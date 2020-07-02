<template>
  <div>
    program
  </div>
</template>

<script>
export default {
  name: 'ProgramPage',
  props: {
    program: {
      type: Object,
      default: () => ({
        id: 1,
        programOwner: '',
        pledgingStartDate: '',
        pledgingEndDate: '',
        pepRallyDate: '',
        programRegistrationCode: '',
        eventDate: '',
        eventName: '',
        serviceLevel: '',
        payableTo: '',
        dueDate: '',
        totalRaisedGoal: '',
        predictedClientPercent: '',
        clientGoal: '',
        teacherPartyDate: '',
        teacherPartyLocation: '',
        preprogramFandR: '',
        parentMembership: '',
        unitType: '',
        unitRangeLow: '',
        unitRangeHigh: '',
        unitRangeMaxCharge: '',
        unitRangeNoUnitsEnteredCharge: '',
        unitRangeEstimatedAverage: '',
        unitRangeFlatConversion: '',
        collectionType: '',
        isArchived: false,
        floridaPrepaid: true,
        goodGrains: true,
        parentEmailPrompts: true,
        restrictAccessToPrizeReports: true,
        showCorporateMatchingWidget: true,
        hideTeacherActionSteps: true,
        hideTeacherIncentives: true,
        disableStudentStarVideo: true,
        requireAddressToRegister: true,
        enableDirectGive: true,
        directGiveUrl: '',
      }),
    },
  },
}
</script>
