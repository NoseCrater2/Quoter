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
        <section>
            
        </section>
        <section slot="pdf-content"  v-if="user">
           
            <section class="pdf-item" style="height: 235px; margin: 15px 15px 0px 15px;">
                <v-row no-gutters v-if="user != null" style="height: 100px;" >
                    <v-col cols="4" style="margin: auto">
                        <img width="80%" :src="`/img/${user.logo}`" >
                    </v-col>
                    <v-col cols="4" >
                        
                    </v-col>
                    <v-col cols="4" style="text-align: center; text-justify: center;">
                        <div class="d-block" style="font-weight: bolder; font-size: 2em;">
                            Cotización
                        </div>
                        <div class="d-block">
                            Folio
                            <div class="d-inline" style="color: #47a5ad; font-weight: bolder;">R200421/001</div>
                        </div>
                        <div class="d-block">
                            Fecha: {{new Date().toLocaleDateString('es-MX')}}
                        </div>
                    </v-col>
                </v-row>
                <v-row justify="center" align="center"  style="height: 100px;" >
                    <v-col cols="6" >
                        <div style="height: 100px;border: 1px solid #d1d3d4; border-radius: 10px" >
                            <v-card-title  style="font-weight: bolder; background-color: #d1d3d4; padding: 0px; justify-content: center; border-radius: 5px; font-size: 0.8em;">
                                CLIENTE / Dirección de envío
                            </v-card-title>
                          <v-card-subtitle style="margin-top: 5px; margin-left: 15px;font-size: 12px; line-height: 15px;">
                                <div class="d-block" style="font-weight: bolder;">
                                    {{user.name+' '+user.last_name}}
                                </div>
                                <div class="d-inline" >
                                    {{user.ship_address}}
                                </div>
                          </v-card-subtitle>
                        </div>
                    </v-col>
                    <v-col cols="6" >
                        <div  style="height: 100px;border: 1px solid #d1d3d4; border-radius: 10px">
                              <v-card-title  style="font-weight: bolder; background-color: #d1d3d4; padding: 0px; justify-content: center; border-radius: 5px; font-size: 0.8em;">
                                Dirección de envío alterna
                            </v-card-title>
                          <v-card-subtitle v-if="user.second_ship_address != null" style="margin-top: 5px; margin-left: 15px;font-size: 12px; line-height: 15px;">
                                <div class="d-block" style="font-weight: bolder;">
                                    {{user.name+' '+user.last_name}}
                                </div>
                                <div class="d-inline" >
                                    {{user.second_ship_address}}
                                </div>
                          </v-card-subtitle>
                        </div>
                    </v-col>
                </v-row>
            </section>
            <div class="water" v-for="p in  Math.ceil(orders.length/3)" :key="p">
                <section class="pdf-item watermark"  v-for="o in orders.slice((p-1)*3, ((p-1)*3)+3)" :key="o.id">
                <div  v-if="o.id" style="width: 90%; height: 90%;  margin-top: 2%;">
                    <div style="width: 100%; height: 80%; border: 1px solid #d1d3d4;">
                        <div style="width: 22.5%; height: 15%; border: 1px solid #d1d3d4; margin-top: 9.5%; text-align: center;margin-left: -87px; transform: rotate(-90deg); font-weight: bolder; color: #418686; background-color:#f1f1f2;">
                            PERSIANA {{o.id}}
                        </div>
                        <div style="width: 60%; height: 80%;margin-top: -78px; margin-left: 25px;font-size: 12px;" >
                            <div class="d-block" style="font-weight: bolder;">
                                Modelo: {{$store.getters.getVariant(o.variant).name}}
                            </div>
                            <div class="d-block" style="font-weight: bolder;" v-if="o.variant2 != null">
                                Modelo 2:  {{$store.getters.getVariant(o.variant2).name}}
                            </div>
                            <div class="d-block">
                                <b> Color:</b>{{o.color.color}}
                                <b>Código:</b>{{o.color.code}} 
                            </div>
                            <div class="d-block" v-if="o.second_color != null">
                                <b> Color 2:</b>{{o.second_color.color}}
                                <b>Código:</b>{{o.second_color.code}} 
                            </div>
                            <div class="d-block">
                                <b>Tipo:</b>Persiana {{o.type}}
                                <b>Línea: </b>{{o.line}}
                            </div>
                            <div  class="d-block">
                                <b v-if="o.cloth_holder">CON PORTATELA</b> 
                                <div style="display: inline" v-if="o.celular_type != null">
                                  {{o.celular_type}}
                                </div>
                                <div style="display: inline" v-if="o.celular_drive != null">
                                  {{o.celular_drive}}
                                </div>
                                <div style="display: inline" v-if="o.instalation_side != null">
                                  <b>Tipo de instalación: </b> {{o.motor.instalation_side}}
                                </div>
                                <div style="display: inline" v-if="o.motor.instalation_side != null">
                                 <b>Tipo de instalación: </b> {{o.motor.instalation_side}}
                                </div>
                            </div>
                            <div class="d-block">
                                <div style="display: inline" v-if="o.motor.frame != null">
                                    <b>Marco: </b>{{o.motor.frame}}
                                </div>
                                <div style="display: inline" v-if="o.motor.rail_color != null">
                                    <b>Riel: </b> {{o.motor.rail_color}}
                                </div>
                                <div style="display: inline" v-if="o.motor.height_control != null">
                                    <b>Alura de mando: </b> {{o.motor.height_control}} mts
                                </div>
                                <div style="display: inline" v-if="o.motor.selected_panel && o.motor.selected_panel != 0">
                                    <b>Agrupamiento: </b> {{o.motor.selected_panel}}
                                </div>
                            </div>
                            <div class="d-block">
                                <b>Precio (m2):</b>${{$store.getters.getVariant(o.variant).price}} MXN | 
                                <b>Subtotal:</b>${{o.price}} MXN
                            </div>
                            <br>
                            <div class="d-block">
                                <div v-if="o.motor_type != null"><b>Accionamiento:</b>{{o.motor_type}}</div>
                                <div v-if="o.motor.drive != null"><b>Control/Motor:</b>{{o.motor.drive}}</div>
                            </div>
                            <div class="d-block">
                                <div style="display: inline" v-if="o.motor.manufacturer != null">
                                    <b>Marca:</b>{{o.motor.manufacturer}}
                                </div>
                                <div style="color: #47a5ad;display: inline" v-if="o.motor.manufacturerPrice > 0">(+${{o.motor.manufacturerPrice}})</div>
                                <div style="display: inline" v-if="o.motor.control_color != null &&  o.motor.control_color != 0">
                                    <b>Color:</b>{{o.motor.control_color}}
                                </div>
                                <div style="display: inline" v-if="o.motor.string_type != null" >
                                    <b>Cadena:</b>{{o.motor.string_type}}
                                </div>
                                <div style="color: #47a5ad; display: inline" v-if="o.motor.stringPrice > 0">(+${{o.motor.stringPrice}})</div>
                            </div>
                            <div class="d-block" v-if="o.motor.gallery != null">
                                <b>Galeria/Fascia:</b>{{o.motor.gallery.model}}
                                <div style="color: #47a5ad;display: inline" v-if="o.motor.galleryPrice > 0">(+${{o.motor.galleryPrice}})</div>
                                <div style="color: #47a5ad;display: inline" v-else > 0">(+${{o.motor.gallery.price}})</div>
                                <b v-if="o.motor.gallery.color != null">Color: {{o.motor.gallery.color}}</b> 
                                <b v-else>Color: n/a</b>
                            </div>
                            <div class="d-block" v-if="o.motor.motor != 0">
                                <b>Motor:</b>
                                <div style="display: inline">{{$store.getters.getMotor(o.motor.motor).system}}</div> 
                                <div style="display: inline"> <b>Tipo: </b>{{$store.getters.getMotor(o.motor.motor).motorizationType}}</div>
                                <div style="display: inline"> <b>Precio: </b>{{mxCurrencyFormat.format($store.getters.getMotor(o.motor.motor).price)}}MXN</div>
                            </div>
                            <div class="d-block" v-if="o.motor.control != null">
                                <b>Control: </b>
                                <div style="display: inline">{{o.motor.control.description}}</div> 
                                <div style="display: inline; color: #47a5ad">{{mxCurrencyFormat.format(o.motor.control.price)}}MXN</div>
                            </div>
                            <div class="d-block" v-if="o.motor.flexiballetPrice > 0">
                                <b>EXTRA:</b>${{o.motor.flexiballetPrice}} MXN
                            </div>
                        </div>
                        <div style="width: 40%; height: 100%;margin-top: -130px; margin-left: 420px; display: flex;  font-size: 10px;">
                            <div style="height: 100%; width: 50%; text-align: center;">
                                <div class="d-block" style="margin-top: 15px;" v-for="(c, index) in o.canvas" :key="index">
                                    <div class="d-block" style="font-weight: bolder; color: #47a5ad">Lienzo {{index + 1}}:</div>
                                    <div class="d-block" style="font-weight: bolder">Ancho:{{c.width}} | Alto: {{c.height}}</div>
                                </div>
                                <div v-if="o.second_color != null">
                                    <img width="75" height="75" :src="`/img/modelos/medium/${o.color.code}.jpg`">
                                    <div class="d-block"> 
                                        Día
                                    </div>
                                </div>
                            </div>
                            <div style="height: 100%; width: 50%;display: flex">
                                <div v-if="o.variant2 != null" style="text-align: center;margin-top: 38px;">
                                    <img width="75" height="75" :src="`/img/modelos/medium/${o.second_color.code}.jpg`">
                                    <div class="d-block"> 
                                        Noche
                                    </div>
                                </div>
                                <div v-else style="margin: auto">
                                    <img width="100" height="120" :src="`/img/modelos/medium/${o.color.code}.jpg`">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="width: 35%; height: 20%; border: 1px solid #d1d3d4; margin-left: 65%; justify-content: center; font-weight: bolder; background-color: #f1f1f2; display: flex;">
                        <div style="margin-top: 10px;">TOTAL: </div>
                        <div style="color: #47a5ad; margin-top: 10px;">
                            {{mxCurrencyFormat.format(
                            o.price + 
                            o.motor.price +
                            o.motor.flexiballetPrice +
                            o.motor.galleryPrice +
                            o.motor.manufacturerPrice +
                            o.motor.stringPrice
                            )}} MXN
                        </div> 
                    </div>
                </div>
            </section>
                    <section class="pdf-item" style="font-size: 10px; font-style: italic; color: gray; margin: 15px;">
                La emisión de este documento es solo para fines informativos y no representa ningún compromiso de fabricación para la empresa ni para el cliente, se considerará en firme cuando se realice el pago del importe acordado.
            </section>
                
                <div class="html2pdf__page-break"/>
            </div>

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

.watermark {
   
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
 
}
</style>

