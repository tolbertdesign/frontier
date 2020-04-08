import { shallowMount, createLocalVue } from '@vue/test-utils'
import SchoolSearch from './SchoolSearch.vue'

const localVue = createLocalVue()

const searchUrl = 'Sales'
const schoolUrl = 'School-URL'
const lang = {
  school_search_header: 'school search header',
  placeholder_school_search: 'placeholder school search',
  search_help_1: 'search help 1',
  search_help_2: 'search help 2',
  search_help_3: 'search help 3',
}

describe('SchoolSearch', () => {
  it('Snapshop test for SchoolSearch', () => {
    const wrapper = shallowMount(SchoolSearch, {
      localVue,
      propsData: {
        errors: [],
        searchUrl: searchUrl,
        schoolUrl: schoolUrl,
        lang: lang,
      },
    })
    expect(wrapper).toMatchSnapshot()
  })
})
