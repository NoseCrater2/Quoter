<template>
    <div>
        <div v-if="selectedPaymentSchema == ''">
            <v-card flat>
                <v-card-title class="justify-center">
                    Esquema de pago con tarjetas de débito y credito
                </v-card-title>
                <v-row>
                    <v-col cols="6">
                        <v-card height="auto" outlined>
                            <v-row no-gutters justify="space-between" class="mt-4">
                              <v-col cols="6" xl="3" lg="3" md="3" sm="3">
                                <v-img
                                  class="my-4"
                                  width="auto"
                                  height="60"
                                  contain
                                  :src="`/img/payments/VISA.svg`"
                                ></v-img>
                              </v-col>
                              <v-col cols="6" xl="3" lg="3" md="3" sm="3">
                                <v-img
                                  class="my-4"
                                  width="auto"
                                  height="60"
                                  contain
                                  :src="`/img/payments/mastercard.svg`"
                                ></v-img>
                              </v-col>
                              <v-col cols="6" xl="3" lg="3" md="3" sm="3">
                                <v-img
                                  class="my-4"
                                  width="auto"
                                  height="60"
                                  contain
                                  :src="`/img/payments/american-express.svg`"
                                ></v-img>
                              </v-col>
                            </v-row>
                            <v-card-actions>
                                <v-btn
                                  color="#3ba2a9"
                                  text
                                  block
                                  @click="intentOpenPaymentSchemaDialog('debit')"
                                >
                                  CONTINUAR
                                </v-btn>
                            </v-card-actions>
                        </v-card>
                        <div class="text-center mt-2">Pago en una sola exhibición con estas tarjetas (débito y crédito)</div>
                        <div class="text-center mt-1" style="font-size: 0.75rem">
                            Se aplicará un 5% adicional al total de la orden seleccionando este esquema de pago
                        </div>
                    </v-col>
                    <v-col cols="6">
                        <v-card height="auto" outlined>
                            <v-row no-gutters justify="space-between" class="mt-4">
                              <v-col cols="6" xl="3" lg="3" md="3" sm="3">
                                <v-img
                                  class="my-4"
                                  width="auto"
                                  height="60"
                                  contain
                                  :src="`/img/payments/VISA.svg`"
                                ></v-img>
                              </v-col>
                              <v-col cols="6" xl="3" lg="3" md="3" sm="3">
                                <v-img
                                  class="my-4"
                                  width="auto"
                                  height="60"
                                  contain
                                  :src="`/img/payments/mastercard.svg`"
                                ></v-img>
                              </v-col>
                              <v-col cols="6" xl="3" lg="3" md="3" sm="3">
                                <v-img
                                  class="my-4"
                                  width="auto"
                                  height="60"
                                  contain
                                  :src="`/img/payments/american-express.svg`"
                                ></v-img>
                              </v-col>
                            </v-row>
                            <v-card-actions>
                                <v-btn
                                  color="#3ba2a9"
                                  text
                                  block
                                  @click="intentOpenPaymentSchemaDialog('credit')"
                                >
                                  CONTINUAR
                                </v-btn>
                            </v-card-actions>
                        </v-card>
                        <div class="text-center mt-2">Pago a 6 meses con estas tarjetas (crédito)</div>
                        <div class="text-center mt-1" style="font-size: 0.75rem">
                            Se aplicará un 15% adicional al total de la orden seleccionando este esquema de pago
                        </div>
                    </v-col>
                </v-row>
                <v-dialog max-width="350" v-model="paymentSchemaDialog" persistent>
                    <v-card>
                        <v-card-title class="justify-center text-center" style="word-break: break-word;">
                           ¿CONTINUAR CON ESTE ESQUEMA DE PAGO?
                        </v-card-title>
                        <v-card-actions>
                            <v-btn color="red" depressed @click="intentClosePaymentSchemaDialog" class="white--text">CANCELAR</v-btn>
                            <v-spacer></v-spacer>
                            <v-btn color="teal" depressed class="white--text" @click="selectPaymentSchema">CONTINUAR</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>
            </v-card>
        </div>
        <div v-else-if="selectedPaymentSchema != ''">
        <v-card v-if="!isOrderAlreadyPayed" class="ma-2" flat >
            <v-card-title v-if="!showNewCardForm" class="justify-center">
                Seleccione una tarjeta de {{selectedPaymentSchema == 'debit' ? 'débito o crédito' : selectedPaymentSchema ? 'crédito' : ''}}
            </v-card-title>
            <v-card-title v-else class="justify-center">
                Nueva tarjeta
            </v-card-title>
            <v-card-text v-if="!showNewCardForm">
                 <v-row v-if="loadingCards" justify="center">
                    <v-col cols="12" style="text-align: center">
                       <v-progress-circular
                          indeterminate
                          color="primary"
                        ></v-progress-circular>
                    </v-col>
                </v-row>
                <!-- <v-item-group v-model="selectedCard" @change="intentOpenPayDialog()"> -->
                    <v-row v-if="selectedCard == null" justify="center">
                        <v-col v-for="(card, index) in filteredCards" cols="12" xl="4" lg="6" md="6" sm="12" :key="index" class="mt-7">
                            <!-- <v-item :value="card.card" v-slot="{active, toggle }" >
                                <div class="d-flex">
                                    <div  class="rounded-l-xl d-flex justify-space-between align-center" @click="toggle" style="background: #F5F5F5; width: 94%" :class="active?'teal lighten-2':''">
                                        <v-list-item-content class="mx-3">
                                            <v-list-item-title>
                                                ***{{ card.card.lastFourDigits}} ({{ card.card.bank}})
                                            </v-list-item-title>
                                            <v-list-item-subtitle>
                                                {{ card.card.expMonth+ '/' + card.card.expYear}}
                                            </v-list-item-subtitle>
                                        </v-list-item-content>
                                        <v-list-item-action class="mx-3">
                                            <v-list-item-action-text>
                                                {{card.card.brand}}
                                            </v-list-item-action-text>
                                        </v-list-item-action>
                                    </div>
                                    <v-btn height="58" class="rounded-r-xl" color="red" @click="openDeleteCardDialog(card.card.token)" depressed tile>
                                        <v-icon color="white">mdi-close</v-icon>
                                    </v-btn>
                                </div>
                            </v-item> -->

                            <!-- img="https://raw.githubusercontent.com/muhammederdem/credit-card-form/master/src/assets/images/3.jpeg" -->
                                <v-card
                                    v-if="$vuetify.breakpoint.width < 396"
                                    height="140px"
                                    class="mx-auto"
                                    width="auto"
                                    outlined
                                    rounded="rounded-xl"
                                    :color="card.card.brand=='visa' ? '#1565C0' : card.card.brand=='mastercard' ? '#D32F2F' : 'grey darken-2'"
                                >
                                    <v-col cols="12">
                                        <v-row justify="space-between">
                                            <v-col cols="6">
                                                <v-img v-if="card.card.brand=='mastercard'" max-height="40" max-width="50" src="https://raw.githubusercontent.com/muhammederdem/credit-card-form/master/src/assets/images/mastercard.png"></v-img>
                                                <v-img v-else-if="card.card.brand=='visa'" max-height="40" max-width="70" src="https://raw.githubusercontent.com/muhammederdem/credit-card-form/master/src/assets/images/visa.png"></v-img>
                                                <v-img v-else-if="card.card.brand=='amex'" max-height="40" max-width="70" src="https://raw.githubusercontent.com/muhammederdem/credit-card-form/master/src/assets/images/amex.png"></v-img>
                                            </v-col>
                                            <v-col cols="6">
                                                <div style="color: white" class="text-end">{{card.card.type == 'credit' ? 'Crédito' : 'Débito'}}</div>
                                            </v-col>
                                        </v-row>
                                    </v-col>
                                    <v-col cols="12">
                                        <div class="white--text text-center font-weight-bold" style="font-size: 0.85rem">{{card.card.brand=='amex' ? card.card.cardPrefix.slice(0, 4) +' ****** *'+ card.card.lastFourDigits : card.card.cardPrefix.slice(0, 4) +' **** **** '+ card.card.lastFourDigits}} </div>
                                    </v-col>
                                    <v-col cols="12">
                                        <v-row justify="space-between" class="mx-2 mt-1">
                                            <v-btn
                                                class="white--text"
                                                color="red"
                                                fab
                                                dark
                                                elevation="0"
                                                x-small
                                                @click="openDeleteCardDialog(card.card.token)"
                                              >
                                                <v-icon size="13">mdi-delete</v-icon>
                                            </v-btn>
                                            <v-btn
                                                class="white--text"
                                                color="teal"
                                                fab
                                                dark
                                                elevation="0"
                                                x-small
                                                @click="intentOpenPayDialog(card.card)"
                                              >
                                                <v-icon size="13">mdi-check</v-icon>
                                            </v-btn>
                                        </v-row>
                                    </v-col>
                                </v-card>
                                <v-card
                                  v-else-if="$vuetify.breakpoint.width >= 396"
                                  class="mx-auto"
                                  min-width="275"
                                  max-width="361"
                                  :color="card.card.brand=='visa' ? '#1565C0' : card.card.brand=='mastercard' ? '#D32F2F' : 'grey darken-2'"
                                  height="240px"
                                  outlined
                                  rounded="rounded-xl"
                                >

                                  <v-col cols="12">
                                    <v-row class="pa-5" justify="space-between">
                                      <v-col cols="6">
                                        <v-row justify="start">
                                        <v-img height="40" max-width="50" src="https://raw.githubusercontent.com/muhammederdem/credit-card-form/master/src/assets/images/chip.png"></v-img>
                                          </v-row>
                                       </v-col>
                                        <v-col cols="6">
                                          <v-row justify="end">
                                        <v-img v-if="card.card.brand=='mastercard'" max-height="40" max-width="50" src="https://raw.githubusercontent.com/muhammederdem/credit-card-form/master/src/assets/images/mastercard.png"></v-img>
                                        <v-img v-else-if="card.card.brand=='visa'" max-height="40" max-width="70" src="https://raw.githubusercontent.com/muhammederdem/credit-card-form/master/src/assets/images/visa.png"></v-img>
                                        <v-img v-else-if="card.card.brand=='amex'" max-height="40" max-width="70" src="https://raw.githubusercontent.com/muhammederdem/credit-card-form/master/src/assets/images/amex.png"></v-img>
                                            </v-row>
                                            <v-row justify="end">
                                                <div style="color: white">{{card.card.type == 'credit' ? 'Crédito' : 'Débito'}}</div>
                                            </v-row>
                                       </v-col>
                                    </v-row>
                                  </v-col>

                                 <v-col cols="12">
                                   <v-row justify="center">
                                    <v-card-title class="white--text text-center font-weight-bold" style="font-size: 1.5rem">{{card.card.brand=='amex' ? card.card.cardPrefix.slice(0, 4) +' ****** *'+ card.card.lastFourDigits : card.card.cardPrefix.slice(0, 4) +' **** **** '+ card.card.lastFourDigits}} </v-card-title>
                                     </v-row>
                                  </v-col>
                                   <v-col cols="12" class="mt-n5">
                                     <v-row>
                                        <v-col cols="8">

                                            <v-card-title class="white--text font-weight-bold" style="font-size: 0.73rem">Entidad</v-card-title>
                                            <v-card-subtitle class="white--text mt-n6" style="font-size: 0.73rem">{{card.card.bank}}</v-card-subtitle>


                                        </v-col>
                                        <v-col cols="4">

                                            <v-card-title class="white--text font-weight-bold" style="font-size: 0.73rem">Expira</v-card-title>
                                            <v-card-subtitle class="white--text mt-n6" style="font-size: 0.73rem">{{ card.card.expMonth+ '/' + card.card.expYear}}</v-card-subtitle>

                                        </v-col>
                                     </v-row>
                                   </v-col>
                                   <!-- :class="$vuetify.breakpoint.width < 375 ? 'mt-n16' : 'mt-n9'" -->
                                   <v-card-actions class="mt-n9">
                                       <v-btn
                                            class="white--text"
                                            color="red"
                                            fab
                                            small
                                            dark
                                            elevation="0"
                                            @click="openDeleteCardDialog(card.card.token)"
                                          >
                                            <v-icon>mdi-delete</v-icon>
                                        </v-btn>
                                        <v-spacer></v-spacer>
                                        <v-btn
                                            class="white--text"
                                            color="teal"
                                            fab
                                            small
                                            dark
                                            elevation="0"
                                            @click="intentOpenPayDialog(card.card)"
                                          >
                                            <v-icon>mdi-check</v-icon>
                                        </v-btn>
                                   </v-card-actions>

                                </v-card>

                        </v-col>
                        <v-col v-if="!loadingCards" cols="12" class="mt-9">
                        <v-card-actions>
                            <!-- <v-item> -->
                                <!-- <div class="d-flex justify-space-between align-center rounded-xl text-center" style="background: #F5F5F5; height: 50px" @click="showNewCardForm = true">
                                    <span class="mx-2">Agregar nueva tarjeta</span>
                                    <v-icon class="mx-5">mdi-plus</v-icon>
                                </div> -->
                                <v-row align="center" justify="center">
                                    <v-col cols="12" xl="6" lg="6" md="6" sm="12" order="2" order-xl="1" order-lg="1" order-md="1" order-sm="2" :class="$vuetify.breakpoint.mdAndUp ? 'text-start': 'text-center'">
                                        <v-btn
                                          color="red"
                                          dark
                                          @click="returnToCards()"
                                        >
                                          Regresar
                                        </v-btn>
                                    </v-col>
                                    <v-col cols="12" xl="6" lg="6" md="6" sm="12" order="1" order-xl="2" order-lg="2" order-md="2" order-sm="1" :class="$vuetify.breakpoint.mdAndUp ? 'text-end': 'text-center'">
                                        <v-btn
                                          color="teal"
                                          dark
                                          @click="openShowNewCardFormDialog()"
                                        >
                                          Agregar nueva tarjeta
                                            <v-icon
                                              right
                                              dark
                                            >
                                              mdi-plus
                                            </v-icon>
                                        </v-btn>
                                    </v-col>
                                </v-row>
                            <!-- </v-item> -->
                        </v-card-actions>
                        </v-col>
                    </v-row>
                    <v-row v-if="selectedCard != null" justify="center">
                        <v-col cols="12">
                            <v-col cols="12">
                                <v-card
                                    v-if="$vuetify.breakpoint.width < 396"
                                    height="140px"
                                    class="mx-auto"
                                    width="auto"
                                    outlined
                                    rounded="rounded-xl"
                                    :color="selectedCard.brand=='visa' ? '#1565C0' : selectedCard.brand=='mastercard' ? '#D32F2F' : 'grey darken-2'"
                                >
                                    <v-col cols="12">
                                        <v-row justify="space-between">
                                            <v-col cols="6">
                                                <v-img v-if="selectedCard.brand=='mastercard'" max-height="40" max-width="50" src="https://raw.githubusercontent.com/muhammederdem/credit-card-form/master/src/assets/images/mastercard.png"></v-img>
                                                <v-img v-else-if="selectedCard.brand=='visa'" max-height="40" max-width="70" src="https://raw.githubusercontent.com/muhammederdem/credit-card-form/master/src/assets/images/visa.png"></v-img>
                                                <v-img v-else-if="selectedCard.brand=='amex'" max-height="40" max-width="70" src="https://raw.githubusercontent.com/muhammederdem/credit-card-form/master/src/assets/images/amex.png"></v-img>
                                            </v-col>
                                            <v-col cols="6">
                                                <div style="color: white" class="text-end">{{selectedCard.type == 'credit' ? 'Crédito' : 'Débito'}}</div>
                                            </v-col>
                                        </v-row>
                                    </v-col>
                                    <v-col cols="12">
                                        <div class="white--text text-center font-weight-bold" style="font-size: 0.85rem">{{selectedCard.brand=='amex' ? selectedCard.cardPrefix.slice(0, 4) +' ****** *'+ selectedCard.lastFourDigits : selectedCard.cardPrefix.slice(0, 4) +' **** **** '+ selectedCard.lastFourDigits}} </div>
                                    </v-col>
                                    <v-col cols="12">
                                        <v-row justify="space-between" class="mx-2 mt-1">
                                            <v-btn
                                                class="white--text"
                                                color="red"
                                                fab
                                                dark
                                                elevation="0"
                                                x-small
                                                @click="openDeleteCardDialog(selectedCard.token)"
                                              >
                                                <v-icon size="13">mdi-delete</v-icon>
                                            </v-btn>
                                            <v-btn
                                                class="white--text"
                                                color="teal"
                                                fab
                                                dark
                                                elevation="0"
                                                x-small
                                                @click="intentOpenPayDialog(selectedCard)"
                                              >
                                                <v-icon size="13">mdi-check</v-icon>
                                            </v-btn>
                                        </v-row>
                                    </v-col>
                                </v-card>
                                <v-card
                                  v-else-if="$vuetify.breakpoint.width >= 396"
                                  class="mx-auto"
                                  min-width="275"
                                  max-width="361"
                                  :color="selectedCard.brand=='visa' ? '#1565C0' : selectedCard.brand=='mastercard' ? '#D32F2F' : 'grey darken-2'"
                                  height="240px"
                                  outlined
                                  rounded="rounded-xl"
                                >

                                  <v-col cols="12">
                                    <v-row class="pa-5" justify="space-between">
                                      <v-col cols="6">
                                        <v-row justify="start">
                                        <v-img height="40" max-width="50" src="https://raw.githubusercontent.com/muhammederdem/credit-card-form/master/src/assets/images/chip.png"></v-img>
                                          </v-row>
                                       </v-col>
                                        <v-col cols="6">
                                          <v-row justify="end">
                                        <v-img v-if="selectedCard.brand=='mastercard'" max-height="40" max-width="50" src="https://raw.githubusercontent.com/muhammederdem/credit-card-form/master/src/assets/images/mastercard.png"></v-img>
                                        <v-img v-else-if="selectedCard.brand=='visa'" max-height="40" max-width="70" src="https://raw.githubusercontent.com/muhammederdem/credit-card-form/master/src/assets/images/visa.png"></v-img>
                                        <v-img v-else-if="selectedCard.brand=='amex'" max-height="40" max-width="70" src="https://raw.githubusercontent.com/muhammederdem/credit-card-form/master/src/assets/images/amex.png"></v-img>
                                            </v-row>
                                            <v-row justify="end">
                                                <div style="color: white">{{selectedCard.type == 'credit' ? 'Crédito' : 'Débito'}}</div>
                                            </v-row>
                                       </v-col>
                                    </v-row>
                                  </v-col>

                                 <v-col cols="12">
                                   <v-row justify="center">
                                    <v-card-title class="white--text text-center font-weight-bold" style="font-size: 1.5rem">{{selectedCard.brand=='amex' ? selectedCard.cardPrefix.slice(0, 4) +' ****** *'+ selectedCard.lastFourDigits : selectedCard.cardPrefix.slice(0, 4) +' **** **** '+ selectedCard.lastFourDigits}} </v-card-title>
                                     </v-row>
                                  </v-col>
                                   <v-col cols="12" class="mt-n5">
                                     <v-row>
                                        <v-col cols="8">

                                            <v-card-title class="white--text font-weight-bold" style="font-size: 0.73rem">Entidad</v-card-title>
                                            <v-card-subtitle class="white--text mt-n6" style="font-size: 0.73rem">{{selectedCard.bank}}</v-card-subtitle>


                                        </v-col>
                                        <v-col cols="4">

                                            <v-card-title class="white--text font-weight-bold" style="font-size: 0.73rem">Expira</v-card-title>
                                            <v-card-subtitle class="white--text mt-n6" style="font-size: 0.73rem">{{ selectedCard.expMonth+ '/' + selectedCard.expYear}}</v-card-subtitle>

                                        </v-col>
                                     </v-row>
                                   </v-col>

                                </v-card>
                            </v-col>
                            <v-col cols="12" xl="4" lg="4" md="4" sm="12" class="mx-auto">
                                <div class="mx-auto">
                                <v-text-field
                                :type="showCVV == false ? 'password': 'text'"
                                dense
                                :disabled="loadingPayButton"
                                outlined
                                class="rounded-xl"
                                placeholder="CVV"
                                maxlength="4"
                                v-model="modelCVVOnPay"
                                append-icon="mdi-eye"
                                @click:append="showCVV = !showCVV"
                                ></v-text-field>
                                </div>
                            </v-col>
                            <v-col cols="12" class="mt-n5 d-flex justify-center">
                                <v-btn color="red" :disabled="loadingPayButton" depressed class="white--text mr-2" @click="cancelPay()">REGRESAR</v-btn>
                                <v-btn color="teal" :disabled="loadingPayButton" :loading="loadingPayButton" depressed class="white--text" @click="confirmPayWithCVV">PAGAR</v-btn>
                            </v-col>
                        </v-col>
                    </v-row>
                <!-- </v-item-group> -->
            </v-card-text>
            <v-card-text  v-if="showNewCardForm">
                                <v-card
                                    v-if="$vuetify.breakpoint.width < 396"
                                    height="140px"
                                    class="mx-auto"
                                    width="auto"
                                    outlined
                                    rounded="rounded-xl"
                                    color="grey darken-2"
                                >
                                    <v-col cols="12">
                                        <v-row justify="space-between">
                                            <v-col cols="6">
                                                <v-img height="30" max-width="40" src="https://raw.githubusercontent.com/muhammederdem/credit-card-form/master/src/assets/images/chip.png"></v-img>
                                            </v-col>
                                            <v-col cols="6">

                                            </v-col>
                                        </v-row>
                                    </v-col>
                                    <v-col cols="12">
                                        <div class="white--text text-center font-weight-bold" style="font-size: 0.85rem">{{cardInformation.cardNumber}} </div>
                                    </v-col>
                                </v-card>

                                <v-card
                                  v-else-if="$vuetify.breakpoint.width >= 396"
                                  class="mx-auto"
                                  min-width="275"
                                  max-width="361"
                                  color="grey darken-2"
                                  height="240px"
                                  outlined
                                  rounded="rounded-xl"
                                >

                                  <v-col cols="12">
                                    <v-row class="pa-5" justify="space-between">
                                      <v-col cols="6">
                                        <v-row justify="start">
                                        <v-img height="40" max-width="50" src="https://raw.githubusercontent.com/muhammederdem/credit-card-form/master/src/assets/images/chip.png"></v-img>
                                          </v-row>
                                       </v-col>
                                        <v-col cols="6">
                                          <v-row justify="end">
                                        <!-- <v-img height="40" max-width="50" src="https://raw.githubusercontent.com/muhammederdem/credit-card-form/master/src/assets/images/mastercard.png"></v-img> -->
                                            </v-row>
                                       </v-col>
                                    </v-row>
                                  </v-col>

                                 <v-col cols="12">
                                   <v-row justify="center">
                                    <v-card-title class="white--text text-center font-weight-bold" style="font-size: 1.5rem">{{cardInformation.cardNumber}}</v-card-title>
                                     </v-row>
                                  </v-col>
                                   <v-col cols="12" class="mt-n1">
                                     <v-row>
                                        <v-col cols="8">

                                            <!-- <v-card-title class="white--text font-weight-bold" style="font-size: 0.73rem">Entidad</v-card-title> -->
                                            <!-- <v-card-subtitle class="white--text mt-n6" style="font-size: 0.73rem">{{card.card.bank}}</v-card-subtitle> -->


                                        </v-col>
                                        <v-col cols="4">

                                            <v-card-title class="white--text font-weight-bold" style="font-size: 0.73rem">Expira</v-card-title>
                                            <v-card-subtitle class="white--text mt-n6" style="font-size: 0.73rem">{{ ((cardInformation.expMonth != null || cardInformation.expMonth != '') ? cardInformation.expMonth+ '/' : '') + ((cardInformation.expYear != null || cardInformation.expYear != '') ? cardInformation.expYear : '')}}</v-card-subtitle>

                                        </v-col>
                                     </v-row>
                                   </v-col>

                                </v-card>
                <v-row justify="center" class="ma-2">
                    <v-col cols="12">
                        <v-col cols="12" xl="4" lg="4" md="4" sm="4" class="mx-auto">
                        <v-text-field
                        dense
                        outlined
                        class="rounded-xl"
                        placeholder="Numero de tarjeta"
                        maxlength="19"
                        v-model="cardInformation.cardNumber"
                        :error="!validateCard"
                        ></v-text-field>
                        </v-col>
                    </v-col>
                    <v-col cols="12" class="mt-n4 mx-auto">
                        <v-row justify="center">


                    <v-col cols="12" xl="3" lg="3" md="3" sm="3" class="d-flex" >
                        <v-text-field
                        dense
                        outlined
                        class="rounded-xl"
                        v-model="cardInformation.expMonth"
                        placeholder="Mes"
                        maxlength="2"
                        :error="!validateDate"
                        ></v-text-field>
                    </v-col>
                    <v-col cols="12" xl="3" lg="3" md="3" sm="3" class="d-flex" >
                        <v-text-field
                        dense
                        outlined
                        class="rounded-xl"
                        v-model="cardInformation.expYear"
                        placeholder="Año"
                        maxlength="4"
                        :error="!validateDate"
                        ></v-text-field>
                    </v-col>
                    <v-col cols="12" xl="3" lg="3" md="3" sm="3" class="d-flex" >
                        <v-text-field
                        dense
                        outlined
                        class="rounded-xl"
                        v-model="cardInformation.cvv2"
                        style="width: 70px !important"
                        placeholder="CVV"
                        maxlength="4"
                        :error="!validateCVV"
                        ></v-text-field>
                    </v-col>
                    </v-row>
                    </v-col>
                </v-row>
                <v-row justify="center" class="mx-auto">
                    <v-col cols="7" class="text-center">
                        <v-btn :class="$vuetify.breakpoint.smAnUp ? 'rounded-l-xl' : ''" class="white--text" color="red" :disabled="isSavingCard" @click="closeShowNewCardFormDialog" >
                            CANCELAR
                            <v-icon right>mdi-close</v-icon>
                        </v-btn>
                         <v-btn :class="$vuetify.breakpoint.smAnUp ? 'rounded-l-xl' : ''" class="white--text"  :loading="isSavingCard" :disabled="isSavingCard" @click="generalValidate" color="#4CAF50"  >
                            GUARDAR
                            <v-icon right>mdi-check</v-icon>
                        </v-btn>
                    </v-col>
                </v-row>
            </v-card-text>
            <v-snackbar
              v-model="displayErrors"
              :multi-line="true"
            >
            {{errors}}
              <template v-slot:action="{ attrs }">
                <v-btn
                  color="red"
                  icon
                  v-bind="attrs"
                  @click="displayErrors = false"
                >
                 <v-icon>mdi-close</v-icon>
                </v-btn>
              </template>
            </v-snackbar>
            <v-dialog max-width="350" v-model="deleteCardDialog" persistent>
                <v-card>
                    <v-card-title class="justify-center">
                        ¿ELIMINAR ESTA TARJETA?
                    </v-card-title>
                    <v-card-actions>
                        <v-btn color="teal" depressed outlined @click="deleteCardDialog  = false" class="white--text">CANCELAR</v-btn>
                        <v-spacer></v-spacer>
                        <v-btn color="red" :disabled="isDeletingCard" :loading="isDeletingCard" depressed class="white--text" @click="deleteCard">ELIMINAR</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
            <v-dialog max-width="350" v-model="payOrderDialog" persistent>
                <v-card>
                    <v-card-title class="justify-center text-center" style="word-break: break-word;">
                       ¿CONTINUAR EL PAGO CON ESTA TARJETA?
                    </v-card-title>
                    <v-card-actions>
                        <v-btn color="red" depressed @click="intentClosePayDialog" class="white--text">CANCELAR</v-btn>
                        <v-spacer></v-spacer>
                        <v-btn color="teal" depressed class="white--text" @click="pay">CONTINUAR</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-card>

        <v-card v-else-if="isOrderAlreadyPayed" class="ma-2" flat >
            <v-card-title class="justify-center">
                ORDEN PAGADA
            </v-card-title>
            <v-card-text class="justify-center text-center">
                <v-icon size="100" color="teal">
                    mdi-check-circle
                </v-icon>
            </v-card-text>
            <v-card-actions>
                <v-row justify="center" justify-xl="space-between" justify-lg="space-between" justify-md="space-between" justify-sm="center">
                    <v-col cols="12" xl="6" lg="6" md="6" sm="12" :class="$vuetify.breakpoint.mdAndUp ? 'text-start': 'text-center'">
                        <v-btn color="teal" depressed @click="goToOrders" class="white--text">IR A MIS ORDENES</v-btn>
                    </v-col>
                    <v-col cols="12" xl="6" lg="6" md="6" sm="12" :class="$vuetify.breakpoint.mdAndUp ? 'text-end': 'text-center'">
                        <v-btn color="teal" depressed class="white--text" @click="stayInMarketcar">SEGUIR COMPRANDO</v-btn>
                    </v-col>
                </v-row>
            </v-card-actions>
        </v-card>
        </div>
    </div>
