const variantsModule = {
    state: {
        variant: [],
        related: [],
        searchedVariants: [],
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

        setSearchedVariants(state, searchedVariants){
            state.searchedVariants = searchedVariants
        },

    },

    actions: {
       

        getVariant: async function ({ commit, state }, idProduct){
           
            try {
                const response = await axios
                .get("/api/variants/"+idProduct)
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

        getSearchedVariants: async function ({ commit, state }, query){
           
            try {
                const response = await  axios.get('/models/search', {params: {query: query}})
                commit('setSearchedVariants',response.data);
            } catch (error) {}
        },

    },
}

export default variantsModule;