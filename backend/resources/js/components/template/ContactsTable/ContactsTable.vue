<template>
  <section>
    <div class="contacts-table px-4 pb-4">
      <div class="border border-transparent pl-3 pb-1">
        <div
          v-if="allSelected"
          class="pb-5"
        >
          <div class="text-center">
            <button
              :disabled="noSponsorsSelected"
              class="w-64 button px-10 font-semibold is-rounded is-secondary shadow"
              @click="emailPreviousSponsors"
            >{{ lang.email_previous_sponsors }}</button>
          </div>
        </div>
        <BCheckbox
          v-if="contacts.length"
          :value="allSponsorsSelected"
          type="is-secondary"
          @change.native="toggleSelectAll"
        >
          <span class="inline-block pl-2 sm:pl-3">
            {{ allSponsorsSelected ? lang.unselect_all : lang.select_all }}
          </span>
        </BCheckbox>
      </div>

      <table class="table is-fullwidth border">
        <!-- Show contacts header, if there are any -->
        <thead v-if="contacts.length">
          <tr class="bg-secondary text-white">
            <th colspan="2">
              {{ lang.contact }}
            </th>
            <th>{{ lang.status }}</th>
            <th>
              <FontAwesomeIcon
                v-if="!isEditing"
                :icon="['far', 'user-edit']"
                class="cursor-pointer"
                @click="isEditing = true"
              />
              <button
                v-else
                class="button is-secondary is-inverted is-small"
                @click="isEditing = false"
              >
                <span>Close</span>
                <span class="icon">
                  <FontAwesomeIcon :icon="['fas', 'times']" />
                </span>
              </button>
            </th>
          </tr>
        </thead>

        <!-- Show the contacts, if we have them  -->
        <tbody v-if="contacts.length">
          <tr
            v-for="(contact, index) in getContactsSorted"
            :key="index"
          >
            <td class="align-middle">
              <BCheckbox
                v-if="contact.isSelectable"
                :value="contact.isSelected"
                type="is-secondary"
                class="custom"
                @change.native="selectContact(contact.id)"
              />
            </td>
            <td class="w-full">
              <div class="flex-1 sm:flex items-center justify-between">
                <div class="flex-1">
                  {{ contact.first_name }} {{ contact.last_name }}
                  <br>
                  {{ contact.email }}
                </div>
                <div
                  v-if="contact.isPreviousSponsor"
                  class="italic font-semibold has-text-secondary sm:pr-10"
                >
                  {{ lang.previous_sponsor }}
                </div>
              </div>
            </td>
            <td>{{ translateStatus(contact.status) }}</td>
            <td class="text-center align-middle">
              <FontAwesomeIcon
                v-if="isEditing"
                :icon="['fas', 'trash-alt']"
                @click="removeContact(contact)"
              />
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </section>
</template>

<script>
import RemoveContactModal from '@/components/template/RemoveContactModal'
import EmailPreviousSponsorsModal from '@/components/template/EmailPreviousSponsorsModal'
import { PledgingStatus } from '@/utilities/PledgingStatus'
import Blur from '@/mixins/Blur'

