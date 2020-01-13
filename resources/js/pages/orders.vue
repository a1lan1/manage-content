<template>
  <b-card
    class="shadow"
    header-tag="header"
    footer-tag="footer"
  >
    <template v-slot:header>
      <b-row>
        <b-col cols="12" class="text-right">
          <b-form-group class="mb-0">
            <b-form-select
              v-model="perPage"
              size="sm"
              :options="pageOptions"
            />
          </b-form-group>
        </b-col>
      </b-row>
    </template>

    <template v-slot:footer>
      <b-row v-if="orders && orders.length > perPage">
        <b-col>
          <b-pagination
            v-model="currentPage"
            :total-rows="totalRows"
            :per-page="perPage"
            align="fill"
            size="sm"
            class="my-0"
          />
        </b-col>
      </b-row>
    </template>

    <b-container fluid>
      <b-alert
        :variant="alert.type"
        dismissible
        fade
        :show="alert.show"
        class="mt-3"
        @dismissed="alert.show = false"
      >
        {{ alert.text }}
      </b-alert>

      <b-table
        v-if="!showEditForm"
        show-empty
        small
        stacked="md"
        :items="orders"
        :fields="fields"
        :current-page="currentPage"
        :per-page="perPage"
        :sort-by.sync="sortBy"
        :sort-desc.sync="sortDesc"
        :sort-direction="sortDirection"
      >
        <template v-slot:cell(name)="row">
          {{ row.item.firstname }} {{ row.item.secondname }}
        </template>

        <template v-slot:cell(actions)="row">
          <b-button size="sm" @click="row.toggleDetails">
            {{ row.detailsShowing ? 'Hide' : 'Show' }}
          </b-button>

          <b-button variant="success" size="sm" @click="editOrder(row.item.id)">
            Edit
          </b-button>

          <b-button variant="danger" size="sm" @click="deleteOrder(row.item.id)">
            Delete
          </b-button>
        </template>

        <template v-slot:row-details="row">
          <b-card>
            <ul>
              <li v-for="(value, key) in row.item" :key="key">
                {{ key }}: {{ value }}
              </li>
            </ul>
          </b-card>
        </template>
      </b-table>
      <b-form v-else>
        <b-form-group
          label="First name:"
          label-for="input-1"
        >
          <b-form-input
            id="input-1"
            v-model="order.firstname"
            type="text"
            required
            placeholder="Enter firstname"
          />
        </b-form-group>

        <b-form-group
          id="input-group-2"
          label="Second name:"
          label-for="input-2"
        >
          <b-form-input
            id="input-2"
            v-model="order.secondname"
            type="text"
            required
            placeholder="Enter secondname"
          />
        </b-form-group>

        <b-form-group
          id="input-group-3"
          label="Email address:"
          label-for="input-3"
        >
          <b-form-input
            id="input-3"
            v-model="order.email"
            type="email"
            required
            placeholder="Enter email"
          />
        </b-form-group>

        <b-form-group
          id="input-group-4"
          label="Phone:"
          label-for="input-4"
        >
          <b-form-input
            id="input-4"
            v-model="order.phone"
            type="text"
            required
            placeholder="Enter phone"
          />
        </b-form-group>

        <b-form-group
          id="input-group-5"
          label="Education:"
          label-for="input-5"
        >
          <b-form-select
            id="input-5"
            v-model="order.education"
            :options="educationList"
            required
          />
        </b-form-group>

        <b-form-group
          label="ip:"
          label-for="input-6"
        >
          <b-form-input
            id="input-6"
            v-model="order.ip"
            type="text"
            required
            placeholder="ip"
          />
        </b-form-group>

        <b-form-group
          label="User agent:"
          label-for="input-7"
        >
          <b-form-input
            id="input-7"
            v-model="order.agent"
            type="text"
            required
            placeholder="User agent"
          />
        </b-form-group>

        <b-button
          variant="primary"
          @click="saveOrder"
        >
          Сохранить
        </b-button>
      </b-form>
    </b-container>
  </b-card>
</template>

<script>
export default {
  middleware: 'admin',
  name: 'Orders',
  data () {
    return {
      order: {},
      showEditForm: false,
      alert: {
        show: false,
        type: 'info',
        text: ''
      },
      educationList: [
        { text: 'Level of education', value: null },
        { text: 'Bachelor', value: 1 },
        { text: 'Master', value: 2 },
        { text: 'PhD', value: 3 }
      ],
      fields: [
        { key: 'name', label: 'Person', sortable: true },
        { key: 'email', label: 'email', sortable: true },
        { key: 'actions', label: 'Actions' }
      ],
      currentPage: 1,
      perPage: 10,
      pageOptions: [10, 25, 50],
      sortBy: '',
      sortDesc: false,
      sortDirection: 'asc'
    }
  },
  computed: {
    totalRows () {
      return this.orders ? this.orders.length : 0
    },
    orders: function () {
      return this.$store.state.user.orders
    }
  },
  created () {
    this.$store.dispatch('user/getOrders')
  },
  methods: {
    editOrder (id) {
      this.showEditForm = true
      this.order = this.orders.find(order => order.id === id)
    },
    saveOrder () {
      this.$store.dispatch('user/storeOrder', this.order)
        .then((response) => {
          if (response.status === 200) {
            this.showEditForm = false
            this.messageAlert('success', 'Данные успешно сохранены!')
          } else {
            this.messageAlert('danger', response.data)
          }
        })
    },
    deleteOrder (id) {
      this.$store.dispatch('user/deleteOrder', { id: id })
    },
    messageAlert (type, text) {
      this.alert.show = true
      this.alert.type = type
      this.alert.text = text
    }
  }
}
</script>
