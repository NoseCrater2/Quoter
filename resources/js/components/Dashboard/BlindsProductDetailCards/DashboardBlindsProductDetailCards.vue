<template>
  <v-card outlined>
      <v-row no-gutters>
          <v-col cols="1" class="text-uppercase font-weight-bold text-center" style="color: #47a5ad; background-color: #E0E0E0; writing-mode: tb-rl; transform: rotate(-180deg);">
                <div class="mr-7">
                    Persiana 1
                </div>
          </v-col>
          <v-col cols="8" class="text-uppercase">
              <div style="font-size: 0.65rem">
                  <div>
                      <span>{{localComputedOrder[0].type}} // {{localComputedOrder[0].manufacturer}}</span>
                      <span>{{localComputedOrder[0].line != null ? ' // '+localComputedOrder[0].line : ''}}</span>
                      <span>{{localComputedOrder[0].variant2 != null ? ' // [1. '+$store.getters.getVariant(localComputedOrder[0].variant).name+'] y [2. '+$store.getters.getVariant(localComputedOrder[0].variant2).name+'] // ' : ' // '+$store.getters.getVariant(localComputedOrder[0].variant).name+' // '}}</span>
                      <span>{{localComputedOrder[0].second_color != null ? localComputedOrder[0].color.color+' // '+localComputedOrder[0].second_color.color+' //' : localComputedOrder[0].color.color+' //'}}</span>
                      <span>{{localComputedOrder[0].cloth_holder != null ? 'CON '+localComputedOrder[0].cloth_holder+' //' : ''}}</span>
                      <span v-for="(canva, index) in localComputedOrder[0].canvas" :key="index">
                          <span>{{localComputedOrder[0].canvas.length > 1 ? '(L'+(index + 1)+') Ancho: '+canva.width+'m - Alto: '+canva.height+'m // ' : 'Ancho: '+canva.width+'m - Alto: '+canva.height+'m // '}}</span>
                      </span>
                      <span>{{localComputedOrder[0].extraEnrollable > 0 ? 'Cargo extra: $'+localComputedOrder[0].extraEnrollable+'.00 MXN // ' : ''}}</span>
                      <span>{{localComputedOrder[0].extraVertical > 0 ? 'Cargo extra: $'+localComputedOrder[0].extraVertical+'.00 MXN // ' : ''}}</span>
                  </div>
                  <div>
                      <span>{{localComputedOrder[0].celular_type != null ? localComputedOrder[0].celular_type+' // '+localComputedOrder[0].celular_drive+' // ' : ''}}</span>

                      <!-- ESTE PANEL IMPRIME 0 EN EL SHOWRESOURCE (CENTRAL a 0) -->
                      <span>{{localComputedOrder[0].motor.selected_panel != null ? localComputedOrder[0].motor.selected_panel+' // PANELES: '+localComputedOrder[0].motor.panels+' // ' : ''}}</span>


                      <span v-if="localComputedOrder[0].motor_type != null">
                          {{localComputedOrder[0].motor_type+' // '+localComputedOrder[0].motor.side_control+' // '+localComputedOrder[0].motor.manufacturer+' // '}}
                          <span>{{localComputedOrder[0].motor.instalation_side != null ? localComputedOrder[0].motor.instalation_side+' // '+localComputedOrder[0].motor.rail_color+' // ' : ''}}</span>
                      </span>
                      <span>{{localComputedOrder[0].motor.frame != null ? localComputedOrder[0].motor.frame+' // ' : ''}}</span>
                      <span>{{localComputedOrder[0].instalation_side != null ? localComputedOrder[0].instalation_side+' // ' : ''}}</span>
                      <span>{{localComputedOrder[0].motor.drive != null ? localComputedOrder[0].motor.drive+' // ' : ''}}</span>
                      <span v-if="localComputedOrder[0].motor.string_type != null">
                          {{localComputedOrder[0].motor.control_color+' '}}
                          <span>{{localComputedOrder[0].motor.stringPrice > 0 ? localComputedOrder[0].motor.manufacturer+' (+$'+localComputedOrder[0].motor.stringPrice+') // ' : ' // '}}</span>
                          {{localComputedOrder[0].motor.string_type+' // '}}
                      </span>
                      <span>{{localComputedOrder[0].motor.height_control ? localComputedOrder[0].motor.height_control+' MTS // ' : ''}}</span>
                      <span v-if="localComputedOrder[0].motor.gallery != null">
                          <span>{{localComputedOrder[0].motor.gallery_color != null ? localComputedOrder[0].motor.gallery_color+' // ' : ''}}</span>
                          {{localComputedOrder[0].motor.gallery.model+' '}}
                          <span>{{localComputedOrder[0].motor.galleryPrice > 0 ? '(+$'+localComputedOrder[0].motor.galleryPrice+') // ' : '(+$'+localComputedOrder[0].motor.gallery.price+') // '}}</span>
                      </span>

                        <!-- ¿ES NORMAL QUE APAREZCA UN 0 EN LA MOTORIZACION? -->
                      <span v-if="localComputedOrder[0].motor.motor != 0 && localComputedOrder[0].motor.motor != null">
                          <span>
                              {{$store.getters.getMotor(localComputedOrder[0].motor.motor).system+' // '+$store.getters.getMotor(localComputedOrder[0].motor.motor).motorizationType+' // '+$store.getters.getMotor(localComputedOrder[0].motor.motor).manufacturer+' '}}
                              <span>{{$store.getters.getMotor(localComputedOrder[0].motor.motor).price > 0 ? '(+$'+$store.getters.getMotor(localComputedOrder[0].motor.motor).price+') // ' : '// '}}</span>
                          </span>
                      </span>


                      <span v-if="localComputedOrder[0].motor.control != null">
                          {{localComputedOrder[0].motor.control.description+' '}}
                          <span>{{localComputedOrder[0].motor.control.price > 0 ? '(+$'+localComputedOrder[0].motor.control.price+') // ' : ' // '}}</span>
                      </span>
                      <span>{{localComputedOrder[0].motor.flexiballetPrice > 0 ? '(+$'+localComputedOrder[0].motor.flexiballetPrice+')' : ''}}</span>
                  </div>
                  <div>
                      <span>Precio (m2): {{localComputedOrder[0].price}} MXN // Descuento: {{user.discount_percent}} % // M2: {{localComputedOrder[0].canvas[0].width * localComputedOrder[0].canvas[0].height}} //</span>
                      <span>
                          Precio con Descto: $ {{methodUnitaryPriceDiscount(user.discount_percent)}} MXN
                      </span>
                  </div>

              </div>
          </v-col>
          <v-col cols="3">
              <v-col cols="12">
                  <v-row no-gutters v-if="localComputedOrder[0].second_color != null" justify="end">
                      <v-col cols="6">
                          <v-img class="ml-auto" min-width="70" max-width="70" min-height="70" max-height="70" :src="'/img/modelos/medium/'+localComputedOrder[0].type+'/'+localComputedOrder[0].manufacturer+'/'+localComputedOrder[0].color.code+'.jpg'" ></v-img>
                      </v-col>
                      <v-col cols="6" class="text-end">
                          <v-img class="ml-auto" min-width="70" max-width="70" min-height="70" max-height="70" :src="'/img/modelos/medium/'+localComputedOrder[0].type+'/'+localComputedOrder[0].manufacturer+'/'+localComputedOrder[0].second_color.code+'.jpg'" ></v-img>
                      </v-col>
                  </v-row>
                  <v-row no-gutters v-else justify="end">
                      <v-col cols="6">
                          <v-img class="ml-auto" min-width="70" max-width="70" min-height="70" max-height="70" :src="'/img/modelos/medium/'+localComputedOrder[0].type+'/'+localComputedOrder[0].manufacturer+'/'+localComputedOrder[0].color.code+'.jpg'" ></v-img>
                      </v-col>
                  </v-row>
              </v-col>
              <v-col cols="12" class="text-end text-uppercase font-weight-bold" style="background-color: #E0E0E0;">
                  <div>
                      <span>Total: </span>
                      <span style="color: #47a5ad;">
                          {{mxCurrencyFormat.format(
                              methodTotalCanvasPrice(user.discount_percent) +
                              parseFloat(localComputedOrder[0].motor.price) +
                              parseFloat(localComputedOrder[0].motor.flexiballetPrice) +
                              parseFloat(localComputedOrder[0].motor.galleryPrice) +
                              parseFloat(localComputedOrder[0].motor.manufacturerPrice) +
                              parseFloat(localComputedOrder[0].motor.stringPrice) +
                              parseFloat(localComputedOrder[0].extraVertical) +
                              parseFloat(localComputedOrder[0].extraEnrollable)
                          )}} MXN
                      </span>
                  </div>
              </v-col>
          </v-col>
      </v-row>
  </v-card>
