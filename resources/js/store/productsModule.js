

const productsModule = {
    state: {
        products: [],
        variants: [],
        types: [],
        lines: [],
        weaves: [],
        subweaves: [],
        sunblinds: [],
    },

    getters: {

    getVariant: (state)=> (slug, type) => {
            return state.variants.find((t) => t.slug === slug && t.type.slug === type)
    },

    getTypes: (state)=> (slug) => {
        return state.products.find((t) => t.slug === slug)
    },

    getLines: (state)=> (slug) => {
        return state.lines.filter((line) => line.types.includes({slug:slug}))
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
        setSubweaves(state, subweaves){
            state.subweaves = subweaves
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
                .get("/api/variants")
                commit('setVariants',response.data.data);
            } catch (error) {}
        }
        },

        // getVariantsByLine: async function ({ commit, state }, slug){
        //     try {
        //         const response = await axios
        //         .get("/api/getVariants/"+slug)
        //         commit('setVariants',response.data.data);
        //     } catch (error) {}
        // },

        getTypes: async function ({ commit, state }, idProduct){
            try {
                const response = await axios
                .get("/api/getTypes/"+idProduct)
                commit('setTypes',response.data.data);
            } catch (error) {}
        },

        getLines: async function ({ commit, state },id){

            try {
                const response = await axios
                .get("/api/lines/" + id)
                commit('setLines',response.data.data);
            } catch (error) {}

        },

        getSubweaves: async function ({ commit}){
            try {
                const response = await axios
                .get("/api/subweaves")
                commit('setSubweaves',response.data.data);
            } catch (error) {}
        },

        // getSunblinds: async function ({ commit, state }, idProduct){
        //     try {
        //         const response = await axios
        //         .get("/api/getSunblinds/"+idProduct)
        //         commit('setSunblinds',response.data.data);
        //     } catch (error) {}
        // },

        // getAllSunblinds: async function ({ commit, state }){
        //     try {
        //         const response = await axios
        //         .get("/api/sunblinds/")
        //         commit('setSunblinds',response.data.data);
        //     } catch (error) {}
        // },

        // getVariantsByType: async function ({ commit, state }, slug){
        //     try {
        //         const response = await axios
        //         .get("/api/getTypeVariants/"+slug)
        //         commit('setVariants',response.data.data);
        //     } catch (error) {}
        // },
        deactiveVariant: async function ({commit}, options) {
            try {
                const response = await axios
                .post("/api/deactive/" + options.id, options)
                commit('setSunblinds',response.data.data);
            } catch (error) {}
        },

        getVariantsByProduct: async function ({ commit }, idProduct){
            try {
                const response = await axios
                .get("/api/getVariantsByProduct/"+idProduct)
                commit('setSunblinds',response.data.data);
            } catch (error) {}
        },


    }
}

export default productsModule;
