<template>
  <b-card
    class="shadow"
    header-tag="header"
    footer-tag="footer"
  >
    <template v-slot:header>
      <b-row>
        <b-col cols="12">
          Events
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
        show-empty
        small
        stacked="md"
        :items="items"
        :fields="fields"
      >
        <template v-slot:cell(image)="row">
          <img
            v-lazy="row.value"
            class="rounded"
            style="height: 50px"
            :alt="row.title"
          >
        </template>

        <template v-slot:cell(actions)="row">
          <b-button size="sm" @click="row.toggleDetails">
            {{ row.detailsShowing ? 'Hide' : 'Show' }}
          </b-button>

          <b-button variant="danger" size="sm" @click="deleteEvent(row.item.id)">
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
  name: 'Events',
  data () {
    return {
      event: {},
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
        { key: 'id' },
        { key: 'image' },
        { key: 'title', label: 'Title', sortable: true },
        { key: 'actions', label: 'Actions' }
      ],
      currentPage: 1,
      totalRows: 0,
      perPage: 10
    }
  },
  computed: {
    ...mapGetters({
      data: 'user/events'
    }),
    items () {
      return this.data ? this.data.data : []
    }
  },
  created () {
    this.getEvents()
  },
  beforeDestroy () {
    this.$store.dispatch('user/resetEvents')
  },
  methods: {
    getEvents () {
      this.$store.dispatch('user/getUserEvents', this.currentPage)
        .then(() => this.setPaginate())
    },
    deleteEvent (id) {
      this.$store.dispatch('user/deleteEvent', { id: id })
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
