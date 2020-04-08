<template>
  <div class="card-content">
    <div>
      <div class="pb-4">
        <figure class="image is-16by9 mb-4 border">
          <VideoIframe
            v-if="video"
            :video-id="video.external_video_id"
            :source="video.source"
          />
        </figure>
      </div>

      <h4 class="font-bold text-lg text-center md:text-left mb-4">
        {{ lang.asking_for_pledges }}
      </h4>
      <ul class="list-reset text-sm md:text-xl">
        <li class="flex items-center mb-2">
          <RouterLink
            :to="{
              name: 'easy-emailer',
              params: {
                participantUserId: firstParticipantId
              }
            }"
            strict
            class="font-semibold underline"
          >
            <ShareSvgIcon type="email" />
          </RouterLink>
          <p class="ml-4">
            <RouterLink
              :to="{
                name: 'easy-emailer',
                params: {
                  participantUserId: firstParticipantId
                }
              }"
              strict
              class="font-semibold underline"
            >
              {{ lang.email.link }}
            </RouterLink> {{ lang.email.paragraph }}
          </p>
        </li>
        <li class="flex items-center mb-2">
          <button @click="shareFacebook()">
            <ShareSvgIcon type="facebook" />
          </button>
          <p class="ml-4">
            <a
              class="font-semibold underline"
              @click.prevent="shareFacebook()"
            >
              {{ lang.share_on_facebook }}
            </a> {{ lang.get_sponsor_pledges }}
          </p>
        </li>
        <li
          v-if="!program.ssv_disabled"
          class="flex items-center mb-2"
        >
          <a href="#">
            <ShareSvgIcon type="ssv" />
          </a>
          <p class="ml-4">
            <a
              href="#"
              class="font-semibold underline"
              @click.prevent="scrollTo()"
            >
              {{ lang.share_ssv }}
            </a> {{ lang.customize_it }}
          </p>
        </li>
        <li class="flex items-center mb-2">
          <a
            href="#"
            class="phone-script-icon"
            @click.prevent="openPhoneScript"
          >
            <ShareSvgIcon type="script" />
          </a>
          <p class="ml-4">
            <a
              href="#"
              class="font-semibold underline phone-script-link"
              @click.prevent="openPhoneScript"
            >
              {{ lang.use_our_phone_script }}
            </a> {{ lang.call_friends }}
          </p>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
import PhoneScriptModal from '@/components/element/PhoneScriptModal'
import ShareSvgIcon from '@/components/element/ShareSvgIcon'
import VideoIframe from '@/components/element/VideoIframe'
import Blur from '@/mixins/Blur'
import axios from 'axios'

export default {
  name: 'HowToGetPledges',
  status: 'prototype',
  release: '1.0.0',
  components: {
    ShareSvgIcon,
    VideoIframe,
  },
  mixins: [Blur],
  props: {
    program: {
      type: Object,
      default: null,
    },
  },
  data () {
    return {
      video: null,
    }
  },
  computed: {
    lang () {
      return this.$store.state.lang.how_to_get_pledges
    },
    firstParticipantId () {
      return this.program.participants[0].id
    },
    hasVideo () {
      return this.program.participants.reduce((result, participant) => {
        const hasImage = !!participant.profile.image_name
        return result || hasImage
      }, false)
    },
    specialUrls () {
      return this.program.participants[0].special_urls
    },
  },
  created () {
    this.fetchVideos()
  },
  methods: {
    isDesktop () {
      return window.matchMedia('(min-width: 769px)').matches
    },
    scrollTo () {
      this.$parent.$parent.$parent.items[2].isOpen = true

      setTimeout(() => {
        // scroll to top
        $('html, body').animate({
          scrollTop: $(this.$parent.$parent.$parent.$el).offset().top,
        }, 300)
      }, 310)
    },

    fetchVideos (videoMetadata) {
      axios.get('/v3/api/videos/get-pledges/' + this.program.id).then(response => {
        this.video = response.data
      }).catch(error => {
        console.error(error)
      })
    },
    openPhoneScript (evt) {
      this.$buefy.modal.open({
        parent: this,
        component: PhoneScriptModal,
        hasModalCard: false,
        canCancel: ['close', 'outside'],
        onCancel: this.unBlur,
        props: { program: this.program },
      })

      this.blur()

      this.gaEvent('Parent Dashboard', 'How To Get Pledges', 'Phone Script')
    },
    getShareUrl (referrerName) {
      const filterFunction = function (specialUrl) {
        return specialUrl.referrer.name === referrerName
      }
      const shortKey = this.specialUrls.filter(filterFunction)[0].short_key
      return window.location.protocol + '//' + window.location.hostname + '/v3/dash/' + shortKey
    },
    shareFacebook () {
      const referrerName = this.hasVideo ? 'Facebook_Video' : 'Facebook'
      const url = this.getShareUrl(referrerName)
      const participantUserId = this.program.participants[0].id
      FB.ui(
        {
          method: 'share',
          href: url,
        },
        function (response) {
          if (response && !response.error_message) {
            axios.get('/users/user_successful_facebook_share/' + participantUserId)
              .catch(console.log)
            var label = this.hasVideo ? 'Pledge Success Page Video' : 'Pledge Success Page'
            ga('send', 'event', 'Share Public Pledge Page', 'Click Facebook Share', label, 1)
          }
        },
      )
    },
  },
}
</script>
