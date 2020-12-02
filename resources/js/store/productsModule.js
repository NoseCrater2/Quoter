

const productsModule = {
    state: {
        products: [],
        variants: [],
        types: [],
        lines: [],
        weaves: [],
        sunblinds: [],
    },

    getters: {

    getType: ({types, slug}) => {
        return types.find((t) => t.slug === slug) || null
      }
        
    },

    mutations: {
        setProducts(state, products){
            state.products = products
        },

        setVariants(state, variants){
            state.variants = variants
        },

        setTypes(state, types){
            state.types = types
        },

        setLines(state, lines){
            state.lines = lines
        },

        setWeaves(state, weaves){
            state.weaves = weaves
        },

        setSunblinds(state, sunblinds){
            state.sunblinds = sunblinds
        },


    },

    actions: {
        getProducts: async function ({ commit, state }){
            try {
                const response = await axios
                .get("/api/products")
                commit('setProducts',response.data.data);
            } catch (error) {}
        },

        getVariantsByLine: async function ({ commit, state }, idProduct){
            try {
                const response = await axios
                .get("/api/getVariants/"+idProduct)
                commit('setVariants',response.data.data);
            } catch (error) {}
        },

        getTypes: async function ({ commit, state }, idProduct){
            try {
                const response = await axios
                .get("/api/getTypes/"+idProduct)
                commit('setTypes',response.data.data);
            } catch (error) {}
        },

        getLines: async function ({ commit, state }, idProduct){
            try {
                const response = await axios
                .get("/api/getLines/"+idProduct)
                commit('setLines',response.data.data);
            } catch (error) {}
        },

        getWeaves: async function ({ commit, state }, idProduct){
            try {
                const response = await axios
                .get("/api/getWeaves/"+idProduct)
                commit('setWeaves',response.data.data);
            } catch (error) {}
        },

        getSunblinds: async function ({ commit, state }, idProduct){
            try {
                const response = await axios
                .get("/api/getSunblinds/"+idProduct)
                commit('setSunblinds',response.data.data);
            } catch (error) {}
        },

        getVariantsByType: async function ({ commit, state }, idProduct){
            try {
                const response = await axios
                .get("/api/getTypeVariants/"+idProduct)
                commit('setVariants',response.data.data);
            } catch (error) {}
        },

        getVariantsByProduct: async function ({ commit, state }, idProduct){
            try {
                const response = await axios
                .get("/api/getVariantsByProduct/"+idProduct)
                commit('setVariants',response.data.data);
            } catch (error) {}
        },
    }
}

export default productsModule;