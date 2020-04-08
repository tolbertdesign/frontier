import { shallowMount, createLocalVue } from '@vue/test-utils'
import NotificationAccordionModal from './NotificationAccordionModal.vue'
import AccordionModal from '@/components/template/AccordionModal'
import Accordion from '@/components/element/Accordion'
import Blur from '@/mixins/Blur'

const localVue = createLocalVue()

const id = 1
const read_at = '2020-01-01 00:00:00'
const clean_html_message = 'clean HTML message'
const type = 'type'
const program_id = 10
const notification = {
  id: id,
  program_id: program_id,
  read_at: read_at,
  clean_html_message: clean_html_message,
  type: type,
}
const notification2 = {
  id: 3,
  program_id: program_id,
  read_at: null,
  clean_html_message: clean_html_message,
  type: type,
  $storeActionCalled: null,
}
const notifications = [
  notification,
]
const eventName = 'event name'
const program = {
  id: program_id,
  event_name: eventName,
}
const $store = {
  state: {
    lang: {
      alerts: 'alerts',
      program_alert: 'program_alert',
    },
    notification: {
      TYPE_PROGRAM: type,
      notifications: [notification],
    },
    User: {
      programs: [program],
    },
  },
  getters: {
    isRead: jest.fn(() => false),
    sortNotificationsByProgramId: jest.fn(id => [notification]),
  },
  dispatch: jest.fn((name, notification) => {
    notification.$storeActionCalled = name
    return notification
  }),
  actions: {
    readNotification: jest.fn(),
  },
}

describe('NotificationAccordionModal', () => {
  it('Snapshop test for NotificationAccordionModal with notifications', () => {
    const wrapper = shallowMount(NotificationAccordionModal, {
      localVue,
      mixins: {
        Blur,
      },
      components: {
        Accordion,
        AccordionModal,
      },
      mocks: {
        $store,
      },
      propsData: {
        program: program,
      },
    })
    expect(wrapper).toMatchSnapshot()
  })

  it('Snapshop test for NotificationAccordionModal without notifications', () => {
    const wrapper = shallowMount(NotificationAccordionModal, {
      localVue,
      mixins: {
        Blur,
      },
      components: {
        Accordion,
        AccordionModal,
      },
      mocks: {
        $store,
      },
      propsData: {
        program: program,
      },
    })
    expect(wrapper).toMatchSnapshot()
  })

  it('Snapshop test for NotificationAccordionModal without event name', () => {
    const wrapper = shallowMount(NotificationAccordionModal, {
      localVue,
      mixins: {
        Blur,
      },
      components: {
        Accordion,
        AccordionModal,
      },
      mocks: {
        $store,
      },
      propsData: {
        program: program,
      },
    })
    expect(wrapper.vm.header).toBe($store.state.lang.notifications)
    expect(wrapper).toMatchSnapshot()
  })

  it('Snapshop test for NotificationAccordionModal with unread notification', () => {
    notification.read_at = null
    const wrapper = shallowMount(NotificationAccordionModal, {
      localVue,
      mixins: {
        Blur,
      },
      components: {
        Accordion,
        AccordionModal,
      },
      mocks: {
        $store,
      },
      propsData: {
        program: program,
      },
    })
    expect(wrapper).toMatchSnapshot()
  })

  it('calculates title correctly from the program', () => {
    const wrapper = shallowMount(NotificationAccordionModal, {
      localVue,
      mixins: {
        Blur,
      },
      components: {
        Accordion,
        AccordionModal,
      },
      mocks: {
        $store,
      },
      propsData: {
        program: program,
      },
    })
    expect(wrapper.vm.getTitle(notification)).toBe($store.state.User.programs[0].event_name)
  })

  it('calls notification action readNotification on created when only one notification in array', () => {
    notifications[0].$storeActionCalled = null
    const wrapper = shallowMount(NotificationAccordionModal, {
      localVue,
      mixins: {
        Blur,
      },
      components: {
        Accordion,
        AccordionModal,
      },
      mocks: {
        $store,
      },
      propsData: {
        program: program,
      },
    })

    wrapper.vm.updateNotification(notifications[0])
    expect(notifications[0].$storeActionCalled).toBe('readNotification')
  })

  it('calls notification action readNotification when notification is read', () => {
    notifications[0].$storeActionCalled = null
    $store.state.notification.notifications.push(notification2)
    const wrapper = shallowMount(NotificationAccordionModal, {
      localVue,
      mixins: {
        Blur,
      },
      components: {
        Accordion,
        AccordionModal,
      },
      mocks: {
        $store,
      },
      propsData: {
        program: program,
      },
    })
    expect(notifications[0].$storeActionCalled).toBe(null)
    wrapper.vm.updateNotification(notifications[0])
    expect(notifications[0].$storeActionCalled).toBe('readNotification')
  })
})
