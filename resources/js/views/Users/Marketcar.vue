<template>
  <div>
      <v-container fluid>
          <div class="text-center text-uppercase my-2" style="font-size: 1.5rem">
              <span>Carrito </span><span class="font-weight-bold" style="color: #3ba2a9">de compra</span>
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
                            <v-list-item-title>Mis compras</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </v-list>


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
                      <v-col cols="12" :xl="!localModelIsStepFourDataBankAccount ? '9' : '12'" :lg="!localModelIsStepFourDataBankAccount ? '9' : '12'" :md="!localModelIsStepFourDataBankAccount ? '9' : '12'" sm="12" order="2" order-xl="1" order-lg="1" order-md="1" order-sm="2">
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

                            <!-- V-ELSE: ESTE WINDOW INICIA AQUÍ Y HARÁ LA FUNCION DE LOS PASOS DE COMPRA -->
                            <v-window class="mx-auto" v-else-if="loadingOrdersToOrdersCardsStepOne && computedNoPaidOrders.length > 0" v-model="localWindowStepModel">
                                <v-window-item  v-for="(item, windowIndex) in modelWindowItemSteps" :key="windowIndex" :value="(windowIndex+1)">
                                <!-- DENTRO DE ESTE WINDOW ITEM SE CARGARÁ EL COMPONENTE DE PASO CORRESPONDIENTE -->
                                    <!-- INICIA CARGA EL COMPONENTE DEL STEP 1 -->
                                    <OrdersCardsStepOne @emitCancelOrder="methodOpenDialogCancelOneOrder" @emitCheckAndBuyFromOrdersCardsStepOneView="localMethodStepThreeCheckAndBuy" @emitDetailsItemFromOrdersCardsStepOneView="localMethodIsOrdersAndQuotationsDialogActivatedOn" :itemOrder="computedNoPaidOrders" v-if="localWindowStepModel == 1"></OrdersCardsStepOne>
                                    <!-- TERMINA CARGA EL COMPONENTE DEL STEP 1 -->
                                    <div v-else-if="localWindowStepModel == 2">
                                        <v-col cols="12" v-for="(itemBlind, index) in quotedOrder.blinds" :key="itemBlind.id">
                                            <DashboardBlindsProductDetailCards :propOrderUser="quotedOrder.user"  @emitDeleteBlindFromDetailCards="methodOpenDialogDeleteBlind" @emitEditBlindFromBlindsProductDetailCardsView="localMethodEditBlindStepThreeMarketcar" :propIsInMarketAndStepThree="true" :propIsOrderOrQuotationString="'quoted'" :propItemArrayBlindsObject="itemBlind" :propBlindCount="(index + 1)" :propBreakpointFromDialog="$vuetify.breakpoint"></DashboardBlindsProductDetailCards>
                                        </v-col>
                                    </div>
                                    <div v-else-if="localWindowStepModel == 3">
                                        <v-col v-if="!localModelIsStepFourDataBankAccount" cols="12">
                                            <v-card elevation="0">

                                                <div class="font-weight-bold mb-2">Elije el metodo de pago que mas prefieras</div>
                                                <v-alert
                                                  color="#3ba2a9"
                                                  dense
                                                  text
                                                  type="info"
                                                >
                                                  Por el momento únicamente está habilitado el pago mediante el Sistema de Pagos Electrónicos Interbancarios (SPEI).
                                                  Estamos trabajando para habilitar más formas de pago. Lamentamos las molestias que este inconveniente pudiera ocasionar.
                                                </v-alert>
                                                <v-radio-group v-model="modelRadioStepFourPaymentMethod" >
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
                                        <v-col v-else-if="localModelIsStepFourDataBankAccount" cols="12" style="background-color: #E0E0E0">
                                            <v-card color="white" style="font-size: 1.3rem" elevation="0" class="px-0">
                                                <v-card-text class="text--primary">
                                                    <v-row align="center" justify="space-between">
                                                        <v-col cols="9">
                                                            <span class="font-weight-bold mb-4" style="font-size: 1.4rem">Datos para la transferencia bancaria</span>
                                                        </v-col>
                                                        <v-col cols="3" class="d-flex justify-end">
                                                            <v-img max-width="100" contain src="https://cdn2.downdetector.com/static/uploads/logo/spei.png"></v-img>
                                                        </v-col>
                                                    </v-row>
                                                </v-card-text>
                                                <v-card-text style="background-color: #E0E0E0" class="text--primary">
                                                    <v-row no-gutters justify="center">

                                                        <v-col cols="12" xl="6" lg="6" md="6" sm="12" :class="!$vuetify.breakpoint.mdAndUp ? 'd-flex flex-column align-center text-center' : ''">
                                                            <div class="mb-7">
                                                                <v-img max-width="430" min-width="300" contain src="http://www.visaalmundo.com/blog/wp-content/uploads/2016/10/Banorte-Logo-EPS-vector-image.png"></v-img>
                                                            </div>
                                                            <div class="text-uppercase">
                                                                <div class="font-weight-bold">Total a pagar: </div>
                                                                <div class="font-weight-bold" style="color: #3ba2a9; font-size: 1.8rem">{{mxCurrencyFormat.format(localModelSubtotalAndTotal)}} MXN</div>
                                                            </div>
                                                            <div class="text-uppercase my-2">
                                                                <div class="font-weight-bold">No. de orden por pagar: </div>
                                                                <div>{{localPropItemQuotationOrderNumberID}}</div>
                                                            </div>
                                                            <div class="text-uppercase my-2">
                                                                <div class="font-weight-bold">No. de cuenta de banco:</div>
                                                                <div>0892 6082 67</div>
                                                            </div>
                                                            <div class="text-uppercase my-2">
                                                                <div class="font-weight-bold">CLABE Interbancaria: </div>
                                                                <div>072 470 0089 2608 2678</div>
                                                            </div>
                                                            <div>
                                                                <div class="font-weight-bold text-uppercase">Nombre de la cuenta: </div>
                                                                <div>Materiales Decorativos S. de R.L. MI.</div>
                                                            </div>
                                                        </v-col>

                                                        <v-col cols="12" xl="6" lg="6" md="6" sm="12" :class="$vuetify.breakpoint.mdAndUp ? 'd-flex flex-column align-center' : 'd-flex flex-column align-center mt-3 text-center'">

                                                            <v-card color="white" outlined min-height="330">
                                                                <v-card-text class="text--primary font-weight-bold" style="font-size: 1.1rem">
                                                                    Como hacer una transferencia bancaria desde tu banca móvil
                                                                </v-card-text>
                                                                <v-card-text class="text--primary">
                                                                    <span>
                                                                        1. Accede a la Banca Móvil desde la plataforma de tu cuenta
                                                                        de banco favorita.
                                                                    </span><br>
                                                                    <span>
                                                                        2. Encuentra y selecciona "Transferencias y Pagos".
                                                                    </span><br>
                                                                    <span>
                                                                        3. Si tu plataforma es Banorte selecciona "Terceros Banorte y otros bancos".
                                                                        Si tu plataforma es de otro banco, busca la opción que diga "Otros bancos".
                                                                    </span><br>
                                                                    <span>
                                                                        4. Escribe la cuenta destinatario.
                                                                    </span><br>
                                                                    <span>
                                                                        5. Ingresa el importe, el concepto, y el día en que quieres aplicar la transferencia.
                                                                    </span><br>
                                                                    <span>
                                                                        6. Revisa los datos y finaliza la operación.
                                                                    </span><br>
                                                                </v-card-text>
                                                            </v-card>

                                                            <v-spacer></v-spacer>
                                                            <v-btn large elevation="0" color="#3ba2a9" class="mt-3 white--text">
                                                                <v-icon left>mdi-printer</v-icon>IMPRIMIR
                                                            </v-btn>
                                                        </v-col>

                                                    </v-row>
                                                    <v-divider class="mt-3"></v-divider>
                                                </v-card-text>
                                                <v-card-text style="background-color: #E0E0E0" class="text--primary mt-n4">
                                                    <div style="font-size: 0.95rem" class="text-center">
                                                        Estimado usuario, usted debe imprimir este documento y abonar el importe dentro de
                                                        las próximas 48 horas hábiles en la entidad bancaria correspondiente. La confirmación de pago
                                                        puede tardar entre 24 y 48 horas. Una vez que haya realizado su pago no olvide enviarnos una copia
                                                        de su ficha de pago a <span class="text-decoration-underline">contacto@rollux.com.mx</span> junto con el número de su orden.
                                                    </div>
                                                </v-card-text>
                                            </v-card>
                                        </v-col>
                                    </div>
                                </v-window-item>
                            </v-window>
                            <!-- ESTE WINDOW TERMINA AQUÍ Y HARÁ LA FUNCION DE LOS PASOS DE COMPRA -->

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
                                :disabled="computedNoPaidOrders.length > 0 ? false : true"
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
                      <v-col v-if="!localModelIsStepFourDataBankAccount" cols="12" xl="3" lg="3" md="3" sm="12" order="1" order-xl="2" order-lg="2" order-md="2" order-sm="1" :style="!$vuetify.breakpoint.mdAndUp ? 'position: sticky; top: 15px; z-index: 2;' : ''" >
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
                                v-if="(localWindowStepModel > 0 && localWindowStepModel < 3)"
                                :disabled="(localWindowStepModel >= 2 && computedNoPaidOrders.length > 0 ) ? false : true"
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
                                :disabled="(((localWindowStepModel == 3 && computedNoPaidOrders.length > 0 && !(isChargingPetitionSPEIPayment)) && checkboxPrivacyTermsAndContinue) && (modelRadioStepFourPaymentMethod != null && modelRadioStepFourPaymentMethod != '')) ? false : true"
                                :loading="(isChargingPetitionSPEIPayment) ? true : false"
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
                            <!-- <div v-if="localWindowStepModel == 2" class="text-decoration-underline text-center mt-n1 mb-4" style="font-size: 0.77rem">Agregar otra persiana</div> -->
                          </v-col>
                          </v-row>
                        </v-card>
                      </v-col>
                  </v-row>
              </v-col>
          </v-row>
          <DashboardOrdersAndQuotationsDialog :id="orderId" v-if="isOrdersAndQuotationsDialogActivated" @emitClickCloseFromOrdersAndQuotationsDialog="emitClickCloseFromOrdersAndQuotationsDialog" @emitCheckAndBuyFromOrdersAndQuotationsDialogView="localMethodStepThreeCheckAndBuy" ></DashboardOrdersAndQuotationsDialog>


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
            modelDialogCancelAllOrders: false,
            modelDialogCancelOneOrder: false,
            modelCancelOneOrderItemId: -1,
            modelDeleteBlindItemId: -1,
            modelDialogDeleteBlind: false,
            isCancellingAllOrders: false,
            isCancellingOneOrder: false,
            isDeletingBlind: false,
            isChargingPetitionSPEIPayment: false,
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
            marketStepsItems: [
                { title: 'Elegir orden', icon: 'mdi-numeric-1' },
                { title: 'Revisar y pagar', icon: 'mdi-numeric-2' },
                { title: 'Confirmar compra', icon: 'mdi-numeric-3' },
            ],
            orderId: 0,
        }
    },
    methods:{

        methodOpenDialogCancelAllOrders(){
            this.modelDialogCancelAllOrders = true;
        },

        methodOpenDialogCancelOneOrder(itemOrder){
            this.modelCancelOneOrderItemId = itemOrder.id;
            this.modelDialogCancelOneOrder = true;
        },

        methodOpenDialogDeleteBlind(itemOrder){
            this.modelDeleteBlindItemId = itemOrder.id;
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

        methodCancelAllOrders(){
            this.isCancellingAllOrders = true;
            this.$store.dispatch('removeAllOrdersMarketcar').then(async ()=>{
                await this.$store.dispatch('getQuotedOrders');
                await this.$store.dispatch('getQuotingOrders');
                this.isCancellingAllOrders = false;
                this.methodCloseDialogCancelAllOrders();
            });
        },

        methodCancelOneOrder(){
            this.isCancellingOneOrder = true;
            if(this.modelCancelOneOrderItemId > -1){
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
                this.$store.dispatch('deleteBlindFromOrder', this.modelDeleteBlindItemId).then(async()=>{
                    await this.$store.dispatch('getQuotedOrder', this.localCurrentIDQuotingOrderStepThree);
                    await this.$store.dispatch('getQuotedOrders');
                    this.isDeletingBlind = false;
                    this.methodCloseDialogDeleteBlind();
                })
            }
        },

        localMethodStepThreeCheckAndBuy(localItem){
            this.$store.dispatch('getQuotedOrder', localItem.id).then(()=>{
                this.orderId = localItem.id;
                this.isOrdersAndQuotationsDialogActivated = false;
                this.localWindowStepModel = 2;
                this.localCurrentIDQuotingOrderStepThree = localItem.id;
                this.localPropItemQuotationOrderNumberID = localItem.order;
                this.localModelSubtotalAndTotal = localItem.total;

            });

        },

        localMethodIsOrdersAndQuotationsDialogActivatedOn(localItem){
            this.$store.dispatch('getQuotedOrder', localItem.id).then(()=>{
                this.orderId = localItem.id;
                this.isOrdersAndQuotationsDialogActivated = true;
                this.localCurrentIDQuotingOrderStepThree = localItem.id;
                this.localPropItemQuotationOrderNumberID = localItem.order;
                this.localToPropTotalPrice = localItem.total;
                this.localCurrentItemOfOrdersAndQuotationsDialogView = localItem;
            });
        },

        localMethodEditBlindStepThreeMarketcar(){
            if(this.localCurrentIDQuotingOrderStepThree > -1){
                this.localWindowStepModel = 1;
                this.localMethodIsOrdersAndQuotationsDialogActivatedOn(this.quotedOrders.find(item=>item.id == this.localCurrentIDQuotingOrderStepThree));
            }
        },

        localMethodBtnContinueStepThree(){
            this.localWindowStepModel = 3;
        },

        localMethodBtnPayStepFour(){
            if(this.localModelIsStepFourDataBankAccount == false){
                // this.localModelIsStepFourDataBankAccount = true;
                this.isChargingPetitionSPEIPayment = true;
                axios.get(`/api/spei-payment/${this.orderId}`).then((response)=>{
                    if(response.status == 200){
                        this.localModelIsStepFourDataBankAccount = true;
                        this.isChargingPetitionSPEIPayment = false;
                    }
                });
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
            quotedOrder: state => state.ordersModule.quotedOrder,

        }),
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
