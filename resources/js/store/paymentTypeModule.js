const paymentTypeModule = {
    state: {
        paymentTypes: [],
        userPaymentTypes: []
    },

    getters: {

    },

    mutations: {
        setPaymentTypes(state, paymentTypes){
            state.paymentTypes = paymentTypes
        },
        setUserPaymentTypes(state, userPaymentTypes){
            state.userPaymentTypes = userPaymentTypes
        },
    },

    actions: {
        actionGetPaymentTypes: async function ({ commit }){
            try {
                const response = await axios.get("/api/payment-types");
                commit('setPaymentTypes', response.data);
            } catch (error) {
            }
        },
        actionGetUserPaymentTypes: async function ({ commit }, user){
            try {
                const response = await axios.get("/api/user-payment-types/"+user.id);
                commit('setUserPaymentTypes', response.data);
            } catch (error) {
            }
        },
        actionAddPaymentTypeToUser: async function ({ commit }, objectPaymentTypes){
            try {
                const response = await axios.post("/api/payment-type-to-user/"+objectPaymentTypes.user.id, {paymentTypes: objectPaymentTypes.paymentTypes.map(item=> item.id)});
            } catch (error) {
            }
        },
    }
}

export default paymentTypeModule;
