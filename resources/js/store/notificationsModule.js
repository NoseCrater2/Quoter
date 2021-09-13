

const notificationsModule = {
    state: {
        notifications: [],
    },

  

    mutations: {
        setNotifications(state, notifications){
            state.notifications = notifications
        },
      
    },

    actions: {
        getNotifications: async function ({ commit, state }){
            try {
                const response = await axios
                .get("/api/notifications")
                commit('setNotifications',response.data);
            } catch (error) {}
            
        },   
    }
}

export default notificationsModule;