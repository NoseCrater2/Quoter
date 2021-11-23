<template>
    
    <div v-if="computedIsDiferenMarketcar">
        <v-row no-gutters>
        <v-col cols="12" xl="6" lg="6" md="12" sm="12" class="pa-2" v-for="(itemBlind, index) in quotedOrder.blinds" :key="itemBlind.id">
            <v-card outlined>
              <v-row no-gutters>
                  <!-- style="color: #47a5ad; background-color: #E0E0E0; writing-mode: tb-rl; transform: rotate(-180deg);" -->
                  <v-col cols="1" class="text-uppercase font-weight-bold text-center" style="color: #47a5ad; background-color: #E0E0E0; writing-mode: tb-rl; transform: rotate(-180deg);">
                        <div class="mr-5">
                            Persiana {{index+1}}
                        </div>
                  </v-col>
                  <v-col cols="6" xl="8" lg="7" md="6" sm="6" class="text-uppercase">
                      <div style="font-size: 0.60rem" class="pa-1">
                          <div>
                              <span>{{itemBlind.type}} // {{itemBlind.manufacturer}}</span>
                              <span>{{itemBlind.line != null ? ' // '+itemBlind.line : ''}}</span>
                              <span>{{itemBlind.variant2 != null ? ' // [1. '+$store.getters.getVariant(itemBlind.variant, itemBlind.type).name+'] y [2. '+$store.getters.getVariant(itemBlind.variant2, itemBlind.type).name+'] // ' : ' // '+$store.getters.getVariant(itemBlind.variant, itemBlind.type).name+' // '}}</span>
                              <span>{{itemBlind.second_color != null ? itemBlind.color.color+' // '+itemBlind.second_color.color+' //' : itemBlind.color.color+' //'}}</span>
                              <span>{{itemBlind.cloth_holder ? 'CON '+itemBlind.cloth_holder+' //' : ''}}</span>
                              <span v-for="(canva, index) in itemBlind.canvas" :key="index">
                                  <span>{{itemBlind.canvas.length > 1 ? '(L'+(index + 1)+') Ancho: '+canva.width+'m - Alto: '+canva.height+'m // ' : 'Ancho: '+canva.width+'m - Alto: '+canva.height+'m // '}}</span>
                              </span>
                              <span>{{itemBlind.extraEnrollable > 0 ? 'Cargo extra: $'+itemBlind.extraEnrollable+'.00 MXN // ' : ''}}</span>
                              <span>{{itemBlind.extraVertical > 0 ? 'Cargo extra: $'+itemBlind.extraVertical+'.00 MXN // ' : ''}}</span>
                          </div>
                          <div>
                              <span>{{itemBlind.celular_type != null ? itemBlind.celular_type+' // '+itemBlind.celular_drive+' // ' : ''}}</span>

                              <!-- ESTE PANEL IMPRIME 0 EN EL SHOWRESOURCE (CENTRAL a 0) -->
                              <span>{{itemBlind.motor.selected_panel ? itemBlind.motor.selected_panel+' // PANELES: '+itemBlind.motor.panels+' // ' : ''}}</span>


                              <span v-if="itemBlind.motor_type != null">
                                  {{itemBlind.motor_type+' // '+itemBlind.motor.side_control+' // '+(itemBlind.motor.manufacturer != null ? itemBlind.motor.manufacturer+' //' : '')+''}}
                                  <span>{{itemBlind.motor.instalation_side != null ? itemBlind.motor.instalation_side+' ss// '+itemBlind.motor.rail_color+' // ' : ''}}</span>
                              </span>
                              <span>{{itemBlind.motor.frame != null ? itemBlind.motor.frame+' // ' : ''}}</span>
                              <span>{{itemBlind.instalation_side != null ? itemBlind.instalation_side+' // ' : ''}}</span>
                              <span>{{itemBlind.motor.drive != null ? itemBlind.motor.drive+' // ' : ''}}</span>
                              <span v-if="itemBlind.motor.string_type != null">
                                  {{itemBlind.motor.control_color+' '}}
                                  <span>{{itemBlind.motor.stringPrice > 0 ? itemBlind.motor.manufacturer+' (+$'+itemBlind.motor.stringPrice+') // ' : ' // '}}</span>
                                  {{itemBlind.motor.string_type+' // '}}
                              </span>
                              <span>{{itemBlind.motor.height_control ? itemBlind.motor.height_control+' MTS // ' : ''}}</span>
                              <span v-if="itemBlind.motor.gallery != null">
                                  <span>{{itemBlind.motor.gallery_color != null ? itemBlind.motor.gallery_color+' // ' : ''}}</span>
                                  {{itemBlind.motor.gallery.model+' '}}
                                  <span>{{itemBlind.motor.galleryPrice > 0 ? '(+$'+itemBlind.motor.galleryPrice+') // ' : '(+$'+itemBlind.motor.gallery.price+') // '}}</span>
                              </span>

                                <!-- ¿ES NORMAL QUE APAREZCA UN 0 EN LA MOTORIZACION? -->
                              <span v-if="itemBlind.motor.motor != 0 && itemBlind.motor.motor != null">
                                  <span>
                                      {{$store.getters.getMotor(itemBlind.motor.motor).system+' // '+$store.getters.getMotor(itemBlind.motor.motor).motorizationType+' // '+$store.getters.getMotor(itemBlind.motor.motor).manufacturer+' '}}
                                      <span>{{$store.getters.getMotor(itemBlind.motor.motor).price > 0 ? '(+$'+$store.getters.getMotor(itemBlind.motor.motor).price+') // ' : '// '}}</span>
                                  </span>
                              </span>


                              <span v-if="itemBlind.motor.control != null">
                                  {{itemBlind.motor.control.description+' '}}
                                  <span>{{itemBlind.motor.control.price > 0 ? '(+$'+itemBlind.motor.control.price+') // ' : ' // '}}</span>
                              </span>
                              <span>{{itemBlind.motor.flexiballetPrice > 0 ? '(+$'+itemBlind.motor.flexiballetPrice+')' : ''}}</span>
                          </div>
                          <div>
                              <span>Precio (M<sup>2</sup>): {{mxCurrencyFormat.format(itemBlind.price)}} MXN {{itemBlind.installmentCharge > 0 ? ` // CARGO POR INSTALACIÓN: ${mxCurrencyFormat.format(itemBlind.installmentCharge)} MXN` : `` }} // Descuento: {{localOrder.user.discount_percent}} % // M<sup>2</sup> {{squareMeters(itemBlind.canvas[0].width, itemBlind.canvas[0].height)}} //</span>
                              <span>
                                  Precio con Descto: {{mxCurrencyFormat.format(itemBlind.discount_price)}} MXN
                              </span>
                          </div>

                      </div>
                  </v-col>
                  <v-col cols="5" xl="3" lg="4" md="5" sm="5">
                      <v-col cols="12">
                          <v-row no-gutters v-if="itemBlind.second_color != null" justify="end">
                              <v-col cols="6">
                                  <v-img class="ml-auto" min-width="70" max-width="70" min-height="70" max-height="70" :src="'/img/modelos/medium/'+itemBlind.type+'/'+itemBlind.manufacturer+'/'+itemBlind.color.code+'.jpg'" ></v-img>
                              </v-col>
                              <v-col cols="6" class="text-end">
                                  <v-img class="ml-auto" min-width="70" max-width="70" min-height="70" max-height="70" :src="'/img/modelos/medium/'+itemBlind.type+'/'+itemBlind.manufacturer+'/'+itemBlind.second_color.code+'.jpg'" ></v-img>
                              </v-col>
                          </v-row>
                          <v-row no-gutters v-else justify="end">
                              <v-col cols="6">
                                  <v-img class="ml-auto" min-width="70" max-width="70" min-height="70" max-height="70" :src="'/img/modelos/medium/'+itemBlind.type+'/'+itemBlind.manufacturer+'/'+itemBlind.color.code+'.jpg'" ></v-img>
                              </v-col>
                          </v-row>
                      </v-col>
                      <v-col cols="12" class="text-end text-uppercase font-weight-bold" style="background-color: #E0E0E0;">
                          <div>
                              <span>Total: </span>
                              <span style="color: #47a5ad;">
                                  {{mxCurrencyFormat.format(
                                      parseFloat(itemBlind.discount_price) +
                                      parseFloat(itemBlind.motor.price) +
                                      parseFloat(itemBlind.motor.flexiballetPrice) +
                                      parseFloat(itemBlind.motor.galleryPrice) +
                                      parseFloat(itemBlind.motor.manufacturerPrice) +
                                      parseFloat(itemBlind.motor.stringPrice) +
                                      parseFloat(itemBlind.extraVertical) +
                                      parseFloat(itemBlind.extraEnrollable) +
                                      parseFloat(itemBlind.installmentCharge)
                                  )}} MXN
                              </span>
                          </div>
                      </v-col>
                  </v-col>
              </v-row>
            </v-card>
        </v-col>
        </v-row>
    </div>
    <div v-else>
        <v-row no-gutters>
        <v-col cols="12" class="mt-3" v-for="(itemBlind, index) in quotedOrder.blinds" :key="itemBlind.id">
            <v-card outlined>
              <v-row no-gutters>
                  <!-- style="color: #47a5ad; background-color: #E0E0E0; writing-mode: tb-rl; transform: rotate(-180deg);" -->
                  <v-col cols="1" class="text-uppercase font-weight-bold text-center" style="color: #47a5ad; background-color: #E0E0E0; writing-mode: tb-rl; transform: rotate(-180deg);">
                        <div class="mr-5">
                            Persiana {{index+1}}
                        </div>
                  </v-col>
                  <v-col cols="6" xl="8" lg="7" md="6" sm="6" class="text-uppercase">
                      <div style="font-size: 0.60rem" class="pa-1">
                          <div>
                              <span>{{itemBlind.type}} // {{itemBlind.manufacturer}}</span>
                              <span>{{itemBlind.line != null ? ' // '+itemBlind.line : ''}}</span>
                              <span>{{itemBlind.variant2 != null ? ' // [1. '+$store.getters.getVariant(itemBlind.variant, itemBlind.type).name+'] y [2. '+$store.getters.getVariant(itemBlind.variant2, itemBlind.type).name+'] // ' : ' // '+$store.getters.getVariant(itemBlind.variant, itemBlind.type).name+' // '}}</span>
                              <span>{{itemBlind.second_color != null ? itemBlind.color.color+' // '+itemBlind.second_color.color+' //' : itemBlind.color.color+' //'}}</span>
                              <span>{{itemBlind.cloth_holder ? 'CON '+itemBlind.cloth_holder+' //' : ''}}</span>
                              <span v-for="(canva, index) in itemBlind.canvas" :key="index">
                                  <span>{{itemBlind.canvas.length > 1 ? '(L'+(index + 1)+') Ancho: '+canva.width+'m - Alto: '+canva.height+'m // ' : 'Ancho: '+canva.width+'m - Alto: '+canva.height+'m // '}}</span>
                              </span>
                              <span>{{itemBlind.extraEnrollable > 0 ? 'Cargo extra: $'+itemBlind.extraEnrollable+'.00 MXN // ' : ''}}</span>
                              <span>{{itemBlind.extraVertical > 0 ? 'Cargo extra: $'+itemBlind.extraVertical+'.00 MXN // ' : ''}}</span>
                          </div>
                          <div>
                              <span>{{itemBlind.celular_type != null ? itemBlind.celular_type+' // '+itemBlind.celular_drive+' // ' : ''}}</span>

                              <!-- ESTE PANEL IMPRIME 0 EN EL SHOWRESOURCE (CENTRAL a 0) -->
                              <span>{{itemBlind.motor.selected_panel ? itemBlind.motor.selected_panel+' // PANELES: '+itemBlind.motor.panels+' // ' : ''}}</span>


                              <span v-if="itemBlind.motor_type != null">
                                  {{itemBlind.motor_type+' // '+itemBlind.motor.side_control+' // '+(itemBlind.motor.manufacturer != null ? itemBlind.motor.manufacturer+' //' : '')+''}}
                                  <span>{{itemBlind.motor.instalation_side != null ? itemBlind.motor.instalation_side+' ss// '+itemBlind.motor.rail_color+' // ' : ''}}</span>
                              </span>
                              <span>{{itemBlind.motor.frame != null ? itemBlind.motor.frame+' // ' : ''}}</span>
                              <span>{{itemBlind.instalation_side != null ? itemBlind.instalation_side+' // ' : ''}}</span>
                              <span>{{itemBlind.motor.drive != null ? itemBlind.motor.drive+' // ' : ''}}</span>
                              <span v-if="itemBlind.motor.string_type != null">
                                  {{itemBlind.motor.control_color+' '}}
                                  <span>{{itemBlind.motor.stringPrice > 0 ? itemBlind.motor.manufacturer+' (+$'+itemBlind.motor.stringPrice+') // ' : ' // '}}</span>
                                  {{itemBlind.motor.string_type+' // '}}
                              </span>
                              <span>{{itemBlind.motor.height_control ? itemBlind.motor.height_control+' MTS // ' : ''}}</span>
                              <span v-if="itemBlind.motor.gallery != null">
                                  <span>{{itemBlind.motor.gallery_color != null ? itemBlind.motor.gallery_color+' // ' : ''}}</span>
                                  {{itemBlind.motor.gallery.model+' '}}
                                  <span>{{itemBlind.motor.galleryPrice > 0 ? '(+$'+itemBlind.motor.galleryPrice+') // ' : '(+$'+itemBlind.motor.gallery.price+') // '}}</span>
                              </span>

                                <!-- ¿ES NORMAL QUE APAREZCA UN 0 EN LA MOTORIZACION? -->
                              <span v-if="itemBlind.motor.motor != 0 && itemBlind.motor.motor != null">
                                  <span>
                                      {{$store.getters.getMotor(itemBlind.motor.motor).system+' // '+$store.getters.getMotor(itemBlind.motor.motor).motorizationType+' // '+$store.getters.getMotor(itemBlind.motor.motor).manufacturer+' '}}
                                      <span>{{$store.getters.getMotor(itemBlind.motor.motor).price > 0 ? '(+$'+$store.getters.getMotor(itemBlind.motor.motor).price+') // ' : '// '}}</span>
                                  </span>
                              </span>


                              <span v-if="itemBlind.motor.control != null">
                                  {{itemBlind.motor.control.description+' '}}
                                  <span>{{itemBlind.motor.control.price > 0 ? '(+$'+itemBlind.motor.control.price+') // ' : ' // '}}</span>
                              </span>
                              <span>{{itemBlind.motor.flexiballetPrice > 0 ? '(+$'+itemBlind.motor.flexiballetPrice+')' : ''}}</span>
                          </div>
                          <div>
                              <span>Precio (M<sup>2</sup>): {{mxCurrencyFormat.format(itemBlind.price)}} MXN {{itemBlind.installmentCharge > 0 ? ` // CARGO POR INSTALACIÓN: ${mxCurrencyFormat.format(itemBlind.installmentCharge)} MXN` : `` }} // Descuento: {{localOrder.user.discount_percent}} % // M<sup>2</sup> {{squareMeters(itemBlind.canvas[0].width, itemBlind.canvas[0].height)}} //</span>
                              <span>
                                  Precio con Descto: {{mxCurrencyFormat.format(itemBlind.discount_price)}} MXN
                              </span>
                          </div>

                      </div>
                  </v-col>
                  <v-col cols="5" xl="3" lg="4" md="5" sm="5">
                      <v-col cols="12">
                          <v-row no-gutters v-if="itemBlind.second_color != null" justify="end">
                              <v-col cols="6">
                                  <v-img class="ml-auto" min-width="70" max-width="70" min-height="70" max-height="70" :src="'/img/modelos/medium/'+itemBlind.type+'/'+itemBlind.manufacturer+'/'+itemBlind.color.code+'.jpg'" ></v-img>
                              </v-col>
                              <v-col cols="6" class="text-end">
                                  <v-img class="ml-auto" min-width="70" max-width="70" min-height="70" max-height="70" :src="'/img/modelos/medium/'+itemBlind.type+'/'+itemBlind.manufacturer+'/'+itemBlind.second_color.code+'.jpg'" ></v-img>
                              </v-col>
                          </v-row>
                          <v-row no-gutters v-else justify="end">
                              <v-col cols="6">
                                  <v-img class="ml-auto" min-width="70" max-width="70" min-height="70" max-height="70" :src="'/img/modelos/medium/'+itemBlind.type+'/'+itemBlind.manufacturer+'/'+itemBlind.color.code+'.jpg'" ></v-img>
                              </v-col>
                          </v-row>
                      </v-col>
                      <v-col cols="12" class="text-end text-uppercase font-weight-bold" style="background-color: #E0E0E0;">
                          <div>
                              <span>Total: </span>
                              <span style="color: #47a5ad;">
                                  {{mxCurrencyFormat.format(
                                      parseFloat(itemBlind.discount_price) +
                                      parseFloat(itemBlind.motor.price) +
                                      parseFloat(itemBlind.motor.flexiballetPrice) +
                                      parseFloat(itemBlind.motor.galleryPrice) +
                                      parseFloat(itemBlind.motor.manufacturerPrice) +
                                      parseFloat(itemBlind.motor.stringPrice) +
                                      parseFloat(itemBlind.extraVertical) +
                                      parseFloat(itemBlind.extraEnrollable) +
                                      parseFloat(itemBlind.installmentCharge)
                                  )}} MXN
                              </span>
                          </div>
                      </v-col>
                  </v-col>
              </v-row>
            </v-card>
            <v-row no-gutters justify="end" v-if="$route.name == 'StepTwoDetails'">
                <v-btn @click="methodEditBlind()" small elevation="0" color="#47a5ad" class="white--text">
                    <v-icon left>mdi-square-edit-outline</v-icon>Editar
                </v-btn>
                <v-btn :disabled="quotedOrder.blinds.length < 2" @click="methodDeleteBlind(itemBlind.id)" small elevation="0" color="#757575" class="white--text ml-1">
                    <v-icon left>mdi-delete</v-icon>Borrar
                </v-btn>
            </v-row>
        </v-col>
        </v-row>
    </div>
