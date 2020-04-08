<template>
  <div class="max-w-7xl mx-auto py-12 sm:px-6 lg:px-8">
    <div class="bg-white overflow-hidden shadow sm:rounded-lg">
      <div class="relative px-4 py-5 sm:p-6">
        <video controls>
          <source src="http://cominex.net/assets/video/vuex_modules.mp4" type="video/mp4">
        </video>
        <svg
          class="border-2 border-dashed border-gray-300 rounded bg-white h-64 w-full text-gray-200"
          preserveAspectRatio="none"
          stroke="currentColor"
          fill="none"
          viewBox="0 0 200 200"
        >
          <path vector-effect="non-scaling-stroke" stroke-width="2" d="M0 0l200 200M0 200L200 0" />
        </svg>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import AppHeader from '@/components/AppHeader'
import AvatarGroup from '@/components/AvatarGroup'

export default {
  name: 'DashboardPage',
  components: { AppHeader, AvatarGroup },
  computed: {
    ...mapGetters({
      user: 'auth/user',
      pledges: 'pledge/pledges',
    }),
  },
  mounted () {
    function fetchDogs ({ breed }) {
      fetch(`https://dog.ceo/api/breed/${breed}/images`)
        .then(res => res.json())
        .then(data => {
          // eslint-disable-next-line
          // console.log(data)
        })
        .catch(error => {
          // eslint-disable-next-line
          console.log(error)
        })
    }

    const dog = {
      name: 'Max',
      breed: 'pomeranian',
      color: 'black',
      age: 6,
    }

    fetchDogs(dog)
  },
}
</script>
