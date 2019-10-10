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
            <b-row v-if="events && events.length > perPage">
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
                    show-empty
                    small
                    stacked="md"
                    :items="events"
                    :fields="fields"
                    :current-page="currentPage"
                    :per-page="perPage"
                    :sort-by.sync="sortBy"
                    :sort-desc.sync="sortDesc"
                    :sort-direction="sortDirection"
            >
                <template v-slot:cell(image)="row">
                    <img :src="row.value" class="rounded" style="height: 50px" :alt="row.title">
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
                            <li v-for="(value, key) in row.item" :key="key">{{ key }}: {{ value }}</li>
                        </ul>
                    </b-card>
                </template>
            </b-table>
        </b-container>
    </b-card>
</template>

<script>
  export default {
    middleware: 'admin',
    name: 'events',
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
        perPage: 10,
        pageOptions: [10, 25, 50],
        sortBy: '',
        sortDesc: false,
        sortDirection: 'asc'
      }
    },
    computed: {
      totalRows () {
        return this.events ? this.events.length : 0
      },
      events: function () {
        return this.$store.state.user.events
      }
    },
    created () {
      this.$store.dispatch('user/getUserEvents')
    },
    methods: {
      deleteEvent (id) {
        this.$store.dispatch('user/deleteEvent', { id: id })
      },
      messageAlert(type, text) {
        this.alert.show = true
        this.alert.type = type
        this.alert.text = text
      }
    }
  }
</script>
