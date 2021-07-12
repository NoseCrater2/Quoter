

const userModule = {
    state: {
        user: {
            roles: [],
        },
        userStatus: [],
        distributors: [],
    },

    getters: {
        getUserStatus(state){
            return state.status
        },
    },

    mutations: {
        setDistributors(state, distributors){
            state.distributors = distributors
        },

        setUserStatus(state, status){
            state.userStatus = status
        }
    },

    actions: {
        getDistributors: async function ({ commit}){
            try {
                const response = await axios
                .get("/api/distributors")
                commit('setDistributors',response.data.data); 
              } catch (error) {
              }
          },
    }
}

export default userModule;