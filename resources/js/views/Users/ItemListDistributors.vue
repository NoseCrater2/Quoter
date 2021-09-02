<template>
    <v-row>
        <v-col cols="12" md="3" sm="12" >
            <v-card>
                <v-card-title style="background: #3ba2a9" class="font-weight-bold white--text">
                    Mi cuenta
                </v-card-title>
                <v-list dense color="#f0f0f0">
                    <v-list-item link :to="{name: 'Profile'}">
                        <v-list-item-content>
                            <v-list-item-title>Mi Perfil</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                    <v-divider></v-divider>
                     <v-list-item link :to="{name: 'Orders', params: {option: 'ordenes'}}">
                        <v-list-item-content>
                            <v-list-item-title>Órdenes</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                     <v-list-item link :to="{name: 'Orders', params: {option: 'cotizaciones'}}">
                        <v-list-item-content>
                            <v-list-item-title>Cotizaciones</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                    <v-divider></v-divider>
                     <v-list-item link >
                         <!-- :to="{name: 'Marketcar'}" -->
                        <v-list-item-content>
                            <v-list-item-title>Mis compras <span style="color: red">(EN CONSTRUCCIÓN)</span></v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </v-list>
            </v-card>
        </v-col>
        <v-col cols="12" md="9" sm="12">
            <v-data-iterator
            no-data-text="NO DISPONIBLE"
            no-results-text="NO DISPONIBLE"
            :loading="loading"
            loading-text="CARGANDO..."
            :items="items"
            :items-per-page="8"
            :search="search"
            sort-by="created_date"
            :sort-desc="false"
            hide-default-footer>
                <template v-slot:header>
                    <v-toolbar dark color="#3ba2a9" class="mb-2" flat>
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
                    <v-row justify="center" justify-xl="start" justify-lg="start" justify-md="start" v-if="option === 'ordenes'">
                        <v-col v-for="item in props.items" :key="item.id" cols="12" xl="2" lg="3" md="4" sm="5">
                            <ItemOrder :item="item"  />
                        </v-col>
                    </v-row>
                    <v-row justify="center" justify-xl="start" justify-lg="start" justify-md="start" v-if="option === 'cotizaciones'">
                        <v-col v-for="item in props.items" :key="item.id" cols="12" xl="2" lg="3" md="4" sm="5">
                            <ItemQuotation :item="item" />
                        </v-col>
                    </v-row>
                </template>

                <template v-slot:footer>
                    <v-row align="center" class="mx-1">
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
                        <span>Página {{page}} de {{ numberOfPages > 0 ? numberOfPages : '1' }}</span>
                        <v-btn icon color="#3ba2a9" class="mr-1" @click="formerPage">
                            <v-icon>mdi-chevron-left</v-icon>
                        </v-btn>
                        <v-btn icon color="#3ba2a9" class="mr-1" @click="nextPage">
                            <v-icon>mdi-chevron-right</v-icon>
                        </v-btn>
                    </v-row>
                </template>
            </v-data-iterator>
            <!-- <div class="d-flex">
                <h1 class="font-weight-bolder" style="color: #3ba2a9">COTIZACIONES</h1>&nbsp;
                <h1 class="font-weight-light">ANTERIORES</h1>
            </div>
             <hr align="center" noshade="noshade" class="divider" style="height: 5px" size="3" width="35%" />
             <v-simple-table class="my-4"  style="background: #f3f3f3">
                  <template v-slot:default>
                    <thead>
                      <tr class="font-weight-bold">
                        <th class="text-center">
                          #Cotizacion
                        </th>
                        <th class="text-center">
                          Fecha de creación
                        </th>
                        <th class="text-center">
                          Total
                        </th>
                        <th class="text-center">
                          Ver detalles
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr
                        v-for="item in vencidas"
                        :key="item.name"
                      >
                        <td class="text-center">{{ item.id }}</td>
                        <td class="text-center">{{ item.created_at }}</td>
                        <td class="text-center">{{ item.total }}</td>
                        <td class="text-center">
                            <v-btn icon @click="isOrdersAndQuotationsDialogActivated = true">
                                <v-icon>mdi-magnify</v-icon>
                            </v-btn>
                            <v-btn icon>
                                <v-icon>mdi-delete</v-icon>
                            </v-btn>
                            <span>/</span>
                            <v-btn color="#3ba2a9" small rounded class="white--text">ACTUALIZAR</v-btn>
                        </td>
                      </tr>
                    </tbody>
                </template>
            </v-simple-table> -->
        </v-col>
        <DashboardOrdersAndQuotationsDialog @emitClickCloseFromOrdersAndQuotationsDialog="emitClickCloseFromOrdersAndQuotationsDialog" :isOrdersAndQuotationsDialogActivated="isOrdersAndQuotationsDialogActivated"></DashboardOrdersAndQuotationsDialog>
    </v-row>
</template>

<script>
import { mapState} from "vuex";
import ItemOrder from '../../components/CustomCards/ItemOrder.vue'
import ItemQuotation from '../../components/CustomCards/ItemQuotation.vue'
import DashboardOrdersAndQuotationsDialog from '../../components/Dashboard/OrdersAndQuotations/DashboardOrdersAndQuotationsDialog.vue'

export default {

    data(){
        return{
            isOrdersAndQuotationsDialogActivated: false,
            loading: false,
            dialog: false,
            page: 1,
            mxCurrencyFormat : new Intl.NumberFormat('en-US', {style: 'currency', currency: 'USD'}),
            itemsPerPageArray: [4, 8, 12],
            itemsPerPage: 4,
            search: '',
            vencidas: [
                {id: 'R140721/100', created_at: 'Aug 14, 2021', total: '$1,290.00 MXN'},
                {id: 'R140721/99', created_at: 'Aug 14, 2021', total: '$1,290.00 MXN'},
                {id: 'R140721/98', created_at: 'Aug 14, 2021', total: '$1,290.00 MXN'}
            ]
        }
    },

    mounted(){
        this.loading = true
        if(this.option === 'ordenes'){
            this.$store.dispatch('getQuotedOrders').then(()=>{
                this.loading = false
            })
        }else if(this.option === 'cotizaciones'){
            this.$store.dispatch('getQuotingOrders').then(()=>{
                this.loading = false
            })
        }
    },

    computed: {
         numberOfPages () {
            return Math.ceil(this.orders.length / this.itemsPerPage)
        },
         ...mapState({
            orders: state => state.ordersModule.quotedOrders,
            cotizaciones: state => state.ordersModule.quotingOrders,
        }),

        items(){
            if(this.option === 'ordenes'){
                return this.orders
            } else if(this.option === 'cotizaciones'){
                return this.cotizaciones
            }
        }
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
        emitClickCloseFromOrdersAndQuotationsDialog(){
            this.isOrdersAndQuotationsDialogActivated = false;
        }
    },

    props: {
        option: {
            type: String,
            required: true,
        }
    },

    components: {
        ItemOrder,
        ItemQuotation,
        DashboardOrdersAndQuotationsDialog
    }
}
</script>
