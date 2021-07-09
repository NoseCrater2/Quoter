

const rolesModule = {
    state: {
        roles: [],
        rolesStatus: [],
    },

    getters: {
        getRolesStatus(state){
            return state.status
        },
    },

    mutations: {
        setRoles(state, roles){
            state.roles = roles
        },

        setRolesStatus(state, status){
            state.rolesStatus = status
        }
    },

    actions: {
        getroles: async function ({ commit, state }){
           
            try {
                const response = await axios
                .get("/api/roles",{
                    headers: {Authorization: "Bearer "+localStorage.getItem('access_token')}})
                
                commit('setRolesStatus',response.status);
                commit('setRoles',response.data.data);
                
              } catch (error) {
                 commit('setRolesErrors',error.response.data)
                 commit('setRolesStatus',error.response.status);
              }
            

          },
    }
}

export default rolesModule;