<template>
  <div>
    <h1 class="participant-registration-form mb-46px text-28 fw-200 d-block mt-8']">
      {{ lang.participant_registration.register_student }}
    </h1>
    <form @submit.prevent="submit">
      <div
        id="upload-photo"
        :data-target="ssvDisabled ? '#uploadPhotoModalSsvDisabled' : '#uploadPhotoModal'"
        data-toggle="modal"
        class="cursor-pointer"
        @click="_uploadPhoto"
      >
        <img
          :src="photo"
          class="profile-picture btn-circle"
        >

        <input
          class="avatar d-block mx-auto"
          name="profile_picture"
          type="file"
        >
        <label
          class="text-15 d-block mx-auto cursor-pointer font-weight-bold"
          for="profile_picture"
        >
          <u>{{ photoText }}</u>
          <p
            v-if="showOptional"
            class="text-12 fw-300"
          >{{ lang.participant_registration.optional }}</p></label>
      </div>
      <div
        v-if="errors"
      >
        <ul
          v-for="(error, key) in errors"
          :key="key"
          class="alert alert-danger p-4"
        >
          <li
            v-for="(message, index) in error"
            :key="index"
            class="error-list-item text-danger"
          >{{ message }}</li>
        </ul>
      </div>
      <text-input
        v-model="first_name"
        :label="lang.participant_registration.student_first_name"
        type="text"
        name="first_name"
        required
        @invalid="resetSubmitButton"
      />
      <text-input
        v-model="last_name"
        :label="lang.participant_registration.student_last_name"
        class="mb-28px"
        type="text"
        name="last_name"
        required
        @invalid="resetSubmitButton"
      />

      <selection-input
        v-model="classroom"
        :default_value="null"
        :default_text="lang.participant_registration.select_classroom"
        class="mb-28px blue-rounded"
        name="classroom"
        required
        @invalid="resetSubmitButton"
      >
        <template v-for="(grade, label) in classroomsByGrade">
          <template v-if="label == 'Other'">
            <option
              v-for="classroom in grade"
              :key="classroom.id"
              :value="classroom.id"
            >
              {{ classroom.name }}
            </option>
          </template>
          <template v-else>
            <optgroup
              :key="label"
              :label="label"
            >
              <option
                v-for="classroom in grade"
                :key="classroom.id"
                :value="classroom.id.toString()"
              >
                {{ classroom.name }}
              </option>
            </optgroup>
          </template>
        </template>
      </selection-input>

      <input
        ref="true_submit_btn"
        type="submit"
        style="display: none"
      >

      <input
        v-model="terms"
        :required="checkbox_required"
        class="checkbox"
        name="participation_terms"
        type="checkbox"
        @invalid="resetSubmitButton"
      >
      <label class="text-12 mb-28px">
        {{ lang.participant_registration.participation_terms_prefix }}
        <a
          id="print-terms"
          href="/v3/terms"
          target="_blank"
        >{{ lang.participant_registration.participation_terms_link }}</a>
      </label>
      <button
        :disabled="submitting"
        type="button"
        class="btn btn-primary btn-round d-block w-200px mx-auto mb-1 btn-drop-shadow text-18"
        @click="handleSubmit"
      >{{ lang.participant_registration.add_student }}
        <i
          v-if="submitting"
          class="fa fa-spinner fa-spin"
        /></button>
    </form>
  </div>
</template>

