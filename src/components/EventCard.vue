<template>
  <router-link class="event-link" :to="{ name: 'events-show', params: { id: event.id } }">
    <div class="event-card -shadow">
      <span class="eyebrow">@{{ event.time }} on {{ event.date }}</span>
      <h4 class="title">
        {{ event.title }}
      </h4>
      <BaseIcon name="users">
        {{ event.attendees.length }} attending
      </BaseIcon>
    </div>
  </router-link>
</template>

<script>
export default {
  name: 'EventCard',
  props: {
    event: {
      type: Object,
      default: () => ({
        time: null,
        date: null,
        title: null,
      }),
    },
  },
}
</script>
