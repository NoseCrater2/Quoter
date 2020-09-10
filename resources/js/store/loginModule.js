import axios from 'axios';
import { reject } from 'lodash';

const loginModule = {

    state:{
        token: localStorage.getItem('access_token') || null,
        loginErrors : [],
        loginStatus: [],
    },


    getters:{
        loggedIn(state){
            return state.token != null
        },

        getLoginErrors(state){
            return state.loginErrors
        },

        getLoginStatus(state){
            return state.loginStatus
        },
    },
    mutations:{
       retrieveToken(state, token){
           state.token = token
       },

       destroyToken(state){
           state.token = null
       },

       setErrors(state, errors){
        state.loginErrors = errors
        },
        setStatus(state, status){
            state.loginStatus = status
        }
    },
    actions:{
        retrieveToken: async function ({ commit, state }, credentials){
           
            try {
                const request = await axios
                .post("/api/login",credentials)
                commit('setStatus',request.status);
                commit('retrieveToken',request.data.token);
                
              } catch (error) {
                commit('setErrors',error.response.data)
                commit('setStatus',error.response.status);
              }

          },

          destroyToken: async function ({ commit, state }){

            if(context.getters.loggedIn){
                await axios
                .post("/api/logout", '',{
                    headers: {Authorization: "Bearer "+context.state.token}
                })
                .then(res => {
                    const token = res.data.access_token
                    localStorage.removeItem('access_token',token)
                    commit('destroyToken')})
                .catch(err => {
                    localStorage.removeItem('access_token',token)
                    commit('destroyToken')
                    reject(err)
                });
            }
      },

          
    },
}

export default loginModule;