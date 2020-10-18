

const modelsModule = {
    state: {
        models: [],
        types: [],
        lines: [],
        colors: [],
        manufacturers: [],
    },

  

    mutations: {
        setModels(state, models){
            state.models = models
        },
        setTypes(state, types){
            state.types = types
        },
        setLines(state, lines){
            state.lines = lines
        },
        setColors(state, colors){
            state.colors = colors
        },
        setManufacturers(state, manufacturers){
            state.manufacturers = manufacturers
        },

      
    },

    actions: {
        getModels: async function ({ commit, state }){
            try {
                const response = await axios
                .get("/api/variants",{
                    headers: {Authorization: "Bearer "+localStorage.getItem('access_token')}})
                commit('setModels',response.data.data);   
              } catch (error) {
                 
              }
        },

        getTypes: async function ({ commit, state }){
            try {
                const response = await axios
                .get("/api/types",{
                    headers: {Authorization: "Bearer "+localStorage.getItem('access_token')}})
                commit('setTypes',response.data.data);   
              } catch (error) {
                 
              }
        },

        getLines: async function ({ commit, state }){
            try {
                const response = await axios
                .get("/api/lines",{
                    headers: {Authorization: "Bearer "+localStorage.getItem('access_token')}})
                commit('setLines',response.data.data);   
              } catch (error) {
                 
              }
        },


        getColors: async function ({ commit, state }){
            try {
                const response = await axios
                .get("/api/colors",{
                    headers: {Authorization: "Bearer "+localStorage.getItem('access_token')}})
                commit('setColors',response.data.data);   
              } catch (error) {
                 
              }
        },

        getManufacturers: async function ({ commit, state }){
            try {
                const response = await axios
                .get("/api/manufacturers",{
                    headers: {Authorization: "Bearer "+localStorage.getItem('access_token')}})
                commit('setManufacturers',response.data.data);   
              } catch (error) {
                 
              }
        },
    }
}

export default modelsModule;