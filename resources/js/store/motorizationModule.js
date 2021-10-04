const motorizationsModule = {
    state: {
        motorizations: [],
        controls: [],
        filteredMotorizations: [],
        galleries: [],
    },

    getters: {
        getMotor: (state)=> (id) => {
            return state.motorizations.find((m) => m.id === id)
        },
        getFilteredMotorizations: (state)=> (name) => {
            return state.motorizations.filter((m) => m.type === name)
        },
        getControl: (state)=> (id) => {
            return state.controls.find((c) => c.id === id)
        },
    },

    mutations: {
        setMotorizations(state, motorizations){
            state.motorizations = motorizations
        },

        setFilteredMotorizations(state, filteredMotorizations){
            state.filteredMotorizations = filteredMotorizations
        },

        setControls(state, controls){
            state.controls = controls
        },

        setGalleries(state, galleries){
            state.galleries = galleries
        },
    },

    actions: {
        getMotorizations: async function ({ commit, state }){
            if(state.motorizations.length === 0){
            try {
                const response = await axios
                .get("/api/motorizations")
                commit('setMotorizations',response.data.data);
            } catch (error) {}
        }
        },

        getFilteredMotorizations: async function ({ commit, state }, typeId){

            try {
                const response = await axios
                .get("/api/getFilteredMotorizations/"+typeId)
                commit('setFilteredMotorizations',response.data.data);
            } catch (error) {}

        },

        getControls: async function ({ commit, state }){
           if(state.controls.length == 0){
            try {
                const response = await axios
                .get("/api/controls/")
                commit('setControls',response.data.data);
            } catch (error) {}
        }

        },

        getGalleries: async function ({ commit, state }){
            if(state.galleries.length === 0){
            try {
                const response = await axios
                .get("/api/galleries")
                commit('setGalleries',response.data.data);
            } catch (error) {}
        }
        },
    }
}

export default motorizationsModule;
