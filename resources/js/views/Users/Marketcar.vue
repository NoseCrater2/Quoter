<template>
  <div>
      <v-container fluid>
          <div class="text-center text-uppercase my-2" style="font-size: 1.5rem">
              <span>Carrito </span><span class="font-weight-bold" style="color: #3ba2a9">de compra</span>
          </div>
          <v-row class="mt-3">
              <v-col v-if="$vuetify.breakpoint.mdAndUp" cols="12" xl="3" lg="3" md="3" sm="3">
                <v-card v-if="user.role == 'Superadministrador' || user.role == 'Administrador'" outlined class="rounded-lg" style="position: sticky; top: 60px; z-index: 2;">
                    <v-card-title style="background: #3ba2a9" class="font-weight-bold white--text">
                        Mi cuenta
                    </v-card-title>
                    <v-list dense color="#f0f0f0">
                        <v-list-item link :to="{name: 'Profile'}">
                            <v-list-item-icon>
                            </v-list-item-icon>
                            <v-list-item-content>
                                <v-list-item-title>Mi Perfil</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                        <v-divider></v-divider>
                        <v-list-group color="#3ba2a9" :value="true" no-action sub-group>
                            <template v-slot:activator>
                              <v-list-item-content>
                                <v-list-item-title>Órdenes</v-list-item-title>
                              </v-list-item-content>
                            </template>
                            <v-list-item
                            :to="option.route"
                            dense
                            v-for="(option, i) in admins"
                            :key="i"
                            link
                            >
                              <v-card-subtitle class="pa-0" style="font-size: 0.8125rem" v-text="option.title"></v-card-subtitle>
                            </v-list-item>
                        </v-list-group>
                        <v-list-group  color="#3ba2a9" :value="true" no-action sub-group>
                          <template v-slot:activator>
                            <v-list-item-content>
                              <v-list-item-title>Cotizaciones</v-list-item-title>
                            </v-list-item-content>
                          </template>
                          <v-list-item
                            :to="option.route"
                            dense
                            v-for="(option, i) in cruds"
                            :key="i"
                            link
                          >
                            <v-card-subtitle class="pa-0" style="font-size: 0.8125rem" v-text="option.title"></v-card-subtitle>
                          </v-list-item>
                        </v-list-group>
                        <v-divider></v-divider>
                        <v-list-item>
                            <v-list-item-icon>
                            </v-list-item-icon>
                            <v-list-item-content>
                                <v-list-item-title>Mis compras</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list>
                </v-card>

                <v-card v-else outlined class="rounded-lg" style="position: sticky; top: 60px; z-index: 2;">
                    <v-card-title style="background: #3ba2a9" class="font-weight-bold white--text">
                        Mi cuenta
                    </v-card-title>
                    <v-list dense color="#f0f0f0">
                        <v-list-item link :to="{name: 'Profile'}">
                            <v-list-item-icon>
                            </v-list-item-icon>
                            <v-list-item-content>
                                <v-list-item-title>Mi Perfil</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                        <v-divider></v-divider>
                        <v-list-item link :to="{name: 'Orders', params: {option: 'ordenes'}}">
                            <v-list-item-icon>
                            </v-list-item-icon>
                            <v-list-item-content>
                                <v-list-item-title>Ordenes</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                        <v-list-item link :to="{name: 'Orders', params: {option: 'cotizaciones'}}">
                            <v-list-item-icon>
                            </v-list-item-icon>
                            <v-list-item-content>
                                <v-list-item-title>Cotizaciones</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                        <v-divider></v-divider>
                        <v-list-item>
                            <v-list-item-icon>
                            </v-list-item-icon>
                            <v-list-item-content>
                                <v-list-item-title>Mis compras</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list>
                </v-card>

              </v-col>
              <v-col cols="12" xl="9" lg="9" md="9" sm="12">
                  <v-row align="center" no-gutters>
                      <v-col cols="4" v-for="(item, index) in marketStepsItems" @click="methodChangeStepWindowFromAlerts((index+1))" :key="index">
                          <!-- @click="changeStepWindowFromAlerts((index+1))" -->
                        <v-alert

                            class="mx-1"
                            :color="(index+1) == modelWindowSteper ? 'orange darken-1' : 'grey lighten-2'"
                        >
                            <div :class="(index+1) == modelWindowSteper ? 'font-weight-bold white--text' : 'font-weight-bold black--text'" style="font-size: 2rem">{{index + 1}}  </div><div :class="(index+1) == modelWindowSteper ? 'white--text' : 'black--text'" style="font-size: 1.2rem">{{item.title}}</div>
                        </v-alert>
                      </v-col>
                  </v-row>
                  <v-row class="mt-n5">
                      <v-col cols="12" :xl="!flagIsStepFour ? '9' : '12'" :lg="!flagIsStepFour ? '9' : '12'" :md="!flagIsStepFour ? '9' : '12'" sm="12" order="2" order-xl="1" order-lg="1" order-md="1" order-sm="2">
                        <div v-if="modelWindowSteper == 1" class="text-start text-uppercase mb-2" style="font-size: 1.4rem;">
                            <span class="font-weight-bold" style="color: #3ba2a9">Órdenes </span><span>pendientes de pago</span>
                        </div>
                        <div v-else-if="modelWindowSteper == 2" class="text-start text-uppercase mb-2" style="font-size: 1.4rem;">
                            <v-row no-gutters>
                                <span class="font-weight-bold" style="color: #3ba2a9">Producto </span><span style="color: #3ba2a9">(s)</span>
                                <v-spacer></v-spacer>
                                <span>#Orden <span class="font-weight-bold" style="color: #3ba2a9"> {{localPropItemQuotationOrderNumberID}}</span></span>
                            </v-row>
                        </div>
                        <div v-else-if="modelWindowSteper == 3" class="text-start text-uppercase mb-2" style="font-size: 1.4rem;">
                            <v-row no-gutters>
                                <span class="font-weight-bold" style="color: #3ba2a9">Pagar orden</span>
                                <v-spacer></v-spacer>
                                <span>#Orden <span class="font-weight-bold" style="color: #3ba2a9"> {{localPropItemQuotationOrderNumberID}}</span></span>
                            </v-row>
                        </div>
                        <v-col cols="12" v-if="loadingOrdersToOrdersCardsStepOne" :class="(loadingOrdersToOrdersCardsStepOne && computedNoPaidOrders.length == 0) ? 'd-flex align-center justify-center' : ''"  style="border: 1px solid #BDBDBD; min-height: 400px;">
                            <!-- V-IF: SI EL CARRITO ESTÁ VACÍO -->
                            <div v-if="loadingOrdersToOrdersCardsStepOne && computedNoPaidOrders.length == 0">
                                <v-img
                                  contain
                                  height="160"
                                  src="/img/dashboard/cart-outline.png"
                                ></v-img>
                                <h3 class="text-h6 font-weight-light mb-2 text-center">
                                    El carrito de compras está vacio
                                </h3>
                            </div>

                            <div v-else-if="loadingOrdersToOrdersCardsStepOne && computedNoPaidOrders.length > 0">
                                <router-view
                                    :key="$route.path"
                                    @emitCancelOrder="methodOpenDialogCancelOneOrder"
                                    @emitDetailsItemFromOrdersCardsStepOneView="methodIsOrdersAndQuotationsDialogActivated"

                                    @emitDeleteBlindFromDetailCards="methodOpenDialogDeleteBlind"
                                    @emitEditBlindFromBlindsProductDetailCardsView="localMethodEditBlindStepThreeMarketcar"

                                    @changeRadioValue="changeRadioValue"
                                >
                                </router-view>
                            </div>


                        </v-col>
                        <v-col v-else cols="12" class="d-flex align-center justify-center"  style="border: 1px solid #BDBDBD; min-height: 400px;">
                            <v-progress-circular
                              size="52"
                              indeterminate
                              color="primary"
                            ></v-progress-circular>
                        </v-col>
                        <div class="text-end">
                            <v-btn
                                @click="methodOpenDialogCancelAllOrders()"
                                :disabled="(computedNoPaidOrders.length > 0) ? false : true"
                                v-if="modelWindowSteper == 1"
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
                      <v-col v-if="!flagIsStepFour" cols="12" xl="3" lg="3" md="3" sm="12" order="1" order-xl="2" order-lg="2" order-md="2" order-sm="1" :style="!$vuetify.breakpoint.mdAndUp ? 'position: sticky; top: 15px; z-index: 2;' : ''" >
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
                            v-if="modelWindowSteper == 3"
                            class="mx-3 mb-n5"
                            v-model="checkboxPrivacyTermsAndContinue"
                            label="He leído y estoy de acuerdo con el Aviso de Privacidad">
                            </v-checkbox>
                            <v-card-actions>
                              <v-btn
                                :disabled="(!computedIsNotNullLocalStorage == false && computedIsAceptedTerms == true) ? false : true"
                                @click="methodContinueStep"
                                large
                                block
                                color="orange darken-1"
                                class="white--text font-weight-bold rounded-lg mx-auto mt-3"
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
                            <!-- <div v-if="modelWindowSteper == 2" class="text-decoration-underline text-center mt-n1 mb-4" style="font-size: 0.77rem">Agregar otra persiana</div> -->
                          </v-col>
                          </v-row>
                        </v-card>
                      </v-col>
                  </v-row>
              </v-col>
          </v-row>
          <DashboardOrdersAndQuotationsDialog :id="orderId" v-if="isOrdersAndQuotationsDialogActivated" @emitClickCloseFromOrdersAndQuotationsDialog="emitClickCloseFromOrdersAndQuotationsDialog" @emitCheckAndBuyFromOrdersAndQuotationsDialogView="methodStepTwoCheckAndBuy" ></DashboardOrdersAndQuotationsDialog>


            <v-dialog v-model="modelDialogCancelAllOrders" persistent max-width="290">
              <v-card>
                <v-card-title class="headline">¿Vaciar carrito?</v-card-title>
                <v-card-text>
                  TODAS las ordenes que estan en el CARRITO pasarán de nuevo a la ventana de COTIZACIONES.
                  ¿Está seguro?
                </v-card-text>
                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn color="gray darken-1" text @click="methodCloseDialogCancelAllOrders()">CANCELAR</v-btn>
                  <v-btn color="primary" :loading="isCancellingAllOrders" :disabled="isCancellingAllOrders" text @click="methodCancelAllOrders()">ACEPTAR</v-btn>
                </v-card-actions>
              </v-card>
            </v-dialog>

            <v-dialog v-model="modelDialogCancelOneOrder" persistent max-width="290">
              <v-card>
                <v-card-title class="headline">¿Cancelar orden?</v-card-title>
                <v-card-text>
                  Si CANCELA, esta ORDEN pasará de nuevo a la ventana de COTIZACIONES.
                  ¿Está seguro?
                </v-card-text>
                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn color="gray darken-1" text @click="methodCloseDialogCancelOneOrder()">CANCELAR</v-btn>
                  <v-btn color="primary" :loading="isCancellingOneOrder" :disabled="isCancellingOneOrder" text @click="methodCancelOneOrder()">ACEPTAR</v-btn>
                </v-card-actions>
              </v-card>
            </v-dialog>

            <v-dialog v-model="modelDialogDeleteBlind" persistent max-width="290">
              <v-card>
                <v-card-title class="headline">¿Eliminar persiana?</v-card-title>
                <v-card-text>
                  Si continua, está persiana se eliminará de la orden y no se podrá recuperar.
                  ¿Está seguro?
                </v-card-text>
                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn color="gray darken-1" text @click="methodCloseDialogDeleteBlind()">CANCELAR</v-btn>
                  <v-btn color="red" :loading="isDeletingBlind" :disabled="isDeletingBlind" text @click="methodDeleteBlind()">ELIMINAR</v-btn>
                </v-card-actions>
              </v-card>
            </v-dialog>

      </v-container>
  </div>