export default {
  name: 'ContactsTable',
  mixins: [Blur],
  props: {
    allSelected: {
      type: Boolean,
      default: true,
    },
    contacts: {
      type: Array,
      default: null,
    },
    participantUserId: {
      type: Number,
      default: null,
    },
  },
  data () {
    return {
      isEditing: false,
    }
  },
  computed: {
    lang () {
      return this.$store.state.lang
    },
    previousSponsors () {
      return this.contacts.filter(contact => contact.isPreviousSponsor)
    },
    previousSelectedSponsors () {
      return this.previousSponsors.filter(contact => contact.isSelected)
    },
    noSponsorsSelected () {
      return this.previousSponsors.filter(contact => contact.isSelected).length === 0
    },
    allSponsorsSelected () {
      const numOfPreviousSponsors = this.previousSponsors.filter(contact => contact.isSelectable).length
      return this.previousSponsors.filter(contact => contact.isSelected).length === numOfPreviousSponsors
    },
    getContactsSorted () {
      const sortedContacts = []

      this.contacts.forEach(function (contact, index) {
        sortedContacts.push(Object.assign({}, contact))
      })

      return sortedContacts.sort(this.sortContact)
    },
  },
  methods: {
    sortContact (contactA, contactB) {
      const statusSortResult = this.sortStatusCompare(contactA.status, contactB.status)

      if (statusSortResult !== 0) {
        return statusSortResult
      }

      if (contactA.first_name && contactB.first_name) {
        const firstNameSortResult = this.sortStringCompare(contactA.first_name, contactB.first_name)

        if (firstNameSortResult !== 0) {
          return firstNameSortResult
        }
      }

      if (contactA.last_name && contactB.last_name) {
        const lastNameSortResult = this.sortStringCompare(contactA.last_name, contactB.last_name)

        if (lastNameSortResult !== 0) {
          return lastNameSortResult
        }
      }

      const emailSortResult = this.sortStringCompare(contactA.email, contactB.email)

      if (emailSortResult !== 0) {
        return emailSortResult
      }

      return -1
    },
    sortStringCompare (stringOne, stringTwo) {
      var firstNameA = stringOne.toLowerCase().trim()
      var firstNameB = stringTwo.toLowerCase().trim()

      if (firstNameA > firstNameB) {
        return 1
      } else if (firstNameA < firstNameB) {
        return -1
      } else {
        return 0
      }
    },
    sortStatusCompare (statusOne, statusTwo) {
      statusOne = statusOne.toLowerCase().trim()
      statusTwo = statusTwo.toLowerCase().trim()

      if (statusOne === statusTwo) {
        return 0
      }

      const statusOrder = Object.keys(PledgingStatus).map(function (key) {
        return PledgingStatus[key].toLowerCase()
      })

      return statusOrder.indexOf(statusOne) - statusOrder.indexOf(statusTwo)
    },
    addContact (contact) {
      this.contacts.push(contact)
    },
    selectContact (contactId) {
      const contact = this.contacts.find(contact => contact.id === contactId)
      contact.isSelected = !contact.isSelected
    },
    toggleSelectAll () {
      const isSelected = !this.allSponsorsSelected
      this.contacts.filter(contact => contact.isSelectable).forEach(contact => {
        contact.isSelected = isSelected
      })
    },
    removeContact (contact) {
      this.$buefy.modal.open({
        parent: this,
        component: RemoveContactModal,
        hasModalCard: true,
        width: 320,
        onCancel: this.unBlur,
        props: {
          contact,
        },
      })
      this.blur()
      this.isEditing = false
    },
    translateStatus (statusText) {
      return this.lang.easy_emailer_status[statusText.toLowerCase()]
    },
    convertPreviousToPotentialSponsors (sponsorIds, status) {
      this.contacts.forEach(contact => {
        if (sponsorIds.indexOf(contact.id) !== -1 && contact.isPreviousSponsor) {
          contact.status = status
          contact.isSelectable = false
          contact.isSelected = false
        }
      })
    },
    emailPreviousSponsors () {
      this.$buefy.modal.open({
        parent: this,
        component: EmailPreviousSponsorsModal,
        hasModalCard: true,
        onCancel: this.unBlur,
        props: {
          previousSponsors: this.previousSelectedSponsors,
          participantUserId: this.participantUserId,
        },
        events: {
          previousSponsorsEmailed: (emailedSponsorIds, skippedSponsorIds) => {
            this.convertPreviousToPotentialSponsors(emailedSponsorIds, PledgingStatus.ACTIVE)
            this.convertPreviousToPotentialSponsors(skippedSponsorIds, PledgingStatus.UNSUBSCRIBED)
          },
        },
      })
      this.blur()
    },
  },
}
</script>

<style>
.table thead td,
.table thead th {
  color: #ffffff;
}
.table td,
.table th {
  vertical-align: middle;
}
.table thead th {
  height: 4em;
}
.b-checkbox.checkbox.custom .control-label {
  padding-left: 0;
}
td.checkbox-cell label.is-disabled {
  display: none;
}
</style>
