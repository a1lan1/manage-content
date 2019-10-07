<template>
    <div>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card my-3">
                        <div class="card-header">
                            <div class="text-right">
                                <template v-if="authenticated">
                                    <router-link :to="{ name: 'home' }">
                                        {{ $t('home') }}
                                    </router-link>
                                </template>
                                <template v-else>
                                    <router-link :to="{ name: 'login' }" class="mr-3">
                                        {{ $t('login') }}
                                    </router-link>
                                    <router-link :to="{ name: 'register' }">
                                        {{ $t('register') }}
                                    </router-link>
                                </template>
                            </div>
                        </div>

                        <div class="container">
                            <div class="row">
                                <div
                                    v-for="(content, index) in contents"
                                    :key="index"
                                    class="col-12 col-sm-6 col-md-4 col-lg-3 my-2"
                                >
                                    <div class="card shadow">
                                        <b-link v-b-modal.modal-image>
                                            <img class="card-img-top" :src="content.image" :alt="content"  @click="modalcontent = index">
                                        </b-link>

                                        <div class="card-body">
                                            <p class="card-text">{{ content.title }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <b-modal id="modal-image" title="" size="lg" hide-footer @close="modalcontent = null">
            <img class="card-img-top" :src="`https://picsum.photos/600/400/?random&dummyParam=${modalcontent}`" :alt="modalcontent">
        </b-modal>
    </div>
</template>

<script>
  import { mapGetters } from 'vuex'

  export default {
    layout: 'basic',
    metaInfo () {
      return {title: this.$t('home')}
    },
    data: () => ({
      title: window.config.appName,
      modalcontent: null
    }),
    computed: mapGetters({
      authenticated: 'auth/check',
      contents: 'user/contents',
    }),
    created () {
      this.$store.dispatch('user/getContents')
    }
  }
</script>
