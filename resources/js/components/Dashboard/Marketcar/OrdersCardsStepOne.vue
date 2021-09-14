<template>
    <v-row dense justify="space-around">
      <v-col cols="12" xl="4" lg="6" md="12" sm="12" v-for="(item) in itemOrder" :key="item.id">
            <v-card min-width="338" max-width="343" class="pa-2 mx-auto" outlined color="grey lighten-2">
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
                                    <!-- <div class="caption ml-1">{{ item.blinds > 1 ? 'Persianas' : 'Persiana'}}</div> -->
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
                <!-- <v-list-item class="mt-n5 mb-n7">
                    <v-list-item-content class="mx-n6">
                        <v-col cols="12">
                            <v-card-actions>

                            </v-card-actions>
                        </v-col>
                        <v-col cols="12" class="mt-n7">

                        </v-col>
                    </v-list-item-content>
                </v-list-item> -->
                <v-card-text>
                    <v-btn @click="localMethodCheckAndBuySendToMarketcarView(item)" block color="orange darken-1" class="white--text font-weight-bold" style="font-size: 1.3rem" tile >REVISAR Y PAGAR</v-btn>
                </v-card-text>
                <v-card-actions>
                    <v-btn @click="localMethodDetailsItemSendToMarketcarView(item)" text class="text-decoration-underline">Ver detalles</v-btn>
                    <v-spacer></v-spacer>
                    <v-btn text >Cancelar orden</v-btn>
                </v-card-actions>
            </v-card>
      </v-col>
    </v-row>
</template>

<script>
import { mapState } from 'vuex';
export default {
    mounted(){
        console.log(this.itemOrder)
    },
    data() {
        return {
            mxCurrencyFormat : new Intl.NumberFormat('en-US', {style: 'currency', currency: 'USD'}),
        }
    },
    methods:{
        localMethodCheckAndBuySendToMarketcarView(item){
            this.$emit('emitCheckAndBuyFromOrdersCardsStepOneView', item)
        },
        localMethodDetailsItemSendToMarketcarView(item){
            this.$emit('emitDetailsItemFromOrdersCardsStepOneView', item)
        }
    },
    computed:{

    },
    components:{

    },
    props:{
        itemOrder:{
            type: Array
        }
    }
}
</script>
