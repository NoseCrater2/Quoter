

const catalogsModule = {
    state: {
        catalogs: [],
    },

    mutations: {
        setCatalogs(state, catalog){
            state.catalogs = catalog
        },

        saveCatalog(state, catalog){
            state.catalog.push(catalog)
        },

        deleteCatalog(state, catalog){
            let  p = state.catalog.find((p => p.id === catalog.id))
            state.catalog.splice(state.catalog.indexOf(p),1)
        },

        editCatalog(state,catalog){
            let  p = state.catalog.find((p => p.id === catalog.id))
            Object.assign(p,catalog);
        },
      
    },

    actions: {
        getCatalogs: async function ({ commit, state }){
            try {
                const response = await axios
                .get("/api/catalogs")
                commit('setCatalogs',response.data);   
              } catch (error) {
                 
              }
        },

        saveCatalog: async function ({ commit, state }, catalog){
             let p = new FormData();
            for (const prop in catalog) {
                p.append(prop, catalog[prop])
            }
            try {
                const response = await axios
                .post("/api/catalogs",p)
                commit('saveCatalog',response.data);   
              } catch (error) {
                 
              }
        },

        deleteCatalog: async function ({ commit, state }, id){
           try {
               const response = await axios
               .delete('/api/catalogs/'+id)
               commit('deleteCatalog',response.data);   
             } catch (error) {
                
             }
       },

       editCatalog: async function ({ commit, state }, catalog){
        let p = new FormData();
        for (const prop in catalog) {
            p.append(prop, catalog[prop])
        }
        p.append('_method','put')
        try {
            const response = await axios
            .post("/api/catalogs/"+catalog.id, p)
            commit('editPrice',response.data);   
          } catch (error) {
             
          }
    }

        
    }
}

export default catalogsModule;