</template>

<script>
import {mapState} from 'vuex';
export default {
    mounted(){
        this.$store.dispatch('getQuotedOrder', 33).then(()=>{
            // console.log(this.quotedOrders)
            console.log(this.quotedOrder.blinds)
        });
    },
    data() {
        return {
            mxCurrencyFormat : new Intl.NumberFormat('en-US', {style: 'currency', currency: 'USD'}),
        }
    },
    computed:{
        ...mapState({
            orders: state => state.ordersModule.orders,
            quotedOrders: state => state.ordersModule.quotedOrders,
            quotedOrder: state => state.ordersModule.quotedOrder,
            quotingOrders: state => state.ordersModule.quotingOrders,
            user: (state) => state.user,
        }),
        localComputedOrder(){
            return this.quotedOrder.blinds;
        },
    },
    methods:{
        methodUnitaryPriceDiscount(localDiscount){
            return this.quotedOrder.blinds[0].price - ((localDiscount / 100) * this.quotedOrder.blinds[0].price)
        },
        methodTotalCanvasPrice(localDiscount){
            let localPrice = 0;
            this.quotedOrder.blinds[0].canvas.forEach(canva=>{
                localPrice += ((parseFloat(canva.width) * parseFloat(canva.height)) * this.methodUnitaryPriceDiscount(localDiscount));
            })
            return parseFloat(localPrice);
        }
    }

}
</script>
