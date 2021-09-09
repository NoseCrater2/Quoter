<template>
<v-dialog v-model="isOrdersAndQuotationsDialogActivated" fullscreen persistent transition="dialog-bottom-transition">
    <v-card tile flat>
        <v-toolbar flat color="#3ba2a9">
            <v-btn icon dark @click="emitClickCloseFromOrdersAndQuotationsDialog()">
                <v-icon>mdi-close</v-icon>
            </v-btn>
            <div class="white--text text-uppercase" :style="$vuetify.breakpoint.mdAndUp ? 'font-size: 1.43rem': 'font-size: 1.0rem'">Detalles de la
                <span>{{computedQuotingOrdersRoute.name}} / </span>
                <span>#{{propItemQuotationOrderNumberID}}</span>
            </div>
            <v-spacer></v-spacer>

            <div v-if="computedQuotingOrdersRoute.path == 'order' && computedQuotingOrdersRoute.name == 'Cotización'" class="mr-1">
                <v-btn :large="$vuetify.breakpoint.mdAndUp ? true : false" :icon="!$vuetify.breakpoint.mdAndUp ? true : false" elevation="0" color="orange darken-1" class="white--text font-weight-bold mr-2">
                    {{$vuetify.breakpoint.mdAndUp ? 'Agregar al carrito' : ''}}
                    <v-icon size="30" right>mdi-cart</v-icon>
                </v-btn>
                <v-btn icon color="white">
                    <v-icon size="30">mdi-square-edit-outline</v-icon>
                </v-btn>
                <v-btn icon color="white">
                    <v-icon size="30">mdi-printer</v-icon>
                </v-btn>
                <v-btn icon color="white">
                    <v-icon size="30">mdi-delete</v-icon>
                </v-btn>
            </div>

            <div v-else-if="computedQuotingOrdersRoute.path == 'marketcar' && computedQuotingOrdersRoute.name == 'Orden'" class="mr-1">
                <v-btn large elevation="0" color="orange darken-1" class="white--text font-weight-bold mr-2">
                    Comprar
                    <v-icon size="30" right>mdi-arrow-right</v-icon>
                </v-btn>
                <v-btn icon color="white">
                    <v-icon size="30">mdi-square-edit-outline</v-icon>
                </v-btn>
                <v-btn icon color="white">
                    <v-icon size="30">mdi-printer</v-icon>
                </v-btn>
                <v-btn icon color="white">
                    <v-icon size="30">mdi-delete</v-icon>
                </v-btn>
            </div>

            <div v-else-if="computedQuotingOrdersRoute.path == 'order' && computedQuotingOrdersRoute.name == 'Orden'" class="mr-1">
                <v-row no-gutters align="center">
                    <div class="white--text mr-1">Estado de la orden: </div>
                    <div style="background-color: black" class="mx-2">
                        <v-chip color="black" text-color="black">
                            <v-avatar size="22" class="green" >
                            </v-avatar>
                        </v-chip>
                        <span class="white--text font-weight-bold mr-4">Entregada</span>
                    </div>
                    <v-btn icon color="white">
                        <v-icon size="30">mdi-printer</v-icon>
                    </v-btn>
                </v-row>
            </div>

        </v-toolbar>
        <v-row no-gutters align="center" class="mt-4">
            <v-col cols="3">
                <v-img class="mx-auto" width="300" src="/img/logos/rollux.png" ></v-img>
            </v-col>
            <v-col cols="6" style="border-left: 4px solid #47a5ad">
                <v-card outlined class="ml-5">
                    <v-col cols="12" style="background-color: #E0E0E0">
                        <div v-if="user.company != null || user.company != ''" class="text-center my-n3" style="font-size: 1.27rem">
                            <span class="font-weight-bold">{{user.company}}</span> | <span>Distribuidor Autorizado</span>
                        </div>
                        <div v-else class="text-center my-n3" style="font-size: 1.27rem">
                            <span class="font-weight-bold">{{user.name+' '+user.last_name}}</span> | <span>Distribuidor Autorizado</span>
                        </div>
                    </v-col>
                    <v-row no-gutters justify="center" class="pa-5" align="start">
                        <v-col cols="12" xl="5" lg="5" md="5" sm="12" style="font-size: 1.15rem" class="mt-n4" :class="!$vuetify.breakpoint.mdAndUp ? 'text-center':''">
                            <div class="font-weight-bold" style="font-size: 1.6rem">{{computedQuotingOrdersRoute.name}}</div>
                            <div>Folio <span class="font-weight-bold" style="color: #47a5ad">R120821/001</span></div>
                            <div>Fecha: {{computedCurrentDate}}</div>
                            <div v-if="computedQuotingOrdersRoute.name == 'Cotización'" style="font-size: 1.0rem">Vigencia hasta: {{computedVigencyDate}}</div>
                        </v-col>
                        <v-col cols="12" xl="7" lg="7" md="7" sm="12" style="font-size: 0.85rem" :class="$vuetify.breakpoint.mdAndUp ? 'mt-n2' : 'text-center'">
                            <div v-if="user.company != null || user.company != ''" class="font-weight-bold">Cliente: {{user.name+' '+user.last_name}}</div>
                            <div v-if="user.ship_address != null || user.ship_address != ''">
                                <span>Dirección: {{user.ship_address}}</span>
                            </div>
                            <div v-if="user.rfc != null || user.rfc != ''">
                                <span>RFC: {{user.rfc}}</span>
                            </div>
                            <div v-if="user.phone != null || user.phone != ''">
                                <span>Teléfono: {{user.phone}}</span>
                            </div>

                            <div v-if="user.email != null || user.email != ''">
                                <span>Email: {{user.email}}</span>
                            </div>
                        </v-col>
                    </v-row>
                </v-card>
            </v-col>
            <v-col cols="3" >
                <v-img class="mx-auto" width="300" :src="'/img/'+user.logo" ></v-img>
            </v-col>
        </v-row>
        <v-col cols="12" style="font-size: 0.85rem;">
            <div class="mx-15 text-center">
                La emisión de este documento es solo para fines informativos y no representan ningún compromiso de fabricación para la empresa, ni para el cliente.
                Se considerará en firme cuando se realice el pago del importe acordado. Precios sujetos a cambios sin previo aviso.
            </div>
        </v-col>
        <v-col cols="12">
            <div v-if="propIsOrderOrQuotationString == 'order'" style="border: 1px dashed black;">
                <v-row no-gutters>
                    <v-col cols="12" xl="6" lg="6" md="12" sm="12" class="pa-2" v-for="(itemBlind, index) in quotedOrder.blinds" :key="itemBlind.id">
                        <DashboardBlindsProductDetailCards :propIsOrderOrQuotationString="'order'" :propItemArrayBlindsObject="itemBlind" :propBlindCount="(index + 1)" :propBreakpointFromDialog="$vuetify.breakpoint"></DashboardBlindsProductDetailCards>
                    </v-col>
                </v-row>
            </div>
            <div v-else-if="propIsOrderOrQuotationString == 'quotation'" style="border: 1px dashed black;">
                <v-row no-gutters>
                    <v-col cols="12" xl="6" lg="6" md="12" sm="12" class="pa-2" v-for="(itemBlind, index) in quotingOrder.blinds" :key="itemBlind.id">
                        <DashboardBlindsProductDetailCards :propIsOrderOrQuotationString="'quotation'" :propItemArrayBlindsObject="itemBlind" :propBlindCount="(index + 1)" :propBreakpointFromDialog="$vuetify.breakpoint"></DashboardBlindsProductDetailCards>
                    </v-col>
                </v-row>
            </div>
        </v-col>
        <v-row no-gutters justify="center" justify-xl="end" justify-lg="end" justify-md="end" justify-sm="center" class="mr-3 mt-3">
            <v-col cols="12" xl="4" lg="4" md="4" sm="12">
                <v-row no-gutters class="font-weight-bold" style="border: 1px solid black">
                    <v-col cols="6" class="text-center" style="border: 1px solid black">
                        <div>
                            SUBTOTAL
                        </div>
                    </v-col>
                    <v-col cols="6" class="text-end" style="border: 1px solid black">
                        <div>
                            {{mxCurrencyFormat.format(propTotalPrice)}} MXN
                        </div>
                    </v-col>
                    <v-col cols="6" class="text-center" style="border: 1px solid black">
                        <div>
                            IVA
                        </div>
                    </v-col>
                    <v-col cols="6" class="text-end" style="border: 1px solid black">
                        <div>
                            INCLUIDO
                        </div>
                    </v-col>
                    <v-col cols="6" class="white--text text-center" style="background-color: #47a5ad; font-size: 1.3rem; border: 1px solid black">
                        <div>
                            TOTAL
                        </div>
                    </v-col>
                    <v-col cols="6" class="white--text text-end" style="background-color: #47a5ad; font-size: 1.3rem; border: 1px solid black">
                        <div>
                            {{mxCurrencyFormat.format(propTotalPrice)}} MXN
                        </div>
                    </v-col>
                </v-row>
            </v-col>
        </v-row>
        <v-row no-gutters justify="center">
            <v-col cols="3" class="mt-7">
                <div>
                    <v-divider style="border: 2px solid #47a5ad"></v-divider>
                </div>
            </v-col>
        </v-row>
        <v-col cols="12" class="text-center mt-n2">
            <div class="mx-15 text-center">
                <!-- <div class="font-weight-bold" style="font-size: 0.9rem">
                    Deposito a la cuenta de Banorte: 0892608267 // CLABE: 072 470 0089 2608 2678 // A nombre de Materiales Decorativos S. de R.L, MI.
                </div> -->
                <div style="font-size: 0.75rem">
                    Favor de revisar importes y cantidades descritas en este documento // Cualquier variación será motivo de otra cotización // La fecha del pedido se toma en cuenta a partir de la fecha de pago
                    No se procesan pedidos que no estén pagados // La mercancía viaja por cuenta y riesgo del comprador // Los tonos de las telas pueden variar ligeramente a los del muestrario
                    Para precios en dólares se tomará en cuenta tipo de cambio emitido por Banorte el día del pago. // No hay cambios ni devoluciones una vez cortada la tela. Precios sujetos a cambios sin previo aviso.
                </div>
            </div>
        </v-col>
    </v-card>
