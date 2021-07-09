<template>
    <VueHtml2pdf
    :show-layout="false"
    :float-layout="true"
    :enable-links="true"
    :enable-download="$vuetify.breakpoint.mdAndDown ? true : false"
    :preview-modal="$vuetify.breakpoint.mdAndDown ? false : true"
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
    ref="html2Pdf2"
    >
        <section slot="pdf-content"  >
            <section class="pdf-item" style="height: 130px; margin: 15px 15px 0px 15px;">
                <v-row no-gutters v-if="user != null" style="height: 100px;" >
                    <v-col cols="4" style="margin: auto">
                        <img v-if="distributor.name != null" width="80%" src="/img/logos/rollux.png" >
                        <img width="80%" :src="`/img/${user.logo}`" >
                    </v-col>
                    <v-col cols="4" style="border-left: solid #47a5ad 4px;">
                        <div style="margin-left: 12px;">
                            <div class="d-block" style="font-weight: bolder;font-size: 12px;" >Rollux | Atención a Distribuidores</div>
                            <div class="d-block" style="font-size: 10px;">Whatsapp: 55 4894 8279</div>
                            <div class="d-block" style="font-size: 10px;">Correo:  ventas@rolllux.com.mx</div>
                            <br>
                            <div class="d-block" style="font-weight: bolder; font-size: 12px;">
                            Cotización
                            </div>
                            <div class="d-block" style="font-weight: bolder; font-size: 12px;">
                            FOLIO 
                            <span style="color: #47a5ad">
                                R{{ getFormattedDate() }}/001
                            </span>
                            </div>
                            <div class="d-block" style="font-size: 12px;">
                                Fecha: {{new Date().toLocaleDateString('es-MX')}}
                            </div>
                        </div>
                    </v-col>
                    <v-col cols="4" >
                        <div style="height: 100px;border: 1px solid #d1d3d4; border-radius: 10px" >
                            <v-card-title  style="font-weight: bolder; background-color: #d1d3d4;padding: 0px; justify-content: center; border-radius: 5px; font-size: 0.8em;">
                                CLIENTE / Dirección de envío
                            </v-card-title>
                            <v-row no-gutters style="margin-top: 5px; margin-left: 5px;font-size: 9px; line-height: 10px;">
                                <v-col cols="6">
                                    <div v-if="distributor.name != null" class="d-block" style="font-weight: bolder;">
                                       {{distributor.name + ' ' + distributor.last_name}}
                                    </div>
                                    <div v-else class="d-block" style="font-weight: bolder;">
                                       {{user.name + ' ' + user.last_name}}
                                    </div>
                                    <div class="d-inline" >
                                        <span v-if="distributor.ship_address != null">
                                        {{distributor.ship_address}}
                                        </span>
                                        <span v-else>
                                        {{user.ship_address}}
                                        </span>
                                    </div>
                                </v-col>
                                <v-col cols="6">
                                    <span style="font-weight: bolder">RFC: </span>JVEXXXXXALXX
                                    <span v-if="distributor.phone != null">Telefono: {{distributor.phone}}</span>
                                    <span v-else>Telefono: {{user.phone}}</span>
                                    <div class="d-block">Embarcado por:</div>
                                    <div class="d-block">Fecha de entrega: </div>
                                    <span>Realizado por: </span>Rollux Web
                                </v-col>
                            </v-row>
                        </div>
                    </v-col>
                </v-row>
            </section>
            <section class="pdf-item">
                <div
                v-for="o in orders"
                :key="o.id"
                style="display: flex; justify-content: center; align-items: center; width: 100%; height: 100px; border: 1px dashed black;">
                    <div style="display: flex; width: 90%; height:90px;border: 1px solid #d1d3d4;">
                        <div  style="width: 16%;font-size: 10px; border: 1px solid #d1d3d4;background-color:#f1f1f2;color: #418686;width: 28px; font-weight: bolder">
                           <p class="rotado" style="margin-top: 40px;">PERSIANA {{ o.id }}</p> 
                        </div>
                        <div style="width: 56%; padding: 7px 0px 7px 21px;font-size: 10px;line-height: 10px;">
                        <div>
                            <span> <strong>Modelo:</strong> <strong style="color: #47a5ad">{{$store.getters.getVariant(o.variant).name}}</strong></span>
                        </div>
                        <div v-if="o.variant2 != null">
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
                        </span>
                    </div>
                    <div  style="width: 20%;font-size: 10px;">
                        <div style="display: flex" v-if="o.second_color != null">
                            <div style="display: flex;height: 100%; width: 50%">
                                <div class="rotado " >
                                    <span>Alto:</span>
                                    <span style="font-weight: bolder; color:#47a5ad">{{o.canvas[0].height}}</span>
                                </div>
                                <div class="d-block" >
                                    <div>
                                        <span>Ancho:</span>
                                        <span style="font-weight: bolder; color:#47a5ad">{{ o.canvas[0].width }}</span>
                                    </div>
                                    <div>
                                        <img width="35" height="65" :src="`/img/modelos/medium/${o.type}/${o.manufacturer}/${o.color.code}.jpg`">
                                    </div>
                                </div>
                            </div>
                            <div  style="display: flex;height: 100%; width: 50%">
                                <div class="d-block" >
                                    <div style="margin-top: 10px">
                                        <img width="35" height="65" :src="`/img/modelos/medium/${o.type}/${o.manufacturer}/${o.second_color.code}.jpg`">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div  style="display: flex; justify-content: center; text-align: center" v-else>
                            <div class="rotado " >
                                <span>Alto:</span>
                                <span style="font-weight: bolder; color:#47a5ad">{{ o.canvas[0].height }}</span>
                            </div>
                            <div class="d-block" >
                                <div>
                                    <span>Ancho:</span>
                                    <span style="font-weight: bolder; color:#47a5ad"> {{ o.canvas[0].width }} </span>
                                </div>
                              <div>
                                <img width="70" height="65" :src="`/img/modelos/medium/${o.type}/${o.manufacturer}/${o.color.code}.jpg`">
                              </div>
                            </div>
                        </div>
                    </div>
                    <div style="width: 24%">
                        <div style="font-size: 10px; height: 59px; margin-top: 7px">
                            <div>
                                <span> <strong>Precio (m2):</strong> ${{$store.getters.getVariant(o.variant).price}} MXN</span>
                            </div>
                            <div>
                                <span v-if="distributor.discount_percent > 0"> <strong>Descuento:</strong> {{ distributor.discount_percent }}%</span>
                                 <span v-else> <strong>Descuento:</strong> {{ user.discount_percent }}%</span>
                            </div>
                            <div>
                                <span> <strong>M2:</strong> {{ o.canvas[0].height * o.canvas[0].width }}</span>
                            </div>
                            <div>
                                <span> <strong>Precio con Descto:</strong> {{ calculateDiscountPrice(o.variant) }}</span>
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
                    </div>
                </div>
            </div>
        </section>
        <section class="pdf-item">
            <div  style="display: flex; justify-content: flex-end; margin: 8px;">
                <table style="margin-right: 20px; min-width: 275px; border-collapse: collapse;">
                    <tr style="text-align: center;border:1px solid black;font-weight: bolder;">
                        <td style="font-size: 9px;">
                            SUBTOTAL
                        </td>
                        <td style="font-size: 12px;">
                            $13,719
                        </td>
                    </tr>
                    <tr style="text-align: center;border: 1px solid black;font-weight: bolder;">
                        <td style="font-size: 9px;">
                            IVA
                        </td>
                        <td style="font-size: 12px;">
                            INICLUIDO
                        </td>
                    </tr>
                    <tr style="text-align: center;border: 1px solid black;font-weight: bolder; font-size: 12px; background-color:#418686; color: white">
                        <td>
                            TOTAL
                        </td>
                        <td>
                            {{mxCurrencyFormat.format(totalPrice) }}MXN
                        </td>
                    </tr>
                </table>
            </div>
            <div  style="display: flex; justify-content: center; margin-bottom: 8px; margin-top: 40px;">
                <hr style="width:50%;text-align:left;margin-left:0; height: 3px; background-color:#47a5ad; border-width:0">
            </div>
            <div class="text-center font-italic" style="width: 90%; margin: auto; font-size: 9px; line-height: 10px;" >
                <p>
                    Favor de revisar importes y cantidades descritas en este documento // Cualquier variación será motivo de otra     cotización // La fecha del pedido se toma en cuenta a partir de la fecha de pago
                    No se procesan pedidos que no estén pagados //La mercancía viaja por cuenta y riesgo del comprador // Los tonos de las telas pueden variar ligeramente a los del muestrario
                    Para precios en dólares se tomará en cuenta tipo de cambio emitido por Banorte el día del pago.. // No hay cambios ni devoluciones una vez cortada la tela.
                </p>
            </div>
        </section>
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
            user: (state) => state.user,
        }),

        totalPrice() {
            return this.$store.getters.totalPrice;
        }
    },

    components: {
        VueHtml2pdf
    },
    methods:{
        getFormattedDate(){
            const d = new Date()
            return d.getDate() + '' + (d.getMonth() + 1) + '' +d.getFullYear() 
        },

        calculateDiscountPrice(variant){
           const original = this.$store.getters.getVariant(variant).price
           const discount =  this.user.discount_percent
           return original - ((discount / 100) * original) 
        }
    },

    props: {
        distributor: {
            type: Object,
            required: false
        }
    }
}
</script>

<style scoped>
*{
    font-family: 'Montserrat';
}
.rotado{
    transform: rotate(-90deg);
    text-align: center;
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

