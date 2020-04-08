<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class ProgramPledgeSetting extends Model
{
    public $timestamps = false;

    const DEFAULT_PPL_PLEDGE_GOAL  = 10;
    const DEFAULT_FLAT_PLEDGE_GOAL = 300;
    protected $fillable            = ['flat_donate_only'];

    public static $metaDefaultAttributesToFields = [
        'flag_high_donation'                => 'flag_high_donation',
        'flag_high_quantity_per_day'        => 'flag_high_quantity_per_period',
        'flag_high_cumulative_per_day'      => 'flag_high_cumulative_per_period',
        'flat_donate_only'                  => 'flat_donate_only',
        'flag_payment_scheduled_high_value' => 'flag_payment_scheduled_high_value',
        'weekend_challenge_amount'          => 'weekend_challenge_amount',
        'family_pledging_enabled'           => 'family_pledging_enabled',
    ];

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function getFlagHighDonationAttribute($value)
    {
        return $value ?: Meta::where('name', '=', 'flag_high_donation')->first()->value;
    }

    public function getFlagHighQuantityPerPeriodAttribute($value)
    {
        return $value ?: Meta::where('name', '=', 'flag_high_quantity_per_day')->first()->value;
    }

    public function getFlagHighCumulativePerPeriodAttribute($value)
    {
        return $value ?: Meta::where('name', '=', 'flag_high_cumulative_per_day')->first()->value;
    }

    public function getFlatDonateOnlyAttribute($value)
    {
        return $value ?: Meta::where('name', '=', 'flat_donate_only')->first()->value;
    }

    public function getFlagPaymentScheduledHighValueAttribute($value)
    {
        return $value ?: Meta::where('name', '=', 'flag_payment_scheduled_high_value')->first()->value;
    }

    public function getWeekendChallengeAmountAttribute($value)
    {
        return $value ?: Meta::where('name', '=', 'weekend_challenge_amount')->first()->value;
    }

    public function getFamilyPledgingEnabledAttribute($value)
    {
        return $this->id ? $value : Meta::where('name', '=', 'family_pledging_enabled')->first()->value;
    }

    public function getRecommendedPledgeAmountsAttribute($value)
    {
        return $value ?: $this->getDefaultRecommendedPledgeAmounts();
    }

    private function getDefaultRecommendedPledgeAmounts()
    {
        return serialize([
            'perlap_a'       => [1, 2, 3, 5, 10],
            'perlap_b'       => [1, 2, 3, 5, 10],
            'flat_a'         => [30, 60, 90, 150, 300],
            'flat_b'         => [30, 60, 90, 150, 300],
            'ppl_default_a'  => '1',
            'flat_default_a' => '30',
            'ppl_default_b'  => '1',
            'flat_default_b' => '30',
        ]);
    }

    public function getDefaultPledgeGoal()
    {
        $flatDonations = $this->flat_donate_only;
        return ($flatDonations) ? self::DEFAULT_FLAT_PLEDGE_GOAL : self::DEFAULT_PPL_PLEDGE_GOAL;
    }

    /**
     * Retrieves all default values for creating a record of this table
     * @return array
     */
    public static function getAllDefaultValues()
    {
        $defaultValues = [];

        $metaRecords = Meta::whereIn('name', array_keys(self::$metaDefaultAttributesToFields))->get();

        foreach ($metaRecords as $record) {
            if (array_key_exists($record->name, self::$metaDefaultAttributesToFields)) {
                $defaultValues[self::$metaDefaultAttributesToFields[$record->name]] = $record->value;
            }
        }

        $defaultValues['ppu_donations_only']            = 0;
        $defaultValues['minimize_flat_donation']        = 0;

        $self = new self();
        $defaultValues['recommended_pledge_amounts']    = $self->getDefaultRecommendedPledgeAmounts();

        return $defaultValues;
    }
}
