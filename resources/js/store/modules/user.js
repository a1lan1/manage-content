import axios from 'axios'
import * as types from '../mutation-types'

const routeEvents = '/api/events'
const routeUserEvents = '/api/user-events'
const routeDeleteUserEvent = '/api/user-events/delete'
const routeOrders = '/api/orders'
const routeDeleteOrder = '/api/orders/delete'

// state
export const state = {
  events: null,
  orders: null
}

// getters
export const getters = {
  events: state => state.events,
  orders: state => state.orders
}

// mutations
export const mutations = {
  [types.FETCH_EVENTS] (state, { events }) {
    state.events = events
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
  async getEvents ({ commit }) {
    try {
      const { data } = await axios.get(routeEvents)

      commit(types.FETCH_EVENTS, { events: data })
    } catch (error) {
      console.log(error)
    }
  },
  async getUserEvents ({ commit }) {
    try {
      const { data } = await axios.get(routeUserEvents)

      commit(types.FETCH_EVENTS, { events: data })
    } catch (error) {
      console.log(error)
    }
  },
  async deleteEvent ({ commit }, id) {
    try {
      const { data } = await axios.post(routeDeleteUserEvent, id)

      commit(types.FETCH_EVENTS, { events: data })
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
