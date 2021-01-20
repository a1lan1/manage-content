<template>
  <div>
    <div class="container">
      <b-alert
        :variant="alert.type"
        dismissible
        fade
        :show="alert.show"
        @dismissed="alert.show = false"
      >
        {{ alert.text }}
      </b-alert>

      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="container">
              <div
                v-if="events.length"
                class="row"
              >
                <div
                  v-for="(event, index) in events"
                  :key="index"
                  class="col-12 col-sm-6 col-md-4 col-lg-3 my-2"
                >
                  <div class="card shadow">
                    <b-link v-b-modal.modal-image>
                      <img
                        v-lazy="event.image"
                        class="card-img-top"
                        :alt="event"
                        @click="modalEvent = index"
                      >
                    </b-link>

                    <div class="card-body">
                      <p class="card-text">
                        {{ event.title }}
                      </p>
                      <b-btn
                        v-if="authenticated"
                        v-b-modal.modal-new-order
                        variant="success"
                        block
                        @click="form.event = event.id"
                      >
                        Add order
                      </b-btn>
                    </div>
                  </div>
                </div>
              </div>
              <div v-else>
                <b-spinner
                  class="my-3"
                  label="loading"
                />
              </div>

              <div
                v-if="!loading && data && currentPage !== data.last_page"
                class="row"
              >
                <div class="col-12 text-center">
                  <b-btn
                    variant="info"
                    class="mb-2"
                    :disabled="busy"
                    @click="loadMore"
                  >
                    <b-spinner v-if="busy" small type="grow" /> Load more
                  </b-btn>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Modals -->
    <b-modal
      id="modal-image"
      size="lg"
      class="p-0"
      hide-footer
      @close="modalEvent = null"
    >
      <img v-lazy="`https://picsum.photos/600/400/?random&dummyParam=${modalEvent}`" class="card-img-top" :alt="modalEvent">
    </b-modal>

    <b-modal
      id="modal-new-order"
      title="New order"
      size="md"
      hide-footer
    >
      <b-form
        @submit="onSubmit"
        @reset="resetForm"
      >
        <b-form-group
          id="input-group-1"
          label="First name:"
          label-for="input-1"
        >
          <b-form-input
            id="input-1"
            v-model="form.firstname"
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
            v-model="form.secondname"
            type="text"
            required
            placeholder="Enter secondname"
          />
        </b-form-group>

        <b-form-group
          id="input-group-3"
          label="Email address:"
          label-for="input-3"
          description="We'll never share your email with anyone else."
        >
          <b-form-input
            id="input-3"
            v-model="form.email"
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
            v-model="form.phone"
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
            v-model="form.education"
            :options="educationList"
            required
          />
        </b-form-group>

        <b-button
          :disabled="loading"
          type="submit"
          variant="primary"
        >
          <b-spinner
            v-if="loading"
            small
            type="grow"
          /> {{ loading ? 'Sending...' : 'Send' }}
        </b-button>

        <b-button
          type="reset"
          variant="danger"
        >
          Reset
        </b-button>
      </b-form>
    </b-modal>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  metaInfo () {
    return { title: 'Events' }
  },
  data: () => ({
    events: [],
    alert: {
      show: false,
      type: 'info',
      text: ''
    },
    title: window.config.appName,
    modalEvent: null,
    loading: false,
    busy: false,
    currentPage: 1,
    form: {
      event: null,
      firstname: '',
      secondname: '',
      email: '',
      phone: '',
      education: null
    },
    educationList: [
      { text: 'Level of education', value: null },
      { text: 'Bachelor', value: 1 },
      { text: 'Master', value: 2 },
      { text: 'PhD', value: 3 }
    ]
  }),
  computed: mapGetters({
    authenticated: 'auth/check',
    user: 'auth/user',
    data: 'user/events'
  }),
  created () {
    this.getEvents()

    if (this.authenticated) {
      this.form.firstname = this.user.name
      this.form.email = this.user.email
    }
  },
  beforeDestroy () {
    this.$store.dispatch('user/resetEvents')
  },
  methods: {
    getEvents () {
      this.busy = true

      this.$store.dispatch('user/getEvents', this.currentPage)
        .then(() => {
          this.events.push(...this.data.data)
        })
        .finally(() => {
          this.busy = false
        })
    },
    loadMore () {
      this.currentPage++
      this.getEvents()
    },
    onSubmit (evt) {
      this.loading = true
      evt.preventDefault()

      this.$store.dispatch('user/storeOrder', this.form)
        .then((response) => {
          this.$root.$emit('bv::hide::modal', 'modal-new-order')
          this.loading = false

          if (response && response.status === 200) {
            this.messageAlert('success', 'Your order has been sent!')
            this.resetForm()
          }
        })
    },
    resetForm () {
      this.form.firstname = ''
      this.form.secondname = ''
      this.form.email = ''
      this.form.phone = ''
      this.form.education = null
    },
    messageAlert (type, text) {
      this.alert.show = true
      this.alert.type = type
      this.alert.text = text
    }
  }
}
</script>
