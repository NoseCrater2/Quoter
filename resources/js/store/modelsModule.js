

const modelsModule = {
    state: {
        models: [],
        types: [],
        lines: [],
        colors: [],
        manufacturers: [],
        relatedColors: [],
        relatedColors2: [],
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

        setRelatedColors(state, colors){
            state.relatedColors = colors
        },
        setRelatedColors2(state, colors){
            state.relatedColors2 = colors
        },

        editModel(state,editedModel){
            state.models.map(function(currentModel){
              if(currentModel.id === editedModel.id){
                Object.assign(currentModel,editedModel);
              }
            });
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

        // getTypes: async function ({ commit, state }){
        //     try {
        //         const response = await axios
        //         .get("/api/types",{
        //             headers: {Authorization: "Bearer "+localStorage.getItem('access_token')}})
        //         commit('setTypes',response.data.data);   
        //       } catch (error) {
                 
        //       }
        // },

        editModel: async function ({ commit},model){
            try {
              const request = await axios
              .put("/api/variants/"+model.id,model)
              commit('editModel',request.data.data);
              //commit('setStatus',request.status);
            } catch (error) {
            //   commit('setErrors',error.response)
            //   commit('setStatus',error.response.status);
            }
          },

        getRelatedColors: async function ({ commit}, data){
            try {
                const response = await axios
                .get("/api/getColors/"+data.slug+"/"+data.type)
                commit('setRelatedColors',response.data.data);   
              } catch (error) {
                 
              }
        },

        getRelatedColors2: async function ({ commit}, data){
            try {
                const response = await axios
                .get("/api/getColors/"+data.slug+"/"+data.type)
                commit('setRelatedColors2',response.data.data);   
              } catch (error) {
                 
              }
        },

        // getLines: async function ({ commit, state }){
        //     try {
        //         const response = await axios
        //         .get("/api/lines")
        //         commit('setLines',response.data.data);   
        //       } catch (error) {
                 
        //       }
        // },


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