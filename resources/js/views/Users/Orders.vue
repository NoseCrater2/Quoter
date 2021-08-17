<template>
    <v-container fluid>
        <!-- SI ES SUPERADMINISTRADOR CARGA TABLA DE ORDENES -->
        <OrdersSuperadminTableView @editItemOrdersView="openDetailsDialog" v-if="isLoadedOrders && (loggedIn && (user.role === 'Superadministrador'))"></OrdersSuperadminTableView>
        <!-- SI ES DIFERENTE DE SUPERADMINISTRADOR CARGA CARDS DE ORDENES -->
        <v-data-iterator
        v-else-if="(isLoadedOrders)"
        :items="orders"
        :items-per-page="itemsPerPage"
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
                <v-row>
                    <v-col v-for="item in props.items" :key="item.id" cols="12" xl="2" lg="3" md="4" sm="6">
                        <v-hover v-slot="{ hover }">
                            <v-card width="303" :color="hover?'#3ba2a9':'white'"  :dark="hover?true:false" >
                                <v-list-item>
                                    <v-list-item-content>
                                        <v-list-item-title style="font-size: 1.15rem" class="text-uppercase font-weight-bold text-start">
                                            {{item.state}}
                                        </v-list-item-title>
                                    </v-list-item-content>
                                    <v-list-item-avatar tile size="67">
                                        <v-icon size="67" :color="hover?'white':'#3ba2a9'"  v-if="item.state=='Orden recibida'">
                                           mdi-clipboard-check
                                        </v-icon>
                                        <v-icon size="67" :color="hover?'white':'#CDDC39'"  v-else-if="item.state=='Orden en proceso'">
                                           mdi-progress-wrench
                                        </v-icon>
                                        <v-icon size="67" :color="hover?'white':'#8BC34A'"  v-else-if="item.state=='Orden en envío'">
                                           mdi-truck-fast
                                        </v-icon>
                                        <v-icon size="67" :color="hover?'white':'#4CAF50'"  v-else-if="item.state=='Orden entregada'">
                                           mdi-truck-check
                                        </v-icon>
                                    </v-list-item-avatar>
                                </v-list-item>
                                <!-- <v-list-item>
                                    <v-list-item-content class="text-decoration-line-through" style="font-size: 1.5rem">
                                        {{mxCurrencyFormat.format(item.subtotal)}}
                                    </v-list-item-content>
                                </v-list-item> -->


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
                                                    <!-- <div class="caption ml-1">{{ item.blinds > 1 ? 'Persianas' : 'Persiana'}}</div> -->
                                                </div>
                                            </v-col>
                                            <v-col cols="9" class="text-right">
                                                <span style="font-size: 2rem" class="font-weight-bold">
                                                   {{mxCurrencyFormat.format(item.total)}}
                                                </span>
                                                <span class="text-center">MXN</span>
                                            </v-col>
                                    </v-list-item-content>
                                </v-list-item>
                                <v-col v-if="item.user" cols="12" class="text-end mt-n9">
                                    <v-icon size="17">mdi-account</v-icon><span class="mb-4 caption">{{item.user}}</span>
                                </v-col>
                                <v-list-item class="mb-n4">
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
                                            <v-card-actions class="ml-n2">
                                                <v-btn outlined rounded text @click="openDetailsDialog(item.id)">Ver Detalles</v-btn>
                                            </v-card-actions>
                                        </v-col>
                                    </v-list-item-content>
                                </v-list-item>
                            </v-card>
                        </v-hover>
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
        <!-- COMIENZA DIALOGO DE DETALLES -->
        <v-dialog v-model="dialog" fullscreen persistent transition="dialog-bottom-transition">
            <v-card tile>
                <v-toolbar color="#3ba2a9">
                    <v-btn icon dark @click="dialog = false">
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                </v-toolbar>
                <DashboardQuotedBlindsView :localOrders="order.blinds" :localOrder="orderNameDetails"></DashboardQuotedBlindsView>
                <!-- <v-row justify="center" align="center">
                             <v-col cols="12" v-for="blind in order.blinds" :key="blind.id">
                        <v-card height="300" >
                            <div style="border: 1px solid black; height: 85%; width: 90%; margin: auto" class="d-flex">
                                <v-card flat class="d-flex"   style="border: 1px solid black; width: 40px; height: 253px">
                                    <div class="rotado">
                                        PERSIANA {{ blind.id }}
                                    </div>
                                </v-card>
                                <v-card flat class="d-flex align-center text-center" style="margin: auto;width: 100%; height: 85%" >
                                    <div style="width: 50%">
                                        <div class="d-block" style="font-weight: bolder;">
                                            Modelo: {{$store.getters.getVariant(blind.variant).name}}
                                        </div>
                                        <div class="d-block" style="font-weight: bolder;" v-if="blind.variant2 != null">
                                            Modelo 2:  {{$store.getters.getVariant(blind.variant2).name}}
                                        </div>
                                        <div class="d-block">
                                            <b> Color:</b>{{blind.color.color}}
                                            <b>Código:</b>{{blind.color.code}}
                                        </div>
                                        <div class="d-block" v-if="blind.second_color != null">
                                            <b> Color 2:</b>{{blind.second_color.color}}
                                            <b>Código:</b>{{blind.second_color.code}}
                                        </div>
                                        <div class="d-block">
                                            <b>Tipo:</b>Persiana {{blind.type}}
                                            <b>Línea: </b>{{blind.line}}
                                        </div>
                                        <div  class="d-block">
                                            <b v-if="blind.cloth_holder">CON PORTATELA</b>
                                            <div style="display: inline" v-if="blind.celular_type != null">
                                              {{blind.celular_type}}
                                            </div>
                                            <div style="display: inline" v-if="blind.celular_drive != null">
                                              {{blind.celular_drive}}
                                            </div>
                                            <div style="display: inline" v-if="blind.instalation_side != null">
                                              <b>Tipo de instalación: </b> {{blind.motor.instalation_side}}
                                            </div>
                                            <div style="display: inline" v-if="blind.motor.instalation_side != null">
                                             <b>Tipo de instalación: </b> {{blind.motor.instalation_side}}
                                            </div>
                                        </div>
                                        <div class="d-block">
                                            <div style="display: inline" v-if="blind.motor.frame != null">
                                                <b>Marco: </b>{{blind.motor.frame}}
                                            </div>
                                            <div style="display: inline" v-if="blind.motor.rail_color != null">
                                                <b>Riel: </b> {{blind.motor.rail_color}}
                                            </div>
                                            <div style="display: inline" v-if="blind.motor.height_control != null">
                                                <b>Alura de mando: </b> {{blind.motor.height_control}} mts
                                            </div>
                                            <div style="display: inline" v-if="blind.motor.selected_panel && blind.motor.selected_panel != 0">
                                                <b>Agrupamiento: </b> {{blind.motor.selected_panel}}
                                            </div>
                                        </div>
                                        <div class="d-block">
                                            <b>Precio (m2):</b>${{$store.getters.getVariant(blind.variant).price}} MXN |
                                            <b>Subtotal:</b>${{blind.price}} MXN
                                        </div>
                                        <br>
                                        <div class="d-block">
                                            <div v-if="blind.motor_type != null"><b>Accionamiento:</b>{{blind.motor_type}}</div>
                                            <div v-if="blind.motor.drive != null"><b>Control/Motor:</b>{{blind.motor.drive}}</div>
                                        </div>
                                        <div class="d-block">
                                            <div style="display: inline" v-if="blind.motor.manufacturer != null">
                                                <b>Marca:</b>{{blind.motor.manufacturer}}
                                            </div>
                                            <div style="color: #47a5ad;display: inline" v-if="blind.motor.manufacturerPrice > 0">(+${{blind.motor.manufacturerPrice}})</div>
                                            <div style="display: inline" v-if="blind.motor.control_color != null &&  blind.motor.control_color != 0">
                                                <b>Color:</b>{{blind.motor.control_color}}
                                            </div>
                                            <div style="display: inline" v-if="blind.motor.string_type != null" >
                                                <b>Cadena:</b>{{blind.motor.string_type}}
                                            </div>
                                            <div style="color: #47a5ad; display: inline" v-if="blind.motor.stringPrice > 0">(+${{blind.motor.stringPrice}})</div>
                                        </div>
                                        <div class="d-block" v-if="blind.motor.gallery != null">
                                            <b>Galeria/Fascia:</b>{{blind.motor.gallery.model}}
                                            <div style="color: #47a5ad;display: inline" v-if="blind.motor.galleryPrice > 0">(+${{blind.motor.galleryPrice}})</div>
                                            <div style="color: #47a5ad;display: inline" v-else > 0">(+${{blind.motor.gallery.price}})</div>
                                            <b v-if="blind.motor.gallery.color != null">Color: {{blind.motor.gallery.color}}</b>
                                            <b v-else>Color: n/a</b>
                                        </div>
                                        <div class="d-block" v-if="blind.motor.motor != 0 && blind.motor.motor != null">
                                            <b>Motor:</b>
                                            <div style="display: inline">{{$store.getters.getMotor(blind.motor.motor).system}}</div>
                                            <div style="display: inline"> <b>Tipo: </b>{{$store.getters.getMotor(blind.motor.motor).motorizationType}}</div>
                                            <div style="display: inline"> <b>Precio: </b>{{mxCurrencyFormat.format($store.getters.getMotor(blind.motor.motor).price)}}MXN</div>
                                        </div>
                                        <div class="d-block" v-if="blind.motor.control != null">
                                            <b>Control: </b>
                                            <div style="display: inline">{{blind.motor.control.description}}</div>
                                            <div style="display: inline; color: #47a5ad">{{mxCurrencyFormat.format(blind.motor.control.price)}}MXN</div>
                                        </div>
                                        <div class="d-block" v-if="blind.motor.flexiballetPrice > 0">
                                            <b>EXTRA:</b>${{blind.motor.flexiballetPrice}} MXN
                                        </div>
                                    </div>
                                    <div style="width: 25%" >
                                        <div class="d-block" style="margin-top: 15px;" v-for="(c, index) in blind.canvas" :key="index">
                                            <div class="d-block" style="font-weight: bolder; color: #47a5ad">Lienzo {{index + 1}}:</div>
                                            <div class="d-block" style="font-weight: bolder">Ancho:{{c.width}}m | Alto: {{c.height}}m</div>
                                        </div>
                                    </div>
                                    <div style="width: 25%">
                                        <v-img
                                        v-if="blind.second_color == null"
                                        width="150"
                                        :src="`/img/modelos/medium/${blind.color.code}.jpg`"
                                        >
                                            <template v-slot:placeholder>
                                                <img  width="150" height="150"  src="/img/modelos/medium-unavailable.jpg">
                                            </template>
                                        </v-img>
                                        <div v-else class="d-flex justify-space-around">
                                            <div>
                                                <div class="d-block">DIA</div>
                                                <v-img
                                                :src="`/img/modelos/medium/${blind.color.code}.jpg`"
                                                width="100"
                                                height="130">
                                                    <template v-slot:placeholder>
                                                        <img src="/img/modelos/medium-unavailable.jpg">
                                                    </template>
                                                </v-img>
                                            </div>
                                            <div>
                                                <div>NOCHE</div>
                                                <v-img
                                                :src="`/img/modelos/medium/${blind.second_color.code}.jpg`"
                                                width="100"
                                                height="130">
                                                    <template v-slot:placeholder>
                                                        <img src="/img/modelos/medium-unavailable.jpg">
                                                    </template>
                                                </v-img>
                                            </div>
                                        </div>
                                    </div>
                                </v-card>
                            </div>
                            <v-card class="d-flex justify-end" style="width: 95%; height: 10%;">
                                <div style="border: 1px solid black">
                                    <div class="d-inline">TOTAL: </div>
                                    <div class="d-inline" style="color: #47a5ad;">
                                        {{mxCurrencyFormat.format(
                                        blind.price +
                                        blind.motor.price +
                                        blind.motor.flexiballetPrice +
                                        blind.motor.galleryPrice +
                                        blind.motor.manufacturerPrice +
                                        blind.motor.stringPrice
                                        )}} MXN
                                    </div>
                                </div>
                            </v-card>
                        </v-card>
                    </v-col>
                </v-row> -->
            </v-card>
        </v-dialog>
        <!-- TERMINA DIALOGO DE DETALLES -->
    </v-container>
</template>

<script>
import { mapState, mapGetters } from "vuex";
import OrdersSuperadminTableView from '../../views/Users/OrdersSuperadminTableView.vue'
import DashboardQuotedBlindsView from '../../views/Users/DashboardQuotedBlindsView.vue'
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
        }
    },

    computed:{
        numberOfPages () {
            return Math.ceil(this.orders.length / this.itemsPerPage)
        },
        ...mapState({
            orders: state => state.ordersModule.quotedOrders,
            order: state => state.ordersModule.quotedOrder,
            user: state => state.user,
            loggedIn: state => state.loggedIn,
        }),
        ...mapGetters([
          'loggedIn',
          'getLoginErrors',
          'getLoginStatus',
          'getUserStatus'
        ]),
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
                this.orderNameDetails = this.orders.find(el => el.id == id)
                this.dialog = true
            });

        }
    },

    components:{
        OrdersSuperadminTableView,
        DashboardQuotedBlindsView
    },

    mounted(){
        console.log(this.user.role)
        this.$store.dispatch('getQuotedOrders').then(()=>{
            this.isLoadedOrders = true;
        });
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
