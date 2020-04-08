import { shallowMount, createLocalVue } from '@vue/test-utils'
import TeacherEmailTemplates from './TeacherEmailTemplates.vue'
import Accordion from '@/components/element/Accordion'
import AccordionModal from '@/components/template/AccordionModal'
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
import Buefy from 'buefy'
import Blur from '@/mixins/Blur'

const localVue = createLocalVue()
localVue.use(Buefy, {
  defaultIconPack: 'fas',
})
localVue.filter('currency', jest.fn())

const program = {
  id: 7,
  event_name: 'event name',
  due_date: new Date(),
  unit: {
    domain: 'test.funrun.com',
  },
  registration_code: 123456,
}

const teacher_email_templates = {
  english: {
    team_day_email: {
      title: 'Team Day Email',
    },
    team_day_two_email: {
      title: 'Team Day 2 Email',
    },
    weekend_challenge_email: {
      title: 'Weekend Challenge Email',
    },
    day_before_funrun_email: {
      title: 'Day Before Event Email',
    },
    day_after_funrun_email: {
      title: 'Day After Event Email',
    },
  },
  spanish: {
    team_day_email: {
      title: 'Spanish Team Day Email',
    },
    team_day_two_email: {
      title: 'Spanish Team Day 2 Email',
    },
    weekend_challenge_email: {
      title: 'Spanish Weekend Challenge Email',
    },
    day_before_funrun_email: {
      title: 'Spanish Day Before Event Email',
    },
    day_after_funrun_email: {
      title: 'Spanish Day After Event Email',
    },
  },
}

const $store = {
  state: {
    User: {
      programs: [
        program,
      ],
      class_pledge_total: 1200,
    },
    lang: {
      teacher_email_templates: teacher_email_templates,
    },
  },
}

describe('TeacherEmailTemplates', () => {
  it('Snapshop test for TeacherEmailTemplates for English emails', () => {
    const wrapper = shallowMount(TeacherEmailTemplates, {
      localVue,
      mixins: {
        Blur,
      },
      mocks: {
        $store,
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
      propsData: {
        language: 'english',
        program: program,
      },
    })
    expect(wrapper).toMatchSnapshot()
  })

  it('Snapshop test for TeacherEmailTemplates for Spanish emails', () => {
    const wrapper = shallowMount(TeacherEmailTemplates, {
      localVue,
      mixins: {
        Blur,
      },
      mocks: {
        $store,
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
      propsData: {
        language: 'spanish',
        program: program,
      },
    })
    expect(wrapper).toMatchSnapshot()
  })
})
