<template>
  <div class="hidden lg:block">
    <!-- Participant Card Groups of 2 -->
    <div :class="['lg:flex flex-wrap', hasOnlyOneParticipant ? 'justify-center' : '' ]">
      <div
        v-for="(participant, index) in participantGroup"
        :key="index"
        :class="[
          selected == null && !hasOnlyOneParticipant ? 'right-border' : '',
          selected == null || selected == participant.id ? '' : 'bg-grey-lighter opacity-75 border-b-2 shadow-inner',
          index == 0 && selected == participant.id && participantGroup.length > 1 ? 'border-r-2' : '',
          index == 1 && selected == participant.id && participantGroup.length > 1 ? 'border-l-2' : ''
        ]"
        class="lg:w-1/2"
      >
        <ParticipantCard
          :participant="participant"
          :program="program"
          :selected="selected"
          @toggle="toggleParticipant($event)"
        />
      </div>
    </div>

    <!-- Participant Rewards Groups of 2 -->
    <div
      v-for="participant in participantGroup"
      :key="participant.id"
      class="px-8"
    >
      <ParticipantRewards
        :program="program"
        :participant="participant"
        :show="selected == participant.id"
      />
    </div>
  </div>
</template>

<script>
import ParticipantCard from '@/components/template/ParticipantCard'
import ParticipantRewards from '@/components/template/ParticipantRewards'

export default {
  name: 'ParticipantGroup',
  components: {
    ParticipantCard,
    ParticipantRewards,
  },
  props: {
    program: {
      type: Object,
      default: undefined,
    },
    participantGroup: {
      type: Array,
      default: () => ([]),
    },
    hasOnlyOneParticipant: {
      type: Boolean,
      default: false,
    },
  },
  data () {
    return {
      selected: null,
    }
  },
  methods: {
    toggleParticipant (id) {
      if (this.selected !== id) {
        this.selected = id
      } else {
        this.selected = null
      }
    },
  },
}
</script>

<style lang="scss">
.right-border:first-of-type {
    position: relative;
    z-index: 1;

    &:before {
        content: "";
        position: absolute;
        right: 0;
        top: 50px;
        height: 8rem;
        width: 1px;
        border-right: 1px solid #DADADA;
    }
}
.top-border {
    position: relative;
    z-index: 1;

    &:before {
        content: "";
        position: absolute;
        margin-left: auto;
        margin-right: auto;
        left: 0;
        right: 0;
        height: 1px;
        width: 80%;
        border-top: 1px solid #DADADA;
    }
}
</style>
