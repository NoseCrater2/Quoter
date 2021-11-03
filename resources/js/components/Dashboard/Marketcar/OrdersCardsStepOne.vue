<template>
    <v-row dense justify="space-around">
      <v-col cols="12" xl="4" lg="6" md="12" sm="12" v-for="(item) in computedNoPaidOrders" :key="item.id">
            <v-card :color="methodColoredBorder(item.id) ? '#80CBC4' : 'grey lighten-2'" min-width="338" max-width="343" class="pa-2 mx-auto" outlined>
                <v-list-item style="background-color: white">
                    <v-list-item-content>
                        <v-list-item-title class="text-uppercase text-start mt-n3">
                            {{ item.blinds }} Persiana(s)
                        </v-list-item-title>
                    </v-list-item-content>
                    <v-list-item-avatar class="mr-n2" tile size="67">
                        <v-icon size="67" color="black">
                           mdi-clipboard-remove
                        </v-icon>
                    </v-list-item-avatar>
                </v-list-item>
                <v-list-item style="background-color: white" class="mt-n4">
                    <v-list-item-content class="mx-n4 mt-n7">
                        <v-col cols="12">
                            <div>Orden {{ item.state }}</div>
                            <div class="text-uppercase font-weight-bold" style="color: #3ba2a9; font-size: 1.2rem">{{item.order}}</div>
                        </v-col>
                            <v-col cols="3">
                                <div>
                                    <v-badge
                                      class="mb-n2 font-weight-bold isHoverBadge"
                                      :content="item.blinds"
                                      :value="item.blinds"
                                      color="#3ba2a9"
                                      overlap
                                      :offset-x="item.blinds > 9 ? '39' : '37'"
                                      offset-y="28"
                                    >
                                      <v-icon color="#3ba2a9" size="55">
                                        mdi-blinds
                                      </v-icon>
                                    </v-badge>
                                </div>
                            </v-col>
                            <v-col cols="9" class="text-right">
                                <span style="font-size: 2rem" class="font-weight-bold">
                                   {{mxCurrencyFormat.format(item.total)}}
                                </span>
                                <span class="text-center" style="font-size: 0.85rem">MXN</span>
                            </v-col>
                    </v-list-item-content>
                </v-list-item>
                <v-card-text>
                    <v-btn @click="pushToStepTwo(item)" block color="orange darken-1" class="white--text font-weight-bold" style="font-size: 1.3rem" tile >REVISAR Y PAGAR</v-btn>
                </v-card-text>
                <v-card-actions>
                    <v-btn @click="localMethodDetailsItemSendToMarketcarView(item.id)" text class="text-decoration-underline">Ver detalles</v-btn>
                    <v-spacer></v-spacer>
                    <v-btn @click="methodCancelOrder(item.id)" text>Cancelar orden</v-btn>
                </v-card-actions>
            </v-card>
      </v-col>
    </v-row>
</template>

<script>
import { mapState } from 'vuex';
export default {
    created(){
        if(Object.keys(this.quotedOrder).length == 0){
            if(localStorage.getItem('quotedOrder') !== null){
                Object.assign(this.quotedOrder, this.$store.getters.getQuotedOrder.order)
                this.idSelectedOrder = this.quotedOrder.id;
            }
        }
    },
    data() {
        return {
            mxCurrencyFormat : new Intl.NumberFormat('en-US', {style: 'currency', currency: 'USD'}),
            idSelectedOrder: localStorage.getItem('quotedOrder') !== null ? JSON.parse(localStorage.getItem('quotedOrder')).order.id : -1
        }
    },
    methods:{
        pushToStepTwo(item){
            this.$store.dispatch('getQuotedOrder', item.id).then(()=>{
                localStorage.removeItem('quotedOrder');
                localStorage.setItem('quotedOrder', JSON.stringify({order:this.quotedOrder, step: 2, paymentType: '', isCheckTerms: false, flagIsStepFour: false, card: {isNewCard: false, isCurrentCard: false, currentCard: null, selectedPaymentSchema: ''}}));
                this.idSelectedOrder = this.quotedOrder.id;
                this.$router.push({name: 'StepTwoDetails'});
            })

        },
        methodCancelOrder(itemID){
            this.$emit('emitCancelOrder', itemID);
        },
        localMethodDetailsItemSendToMarketcarView(itemID){
            this.$emit('emitDetailsItemFromOrdersCardsStepOneView', itemID);
        },
        methodColoredBorder(id){
            if(this.idSelectedOrder > -1){
                if(this.idSelectedOrder == id){
                    return true;
                }
            }
            return false;
        }
    },
    computed:{
        ...mapState({
            quotedOrders: state => state.ordersModule.quotedOrders,
            quotedOrder: state => state.ordersModule.quotedOrder,
        }),
        computedNoPaidOrders(){
            return this.quotedOrders.filter(itemOrder=> itemOrder.state == 'No Pagada');
        }
    }
}
</script>