</template>

<script>
import NetPay from '../../../utils/netpay.min.js'
import axios from 'axios'
import { mapState } from 'vuex'
export default {
    data(){
        return {
            showCVV: false,
            payOrderDialog: false,
            loadingPayButton: false,
            deleteCardDialog: false,
            isDeletingCard: false,
            isSavingCard: false,
            loadingCards: false,
            showNewCardForm: localStorage.getItem('quotedOrder') !== null ? JSON.parse(localStorage.getItem('quotedOrder')).card.isNewCard : false,
            selectedCard: localStorage.getItem('quotedOrder') !== null ? JSON.parse(localStorage.getItem('quotedOrder')).card.currentCard : null,
            preSelectedCard: localStorage.getItem('quotedOrder') !== null ? JSON.parse(localStorage.getItem('quotedOrder')).card.currentCard : null,
            errors: null,
            displayErrors: false,
            cardInformation: {
                cardNumber: null,
                expMonth: null,
                expYear: null,
                cvv2: null,
            },
            selectedToken: null,
            cards: [],
            modelCVVOnPay: '',
            isOrderAlreadyPayed: false,
            preselectedPaymentSchema: '',
            paymentSchemaDialog: false
        }
    },

    created(){
        if(this.$route.name == 'StepFourNetpay'){
            if(Object.keys(this.quotedOrder).length == 0){
                if(localStorage.getItem('quotedOrder') !== null){
                    let localStorageObject = JSON.parse(localStorage.getItem('quotedOrder'));
                    Object.assign(this.quotedOrder, localStorageObject.order)
                }
                else if(localStorage.getItem('quotedOrder') === null){
                    this.$router.push({name: 'Marketcar'});
                }
            }
        }

        if(this.user.netpayClientId){
            this.chargeCards()
        }


        // NetPay.setApiKey(process.env.MIX_NETPAY_PUBLIC_KEY_PROD); //PRODUCCION

        NetPay.setApiKey(process.env.MIX_NETPAY_PUBLIC_KEY_SBOX);//SANDBOX
        NetPay.setSandboxMode(true);//SANDBOX

        //DEBIT CARD
        // let cardInformation = {
        //     cardNumber: "5499490519982367",
        //     expMonth: "04",
        //     expYear: "25",
        //     cvv2: "999",
        // };

        //CREDIT CARD
        // let cardInformation = {
        //     cardNumber: "4918717162313532",
        //     expMonth: "04",
        //     expYear: "25",
        //     cvv2: "999",
        // };

    },

    mounted(){

    },

    methods: {
        intentOpenPaymentSchemaDialog(value){
            this.preselectedPaymentSchema = value;
            this.paymentSchemaDialog = true;
        },
        intentClosePaymentSchemaDialog(){
            this.preselectedPaymentSchema = '';
            this.paymentSchemaDialog = false;
        },
        selectPaymentSchema(){
           this.$store.commit('setSelectedPaymentSchema', this.preselectedPaymentSchema);
           if(localStorage.getItem('quotedOrder') != null){
               let localStorageObject = JSON.parse(localStorage.getItem('quotedOrder'));
               localStorageObject.card.selectedPaymentSchema = this.selectedPaymentSchema;
               localStorage.setItem('quotedOrder', JSON.stringify(localStorageObject));
           }
           this.intentClosePaymentSchemaDialog();
        },
        intentOpenPayDialog(card){
            this.preSelectedCard = card;
            if(this.preSelectedCard){
                this.payOrderDialog = true
            }
        },

        intentClosePayDialog(){
            this.preSelectedCard = null;
            this.payOrderDialog = false;
        },

        openShowNewCardFormDialog(){
            this.showNewCardForm = true;
            let localStorageObject = JSON.parse(localStorage.getItem('quotedOrder'))
            localStorageObject.card.isNewCard = true;
            localStorage.setItem('quotedOrder', JSON.stringify(localStorageObject))
        },

        closeShowNewCardFormDialog(){
            let resetCard = {
                cardNumber: null,
                expMonth: null,
                expYear: null,
                cvv2: null,
            }
            Object.assign(this.cardInformation, resetCard);
            this.showNewCardForm = false;
            let localStorageObject = JSON.parse(localStorage.getItem('quotedOrder'))
            localStorageObject.card.isNewCard = false;
            localStorage.setItem('quotedOrder', JSON.stringify(localStorageObject))
        },

        chargeCards(){
            this.loadingCards = true
            axios.get('/api/netpay-get-client/'+this.user.id).then(response => {
                this.loadingCards = false
                this.cards = response.data.paymentSources
            })
        },

        success(e) {
            let cardObject = JSON.parse(e.message.data)
            if(this.user.netpayClientId){
                axios.post('/api/netpay-add-card/'+this.user.id,
                    {token: cardObject.token, cvv2: this.cardInformation.cvv2}
                ).then((response) => {
                    if(response.status == 200){
                        this.showNewCardForm = false
                         this.chargeCards()
                    }else{
                        this.errors = 'Ocurrió un error, intenteló de nuevo'
                        this.displayErrors = true
                    }
                    this.isSavingCard = false;

                })
            }else{
                axios.post('/api/netpay-save/'+this.user.id, {token: cardObject.token}).then((response) => {
                     if(response.status == 200){
                         this.showNewCardForm = false
                         this.chargeCards()
                     }else{
                         this.errors = 'Ocurrió un error, intenteló de nuevo'
                        this.displayErrors = true
                     }

                })
            }
            let localStorageObject = JSON.parse(localStorage.getItem('quotedOrder'));
            localStorageObject.card.isNewCard = false;
            localStorage.setItem('quotedOrder', JSON.stringify(localStorageObject));
        },

        error(e) {
            this.isSavingCard = false;
            this.errors = e
            this.displayErrors = true
            let localStorageObject = JSON.parse(localStorage.getItem('quotedOrder'));
            localStorageObject.card.isNewCard = false;
            localStorage.setItem('quotedOrder', JSON.stringify(localStorageObject));
        },

        generalValidate(){
            this.isSavingCard = true;
            NetPay.token.create(this.cardInformation, this.success, this.error);
        },

        openDeleteCardDialog(token){
            this.selectedToken = token
            this.deleteCardDialog = true
        },

        deleteCard(){
            this.isDeletingCard = true;
            axios.post('/api/netpay-delete-card/'+this.user.id, {token: this.selectedToken}).then((response)=> {
                if(response.status == 200){
                    this.chargeCards()
                }else{
                    this.errors = 'Ocurrió un error, intente de nuevo'
                    this.displayErrors = true
                }
                this.isDeletingCard = false;
                this.deleteCardDialog = false
            })
        },

        pay(){
            this.selectedCard = this.preSelectedCard;
            let localStorageObject = JSON.parse(localStorage.getItem('quotedOrder'))
            localStorageObject.card.currentCard = this.selectedCard;
            localStorageObject.card.isCurrentCard = true;
            localStorage.setItem('quotedOrder', JSON.stringify(localStorageObject))
            this.intentClosePayDialog();
        },

        cancelPay(){
            this.selectedCard = null;
            this.preSelectedCard = null;
            let localStorageObject = JSON.parse(localStorage.getItem('quotedOrder'))
            localStorageObject.card.currentCard = this.selectedCard;
            localStorageObject.card.isCurrentCard = false;
            localStorage.setItem('quotedOrder', JSON.stringify(localStorageObject))
        },

        confirmPayWithCVV(){
            let localStorageObject = JSON.parse(localStorage.getItem('quotedOrder'));
            this.loadingPayButton = true
            let totalOrderPrice = localStorageObject.order.total;
            if(this.selectedPaymentSchema == 'debit'){
                totalOrderPrice = localStorageObject.order.total * 1.05;
            }
            else if(this.selectedPaymentSchema == 'credit'){
                totalOrderPrice = localStorageObject.order.total * 1.15;
            }
            totalOrderPrice = Math.round(totalOrderPrice * 10) / 10;
            axios.post('/api/netpay-intent-pay/'+this.user.id, {cvv: this.modelCVVOnPay, token: this.selectedCard.token, amount: ''+totalOrderPrice, order: localStorageObject.order.order, idOrder: localStorageObject.order.id, cardType: this.selectedCard.type, selectedPaymentSchema: this.selectedPaymentSchema }).then(async(response) => {
                if(response.status == 200){
                    localStorage.removeItem('quotedOrder');
                    if(this.user.role == 'Superadministrador' || this.user.role == 'Administrador'){
                        await this.$store.dispatch('getAdminQuotedOrders')
                        await this.$store.dispatch('getAdminQuotingOrders')
                    }
                    else{
                        await this.$store.dispatch('getQuotedOrders')
                        await this.$store.dispatch('getQuotingOrders')
                    }
                    this.loadingPayButton = false
                    this.isOrderAlreadyPayed = true;
                    this.selectedCard = null;
                    this.preSelectedCard = null;
                    this.modelCVVOnPay = '';
                    if(this.computedNoPaidOrders == 0){
                        this.stayInMarketcar();
                    }
                }else{
                    this.errors = 'Ocurrió un error, intente de nuevo'
                    this.displayErrors = true
                    this.loadingPayButton = false
                }

            })
        },
        goToOrders(){
            this.$store.commit('setSelectedPaymentSchema', '');
            if(this.user.role == 'Superadministrador' || this.user.role == 'Administrador'){
                this.$router.push({name: 'Orders', params: {option: 'ordenes-admin'}});
            }
            else{
                this.$router.push({name: 'Orders', params: {option: 'ordenes'}});
            }
        },
        stayInMarketcar(){
            this.$store.commit('setSelectedPaymentSchema', '');
            this.$router.push({name:'Marketcar'});
        },
        returnToCards(){
            this.$store.commit('setSelectedPaymentSchema', '');
            if(localStorage.getItem('quotedOrder') != null){
               let localStorageObject = JSON.parse(localStorage.getItem('quotedOrder'));
               localStorageObject.card.selectedPaymentSchema = this.selectedPaymentSchema;
               localStorage.setItem('quotedOrder', JSON.stringify(localStorageObject));
            }

        }
    },

    computed: {
        ...mapState({
            user: state => state.user,
            quotedOrder: state => state.ordersModule.quotedOrder,
            quotedOrders: state => state.ordersModule.quotedOrders,
            selectedPaymentSchema: state => state.ordersModule.selectedPaymentSchema
        }),
        computedNoPaidOrders(){
            return this.quotedOrders.filter(itemOrder=> itemOrder.state == 'No Pagada');
        },
        validateCard(){
            if(this.cardInformation.cardNumber){
                return NetPay.card.validateNumber(this.cardInformation.cardNumber) && NetPay.card.validateNumberLength(this.cardInformation.cardNumber)
            }
            return true
        },

        validateDate(){
            if(this.cardInformation.expMonth && this.cardInformation.expYear){
                return NetPay.card.validateExpiry(this.cardInformation.expMonth, this.cardInformation.expYear);
            }
            return true
        },

        validateCVV(){
            if(this.cardInformation.cardNumber && this.cardInformation.cvv2){
                return NetPay.card.validateCVV(this.cardInformation.cvv2, this.cardInformation.cardNumber);
            }
            return true
        },
        filteredCards(){
            if(this.cards.length > 0){
                if(this.selectedPaymentSchema == 'debit'){
                    return this.cards;
                }
                else if(this.selectedPaymentSchema == 'credit'){
                    let creditCards = this.cards.filter((card)=>card.card.type == 'credit');
                    return creditCards;
                }
            }
            return this.cards;
        }
    }

}
</script>

<style>

</style>
