import LanguageParser from './LanguageParser.js'

const lang = '<p>:test</p><div>:variable</div>'
const values = {
  test: 'new value',
  variable: 'another new value',
}
describe('LanguageParser', () => {
  it('A test for LanguageParser', () => {
    expect(LanguageParser.methods.parseLanguage(lang, values, false)).toBe('<p>new value</p><div>another new value</div>')
  })
})
