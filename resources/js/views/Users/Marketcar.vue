<template>
  <div>
      <v-container fluid>
          <div class="text-center text-uppercase my-2" style="font-size: 1.5rem">
              <span>Carrito de compra </span><span class="font-weight-bold" style="color: #3ba2a9">Orden</span>
              <div style="color: red">(¡EN CONSTRUCCION! DISCULPE LAS MOLESTIAS)</div>
          </div>
          <v-row class="mt-3">
              <v-col v-if="$vuetify.breakpoint.mdAndUp" cols="12" xl="3" lg="3" md="3" sm="3">
                <v-card
                style="position: sticky; top: 60px; z-index: 2;"
                  height="auto"
                  width="auto"
                  outlined
                  class="rounded-lg"
                >
                  <v-navigation-drawer color="grey lighten-3" height="auto" width="auto" permanent>
                    <v-list-item style="background-color: #3ba2a9">
                      <v-list-item-content>
                        <v-list-item-title class="white--text font-weight-bold" style="font-size: 1.3rem">
                          Mi cuenta
                        </v-list-item-title>
                      </v-list-item-content>
                    </v-list-item>


                    <v-list
                    >
                      <v-list-item>
                        <v-list-item-title>{{navigationDrawerItems[0].title}}</v-list-item-title>
                      </v-list-item>

                      <v-list-group
                        v-for="item in computedNavigationDrawerItemsWithChild"
                        :key="item.title"
                        v-model="item.active"
                        no-action
                      >
                        <template v-slot:activator>
                          <v-list-item-content>
                            <v-list-item-title v-text="item.title"></v-list-item-title>
                          </v-list-item-content>
                        </template>

                        <v-list-item
                          v-for="child in item.childItems"
                          :key="child.title"
                        >
                          <v-list-item-content>
                            <v-list-item-title style="font-size: 0.80rem" v-text="child.title"></v-list-item-title>
                          </v-list-item-content>
                        </v-list-item>
                      </v-list-group>
                      <v-list-item>
                        <v-list-item-title>{{navigationDrawerItems[3].title}}</v-list-item-title>
                      </v-list-item>
                    </v-list>
                  </v-navigation-drawer>
                </v-card>
              </v-col>
              <v-col cols="12" xl="9" lg="9" md="9" sm="12">
                  <v-row align="center" no-gutters>
                      <v-col cols="4" v-for="(item, index) in marketStepsItems" :key="index">
                          <!-- @click="changeStepWindowFromAlerts((index+1))" -->
                        <v-alert

                            class="mx-1"
                            :color="(index+1) == localWindowStepModel ? 'orange darken-1' : 'grey lighten-2'"
                        >
                            <div :class="(index+1) == localWindowStepModel ? 'font-weight-bold white--text' : 'font-weight-bold black--text'" style="font-size: 2rem">{{index + 1}}  </div><div :class="(index+1) == localWindowStepModel ? 'white--text' : 'black--text'" style="font-size: 1.2rem">{{item.title}}</div>
                        </v-alert>
                      </v-col>
                  </v-row>
                  <v-row class="mt-n5">
                      <v-col cols="12" xl="9" lg="9" md="9" sm="12" order="2" order-xl="1" order-lg="1" order-md="1" order-sm="2">
                        <div v-if="localWindowStepModel == 1" class="text-start text-uppercase mb-2" style="font-size: 1.4rem;">
                            <span class="font-weight-bold" style="color: #3ba2a9">Órdenes </span><span>pendientes de pago</span>
                        </div>
                        <div v-else-if="localWindowStepModel == 2" class="text-start text-uppercase mb-2" style="font-size: 1.4rem;">
                            <v-row no-gutters>
                                <span class="font-weight-bold" style="color: #3ba2a9">Producto </span><span style="color: #3ba2a9">(s)</span>
                                <v-spacer></v-spacer>
                                <span>#Orden <span class="font-weight-bold" style="color: #3ba2a9"> {{localPropItemQuotationOrderNumberID}}</span></span>
                            </v-row>
                        </div>
                        <div v-else-if="localWindowStepModel == 3" class="text-start text-uppercase mb-2" style="font-size: 1.4rem;">
                            <v-row no-gutters>
                                <span class="font-weight-bold" style="color: #3ba2a9">Pagar orden</span>
                                <v-spacer></v-spacer>
                                <span>#Orden <span class="font-weight-bold" style="color: #3ba2a9"> {{localPropItemQuotationOrderNumberID}}</span></span>
                            </v-row>
                        </div>
                        <v-col cols="12"  style="border: 1px solid #BDBDBD; min-height: 400px;">
                            <!-- V-IF: SI EL CARRITO ESTÁ VACÍO -->
                            <!-- <div>
                                <v-img
                                  contain
                                  height="160"
                                  src="/img/dashboard/cart-outline.png"
                                ></v-img>
                                <h3 class="text-h6 font-weight-light mb-2 text-center">
                                  El carrito de compras está vacio
                                </h3>
                            </div> -->

                            <!-- V-ELSE: ESTE WINDOW INICIA AQUÍ Y HARÁ LA FUNCION DE LOS PASOS DE COMPRA -->
                            <v-window class="mx-auto" v-if="loadingOrdersToOrdersCardsStepOne" v-model="localWindowStepModel">
                                <v-window-item  v-for="(item, windowIndex) in modelWindowItemSteps" :key="windowIndex" :value="(windowIndex+1)">
                                <!-- DENTRO DE ESTE WINDOW ITEM SE CARGARÁ EL COMPONENTE DE PASO CORRESPONDIENTE -->
                                    <!-- INICIA CARGA EL COMPONENTE DEL STEP 1 -->
                                    <OrdersCardsStepOne @emitCheckAndBuyFromOrdersCardsStepOneView="localMethodStepThreeCheckAndBuy" @emitDetailsItemFromOrdersCardsStepOneView="localMethodIsOrdersAndQuotationsDialogActivatedOn" :itemOrder="computedNoPaidOrders" v-if="localWindowStepModel == 1"></OrdersCardsStepOne>
                                    <!-- TERMINA CARGA EL COMPONENTE DEL STEP 1 -->
                                    <div v-else-if="localWindowStepModel == 2">
                                        <v-col cols="12" v-for="(itemBlind, index) in quotingOrder.blinds" :key="itemBlind.id">
                                            <DashboardBlindsProductDetailCards @emitEditBlindFromBlindsProductDetailCardsView="localMethodEditBlindStepThreeMarketcar" :propIsInMarketAndStepThree="true" :propIsOrderOrQuotationString="'quotation'" :propItemArrayBlindsObject="itemBlind" :propBlindCount="(index + 1)" :propBreakpointFromDialog="$vuetify.breakpoint"></DashboardBlindsProductDetailCards>
                                        </v-col>
                                    </div>
                                    <div v-else-if="localWindowStepModel == 3">
                                        <v-col v-if="!localModelIsStepFourDataBankAccount" cols="12">
                                            <v-card elevation="0" :width="$vuetify.breakpoint.xl ? '880' : $vuetify.breakpoint.lg ? '640' : $vuetify.breakpoint.md ? '480' : $vuetify.breakpoint.sm ? '500' : '390'">

                                                <div class="font-weight-bold">Elije el metodo de pago que mas prefieras</div>
                                                <v-radio-group v-model="modelRadioStepFourPaymentMethod">
                                                    <v-tooltip
                                                       color="transparent"
                                                        left
                                                      >
                                                        <template v-slot:activator="{ on, attrs }">
                                                            <v-radio disabled v-bind="attrs" v-on="on" color="#3ba2a9" class="py-2 px-5 localBorderNoActiveClass" value="debitcreditcard">
                                                              <template v-slot:label>
                                                                <div>Tarjeta de débito o crédito</div>
                                                                <v-spacer></v-spacer>
                                                                <v-img max-width="80" contain src="https://fantactica.mx/wp-content/uploads/2021/04/visa-and-mastercard-logos-logo-visa-png-logo-visa-mastercard-png-visa-logo-white-png-awesome-logos.png"></v-img>
                                                              </template>
                                                            </v-radio>
                                                        </template>
                                                        <v-col cols="3">
                                                            <v-card outlined class="pa-5 text-justify" style="border: 3px solid #E53935; box-shadow: 1px 0px 9px 3px rgba(0,0,0,0.75);">
                                                              Estamos trabajando para habilitar esta opción de pago, sentimos el inconveniente que te pueda ocasionar.
                                                            </v-card>
                                                        </v-col>
                                                    </v-tooltip>
                                                    <v-tooltip
                                                       color="transparent"
                                                        left
                                                      >
                                                        <template v-slot:activator="{ on, attrs }">
                                                            <v-radio v-bind="attrs" v-on="on" color="#3ba2a9" class="py-2 px-5 localBorderNoActiveClass" value="electronicspei">
                                                              <template v-slot:label>
                                                                <div>Transferencia electrónica</div>
                                                                <v-spacer></v-spacer>
                                                                <v-img max-width="60" contain src="https://cdn2.downdetector.com/static/uploads/logo/spei.png"></v-img>
                                                              </template>
                                                            </v-radio>
                                                        </template>
                                                        <v-col cols="3">
                                                            <v-card outlined class="pa-5 text-justify" style="border: 3px solid #3ba2a9; box-shadow: 1px 0px 9px 3px rgba(0,0,0,0.75);">
                                                              Una vez realizado el pago, deberá enviar su comprobante de pago a Rollux México para que el estatus de su orden esté aprobada; este puede tardar de 15 a 20 minutos en reflejarse. Si presentas algún inconveniente con el estatus de tu pago, por favor, comunicate a Atención a Clientes, o envianos un correo a contacto@rollux.com.mx indicando número de orden y adjuntando tu comprobante de pago.
                                                            </v-card>
                                                        </v-col>
                                                    </v-tooltip>
                                                    <v-tooltip
                                                       color="transparent"
                                                        left
                                                      >
                                                        <template v-slot:activator="{ on, attrs }">
                                                            <v-radio disabled v-bind="attrs" v-on="on" color="#3ba2a9" class="py-2 px-5 localBorderNoActiveClass" value="oxxopay">
                                                              <template v-slot:label>
                                                                <div>OXXO Pay</div>
                                                                <v-spacer></v-spacer>
                                                                <v-img max-width="80" contain src="https://www.pikpng.com/pngl/m/342-3427288_oxxo-pay-conoce-5-caracter-237sticas-de-este.png"></v-img>
                                                              </template>
                                                            </v-radio>
                                                        </template>
                                                        <v-col cols="3">
                                                            <v-card outlined class="pa-5 text-justify" style="border: 3px solid #E53935; box-shadow: 1px 0px 9px 3px rgba(0,0,0,0.75);">
                                                              Estamos trabajando para habilitar esta opción de pago, sentimos el inconveniente que te pueda ocasionar.
                                                            </v-card>
                                                        </v-col>
                                                    </v-tooltip>
                                                </v-radio-group>

                                            </v-card>
                                        </v-col>
                                        <v-col v-else-if="localModelIsStepFourDataBankAccount" cols="12">
                                            <v-card elevation="0" :width="$vuetify.breakpoint.xl ? '880' : $vuetify.breakpoint.lg ? '640' : $vuetify.breakpoint.md ? '480' : $vuetify.breakpoint.sm ? '500' : '390'">
                                                <div class="font-weight-bold mb-4">Datos para la transferencia bancaria</div>
                                                <div class="text-uppercase">
                                                    <div class="font-weight-bold" style="color: #3ba2a9">Total a pagar: </div>
                                                    <div class="font-weight-bold">{{mxCurrencyFormat.format(localModelSubtotalAndTotal)}} MXN</div>
                                                </div>
                                                <div class="text-uppercase">
                                                    <div class="font-weight-bold">No. de orden por pagar: </div>
                                                    <div>{{localPropItemQuotationOrderNumberID}}</div>
                                                </div>
                                                <div class="text-uppercase">
                                                    <div class="font-weight-bold">No. de cuenta de banco:</div>
                                                    <div>{{localPropItemQuotationOrderNumberID}}</div>
                                                </div>
                                                <div class="text-uppercase">
                                                    <div class="font-weight-bold">CLABE Interbancaria: </div>
                                                    <div>{{localPropItemQuotationOrderNumberID}}</div>
                                                </div>
                                                <div class="text-uppercase">
                                                    <div class="font-weight-bold">Nombre de la cuenta: </div>
                                                    <div>{{localPropItemQuotationOrderNumberID}}</div>
                                                </div>
                                                <!-- <v-text-field
                                                  v-model="modelObjectDataBankAccount.bankAccount"
                                                  prepend-inner-icon="mdi-bank"
                                                  label="No. de cuenta de banco"
                                                  outlined
                                                ></v-text-field>
                                                <v-text-field
                                                  v-model="modelObjectDataBankAccount.clabe"
                                                  prepend-inner-icon="mdi-card-account-details"
                                                  label="CLABE interbancaria"
                                                  outlined
                                                ></v-text-field>
                                                <v-text-field
                                                  v-model="modelObjectDataBankAccount.nameAccount"
                                                  prepend-inner-icon="mdi-pencil"
                                                  label="Nombre de la cuenta"
                                                  outlined
                                                ></v-text-field> -->
                                            </v-card>
                                        </v-col>
                                    </div>
                                </v-window-item>
                            </v-window>
                            <!-- ESTE WINDOW TERMINA AQUÍ Y HARÁ LA FUNCION DE LOS PASOS DE COMPRA -->

                        </v-col>
                        <div class="text-end">
                            <v-btn
                                v-if="localWindowStepModel == 1"
                                large
                              color="#3ba2a9"
                              class="white--text rounded-lg mt-3"
                            >
                            <v-icon
                            size="30"
                                  left
                                  dark
                                >
                                  mdi-delete
                            </v-icon>Vaciar carrito
                            </v-btn>
                        </div>
                      </v-col>
                      <v-col cols="12" xl="3" lg="3" md="3" sm="12" order="1" order-xl="2" order-lg="2" order-md="2" order-sm="1" :style="!$vuetify.breakpoint.mdAndUp ? 'position: sticky; top: 15px; z-index: 2;' : ''" >
                        <v-card
                        :style="$vuetify.breakpoint.mdAndUp ? 'position: sticky; top: 60px; z-index: 2;' : ''"
                        class="rounded-lg"
                        :class="$vuetify.breakpoint.mdAndUp ? 'mt-10 ' : 'mt-5'"
                            outlined
                        >
                          <div class="white--text text-center font-weight-bold pa-3 rounded-lg" style="background-color: #3ba2a9">Resumen de la orden de la compra</div>
                          <v-row align="center" no-gutters>
                          <v-col cols="12" xl="12" lg="12" md="12" sm="4">
                              <v-row class="pa-3" style="font-size: 0.87rem">
                                  <v-col cols="5">
                                      <div>Subtotal: </div>
                                  </v-col>
                                  <v-col cols="7">
                                      <div class="text-end">{{mxCurrencyFormat.format(localModelSubtotalAndTotal)}} MXN</div>
                                  </v-col>
                                  <v-col cols="5" class="mt-n5">
                                      <div>I.V.A. </div>
                                  </v-col>
                                  <v-col cols="7" class="mt-n5">
                                      <div class="text-end">INCLUIDO</div>
                                  </v-col>
                              </v-row>
                          </v-col>
                          <v-col cols="12" xl="12" lg="12" md="12" sm="4" style="background-color: #B2DFDB">
                            <v-col cols="12" style="background-color: #B2DFDB">
                                <div class="text-end font-weight-bold" style="color: #3ba2a9; font-size: 1.45rem">
                                      {{mxCurrencyFormat.format(localModelSubtotalAndTotal)}} MXN
                                </div>
                            </v-col>
                            <v-col cols="12" style="background-color: #B2DFDB" class="mt-n6">
                                <div class="text-uppercase text-end">
                                    Total
                                </div>
                            </v-col>
                          </v-col>
                          <v-col cols="12" xl="12" lg="12" md="12" sm="4">
                            <v-checkbox
                            v-if="localWindowStepModel == 3"
                            class="mx-3 mb-n5"
                            v-model="checkboxPrivacyTermsAndContinue"
                            label="He leído y estoy de acuerdo con el Aviso de Privacidad">
                            </v-checkbox>
                            <v-card-actions>
                              <v-btn
                                @click="localMethodBtnContinueStepThree"
                                v-if="localWindowStepModel > 0 && localWindowStepModel < 3"
                                :disabled="(localWindowStepModel >= 2) ? false : true"
                                large
                                block
                                color="orange darken-1"
                                class="white--text font-weight-bold rounded-lg mx-auto mt-3"
                                :class="localWindowStepModel <= 2 ? '' : 'mb-7'"
                              >
                                {{btnContinuarTitle}}
                                  <v-icon
                                  size="30"
                                    right
                                    dark
                                  >
                                    mdi-arrow-right
                                  </v-icon>
                              </v-btn>
                              <v-btn
                                @click="localMethodBtnPayStepFour"
                                v-else-if="(localWindowStepModel == 3)"
                                :disabled="(((localWindowStepModel == 3) && checkboxPrivacyTermsAndContinue) && (modelRadioStepFourPaymentMethod != null && modelRadioStepFourPaymentMethod != '')) ? false : true"
                                large
                                block
                                color="orange darken-1"
                                class="white--text font-weight-bold rounded-lg mx-auto mt-3"
                                :class="localWindowStepModel <= 2 ? '' : 'mb-7'"
                              >
                                {{btnContinuarTitle}}
                                  <v-icon
                                  size="30"
                                    right
                                    dark
                                  >
                                    mdi-arrow-right
                                  </v-icon>
                              </v-btn>
                            </v-card-actions>
                            <div v-if="localWindowStepModel <= 2" class="text-decoration-underline text-center mt-n1 mb-4" style="font-size: 0.77rem">Agregar otra persiana</div>
                          </v-col>
                          </v-row>
                        </v-card>
                      </v-col>
                  </v-row>
              </v-col>
          </v-row>
          <DashboardOrdersAndQuotationsDialog @emitCheckAndBuyFromOrdersAndQuotationsDialogView="localMethodStepThreeCheckAndBuy" @emitClickCloseFromOrdersAndQuotationsDialog="emitClickCloseFromOrdersAndQuotationsDialog" :isOrdersAndQuotationsDialogActivated="isOrdersAndQuotationsDialogActivated" :propTotalPrice="localToPropTotalPrice" :propIsOrderOrQuotationString="'quotation'" :propItemQuotationOrderNumberID="localPropItemQuotationOrderNumberID" :idOrderQuotationOrdersAndQuotationsDialog="localCurrentItemOfOrdersAndQuotationsDialogView"></DashboardOrdersAndQuotationsDialog>
      </v-container>
  </div>
