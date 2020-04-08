<template>
  <div
    style="max-width: 452px"
    class="upload-photo-form bg-white p-4 mx-auto shadow-md rounded-xl relative mb-2"
  >
    <header class="card-header px-4 shadow-none">
      <p class="flex justify-between items-center text-center modal-card-title text-white">
        <span style="width: 24px; height: 48px;" />
        <a
          class="text-black self-start cursor-pointer relative"
          style="width: 24px; height: 48px;"
          @click="$emit('close')"
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
    <div class="modal-body text-center">
      <h2 class="text-3xl font-normal">
        {{ lang.upload_photo }}
      </h2>
      <p
        v-if="ssvDisabled"
        class="mb-4 mx-auto text-sm pb-6 w-2/3 font-light"
      >{{ lang.upload_photo_desc_disabled_ssv }}</p>
      <p
        v-else
        class="mb-4 mx-auto text-sm pb-6 w-2/3 font-light"
      >{{ lang.upload_photo_desc }}</p>
      <div>
        <croppa
          v-model="myCroppa"
          :zoom-speed="15"
          :width="150"
          :height="150"
          :show-remove-button="false"
          :placeholder="''"
          :initial-image="initialImage"
          class="croppa-image mx-auto my-2 cursor-pointer relative"
          @new-image-drawn="newImageDrawn"
          @new-image="newImage"
          @draw="drawCount++"
        />
      </div>
      <button
        class="button is-secondary rounded-full shadow px-6 mb-2"
        @click.prevent="myCroppa.chooseFile()"
      >
        <input
          name="profile_image"
          hidden
        >
        {{ lang.upload_photo }}
      </button>
      <div>
        <a
          :class="{'invisible' : !shouldShowDelete}"
          class="is-danger mb-2 relative"
          @click.prevent="deleteImage()"
        >{{ lang.delete_photo }}
        </a>
      </div>

      <div class="buttons mx-auto w-150px inline-flex justify-start content-center mt-2">
        <button
          style="width: 25px; height: 25px"
          class="button is-default image-control"
          @click="_rotateCounterClockWise"
        >
          <FontAwesomeIcon
            :icon="['fas', 'undo']"
            class="text-2xs"
          />
        </button>
        <button
          style="width: 25px; height: 25px"
          class="button is-default image-control"
          @click="_zoomOut"
        >
          <FontAwesomeIcon
            :icon="['fas', 'minus']"
            class="text-2xs"
          />
        </button>
        <button
          style="width: 25px; height: 25px"
          class="button is-default image-control"
          @click="resetImage"
        >
          <FontAwesomeIcon
            :icon="['fas', 'expand-arrows-alt']"
            class="text-2xs"
          />
        </button>
        <button
          style="width: 25px; height: 25px"
          class="button is-default image-control"
          @click="_zoomIn"
        >
          <FontAwesomeIcon
            :icon="['fas', 'plus']"
            class="text-2xs"
          />
        </button>
        <button
          style="width: 25px; height: 25px"
          class="button is-default image-control"
          @click="_rotateClockWise"
        >
          <FontAwesomeIcon
            :icon="['fas', 'redo']"
            class="text-2xs"
          />
        </button>
      </div>
      <br>
      <button
        :disabled="!isSavable"
        class="image-upload-save-btn mx-auto button is-secondary rounded-full shadow text-lg mb-3 px-4"
        data-dismiss="modal"
        @click="saveImage"
      >{{ lang.edit_participant.save }}</button>
      <p
        v-if="shouldShowDelete && !ssvDisabled"
        class="text-gray text-sm px-16 -mt-1 leading-tight"
      >{{ lang.edit_participant.student_star_wait }}</p>
    </div>
  </div>
</template>

<script>

