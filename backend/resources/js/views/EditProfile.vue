<template>
  <section class="page min-h-screen default_theme">
    <AppHeader>
      <PageHeader>{{ lang.edit_profile.page_header }}</PageHeader>
    </AppHeader>
    <div class="mx-4 md:mx-0 pb-4 pt-24 lg:pt-40">
      <div class="max-w-md md:mx-auto">
        <EditProfileForm :user="user" />
      </div>
    </div>
  </section>
</template>

<script>
import AppHeader from '@/components/template/AppHeader'
import PageHeader from '@/components/pattern/PageHeader'
import EditProfileForm from '@/components/template/EditProfileForm'

export default {
  name: 'EditProfilePage',
  status: 'prototype',
  release: '1.0.0',
  components: {
    AppHeader,
    PageHeader,
    EditProfileForm,
  },
  computed: {
    lang () {
      return this.$store.state.lang
    },
    user () {
      return this.$store.state.User
    },
  },
  metaInfo: {
    title: 'Edit Profile',
  },
}
</script>