</v-dialog>
</template>

<script>
import { mapState } from "vuex";
import DashboardBlindsProductDetailCards from '../../Dashboard/BlindsProductDetailCards/DashboardBlindsProductDetailCards.vue'
export default {
  data() {
    return {
        localModeldate: new Date(),
        mxCurrencyFormat : new Intl.NumberFormat('en-US', {style: 'currency', currency: 'USD'}),
    }
  },
  components: {
      DashboardBlindsProductDetailCards
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
      computedCurrentDate(){
          let year = this.localModeldate.getFullYear();
          let month = this.localModeldate.getMonth() + 1;
          let day = this.localModeldate.getDate();
          if(day < 10){
              day = '0'+day;
          }
          if(month < 10){
              month = '0'+month;
          }
          return day + '/' + month + '/' + year
      },
      computedVigencyDate(){
          let methodLocalCurrentDate = this.localModeldate;
          methodLocalCurrentDate.setDate(this.localModeldate.getDate() + 7)
          let year = methodLocalCurrentDate.getFullYear();
          let month = methodLocalCurrentDate.getMonth() + 1;
          let day = methodLocalCurrentDate.getDate();
          if(day < 10){
              day = '0'+day;
          }
          if(month < 10){
              month = '0'+month;
          }
          return day + '/' + month + '/' + year
      },
      computedQuotingOrdersRoute(){
          if(this.$router.currentRoute.name == 'Orders'){
              if(this.propIsOrderOrQuotationString == 'order'){
                  return {path: 'order', name: 'Orden'};
              }
              else if(this.propIsOrderOrQuotationString == 'quotation'){
                  return {path: 'order', name: 'Cotización'};
              }
          }
          else if(this.$router.currentRoute.name == 'Marketcar'){
              return {path: 'marketcar', name: 'Orden'};
          }
      }
  },
  methods:{
      emitClickCloseFromOrdersAndQuotationsDialog(){
          this.$emit('emitClickCloseFromOrdersAndQuotationsDialog', false);
      }
  },
  props:{
      isOrdersAndQuotationsDialogActivated: {
          type: Boolean
      },
      idOrderQuotationOrdersAndQuotationsDialog:{
          type: Number
      },
      propTotalPrice:{
          type: Number
      },
      propIsOrderOrQuotationString: {
          type: String
      },
      propItemQuotationOrderNumberID:{
          type: String
      }
  }
}
</script>
