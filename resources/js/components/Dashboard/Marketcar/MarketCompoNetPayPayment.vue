<template>
    <v-card  class="ma-2" flat >
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
            <v-item-group v-model="selectedCard" @change="intentOpenPayDialog()">
                <v-row>
                    <v-col v-for="(card, index) in cards" cols="12" :key="index">
                        <v-item :value="card.card" v-slot="{active, toggle }" >
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
                        </v-item>
                    </v-col>
                    <v-col cols="12">
                        <v-item >
                            <div class="d-flex justify-space-between align-center rounded-xl text-center" style="background: #F5F5F5; height: 50px" @click="showNewCardForm = true">
                                <span class="mx-2">Agregar nueva tarjeta Willy Joto</span>
                                <v-icon class="mx-5">mdi-plus</v-icon>
                            </div>
                        </v-item>
                    </v-col>
                </v-row>
            </v-item-group>
        </v-card-text>
        <v-card-text style="border: 1px solid #E0E0E0; border-radius: 15px;" v-if="showNewCardForm">
            <v-row justify="center" class="ma-2">
                <v-col cols="3" md="3" sm="3">
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
                <v-col cols="2" md="2" sm="2" class="d-flex" >
                    <v-text-field
                    dense
                    outlined
                    class="rounded-l-xl"
                    v-model="cardInformation.expMonth"
                    placeholder="Mes"
                    maxlength="2"
                    :error="!validateDate"
                    ></v-text-field>
                    <v-text-field
                    dense
                    outlined
                    class="rounded-r-xl"
                    v-model="cardInformation.expYear"
                    placeholder="Año"
                    maxlength="4"
                    :error="!validateDate"
                    ></v-text-field>
                </v-col>
                <v-col cols="2" md="2" sm="2">
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
            <v-row justify="center">
                <v-col cols="7" class="text-center">
                    <v-btn class="rounded-l-xl white--text" color="red" @click="showNewCardForm = false" >
                        CANCELAR
                        <v-icon right>mdi-close</v-icon>
                    </v-btn>
                     <v-btn class="rounded-r-xl white--text"  @click="generalValidate" color="#4CAF50"  >
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
                    <v-btn color="red" depressed class="white--text" @click="deleteCard">ELIMINAR</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-dialog max-width="350" v-model="payOrderDialog" persistent>
            <v-card>
                <v-card-title class="justify-center text-center" style="word-break: break-word;">
                   Al hacer clic en pagar se procederá al pago
                </v-card-title>
                <v-card-actions>
                    <v-btn color="red" depressed @click="payOrderDialog  = false" class="white--text">CANCELAR</v-btn>
                    <v-spacer></v-spacer>
                    <v-btn color="teal"  :loading="loadingPayButton" depressed class="white--text" @click="pay">PAGAR</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-card>
</template>

<script>
import NetPay from '../../../utils/netpay.min.js'
import axios from 'axios'
import { mapState } from 'vuex'
export default {
    data(){
        return {
            payOrderDialog: false,
            loadingPayButton: false,
            deleteCardDialog: false,
            loadingCards: false,
            showNewCardForm: false,
            selectedCard: null,
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

    mounted(){
        if(this.user.netpayClientId){
            this.chargeCards()
        }
        
        NetPay.setApiKey("pk_netpay_RjQdVseiQQZsCtAXVmoMoXnVq");
        NetPay.setSandboxMode(true);
        // let cardInformation = {
        //     cardNumber: "5499490519982367",
        //     expMonth: "04",
        //     expYear: "25",
        //     cvv2: "999",
        // };
    },

    methods: {
        intentOpenPayDialog(){
            if(this.selectedCard){
                this.payOrderDialog = true
            }
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
            this.errors = e
            this.displayErrors = true
        },

        generalValidate(){
            NetPay.token.create(this.cardInformation, this.success, this.error);
        },

        openDeleteCardDialog(token){
            this.selectedToken = token
            this.deleteCardDialog = true
        },

        deleteCard(){
            axios.post('/api/netpay-delete-card/'+this.user.id, {token: this.selectedToken}).then((response)=> {
                if(response.status == 200){
                    this.chargeCards()
                }else{
                    this.errors = 'Ocurrió un error, intenteló de nuevo'
                    this.displayErrors = true
                }
                this.deleteCardDialog = false
            })
        },

        pay(){
            this.loadingPayButton = true
            console.log(this.selectedCard)
            // axios.post('netpay-intent-pay/'+this.user.id, {}).then((response) => {
            //     console.log(response)
            // })
        }
    },

    computed: {
        ...mapState({
            user: state => state.user
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
