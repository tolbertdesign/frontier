export const $store = {
  state: {
    lang: {
      is_required: true,
      pledge_info: {},
      edit_participant: {
        upload_photo: '',
        form_title: '',
        first_name_label: '',
        first_name_placeholder: '',
        last_name_label: '',
        last_name_placeholder: '',
        classroom_label: '',
        family_pledging_header: '',
        family_pledging_message: '',
        pledge_goal: 'Pledge Goal',
        goal_amount: 'Goal Amount',
        pledge_message: 'Pledge Message',
        bold: 'Bold',
        italic: 'Italic',
        underline: 'Underline',
        save: 'Save',
        cancel: 'Cancel',
        view_agreement: 'View Agreement',
        delete: 'Delete',
        default_pledge_page_message: 'Our school is hosting a fundraiser to raise funds for :funds_raised_for - but we need your help! At the finale of our fundraiser on :event_date, each student will complete :unit_type in the :event_name to help our school. Will you consider making a pledge to support our education? Click "<a href=":link"><b><u>Enter Pledge</u></b></a>" to start!',
      },
    },
  },
  getters: {
    avatarPath: '',
    programParticipantCount: (programId) => 1,
  },
  gtag: jest.fn(),
}
export const $v = {
  form: {
    first_name: '',
    last_name: '',
    pledge_goal: {
      $model: '',
    },
  },
}

export const participant = {
  first_name: 'Participant',
  last_name: 'User',
  participant_info: {
    classroom: {
      group: {
        program: {
          program_pledge_setting: {
            family_pledging_enabled: 1,
            flat_donate_only: 0,
          },
          microsite: {
            funds_raised_for: 'New technology',
          },
          fun_run: '01-10-2010 01:10:50',
        },
      },
    },
    family_pledging_enabled: true,
  },
  profile: {
    pledge_goal: '',
    pledge_page_text: '',
    image_name: '',
  },
}

export const participantFlatDonateOnly = {
  first_name: 'Participant',
  last_name: 'User',
  participant_info: {
    classroom: {
      group: {
        program: {
          program_pledge_setting: {
            family_pledging_enabled: 1,
            flat_donate_only: 1,
          },
          microsite: {
            funds_raised_for: 'New technology',
          },
          fun_run: '01-10-2010 01:10:50',
        },
      },
    },
    family_pledging_enabled: true,
  },
  profile: {
    pledge_goal: '',
    pledge_page_text: '',
    image_name: '',
  },
}

export const settings = {
  unit: {
    modifier: 'per',
    name: 'reading challenge',
  },
  unitRangeLow: '30',
  unitRangeHigh: '35',
}
export const $vInvalid = {
  form: {
    first_name: {
      $invalid: true,
    },
    last_name: {
      $invalid: true,
    },
    pledge_goal: {
      $invalid: true,
    },
  },
}

export default {
  $store,
  $v,
  participant,
  participantFlatDonateOnly,
  settings,
}