export default {
  name: 'DashboardUploadPhotoForm',
  status: 'prototype',
  release: '1.0.0',
  props: {
    lang: {
      type: Object,
      default: null,
    },
    startingImage: {
      // This is the image that will show when the form first displays. This could be the defaultImage or a custom image.
      type: String,
      default: null,
    },
    isDefaultImage: {
      type: Boolean,
      default: false,
    },
    defaultImage: {
      // This is the image that will show if a custom image is deleted. Think of this as the placeholder image.
      type: String,
      default: '',
    },
    ssvDisabled: {
      type: Boolean,
      default: false,
    },
  },
  data () {
    return {
      myCroppa: null,
      initialMetadata: null,
      initialImageUrl: null,
      initialImageFile: null,
      drawCount: 0,
      shouldShowDelete: false,
      initialImage: this.startingImage, // Required to be named as "initialImage" by Croppa
    }
  },
  computed: {
    hasImage () {
      if (this.myCroppa) {
        return this.myCroppa.hasImage()
      }
      return false
    },
    isSavable () {
      if (this.myCroppa && this.drawCount) {
        return this.initialImageUrl !== this.myCroppa.generateDataUrl()
      }
      return false
    },
  },
  mounted () {
    this.shouldShowDelete = !this.isDefaultImage
    this.initialImageUrl = this.myCroppa.generateDataUrl()
    // subscription used to refresh on second participant
    this.$store.subscribe((event, payload) => {
      if (event.type === 'new_participant') {
        this.myCroppa.remove()
        this.initialImageUrl = this.myCroppa.generateDataUrl()
      }
    })
  },
  methods: {
    resetImage () {
      this.gaEvent('Parent Dashboard', 'Photo Upload Form', 'Reset Image')
      this.myCroppa.applyMetadata(this.initialMetadata)
      this.$emit('is-photo-default', false)
    },
    newImageDrawn () {
      this.initialMetadata = this.myCroppa.getMetadata()
    },
    newImage () {
      this.shouldShowDelete = true
      this.$store.commit('SET_PHOTO_DIRTY', true)
      this.$emit('is-photo-default', false)
    },
    async saveImage () {
      this.gaEvent('Titan Edit Participant', 'Photo Upload Form', 'Save Image')
      this.initialImageUrl = this.myCroppa.generateDataUrl()
      this.initialImageFile = await this.myCroppa.promisedBlob()
      this.$store.dispatch('setUserPhoto', this.initialImageUrl ? this.initialImageUrl : undefined)
      this.$store.dispatch('setUserPhotoFile', this.initialImageFile ? this.initialImageFile : undefined)
      this.$store.commit('SET_PHOTO_DIRTY', true)
      this.$emit('photo-changed')
      this.$emit('close')
    },
    deleteImage () {
      this.shouldShowDelete = false
      this.myCroppa.remove()
      this.initialImage = this.defaultImage
      this.myCroppa.refresh()
      this.$store.dispatch('setUserPhoto', undefined)
      this.$store.dispatch('setUserPhotoFile', undefined)

      this.gaEvent('Parent Dashboard', 'Photo Upload Form', 'Delete Image')
      this.$emit('photo-removed')
      this.$emit('is-photo-default', true)
    },
    _rotateCounterClockWise () {
      this.myCroppa.rotate(-1)
      this.gaEvent('Parent Dashboard', 'Photo Upload Form', 'Rotate Counter Clockwise')
      this.$emit('is-photo-default', false)
    },
    _rotateClockWise () {
      this.myCroppa.rotate(1)
      this.gaEvent('Parent Dashboard', 'Photo Upload Form', 'Rotate Clockwise')
      this.$emit('is-photo-default', false)
    },
    _zoomOut () {
      this.myCroppa.zoomOut()
      this.gaEvent('Parent Dashboard', 'Photo Upload Form', 'Zoom Out')
      this.$emit('is-photo-default', false)
    },
    _zoomIn () {
      this.myCroppa.zoomIn()
      this.gaEvent('Parent Dashboard', 'Photo Upload Form', 'Zoom In')
      this.$emit('is-photo-default', false)
    },
  },
}
</script>
