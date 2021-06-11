
const ordersModule = {

    state:{
      orders: JSON.parse(localStorage.getItem('orders')) || [],
      totalPrice: 0,
      quotedOrders: [],
      quotedOrder: [],
      quotingOrders: [],
      quotingOrder: [],
       
    },


    getters:{
       

        countBlinds(state){
            return state.orders.length
        },
        orderBlinds(state){
            return state.orders
        },

        totalPrice(state){
            let prices = 0
            state.orders.map(function(order){
                let pt = parseFloat(order.price) +
                parseFloat(order.motor.price) +
                parseFloat(order.motor.flexiballetPrice) + 
                parseFloat(order.motor.galleryPrice) + 
                parseFloat(order.motor.manufacturerPrice) + 
                parseFloat(order.motor.stringPrice)
                
                return prices += pt
           })
            
            return prices
            
        },



    },
    mutations:{
        saveOrder(state,newOrder){
            state.orders.push(newOrder);
            //state.newUserId = newUser.id;
        },

        setQuotedOrders(state, orders){
          state.quotedOrders = orders
          //state.newUserId = newUser.id;
        },

        setQuotedOrder(state, order){
          state.quotedOrder = order
          //state.newUserId = newUser.id;
        },

        setQuotingOrders(state, orders){
          state.quotingOrders = orders
          //state.newUserId = newUser.id;
        },

        setQuotingOrder(state, order){
          state.quotingOrder = order
          //state.newUserId = newUser.id;
        },

        pushProductToCart (state, item){
            state.orders.push(item)
            localStorage.setItem('orders', JSON.stringify(state.orders))
        },

        editOrder (state, item){
            state.orders.map(function(currentOrder) {
                if (currentOrder.id === item.id) {
                    Object.assign(currentOrder, item);
                    localStorage.setItem('orders', JSON.stringify(state.orders))
                }
            });
        },

        incrementItemQuantity(state, item){
            item.quantity++
        },

        sumTotalPrice(state, price){
            let currentPrice = parseFloat(state.totalPrice)
            let newPrice = parseFloat(price)
            state.totalPrice = currentPrice + newPrice
        },

        deleteOrder(state, id) {
            let  u = state.orders.find((order => order.id === id))
            state.orders.splice(state.orders.indexOf(u),1)
            localStorage.setItem('orders', JSON.stringify(state.orders))   
        },

        deleteQuotingOrder(state, deleteOrder) {
            let  u = state.quotingOrders.find((order => order.id === deleteOrder.id))
           state.quotingOrders.splice(state.quotingOrders.indexOf(u),1)
        },

        assignOrder(state, orders){
            state.orders = orders.blinds
        },

    },
    actions:{
        addToOrder (context, blind){
            if(context.state.orders.length == 0){
                blind.id = 1
            }else{
                blind.id = context.state.orders[context.state.orders.length - 1].id + 1
            }
            context.commit('pushProductToCart', blind)
        },

        editOrder (context, blind){
            context.commit('editOrder', blind)
        },
        
        deleteOrder(context,id){
             context.commit('deleteOrder',id);
        },

        saveOrders: async function ({ commit}, orders){
            try {
                const response = await axios
                .post("/api/orders", {'orders':orders, 'is_quotation': 0})
                // commit('setProducts',response.data.data);
            } catch (error) {}
        
        },

        saveQuotations: async function ({ commit}, orders){
            try {
                const response = await axios
                .post("/api/orders", {'orders':orders, 'is_quotation': true})
            } catch (error) {}
        
        },

        updateQuotations: async function ({ state}, orders){
            try {
                const response = await axios
                .put("/api/orders/" + orders.id, orders).then((response) => {
                    console.log(response)
                    if(response.status === 200){
                        localStorage.removeItem("orders");
                        state.orders = []
                    }
                })
            } catch (error) {}
        
        },

        updateOrders: async function ({state}, orders){
            try {
                const response = await axios
                .put("/api/orders/" + orders.id, orders).then((response) => {
                    if(response.status === 200){
                        localStorage.removeItem("orders");
                        state.orders = []
                    }
                })
            } catch (error) {}
        
        },

        getQuotedOrders: async function ({ commit, state }){
            try {
                const response = await axios
                .get("/api/orders")
                commit('setQuotedOrders',response.data.data);
            } catch (error) {}
        },

        getQuotedOrder: async function ({ commit, state },id){
            try {
                const response = await axios
                .get("/api/orders/"+id)
                commit('setQuotedOrder',response.data.data);
            } catch (error) {}
        },
        getQuotingOrders: async function ({ commit, state }){
            try {
                const response = await axios
                .get("/api/quotations")
                commit('setQuotingOrders',response.data.data);
            } catch (error) {}
        },

        getQuotingOrder: async function ({ commit, state },id){
            try {
                const response = await axios
                .get("/api/orders/"+id)
                commit('setQuotingOrder',response.data.data);
            } catch (error) {}
        },

        deleteQuotingOrder: async function ({ commit },id){
            try {
                const response = await axios
                .delete("/api/orders/" + id)
                commit('deleteQuotingOrder',response.data.data);
            } catch (error) {}
        },

        editQuotingOrder: async function ({ commit },id){
            try {
                const response = await axios
                .get("/api/orders/"+id)
                commit('assignOrder',response.data.data);
            } catch (error) {}
        },

        changeToOrder: async function ({ commit }, id){
            try {
                const response = await axios
                .get("/api/changequoting/"+id)
                commit('deleteQuotingOrder',response.data.data);
            } catch (error) {}
        },
    },
}

export default ordersModule;