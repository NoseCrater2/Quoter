<template>
    <div>
            <v-card outlined>
              <v-row no-gutters>
                  <!-- style="color: #47a5ad; background-color: #E0E0E0; writing-mode: tb-rl; transform: rotate(-180deg);" -->
                  <v-col cols="1" class="text-uppercase font-weight-bold text-center" style="color: #47a5ad; background-color: #E0E0E0; writing-mode: tb-rl; transform: rotate(-180deg);">
                        <div class="mr-5">
                            Persiana {{propBlindCount}}
                        </div>
                  </v-col>
                  <v-col cols="6" xl="8" lg="7" md="6" sm="6" class="text-uppercase">
                      <div style="font-size: 0.60rem" class="pa-1">
                          <div>
                              <span>{{localComputedOrderQuotation.type}} // {{localComputedOrderQuotation.manufacturer}}</span>
                              <span>{{localComputedOrderQuotation.line != null ? ' // '+localComputedOrderQuotation.line : ''}}</span>
                              <span>{{localComputedOrderQuotation.variant2 != null ? ' // [1. '+$store.getters.getVariant(localComputedOrderQuotation.variant, localComputedOrderQuotation.type).name+'] y [2. '+$store.getters.getVariant(localComputedOrderQuotation.variant2, localComputedOrderQuotation.type).name+'] // ' : ' // '+$store.getters.getVariant(localComputedOrderQuotation.variant, localComputedOrderQuotation.type).name+' // '}}</span>
                              <span>{{localComputedOrderQuotation.second_color != null ? localComputedOrderQuotation.color.color+' // '+localComputedOrderQuotation.second_color.color+' //' : localComputedOrderQuotation.color.color+' //'}}</span>
                              <span>{{localComputedOrderQuotation.cloth_holder ? 'CON '+localComputedOrderQuotation.cloth_holder+' //' : ''}}</span>
                              <span v-for="(canva, index) in localComputedOrderQuotation.canvas" :key="index">
                                  <span>{{localComputedOrderQuotation.canvas.length > 1 ? '(L'+(index + 1)+') Ancho: '+canva.width+'m - Alto: '+canva.height+'m // ' : 'Ancho: '+canva.width+'m - Alto: '+canva.height+'m // '}}</span>
                              </span>
                              <span>{{localComputedOrderQuotation.extraEnrollable > 0 ? 'Cargo extra: $'+localComputedOrderQuotation.extraEnrollable+'.00 MXN // ' : ''}}</span>
                              <span>{{localComputedOrderQuotation.extraVertical > 0 ? 'Cargo extra: $'+localComputedOrderQuotation.extraVertical+'.00 MXN // ' : ''}}</span>
                          </div>
                          <div>
                              <span>{{localComputedOrderQuotation.celular_type != null ? localComputedOrderQuotation.celular_type+' // '+localComputedOrderQuotation.celular_drive+' // ' : ''}}</span>

                              <!-- ESTE PANEL IMPRIME 0 EN EL SHOWRESOURCE (CENTRAL a 0) -->
                              <span>{{localComputedOrderQuotation.motor.selected_panel ? localComputedOrderQuotation.motor.selected_panel+' // PANELES: '+localComputedOrderQuotation.motor.panels+' // ' : ''}}</span>


                              <span v-if="localComputedOrderQuotation.motor_type != null">
                                  {{localComputedOrderQuotation.motor_type+' // '+localComputedOrderQuotation.motor.side_control+' // '+(localComputedOrderQuotation.motor.manufacturer != null ? localComputedOrderQuotation.motor.manufacturer+' //' : '')+''}}
                                  <span>{{localComputedOrderQuotation.motor.instalation_side != null ? localComputedOrderQuotation.motor.instalation_side+' ss// '+localComputedOrderQuotation.motor.rail_color+' // ' : ''}}</span>
                              </span>
                              <span>{{localComputedOrderQuotation.motor.frame != null ? localComputedOrderQuotation.motor.frame+' // ' : ''}}</span>
                              <span>{{localComputedOrderQuotation.instalation_side != null ? localComputedOrderQuotation.instalation_side+' // ' : ''}}</span>
                              <span>{{localComputedOrderQuotation.motor.drive != null ? localComputedOrderQuotation.motor.drive+' // ' : ''}}</span>
                              <span v-if="localComputedOrderQuotation.motor.string_type != null">
                                  {{localComputedOrderQuotation.motor.control_color+' '}}
                                  <span>{{localComputedOrderQuotation.motor.stringPrice > 0 ? localComputedOrderQuotation.motor.manufacturer+' (+$'+localComputedOrderQuotation.motor.stringPrice+') // ' : ' // '}}</span>
                                  {{localComputedOrderQuotation.motor.string_type+' // '}}
                              </span>
                              <span>{{localComputedOrderQuotation.motor.height_control ? localComputedOrderQuotation.motor.height_control+' MTS // ' : ''}}</span>
                              <span v-if="localComputedOrderQuotation.motor.gallery != null">
                                  <span>{{localComputedOrderQuotation.motor.gallery_color != null ? localComputedOrderQuotation.motor.gallery_color+' // ' : ''}}</span>
                                  {{localComputedOrderQuotation.motor.gallery.model+' '}}
                                  <span>{{localComputedOrderQuotation.motor.galleryPrice > 0 ? '(+$'+localComputedOrderQuotation.motor.galleryPrice+') // ' : '(+$'+localComputedOrderQuotation.motor.gallery.price+') // '}}</span>
                              </span>

                                <!-- ¿ES NORMAL QUE APAREZCA UN 0 EN LA MOTORIZACION? -->
                              <span v-if="localComputedOrderQuotation.motor.motor != 0 && localComputedOrderQuotation.motor.motor != null">
                                  <span>
                                      {{$store.getters.getMotor(localComputedOrderQuotation.motor.motor).system+' // '+$store.getters.getMotor(localComputedOrderQuotation.motor.motor).motorizationType+' // '+$store.getters.getMotor(localComputedOrderQuotation.motor.motor).manufacturer+' '}}
                                      <span>{{$store.getters.getMotor(localComputedOrderQuotation.motor.motor).price > 0 ? '(+$'+$store.getters.getMotor(localComputedOrderQuotation.motor.motor).price+') // ' : '// '}}</span>
                                  </span>
                              </span>


                              <span v-if="localComputedOrderQuotation.motor.control != null">
                                  {{localComputedOrderQuotation.motor.control.description+' '}}
                                  <span>{{localComputedOrderQuotation.motor.control.price > 0 ? '(+$'+localComputedOrderQuotation.motor.control.price+') // ' : ' // '}}</span>
                              </span>
                              <span>{{localComputedOrderQuotation.motor.flexiballetPrice > 0 ? '(+$'+localComputedOrderQuotation.motor.flexiballetPrice+')' : ''}}</span>
                          </div>
                          <div>
                              <span>Precio (m2): {{mxCurrencyFormat.format(localComputedOrderQuotation.price)}} MXN // Descuento: {{propOrderUser.discount_percent}} % // M2: {{squareMeters(localComputedOrderQuotation.canvas[0].width, localComputedOrderQuotation.canvas[0].height)}} //</span>
                              <span>
                                  Precio con Descto: {{mxCurrencyFormat.format(localComputedOrderQuotation.discount_price)}} MXN
                              </span>
                          </div>

                      </div>
                  </v-col>
                  <v-col cols="5" xl="3" lg="4" md="5" sm="5">
                      <v-col cols="12">
                          <v-row no-gutters v-if="localComputedOrderQuotation.second_color != null" justify="end">
                              <v-col cols="6">
                                  <v-img class="ml-auto" min-width="70" max-width="70" min-height="70" max-height="70" :src="'/img/modelos/medium/'+localComputedOrderQuotation.type+'/'+localComputedOrderQuotation.manufacturer+'/'+localComputedOrderQuotation.color.code+'.jpg'" ></v-img>
                              </v-col>
                              <v-col cols="6" class="text-end">
                                  <v-img class="ml-auto" min-width="70" max-width="70" min-height="70" max-height="70" :src="'/img/modelos/medium/'+localComputedOrderQuotation.type+'/'+localComputedOrderQuotation.manufacturer+'/'+localComputedOrderQuotation.second_color.code+'.jpg'" ></v-img>
                              </v-col>
                          </v-row>
                          <v-row no-gutters v-else justify="end">
                              <v-col cols="6">
                                  <v-img class="ml-auto" min-width="70" max-width="70" min-height="70" max-height="70" :src="'/img/modelos/medium/'+localComputedOrderQuotation.type+'/'+localComputedOrderQuotation.manufacturer+'/'+localComputedOrderQuotation.color.code+'.jpg'" ></v-img>
                              </v-col>
                          </v-row>
                      </v-col>
                      <v-col cols="12" class="text-end text-uppercase font-weight-bold" style="background-color: #E0E0E0;">
                          <div>
                              <span>Total: </span>
                              <span style="color: #47a5ad;">
                                  {{mxCurrencyFormat.format(
                                      parseFloat(localComputedOrderQuotation.discount_price) +
                                      parseFloat(localComputedOrderQuotation.motor.price) +
                                      parseFloat(localComputedOrderQuotation.motor.flexiballetPrice) +
                                      parseFloat(localComputedOrderQuotation.motor.galleryPrice) +
                                      parseFloat(localComputedOrderQuotation.motor.manufacturerPrice) +
                                      parseFloat(localComputedOrderQuotation.motor.stringPrice) +
                                      parseFloat(localComputedOrderQuotation.extraVertical) +
                                      parseFloat(localComputedOrderQuotation.extraEnrollable)
                                  )}} MXN
                              </span>
                          </div>
                      </v-col>
                  </v-col>
              </v-row>
            </v-card>
            <v-row no-gutters justify="end" v-if="propIsInMarketAndStepThree && propIsOrderOrQuotationString == 'quoted'">
                <v-btn @click="emitEditBlindFromBlindsProductDetailCardsView()" small elevation="0" color="#47a5ad" class="white--text">
                    <v-icon left>mdi-square-edit-outline</v-icon>Editar
                </v-btn>
                <v-btn :disabled="quotedOrder.blinds.length < 2" @click="methodDeleteBlind(localComputedOrderQuotation)" small elevation="0" color="#757575" class="white--text ml-1">
                    <v-icon left>mdi-delete</v-icon>Borrar
                </v-btn>
            </v-row>
    </div>
