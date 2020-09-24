

const loginModule = {

    state:{
        token: localStorage.getItem('access_token') || null,
        loginErrors : [],
        loginStatus: [],
        signupStatus: [],
        signupErrors: [],
        checkStatus: null,
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

        getSignupStatus(state){
            return state.signupStatus
        },


    },
    mutations:{
       retrieveToken(state, token){
        localStorage.setItem('access_token', token)
       },

       destroyToken(state){
        
        localStorage.removeItem('access_token')

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

           try {
               const response = await axios
               .post("/api/logout", '',{
                   headers: {Authorization: "Bearer "+state.token}})
                   
                   commit('setErrors',response.data.message)
                   commit('setStatus',response.status)
                   commit('destroyToken', state)
           } catch (error) {
               
           }
      },

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

          
    },
}

export default loginModule;