import axios from 'axios'
import Vue from 'vue'
import * as types from '../mutation-types'

const routeContents = '/api/contents'

// state
export const state = {
  contents: null
}

// getters
export const getters = {
  contents: state => state.contents
}

// mutations
export const mutations = {
  [types.FETCH_CONTENTS] (state, { contents }) {
    state.contents = contents
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
  }
}
