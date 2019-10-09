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
                            <div class="row">
                                <div
                                    v-for="(event, index) in events"
                                    :key="index"
                                    class="col-12 col-sm-6 col-md-4 col-lg-3 my-2"
                                >
                                    <div class="card shadow">
                                        <b-link v-b-modal.modal-image>
                                            <img class="card-img-top" :src="event.image" :alt="event"  @click="modalEvent = index">
                                        </b-link>

                                        <div class="card-body">
                                            <p class="card-text">{{ event.title }}</p>
                                            <b-btn
                                                    v-if="authenticated"
                                                    variant="success"
                                                    block
                                                    v-b-modal.modal-new-order
                                                    @click="form.event = event.id"
                                            >
                                                Add order
                                            </b-btn>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <b-modal id="modal-image"
                 size="lg"
                 class="p-0"
                 hide-footer
                 @close="modalEvent = null"
        >
            <img class="card-img-top" :src="`https://picsum.photos/600/400/?random&dummyParam=${modalEvent}`" :alt="modalEvent">
        </b-modal>

        <b-modal id="modal-new-order" title="New order" size="md" hide-footer>
            <b-form
                    @submit="onSubmit"
                    @reset="onReset"
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
                    ></b-form-input>
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
                    ></b-form-input>
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
                    ></b-form-input>
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
                    ></b-form-input>
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
                    ></b-form-select>
                </b-form-group>

                <b-button
                        :disabled="loading"
                        type="submit"
                          variant="primary"
                >
                    {{ loading ? 'Отправляем...' : 'Отправить' }}
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
      return { title: this.$t('home') }
    },
    data: () => ({
      alert: {
        show: false,
        type: 'info',
        text: ''
      },
      title: window.config.appName,
      modalEvent: null,
      loading: false,
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
      events: 'user/events',
    }),
    created () {
      this.$store.dispatch('user/getEvents')
    },
    methods: {
      onSubmit (evt) {
        this.loading = true
        evt.preventDefault()

        this.$store.dispatch('user/storeOrder', this.form)
          .then((response) => {
            this.$root.$emit('bv::hide::modal', 'modal-new-order')
            this.loading = false

            if (response.status === 200) {
              this.messageAlert('success', 'Ваша заявка отправлена!')
            } else {
              this.messageAlert('danger', response.data)
            }
          })
      },
      onReset (evt) {
        evt.preventDefault()

        this.form.firstname = ''
        this.form.secondname = ''
        this.form.email = ''
        this.form.phone = ''
        this.form.education = null
      },
      messageAlert(type, text) {
        this.alert.show = true
        this.alert.type = type
        this.alert.text = text
      }
    }
  }
</script>
