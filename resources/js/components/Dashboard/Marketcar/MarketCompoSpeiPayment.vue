<template>
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
                        <div class="font-weight-bold" style="color: #3ba2a9; font-size: 1.8rem">{{mxCurrencyFormat.format(quotedOrder.total)}} MXN</div>
                    </div>
                    <div class="text-uppercase my-2">
                        <div class="font-weight-bold">No. de orden por pagar: </div>
                        <div>{{quotedOrder.order}}</div>
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
                    <v-btn large elevation="0" @click="stayInMarketcar" color="#3ba2a9" class="mt-3 white--text">
                        SEGUIR COMPRANDO
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
</template>

<script>
import {mapState} from 'vuex';
export default {
    created(){
        if(this.$route.name == 'StepFourSpei'){
            if(localStorage.getItem('quotedOrder') !== null){
                localStorage.removeItem('quotedOrder');
            }
            else if(localStorage.getItem('quotedOrder') === null){
                this.$router.push({name: 'Marketcar'});
            }
        }
    },
    data() {
        return {
            mxCurrencyFormat : new Intl.NumberFormat('en-US', {style: 'currency', currency: 'USD'}),
        }
    },
    computed:{
        ...mapState({
            quotedOrder: state => state.ordersModule.quotedOrder,
        }),
    },
    methods:{
        stayInMarketcar(){
            this.$router.push({name: 'Marketcar'});
        }

    }
}
</script>

<style>

</style>
