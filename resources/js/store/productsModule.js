

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

    getVariant: (state)=> (id) => {
            return state.variants.find((t) => t.id === id)
    },

    getTypes: (state)=> (slug) => {
        return state.products.find((t) => t.slug === slug)
    },

    getLines: (state)=> (slug) => {
        return state.lines.filter((line) => line.types.includes(slug))
    },

    getType: (state)=> (slug) => {
        return state.products.find((product) => product.types === slug)
    },

    getLine: (state)=> (slug) => {
        return state.lines.filter((line) => line.slug === slug)
    },
        
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
            if(state.products.length === 0){
            try {
                const response = await axios
                .get("/api/products")
                commit('setProducts',response.data.data);
            } catch (error) {}
        }
        },

        getAllVariants: async function ({ commit, state }){
            if(state.variants.length === 0){
            try {
                const response = await axios
                .get("/api/variants/")
                commit('setVariants',response.data.data);
            } catch (error) {}
        }
        },

        getVariantsByLine: async function ({ commit, state }, slug){
            try {
                const response = await axios
                .get("/api/getVariants/"+slug)
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

        getLines: async function ({ commit, state }){
            if(state.products.length === 0){
            try {
                const response = await axios
                .get("/api/lines/"+idProduct)
                commit('setLines',response.data.data);
            } catch (error) {}
            }
        },

        getWeaves: async function ({ commit, state }, slugLine){
            try {
                const response = await axios
                .get("/api/getWeaves/"+slugLine)
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

        getAllSunblinds: async function ({ commit, state }){
            try {
                const response = await axios
                .get("/api/sunblinds/")
                commit('setSunblinds',response.data.data);
            } catch (error) {}
        },

        getVariantsByType: async function ({ commit, state }, slug){
            try {
                const response = await axios
                .get("/api/getTypeVariants/"+slug)
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