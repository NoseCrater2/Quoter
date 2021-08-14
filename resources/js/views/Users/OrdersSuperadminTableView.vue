<template>
    <div>
        <v-data-table
        :items="orders"
        :headers="modelsHeaders"
        :search="search"
        :items-per-page="15"
        class="elevation-1"
        >
         <!-- :src="`img/modelos/medium/${item.image}`" -->
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
            <template v-slot:item.actions="{ item }">
              	<v-icon small class="mr-2" @click="editItemOrdersView(item)">
                	mdi-magnify
              	</v-icon>
            </template>
        </v-data-table>
    </div>
</template>

<script>
import { mapState, mapGetters } from "vuex";
export default {
    data() {
        return {
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
        editItemOrdersView(item){
            this.$emit('editItemOrdersView', item.id);
        }
    }
}
</script>
