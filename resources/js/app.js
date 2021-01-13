import 'core-js'
import 'regenerator-runtime/runtime'

import Vue from 'vue'
import store from '~/store'
import router from '~/router'
import i18n from '~/plugins/i18n'
import App from '~/components/App'
import BootstrapVue from 'bootstrap-vue'
import VueLazyload from 'vue-lazyload'

import '~/plugins'
import '~/components'

Vue.config.productionTip = false

Vue.use(BootstrapVue)
Vue.use(VueLazyload)

/* eslint-disable no-new */
new Vue({
  i18n,
  store,
  router,
  ...App
})
