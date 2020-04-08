<template>
  <div class="contacts">
    <!-- https://medium.com/swlh/how-to-use-async-and-await-with-vue-js-apps-33132aa0838b -->
    <div class="center">
      <h1>Address Book Home</h1>
    </div>
    <table>
      <tr>
        <th>ID</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Address Line 1</th>
        <th>Address Line 2</th>
        <th>City</th>
        <th>Country</th>
        <th>Postal Code</th>
        <th>Gender</th>
        <th>Age</th>
        <th>Email</th>
        <th />
        <th />
      </tr>

      <tr v-for="c in contacts" :key="c.id">
        <td>{{ c.id }}</td>
        <td>{{ c.firstName }}</td>
        <td>{{ c.lastName }}</td>
        <td>{{ c.addressLineOne }}</td>
        <td>{{ c.addressLineTwo }}</td>
        <td>{{ c.city }}</td>
        <td>{{ c.country }}</td>
        <td>{{ c.postalCode }}</td>
        <td>{{ c.gender }}</td>
        <td>{{ c.age }}</td>
        <td>{{ c.email }}</td>
        <td>
          <button class="md-primary" @click="selectedContactId = c.id; showDialog = true">
            Edit
          </button>
        </td>
        <td>
          <button class="md-accent" @click="removeContact(c.id)">
            Delete
          </button>
        </td>
      </tr>
    </table>
    <!-- <md-dialog :md-active.sync="showDialog">
      <md-dialog-content>
        <ContactForm
          :editing="true"
          :contactId="selectedContactId"
          @contactSaved="selectedContactId = undefined; showDialog = false"
        />
      </md-dialog-content>
    </md-dialog> -->
  </div>
</template>

<script>
import { contactMixin } from '@/mixins/contactMixin'
import ContactForm from '@/components/ContactForm.vue'

export default {
  name: 'ContactsPage',
  components: {
    ContactForm,
  },
  mixins: [contactMixin],
  props: {
    editing: Boolean,
    id: Number,
  },
  data () {
    return {
      showDialog: false,
      selectedContactId: undefined,
    }
  },
  computed: {
    contacts () {
      return this.$store.state.contacts
    },
  },
  beforeMount () {
    this.getAllContacts()
  },
  methods: {
    async getAllContacts () {
      try {
        const response = await this.getContacts()
        this.$store.commit('setContacts', response.data)
      } catch (ex) {
        console.log(ex)
      }
    },
    async removeContact (id) {
      try {
        await this.deleteContact(id)
        await this.getAllContacts()
      } catch (ex) {
        console.log(ex)
      }
    },
  },
}
</script>
