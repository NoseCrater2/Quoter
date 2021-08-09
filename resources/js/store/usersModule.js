

const usersModule = {
    state: {
        registerErrors: [],
        registerStatus: 0,
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
        setRegisterErrors(state, errors){
            state.registerErrors = errors
        },

        setRegisterStatus(state, status){
            state.registerStatus = status
        },

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

          mutationDeleteUser(state, idDeletedUser){
              //No usé el indexOf metodo de Js por que me daba error
              let idFinded = -1;
              state.users.forEach((itemUser, index)=>{
                  if(itemUser.id == idDeletedUser){
                    idFinded = index;
                  }
              })
              if(idFinded > 0){
                state.users.splice(idFinded, 1);
              }
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
            let u = new FormData();
            for (const prop in editUser) {
                u.append(prop, editUser[prop])
            }
            u.append('_method', 'put')

            try {
                const response = await axios
                .post("/api/users/"+editUser.id,u)

                commit('setUsersStatus',response.status);
                commit('editUser',response.data.data);

              } catch (error) {
                 commit('setUsersErrors',error.response.data)
                 commit('setUsersStatus',error.response.status);
              }
          },

          saveUser: async function ({ commit }, newUser){

            let u = new FormData();
            for (const prop in newUser) {
                u.append(prop, newUser[prop])
            }
            try {
                const response = await axios
                .post("/api/users",u)

                commit('setUsersStatus',response.status);
                commit('saveUser',response.data.data);

              } catch (error) {
                 commit('setUsersErrors',error.response.data)
                 commit('setUsersStatus',error.response.status);
              }
          },

          actionDeleteUserAXIOS: async function ({ commit }, deletedUser){

            try {
                const response = await axios.delete(`/api/users/${deletedUser.id}`)
                commit('setUsersStatus',response.status);
                commit('mutationDeleteUser', deletedUser.id);

              } catch (error) {
                 commit('setUsersErrors',error.response.data)
                 commit('setUsersStatus',error.response.status);
              }
          },

          registerClient: async function ({ commit, state },  data){

            try {
                const request = await axios
                .post("/api/register-client", data)
                commit('setRegisterStatus', request.status)
            } catch (error) {
                commit('setRegisterErrors',error.response.data)
                commit('setRegisterStatus', error.response.status)
            }
          },


    }
}

export default usersModule;
