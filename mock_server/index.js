export const User = {
  id: 1,
  first_name: 'Roosevelt',
  last_name: 'Franklin',
  programs: [],
  participants: [
    {
      id: 1,
      first_name: 'first',
      last_name: 'sibling',
      email: 'p1@example.com',
      participant_info: {
        user_id: 1,
        family_pledging_enabled: 0,
        pledges: [
          {
            id: 1,
            amount: 10,
            participant_user_id: 1,
            family_pledge_id: 1,
            pledge_status_id: 1,
            pledge_type_id: 1,
            payment_id: null,
          },
        ],
        classroom: {
          id: 1,
          grade: {
            id: 1,
            name: '1st Grade',
          },
          group: {
            program_id: 1,
            program: {
              id: 1,
              name: '',
              archived: 0,
              deleted: 0,
              program_pledge_setting: {
                family_pledging_enabled: 1,
              },
              microsite: {
                microsite_color_theme: {
                  theme_name: '',
                },
              },
              unit: {},
              unit_range_low: 30,
              unit_range_high: 35,
            },
          },
        },
        potential_sponsor: {
          email: 'ps1@example.com',
        },
      },
      school: {
        id: 1,
        name: 'Roosevelt Franklin Elementary School',
      },
    },
  ],
}

export default User

// Roosevelt Franklin
// Harvey Kneeslapper
// Professor Hastings
// Don Music
// Herbert Birdsfoot
// Kermit the Frog
// Bruno the Trashman
