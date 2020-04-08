<template>
  <div>
    <div class="mb-1 py-8 rounded-lg ">
      <UsaMap
        :active-states="selectedPledgedPlaces.states"
        class="text-grey-light"
      />
    </div>

    <div class="flex flex-col items-center">
      <span class="text-2xl">
        <span class="font-light">States:</span>
        <span class="font-bold">{{ statesCount }}</span>
      </span>
      <div class="relative">
        <select
          v-model="selectedPledgedPlaces"
          class="block appearance-none w-full py-1 px-4 pr-8 border border-primary bg-white rounded-md leading-tight focus:outline-none focus:bg-white focus:border-green-500"
          @change="trackSelect"
        >
          <option
            :value="myPledgedPlaces"
            data-label="My States"
          >
            My States
          </option>
          <option
            v-for="(classroom, index) in classrooms"
            :key="index"
            :value="classroom.pledgedPlaces"
            data-label="Specific Classroom"
          >
            {{ statesByClassroomLabel(classroom) }}
          </option>
          <option
            :value="program.pledgedPlaces"
            data-label="School States"
          >
            School States
          </option>
        </select>
        <div
          class="pointer-events-none absolute flex items-center px-2 pt-2"
          style="right: 0; top: 0"
        >
          <svg
            class="fill-current h-4 w-4"
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 20 20"
          ><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" /></svg>
        </div>
      </div>

      <p class="text-sm">
        Countries: <b>{{ [...selectedPledgedPlaces.countries].filter(c=>!!c).sort().join(', ') }}</b>
      </p>
    </div>
  </div>
</template>

<script>
import UsaMap from '@/components/element/UsaMap'
import { uniq, uniqBy, flatMap } from 'lodash'
import FamilyPledging from '@/utilities/FamilyPledging'

export default {
  components: {
    UsaMap,
  },
  props: {
    program: {
      type: Object,
      default: null,
    },
  },
  data: () => ({
    selectedPledgedPlaces: {
      states: [],
      countries: [],
    },
  }),
  computed: {
    classrooms () {
      return uniqBy(flatMap(this.program.participants, participant => {
        const classroom = participant.participant_info.classroom
        return classroom
      }), 'id').sort((a, b) => a.name > b.name ? 1 : -1)
    },
    familyPledgingObj () {
      return new FamilyPledging([this.program]
        , this.program.participants[0].id)
    },
    participant () {
      const familyPledgingObj = this.familyPledgingObj

      if (familyPledgingObj.isFamilyPledgingEnabled() && familyPledgingObj.getSmallestIdParticipantInCurrentParticipantProgram()) {
        return familyPledgingObj.getSmallestIdParticipantInCurrentParticipantProgram()
      } else if (familyPledgingObj.getCurrentParticipant()) {
        return familyPledgingObj.getCurrentParticipant()
      } else {
        return null
      }
    },
    myPledgedStates () {
      const includedStatuses = [2, 3, 8]

      return uniq(
        this.participant.participant_info.pledges
          .filter(pledge => includedStatuses.includes(pledge.pledge_status_id))
          .filter(pledge => pledge.deleted === 0)
          .map(pledge => {
            if (pledge.pledge_sponsor) {
              return pledge.pledge_sponsor.state
            }
          }),
      )
    },
    myPledgedCountries () {
      const includedStatuses = [2, 3, 8]

      return uniq(
        this.participant.participant_info.pledges
          .filter(pledge => includedStatuses.includes(pledge.pledge_status_id))
          .filter(pledge => pledge.deleted === 0)
          .filter(country => !!country)
          .flatMap(pledges => {
            if (pledges.pledge_sponsor.country_entity) {
              return pledges.pledge_sponsor.country_entity.name
            }
            return ''
          }),
      )
    },
    myPledgedPlaces () {
      return {
        states: this.myPledgedStates,
        countries: this.myPledgedCountries,
      }
    },
    statesCount () {
      const removedStates = ['DC', '']
      return this.selectedPledgedPlaces.states
        .filter((state) => state != null)
        .filter(state => !removedStates.includes(state))
        .length
    },
  },
  mounted () {
    this.selectedPledgedPlaces = this.program.pledgedPlaces
  },
  methods: {
    statesByClassroomLabel (classroom) {
      return classroom.name + (classroom.grade.name === 'Other' ? '' : ' - ' + classroom.grade.name)
    },
    trackSelect (event) {
      const label = event.target.selectedOptions[0].getAttribute('data-label')
      this.gaEvent('pledges by state map', label, 'click')
    },
  },

}
</script>
