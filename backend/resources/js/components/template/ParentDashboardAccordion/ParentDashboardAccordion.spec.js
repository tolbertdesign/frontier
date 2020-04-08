import { shallowMount, createLocalVue } from '@vue/test-utils'
import ParentDashboardAccordion from './ParentDashboardAccordion.vue'
import Accordion from '@/components/element/Accordion'

const localVue = createLocalVue()

describe('ParentDashboardAccordion', () => {
  let program = {}

  window.matchMedia = jest.fn().mockImplementation(query => {
    return {
      matches: false,
      media: query,
      onchange: null,
      addListener: jest.fn(),
      removeListener: jest.fn(),
    }
  })

  beforeEach(() => {
    program = {
      participants: [
        {
          profile: {
            image_name: null,
          },
          participant_info: {
            pledges: [],
          },
        },
      ],
      microsite: {
        school_image_name: 'School',
      },
      ssv_disabled: 0,
    }
  })

  it('is a Vue instance', () => {
    const wrapper = shallowMount(ParentDashboardAccordion, {
      localVue,
      components: {
        Accordion,
      },
      propsData: { program },
    })
    expect(wrapper.isVueInstance()).toBeTruthy()
  })

  it('it renders correctly', () => {
    const wrapper = shallowMount(ParentDashboardAccordion, {
      localVue,
      components: {
        Accordion,
      },
      propsData: { program },
    })
    expect(wrapper.html()).toMatchSnapshot()
  })

  it('it renders correctly with ssv_disabled turned on', () => {
    program.ssv_disabled = 1
    const wrapper = shallowMount(ParentDashboardAccordion, {
      localVue,
      components: {
        Accordion,
      },
      propsData: { program },
    })
    expect(wrapper.html()).toMatchSnapshot()
  })

  it('it hides number in title for 0 pledge', () => {
    const wrapper = shallowMount(ParentDashboardAccordion, {
      localVue,
      components: {
        Accordion,
      },
      propsData: { program },
    })
    expect(wrapper.vm.pledgeInfoTitle()).toBe('Pledges')
  })

  it('it shows number in title for 1 pledge', () => {
    addPledge(1)

    const wrapper = shallowMount(ParentDashboardAccordion, {
      localVue,
      components: {
        Accordion,
      },
      propsData: { program },
    })
    expect(wrapper.vm.pledgeInfoTitle()).toBe('Pledges (1)')
  })

  it('it counts 0 pledge', () => {
    const wrapper = shallowMount(ParentDashboardAccordion, {
      localVue,
      components: {
        Accordion,
      },
      propsData: { program },
    })
    expect(wrapper.vm.pledgesCount()).toBe(0)
  })

  it('it counts 1 pledge', () => {
    addPledge(1)
    const wrapper = shallowMount(ParentDashboardAccordion, {
      localVue,
      components: {
        Accordion,
      },
      propsData: { program },
    })
    expect(wrapper.vm.pledgesCount()).toBe(1)
  })

  it('it counts 2 pledge', () => {
    addPledge(1)
    addPledge(2)
    const wrapper = shallowMount(ParentDashboardAccordion, {
      localVue,
      components: {
        Accordion,
      },
      propsData: { program },
    })
    expect(wrapper.vm.pledgesCount()).toBe(2)
  })

  it('it counts 3 pledge', () => {
    addPledge(1)
    addPledge(2)
    addPledge(3)
    const wrapper = shallowMount(ParentDashboardAccordion, {
      localVue,
      components: {
        Accordion,
      },
      propsData: { program },
    })
    expect(wrapper.vm.pledgesCount()).toBe(3)
  })

  it('it counts family pledges', () => {
    addPledge(1)
    addPledge(2, 'bestfamily')
    addPledge(3, 'bestfamily')
    const wrapper = shallowMount(ParentDashboardAccordion, {
      localVue,
      components: {
        Accordion,
      },
      propsData: { program },
    })
    expect(wrapper.vm.pledgesCount()).toBe(2)
  })

  const addPledge = (id, familyPledgeId = null) => {
    program.participants[0].participant_info.pledges.push(
      {
        id: id,
        family_pledge_id: familyPledgeId,
      },
    )
  }
})
