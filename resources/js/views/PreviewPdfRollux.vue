<template>
    <VueHtml2pdf
    :show-layout="false"
    :float-layout="true"
    :enable-links="true"
    :enable-download="$vuetify.breakpoint.mdAndUp ? false : true"
    :preview-modal="$vuetify.breakpoint.mdAndUp ? true : false"
    :paginate-elements-by-height="800"
    filename="hee hee"
    :pdf-quality="2"
    :manual-pagination="true"
    pdf-format="a4"
    pdf-orientation="portrait"
    pdf-content-width="900"
    @hasStartedGeneration="hasStartedGeneration()"
    @hasGenerated="hasGenerated($event)"
    :html-to-pdf-options="{html2canvas: {scrollX: '0', scrollY: '0'}}"
    ref="html2Pdf"
    >
        <section slot="pdf-content" >
            <section class="pdf-item" style="height: 155px; margin: 13px 10px -3px -4px;">
                <v-row no-gutters style="height: 100px;" >
                   <v-col cols="3" style="margin: auto; margin-left: -1px" >
                        <img width="100%" src="img/logos/rollux.png" >
                    </v-col>
                    <v-col cols="4" style="border-left: solid #47a5ad 5px; margin-left: -7px; display: flex; align-items: center">
                        <div style="margin-left: 12px;margin-top: 9px; margin-botom: 6px;">
                            <div class="d-block" style="font-weight: bolder;font-size: 13px;" >Rollux | Atención a Distribuidores</div>
                            <div class="d-block" style="font-size: 13px;">Whatsapp: 55 4894 8279</div>
                            <div class="d-block" style="font-size: 13px;">Correo:  ventas@rolllux.com.mx</div>
                        </div>
                    </v-col>
                    <v-col cols="5" style="text-align: center; margin: auto; display: flex; flex-direction: column; justify-content: center;" >
                        <div class="d-block" style="font-weight: bolder; font-size: 1.3em; margin-top: 17px; margin-left: 40px">
                            Cotización en línea
                        </div>
                        <div class="d-block" style="font-size: 11px; margin-left: 40px">
                            Fecha: {{new Date().toLocaleDateString('es-MX')}}
                        </div>
                    </v-col>
                </v-row>
                <br>
                <div style="width: 78%; font-size: 8px; line-height: 10px; text-align: center; margin: -8px auto 0px auto" >
                    <i>
                        La emisión de este documento es solo para fines informativos y no representan ningún compromiso de fabricación para la empresa, ni para el cliente.
                        Se considerará en firme cuando se realice el pago del importe acordado. Precios sujetos a cambios sin previo aviso.
                    </i>
                </div>
            </section>
            <section class="pdf-item" style="margin-left: 3px; margin-top: -5px">
                <div
                v-for="(n, index) in Math.round(orders.length / 2)"
                :key="index"
                style="display: flex; justify-content: start; align-items: center;">

            <div style="display: flex; justify-content: start; align-items: center; width: 97%; height: 100px; border: 1px dashed black;">

                    <div v-for="o in returnedOneTwoOrders(n)" :key="o.id" style=" background-color: rgba(255,255,255,0); display: flex; width: 49%; height:90px;border: 1px solid #d1d3d4; margin-left: 6px;">
                        <div style="font-size: 9px; border: 1px solid #d1d3d4; background-color:#f1f1f2; color: #418686; width: 28px; font-weight: bolder">
                           <p class="rotado" style="margin-top: 55px; white-space: nowrap;">PERSIANA {{ o.id }}</p>
                        </div>
                        <div style="font-size: 7px; width: 64%; padding: 2px 0px 7px 4px;line-height: 10px;">
                        <div style="text-transform: uppercase;">
                            {{o.type}} // {{o.manufacturer}}{{o.line != null ? ' // '+o.line : ''}}{{o.variant2 != null ? ' // '+$store.getters.getVariant(o.variant).name+'-'+$store.getters.getVariant(o.variant2).name+' // ' : ' // '+$store.getters.getVariant(o.variant).name+' // '}}{{o.second_color != null ? o.color.color+' // '+o.second_color.color+ ' // ' : o.color.color+' // '}}
                                <span v-for="(canva, index) in o.canvas" :key="index">
                                    <strong v-if="o.canvas.length > 1">(L{{(index+1)}}) Ancho: {{canva.width}}m - Alto: {{canva.height}}m // </strong>
                                    <strong v-else>Ancho: {{canva.width}}m - Alto: {{canva.height}}m // </strong>
                                </span>
                            <!-- <span> <strong>Modelo:</strong> <strong style="color: #47a5ad">{{$store.getters.getVariant(o.variant).name}}</strong></span> -->
                        </div>
                        <div style="text-transform: uppercase;">
                            <span v-if="o.motor_type != null">
                                {{o.motor_type}} // {{o.motor.side_control}} // {{o.motor.manufacturer}} // {{ o.motor.instalation_side != null ? o.motor.rail_color+' // ' : '' }}
                            </span>
                            <span v-if="o.instalation_side != null">
                                {{o.instalation_side}} //
                            </span>
                            <span v-if="o.motor.drive != null">
                                {{ o.motor.drive }} //
                            </span>
                            <span v-if="o.motor.string_type != null">
                                {{o.motor.control_color}} {{o.motor.stringPrice > 0 ? o.motor.manufacturer+' (+$'+o.motor.stringPrice+') // ': ' // '}}{{o.motor.string_type+' // '}}
                            </span>
                            <span v-if="o.motor.gallery != null">
                                {{o.motor.gallery.color != null ? o.motor.gallery.color+' // ' : ''}}{{o.motor.gallery.model}} {{o.motor.galleryPrice > 0 ? '(+$'+o.motor.galleryPrice+') // ': '(+$'+o.motor.gallery.price+') // '}}
                            </span>
                            <span v-if="o.motor.motor != 0 && o.motor.motor != null">
                                {{$store.getters.getMotor(o.motor.motor).system}} // {{$store.getters.getMotor(o.motor.motor).motorizationType}} // {{$store.getters.getMotor(o.motor.motor).manufacturer}} {{$store.getters.getMotor(o.motor.motor).price > 0 ? '(+$'+$store.getters.getMotor(o.motor.motor).price+') // ': ' // '}}
                            </span>
                            <span v-if="o.motor.control != null">
                                {{o.motor.control.description}} {{o.motor.control.price > 0 ? '(+$'+o.motor.control.price+') // ': ' // '}}
                            </span>
                            <span v-if="o.motor.flexiballetPrice > 0">
                                (+${{o.motor.flexiballetPrice}}) //
                            </span>
                        </div>
                        <!-- <div v-if="o.variant2 != null">
                            <span> <strong>Modelo 2:</strong> <strong style="color: #47a5ad">{{$store.getters.getVariant(o.variant2).name}}</strong></span>
                        </div>
                        <div>
                            <span> <strong>Color:</strong> {{o.color.color}} <strong>Codigo: </strong><strong style="color: #47a5ad">{{ o.color.code }}</strong></span>
                        </div>
                        <div v-if="o.second_color != null">
                            <span> <strong>Color 2:</strong> {{o.second_color.color}} <strong>Codigo: </strong><strong style="color: #47a5ad">{{ o.second_color.code }}</strong></span>
                        </div>
                        <div>
                            <span> <strong>Tipo:</strong>{{ o.type }} </span>
                            <span v-if="o.line != null"><strong>Línea: </strong> {{ o.line }}</span>
                        </div>
                        <br>
                        <div v-if="o.motor_type != null">
                            <span >
                                <strong>Accionamiento: </strong>{{o.motor_type}}
                                <strong v-if="o.motor_type === 'Manual'">Control:</strong>
                                <strong v-if="o.motor_type === 'Motorizado'">Motor: </strong> {{o.motor.side_control}}
                            </span>
                        </div>
                        <div v-if="o.instalation_side != null">
                            <span >
                                <strong>Instalación a: </strong>{{o.instalation_side}}
                            </span>
                        </div>
                        <span v-if="o.motor.selected_panel && o.motor.selected_panel != 0">
                            <strong>Agrupamiento: </strong>{{o.motor.selected_panel}}
                        </span>
                        <span v-if="o.motor.frame != null">
                            <strong>Marco: </strong>{{o.motor.frame}}
                        </span>
                        <span v-if="o.motor.drive != null">
                            <strong>Accionamiento: </strong> {{ o.motor.drive }}
                        </span>
                        <span v-if="o.motor.height_control != null">
                            <strong>Altura de mando: </strong>{{o.motor.height_control}}
                        </span>

                        <div v-if="o.motor.instalation_side != null">
                            <span >
                                <strong>Instalación a: </strong>{{o.motor.instalation_side}}
                                <strong>Riel: </strong> {{ o.motor.rail_color }}
                            </span>
                        </div>


                        <div v-if="o.motor.string_type != null">
                            <span>
                                <strong>Marca: </strong>{{o.motor.manufacturer}}
                                <i v-if="o.motor.manufacturerPrice > 0" style="color: #47a5ad">+({{o.motor.manufacturerPrice}})</i>
                                <strong>Color: </strong>{{o.motor.control_color}}
                                <strong>Cadena: </strong>{{o.motor.string_type}}
                                <i v-if="o.motor.stringPrice > 0" style="color: #47a5ad">+({{o.motor.stringPrice}})</i>
                            </span>
                        </div>
                        <div v-if="o.motor.gallery != null">
                           <span>
                               <strong>Galería/Fascia: </strong>{{o.motor.gallery.model}}
                                <i v-if="o.motor.galleryPrice > 0" style="color: #47a5ad">+({{o.motor.galleryPrice}})</i>
                                <i v-else style="color: #47a5ad">+({{o.motor.gallery.price}})</i>
                               <strong v-if="o.motor.gallery.color != null">Color: </strong> {{o.motor.gallery.color}}
                               <strong>N/A</strong>
                            </span>
                        </div>
                        <div v-if="o.motor.motor != 0 && o.motor.motor != null">
                            <span>
                                <strong>Tipo: </strong>{{$store.getters.getMotor(o.motor.motor).system}} |
                                {{$store.getters.getMotor(o.motor.motor).motorizationType}}
                                <strong>Marca: </strong>{{$store.getters.getMotor(o.motor.motor).manufacturer}}
                                <i style="color: #47a5ad">+({{$store.getters.getMotor(o.motor.motor).price}})</i>
                            </span>
                        </div>
                        <div v-if="o.motor.control != null">
                            <span>
                                <strong>Control: </strong>{{o.motor.control.description}}
                                <i style="color: #47a5ad">+({{o.motor.control.price}})</i>
                            </span>
                        </div>
                        <span v-if="o.motor.flexiballetPrice > 0">
                            <strong>Extra: </strong>
                            <i style="color: #47a5ad">+({{o.motor.flexiballetPrice}})</i>
                        </span> -->
                    </div>

                    <div style="width: 40%;font-size: 9px; background-color: rgba(255,255,255,0)">
                        <div v-if="o.second_color != null">
                            <div style="margin-top: 7px; margin-bottom: 11.5px; margin-left: 28%">
                                <img width="43" height="43" :src="`/img/modelos/medium/${o.type}/${o.manufacturer}/${o.color.code}.jpg`">
                                <img width="43" height="43" style="padding-left: 2px" :src="`/img/modelos/medium/${o.type}/${o.manufacturer}/${o.second_color.code}.jpg`">
                            </div>
                            <div style="font-weight: bolder; border: 1px solid #d1d3d4;background-color:#f1f1f2; font-size: 9.57px; width: 100%; text-align: right; padding-bottom: 3px; padding-top: 2px; padding-right: 4px">
                                  <span>TOTAL: </span>
                                  <span style="color: #47a5ad">
                                    {{mxCurrencyFormat.format(
                                    o.price +
                                    o.motor.price +
                                    o.motor.flexiballetPrice +
                                    o.motor.galleryPrice +
                                    o.motor.manufacturerPrice +
                                    o.motor.stringPrice
                                    )}} MXN
                                  </span>
                            </div>
                        </div>
                        <div v-else>
                            <div style="margin-top: 7px; margin-bottom: 11.5px; margin-left: 60%">
                              <img width="43" height="43" :src="`/img/modelos/medium/${o.type}/${o.manufacturer}/${o.color.code}.jpg`">
                            </div>
                            <div style="font-weight: bolder; border: 1px solid #d1d3d4;background-color:#f1f1f2; font-size: 9.57px; width: 100%; text-align: right; padding-bottom: 3px; padding-top: 2px; padding-right: 4px">
                                  <span>TOTAL: </span>
                                  <span style="color: #47a5ad">
                                    {{mxCurrencyFormat.format(
                                    o.price +
                                    o.motor.price +
                                    o.motor.flexiballetPrice +
                                    o.motor.galleryPrice +
                                    o.motor.manufacturerPrice +
                                    o.motor.stringPrice
                                    )}} MXN
                                  </span>
                            </div>
                        </div>
                    </div>


                    <!-- <div style="width: 24%">
                        <div style="font-size: 10px; height: 59px; margin-top: 7px">
                            <div>
                                <span> <strong>Precio (m2):</strong> ${{$store.getters.getVariant(o.variant).price}} MXN</span>
                            </div>
                            <div>
                                <span> <strong>M2:</strong> {{ o.canvas[0].height * o.canvas[0].width }}</span>
                            </div>
                        </div>
                        <div style="font-weight: bolder; border: 1px solid #d1d3d4;background-color:#f1f1f2; font-size: 12px; display: flex; justify-content: center;">
                              <div class="d-inline" >TOTAL:</div>
                              <div class="d-inline" style="color: #47a5ad">{{mxCurrencyFormat.format(
                            o.price +
                            o.motor.price +
                            o.motor.flexiballetPrice +
                            o.motor.galleryPrice +
                            o.motor.manufacturerPrice +
                            o.motor.stringPrice
                            )}} MXN</div>
                        </div>
                    </div> -->
                </div>
            </div>

            </div>
        </section>

        <section class="pdf-item" style="margin-top: 16px">
            <div  style="display: flex; justify-content: flex-end; margin: 8px;">
                <table style="margin-right: 20px; min-width: 275px; border-collapse: collapse;">
                    <tr style="border:1px solid black;font-weight: bolder;">
                        <td style="font-size: 9px; text-align: center;">
                            SUBTOTAL
                        </td>
                        <td style="font-size: 12px; text-align: right; padding-right: 11px;">
                            {{mxCurrencyFormat.format(totalPrice) }} MXN
                        </td>
                    </tr>
                    <tr style="border: 1px solid black;font-weight: bolder;">
                        <td style="font-size: 9px; text-align: center;">
                            IVA
                        </td>
                        <td style="font-size: 12px; text-align: right; padding-right: 11px;">
                            INCLUIDO
                        </td>
                    </tr>
                    <tr style="border: 1px solid black;font-weight: bolder; font-size: 12px; background-color:#418686; color: white">
                        <td style="text-align: center;">
                            TOTAL
                        </td>
                        <td style="text-align: right; padding-right: 11px;">
                            {{mxCurrencyFormat.format(totalPrice) }} MXN
                        </td>
                    </tr>
                </table>
            </div>
            <div style="display: flex; justify-content: center; margin-bottom: 8px; margin-top: 29px;">
                <hr style="width:27%;text-align:left;margin-left:0; height: 3px; background-color:#47a5ad; border-width:0">
            </div>
            <div style="width: 87%; margin: auto; font-size: 8px; line-height: 10px; text-align: center;">
                <i>
                    Favor de revisar importes y cantidades descritas en este documento // Cualquier variación será motivo de otra cotización // La fecha del pedido se toma en cuenta a partir de la fecha de pago
                    No se procesan pedidos que no estén pagados // La mercancía viaja por cuenta y riesgo del comprador // Los tonos de las telas pueden variar ligeramente a los del muestrario
                    Para precios en dólares se tomará en cuenta tipo de cambio emitido por Banorte el día del pago. // No hay cambios ni devoluciones una vez cortada la tela. Precios sujetos a cambios sin previo aviso.
                </i>
            </div>
        </section>


            <!-- <div class="water" v-for="p in  Math.ceil(orders.length/3)" :key="p">
                <section class="pdf-item watermark"  v-for="o in orders.slice((p-1)*3, ((p-1)*3)+3)" :key="o.id">
                <div  v-if="$store.getters.getVariant(o.variant)" style="width: 90%; height: 90%;  margin-top: 2%;">

                </div>
            </section>
                <div class="html2pdf__page-break"/>
            </div> -->
        </section>
    </VueHtml2pdf>

</template>

<script>
import VueHtml2pdf from 'vue-html2pdf'
import {mapState} from 'vuex'
export default {
    data(){
        return{
            mxCurrencyFormat : new Intl.NumberFormat('en-US', {style: 'currency', currency: 'USD'}),
        }
    },


    computed:{
         ...mapState({
            orders: (state) => state.ordersModule.orders,
        }),
        totalPrice() {
            return this.$store.getters.totalPrice;
        }
    },


    methods:{
        returnedOneTwoOrders(localIndex){
            let multiX2 = localIndex * 2;
            return this.orders.slice((multiX2 - 2), multiX2)
        },
    },

    components: {
        VueHtml2pdf
    }
}
</script>

<style scoped>
*{
    font-family: 'Montserrat';

}
.rotado{
    transform: rotate(-90deg);
}
/* .watermark {

    border: 1px dashed gray;
    height: 217px;
    width: 97%;
    display: flex;
    justify-content: center;
}
.water{
 background-image: url('/img/transparent-r.png');
 background-repeat: no-repeat;
 background-position:center;
 background-size: 300px;

} */
</style>
