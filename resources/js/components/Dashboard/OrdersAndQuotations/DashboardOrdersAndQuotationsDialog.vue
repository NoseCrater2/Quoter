<template>
<v-dialog v-model="dialog" fullscreen persistent transition="dialog-bottom-transition">
    <v-card tile flat>
        <v-toolbar flat color="#3ba2a9">
            <v-btn icon dark @click="emitClickCloseFromOrdersAndQuotationsDialog()">
                <v-icon>mdi-close</v-icon>
            </v-btn>
            <div class="white--text text-uppercase" :style="$vuetify.breakpoint.mdAndUp ? 'font-size: 1.43rem': 'font-size: 1.0rem'">Detalles de la

                <span  v-if="quotedOrder.is_quotation == 1">COTIZACIÓN</span>
                <span  v-else>ORDEN</span>
                <span>/#{{quotedOrder.order}}</span>
            </div>
            <v-spacer></v-spacer>

            <div v-if="quotedOrder.is_quotation == 1" class="mr-1">
                <v-btn
                :large="$vuetify.breakpoint.mdAndUp ? true : false" :icon="!$vuetify.breakpoint.mdAndUp ? true : false"
                elevation="0"
                color="orange darken-1"
                class="white--text font-weight-bold mr-2"
                @click="makeOrder()"
                :loading="loadingChange"
                :disabled="loadingChange"
                >
                    {{$vuetify.breakpoint.mdAndUp ? 'Agregar al carrito' : ''}}
                    <v-icon size="30" right>mdi-cart</v-icon>
                </v-btn>
                <v-tooltip bottom>
                    <template v-slot:activator="{ on, attrs }">
                        <v-btn icon color="white" v-bind="attrs" v-on="on" @click="dialog3 = true">
                            <v-icon size="30">mdi-square-edit-outline</v-icon>
                        </v-btn>
                 </template>
                  <span>Editar</span>
                </v-tooltip>

                <v-tooltip bottom>
                    <template v-slot:activator="{ on, attrs }">
                        <v-btn icon color="white" @click="downloadPdf()" v-bind="attrs" v-on="on">
                            <v-icon size="30">mdi-printer</v-icon>
                        </v-btn>
                  </template>
                  <span>Descargar en PDF</span>
                </v-tooltip>

                 <v-tooltip bottom>
                    <template v-slot:activator="{ on, attrs }">
                        <v-btn icon color="white" @click="dialog2 = true" v-bind="attrs" v-on="on">
                            <v-icon size="30">mdi-delete</v-icon>
                        </v-btn>
                    </template>
                  <span>Eliminar</span>
                </v-tooltip>
            </div>

            <div v-else-if="(quotedOrder.is_quotation == 0 && quotedOrder.state == 'No Pagada')" class="mr-1">
                <v-btn @click="localMethodCheckAndBuyFromOrdersAndQuotationsDialogView()" large elevation="0" color="orange darken-1" class="white--text font-weight-bold mr-2">
                    Comprar
                    <v-icon size="30" right>mdi-arrow-right</v-icon>
                </v-btn>
                <v-tooltip bottom>
                    <template v-slot:activator="{ on, attrs }">
                        <v-btn icon color="white" v-bind="attrs" v-on="on" @click="dialog3 = true">
                            <v-icon size="30">mdi-square-edit-outline</v-icon>
                        </v-btn>
                 </template>
                  <span>Editar</span>
                </v-tooltip>
               <v-tooltip bottom>
                    <template v-slot:activator="{ on, attrs }">
                        <v-btn icon color="white" @click="downloadPdf()" v-bind="attrs" v-on="on">
                            <v-icon size="30">mdi-printer</v-icon>
                        </v-btn>
                  </template>
                  <span>Descargar en PDF</span>
                </v-tooltip>
                <v-tooltip bottom>
                    <template v-slot:activator="{ on, attrs }">
                        <v-btn icon color="white" @click="dialog2 = true" v-bind="attrs" v-on="on">
                            <v-icon size="30">mdi-delete</v-icon>
                        </v-btn>
                    </template>
                  <span>Eliminar</span>
                </v-tooltip>
            </div>

            <div v-else-if="(quotedOrder.is_quotation == 0 && quotedOrder.state != 'No Pagada')" class="mr-1">
                <v-row no-gutters align="center">
                    <div class="white--text mr-1">Estado de la orden: </div>
                    <div style="background-color: black" class="mx-2">
                        <v-chip color="black" text-color="black">
                            <v-avatar v-if="quotedOrder.state === 'Recibida'" size="22" class="grey lighten-1"></v-avatar>
                            <v-avatar v-if="quotedOrder.state === 'En produccion'" size="22" class="orange darken-1"></v-avatar>
                            <v-avatar v-if="quotedOrder.state === 'Paqueteria'" size="22" class="blue darken-1"></v-avatar>
                            <v-avatar v-if="quotedOrder.state === 'Entregada'" size="22" class="green darken-1"></v-avatar>
                            <v-avatar v-if="quotedOrder.state === 'Cancelada'" size="22" class="red darken-2"></v-avatar>
                            <v-avatar v-if="quotedOrder.state === 'No Pagada'" size="22" class="black"></v-avatar>
                            <v-avatar v-if="quotedOrder.state === 'En Verificacion'" size="22" class="yellow"></v-avatar>
                        </v-chip>
                        <span class="white--text font-weight-bold mr-4">{{quotedOrder.state}}</span>
                    </div>
                    <v-btn icon color="white" @click="downloadPdf()">
                        <v-icon size="30">mdi-printer</v-icon>
                    </v-btn>
                </v-row>
            </div>

        </v-toolbar>
        <v-row no-gutters align="center" class="mt-4" v-if="quotedOrder.user != null">
            <v-col cols="3">
                <v-img class="mx-auto" width="300" src="/img/logos/rollux.png" ></v-img>
            </v-col>
            <v-col cols="6" style="border-left: 4px solid #47a5ad">
                <v-card outlined class="ml-5">
                    <v-col cols="12" style="background-color: #E0E0E0">
                        <div v-if="quotedOrder.user.company != null || quotedOrder.user.company != ''" class="text-center my-n3" style="font-size: 1.27rem">
                            <span class="font-weight-bold">{{quotedOrder.user.company}}</span> | <span>Distribuidor Autorizado</span>
                        </div>
                        <div v-else class="text-center my-n3" style="font-size: 1.27rem">
                            <span class="font-weight-bold">{{quotedOrder.user.name+' '+quotedOrder.user.last_name}}</span> | <span>Distribuidor Autorizado</span>
                        </div>
                    </v-col>
                    <v-row no-gutters justify="center" class="pa-5" align="start">
                        <v-col cols="12" xl="5" lg="5" md="5" sm="12" style="font-size: 1.15rem" class="mt-n4" :class="!$vuetify.breakpoint.mdAndUp ? 'text-center':''">
                            <div class="font-weight-bold" style="font-size: 1.6rem" v-if="quotedOrder.is_quotation">Cotización</div>
                            <div class="font-weight-bold" style="font-size: 1.6rem" v-else>Orden</div>
                            <div>Folio <span class="font-weight-bold" style="color: #47a5ad">{{quotedOrder.order}}</span></div>
                            <div>Fecha: {{quotedOrder.created_at}}</div>
                            <div v-if="quotedOrder.is_quotation" style="font-size: 1.0rem">Vigencia hasta: {{quotedOrder.validity}}</div>
                        </v-col>
                        <v-col cols="12" xl="7" lg="7" md="7" sm="12" style="font-size: 0.85rem" :class="$vuetify.breakpoint.mdAndUp ? 'mt-n2' : 'text-center'">
                            <div v-if="quotedOrder.user.company != null || quotedOrder.user.company != ''" class="font-weight-bold">Cliente: {{quotedOrder.user.name+' '+quotedOrder.user.last_name}}</div>
                            <div v-if="quotedOrder.user.ship_address != null || quotedOrder.user.ship_address != ''">
                                <span>Dirección: {{quotedOrder.user.ship_address}}</span>
                            </div>
                            <div v-if="quotedOrder.user.rfc != null || quotedOrder.user.rfc != ''">
                                <span>RFC: {{quotedOrder.user.rfc}}</span>
                            </div>
                            <div v-if="quotedOrder.user.phone != null || quotedOrder.user.phone != ''">
                                <span>Teléfono: {{quotedOrder.user.phone}}</span>
                            </div>

                            <div v-if="quotedOrder.user.email != null || quotedOrder.user.email != ''">
                                <span>Email: {{quotedOrder.user.email}}</span>
                            </div>
                        </v-col>
                    </v-row>
                </v-card>
            </v-col>
            <v-col cols="3" >
                <v-img class="mx-auto" width="300" :src="'/img/'+quotedOrder.user.logo" ></v-img>
            </v-col>
        </v-row>
        <v-col cols="12" style="font-size: 0.85rem;">
            <div class="mx-15 text-center">
                La emisión de este documento es solo para fines informativos y no representan ningún compromiso de fabricación para la empresa, ni para el cliente.
                Se considerará en firme cuando se realice el pago del importe acordado. Precios sujetos a cambios sin previo aviso.
            </div>
        </v-col>
        <v-col cols="12">
            <div style="border: 1px dashed black;">
                <DashboardBlindsProductDetailCards :idOrder="id" :isFromDialog="true"></DashboardBlindsProductDetailCards>
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
                            {{mxCurrencyFormat.format(quotedOrder.total)}} MXN
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
                        <div style="font-size: 0.63rem">
                            Pago con SPEI (Transferencia bancaria)
                        </div>
                    </v-col>
                    <v-col cols="6" class="white--text text-end" style="background-color: #47a5ad; font-size: 1.3rem; border: 1px solid black">
                        <div>
                            {{mxCurrencyFormat.format(quotedOrder.total)}} MXN
                        </div>
                    </v-col>
                    <v-col cols="6" class="text-center" style="font-size: 0.63rem; background-color: #E0E0E0;">
                        <div>
                            Pago con tarjeta 1 sola emisión.
                        </div>
                        <!-- <div>
                            (Con Tarjeta de Débito) <span style="color: red">(+5%)</span>
                        </div> -->
                    </v-col>
                    <v-col cols="6" class="text-end" style="background-color: #E0E0E0;">
                        <div>
                            {{mxCurrencyFormat.format((quotedOrder.total * 1.05))}} MXN
                        </div>
                    </v-col>
                    <v-col cols="6" class="text-center" style="font-size: 0.63rem; background-color: #E0E0E0;">
                        <div>
                            Pago a 6 meses.
                        </div>
                        <!-- <div>
                            (Con Tarjeta de Crédito) <span style="color: red">(+15%)</span>
                        </div> -->
                    </v-col>
                    <v-col cols="6" class="text-end" style="background-color: #E0E0E0;">
                        <div>
                            {{mxCurrencyFormat.format((quotedOrder.total * 1.15))}} MXN
                        </div>
                        <div style="font-size: 0.63rem;">
                            6 Pagos de {{mxCurrencyFormat.format(((quotedOrder.total * 1.15) / 6))}} MXN
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
    <v-dialog  v-model="dialog2" max-width="300px">
        <v-card>
            <v-card-title v-if="quotedOrder.is_quotation">
              ¿Eliminar esta cotización?
            </v-card-title>
            <v-card-title v-else>
              ¿Eliminar esta órden?
            </v-card-title>
            <v-card-actions>
              <v-btn text @click="dialog2 = false">
                CANCELAR
              </v-btn>
              <v-spacer></v-spacer>
              <v-btn color="red" text @click="deleteOrder()">
                ELIMINAR
              </v-btn>
            </v-card-actions>
          </v-card>
    </v-dialog>
     <v-dialog  v-model="dialog3" max-width="300px">
        <v-card>
            <v-card-title class="titledialog">
                Esta acción le redigirá al cotizador
            </v-card-title>
            <v-card-actions>
              <v-btn color="red" text @click="dialog3 = false">
                CANCELAR
              </v-btn>
              <v-spacer></v-spacer>
              <v-btn color="#47a5ad" text @click="setToQuoter()">
                CONTINUAR
              </v-btn>
            </v-card-actions>
          </v-card>
    </v-dialog>