</template>

<script>
import axios from 'axios';
import {mapState} from 'vuex';
export default {
    created(){
        if(this.$route.name == 'StepTwoDetails'){

                if(localStorage.getItem('quotedOrder') !== null){
                    let localStorageObject = JSON.parse(localStorage.getItem('quotedOrder'));
                    Object.assign(this.localOrder, localStorageObject.order)
                }
                else if(localStorage.getItem('quotedOrder') === null){
                    this.$router.push({name: 'Marketcar'});
                }

        }
        else{
            axios.get('/api/orders/'+this.idOrder).then((response)=>{
                this.localOrder = response.data.data
            })
        }
    },
    data() {
        return {
            mxCurrencyFormat : new Intl.NumberFormat('en-US', {style: 'currency', currency: 'USD'}),
            localOrder: {}
        }
    },
    computed:{
        ...mapState({
            quotedOrder: state => state.ordersModule.quotedOrder,
        }),
        computedIsDiferenMarketcar(){
            if((this.$route.name == 'StepTwoDetails' || this.$route.name == 'StepThreeChoose' || this.$route.name == 'StepFourNetpay' || this.$route.name == 'StepFourSpei') && !this.isFromDialog){
                return false
            }
            return true
        }
    },
    methods:{
        squareMeters(width, height){
            let resultWidhtXHeight = 0;
            if(width < 1 && height < 1){
                resultWidhtXHeight = 1;
                return resultWidhtXHeight;
            }else if(width < 1){
                resultWidhtXHeight = 1 * height;
                return resultWidhtXHeight.toFixed(3);
            }else if(height < 1){
                resultWidhtXHeight = 1 * width;
                return resultWidhtXHeight.toFixed(3);
            }else{
                resultWidhtXHeight = height * width;
                return resultWidhtXHeight.toFixed(3);
            }
        },
        methodDeleteBlind(itemBlindID){
            this.$emit('emitDeleteBlindFromDetailCards', itemBlindID);
        },
        methodEditBlind(){
            this.$emit('emitEditBlindFromBlindsProductDetailCardsView', this.localOrder.id);
        }
    },
    props:{
      idOrder: {
          type: Number,
      },
      isFromDialog: {
        default: false,
        type: Boolean
      }
    }
}
</script>
