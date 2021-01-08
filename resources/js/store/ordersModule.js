
const ordersModule = {

    state:{
      orders:[],
      totalPrice: 0,
       
    },


    getters:{
       
        getPrice(state) {
            
            return 0
          },

        countBlinds(state){
            return state.orders.length
        },
        orderBlinds(state){
            return state.orders
        },

        totalPrice(state){
             
            let prices = 0
            state.orders.map(function(order){
                let pt = parseFloat(order.price) + parseFloat(order.motor.price)
             return prices += pt
           })
            
            return prices
            
        }
    },
    mutations:{
        saveOrder(state,newOrder){
            state.orders.push(newOrder);
            //state.newUserId = newUser.id;
          },

          pushProductToCart (state, item){
              state.orders.push(item)
          },

        editOrder (state, item){
            state.orders.map(function(currentOrder) {
                if (currentOrder.id === item.id) {
                    Object.assign(currentOrder, item);
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
          
           
          },

    },
    actions:{
        addToOrder (context, blind){
            blind.id = (context.state.orders.length + 1)
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
    },
}

export default ordersModule;