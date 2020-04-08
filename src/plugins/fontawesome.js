import Vue from 'vue'

import { library, dom } from '@fortawesome/fontawesome-svg-core'

// Brands (fab)
import { faFacebook, faFacebookF, faFacebookSquare, faTwitter } from '@fortawesome/free-brands-svg-icons'

// Regular (far)
import {
  faAddressCard,
  faArrowCircleRight,
  faBars as farBars,
  faCircle,
  faCommentAltLines,
  faEdit,
  faEnvelope,
  faInfoCircle,
  faLock,
  faSignIn,
  faSignOut,
  faSquare,
  faTimes as farTimes,
  faUserEdit as farUserEdit,
} from '@fortawesome/pro-regular-svg-icons'

// Light (fal)
import { faBars, faTimes, faUserEdit } from '@fortawesome/pro-light-svg-icons'

// Solid Style Icons (fas)
import {
  faBars as fasBars,
  faBell,
  faBold,
  faCaretDown,
  faCaretUp,
  faCheck,
  faCheckSquare,
  faChevronDown,
  faChevronUp,
  faCircle as fasCircle,
  faCode,
  faCoffee,
  faCog,
  faComment,
  faEdit as fasEdit,
  faEnvelope as fasEnvelope,
  faExclamationCircle,
  faExclamationTriangle,
  faEye,
  faItalic,
  faLink,
  faListOl,
  faListUl,
  faLock as fasLock,
  faMobileAlt,
  faParagraph,
  faPlayCircle,
  faQuestionCircle,
  faQuoteRight,
  faShare,
  faShareSquare,
  faSortDown,
  faSpinner,
  faStrikethrough,
  faTimes as fasTimes,
  faTrashAlt,
  faUnderline,
  faUser,
  faUserPlus,
} from '@fortawesome/free-solid-svg-icons'

import { FontAwesomeIcon, FontAwesomeLayers, FontAwesomeLayersText } from '@fortawesome/vue-fontawesome'

library.add(
  faAddressCard,
  faArrowCircleRight,
  faBars,
  faBell,
  faBold,
  faCaretDown,
  faCaretUp,
  faCheck,
  faCheckSquare,
  faChevronDown,
  faChevronUp,
  faCircle,
  faCode,
  faCoffee,
  faCog,
  faComment,
  faCommentAltLines,
  faEdit,
  fasEdit,
  faEnvelope,
  faExclamationCircle,
  faExclamationTriangle,
  faEye,
  faFacebook,
  faFacebookF,
  faFacebookSquare,
  faInfoCircle,
  faItalic,
  faLink,
  faListOl,
  faListUl,
  faLock,
  faMobileAlt,
  faParagraph,
  faPlayCircle,
  faQuestionCircle,
  faQuoteRight,
  farBars,
  farTimes,
  fasBars,
  fasCircle,
  fasEnvelope,
  faShare,
  faShareSquare,
  faSignIn,
  faSignOut,
  fasLock,
  faSortDown,
  faSpinner,
  faSquare,
  fasTimes,
  faStrikethrough,
  faTimes,
  faTrashAlt,
  faTwitter,
  faUnderline,
  faUser,
  faUserEdit,
  faUserPlus,
  farUserEdit,
)

dom.watch()

Vue.component('FontAwesomeIcon', FontAwesomeIcon)
Vue.component('FontAwesomeLayers', FontAwesomeLayers)
Vue.component('FontAwesomeLayersText', FontAwesomeLayersText)
