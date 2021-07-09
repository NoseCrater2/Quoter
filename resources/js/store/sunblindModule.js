const sunblindModule = {
    state: {
        sunblind: [],
        relatedSunblinds: [],
    },

    getters: {
   
    },

    mutations: {
        setSunblind(state, sunblind){
            state.sunblind = sunblind
        },
        setRelatedSunblind(state, relatedSunblinds){
            state.relatedSunblinds = relatedSunblinds
        },

    },

    actions: {
       

        getSunblind: async function ({ commit, state }, idVariant){
            try {
                const response = await axios
                .get("/api/sunblinds/"+idVariant)
                commit('setSunblind',response.data.data);
            } catch (error) {}
        },

        // 'getRelated/{variant}'

        getRelatedSunblind: async function ({ commit, state }, idVariant){
            try {
                const response = await axios
                .get("/api/getRelatedBlinds/"+idVariant)
                commit('setRelatedSunblind',response.data.data);
            } catch (error) {}
        },

    },
}

export default sunblindModule;