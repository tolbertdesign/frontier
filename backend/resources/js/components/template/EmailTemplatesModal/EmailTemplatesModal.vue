<template>
  <AccordionModal
    :header="lang.emails_we_send"
    class="mx-4"
  >
    <template>
      <Accordion
        v-for="(template, index) in templates"
        :key="template.id"
        :open="template.isOpen"
        animation="zoom-out"
        @open="openAndCloseOthers(index)"
      >
        <template slot="title">
          <p class="text-sm sm:text-base md:text-lg text-left">
            <span class="font-semibold">{{ template.id }}. {{ template.name }}</span><br>
            {{ template.snippet }}
          </p>
        </template>
        <template>
          <div class="modal-card-body bg-white p-4 md:p-6 text-sm sm:text-base md:text-lg">
            <p class="mb-4">
              {{ lang.sponsor_name }},
            </p>
            <p class="mb-4">
              {{
                parseLanguage(
                  lang.template,
                  {
                    event_name: program.event_name,
                    names: formattedNames,
                    is_are: isAre,
                    funds_raised_for: program.microsite.funds_raised_for,
                    unit_name: program.unit.name,
                    plural_unit_name: program.unit.name_plural,
                    pledge_goal: participant.profile.pledge_goal | currency,
                    unit_modifier: program.unit.modifier,
                  }
                )
              }}
            </p>
            <p class="mb-4">
              <a :href="template.link">
                {{ parseLanguage(lang.click_here_reach_for_greatness, { names: formattedNames }) }}
              </a>
            </p>
            <p class="mb-4">
              {{ lang.thanks_so_much }}
            </p>
            <p class="mb-4">
              - {{ user.first_name }}
            </p>
          </div>
        </template>
      </Accordion>
    </template>
    <template slot="footer">
      <AddContactsButtons />
    </template>
  </AccordionModal>
</template>

<script>
import AddContactsButtons from '@/components/template/AddContactsButtons'
import Accordion from '@/components/element/Accordion'
import AccordionModal from '@/components/template/AccordionModal'
import Blur from '@/mixins/Blur'

export default {
  name: 'EmailTemplatesModal',
  components: {
    AddContactsButtons,
    Accordion,
    AccordionModal,
  },
  mixins: [Blur],
  data () {
    return {
      EE_ENROLLMENT: 6,
      EE_DAY_BEFORE: 7,
      EE_DAY_AFTER: 8,
    }
  },
  computed: {
    lang () {
      return this.$store.state.lang
    },
    templates () {
      return [
        {
          id: 1,
          name: 'After Contact is Added',
          snippet: 'Subject: Help ' + this.formattedNames + ' in the ' + this.program.event_name,
          isOpen: false,
          link: this.enrollmentLink,
        },
        {
          id: 2,
          name: 'One Day Before The Event',
          snippet: 'Subject: Help ' + this.formattedNames + ' in the ' + this.program.event_name,
          isOpen: false,
          link: this.dayBeforeLink,
        },
        {
          id: 3,
          name: 'One Day Before Event Ends',
          snippet: 'Subject: Help ' + this.formattedNames + ' in the ' + this.program.event_name,
          isOpen: false,
          link: this.dayAfterLink,
        },
      ]
    },
    enrollmentLink () {
      let link = ''
      this.participant.special_urls.forEach(specialUrl => {
        if (specialUrl.referrer.id === this.EE_ENROLLMENT) {
          link = '/a/s/' + specialUrl.short_key
        }
      })
      return link
    },
    dayBeforeLink () {
      let link = ''
      this.participant.special_urls.forEach(specialUrl => {
        if (specialUrl.referrer.id === this.EE_DAY_BEFORE) {
          link = '/a/s/' + specialUrl.short_key
        }
      })
      return link
    },
    dayAfterLink () {
      let link = ''
      this.participant.special_urls.forEach(specialUrl => {
        if (specialUrl.referrer.id === this.EE_DAY_AFTER) {
          link = '/a/s/' + specialUrl.short_key
        }
      })
      return link
    },
    participants () {
      return this.program.participants
    },
    participant () {
      return this.participants.find(participant => {
        return participant.id === parseInt(this.$route.params.participantUserId)
      })
    },
    user () {
      return this.$store.state.User
    },
    program () {
      return this.user.programs.find(program => {
        return program.participants.find(participant => participant.id === parseInt(this.$route.params.participantUserId)) !== undefined
      })
    },
    participantLength () {
      return this.participants.length
    },
    formattedNames () {
      let names = ''
      if (this.participantLength > 2) {
        this.participants.forEach((participant, index) => {
          // Check if is last participant
          if (index + 1 === this.participantLength) {
            names += 'and ' + participant.first_name
          } else {
            names += participant.first_name + ', '
          }
        })
      } else if (this.participantLength === 2) {
        names = this.participants[0].first_name + ' & ' + this.participants[1].first_name
      } else if (this.participantLength === 1) {
        names = this.participants[0].first_name
      }

      return names
    },
    isAre () {
      if (this.participantLength > 1) {
        return 'are'
      }

      return 'is'
    },
  },
  methods: {
    openAndCloseOthers (index) {
      this.templates.forEach(template => {
        template.isOpen = false
      })
      this.templates[index].isOpen = true
    },
    closeModal () {
      this.$emit('close')
      this.unBlur()
    },
  },
}
</script>
