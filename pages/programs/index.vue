<template>
  <div>
    <header>
      <div>
        <h1 class="text-3xl font-bold leading-tight text-gray-900">
          Programs
        </h1>
      </div>
    </header>

    <main>
      <div class="">
        <div class="">
          <div class="border-4 border-gray-200 border-dashed rounded-lg h-96" />
        </div>
      </div>
    </main>
  </div>
</template>

<script>
export default {
  props: {
    programs: {
      type: Array,
      default: () => [
        {
          id: 1,
          todo: '',
          eventName: '',
          semester: '',
          team: '',
          programOwner: '',
          pepRallyDate: '',
          eventDate: '',
          eventType: 'Fun Run',
        },
      ],
    },
  },
}
</script>

<style lang="scss" scoped></style>
