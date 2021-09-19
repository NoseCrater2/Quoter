<template>
    <v-hover v-slot="{ hover }">
        <v-card min-width="228" max-width="228" :class="!$vuetify.breakpoint.smAndUp ? 'mx-auto' : ''" :color="hover?'#3ba2a9':'white'"  :dark="hover?true:false" >
            <v-list-item>
                <v-list-item-content class="mt-n3">
                    <v-list-item-subtitle>
                        {{item.blinds}} PERSIANA(S)
                    </v-list-item-subtitle>
                </v-list-item-content>
                <v-list-item-avatar tile size="67">
                    <v-icon size="67" :color="hover?'white':'#3ba2a9'" >
                       mdi-clipboard-check
                    </v-icon>
                    <!-- <v-icon size="67" :color="hover?'white':'#CDDC39'"  v-else-if="item.state=='Orden en proceso'">
                       mdi-progress-wrench
                    </v-icon>
                    <v-icon size="67" :color="hover?'white':'#8BC34A'"  v-else-if="item.state=='Orden en envío'">
                       mdi-truck-fast
                    </v-icon>
                    <v-icon size="67" :color="hover?'white':'#4CAF50'"  v-else-if="item.state=='Orden entregada'">
                       mdi-truck-check
                    </v-icon> -->
                </v-list-item-avatar>
            </v-list-item>
            <v-card-title class="font-weight-bold py-1">
                <h3>Orden recibida</h3>
                <h3 :style="hover?'color: white':'color: #3ba2a9'">{{item.order}}</h3>
            </v-card-title>
            <v-list-item>
                <v-list-item-content class="mx-n3">
                        <v-col cols="3">
                            <div>
                                <v-badge
                                  class="mb-n2 font-weight-bold isHoverBadge"
                                  :content="item.blinds"
                                  :value="item.blinds"
                                  :color="hover?'white':'#3ba2a9'"
                                  overlap
                                  :offset-x="item.blinds > 9 ? '39' : '37'"
                                  offset-y="28"
                                >
                                  <v-icon :color="hover?'white':'#3ba2a9'" size="55">
                                    mdi-blinds
                                  </v-icon>
                                </v-badge>
                            </div>
                        </v-col>
                        <v-col cols="9" class="text-right">
                            <span :style="$vuetify.breakpoint.lgAndUp ? 'font-size: 1.2rem' : $vuetify.breakpoint.md ? 'font-size: 1.1rem' : 'font-size: 1.2rem'" class="font-weight-bold">
                               {{mxCurrencyFormat.format(item.total)}}
                            </span>
                            <span class="text-center" style="font-size: 0.85rem">MXN</span>
                        </v-col>
                </v-list-item-content>
            </v-list-item>
            <v-card-actions class="">
                <v-btn x-small outlined rounded text @click="localMethodIsOrdersAndQuotationsDialogActivatedOn(item)">Ver Detalles</v-btn>
                <v-spacer></v-spacer>
                <v-chip small :color="hover?'#3ba2a9':'white'" :text-color="hover?'white':'black'">
                    <v-avatar class="white" >
                        <v-icon v-if="item.state === 'Recibida'" size="22" color="grey lighten-1">mdi-checkbox-blank-circle</v-icon>
                        <v-icon v-if="item.state === 'En produccion'" size="22" color="orange darken-1">mdi-checkbox-blank-circle</v-icon>
                        <v-icon v-if="item.state === 'Paqueteria'" size="22" color="blue darken-1">mdi-checkbox-blank-circle</v-icon>
                        <v-icon v-if="item.state === 'Entregada'" size="22" color="green darken-1">mdi-checkbox-blank-circle</v-icon>
                        <v-icon v-if="item.state === 'Cancelada'" size="22" color="red darken-2">mdi-checkbox-blank-circle</v-icon>
                        <v-icon v-if="item.state === 'No Pagada'" size="22" color="black">mdi-diameter-variant</v-icon>
                    </v-avatar>
                   {{ item.state}}
                </v-chip>
            </v-card-actions>
            <!-- <v-col v-if="item.user" cols="12" class="text-end mt-n9">
                <v-icon size="17">mdi-account</v-icon><span class="mb-4 caption">{{item.user}}</span>
            </v-col> -->
            <!-- <v-list-item class="mb-n4">
                <v-list-item-content class="mx-n4">
                    <v-col cols="6">
                        <v-row>
                            <v-col cols="3">
                                <v-icon>mdi-calendar-check</v-icon>
                            </v-col>
                            <v-col cols="9">
                                <span class="subtitle-2">Fecha de pedido</span>
                                <div class="caption">
                                    {{item.created_at}}
                                </div>
                            </v-col>
                        </v-row>
                    </v-col>
                    <v-divider vertical></v-divider>
                    <v-col cols="6">

                    </v-col>
                </v-list-item-content>
            </v-list-item> -->
        </v-card>
    </v-hover>
</template>

<script>
import { mapState } from 'vuex';
export default {
    data(){
        return {
            localToPropTotalPrice: 0,
            isOrdersAndQuotationsDialogActivated: false,
            mxCurrencyFormat : new Intl.NumberFormat('en-US', {style: 'currency', currency: 'USD'}),
        }
    },
    computed:{
        ...mapState({
            orders: state => state.ordersModule.orders,
            quotedOrders: state => state.ordersModule.quotedOrders,
            quotedOrder: state => state.ordersModule.quotedOrder,
            quotingOrders: state => state.ordersModule.quotingOrders,
            quotingOrder : state => state.ordersModule.quotingOrder,
            user: (state) => state.user,
        }),
    },
    methods:{
        localMethodIsOrdersAndQuotationsDialogActivatedOn(localItem){
            this.$store.dispatch('getQuotedOrder', localItem.id).then(()=>{
                // this.localToPropTotalPrice = localItem.total;
                // this.isOrdersAndQuotationsDialogActivated = true;
                // console.log(this.quotedOrders, this.quotedOrder)
                this.$emit('emitFromItemOrder', localItem)
            });

        },
        emitClickCloseFromOrdersAndQuotationsDialog(){
            this.localToPropTotalPrice = 0;
            this.isOrdersAndQuotationsDialogActivated = false;
        }
    },
    props: {
        item: {
            type: Object,
            required: true
        }
    }
}
</script>
