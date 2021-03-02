<template>
    <v-container fluid>
        <v-data-iterator
        :items="orders"
        :items-per-page="itemsPerPage"
        :search="search"
        sort-by="created_date"
        :sort-desc="false"
        hide-default-footer>
            <template v-slot:header>
                <v-toolbar dark color="#3ba2a9" class="mb-1">
                    <v-text-field
                    v-model="search"
                    clearable
                    flat
                    solo-inverted
                    hide-details
                    prepend-inner-icon="mdi-magnify"
                    label="Buscar orden"
                    ></v-text-field>
                </v-toolbar>
            </template>

            <template v-slot:default="props">
                <v-row>
                    <v-col v-for="item in props.items" :key="item.id" cols="12" sm="6" md="4" lg="3">
                        <v-hover v-slot="{ hover }">
                            <v-card class="mx-auto" :color="hover?'#3ba2a9':'white'"  :dark="hover?true:false" >
                              
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <div class="overline mb-4">{{ item.blinds}} PERSIANA(S)</div>
                                        <v-list-item-title class="headline mb-1">
                                            {{item.state}}
                                        </v-list-item-title>
                                    </v-list-item-content>
                                    <v-list-item-avatar  tile size="80">
                                        <v-icon size="80" :color="hover?'white':'#3ba2a9'"  v-if="item.state=='Orden recibida'">
                                           mdi-clipboard-check
                                        </v-icon>
                                        <v-icon size="80" :color="hover?'white':'#CDDC39'"  v-else-if="item.state=='Orden en proceso'">
                                           mdi-progress-wrench
                                        </v-icon>
                                        <v-icon size="80" :color="hover?'white':'#8BC34A'"  v-else-if="item.state=='Orden en envío'">
                                           mdi-truck-fast
                                        </v-icon>
                                        <v-icon size="80" :color="hover?'white':'#4CAF50'"  v-else-if="item.state=='Orden entregada'">
                                           mdi-truck-check
                                        </v-icon>
                                    </v-list-item-avatar>
                                </v-list-item>
                                <v-list-item>
                                    <v-list-item-content class="text-decoration-line-through" style="font-size: 1.5rem">
                                        {{mxCurrencyFormat.format(item.subtotal)}}
                                    </v-list-item-content>
                                </v-list-item>

                                <v-list-item>
                                    <v-list-item-content  style="font-size: 1.8rem">
                                      {{mxCurrencyFormat.format(item.total)}}
                                    </v-list-item-content>
                                </v-list-item>
                                <v-list-item>
                                    <v-list-item-content >
                                        Fecha de creación: 
                                    </v-list-item-content>
                                    <v-list-item-icon>
                                        {{item.created_at}}
                                    </v-list-item-icon>
                                </v-list-item>
                                <v-list-item>
                                    <v-list-item-content >
                                        Última actualización: 
                                    </v-list-item-content>
                                    <v-list-item-icon>
                                        {{item.updated_at}}
                                    </v-list-item-icon>
                                </v-list-item>

                                <v-card-actions>
                                    <v-btn outlined rounded text @click="openDetailsDialog(item.id)">Ver detalles</v-btn>
                                    <v-spacer></v-spacer>
                                </v-card-actions>
                            </v-card>
                        </v-hover>
                    </v-col>
                </v-row>
            </template>

            <template v-slot:footer>
                <v-row class="mt-2" align="center" justify="center">
                    <span class="grey--text">Ordenes por página</span>
                    <v-menu offset-y>
                        <template v-slot:activator="{ on, attrs}">
                            <v-btn dark text color="#3ba2a9" class="ml-2" v-bind="attrs" v-on="on">
                                {{itemsPerPage}}
                                <v-icon>mdi-chevron-down</v-icon>
                            </v-btn>
                        </template>
                        <v-list>
                            <v-list-item v-for="(number, index) in itemsPerPageArray" :key="index" @click="updateItemsPerPage(number)">
                                <v-list-item-title>
                                    {{number}}
                                </v-list-item-title>
                            </v-list-item>
                        </v-list>
                    </v-menu>
                    <v-spacer></v-spacer>
                    <span>Página {{page}} de {{ numberOfPages }}</span>
                    <v-btn icon color="#3ba2a9" class="mr-1" @click="formerPage">
                        <v-icon>mdi-chevron-left</v-icon>
                    </v-btn>
                    <v-btn icon color="#3ba2a9" class="mr-1" @click="nextPage">
                        <v-icon>mdi-chevron-right</v-icon>
                    </v-btn>
                </v-row>
            </template>
        </v-data-iterator>
        <v-row justify="center">
            <v-dialog v-model="dialog" fullscreen hide-overlay transition="dialog-bottom-transition">
                <v-card>
                    <v-toolbar dark>
                        <v-btn icon dark @click="dialog = false">
                            <v-icon>mdi-close</v-icon>
                        </v-btn>
                    </v-toolbar>
                    <v-row v-for="blind in order.blinds" :key="blind.id">
                        {{blind.type}}
                    </v-row>
                </v-card>
            </v-dialog>
        </v-row>
    </v-container>
</template>

<script>
import { mapState } from "vuex";
export default {
    data(){
        return{
            dialog: false,
            page: 1,
            mxCurrencyFormat : new Intl.NumberFormat('en-US', {style: 'currency', currency: 'USD'}),
            itemsPerPageArray: [4, 8, 12],
            itemsPerPage: 4,
            search: '',
        }
    },

    computed:{
        numberOfPages () {
            return Math.ceil(this.orders.length / this.itemsPerPage)
        },
        ...mapState({
            orders: state => state.ordersModule.quotedOrders,
            order: state => state.ordersModule.quotedOrder,
        }),
    },

    methods:{
        updateItemsPerPage (number) {
            this.itemsPerPage = number
        },
        nextPage () {
            if (this.page + 1 <= this.numberOfPages) this.page += 1
        },
        formerPage () {
            if (this.page - 1 >= 1) this.page -= 1
        },
        openDetailsDialog(id){
            this.$store.dispatch('getQuotedOrder',id).then(()=>{
                 this.dialog = true
            });
           
        }
    },

    mounted(){
        this.$store.dispatch('getQuotedOrders');
    }
}
</script>