</template>

<script>
import {mapState} from 'vuex';
export default {
    data() {
        return {
            mxCurrencyFormat : new Intl.NumberFormat('en-US', {style: 'currency', currency: 'USD'}),
        }
    },
    computed:{
        ...mapState({
            quotedOrder: state => state.ordersModule.quotedOrder,
        }),
        localComputedOrderQuotation(){
            return this.propItemArrayBlindsObject;
        },
    },
    methods:{
        methodDeleteBlind(itemBlind){
            this.$emit('emitDeleteBlindFromDetailCards', itemBlind);
        },
        methodUnitaryPriceDiscount(localDiscount){
            return this.propItemArrayBlindsObject.price - ((localDiscount / 100) * this.propItemArrayBlindsObject.price)
        },
        squareMeters(width, height){
            if(width < 1 && height < 1){
                return 1
            }else if(width < 1){
                return Math.round(height) * 10 / 10
            }else if(height < 1){
                return Math.round(width) * 10 / 10
            }else{
               return Math.round((width * height) * 10) / 10

            }
        },
        emitEditBlindFromBlindsProductDetailCardsView(){
            this.$emit('emitEditBlindFromBlindsProductDetailCardsView');
        }
    },
    props:{
        propItemArrayBlindsObject: {
            type: Object
        },
        propBlindCount: {
            type: Number
        },
        propBreakpointFromDialog: {
            type: Object
        },
        propIsOrderOrQuotationString: {
            type: String
        },
        propIsInMarketAndStepThree:{
            type: Boolean
        },
        propOrderUser:{
            type:Object
        }
    }
}
</script>
