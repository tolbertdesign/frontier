<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserFlaggingModeSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(MicrositeColorThemeSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(PrizeSeeder::class);
        $this->call(SchoolSeeder::class);
        $this->call(ProgramSeeder::class);
        $this->call(GroupSeeder::class);
        $this->call(ClassroomSeeder::class);
        $this->call(GradeSeeder::class);
        $this->call(PledgePeriodSeeder::class);
        $this->call(MicrositeSeeder::class);
        $this->call(MicrositeVideoSeeder::class);
        $this->call(MicrositePicSeeder::class);
        $this->call(UserActivitySeeder::class);
        $this->call(UserEmailTypeSeeder::class);
        $this->call(ProgramPledgeSettingSeeder::class);
        $this->call(UserEmailOptOutSeeder::class);
        $this->call(UserActivityHistorySeeder::class);
        $this->call(UserNewFrCodeSeeder::class);
        $this->call(UserTaskTemplateSeeder::class);
        $this->call(UserTaskListSeeder::class);
        $this->call(UserTaskListTaskSeeder::class);
        $this->call(BraintreeMerchantSeeder::class);
        $this->call(UserTaskSeeder::class);
        $this->call(ProgramSponsorSeeder::class);
        $this->call(ProgramSponsorAdSeeder::class);
        $this->call(AdLocationSeeder::class);
        $this->call(FieldAliasSeeder::class);
        $this->call(PledgeStatusSeeder::class);
        $this->call(PledgeSubstatusSeeder::class);
        $this->call(GradeAliasSeeder::class);
        $this->call(GroupLevelSeeder::class);
        $this->call(PledgeTypeSeeder::class);
        $this->call(OrganizationAdministratorSeeder::class);
        $this->call(SponsorTypeSeeder::class);
        $this->call(ReferrerSeeder::class);
        $this->call(MetaSeeder::class);
        $this->call(UsaZipSeeder::class);
        $this->call(EnteredLocationSeeder::class);
        $this->call(EnteredLocationGivingMarketSeeder::class);
        $this->call(PledgeSeeder::class);
        $this->call(PledgeStaticSeeder::class);
        $this->call(UserNoteSeeder::class);
        $this->call(PotentialSponsorSeeder::class);
        // $this->call(PaymentSeeder::class); //create these in the manual and online seeders
        $this->call(ManualPaymentSeeder::class);
        $this->call(OnlinePaymentSeeder::class);
        $this->call(BraintreeCustomerSeeder::class);
        $this->call(PledgeReferrerSeeder::class);
        $this->call(PledgeEnteredLocationSeeder::class);
        $this->call(OnlinePendingPaymentStatusSeeder::class);
        $this->call(OnlinePendingPaymentSeeder::class);
        $this->call(CcTransactionSeeder::class);
        $this->call(ProgramTodoSeeder::class);
        $this->call(SpecialUrlSeeder::class);
        $this->call(PrizesBoundSeeder::class);
        $this->call(PrizesListSeeder::class);
        $this->call(PrizesBoundTemplateSeeder::class);
        $this->call(PrizesBoundStudentSeeder::class);
        $this->call(UnitSeeder::class);
        $this->call(PledgeOMeterSeeder::class);
        $this->call(NotificationsTableSeeder::class);
        $this->call(TeacherSeeder::class);
        $this->call(ArticleSeeder::class);
        $this->call(PodcastSeeder::class);
        $this->call(BoosterTeamSeeder::class);
    }
}
