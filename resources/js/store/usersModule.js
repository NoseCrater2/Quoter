

const usersModule = {
    state: {
        users: [],
        usersStatus: null,
        usersErrors: [], 
    },

    getters: {
        getUsersStatus(state){
            return state.status
        },
    },

    mutations: {
        setUsers(state, users){
            state.users = users
        },

        setUsersErrors(state, errors){
            state.usersErrors = errors
        },

        setUsersStatus(state, status){
            state.usersStatus = status
        },

        editUser(state,editedUser){
            state.users.map(function(currentUser){
              if(currentUser.id === editedUser.id){
                Object.assign(currentUser,editedUser);
              }
            });
          },

          saveUser(state,newUser){
            state.users.push(newUser);
           
          },
    },

    actions: {
        getusers: async function ({ commit, state }){
           
            try {
                const response = await axios
                .get("/api/users",{
                    headers: {Authorization: "Bearer "+localStorage.getItem('access_token')}})
                
                commit('setUsersStatus',response.status);
                commit('setUsers',response.data.data);
                
              } catch (error) {
                 commit('setUsersErrors',error.response.data)
                 commit('setUsersStatus',error.response.status);
              }
            

          },

          editUser: async function ({ commit, state }, editUser){
           
            try {
                const response = await axios
                .put("/api/users/"+editUser.id,editUser,{
                    headers: {Authorization: "Bearer "+localStorage.getItem('access_token')}})
                
                commit('setUsersStatus',response.status);
                commit('editUser',response.data.data);
                
              } catch (error) {
                 commit('setUsersErrors',error.response.data)
                 commit('setUsersStatus',error.response.status);
              }
          },

          saveUser: async function ({ commit, state }, newUser){
           
            try {
                const response = await axios
                .post("/api/users/",newUser,{
                    headers: {Authorization: "Bearer "+localStorage.getItem('access_token')}})
                
                commit('setUsersStatus',response.status);
                commit('saveUser',response.data.data);
                
              } catch (error) {
                 commit('setUsersErrors',error.response.data)
                 commit('setUsersStatus',error.response.status);
              }
          },
    }
}

export default usersModule;