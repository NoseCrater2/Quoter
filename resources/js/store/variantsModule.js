const variantsModule = {
    state: {
        variant: [],
        related: [],
    },

    getters: {
   
    },

    mutations: {
        setVariant(state, variant){
            state.variant = variant
        },
        setRelated(state, related){
            state.related = related
        },

    },

    actions: {
       

        getVariant: async function ({ commit, state }, idVariant){
            try {
                const response = await axios
                .get("/api/variants/"+idVariant)
                commit('setVariant',response.data.data);
            } catch (error) {}
        },

        // 'getRelated/{variant}'

        getRelated: async function ({ commit, state }, idVariant){
            try {
                const response = await axios
                .get("/api/getRelated/"+idVariant)
                commit('setRelated',response.data.data);
            } catch (error) {}
        },

    },
}

export default variantsModule;