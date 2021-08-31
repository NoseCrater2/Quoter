

const priceModule = {
    state: {
        prices: [],
    },

  

    mutations: {
        setPrices(state, prices){
            state.prices = prices
        },

        savePrice(state, price){
            state.prices.push(price)
        },

        deletePrice(state, price){
            let  p = state.prices.find((p => p.id === price.id))
            state.prices.splice(state.prices.indexOf(p),1)
        },

        editPrice(state,price){
            let  p = state.prices.find((p => p.id === price.id))
            Object.assign(p,price);
        },
      
    },

    actions: {
        getPrices: async function ({ commit, state }){
            try {
                const response = await axios
                .get("/api/prices")
                commit('setPrices',response.data);   
              } catch (error) {
                 
              }
        },

        getBlind: async function ({ commit, state }){
            commit('setBlind',blind);
            // try {
            //     const response = await axios
            //     .get("/api/types",{
            //         headers: {Authorization: "Bearer "+localStorage.getItem('access_token')}})
            //     commit('setTypes',response.data.data);   
            //   } catch (error) {
                 
            //   }
        },

        savePrice: async function ({ commit, state }, price){
             let p = new FormData();
            for (const prop in price) {
                p.append(prop, price[prop])
            }
            try {
                const response = await axios
                .post("/api/prices",p)
                commit('savePrice',response.data);   
              } catch (error) {
                 
              }
        },

        deletePrice: async function ({ commit, state }, id){
           try {
               const response = await axios
               .delete('/api/prices/'+id)
               commit('deletePrice',response.data);   
             } catch (error) {
                
             }
       },

       editPrice: async function ({ commit, state }, price){
        let p = new FormData();
        for (const prop in price) {
            p.append(prop, price[prop])
        }
        p.append('_method','put')
        try {
            const response = await axios
            .post("/api/prices/"+price.id, p)
            commit('editPrice',response.data);   
          } catch (error) {
             
          }
    }

        
    }
}

export default priceModule;