

const userModule = {
    state: {
        user: {
            roles: [],
        },
        userStatus: [],
    },

    getters: {
        getUserStatus(state){
            return state.status
        },
    },

    mutations: {
        setUser(state, user){
            state.user = user
        },

        setUserStatus(state, status){
            state.userStatus = status
        }
    },

    actions: {
        getUser: async function ({ commit, state }){
           
            try {
                const response = await axios
                .get("/api/getMyInfo",{
                    headers: {Authorization: "Bearer "+localStorage.getItem('access_token')}})
                
                commit('setUserStatus',response.status);
                commit('setUser',response.data.data);
                
              } catch (error) {
                // commit('setErrors',error.response.data)
                // commit('setStatus',error.response.status);
              }
            

          },
    }
}

export default userModule;