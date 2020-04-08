import _ from 'lodash'
import hasNumber from './hasNumber'
import hasLowercase from './hasLowercase'
import hasUppercase from './hasUppercase'

export default (password) => {
  // probably already handled by the required flag
  if (_.isNull(password) || !_.isString(password) || _.isEmpty(password)) {
    return false
  }

  // Minimum of 1 Lowercase Letter
  if (!hasLowercase(password)) {
    return false
  }

  // Minimum of 1 Uppercase Letter
  if (!hasUppercase(password)) {
    return false
  }

  // Minimum of 1 Number
  if (!hasNumber(password)) {
    return false
  }

  // Minimum of 6 Characters
  // separately targeting input length to provide specific error message
  return true
}
