import axios from 'axios'
import * as types from '../mutation-types'

const routeContents = '/api/contents'
const routeOrders = '/api/orders'
const routeDeleteOrder = '/api/orders/delete'

// state
export const state = {
  contents: null,
  orders: null
}

// getters
export const getters = {
  contents: state => state.contents,
  orders: state => state.orders
}

// mutations
export const mutations = {
  [types.FETCH_CONTENTS] (state, { contents }) {
    state.contents = contents
  },
  [types.FETCH_ORDERS] (state, { orders }) {
    state.orders = orders
  },
  [types.FETCH_ORDER] (state, { order }) {
    state.orders.push(order)
  }
}

// actions
export const actions = {
  async getContents ({ commit }) {
    try {
      const { data } = await axios.get(routeContents)

      commit(types.FETCH_CONTENTS, { contents: data })
    } catch (error) {
      console.log(error)
    }
  },
  async getOrders ({ commit }) {
    try {
      const { data } = await axios.get(routeOrders)

      commit(types.FETCH_ORDERS, { orders: data })
    } catch (error) {
      console.log(error)
    }
  },
  async storeOrder ({ commit }, order) {
    try {
      return await axios.post(routeOrders, order)
    } catch (error) {
      console.log(error)
    }
  },
  async deleteOrder ({ commit }, id) {
    try {
      const { data } = await axios.post(routeDeleteOrder, id)

      commit(types.FETCH_ORDERS, { orders: data })
    } catch (error) {
      console.log(error)
    }
  }
}
