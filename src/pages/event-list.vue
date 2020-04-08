<template>
  <div>
    <h1>Events for {{ user.user.name }}</h1>
    <EventCard
      v-for="event in event.events"
      :key="event.id"
      :event="event"
    />
    <template v-if="page !== 1">
      <RouterLink
        :to="{ name: 'event-list', query: { page: page - 1 } }"
        rel="prev"
      >
        Prev Page
      </RouterLink>
      <template v-if="hasNextPage">
        |
      </template>
    </template>
    <RouterLink
      v-if="hasNextPage"
      :to="{ name: 'event-list', query: { page: page + 1 } }"
      rel="next"
    >
      Next Page
    </RouterLink>
  </div>
</template>

<script>
import { mapState } from 'vuex'
import store from '@/vuex/store'
import EventCard from '@/components/EventCard'

function getPageEvents (routeTo, next) {
  const currentPage = parseInt(routeTo.query.page) || 1
  store
    .dispatch('event/fetchEvents', {
      page: currentPage,
    })
    .then(() => {
      routeTo.params.page = currentPage
      next()
    })
}

export default {
  components: { EventCard },
  props: {
    page: {
      type: Number,
      required: true,
    },
  },
  beforeRouteEnter (routeTo, routeFrom, next) {
    getPageEvents(routeTo, next)
  },
  beforeRouteUpdate (routeTo, routeFrom, next) {
    getPageEvents(routeTo, next)
  },
  computed: {
    hasNextPage () {
      return this.event.eventsTotal > this.page * this.event.perPage
    },
    ...mapState(['event', 'user']),
  },
}
</script>
