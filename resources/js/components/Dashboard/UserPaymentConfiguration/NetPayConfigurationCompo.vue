<template>
    <div>
    <v-card class="ma-2" flat >
        <v-card-title v-if="!showNewCardForm" class="justify-center">
            Mis tarjetas
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

            <v-row justify="center">
                <v-col v-for="(card, index) in cards" cols="12" xl="4" lg="6" md="6" sm="12" :key="index">
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
                       <v-card-actions class="mt-n8 text-center d-flex justify-center">
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
                       </v-card-actions>
                    </v-card>
                </v-col>
                <v-col v-if="!loadingCards" cols="12" class="mt-3">
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
                </v-col>
            </v-row>
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
            deleteCardDialog: false,
            isDeletingCard: false,
            isSavingCard: false,
            loadingCards: false,
            showNewCardForm: false,
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
        }
    },

    created(){

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

    methods: {

        openShowNewCardFormDialog(){
            this.showNewCardForm = true;
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
        },

        error(e) {
            this.isSavingCard = false;
            this.errors = e
            this.displayErrors = true
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
                    if(localStorage.getItem('quotedOrder') != null){
                        let localStorageObject = JSON.parse(localStorage.getItem('quotedOrder'));
                        if(localStorageObject.card.currentCard != null){
                            if(localStorageObject.card.currentCard.token == this.selectedToken){
                                localStorageObject.card.currentCard = null;
                                localStorageObject.card.isCurrentCard = false;
                                localStorage.setItem('quotedOrder', JSON.stringify(localStorageObject));
                                this.$store.commit('setCreditDebitType', '');
                            }
                        }
                    }
                    this.selectedToken = null;
                    this.chargeCards()
                }else{
                    this.errors = 'Ocurrió un error, intente de nuevo'
                    this.displayErrors = true
                }
                this.isDeletingCard = false;
                this.deleteCardDialog = false
            })
        },

    },

    computed: {
        ...mapState({
            user: state => state.user,
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
