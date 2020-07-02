<template>
  <div>
    Users

    <form action="">
      <h2>Quick Create New User</h2>
      <input type="text" placeholder="First Name" />
      <input type="text" placeholder="Last Name" />
      <input type="text" placeholder="Email" />
      <button>Submit</button>
    </form>
  </div>
</template>

<script>
export default {
  props: {
    users: {
      type: Array,
      default: () => [
        {
          id: 1,
          firstName: 'Victor',
          lastName: 'Tolbert',
          email: 'victor.tolbert@hey.com',
          dob: '',
          streetAddress: '',
          city: '',
          state: '',
          zip: '',
          country: '',
          phone: '',
          userFlaggingMode: '',
          blockCollectionReminder: false,
          signedPaperWaiver: false,
          active: true,
        },
      ],
    },
  },
}
</script>
