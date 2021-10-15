<template>
    <v-container fluid>

        <div class="text-center" v-if="option.includes('admin')">
            <h1 class="font-weight-light d-inline">{{option.split('-')[0].toUpperCase()}}</h1>
            <h1 class="d-inline" style="color: #3ba2a9">DISTRIBUIDORES</h1>
        </div>

        <div class="text-center" v-else>
            <h1 class="d-inline" style="color: #3ba2a9">{{option.split('-')[0].toUpperCase()}}</h1>
            <h1 class="font-weight-light d-inline">PROPIAS</h1>
        </div>

        <OrdersSuperadminTableView
        v-if="user.role === 'Superadministrador' || user.role === 'Administrador' || user.role === 'Vendedor'"
        :option="option"
        >
        </OrdersSuperadminTableView>

        <ItemListDistributors  v-else-if="user.role === 'Distribuidor'"  :option="option" />


        <!-- COMIENZA DIALOGO DE DETALLES -->
        <!-- <v-dialog v-model="dialog" fullscreen persistent transition="dialog-bottom-transition">
            <v-card tile>
                <v-toolbar color="#3ba2a9">
                    <v-btn icon dark @click="dialog = false">
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                </v-toolbar>
                <DashboardQuotedBlindsView :localOrders="order.blinds" :localOrder="orderNameDetails"></DashboardQuotedBlindsView>
            </v-card>
        </v-dialog> -->
        <!-- TERMINA DIALOGO DE DETALLES -->
    </v-container>
</template>

<script>
import { mapState, mapGetters } from "vuex";
import OrdersSuperadminTableView from './OrdersSuperadminTableView.vue'
// import DashboardQuotedBlindsView from './DashboardQuotedBlindsView.vue'
import ItemListDistributors from './ItemListDistributors.vue'
export default {
    data(){
        return{
            orderNameDetails: {},
            isLoadedOrders: false,
            dialog: false,
            page: 1,
            mxCurrencyFormat : new Intl.NumberFormat('en-US', {style: 'currency', currency: 'USD'}),
            itemsPerPageArray: [4, 8, 12],
            itemsPerPage: 4,
            search: '',
            admins: [
                {title: 'Mis Ordenes', route: ''},
                {title: 'Ordnes Distribuidores', route: ''},
            ],
            cruds: [
                {title: 'Mis Cotizaciones', route: ''},
                {title: 'Cotizaciones Distribuidores', route: ''},
            ],
        }
    },

    methods: {
        // openDetailsDialog(id){
        //     this.$store.dispatch('getQuotedOrder',id).then(()=>{
        //         this.orderNameDetails = this.orders.find(el => el.id == id)
        //         this.dialog = true
        //     });

        // }
    },
    computed:{

        ...mapState({
            orders: state => state.ordersModule.quotedOrders,
            // order: state => state.ordersModule.quotedOrder,
            user: state => state.user,
            // loggedIn: state => state.loggedIn,
        }),
        ...mapGetters([
          'loggedIn',
          'getLoginErrors',
          'getLoginStatus',
          'getUserStatus'
        ]),
    },



    components:{
        OrdersSuperadminTableView,
        // DashboardQuotedBlindsView,
        ItemListDistributors
    },

    mounted(){
        // this.$store.dispatch('getQuotedOrders').then(()=>{
        //     this.isLoadedOrders = true;
        // });
    },

    props: {
        option: {
            type: String,
            required: true,
        }
    }
}
</script>
<style scoped>
.rotado{
  writing-mode: vertical-lr;
  transform: rotate(180deg);
  text-align:center;
}
/* /ESTE ES UN DEEP SELECTOR >>> */
>>>.v-badge__badge.white{
    color: #3ba2a9;
}
</style>
