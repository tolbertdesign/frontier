<template>
  <AccordionModal :header="language">
    <template>
      <div class="min-h-0 max-h-full">
        <Accordion
          v-for="(email, key, index) in emails[language]"
          :key="key"
          :title="email.title"
          :is-open="index === 0"
        >
          <template slot="title">
            <p class="text-sm sm:text-base md:text-lg text-left">
              <span class="font-semibold">{{ email.title }}</span>
            </p>
          </template>

          <template>
            <div class="p-2">
              <div class="modal-card-body bg-white p-4 md:p-6 text-sm sm:text-base md:text-lg">
                <Component
                  :is="email.component"
                  :props="props"
                />
              </div>
            </div>
          </template>
        </Accordion>
      </div>
    </template>
  </AccordionModal>
</template>

<script>
import Accordion from '@/components/element/Accordion'
import AccordionModal from '@/components/template/AccordionModal'
import currency from '@/filters/currency'
import Blur from '@/mixins/Blur'
import EnglishTeamDay from '@/components/element/TeacherEmails/English/TeamDay'
import EnglishTeamDayTwo from '@/components/element/TeacherEmails/English/TeamDayTwo'
import EnglishWeekendChallenge from '@/components/element/TeacherEmails/English/WeekendChallenge'
import EnglishDayAfterFunrun from '@/components/element/TeacherEmails/English/DayAfterFunrun'
import EnglishDayBeforeFunrun from '@/components/element/TeacherEmails/English/DayBeforeFunrun'
import SpanishTeamDay from '@/components/element/TeacherEmails/Spanish/TeamDay'
import SpanishTeamDayTwo from '@/components/element/TeacherEmails/Spanish/TeamDayTwo'
import SpanishWeekendChallenge from '@/components/element/TeacherEmails/Spanish/WeekendChallenge'
import SpanishDayAfterFunrun from '@/components/element/TeacherEmails/Spanish/DayAfterFunrun'
import SpanishDayBeforeFunrun from '@/components/element/TeacherEmails/Spanish/DayBeforeFunrun'

export default {
  name: 'TeacherEmailTemplates',
  status: 'prototype',
  release: '1.0.0',
  filters: {
    currency: currency,
  },
  components: {
    Accordion,
    AccordionModal,
    EnglishTeamDay,
    EnglishTeamDayTwo,
    EnglishWeekendChallenge,
    EnglishDayAfterFunrun,
    EnglishDayBeforeFunrun,
    SpanishTeamDay,
    SpanishTeamDayTwo,
    SpanishWeekendChallenge,
    SpanishDayAfterFunrun,
    SpanishDayBeforeFunrun,
  },
  mixins: [
    Blur,
  ],
  props: {
    language: {
      type: String,
      default: 'english',
    },
    program: {
      type: Object,
      default: () => {},
    },
  },
  computed: {
    lang () {
      return this.$store.state.lang
    },
    class_pledge_total () {
      return currency(this.$store.state.User.class_pledge_total, true)
    },
    emails () {
      return {
        english: [
          {
            title: this.lang.teacher_email_templates.english.team_day_email.title,
            component: 'EnglishTeamDay',
          },
          {
            title: this.lang.teacher_email_templates.english.team_day_two_email.title,
            component: 'EnglishTeamDayTwo',
          },
          {
            title: this.lang.teacher_email_templates.english.weekend_challenge_email.title,
            component: 'EnglishWeekendChallenge',
          },
          {
            title: this.lang.teacher_email_templates.english.day_before_funrun_email.title,
            component: 'EnglishDayAfterFunrun',
          },
          {
            title: this.lang.teacher_email_templates.english.day_after_funrun_email.title,
            component: 'EnglishDayBeforeFunrun',
          },
        ],
        spanish: [
          {
            title: this.lang.teacher_email_templates.spanish.team_day_email.title,
            component: 'SpanishTeamDay',
          },
          {
            title: this.lang.teacher_email_templates.spanish.team_day_two_email.title,
            component: 'SpanishTeamDayTwo',
          },
          {
            title: this.lang.teacher_email_templates.spanish.weekend_challenge_email.title,
            component: 'SpanishWeekendChallenge',
          },
          {
            title: this.lang.teacher_email_templates.spanish.day_before_funrun_email.title,
            component: 'SpanishDayAfterFunrun',
          },
          {
            title: this.lang.teacher_email_templates.spanish.day_after_funrun_email.title,
            component: 'SpanishDayBeforeFunrun',
          },
        ],
      }
    },
    props () {
      return {
        event_name: this.program.event_name,
        registration_code: this.program.registration_code,
        due_date: this.formattedDueDate(this.program.due_date),
        link: this.program.unit.domain,
        class_pledge_total: this.class_pledge_total,
      }
    },
  },
  methods: {
    formattedDueDate (date) {
      const dueDate = new Date(date)
      return (dueDate.getMonth() + 1) + '/' + dueDate.getDate() + '/' + dueDate.getFullYear()
    },
    closeModal () {
      this.$emit('close')
      this.unBlur()
    },
  },
}
</script>
