<template>
  <form
    :novalidate="!isIE11"
    @submit.prevent="submit"
  >
    <div class="mx-4 md:mx-0 pb-4">
      <div class="student-info border-b mb-10 pb-10">
        <div class="max-w-md md:mx-auto">
          <div class="add-photo mb-8">
            <div class="flex items-center justify-start">
              <AvatarImage
                :src="avatarSrc"
                :should-emit="true"
                alt="Edit Participant Profile Image"
                class="cursor-pointer"
                @open="openDashboardPhotoUpload"
                @click.prevent="openDashboardPhotoUpload"
              />

              <button
                class="button is-secondary rounded-full ml-3"
                @click.prevent="openDashboardPhotoUpload"
              >
                {{ lang.edit_participant.upload_photo }}
              </button>
            </div>
          </div>

          <h2 class="text-lg font-semibold mb-4">
            {{ lang.edit_participant.form_title }}
          </h2>

          <BaseInput
            v-model.trim="form.first_name"
            :v="$v.form.first_name"
            :label="lang.edit_participant.first_name_label"
            :placeholder="lang.edit_participant.first_name_placeholder"
            required
          />

          <BaseInput
            v-model.trim="form.last_name"
            :v="$v.form.last_name"
            :label="lang.edit_participant.last_name_label"
            :placeholder="lang.edit_participant.last_name_placeholder"
            required
          />

          <div class="field">
            <label class="">{{ lang.edit_participant.classroom_label }}</label>
            <div class="control">
              <div class="select is-fullwidth">
                <select
                  v-model="form.classroom.id"
                  name="classroom"
                  class="select"
                  required
                >
                  <template v-for="(grade, label) in classroomsSorted">
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
                </select>
              </div>
            </div>
          </div>

        </div>
      </div>

      <div
        v-if="displayFamilyPledging"
        class="family-pledging border-b mb-10 pb-10"
      >
        <div class="max-w-md md:mx-auto">
          <div class="flex items-center mb-6">
            <h2 class="text-lg font-semibold mr-6">
              {{ lang.edit_participant.family_pledging_header }}
            </h2>
            <img
              src="/v3-assets/dashboard/images/family-pledging.png"
              style="width: 36px; height: 36px;"
              alt=""
            >
          </div>

          <div class="field">
            <BSwitch
              v-model="form.family_pledging_enabled"
              type="is-tertiary"
            />
          </div>

          <p class="text-sm">
            {{ lang.edit_participant.family_pledging_message }}
          </p>
        </div>
      </div>

      <div class="pledge-goal border-b mb-10 pb-10">
        <div class="max-w-md md:mx-auto">
          <h2
            v-if="isFlat"
            class="text-lg font-semibold mb-4"
          >
            {{ lang.edit_participant.pledge_goal }}
          </h2>
          <h2
            v-else
            class="text-lg font-semibold mb-4 capitalize"
          >
            {{ lang.edit_participant.pledge_goal }} <span v-if="!isFlat">: {{ form.unit.modifier }} {{ form.unit.name }}</span>
          </h2>
          <div class="field">
            <label
              class="text-sm"
              for="goal-amount"
            >
              {{ lang.edit_participant.goal_amount }}
            </label>
            <div class="control">
              <div class="flex items-center">
                <div>
                  <input
                    id="goal-amount"
                    v-model="$v.form.pledge_goal.$model"
                    step="1"
                    min="0"
                    type="number"
                    class="input font-bold w-16 sm:w-32"
                  >
                </div>
                <div
                  v-if="!isFlat"
                  class="flex items-center"
                >
                  <div class="font-bold px-2 sm:px-4 text-lg">
                    =
                  </div>
                  <div class="leading-none">
                    <span class="font-bold text-lg">
                      ${{ (form.pledge_goal * form.unitRangeLow) | currency }} to ${{ (form.pledge_goal * form.unitRangeHigh) | currency }}
                    </span><br>
                    <span class="text-xs">
                      $1 <span class="capitalize">{{ form.unit.modifier }} {{ form.unit.name }}</span> = ${{ form.unitRangeLow }} to ${{ form.unitRangeHigh }}
                    </span>
                  </div>
                </div>
              </div>
            </div>
            <p
              v-if="$v.form.pledge_goal.$invalid"
              class="help is-danger pl-2 text-xs text-red-500"
            >
              {{ lang.edit_participant.goal_amount }} {{ lang.is_required }}
            </p>
          </div>
        </div>
      </div>

      <div class="pledge-page-message mb-10">
        <div class="max-w-md md:mx-auto">
          <h2 class="text-lg font-semibold mb-2">
            {{ lang.edit_participant.pledge_message }}
          </h2>

          <div class="editor">
            <EditorMenuBar :editor="editor">
              <div
                slot-scope="{ commands, isActive }"
                class="field has-addons"
                style="margin-bottom: -1px"
              >
                <p class="control">
                  <button
                    :class="['button', { 'is-active': isActive.bold() }]"
                    @click.prevent="commands.bold"
                  >
                    <span class="icon is-small">
                      <FontAwesomeIcon :icon="['fas', 'bold']" />
                    </span>
                    <span>{{ lang.edit_participant.bold }}</span>
                  </button>
                </p>

                <p class="control">
                  <button
                    :class="['button', { 'is-active': isActive.italic() }]"
                    @click.prevent="commands.italic"
                  >
                    <span class="icon is-small">
                      <FontAwesomeIcon :icon="['fas', 'italic']" />
                    </span>
                    <span>{{ lang.edit_participant.italic }}</span>
                  </button>
                </p>

                <p class="control">
                  <button
                    :class="['button', { 'is-active': isActive.underline() }]"
                    @click.prevent="commands.underline"
                  >
                    <span class="icon is-small">
                      <FontAwesomeIcon :icon="['fas', 'underline']" />
                    </span>
                    <span>{{ lang.edit_participant.underline }}</span>
                  </button>
                </p>
              </div>
            </EditorMenuBar>

            <EditorContent
              :editor="editor"
              class="editor__content border p-2 mb-10"
            />
          </div>
        </div>
      </div>

      <div class="text-center mb-10 pb-10">
        <div class="max-w-md md:mx-auto">
          <div class="flex flex-col items-center justify-start">
            <button
              :disabled="$v.$invalid"
              class="inline-block w-full sm:w-64 mb-4 py-2 rounded-full leading-none text-lg font-semibold focus:outline-none focus:shadow-outline shadow-md bg-secondary text-white"
            >
              {{ lang.edit_participant.save }}
            </button>
            <a
              href="/v3/home/dashboard"
              class="inline-block w-full sm:w-64 mb-4 py-2 rounded-full leading-none text-lg font-semibold focus:outline-none focus:shadow-outline shadow-md bg-white text-secondary hover:text-secondary-light border border-secondary hover:border-secondary-light"
            >
              {{ lang.edit_participant.cancel }}
            </a>
          </div>

          <a
            class="inline-block mb-4"
            href="/v3/terms#"
            target="_new"
          >
            {{ lang.edit_participant.view_agreement }}
          </a><br>
          <button
            v-tooltip="deleteTooltip"
            :disabled="false"
            class="text-red"
            href="#"
            @click.prevent="deleteStudent"
          >
            {{ lang.edit_participant.delete }}
          </button>
        </div>
      </div>
    </div>
  </form>