</template>

<script>
import OrdersCardsStepOne from '../../components/Dashboard/Marketcar/OrdersCardsStepOne.vue'
import DashboardOrdersAndQuotationsDialog from '../../components/Dashboard/OrdersAndQuotations/DashboardOrdersAndQuotationsDialog.vue'
import DashboardBlindsProductDetailCards from '../../components/Dashboard/BlindsProductDetailCards/DashboardBlindsProductDetailCards.vue';
import { mapState } from 'vuex';
import axios from 'axios';
export default {
    mounted(){
        this.$store.dispatch('getQuotedOrders').then(()=>{
            this.loadingOrdersToOrdersCardsStepOne = true
        })
    },
    data() {
        return {
            modelObjectDataBankAccount: {
                bankAccount: null,
                clabe: null,
                nameAccount: null
            },
            localModelIsStepFourDataBankAccount: false,
            modelRadioStepFourPaymentMethod: '',
            mxCurrencyFormat : new Intl.NumberFormat('en-US', {style: 'currency', currency: 'USD'}),
            localCurrentIDQuotingOrderStepThree: -1,
            localCurrentItemOfOrdersAndQuotationsDialogView: {},
            localModelSubtotalAndTotal: 0,
            modelWindowItemSteps: [
                {step: 1, name: 'ChooseOrder'},
                {step: 2, name: 'CheckAndBuy'},
                {step: 3, name: 'Confirm'}
            ],
            localWindowStepModel: 1,
            localToPropTotalPrice: 0,
            localPropItemQuotationOrderNumberID: '',
            isOrdersAndQuotationsDialogActivated: false,
            loadingOrdersToOrdersCardsStepOne: false,
            checkboxPrivacyTermsAndContinue: false,
            navigationDrawerItems: [
                { title: 'Mi perfil', icon: 'mdi-view-dashboard' },
                { title: 'Órdenes',
                  childItems: [
                    { title: 'Mis Órdenes' },
                    { title: 'Órdenes Distribuidores' }
                  ],
                  active: false,
                  icon: 'mdi-image' },
                { title: 'Cotizaciones',
                  childItems: [
                    { title: 'Mis Cotizaciones' },
                    { title: 'Cotizaciones Distribuidores' }
                  ],
                  active: false,
                  icon: 'mdi-help-box' },
                { title: 'Mis compras', icon: 'mdi-help-box' },
            ],
            marketStepsItems: [
                { title: 'Elegir orden', icon: 'mdi-numeric-1' },
                { title: 'Revisar y pagar', icon: 'mdi-numeric-2' },
                { title: 'Confirmar compra', icon: 'mdi-numeric-3' },
            ],
        }
    },
    methods:{
        localMethodStepThreeCheckAndBuy(localItem){
            this.$store.dispatch('getQuotingOrder', localItem.id).then(()=>{
                this.isOrdersAndQuotationsDialogActivated = false;
                this.localWindowStepModel = 2;
                this.localCurrentIDQuotingOrderStepThree = localItem.id;
                this.localPropItemQuotationOrderNumberID = localItem.order;
                this.localModelSubtotalAndTotal = localItem.total;
                console.log(localItem)
            });

        },
        localMethodIsOrdersAndQuotationsDialogActivatedOn(localItem){
            this.$store.dispatch('getQuotingOrder', localItem.id).then(()=>{
                this.localCurrentItemOfOrdersAndQuotationsDialogView = localItem;
                this.localToPropTotalPrice = localItem.total;
                this.localCurrentIDQuotingOrderStepThree = localItem.id;
                this.localPropItemQuotationOrderNumberID = localItem.order;
                this.isOrdersAndQuotationsDialogActivated = true;
            });
        },
        localMethodEditBlindStepThreeMarketcar(){
            if(this.localCurrentIDQuotingOrderStepThree > -1){
                // this.$store.dispatch('editQuotingOrder', this.localCurrentIDQuotingOrderStepThree).then(()=>{
                //     this.$router.push({name: 'Quoter', params:{order_id: this.localCurrentIDQuotingOrderStepThree}})
                // });
                this.localWindowStepModel = 1;
                this.localMethodIsOrdersAndQuotationsDialogActivatedOn(this.quotedOrders.find(item=>item.id == this.localCurrentIDQuotingOrderStepThree));
                // this.localMethodIsOrdersAndQuotationsDialogActivatedOn();
            }
        },
        localMethodBtnContinueStepThree(){
            this.localWindowStepModel = 3;
        },
        localMethodBtnPayStepFour(){
            if(this.localModelIsStepFourDataBankAccount == false){
                this.localModelIsStepFourDataBankAccount = true;
            }
            else if(this.localModelIsStepFourDataBankAccount == true){
                // let validObjectDataBankAccount = Object.values(this.modelObjectDataBankAccount).filter(item=>(item != null && item != '')).length;
                // if(validObjectDataBankAccount == 3){
                //     console.log(this.localCurrentIDQuotingOrderStepThree)
                //     axios.post(`/api/buy/${this.localCurrentIDQuotingOrderStepThree}`, {bank_account: this.modelObjectDataBankAccount.bankAccount, clabe: this.modelObjectDataBankAccount.clabe, name_account: this.modelObjectDataBankAccount.nameAccount}).then((response)=>{
                //         if(response.status === 200){
                //             console.log("PASO 4")
                //         }
                //     });
                // }
            }
        },


        emitClickCloseFromOrdersAndQuotationsDialog(){
            this.localToPropTotalPrice = 0;
            this.localCurrentItemOfOrdersAndQuotationsDialogView = {};
            this.localPropItemQuotationOrderNumberID = '';
            this.isOrdersAndQuotationsDialogActivated = false;
        },

        changeStepWindowFromAlerts(index){
            if(index <= 3 && index != this.localWindowStepModel){
                this.localWindowStepModel = index;
            }
        }
    },
    computed:{
        ...mapState({
            quotedOrders: state => state.ordersModule.quotedOrders,
            orders: state => state.ordersModule.orders,
            quotingOrders: state => state.ordersModule.quotingOrders,
            quotingOrder : state => state.ordersModule.quotingOrder,
            user: (state) => state.user,

        }),
        computedNavigationDrawerItemsWithChild(){
            return [{...this.navigationDrawerItems[1]}, {...this.navigationDrawerItems[2]}]
        },
        btnContinuarTitle(){
            return this.localWindowStepModel == 3 ? 'Pagar' : 'Continuar';
        },
        computedNoPaidOrders(){
            return this.quotedOrders.filter(itemOrder=> itemOrder.state == 'No Pagada');
        }
    },
    components:{
        OrdersCardsStepOne,
        DashboardOrdersAndQuotationsDialog,
        DashboardBlindsProductDetailCards
    }
}
</script>

<style scoped>
.localBorderNoActiveClass{
    border: 2px solid #757575;
    border-radius: 5px;
    filter: grayscale(1);
}
>>>.v-radio.v-item--active{
    border: 2px solid #3ba2a9;
    border-radius: 5px;
    filter: grayscale(0);
}
</style>
