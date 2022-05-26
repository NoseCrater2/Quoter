const matrixModule = {
    state : {
        matrix: []
    },

    mutations : {
        setMatrix (state, matrix) {
            state.matrix = matrix
        }
    },

    actions : {
        getMatrix: async function ({commit}, file){
            try {
                const response  = await axios.get('/api/' + file);
                commit('setMatrix', response.data)
            } catch (error) {
                
            }
        }
    } 
}

export default matrixModule;