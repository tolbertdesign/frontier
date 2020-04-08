<template>
  <div class="m-4 rounded-xl overflow-hidden">
    <div
      :class="cardClasses"
      class="card"
    >
      <header
        v-if="duration === 0"
        class="card-header bg-blue text-white border-b-0 pt-4 pr-4 -mb-16 shadow-none"
      >
        <p class="flex justify-between items-center text-center modal-card-title text-white">
          <span style="width: 24px; height: 48px;" />
          <a
            href="#"
            class="text-white self-start hover:text-white"
            style="width: 24px; height: 48px;"
            @click.prevent="close"
          >
            <span class="icon">
              <FontAwesomeIcon
                :icon="['fas', 'times']"
                size="xs"
              />
            </span>
          </a>
        </p>
      </header>
      <div
        class="card-content py-16 sm:px-32 text-white text-center"
      >
        <FontAwesomeIcon
          :icon="['fas', 'check']"
          size="3x"
        />
        <p
          v-if="title"
          class="font-bold text-xl capitalize"
          v-text="title"
        />
        <p
          v-if="subtitle"
          class="max-w-2xs sm:max-w-xs md:-mx-4 text-base mx-auto"
          v-text="subtitle"
        />
      </div>
    </div>
  </div>
</template>

<script>
import Blur from '@/mixins/Blur'

export default {
  name: 'SaveSuccessModal',
  mixins: [Blur],
  props: {
    type: {
      type: String,
      default: 'success',
    },
    duration: {
      type: Number,
      default: 1000,
    },
    title: {
      type: String,
      default: null,
    },
    subtitle: {
      type: String,
      default: null,
    },
    reload: {
      type: Boolean,
      default: false,
    },
  },
  computed: {
    cardClasses () {
      return {
        'bg-blue': this.type === 'success',
        'bg-red': this.type === 'error',
      }
    },
  },
  mounted () {
    this.blur()
    if (this.duration > 0) {
      setTimeout(() => {
        this.close()
      }, this.duration)
    }
  },
  methods: {
    close () {
      if (this.reload) {
        // Refresh the page so the updates will take effect throughout the frontend
        location.reload()
      }
      this.$emit('close')
      this.unBlur()
    },
  },
}
</script>
