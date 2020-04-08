<?php

namespace App\Entities;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;
use App\Notifications\ResetPassword;
use App\Entities\Participant;
use App\Entities\UsersUserGroup;
use Carbon\Carbon;
use App\Exceptions\Booster\RegistrationAgeException;
use App\Libraries\CacheKeys;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Config;
use DB;
use Illuminate\Support\Facades\DB as FacadesDB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;
    use HasRoles;

    const ADMIN_USERS_GROUP_ID       = 1;
    const SPONSOR_USERS_GROUP_ID     = 4;
    const PARENT_USERS_GROUP_ID      = 5;
    const VOLUNTEER_USERS_GROUP_ID   = 8;
    const ORG_ADMIN_USERS_GROUP_ID   = 50;
    const SUPER_ADMIN_USERS_GROUP_ID = 1000;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'username',
        'created_on',
        'fr_code',
        'password',
        'flagging_mode_id',
        'block_collection_reminder',
        'reg_code_temp_user',
        'email_opt_out',
        'phone',
        'dob',
        'registered',
        'active',
        'waiver_ts',
        'waiver_dob',
        'waiver_signed',
        'marketing_opt_in_ts',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $appends = ['school'];

    public function orgAdminSchools()
    {
        return $this->belongsToMany(School::class, 'organization_administrators', 'user_id', 'school_id');
    }

    public function userActivities()
    {
        return $this->belongsToMany(UserActivity::class, 'user_activity_history', 'user_id', 'activity_id');
    }

    public function userFlaggingMode()
    {
        return $this->belongsTo(UserFlaggingMode::class, 'flagging_mode_id');
    }

    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }

    public function socialLogin()
    {
        return $this->hasOne(SocialLogin::class);
    }

    public function participants()
    {
        return $this->belongsToMany(User::class, 'students_parents', 'parent_id', 'student_id');
    }

    public function participantInfo()
    {
        return $this->hasOne(Participant::class);
    }

    public function classroom()
    {
        return $this->belongsToMany(Classroom::class, 'participants');
    }

    public function specialUrls()
    {
        return $this->hasMany(SpecialUrl::class);
    }

    public function parents()
    {
        return $this->belongsToMany(User::class, 'students_parents', 'student_id', 'parent_id');
    }

    public function groups()
    {
        return $this->hasMany(UsersUserGroup::class);
    }

    /**
     * Retrieves the program of the user if it exists otherwise false
     * @return App\Entities\Program
     */
    public function getProgram()
    {
        if ($this->participantInfo) {
            return $this->participantInfo->program();
        }

        return false;
    }

    public function manualPayments()
    {
        return $this->hasMany(ManualPayment::class, 'entered_by');
    }

    public function prizes()
    {
        return $this->belongsToMany(
            Prize::class,
            'prizes_bound_student',
            'student_id',
            'prize_id'
        )
        ->withPivot(['status']);
    }

    public function userNotes()
    {
        return $this->hasMany(UserNote::class);
    }

    public function emailNotifications()
    {
        return $this->hasMany(EmailNotification::class);
    }

    public function participantPledges()
    {
        return $this->hasMany(Pledge::class, 'participant_user_id');
    }

    public function isMyParticipant()
    {
        return $this->parents->contains(Auth::user());
    }

    public function participantPayments()
    {
        return $this->belongsToMany(Payment::class, 'payments_students', 'student_id', 'payment_id');
    }

    public function participantManualPayments()
    {
        return $this->belongsToMany(
            ManualPayment::class,
            'payments_students',
            'student_id',
            'payment_id',
            'id',
            'payment_id'
        );
    }

    public function participantManualPaymentsTotal()
    {
        return $this->participantManualPayments
            ->reduce(
                function ($total, $manualPayment) {
                    //Clean me while working on story 170134166
                    if ($manualPayment->payment->deleted !== 1) {
                        return $total += $manualPayment->payment->amount;
                    }
                },
                0
            ) ?: 0;
    }

    public function sponsorPledges()
    {
        return $this->hasMany(Pledge::class, 'user_id');
    }

    public function collectionReminderHistories()
    {
        return $this->hasMany(CollectionReminderHistory::class);
    }

    public function prizesBoundStudent()
    {
        return $this->hasMany(PrizesBoundStudent::class, 'student_id');
    }

    public function braintreeCustomers()
    {
        return $this->hasMany(BraintreeCustomer::class);
    }

    public function accessToken()
    {
        return $this->hasOne(AccessToken::class);
    }

    public function userTasks()
    {
        return $this->hasMany(UserTask::class, 'assigned_to_user_id');
    }

    public function podcasts()
    {
        return $this->hasMany(Podcast::class);
    }

    public function subscribedPodcasts()
    {
        return $this->belongsToMany(Podcast::class, 'subscriptions')->withTimestamps();
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function subscribesTo($podcast)
    {
        return $this->subscribedPodcasts()->where($podcast->getQualifiedKeyName(), $podcast->getKey())->count() > 0;
    }

    public function subscriptionTo($podcast)
    {
        return $this->subscriptions()->where('podcast_id', $podcast->id)->first();
    }

    public function hasLapsEntered()
    {
        return is_int($this->laps);
    }

    public function pledgeProcessUrl($shortKey)
    {
        $slug       = $this->specialUrls->where('short_key', '=', $shortKey)->first()->slug;
        return secure_url('/public_dashboard/pledge/' . $slug);
    }

    public function shareLinkReferrer()
    {
        $referrerId = $this->video_url ? Referrer::LINK_VIDEO : Referrer::LINK;
        return SpecialUrl::where('referrer_id', '=', $referrerId)->where('user_id', '=', $this->id)->first();
    }

    public function shareLinkUrl()
    {
        $shortKey = $this->shareLinkReferrer()->short_key;

        if (env('USE_NEW_PUBLIC_PAGE')) {
            return secure_url('/v3/dash/' . $shortKey);
        } else {
            return env('PUBLIC_PLEDGE_URL') . '/dash/' . $shortKey;
        }
    }

    public function shareFacebookUrl($utmLinks = false)
    {
        $referrerId = $this->video_url ? Referrer::FACEBOOK_VIDEO : Referrer::FACEBOOK;
        $specialUrl = $this->specialUrls->where('referrer_id', '=', $referrerId)->first();
        $shortKey   = $specialUrl->short_key;

        $url = secure_url('/v3/dash/' . $shortKey);
        if ($utmLinks) {
            $url .= $specialUrl->UTMLink();
        }
        return $url;
    }

    public function getSpecialUrlByFacebookReferrer()
    {
        $referrerId = Referrer::FACEBOOK;
        $specialUrl = $this->specialUrls->where('referrer_id', '=', $referrerId)->first();
        $shortKey   = $specialUrl->short_key;

        return secure_url('/v3/dash/' . $shortKey);
    }

    public function getSpecialUrlByFacebookVideoReferrer()
    {
        $referrerId = Referrer::FACEBOOK_VIDEO;
        $specialUrl = $this->specialUrls->where('referrer_id', '=', $referrerId)->first();
        $shortKey   = $specialUrl->short_key;

        return secure_url('/v3/dash/' . $shortKey);
    }

    public function getCanonicalUrlByFacebookReferrer()
    {
        return $this->shareFacebookUrl(true);
    }

    public function getShareUrlWithPossibleVideo($referrer, $hasFamilyVideo = false)
    {
        if ($this->video_url || $hasFamilyVideo) {
            $referrer .= '_video';
        }
        return $this->getShareUrlByReferrer($referrer);
    }

    public function getShareUrlByReferrer($referrer)
    {
        $url = SpecialUrl::where('user_id', $this->id)
            ->whereHas('referrer', function ($query) use ($referrer) {
                $query->where('name', $referrer);
            })
            ->first();
        return secure_url('/v3/dash/' . $url->short_key);
    }

    public function getMissingSpecialUrls()
    {
        $userId      = $this->id;
        $specialUrls = SpecialUrl::rightJoin('referrers', function ($join) use ($userId) {
            $join->on('referrers.id', '=', 'special_urls.referrer_id')
                ->where('special_urls.user_id', '=', $userId);
        })
        ->whereNull('special_urls.user_id')
        ->whereNull('special_urls.slug')
        ->whereNull('special_urls.short_key')
        ->get()->toArray();
        return $specialUrls;
    }

    public function createSpecialUrls()
    {
        $missingSpecialUrls = $this->getMissingSpecialUrls();

        foreach ($missingSpecialUrls as $missingSpecialUrl) {
            $slug = $missingSpecialUrl['slug'] ?: sha1($this->id . '~' . $missingSpecialUrl['id'] . '~' . rand());
            // Take 6 bytes of hash, base64-encode to URL-safe 8 character key.
            $short_key = strtr(base64_encode(pack('H*', substr($slug, 0, 12))), '+/', '-_');

            $specialUrls[] = [
                'user_id'     => $this->id,
                'referrer_id' => $missingSpecialUrl['id'],
                'slug'        => $slug,
                'short_key'   => $short_key
            ];
        }
        SpecialUrl::insert($specialUrls);
    }

    public function bindNewParticipantPrizes()
    {
        $classroom     = $this->classroom->first();
        $group         = $classroom->group;
        $prizesToBind  = PrizesBound::where('group_id', '=', $group->id)->get();
        $studentPrizes = [];

        foreach ($prizesToBind as $prizeBound) {
            $studentPrizes[] = [
                'prize_id'   => $prizeBound->prize_id,
                'student_id' => $this->id,
            ];
        }

        PrizesBoundStudent::insert($studentPrizes);

        //register the student for any Registration prizes
        $registrationPrizes = PrizesBound::where('actual_amount', '0.00')
            ->whereNull('quantity')
            ->whereNull('activity_reward')
            ->where('group_id', $group->id)
            ->get();

        if ($registrationPrizes->count() > 0) {
            PrizesBoundStudent::where('student_id', $this->id)
                ->whereIn('prize_id', $registrationPrizes->pluck('prize_id'))
                ->update(['status' => 'giveaway']);
        }
    }

    public function setDobAttribute($value)
    {
        if ($value instanceof Carbon && $value->diff(Carbon::now())->format('%y') < 13) {
            throw new RegistrationAgeException();
        }
        $this->attributes['dob'] = $value;
    }

    public function setEmailAttribute($value)
    {
        $this->attributes['email']    = $value;
        $this->attributes['username'] = $value;
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($this, $token));
    }

    public function getSchoolAttribute()
    {
        $program = $this->getProgram();
        if ($program) {
            $school             = $program->first()->school;
            $school->program_id = $program->first()->id;
            return $school;
        } else {
            return null;
        }
    }

    public function createAccessToken($redirect = null, $minsToExpire = 2)
    {
        $now = Carbon::now();

        $token = AccessToken::updateOrCreate(
            [
                'user_id'      => $this->id
            ],
            [
                'user_id'      => $this->id,
                'access_token' => hash('sha256', base64_encode(random_bytes(16))),
                'redirect'     => $redirect,
                'expires_at'   => FacadesDB::raw('DATE_ADD(NOW(), INTERVAL ' . (int)$minsToExpire . ' MINUTE)'),
            ]
        );

        return $token;
    }

    public function getEmailPreferenceToken()
    {
        return Crypt::encryptString($this->email);
    }

    public function updateEmailPreferences($emailTypeIdsToBlock)
    {
        $userEmailTypes = UserEmailType::all();

        UserEmailOptOut::where('email', $this->email)->delete();

        if ($emailTypeIdsToBlock) {
            foreach ($emailTypeIdsToBlock as $emailTypeIdToBlock) {
                if ($userEmailTypes->contains($emailTypeIdToBlock)) {
                    UserEmailOptOut::firstOrCreate(
                        [
                            'email'              => $this->email,
                            'user_email_type_id' => $emailTypeIdToBlock
                        ]
                    );
                }
            }
        }
    }

    /**
     * Retreives pledges of previous sponsors along with the pledge Sponsor
     *
     * @return Illuminate\
     */
    public function previousPledges()
    {
        if ($this->parents->count() == 0) {
            return $this->participantPledges()->whereIn('pledge_type_id', [Pledge::PAID_STATUS])->get()->toArray();
        }
        $ids = [];
        foreach ($this->parents as $parent) {
            $ids = array_merge($ids, $parent->participants->pluck('id')->toArray());
        }

        $sponsors = Pledge::whereIn('participant_user_id', $ids)
            ->whereIn('pledge_status_id', [Pledge::PAID_STATUS])
            ->with(['pledgeSponsor'])->get()
            ->unique('pledgeSponsor.email');

        return $sponsors;
    }

    public function getAds(AdLocation $location)
    {
        $sponsors = $this->getProgram()->programSponsors()->get();
        if ($sponsors->count() == 0) {
            return collect([]);
        }

        return $location->programSponsorAd()->whereIn('program_sponsor_id', $sponsors->toArray())->get();
    }

    public function makeUserProfileImageUrl($imageName)
    {
        return Storage::disk('s3')->url(Config::get('booster.s3_user_profile_images') . $imageName);
    }

    public function isOrgAdmin()
    {
        return $this->hasRole('Organization Admin');
    }

    public function isSponsor()
    {
        return $this->hasRole('sponsors');
    }

    public function getGroupMembershipAttribute()
    {
        return $this->groups->pluck('group_id')->toArray();
    }

    public function getIsTeacherUserAttribute()
    {
        return $this->isTeacher();
    }

    /**
     * Determine if user is a collections volunteer.
     *
     * @return  Boolean
     */
    public function isVolunteer()
    {
        return $this->hasRole('volunteers');
    }

    /**
     * Checks if user has any active participants.
     *
     * @return  Boolean
     */
    public function hasActiveParticipants()
    {
        if ($this->participants()->exists()) {
            // Check if user only has archived participants
            return $this->participants()->get()
                ->filter(function ($user) {
                    return $user->getProgram()->archived === 1;
                })->count() < $this->participants()->count();
        }
        return false;
    }

    /**
     *
     * Determines if the users has an active pledge
     *
     * @return boolean
     */
    public function hasNoActivePledge()
    {
        return $this
            ->sponsorPledges()
            ->with('program')
            ->get()
            ->filter(function ($pledge) {
                return $pledge->program->archived == 0;
            })
            ->count() == 0;
    }

    /**
     * Gets the user type for the user Parent, Teacher, Sponsor, Org Admin, Admin, etc...
     */
    public function getUserTypes()
    {
        $userType = [];
        if ($this->isSuperAdmin()) {
            array_push($userType, 'Super Admin');
        }
        if ($this->isAdmin()) {
            array_push($userType, 'Admin');
        }
        if ($this->hasActiveParticipants() && ! $this->allParticipantsAreTeachers()) {
            array_push($userType, 'Parent');
        }
        if ($this->isTeacher()) {
            array_push($userType, 'Teacher');
        }
        if ($this->isOrgAdmin()) {
            array_push($userType, 'Org Admin');
        }
        if ($this->isVolunteer()) {
            array_push($userType, 'Volunteer');
        }
        if (! $this->hasNoActivePledge()) {
            array_push($userType, 'Sponsor');
        }
        if (count($userType) === 0) {
            array_push($userType, 'Unknown');
        }
        return $userType;
    }

    /**
     * Checks if the user is a System Admin
     */
    public function isAdmin()
    {
        return $this->hasRole('admin');
    }

    /**
     * Checks if the user is a Super Admin
     */
    public function isSuperAdmin()
    {
        return $this->hasRole('System Administrator');
    }

    /**
     * Check if the user has any participants that are a teacher
     *
     * @return Boolean
     */
    public function isTeacher()
    {
        return $this->getActiveParticipants()->contains(function ($participant) {
            return $participant->participantUserIsTeacher();
        });
    }

    /**
     * Checks if the participant user is a teacher
     *
     * @return Boolean
     */
    public function participantUserIsTeacher()
    {
        return $this->classroom->contains(function ($classroom) {
            $teachers = $classroom->getTeachersUserIds();
            return in_array($this->id, $teachers);
        });
    }

    /**
     * Checks to make sure that all participants for a user are a teacher on a classroom
     *
     * @return Boolean
     */
    public function allParticipantsAreTeachers()
    {
        $participants = $this->getActiveParticipants();

        return $participants->every(function ($participant) {
            return $participant->participantUserIsTeacher();
        });
    }

    /**
     *
     * Gets participants for a user that are in active programs
     *
     * @return \Illuminate\Support\Collection $users
     */
    public function getActiveParticipants()
    {
        return $this->participants()->get()
        ->filter(function ($user) {
            return $user->getProgram()->archived === 0;
        });
    }

    public function hasParticipants()
    {
        return count($this->participants) !== 0;
    }

    /**
     * Scope a query to not include deleted users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNonDeleted($query)
    {
        return $query->where('users.deleted', 0);
    }

    public function teacherParticipant()
    {
        return $this->getActiveParticipants()->first(function ($participant) {
            return $participant->participantUserIsTeacher();
        });
    }

    public function getTeacherParticipantIdAttribute()
    {
        return $this->teacherParticipant()->id;
    }

    public function getClassLastNameAttribute()
    {
        if ($this->isTeacher()) {
            $classroom     = $this->teacherParticipant()->classroom->first();
        } else {
            $classroom     = $this->classroom->first();
        }

        if (!isset($classroom)) {
            return null;
        }

        return $classroom->getTeacherLastName();
    }

    public function getClassPledgeTotalAttribute()
    {
        if ($this->isTeacher()) {
            $classroom     = $this->teacherParticipant()->classroom->first();
        } else {
            $classroom     = $this->classroom->first();
        }

        if (!isset($classroom)) {
            return null;
        }

        return $classroom->getPledgeTotal();
    }

    public function getSchoolsForZendesk()
    {
        $schools = [];
        if ($this->hasActiveParticipants()) {
            foreach ($this->getActiveParticipants() as $participantUser) {
                $school = str_replace(',', '', $participantUser->getProgram()->school->name);

                if (! in_array($school, $schools)) {
                    array_push($schools, $school);
                }
            }
        }

        if ($this->isOrgAdmin()) {
            foreach ($this->orgAdminSchools() as $orgAdminSchool) {
                $school = str_replace(',', '', $orgAdminSchool->name);
                if (! in_array($school, $schools)) {
                    array_push($schools, $school);
                }
            }
        }

        if ($this->isSuperAdmin()) {
            array_push($schools, 'Booster');
        }

        return implode(',', $schools);
    }

    public function getNotificationsAttribute()
    {
        $userId   = $this->id;
        $cacheKey = CacheKeys::getUserNotificationKey($userId);

        $notifications = Cache::remember($cacheKey, 60 * 24, function () use ($userId) {
            return Notification::where('notifiable_id', $userId)->get()->each->setAppends([
                'clean_html_message'
            ]);
        });

        if (is_array($notifications)) {
            $notifications = collect($notifications);
        }

        // Need to filter expired notifications in case they expired while in cache.
        $notifications = Notification::removeExpiredNotifications($notifications);

        return $notifications;
    }
}