</v-dialog>
</template>

<script>
import axios from 'axios'
import {mapState} from 'vuex';
const FileDownload = require('js-file-download');
import DashboardBlindsProductDetailCards from '../../Dashboard/BlindsProductDetailCards/DashboardBlindsProductDetailCards.vue'
export default {
  data() {
    return {
        order: {},
        dialog: true,
        dialog2: false,
        dialog3: false,
        loadingChange: false,
        localModeldate: new Date(),
        mxCurrencyFormat : new Intl.NumberFormat('en-US', {style: 'currency', currency: 'USD'}),
    }
  },

  mounted(){
    //   axios.get('/api/orders/'+this.id).then((response)=>{
    //       this.
    //       this.order = response.data.data

          this.$store.dispatch('getQuotedOrder', this.id).then(async() => {
            // await this.$store.dispatch('getQuotedOrders');
            // this.loadingChange = false
            // this.$emit('emitClickCloseFromOrdersAndQuotationsDialog', false);
        })
      //})
  },

  components: {
      DashboardBlindsProductDetailCards
  },
  computed:{

       ...mapState({
            quotedOrder: state => state.ordersModule.quotedOrder,
        }),
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
    },

    localMethodCheckAndBuyFromOrdersAndQuotationsDialogView(){
        this.$emit('emitCheckAndBuyFromOrdersAndQuotationsDialogView', this.order);
    },

    deleteOrder(){
      this.$store.dispatch('deleteQuotingOrder', this.id).then(async()=>{
          if(localStorage.getItem('quotedOrder') !== null){
              let localStorageObject = JSON.parse(localStorage.getItem('quotedOrder'));
              if(localStorageObject.order.id == this.id){
                  localStorage.removeItem('quotedOrder')
              }
          }
          await this.$store.dispatch('getQuotedOrders');
          await this.$store.dispatch('getQuotingOrders');
          this.$emit('emitClickCloseFromOrdersAndQuotationsDialog', false);
      })
    },

    downloadPdf(){
        axios.post("/api/auth-order-list-pdf-distributor", {orders: this.order.blinds, user: this.order.user, distributorImagePrint: false}, {responseType: 'blob',}).then((response)=>{
          FileDownload(response.data, this.order.order+'.pdf')
      }).catch(()=>{
        //  this.isPrintingSuperAdminUserPDF = false;
      })
    },

    makeOrder(){
        this.loadingChange = true
        this.$store.dispatch('changeToOrder', this.id).then(async() => {
            await this.$store.dispatch('getQuotedOrders');
            this.loadingChange = false
            this.$emit('emitClickCloseFromOrdersAndQuotationsDialog', false);
        })
    },

    setToQuoter(){
        this.$store.commit('assignOrder', this.order)
        this.$router.push({name: 'Quoter'})
    }

  },
  props:{
      id: {
          type: Number,
      }
  }
}
</script>
<style scoped>
    .titledialog{
        text-align: center;
        word-break: normal;
    }

</style>
