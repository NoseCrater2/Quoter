import { mapState } from 'vuex';
<template>
    <v-col cols="12">
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
            <v-radio-group @change="changeRadioValue" v-model="modelRadioStepFourPaymentMethod" >
                <v-tooltip
                   color="transparent"
                    left
                  >
                    <template v-slot:activator="{ on, attrs }">
                        <v-radio  v-bind="attrs" v-on="on" color="#3ba2a9" class="py-2 px-5 localBorderNoActiveClass" value="debitcreditcard">
                          <template v-slot:label>
                            <div>Tarjeta de débito o crédito</div>
                            <v-spacer></v-spacer>
                            <v-img max-width="80" contain src="https://fantactica.mx/wp-content/uploads/2021/04/visa-and-mastercard-logos-logo-visa-png-logo-visa-mastercard-png-visa-logo-white-png-awesome-logos.png"></v-img>
                          </template>
                        </v-radio>
                    </template>
                    <!-- <v-col cols="3">
                        <v-card outlined class="pa-5 text-justify" style="border: 3px solid #E53935; box-shadow: 1px 0px 9px 3px rgba(0,0,0,0.75);">
                          Estamos trabajando para habilitar esta opción de pago, sentimos el inconveniente que te pueda ocasionar.
                        </v-card>
                    </v-col> -->
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
                            <v-img max-width="80" contain src="https://mundocontact.com/wp-content/uploads/2017/03/OXXO-PAY.jpg"></v-img>
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
</template>

<script>
import {mapState} from 'vuex';
export default {
    created(){
        if(this.$route.name == 'StepThreeChoose'){
            if(Object.keys(this.quotedOrder).length == 0){
                if(localStorage.getItem('quotedOrder') !== null){
                    Object.assign(this.quotedOrder, this.$store.getters.getQuotedOrder.order)
                }
                else if(localStorage.getItem('quotedOrder') === null){
                    this.$router.push({name: 'Marketcar'});
                }
            }
        }
    },
    data() {
        return {
            modelRadioStepFourPaymentMethod: localStorage.getItem('quotedOrder') !== null ? JSON.parse(localStorage.getItem('quotedOrder')).paymentType : ''
        }
    },
    computed:{
        ...mapState({
            quotedOrder: state => state.ordersModule.quotedOrder,
        }),
    },
    methods:{
        changeRadioValue(value){
            this.$emit('changeRadioValue', value)
        }
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
