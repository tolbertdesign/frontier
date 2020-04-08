<template>
  <AccordionModal
    :header="lang.alerts"
    class="m-2"
  >
    <template
      v-if="notifications.length > 0"
    >
      <Accordion
        v-for="notification in notifications"
        :key="notification.id"
        :title="getTitle(notification)"
        :is-open="notifications.length === 1"
        :should-emit-viewed="true"
        :title-font-weight="fontWeight(notification)"
        animation="zoom-out"
        @viewed="updateNotification(notification)"
      >
        <template>
          <div class="p-2">
            <div class="modal-card-body bg-white p-4 md:p-6 text-sm sm:text-base md:text-lg">
              <p
                class="mb-4"
                v-html="content(notification)"
              />
            </div>
          </div>
        </template>
      </Accordion>
    </template>
    <div
      v-else
      class="py-2 text-center"
    >
      {{ lang.no_alerts }}
    </div>
  </AccordionModal>
</template>

<script>
import AccordionModal from '@/components/template/AccordionModal'
import Accordion from '@/components/element/Accordion'
import Blur from '@/mixins/Blur'

export default {
  name: 'NotificationAccordionModal',
  components: {
    AccordionModal,
    Accordion,
  },
  mixins: [Blur],
  props: {
    program: {
      type: Object,
      default: () => {},
    },
  },
  computed: {
    lang () {
      return this.$store.state.lang
    },
    notifications () {
      return this.$store.getters.sortNotificationsByProgramId(this.program.id)
    },
  },
  created () {
    if (this.$store.state.notification.notifications.length === 1) {
      this.updateNotification(this.$store.state.notification.notifications[0])
    }
  },
  methods: {
    closeModal () {
      this.$emit('close')
      this.unBlur()
    },
    updateNotification (notification) {
      if (!this.$store.getters.isRead(notification)) {
        this.$store.dispatch('readNotification', notification)
      }
    },
    fontWeight (notification) {
      if (notification.read_at) {
        return 'font-normal'
      }

      return 'font-semibold'
    },
    content (notification) {
      return notification.clean_html_message || ''
    },
    getTitle (notification) {
      const program = this.$store.state.User.programs.find(program => program.id === notification.program_id)
      return program.event_name
    },
  },
}
</script>