</template>

<script>
import { mapState, mapGetters, mapMutations, mapActions } from 'vuex'
import SaveSuccessModal from '@/components/template/SaveSuccessModal'
import { Editor, EditorContent, EditorMenuBar } from 'tiptap'
import { Bold, Italic, Link, Underline } from 'tiptap-extensions'
import { required } from 'vuelidate/lib/validators'
import UploadPhotoForm from '@/components/template/UploadPhotoForm'
import Blur from '@/mixins/Blur'

const DEFAULT_IMAGE = '/v3-assets/dashboard/images/dashboard-avatar.svg'
const isIE = '-ms-scroll-limit' in document.documentElement.style && '-ms-ime-align' in document.documentElement.style
const isEdge = '-ms-scroll-limit' in document.documentElement.style && '-ms-ime-align' in document.documentElement.style && !window.navigator.msPointerEnabled

export default {
  name: 'EditParticipantForm',
  status: 'prototype',
  release: '1.0.0',
  components: {
    EditorContent,
    EditorMenuBar,
  },
  mixins: [Blur],
  props: {
    participant: {
      type: Object,
      default: null,
    },
    classrooms: {
      type: Array,
      default: () => ([]),
    },
    settings: {
      type: Object,
      default: null,
    },
  },
  data: () => ({
    isIE11: isIE && !isEdge,
    form: {
      first_name: '',
      last_name: '',
      family_pledging_enabled: '',
      pledge_goal: '',
      pledge_page_text: '',
      classrooms: [],
      classroom: {},
      unit: {},
      unitRangeLow: null,
      unitRangeHigh: null,
      image_name: '',
    },
    editor: null,
    tempUploadedPhoto: null,
    hasPhotoBeenRemoved: null,
  }),
  validations: {
    form: {
      first_name: { required },
      last_name: { required },
      pledge_goal: { required },
    },
  },
  computed: {
    ...mapState(['lang', 'newUserPhoto', 'newUserPhotoFile']),
    ...mapGetters(['avatarPath', 'programParticipantCount']),
    program () {
      return this.participant.participant_info.classroom.group.program
    },
    avatarSrc () {
      if (this.tempUploadedPhoto) {
        return this.tempUploadedPhoto
      }
      if (this.participant.profile.image_name === null) {
        return DEFAULT_IMAGE
      }
      return this.avatarPath + this.form.image_name
    },
    classroomsByGrade () {
      return this.classrooms
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
    classroomsGroupAndSorted () {
      return Object.keys(this.classroomsByGrade).sort()
    },
    classroomsSorted () {
      return this.classrooms
        .filter(classroom => !classroom.deleted)
        .map(classroom => ({
          id: classroom.id,
          name: classroom.name,
          gradeId: classroom.grade.id,
          gradeName: classroom.grade.name,
          gradeDisplayName: classroom.grade.display_name,
        }))
        .sort((a, b) => {
          if (a.gradeId > b.gradeId) return 1
          if (a.gradeId < b.gradeId) return -1
          if (a.name > b.name) return 1
          if (a.name < b.name) return -1
        })
        .reduce((classrooms, classroom) => {
          const grade = (classroom.gradeId > 0) ? `${classroom.gradeName} ${this.lang.edit_participant.grade}` : classroom.gradeName
          if (!classrooms[grade]) {
            classrooms[grade] = []
          }
          classrooms[grade].push(classroom)
          return classrooms
        }, {})
    },
    isProgramFamilyPledgingEnabled () {
      return this.program.program_pledge_setting.family_pledging_enabled === 1
    },
    displayFamilyPledging () {
      const isProgramFamilyPledgingEnabled = this.program.program_pledge_setting.family_pledging_enabled === 1
      const hasMultipleParticipantInProgram =
            this.programParticipantCount(this.program.id) > 1
      return isProgramFamilyPledgingEnabled && hasMultipleParticipantInProgram
    },
    isFlat () {
      return this.program.program_pledge_setting.flat_donate_only === 1
    },
    deleteTooltip () {
      return {
        classes: ['info'],
        content: this.lang.delete_tooltip,
        placement: 'auto',
        trigger: 'hover click focus',
      }
    },
    editorContent () {
      if (this.emptyEditorText) {
        return this.defaultPledgePageText
      }

      return this.form.pledge_page_text
    },
    emptyEditorText () {
      // Use regex in replace() to remove whitespace characters in the pledge page text.
      return this.form.pledge_page_text.replace(/\s+/g, '') === '<p></p>' || this.form.pledge_page_text === ''
    },
    defaultPledgePageText () {
      return this.parseLanguage(this.lang.edit_participant.default_pledge_page_message, {
        funds_raised_for: this.participant.participant_info.classroom.group.program.microsite.funds_raised_for,
        event_date: this.formatEventDate(this.participant.participant_info.classroom.group.program.fun_run),
        unit_type: this.settings.unit.name_plural,
        event_name: this.participant.participant_info.classroom.group.program.event_name,
        link: '/v3/tkdashboard/?redirect=' + encodeURI('auth/login/' + this.participant.fr_code + '/view-participant/pledge'),
      })
    },
  },
  mounted () {
    const { first_name, last_name } = this.participant
    const { classroom, family_pledging_enabled } = this.participant.participant_info
    const { pledge_goal, pledge_page_text, image_name } = this.participant.profile
    const { unit, unitRangeLow, unitRangeHigh } = this.settings

    this.form = {
      first_name,
      last_name,
      classroom,
      family_pledging_enabled: !!family_pledging_enabled,
      pledge_goal: this.$options.filters.Currency(pledge_goal),
      pledge_page_text,
      unit,
      unitRangeLow,
      unitRangeHigh,
      image_name,
    }

    this.editor = new Editor({
      extensions: [new Bold(), new Italic(), new Link(), new Underline()],
      content: this.editorContent,
    })
  },
  beforeDestroy () {
    this.editor.destroy()
  },
  methods: {
    ...mapMutations(['SET_PHOTO_DIRTY']),
    ...mapActions(['refreshUser']),
    formatEventDate (date) {
      const year = date.slice(2, 4)
      const month = date.slice(5, 7)
      const day = date.slice(8, 10)
      return month + '/' + day + '/' + year
    },
    getSubmitData () {
      this.form.pledge_page_text = this.editor.getHTML()

      const formData = new FormData()

      formData.append('participant_id', this.participant.id)
      formData.append('first_name', this.form.first_name)
      formData.append('last_name', this.form.last_name)
      formData.append('classroom_id', this.form.classroom.id)
      formData.append('family_pledging_enabled', this.form.family_pledging_enabled ? 1 : 0)
      formData.append('pledge_goal', this.form.pledge_goal)
      formData.append('pledge_page_text', this.form.pledge_page_text)

      if (this.hasPhotoBeenRemoved) {
        formData.append('deleteFile', 1)
      } else if (this.newUserPhotoFile) {
        formData.append('photoFile', this.newUserPhotoFile)
      }

      return formData
    },
    submit () {
      this.$v.$touch()
      this.$forceUpdate()

      if (this.$v.$invalid) return
      const submitData = this.getSubmitData()
      axios.post(
        '/v3/participant/update',
        submitData,
        {
          headers: { 'Content-Type': 'multipart/form-data' },
        },
      )
        .then(response => {
          this.refreshUser()
          if (this.$store.state.photoDirty) {
            this.gaEvent('Parent Dashboard', 'Edit Participant Form', 'Upload Photo')
            this.SET_PHOTO_DIRTY(false)
          }

          this.$v.$reset()
          this.SET_PHOTO_DIRTY(false)

          if (this.emptyEditorText) {
            this.editor.destroy()
            this.editor = new Editor({
              extensions: [new Bold(), new Italic(), new Link(), new Underline()],
              content: this.editorContent,
            })
          }

          this.$buefy.modal.open({
            parent: this,
            component: SaveSuccessModal,
            scroll: 'keep',
            hasModalCard: true,
            canCancel: false,
            props: {
              title: this.lang.edit_participant.saved_successfully,
              reload: true,
            },
          })
        })
    },
    deleteStudent () {
      this.$dialog.confirm({
        title: 'Deleting Student',
        message: 'You are about to delete this participant? Are you sure you want to continue?',
        cancelText: 'No',
        confirmText: 'Yes',
        type: 'is-danger',
        hasIcon: true,
        onConfirm: () => this.$buefy.toast.open({
          duration: 3000,
          message: 'Student has been deleted',
          position: 'is-top',
          type: 'is-danger',
        }),
      })
    },
    openDashboardPhotoUpload () {
      const cacheBust = '?' + Date.now()
      var isDefaultImage = this.avatarSrc === DEFAULT_IMAGE
      var initialImage = this.avatarSrc + cacheBust

      if (this.tempUploadedPhoto && this.hasPhotoBeenRemoved) {
        isDefaultImage = true
      }

      if (this.tempUploadedPhoto) {
        initialImage = this.avatarSrc
      }

      this.$buefy.modal.open({
        parent: this,
        component: UploadPhotoForm,
        hasModalCard: false,
        width: 'auto',
        onCancel: this.unBlur,
        canCancel: ['escape', 'outside'],
        events: {
          close: evt => {
            this.unBlur()
          },
          'photo-changed': evt => {
            this.tempUploadedPhoto = this.newUserPhoto
            this.SET_PHOTO_DIRTY(true)
          },
          'photo-removed': evt => {
            this.tempUploadedPhoto = null
            this.SET_PHOTO_DIRTY(true)
          },
          'is-photo-default': isPhotoDefault => {
            this.hasPhotoBeenRemoved = isPhotoDefault
          },
        },
        props: {
          lang: this.lang,
          startingImage: initialImage,
          isDefaultImage: isDefaultImage,
          defaultImage: DEFAULT_IMAGE,
          ssvDisabled: this.program.ssv_disabled,
        },
      })
      this.blur()
    },
  },
}
</script>
