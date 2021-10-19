<template>
    <div>
    <v-card v-if="!isOrderAlreadyPayed" class="ma-2" flat >
        <v-card-title v-if="!showNewCardForm" class="justify-center">
            Seleccionar tarjeta
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
                    <v-col v-for="(card, index) in cards" cols="12" xl="4" lg="6" md="6" sm="12" :key="index">
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
                                    <v-img v-if="card.card.brand=='mastercard'" height="40" max-width="50" src="https://raw.githubusercontent.com/muhammederdem/credit-card-form/master/src/assets/images/mastercard.png"></v-img>
                                    <v-img v-else-if="card.card.brand=='visa'" height="40" max-width="50" src="https://raw.githubusercontent.com/muhammederdem/credit-card-form/master/src/assets/images/visa.png"></v-img>
                                    <v-img v-else-if="card.card.brand=='amex'" height="40" max-width="50" src="https://raw.githubusercontent.com/muhammederdem/credit-card-form/master/src/assets/images/amex.png"></v-img>
                                        </v-row>
                                   </v-col>
                                </v-row>
                              </v-col>

                             <v-col cols="12">
                               <v-row justify="center">
                                <v-card-title class="white--text text-center font-weight-bold" style="font-size: 1.5rem">{{card.card.brand=='amex' ? card.card.cardPrefix.slice(0, 4) +' ****** *'+ card.card.lastFourDigits : card.card.cardPrefix.slice(0, 4) +' **** **** '+ card.card.lastFourDigits}} </v-card-title>
                                 </v-row>
                              </v-col>
                               <v-col cols="12" class="mt-n1">
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
                               <v-card-actions class="mt-n8">
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
                    <v-col v-if="!loadingCards" cols="12" class="mt-3">
                        <!-- <v-item> -->
                            <!-- <div class="d-flex justify-space-between align-center rounded-xl text-center" style="background: #F5F5F5; height: 50px" @click="showNewCardForm = true">
                                <span class="mx-2">Agregar nueva tarjeta</span>
                                <v-icon class="mx-5">mdi-plus</v-icon>
                            </div> -->
                            <div class="d-flex justify-center align-center">
                                <v-btn
                                  color="teal"
                                  dark
                                  @click="openShowNewCardFormDialog()"
                                >
                                  Agregar una nueva tarjeta
                                    <v-icon
                                      right
                                      dark
                                    >
                                      mdi-plus
                                    </v-icon>
                                </v-btn>
                            </div>
                        <!-- </v-item> -->
                    </v-col>
                </v-row>
                <v-row v-if="selectedCard != null" justify="center">
                    <v-col cols="12">
                        <v-col cols="12">
                            <v-card
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
                                    <v-img v-if="selectedCard.brand=='mastercard'" height="40" max-width="50" src="https://raw.githubusercontent.com/muhammederdem/credit-card-form/master/src/assets/images/mastercard.png"></v-img>
                                    <v-img v-else-if="selectedCard.brand=='visa'" height="40" max-width="50" src="https://raw.githubusercontent.com/muhammederdem/credit-card-form/master/src/assets/images/visa.png"></v-img>
                                    <v-img v-else-if="selectedCard.brand=='amex'" height="40" max-width="50" src="https://raw.githubusercontent.com/muhammederdem/credit-card-form/master/src/assets/images/amex.png"></v-img>
                                        </v-row>
                                   </v-col>
                                </v-row>
                              </v-col>

                             <v-col cols="12">
                               <v-row justify="center">
                                <v-card-title class="white--text text-center font-weight-bold" style="font-size: 1.5rem">{{selectedCard.brand=='amex' ? selectedCard.cardPrefix.slice(0, 4) +' ****** *'+ selectedCard.lastFourDigits : selectedCard.cardPrefix.slice(0, 4) +' **** **** '+ selectedCard.lastFourDigits}} </v-card-title>
                                 </v-row>
                              </v-col>
                               <v-col cols="12" class="mt-n1">
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
                        <v-col cols ="4" class="mx-auto">
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
                    <v-col cols="4" class="mx-auto">
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


                <v-col cols="3" class="d-flex" >
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
                <v-col cols="3" class="d-flex" >
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
                <v-col cols="3" class="d-flex" >
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
            <v-row justify="center">
                <v-col cols="7" class="text-center">
                    <v-btn class="rounded-l-xl white--text" color="red" :disabled="isSavingCard" @click="closeShowNewCardFormDialog" >
                        CANCELAR
                        <v-icon right>mdi-close</v-icon>
                    </v-btn>
                     <v-btn class="rounded-r-xl white--text"  :loading="isSavingCard" :disabled="isSavingCard" @click="generalValidate" color="#4CAF50"  >
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
            <v-btn color="teal" depressed @click="goToOrders" class="white--text">IR A MIS ORDENES</v-btn>
            <v-spacer></v-spacer>
            <v-btn color="teal" depressed class="white--text" @click="stayInMarketcar">SEGUIR COMPRANDO</v-btn>
        </v-card-actions>
    </v-card>
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
            isOrderAlreadyPayed: false
        }
    },

    created(){
        if(this.$route.name == 'StepFourNetpay'){
            if(Object.keys(this.quotedOrder).length == 0){
                if(localStorage.getItem('quotedOrder') !== null){
                    Object.assign(this.quotedOrder, this.$store.getters.getQuotedOrder.order)
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


        // let cardInformation = {
        //     cardNumber: "5499490519982367",
        //     expMonth: "04",
        //     expYear: "25",
        //     cvv2: "999",
        // };
    },

    mounted(){

    },

    methods: {
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
            this.loadingPayButton = true
            axios.post('/api/netpay-intent-pay/'+this.user.id, {cvv: this.modelCVVOnPay, token: this.selectedCard.token, amount: ''+this.$store.getters.getQuotedOrder.order.total, order: this.$store.getters.getQuotedOrder.order.order, idOrder: this.$store.getters.getQuotedOrder.order.id}).then(async(response) => {
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
                }else{
                    this.errors = 'Ocurrió un error, intente de nuevo'
                    this.displayErrors = true
                    this.loadingPayButton = false
                }

            })
        },
        goToOrders(){
            if(this.user.role == 'Superadministrador' || this.user.role == 'Administrador'){
                this.$router.push({name: 'Orders', params: {option: 'ordenes-admin'}});
            }
            else{
                this.$router.push({name: 'Orders', params: {option: 'ordenes'}});
            }
        },
        stayInMarketcar(){
            this.$router.push({name:'Marketcar'});
        }
    },

    computed: {
        ...mapState({
            user: state => state.user,
            quotedOrder: state => state.ordersModule.quotedOrder,
        }),

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
        }
    }

}
</script>

<style>

</style>
