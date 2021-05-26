
const ordersModule = {

    state:{
      orders: JSON.parse(localStorage.getItem('orders')) || [],
      totalPrice: 0,
      quotedOrders: [],
      quotedOrder: [],
       
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
          pushProductToCart (state, item){
           
              state.orders.push(item)
              localStorage.setItem('orders', JSON.stringify(state.orders))
            //   state.orders.push(item)
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

    },
    actions:{
        addToOrder (context, blind){
            
            if(context.state.orders.length == 0){
                blind.id = 1
            }else{
                blind.id = context.state.orders[context.state.orders.length - 1].id + 1
            }
           
            //  const orderItem = context.state.orders.find(item => item.id === blind.id)
            
            // // if(!orderItem){
                context.commit('pushProductToCart', blind)
               // context.commit('sumTotalPrice', blind.price)
            //  }
             //else{
            //     context.commit('incrementItemQuantity', orderItem)
            // }

            //Aquí se puede añadir otro commit para reducir el inventario
        },

        editOrder (context, blind){
            context.commit('editOrder', blind)
        },
        
        deleteOrder(context,id){
             context.commit('deleteOrder',id);
        },

        saveOrders: async function ({ commit}, orders){
            console.log(orders)
            try {
                const response = await axios
                .post("/api/orders", {'orders':orders})
                // commit('setProducts',response.data.data);
            } catch (error) {}
        
        },

        getQuotedOrders: async function ({ commit, state }){
            try {
                const response = await axios
                .get("/api/orders/")
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
    },
}

export default ordersModule;