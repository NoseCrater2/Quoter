
import Vue from 'vue';
import Vuex from 'vuex';
import axios from 'axios';
Vue.use(Vuex)
// import loginModule from './loginModule';
import userModule from './userModule';
import usersModule from './usersModule';
import rolesModule from './rolesModule';
import modelsModule from './modelsModule';
import productsModule from './productsModule';
import variantsModule from './variantsModule';
import ordersModule from './ordersModule';
import sunblindModule from './sunblindModule';
import motorizationModule from './motorizationModule';
import { isLoggedIn, logOut } from '../utils/auth';
import { isNull } from 'lodash';

const store = new Vuex.Store({


  modules:{
  
   userModule,
   usersModule,
   rolesModule,
   modelsModule,
   productsModule,
   variantsModule,
   ordersModule,
   sunblindModule,
   motorizationModule,
  },
  state:{
    loginErrors : [],
    loginStatus: [],
    signupStatus: [],
    signupErrors: [],
    checkStatus: null,
    isLoggedIn: localStorage.getItem('isLoggedIn') || false,
    user: null,
   
},


getters:{
   
    loggedIn(state) {
        
        return state.token !== null
      },

    getLoginErrors(state){
        return state.loginErrors
    },

    getLoginStatus(state){
        return state.loginStatus
    },

    getSignupStatus(state){
        return state.signupStatus
    },


},
mutations:{

  setUser(state, payload){
    state.user = payload
  },

  setLoggedIn(state, payload){
    state.isLoggedIn = payload
  },

  setSignupErrors(state, errors){
    state.signupErrors = errors
  },
  setSignupStatus(state, status){
    state.signupStatus = status
  },

  setErrors(state, errors){
    state.loginErrors = errors
  },

  setStatus(state, status){
    state.loginStatus = status
  },

  setCheckStatus(state, status){
    state.checkStatus = status
  },

},
actions:{
  async loadUser({commit, dispatch}){
    if(isLoggedIn()){
      
      try {
        const response = await axios.get("/user")
        
        commit("setUser", response.data.data)
       
        commit("setLoggedIn", true)

      } catch (error) {
          dispatch("logout")
        
      }
    }
  }, 

  logout({commit}){
    commit("setUser", null)
    commit("setLoggedIn", false)
    logOut()
  },

  //   retrieveToken: async function ({ commit, state }, credentials){
       
  //       try {
  //           const request = await axios
  //           .post("/api/login",credentials)
  //           localStorage.setItem('access_token', request.data.token)
  //           commit('retrieveToken',request.data.token);
  //           commit('setStatus',request.status);
            
           
  //         } catch (error) {
  //           commit('setErrors',error.response.data)
  //           commit('setStatus',error.response.status);
  //         }

  //     },

  //     destroyToken: async function ({ commit, state }){

  //      try {
  //          const response = await axios
  //          .post("/api/logout", '',{
  //              headers: {Authorization: "Bearer "+state.token}})
               
  //              commit('setErrors',response.data.message)
  //              commit('setStatus',response.status)
  //              commit('destroyToken', state)
  //      } catch (error) {
           
  //      }
  // },

  signup: async function ({ commit, state }, credentials){
       
    try {
        const request = await axios
        .post("/api/register",credentials)
        commit('setSignupStatus',request.status);
        commit('retrieveToken',request.data.token);
      } catch (error) {
        commit('setSignupErrors',error.response.data)
        commit('setSignupStatus',error.response.status);
      }

  },

  checkPasword: async function ({ commit, state }, intent){
       
    try {
       
        const request = await axios
        .post("/api/checkPassword",{'intent': intent },{
            headers: {Authorization: "Bearer "+state.token}})
        commit('setCheckStatus',request.status);
        //commit('retrieveToken',request.data.token);
      } catch (error) {
        //commit('setSignupErrors',error.response.data)
        //commit('setSignupStatus',error.response.status);
      }

  },

  loadStoredState(context) {
    context.commit("setLoggedIn", isLoggedIn());
},

      
},
 
})



export default store

