<template>
  <div class="mx-auto mt-16">
    <!-- Welcome to Frontier Log in with one of the following: Github Email -->

    <ul>
      <li>admin_ads</li>
      <li>admin_stats</li>
      <li>admin/classes/126106</li>
      <li>admin/classes/add_participant/0/1</li>
      <li>admin/user_groups</li>
      <li>admin/online-transaction-fix</li>
      <li>admin/pledges/edit/360</li>
      <li>admin/pledges/new/5</li>
      <li>admin/pledges/report/all-programs-all-pledges-csv</li>
      <li>admin/pledges/send-email/5</li>
      <li>admin/prizelist/edit/1</li>
      <li>admin/prizelist/edit/prize/47</li>
      <li>admin/prizelist/new</li>
      <li>admin/prizelist</li>
      <li>admin/prizes/1</li>
      <li>admin/prizes/edit/1</li>
      <li>admin/prizes</li>
      <li>admin/program/add_missing_units/1</li>
      <li>admin/programs/add_class/1</li>
      <li>admin/programs/classes/1</li>
      <li>admin/programs/communication/collection-reminder/1</li>
      <li>admin/programs/communication/parent-collection-letter/1</li>
      <li>admin/programs/communication/sponsor-follow-up/1</li>
      <li>admin/programs/communication/unpaid-sponsor-follow-up/1/1</li>
      <li>admin/programs/communication/unpaid-sponsor-follow-up/1</li>
      <li>admin/programs/dashboard/1</li>
      <li>admin/programs/dashboard/1</li>
      <li>admin/programs/edit/1#content</li>
      <li>admin/programs/edit/1#groups</li>
      <li>admin/programs/edit/1#merchant</li>
      <li>admin/programs/edit/1#pledge-periods</li>
      <li>admin/programs/edit/1#pledge-settings</li>
      <li>admin/programs/edit/1#prizes</li>
      <li>admin/programs/edit/1</li>
      <li>admin/programs/help_requests/1</li>
      <li>admin/programs/parents/1</li>
      <li>admin/programs/payments/1</li>
      <li>admin/programs/pledges/1</li>
      <li>admin/programs/pledges/1</li>
      <li>admin/programs/prizes/1</li>
      <li>admin/programs/report/merchant-deposit-summary-csv</li>
      <li>admin/programs/report/programs-summary-csv</li>
      <li>admin/programs/reports/1</li>
      <li>admin/programs/sponsors/1</li>
      <li>admin/programs/students/1</li>
      <li>admin/programs/teachers/1</li>
      <li>admin/programs/todos/1</li>
      <li>admin/programs/upload_classes/1</li>
      <li>admin/schools/edit/1#merchant</li>
      <li>admin/schools/edit/1#org-admin</li>
      <li>admin/schools/edit/1#programs</li>
      <li>admin/schools/edit/1#programs</li>
      <li>admin/schools/edit/1#school</li>
      <li>admin/schools/edit/1</li>
      <li>admin/student_star</li>
      <li>admin/system_alert</li>
      <li>admin/user_tasks/lists</li>
      <li>admin/user_tasks/templates</li>
      <li>admin/users/edit/4</li>
      <li>admin/users/edit/5</li>
      <li>admin/users/edit</li>
      <li>admin/users/notes/5</li>
      <li>admin/users/profile/5</li>
      <li>Test Payment Emails (button)</li>
    </ul>

    <input v-model="q" type="search" @input="$fetch" />

    <!-- <pre>{{ programs }}</pre> -->
  </div>
</template>

<script>
export default {
  name: 'IndexPage',
  async fetch() {
    // $content('articles', params.slug)
    // /_content/articles/hello-world
    // http://localhost:3000/_content/articles?only=title&only=description&limit=10
    this.programs = await this.$content('programs')
      .only(['name', 'event_name', 'client_goal', 'microsite'])
      .sortBy('name')
      // .where({name: 'Test Program'})
      .fetch()
  },
  data() {
    return {
      programs: [],
      q: '',
    }
  },
}
</script>
