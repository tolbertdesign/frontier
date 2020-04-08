<template>
  <div class="share-button flex flex-col">
    <a
      v-if="type === 'sms'"
      :class="['is-rounded text-white shadow hover:text-white flex items-center justify-center w-12 h-12 rounded-full mx-auto cursor-pointer lg:hidden', config.className]"
      :data-tooltip="config.tooltipText"
      :title="config.tooltipText"
      :href="smsLink"
      @click="gaTrack"
    >
      <FontAwesomeIcon
        :icon="config.icon"
        class="text-2xl"
      />
    </a>
    <button
      v-if="type !== 'sms'"
      :class="['lg:hidden flex items-center justify-center w-12 h-12 mx-auto text-white hover:text-white rounded-full shadow cursor-pointer', config.className]"
      :data-tooltip="config.tooltipText"
      :title="config.tooltipText"
      @click="clicked"
    >
      <FontAwesomeIcon
        :icon="config.icon"
        class="text-2xl"
      />
      <span
        class="hidden lg:inline"
        v-html="config.label"
      />
    </button>
    <span
      class="text-sm lg:hidden"
      v-html="config.label"
    />
    <button
      :data-tooltip="config.tooltipText"
      :title="config.tooltipText"
      :class="['hidden lg:flex justify-center px-2 py-2 font-semibold text-xl text-white hover:text-white rounded-full shadow cursor-pointer focus:outline-none focus:shadow-outline', config.className]"
      @click="clicked"
    >
      <FontAwesomeIcon
        :icon="config.icon"
        class="text-2xl mr-2"
      />
      <span v-html="config.label" />
    </button>

  </div>
</template>

<script>
import ClipboardJS from 'clipboard'
require('bootstrap')
export default {
  name: 'ShareButton',
  status: 'prototype',
  release: '1.0.0',
  props: {
    type: {
      type: String,
      default: 'facebook',
    },
    participants: {
      type: Array,
      default: () => [],
    },
    specialUrls: {
      type: Array,
      default: () => [],
    },
    hasVideo: {
      type: Boolean,
      default: false,
    },
    program: {
      type: Object,
      default: undefined,
    },
    ga_page_location: {
      type: String,
      default: 'Student Card Header Section',
    },
    ga_site_location: {
      type: String,
      default: 'Parent Dashboard',
    },
  },
  computed: {
    config () {
      switch (this.type) {
      case 'email':
        return {
          icon: 'envelope',
          label: this.lang.easy_emailer_button,
          className: 'has-background-email',
        }
      case 'sms':
        return {
          icon: 'comment',
          label: this.lang.sms_button,
          className: 'has-background-text-message',
        }
      case 'link':
        return {
          icon: 'link',
          label: this.lang.copy_and_share_button,
          className: 'has-background-copy-link copy-text',
          tooltipText: 'Copied!',
        }
      case 'facebook':
      default:
        return {
          icon: ['fab', 'facebook-f'],
          label: this.lang.facebook_button,
          className: 'has-background-facebook',
        }
      }
    },
    lang () {
      return this.$store.state.lang
    },
    smsLink () {
      const referrerName = this.hasVideo ? 'SMS_Video' : 'SMS'
      const isAre = this.participants.length === 1 ? 'is' : 'are'
      const eventName = this.program.event_name
      const langString = this.hasVideo ? this.lang.sms.has_video : this.lang.sms.no_video
      const smsBody = this.parseLanguage(
        langString,
        {
          participant_display_names: this.participantDisplayNames(this.participants),
          is_are: isAre,
          event_name: eventName,
          share_url: this.getShareUrl(referrerName),
        },
      )
      return 'sms:?&body=' + smsBody.replace(/&/g, 'and')
    },
  },
  methods: {
    clicked (event) {
      this.gaTrack()

      const participantUserId = this.getSmallestParticipantId()
      switch (this.type) {
      case 'email':
        this.$router.push({
          name: 'easy-emailer',
          params: {
            participantUserId: participantUserId,
          },
        })
        break
      case 'sms':
        break
      case 'link':
        this.shareLink()
        break
      case 'facebook':
      default:
        this.shareFacebook()
      }
    },
    getSmallestParticipantId () {
      const participantIds = this.participants.map(obj => obj.id)
      return Math.min(...participantIds)
    },
    gaTrack () {
      const action = 'Share Button: ' + this.type + (this.hasVideo ? ' video' : '')
      this.gaEvent(this.ga_site_location, this.ga_page_location, action)
    },
    getShareUrl (referrerName) {
      const filterFunction = function (specialUrl) {
        return specialUrl.referrer.name === referrerName
      }
      const shortKey = this.specialUrls.filter(filterFunction)[0].short_key
      return window.location.protocol + '//' + window.location.hostname + '/v3/dash/' + shortKey
    },
    shareLink () {
      const referrerName = this.hasVideo ? 'Link_Video' : 'Link'
      var clipboardjs = new ClipboardJS('.copy-text', {
        text: (trigger) => {
          return this.getShareUrl(referrerName)
        },
      })
      clipboardjs.on('success', function (e) {
        $('.copy-text').tooltip({ trigger: 'manual' })
        $(e.trigger).tooltip('show')
        setTimeout(function () {
          $(e.trigger).tooltip('hide')
        }, 1000)
      })
    },
    shareFacebook () {
      const referrerName = this.hasVideo ? 'Facebook_Video' : 'Facebook'
      const url = this.getShareUrl(referrerName)
      FB.ui(
        {
          method: 'share',
          href: url,
        },
        function (response) {
          if (response && !response.error_message) {
            var label = this.hasVideo ? 'Pledge Success Page Video' : 'Pledge Success Page'
            ga('send', 'event', 'Share Public Pledge Page', 'Click Facebook Share', label, 1)
          }
        },
      )
    },
  },
}
</script>
