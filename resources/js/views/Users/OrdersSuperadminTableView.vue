<template>
    <v-row>
        <v-col cols="3">
            <v-card>
                <v-card-title style="background: #3ba2a9" class="font-weight-bold white--text">
                    Mi cuenta
                </v-card-title>
                <v-list dense color="#f0f0f0">
                    <v-list-item >
                        <v-list-item-icon>
                        </v-list-item-icon>
                        <v-list-item-content>
                            <v-list-item-title>Mi Perfil</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                    <v-list-group color="#3ba2a9" :value="true" no-action sub-group>
                        <template v-slot:activator>
                          <v-list-item-content>
                            <v-list-item-title>Órdenes</v-list-item-title>
                          </v-list-item-content>
                        </template>
                        <v-list-item
                        dense
                          v-for="(option, i) in admins"
                          :key="i"
                          link
                        >
                          <v-list-item-title v-text="option.title"></v-list-item-title>
                        </v-list-item>
                    </v-list-group>
                    <v-list-group  color="#3ba2a9" :value="true" no-action sub-group>
                      <template v-slot:activator>
                        <v-list-item-content>
                          <v-list-item-title>Cotizaciones</v-list-item-title>
                        </v-list-item-content>
                      </template>
                      <v-list-item
                      dense
                        v-for="(option, i) in cruds"
                        :key="i"
                        link
                      >
                        <v-list-item-title v-text="option.title"></v-list-item-title>
                      </v-list-item>
                    </v-list-group>
                </v-list>
            </v-card>
        </v-col>
        <v-col cols="9">
        <div class="text-center">
        </div>
        <v-data-table
        :items="orders"
        :headers="modelsHeaders"
        :search="search"
        :items-per-page="15"
        class="elevation-1"
        >
            <template v-slot:top>
                <v-toolbar dark color="#3ba2a9" class="mb-1" elevation="0">
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
            <template v-slot:item.total="{ item }">
                 {{mxCurrencyFormat.format(item.total)}} MXN
            </template>

            <template v-slot:item.state="{ item }">
                <div class="d-inline">
                    {{ item.state}}
                </div>
                <div class="d-inline">
                    <v-icon
                    v-if="item.state === 'Orden recibida'"
                    icon color="#acacac" class="mb-1 ml-2">
                        mdi-checkbox-blank-circle
                    </v-icon>
                    <v-icon
                    v-if="item.state === 'En Producción'"
                    icon color="#ff8b00" class="mb-1 ml-2">
                        mdi-checkbox-blank-circle
                    </v-icon>
                    <v-icon
                    v-if="item.state === 'Paquetería'"
                    icon color="#01afec" class="mb-1 ml-2">
                        mdi-checkbox-blank-circle
                    </v-icon>
                    <v-icon
                    v-if="item.state === 'Entrega'"
                    icon color="#0eae02" class="mb-1 ml-2">
                        mdi-checkbox-blank-circle
                    </v-icon>
                    <v-icon
                    v-if="item.state === 'Cancelada'"
                    icon color="#fd220c" class="mb-1 ml-2">
                        mdi-checkbox-blank-circle
                    </v-icon>
                    <v-icon
                    v-if="item.state === 'No Pagada'"
                    icon color="black" class="mb-1 ml-2">
                        diameter-variant
                    </v-icon>
                </div>

                <div class="d-inline" >
                    <v-menu bottom offset-x>
                      <template v-slot:activator="{ on, attrs }">
                            <v-btn icon v-bind="attrs" v-on="on" class="mb-1">
                                <v-icon>mdi-square-edit-outline</v-icon>
                            </v-btn>
                      </template>
                      <v-list dense>
                        <v-list-item
                        link
                        :class="item.state === option.text?'v-list-item--active':''"
                        :value="option.text"
                        dense
                        v-for="(option, index) in items"
                        :key="index"
                        >
                        <v-list-item-icon>

                          <v-icon v-if="item.state === option.text" :color="option.color">mdi-record-circle-outline</v-icon>
                          <v-icon v-else :color="option.color">mdi-circle-outline</v-icon>
                        </v-list-item-icon>
                        <v-list-item-content>
                          <v-list-item-title v-text="option.text"></v-list-item-title>
                        </v-list-item-content>
                        </v-list-item>
                      </v-list>
                    </v-menu>
                </div>
            </template>
            <template v-slot:item.actions="{ item }">
              	<v-icon small class="mr-2" @click="isOrdersAndQuotationsDialogActivated = true">
                	mdi-magnify
              	</v-icon>
            </template>
        </v-data-table>
        </v-col>
        <DashboardOrdersAndQuotationsDialog @emitClickCloseFromOrdersAndQuotationsDialog="emitClickCloseFromOrdersAndQuotationsDialog" :isOrdersAndQuotationsDialogActivated="isOrdersAndQuotationsDialogActivated"></DashboardOrdersAndQuotationsDialog>
    </v-row>
</template>

<script>
import { mapState, mapGetters } from "vuex";
import DashboardOrdersAndQuotationsDialog from '../../components/Dashboard/OrdersAndQuotations/DashboardOrdersAndQuotationsDialog.vue'

export default {
    data() {
        return {
            isOrdersAndQuotationsDialogActivated: false,
            search: null,
            mxCurrencyFormat : new Intl.NumberFormat('en-US', {style: 'currency', currency: 'USD'}),
            modelsHeaders: [
                {
                    text: 'ID Compra',
                    value: 'id',
                    sortable: false,
                    align: 'center',
                },
                { text: 'Total', value: 'total', align: 'center' },
                { text: 'Cliente', value: 'user', align: 'center' },
                { text: 'Estado de la orden', value: 'state', align: 'center' },
                { text: 'Fecha de creación', value: 'created_at', align: 'center' },
                { text: 'Última actualización', value: 'updated_at', align: 'center' },
                { text: 'Ver detalles', value: 'actions', align: 'center', sortable: false },
            ],
            items: [
                { text: 'Orden recibida', color: '#acacac' },
                { text: 'En Producción', color: '#ff8b00' },
                { text: 'Paquetería', color: '#01afec' },
                { text: 'Entregado', color: '#0eae02' },
                { text: 'Cancelada', color: '#fd220c' },
                { text: 'No pagada', color: 'black' },
            ],
        }
    },
    computed:{
        ...mapState({
          user: state => state.user,
          products: state => state.productsModule.products,
          loggedIn: state => state.loggedIn,
          orders: state => state.ordersModule.quotedOrders,
          order: state => state.ordersModule.quotedOrder,
        }),
        ...mapGetters([
          'loggedIn',
          'getLoginErrors',
          'getLoginStatus',
          'getUserStatus'
        ]),
    },
    methods:{
        emitClickCloseFromOrdersAndQuotationsDialog(){
            this.isOrdersAndQuotationsDialogActivated = false;
        }
    },
    components:{
        DashboardOrdersAndQuotationsDialog
    }
}
</script>
