import { bind } from "lodash";


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
            return state.totalPrice
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

          incrementItemQuantity(state, item){
              item.quantity++
          },

          sumTotalPrice(state, price){
              let currentPrice = parseFloat(state.totalPrice)
              let newPrice = parseFloat(price)
            state.totalPrice = currentPrice + newPrice
        },

    },
    actions:{
        addToOrder (context, blind){
           
            const orderItem = context.state.orders.find(item => item.id === blind.id)
            
            if(!orderItem){
                context.commit('pushProductToCart', blind)
                context.commit('sumTotalPrice', blind.price)
            }else{
                context.commit('incrementItemQuantity', orderItem)
            }

            //Aquí se puede añadir otro commit para reducir el inventario
        }
    },
}

export default ordersModule;