</template>

<script>
import DashboardOrdersAndQuotationsDialog from '../../components/Dashboard/OrdersAndQuotations/DashboardOrdersAndQuotationsDialog.vue'
import axios from 'axios';
import { mapState } from 'vuex';
export default {
    created(){
        this.$store.dispatch('getQuotedOrders').then(()=>{
            this.loadingOrdersToOrdersCardsStepOne = true
            if(Object.keys(this.quotedOrder).length == 0){
                if(localStorage.getItem('quotedOrder') !== null){
                    Object.assign(this.quotedOrder, this.$store.getters.getQuotedOrder.order)
                }
            }
        })
    },
    data() {
        return {
            modelDialogCancelAllOrders: false,
            modelDialogCancelOneOrder: false,
            modelCancelOneOrderItemId: -1,
            modelDeleteBlindItemId: -1,
            modelDialogDeleteBlind: false,
            isCancellingAllOrders: false,
            isCancellingOneOrder: false,
            isDeletingBlind: false,
            isChargingPetitionSPEIPayment: false,
            flagIsStepFour: false,
            urlNetPayPayment: null,
            modelRadioStepFourPaymentMethod: localStorage.getItem('quotedOrder') !== null ? JSON.parse(localStorage.getItem('quotedOrder')).paymentType : '',
            mxCurrencyFormat : new Intl.NumberFormat('en-US', {style: 'currency', currency: 'USD'}),
            localModelSubtotalAndTotal: localStorage.getItem('quotedOrder') !== null ? JSON.parse(localStorage.getItem('quotedOrder')).order.total : 0,
            modelWindowItemSteps: [
                {step: 1, name: 'ChooseOrder'},
                {step: 2, name: 'CheckAndBuy'},
                {step: 3, name: 'Confirm'}
            ],
            modelWindowSteper: localStorage.getItem('quotedOrder') !== null ? JSON.parse(localStorage.getItem('quotedOrder')).step : 1,
            localToPropTotalPrice: 0,
            localPropItemQuotationOrderNumberID: localStorage.getItem('quotedOrder') !== null ? JSON.parse(localStorage.getItem('quotedOrder')).order.order : '',
            isOrdersAndQuotationsDialogActivated: false,
            loadingOrdersToOrdersCardsStepOne: false,
            checkboxPrivacyTermsAndContinue: localStorage.getItem('quotedOrder') !== null ? JSON.parse(localStorage.getItem('quotedOrder')).isCheckTerms : false,
            marketStepsItems: [
                { title: 'Elegir orden', icon: 'mdi-numeric-1' },
                { title: 'Revisar y pagar', icon: 'mdi-numeric-2' },
                { title: 'Confirmar compra', icon: 'mdi-numeric-3' },
            ],
            admins: [
                {title: 'Mis Órdenes', route: {name: 'Orders', params: {option: 'ordenes'}}},
                {title: 'Ordenes Distribuidores', route: {name: 'Orders', params: {option: 'ordenes-admin'}}}
            ],

            cruds: [
                {title: 'Mis Cotizaciones', route: {name: 'Orders', params: {option: 'cotizaciones'}} },
                {title: 'Cotizaciones Distribuidores', route: {name: 'Orders', params: {option: 'cotizaciones-admin'}}}
            ],
            orderId: 0,
        }
    },
    methods:{

        methodOpenDialogCancelAllOrders(){
            this.modelDialogCancelAllOrders = true;
        },

        methodOpenDialogCancelOneOrder(itemID){
            this.modelCancelOneOrderItemId = itemID;
            this.modelDialogCancelOneOrder = true;
        },

        methodOpenDialogDeleteBlind(itemBlindID){
            this.modelDeleteBlindItemId = itemBlindID;
            this.modelDialogDeleteBlind = true;
        },

        methodCloseDialogCancelAllOrders(){
            this.modelDialogCancelAllOrders = false;
        },

        methodCloseDialogCancelOneOrder(){
            this.modelCancelOneOrderItemId = -1;
            this.modelDialogCancelOneOrder = false;
        },

        methodCloseDialogDeleteBlind(){
            this.modelDeleteBlindItemId = -1;
            this.modelDialogDeleteBlind = false;
        },

        changeRadioValue(value){
            this.modelRadioStepFourPaymentMethod = value;
            if(localStorage.getItem('quotedOrder') !== null){
                let localStorageObject = JSON.parse(localStorage.getItem('quotedOrder'))
                localStorageObject.paymentType = this.modelRadioStepFourPaymentMethod;
                localStorage.setItem('quotedOrder', JSON.stringify(localStorageObject));
            }
        },

        methodCancelAllOrders(){
            this.isCancellingAllOrders = true;
            this.$store.dispatch('removeAllOrdersMarketcar').then(async ()=>{
                await this.$store.dispatch('getQuotedOrders');
                await this.$store.dispatch('getQuotingOrders');
                localStorage.removeItem('quotedOrder');
                this.isCancellingAllOrders = false;
                this.methodCloseDialogCancelAllOrders();
                console.log('mod')
            });
        },

        methodCancelOneOrder(){
            this.isCancellingOneOrder = true;
            if(this.modelCancelOneOrderItemId > -1){
                if(localStorage.getItem('quotedOrder') !== null){
                    let localStorageObject = JSON.parse(localStorage.getItem('quotedOrder'));
                    if(localStorageObject.order.id == this.modelCancelOneOrderItemId){
                        localStorage.removeItem('quotedOrder')
                    }
                }
                this.$store.dispatch('removeOrderMarketcar', this.modelCancelOneOrderItemId).then(async()=>{
                    await this.$store.dispatch('getQuotedOrders');
                    await this.$store.dispatch('getQuotingOrders');
                    this.isCancellingOneOrder = false;
                    this.methodCloseDialogCancelOneOrder();
                });
            }
        },

        methodDeleteBlind(){
            this.isDeletingBlind = true;
            if(this.modelDeleteBlindItemId > -1){
                if(localStorage.getItem('quotedOrder') !== null){
                    let localStorageObject = JSON.parse(localStorage.getItem('quotedOrder'))
                    let findedIdBlind = localStorageObject.order.blinds.findIndex((itemBlind) => itemBlind.id == this.modelDeleteBlindItemId);
                    if(findedIdBlind > -1){
                        let removed = localStorageObject.order.blinds.splice(findedIdBlind, 1);
                        localStorage.setItem('quotedOrder', JSON.stringify(localStorageObject));
                    }
                }
                this.$store.dispatch('deleteBlindFromOrder', this.modelDeleteBlindItemId).then(async()=>{
                    await this.$store.dispatch('getQuotedOrder', this.quotedOrder.id);
                    await this.$store.dispatch('getQuotedOrders');
                    this.isDeletingBlind = false;
                    this.methodCloseDialogDeleteBlind();
                })
            }
        },

        methodStepTwoCheckAndBuy(localItem){
            this.$store.dispatch('getQuotedOrder', localItem.id).then(()=>{
                localStorage.removeItem('quotedOrder');
                localStorage.setItem('quotedOrder', JSON.stringify({order:this.quotedOrder, step: 2, paymentType: '', isCheckTerms: false}));
                this.orderId = localItem.id;
                this.isOrdersAndQuotationsDialogActivated = false;
                this.modelWindowSteper = 2;
                this.localPropItemQuotationOrderNumberID = localItem.order;
                this.localModelSubtotalAndTotal = localItem.total;
                this.$router.push({name: 'StepTwoDetails'});

            });

        },

        methodIsOrdersAndQuotationsDialogActivated(itemID){
            this.$store.dispatch('getQuotedOrder', itemID).then(()=>{
                this.orderId = itemID;
                this.isOrdersAndQuotationsDialogActivated = true;
            })
        },

        localMethodEditBlindStepThreeMarketcar(idItem){
            this.modelWindowSteper = 1;
            this.methodIsOrdersAndQuotationsDialogActivated(this.quotedOrders.find(item=>item.id == idItem).id);
        },

        localMethodBtnContinueStepThree(){
            this.modelWindowSteper = 3;
        },

        localMethodBtnPayStepFour(){
            if(this.flagIsStepFour == false){
                if(this.modelRadioStepFourPaymentMethod != '' && this.modelRadioStepFourPaymentMethod == 'debitcreditcard'){
                    this.flagIsStepFour = true;
                }
                if(this.modelRadioStepFourPaymentMethod != '' && this.modelRadioStepFourPaymentMethod == 'electronicspei'){
                    this.isChargingPetitionSPEIPayment = true;
                    axios.get(`/api/spei-payment/${this.orderId}`).then(async(response)=>{
                        if(response.status == 200){
                            if(this.user.role == 'Superadministrador' || this.user.role == 'Administrador'){
                                await this.$store.dispatch('getAdminQuotedOrders')
                                await this.$store.dispatch('getAdminQuotingOrders')
                            }
                            else{
                                await this.$store.dispatch('getQuotedOrders')
                                await this.$store.dispatch('getQuotingOrders')
                            }
                            localStorage.removeItem('quotedOrder');
                            this.flagIsStepFour = true;
                            this.isChargingPetitionSPEIPayment = false;
                        }
                    });
                }
            }
        },

        emitClickCloseFromOrdersAndQuotationsDialog(){
            this.isOrdersAndQuotationsDialogActivated = false;
        },

        methodChangeStepWindowFromAlerts(index){
            if(this.computedIsNotNullLocalStorage){
                if(index <= 3 && index != this.modelWindowSteper){
                    this.modelWindowSteper = index;
                    let localStorageObject = JSON.parse(localStorage.getItem('quotedOrder'))
                    localStorageObject.step =  this.modelWindowSteper;
                    localStorage.setItem('quotedOrder', JSON.stringify(localStorageObject));
                    switch(this.modelWindowSteper){
                        case 1:
                                this.$router.push({name: 'Marketcar'});
                            break;
                        case 2:
                                this.$router.push({name: 'StepTwoDetails'});
                            break;
                        case 3:
                                this.$router.push({name: 'StepThreeChoose'});
                            break;
                    }
                }
            }
        },

        methodContinueStep(){
            if(this.computedIsNotNullLocalStorage){
                switch (this.$route.name) {
                  case 'Marketcar':
                        let localStorageObject1 = JSON.parse(localStorage.getItem('quotedOrder'))
                        localStorageObject1.step = 2;
                        this.modelWindowSteper = 2;
                        localStorage.setItem('quotedOrder', JSON.stringify(localStorageObject1));
                      this.$router.push({name: 'StepTwoDetails'});
                    break;
                  case 'StepTwoDetails':
                        let localStorageObject2 = JSON.parse(localStorage.getItem('quotedOrder'))
                        localStorageObject2.step = 3;
                        this.modelWindowSteper = 3;
                        localStorage.setItem('quotedOrder', JSON.stringify(localStorageObject2));
                        this.$router.push({name: 'StepThreeChoose'});
                    break;
                //   case 'StepThreeChoose':

                //     break;
                //   default:

                //     break;
                }
            }
            console.log(this.$route.name)
        }

    },
    computed:{
        ...mapState({
            quotedOrders: state => state.ordersModule.quotedOrders,
            quotedOrder: state => state.ordersModule.quotedOrder,
            user: state => state.user,
        }),
        btnContinuarTitle(){
            return this.modelWindowSteper == 3 ? 'Pagar' : 'Continuar';
        },
        computedNoPaidOrders(){
            return this.quotedOrders.filter(itemOrder=> itemOrder.state == 'No Pagada');
        },
        computedIsNotNullLocalStorage(){
            if(localStorage.getItem('quotedOrder') !== null){
                return true;
            }
            else{
                return false;
            }
        },
        computedIsAceptedTerms(){
            if(this.modelWindowSteper == 3){
                if(this.checkboxPrivacyTermsAndContinue == true && this.modelRadioStepFourPaymentMethod != ''){
                    return true;
                }
                else{
                    return false;
                }
            }
            return true;
        }
    },
    watch:{
        checkboxPrivacyTermsAndContinue(newValue, oldValue){
            if(localStorage.getItem('quotedOrder') !== null){
                let localStorageObject = JSON.parse(localStorage.getItem('quotedOrder'))
                localStorageObject.isCheckTerms = newValue;
                localStorage.setItem('quotedOrder', JSON.stringify(localStorageObject));
            }
        }
    },
    components:{
        DashboardOrdersAndQuotationsDialog,
    }
}
</script>

<style scoped>

</style>