<script>
export default {
  data: function () {
    return {
      first_name: '',
      last_name: '',
      classroom: null,
      terms: false,
      photo: null,
      photoFile: null,
      photoText: '',
      showOptional: true,
      errors: null,
      submitting: false,
      checkbox_required: false,
    }
  },
  computed: {
    school () {
      return this.$store.state.User.participants[this.participant_num - 1]
        .school
    },
    ssvDisabled () {
      return this.school.ssv_disabled
    },
    classroomsByGrade () {
      // return this.$store.getters.classroomsByGrade;
      return this.school.classrooms
        .filter(classroom => !classroom.deleted)
        .reduce((classrooms, classroom) => {
          const grade = (classroom.grade.id > 0) ? `${classroom.grade.name} Grade` : classroom.grade.name
          if (!classrooms[grade]) {
            classrooms[grade] = []
          }
          classrooms[grade].push(classroom)
          return classrooms
        }, {})
    },
    lang () {
      return this.$store.state.lang
    },
    participant_num () {
      return this.$store.state.User.participants.length
    },
    User () {
      return this.$store.state.User
    },
  },
  mounted () {
    this.hjTrigger('dash-register-participant')
    $('#uploadPhotoModal').on('shown.bs.modal', () => {
      this.hjTrigger('dash-upload-photo-form')
    })
    this.showUploadText()
    this.photo = this.photoUrl()
    this.photoFile = this.getPhotoFile()
    this.$store.subscribe((event, payload) => {
      if (event.type === 'set_user_photo') {
        this.photo = this.photoUrl()
      }
    })

    this.$store.subscribe((event, payload) => {
      if (event.type === 'set_user_photo_file') {
        this.photoFile = this.getPhotoFile()
      }
    })
  },
  methods: {
    handleSubmit: function (e) {
      if (this.submitting) {
        return
      }

      // Enable checkbox to be required
      this.checkbox_required = true

      // Have to wait before running submission because DOM update can take a bit of time
      this.$nextTick(() => {
        this.$refs.true_submit_btn.click()
      })
    },
    resetSubmitButton: function () {
      this.submitting = false
    },
    submit: function () {
      this.submitting = true
      const formData = new FormData()

      formData.append('firstName', this.first_name)
      formData.append('lastName', this.last_name)
      formData.append('classroomId', this.classroom)
      formData.append('isAgreed', this.terms)
      if (this.photoFile !== null) { formData.append('imageFile', this.photoFile) }

      axios
        .post(
          '/v3/register/participant',
          formData,
          { headers: { 'Content-Type': 'multipart/form-data' } },
        )
        .then(response => {
          const participant = {
            index: this.participant_num - 1,
            data: response.data,
          }
          this.$store.commit('UPDATE_PARTICIPANT', participant)

          if (formData.imageB64Url !== this.$store.state.default_user_image) {
            this.gaEvent('Titan Registration', 'Parent Registration', 'Student Photo')
          } else {
            this.gaEvent('Titan Registration', 'Parent Registration', 'Student No Photo')
          }
          if (this.$store.state.User.participants.length > 1 && !formData.isFamilyPledgingEnabled) {
            this.gaEvent('Titan Registration', 'Parent Registration', 'No Family Pledge')
          }
          this.$emit('participant-registered')
        })
        .catch(error => {
          this.errors = JSON.parse(error.request.response).errors
        })
        .finally(() => {
          this.submitting = false
        })
    },
    showUploadText () {
      this.photoText = this.lang.participant_registration.upload_photo
      this.showOptional = true
    },
    showEditText () {
      this.photoText = this.lang.participant_registration.edit_photo
      this.showOptional = false
    },
    photoUrl () {
      if (
        this.$store.state.User.participants[this.participant_num - 1]
          .photo_url === undefined
      ) {
        this.showUploadText()
        return this.$store.state.default_user_image
      }
      this.showEditText()
      return this.$store.state.User.participants[this.participant_num - 1]
        .photo_url
    },
    getPhotoFile () {
      if (
        this.$store.state.User.participants[this.participant_num - 1]
          .photo_file === undefined
      ) {
        return null
      }
      return this.$store.state.User.participants[this.participant_num - 1]
        .photo_file
    },
    getImageBlob () {
      const block = this.photo.split(';')
      const contentType = block[0].split(':')[1]
      const realData = block[1].split(':')[1]
      const blob = this.b64toBlob(realData, contentType)
      return blob
    },
    b64toBlob (b64Data, contentType, sliceSize) {
      contentType = contentType || ''
      sliceSize = sliceSize || 512

      var byteCharacters = atob(b64Data)
      var byteArrays = []

      for (var offset = 0; offset < byteCharacters.length; offset += sliceSize) {
        var slice = byteCharacters.slice(offset, offset + sliceSize)

        var byteNumbers = new Array(slice.length)
        for (var i = 0; i < slice.length; i++) {
          byteNumbers[i] = slice.charCodeAt(i)
        }

        var byteArray = new Uint8Array(byteNumbers)

        byteArrays.push(byteArray)
      }

      var blob = new Blob(byteArrays, { type: contentType })
      return blob
    },
    _uploadPhoto () {
      this.gaEvent('Titan Registration', 'Participant Form', 'Upload Photo')
    },
  },
}
</script>
