

const modelsModule = {
    state: {
        blinds: [],
        blind: [],
    },

  

    mutations: {
        setBlinds(state, blinds){
            state.blinds = blinds
        },
        setBlind(state, blind){
            state.blind = blind
        },
      
    },

    actions: {
        getBlinds: async function ({ commit, state }){
            blinds = [
                {id:1,name: 'Uno', price: 1000.00, image: 'https://i.pinimg.com/originals/ca/9d/f5/ca9df54ce60dcfc898a87f77cec0e7b7.jpg'},
                {id:2,name: 'Dos', price: 1050.00, image: 'https://www.creativeswall.com/wp-content/uploads/2014/04/fabric_texture_04_preview.jpg'},
                {id:3,name: 'Tres', price: 2048.00, image: 'https://cdn02.plentymarkets.com/2brofzsczyt8/item/images/179823/full/Tapete-Vlies-Strukturiert-kupfer-Metallic-Rasch-Te.jpg'},
                {id:4,name: 'Cuatro', price: 900.00, image: 'https://i.pinimg.com/originals/4b/63/01/4b6301946bd5495ff9c200fc4308a543.jpg'},
                {id:5,name: 'Cinco', price: 990.00, image: 'https://images-na.ssl-images-amazon.com/images/I/914IWKpapWL._AC_SL1500_.jpg'},
                {id:6,name: 'Seis', price: 1010.00, image: 'https://www.wallpaperwarehouse.com/upload_media/product/preview/1554317253BIORTEFJ_1554414773.jpg'},
                {id:7,name: 'Siete', price: 2500.00, image: 'https://bhf-cdn.azureedge.net/bhf-blob-prod/0034928_arya-brown-fabric-texture-wallpaper_600.jpeg'},
                {id:8,name: 'Ocho', price: 3000.00, image: ''},
                {id:9,name: 'Nueve', price: 500.00, image: ''},
                {id:10,name: 'Dies', price: 700.00, image: ''},
                {id:11,name: 'Once', price: 2700.00, image: ''},
                {id:12,name: 'Doce', price: 2100.00, image: ''},
                {id:13,name: 'Trece', price: 1500.00, image: ''},

            ]
            commit('setBlinds',blinds);
            // try {
            //     const response = await axios
            //     .get("/api/variants",{
            //         headers: {Authorization: "Bearer "+localStorage.getItem('access_token')}})
            //     commit('setModels',response.data.data);   
            //   } catch (error) {
                 
            //   }
        },

        getBlind: async function ({ commit, state }){
            blind = [
                
            ]
            commit('setBlind',blind);
            // try {
            //     const response = await axios
            //     .get("/api/types",{
            //         headers: {Authorization: "Bearer "+localStorage.getItem('access_token')}})
            //     commit('setTypes',response.data.data);   
            //   } catch (error) {
                 
            //   }
        },

        
    }
}

export default modelsModule;