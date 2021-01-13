<template>
  <b-card
    class="shadow"
    header-tag="header"
    footer-tag="footer"
  >
    <template v-slot:header>
      <b-row>
        <b-col cols="12">
          Orders
        </b-col>
      </b-row>
    </template>

    <b-container>
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
        :items="items"
        :fields="fields"
      >
        <template v-slot:cell(name)="row">
          {{ row.item.firstname }} {{ row.item.secondname }}
        </template>

        <template v-slot:cell(actions)="row">
          <b-button size="sm" @click="row.toggleDetails">
            {{ row.detailsShowing ? 'Hide' : 'Show' }}
          </b-button>

          <b-button
            variant="success"
            size="sm"
            @click="editOrder(row.item.id)"
          >
            Edit
          </b-button>

          <b-button
            variant="danger"
            size="sm"
            @click="deleteOrder(row.item.id)"
          >
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
          :disabled="loading"
          @click="saveOrder"
        >
          <b-spinner v-if="loading" small type="grow" /> Сохранить
        </b-button>
      </b-form>
    </b-container>

    <template v-slot:footer>
      <b-row>
        <b-col>
          <b-pagination
            v-model="currentPage"
            :total-rows="totalRows"
            :per-page="perPage"
            align="center"
            size="sm"
            class="my-0"
            @change="paginationEvent"
          />
        </b-col>
      </b-row>
    </template>
  </b-card>
</template>

<script>
import { mapGetters } from 'vuex'

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
        { key: 'name', label: 'Person' },
        { key: 'email' },
        { key: 'phone' },
        { key: 'actions' }
      ],
      currentPage: 1,
      totalRows: 0,
      perPage: 10,
      loading: false
    }
  },
  computed: {
    ...mapGetters({
      data: 'user/orders'
    }),
    items () {
      return this.data ? this.data.data : []
    }
  },
  created () {
    this.getOrders()
  },
  beforeDestroy () {
    this.$store.dispatch('user/resetOrders')
  },
  methods: {
    getOrders () {
      this.$store.dispatch('user/getOrders', this.currentPage)
        .then(() => this.setPaginate())
    },
    editOrder (id) {
      this.showEditForm = true
      this.order = this.items.find(order => order.id === id)
    },
    saveOrder () {
      this.loading = true

      this.$store.dispatch('user/storeOrder', this.order)
        .then((response) => {
          if (response.status === 200) {
            this.showEditForm = false
            this.messageAlert('success', 'Данные успешно сохранены!')
          } else {
            this.messageAlert('danger', response.data)
          }
        })
        .finally(() => {
          this.loading = false
        })
    },
    deleteOrder (id) {
      this.$store.dispatch('user/deleteOrder', { id: id })
    },
    messageAlert (type, text) {
      this.alert.show = true
      this.alert.type = type
      this.alert.text = text
    },
    setPaginate () {
      this.totalRows = this.data.total
      this.currentPage = this.data.current_page
      this.perPage = this.data.per_page
    },
    paginationEvent (page) {
      this.currentPage = page
      this.getOrders()
    }
  }
}
</script>
