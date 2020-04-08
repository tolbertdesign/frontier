<template>
  <div>
    <div class="upload-photo-form auth w-150px position-relative mx-auto">
      <croppa
        v-model="myCroppa"
        :zoom-speed="15"
        :width="150"
        :height="150"
        :show-remove-button="false"
        :placeholder="''"
        class="croppa-image"
        @new-image-drawn="initialMetadata=myCroppa.getMetadata()"
        @draw="drawCount++"
      >
        <img
          slot="placeholder"
          :src="initialImage"
        >
      </croppa>
    </div>
    <button
      class="mx-auto btn btn-primary btn-round btn-drop-shadow upload-photo-btn px-4 mb-2"
      @click.prevent="myCroppa.chooseFile()"
    >
      <input
        name="profile_image"
        hidden
      >
      {{ lang.participant_registration.upload_photo }}
    </button>
    <div
      :class="{'invisible' : !hasImage}"
      class="delete-photo-btn cursor-pointer text-danger mb-2 text-14"
      @click="deleteImage()"
    >{{ lang.delete_photo }}</div>
    <div class="buttons mb-4 mx-auto w-150px d-flex justify-content-between">
      <button
        class="btn btn-default image-control text-10"
        @click="_rotateCounterClockWise"
      ><i class="fas fa-undo" /></button>
      <button
        class="btn btn-default image-control text-10"
        @click="_zoomOut"
      ><i class="fas fa-minus" /></button>
      <button
        class="btn btn-default image-control text-10"
        @click="resetImage()"
      ><i class="fas fa-expand-arrows-alt" /></button>
      <button
        class="btn btn-default image-control text-10"
        @click="_zoomIn"
      ><i class="fas fa-plus" /></button>
      <button
        class="btn btn-default image-control text-10"
        @click="_rotateClockWise"
      ><i class="fas fa-redo" /></button>
    </div>
    <button
      :disabled="!isSavable"
      class="image-upload-save-btn btn btn-round btn-primary mb-3 w-150px fw-400 text-18 w-200px"
      data-dismiss="modal"
      @click="saveImage"
    >{{ lang.save }}</button>
    <p
      :class="{'invisible' : !hasImage || ssvDisabled}"
      class="student_star_wait text-14 mw-250px mx-auto"
    >{{ lang.student_star_wait }}</p>
  </div>
</template>

<script>
export default {
  props: {
    lang: {
      type: Object,
      default: null,
    },
    ssvDisabled: {
      type: Boolean,
      default: false,
    },
  },
  data () {
    return {
      myCroppa: null,
      initialImage: '/img/userpic_60px.svg',
      initialMetadata: null,
      initialImageUrl: null,
      initialImageFile: null,
      drawCount: 0,
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
      this.gaEvent('Titan Registration', 'Photo Upload Form', 'Reset Image')
      this.myCroppa.applyMetadata(this.initialMetadata)
    },
    async saveImage () {
      this.gaEvent('Titan Registration', 'Photo Upload Form', 'Save Image')
      this.initialImageUrl = this.myCroppa.generateDataUrl()
      this.initialImageFile = await this.myCroppa.promisedBlob()
      this.$store.commit('SET_USER_PHOTO', this.initialImageUrl ? this.initialImageUrl : undefined)
      this.$store.commit('SET_USER_PHOTO_FILE', this.initialImageFile ? this.initialImageFile : undefined)
      this.$emit('photo-changed')
      $('#uploadPhotoModal').modal('hide')
    },
    deleteImage () {
      this.gaEvent('Titan Registration', 'Photo Upload Form', 'Delete Image')
      this.myCroppa.remove()
    },
    _rotateCounterClockWise () {
      this.myCroppa.rotate(-1)
      this.gaEvent('Titan Registration', 'Photo Upload Form', 'Rotate Counter Clockwise')
    },
    _rotateClockWise () {
      this.myCroppa.rotate(1)
      this.gaEvent('Titan Registration', 'Photo Upload Form', 'Rotte Clockwise')
    },
    _zoomOut () {
      this.myCroppa.zoomOut()
      this.gaEvent('Titan Registration', 'Photo Upload Form', 'Zoom Out')
    },
    _zoomIn () {
      this.myCroppa.zoomIn()
      this.gaEvent('Titan Registration', 'Photo Upload Form', 'Zoom In')
    },

  },
}
</script>
