<template>
  <div>
      <v-container fluid>
          <div class="text-center text-uppercase my-2" style="font-size: 1.5rem">
              <span>Carrito de compra </span><span class="font-weight-bold" style="color: #3ba2a9">Orden</span>
              <div style="color: red">(¡EN CONSTRUCCION! DISCULPE LAS MOLESTIAS)</div>
          </div>
          <v-row class="mt-3">
              <v-col v-if="$vuetify.breakpoint.mdAndUp" cols="12" xl="3" lg="3" md="3" sm="3">
                <v-card
                style="position: sticky; top: 60px; z-index: 2;"
                  height="auto"
                  width="auto"
                  outlined
                  class="rounded-lg"
                >
                  <v-navigation-drawer color="grey lighten-3" height="auto" width="auto" permanent>
                    <v-list-item style="background-color: #3ba2a9">
                      <v-list-item-content>
                        <v-list-item-title class="white--text font-weight-bold" style="font-size: 1.3rem">
                          Mi cuenta
                        </v-list-item-title>
                      </v-list-item-content>
                    </v-list-item>


                    <v-list
                    >
                      <v-list-item>
                        <v-list-item-title>{{navigationDrawerItems[0].title}}</v-list-item-title>
                      </v-list-item>

                      <v-list-group
                        v-for="item in computedNavigationDrawerItemsWithChild"
                        :key="item.title"
                        v-model="item.active"
                        no-action
                      >
                        <template v-slot:activator>
                          <v-list-item-content>
                            <v-list-item-title v-text="item.title"></v-list-item-title>
                          </v-list-item-content>
                        </template>

                        <v-list-item
                          v-for="child in item.childItems"
                          :key="child.title"
                        >
                          <v-list-item-content>
                            <v-list-item-title style="font-size: 0.80rem" v-text="child.title"></v-list-item-title>
                          </v-list-item-content>
                        </v-list-item>
                      </v-list-group>
                      <v-list-item>
                        <v-list-item-title>{{navigationDrawerItems[3].title}}</v-list-item-title>
                      </v-list-item>
                    </v-list>
                  </v-navigation-drawer>
                </v-card>
              </v-col>
              <v-col cols="12" xl="9" lg="9" md="9" sm="12">
                  <v-row align="center" no-gutters>
                      <v-col cols="3" v-for="(item, index) in marketStepsItems" :key="index">
                        <v-alert
                            @click="changeStepWindowFromAlerts((index+1))"
                            class="mx-1"
                            :color="(index+1) == localWindowStepModel ? 'orange darken-1' : 'grey lighten-2'"
                        >
                            <div :class="(index+1) == localWindowStepModel ? 'font-weight-bold white--text' : 'font-weight-bold black--text'" style="font-size: 2rem">{{index + 1}}  </div><div :class="(index+1) == localWindowStepModel ? 'white--text' : 'black--text'" style="font-size: 1.2rem">{{item.title}}</div>
                        </v-alert>
                      </v-col>
                  </v-row>
                  <v-row class="mt-n5">
                      <v-col cols="12" xl="9" lg="9" md="9" sm="12" order="2" order-xl="1" order-lg="1" order-md="1" order-sm="2">
                        <div v-if="localWindowStepModel == 1" class="text-start text-uppercase mb-2" style="font-size: 1.4rem;">
                            <span class="font-weight-bold" style="color: #3ba2a9">Órdenes </span><span>pendientes de pago</span>
                        </div>
                        <div v-else-if="localWindowStepModel == 3" class="text-start text-uppercase mb-2" style="font-size: 1.4rem;">
                            <v-row no-gutters>
                                <span class="font-weight-bold" style="color: #3ba2a9">Producto </span><span style="color: #3ba2a9">(s)</span>
                                <v-spacer></v-spacer>
                                <span>#Orden <span class="font-weight-bold" style="color: #3ba2a9"> P010821/100</span></span>
                            </v-row>
                        </div>
                        <div v-else-if="localWindowStepModel == 4" class="text-start text-uppercase mb-2" style="font-size: 1.4rem;">
                            <v-row no-gutters>
                                <span class="font-weight-bold" style="color: #3ba2a9">Pagar orden</span>
                                <v-spacer></v-spacer>
                                <span>#Orden <span class="font-weight-bold" style="color: #3ba2a9"> P010821/100</span></span>
                            </v-row>
                        </div>
                        <div class="pa-4" style="border: 1px solid #BDBDBD">
                          <v-img
                            contain
                            min-height="195"
                            src="/img/dashboard/cart-outline.png"
                          >

                            <!-- ESTE WINDOW INICIA AQUÍ Y HARÁ LA FUNCION DE LOS PASOS DE COMPRA -->
                            <v-window v-model="localWindowStepModel">
                                <v-window-item v-for="(item, windowIndex) in 4" :key="windowIndex" :value="(windowIndex+1)">
                                <!-- DENTRO DE ESTE WINDOW ITEM SE CARGARÁ EL COMPONENTE DE PASO CORRESPONDIENTE -->
                                    <!-- INICIA CARGA EL COMPONENTE DEL STEP 1 -->
                                    <OrdersCardsStepOne v-if="localWindowStepModel == 1"></OrdersCardsStepOne>
                                    <!-- TERMINA CARGA EL COMPONENTE DEL STEP 1 -->
                                </v-window-item>
                            </v-window>
                            <!-- ESTE WINDOW TERMINA AQUÍ Y HARÁ LA FUNCION DE LOS PASOS DE COMPRA -->

                          </v-img>
                          <!-- <h3 class="text-h6 font-weight-light mb-2 text-center">
                            El carrito de compras está vacio
                          </h3> -->
                        </div>
                        <div class="text-end">
                            <v-btn
                                large
                              color="#3ba2a9"
                              class="white--text rounded-lg mt-3"
                            >
                            <v-icon
                            size="30"
                                  left
                                  dark
                                >
                                  mdi-delete
                            </v-icon>Vaciar carrito
                            </v-btn>
                        </div>
                      </v-col>
                      <v-col cols="12" xl="3" lg="3" md="3" sm="12" order="1" order-xl="2" order-lg="2" order-md="2" order-sm="1" :style="!$vuetify.breakpoint.mdAndUp ? 'position: sticky; top: 15px; z-index: 2;' : ''" >
                        <v-card
                        :style="$vuetify.breakpoint.mdAndUp ? 'position: sticky; top: 60px; z-index: 2;' : ''"
                        class="rounded-lg"
                        :class="$vuetify.breakpoint.mdAndUp ? 'mt-10 ' : 'mt-5'"
                            outlined
                        >
                          <div class="white--text text-center font-weight-bold pa-3 rounded-lg" style="background-color: #3ba2a9">Resumen de la orden de la compra</div>
                          <v-row align="center" no-gutters>
                          <v-col cols="12" xl="12" lg="12" md="12" sm="4">
                              <v-row class="pa-3" style="font-size: 0.87rem">
                                  <v-col cols="5">
                                      <div>Subtotal: </div>
                                  </v-col>
                                  <v-col cols="7">
                                      <div class="text-end">$0.00 MXN</div>
                                  </v-col>
                                  <v-col cols="5" class="mt-n5">
                                      <div>I.V.A. </div>
                                  </v-col>
                                  <v-col cols="7" class="mt-n5">
                                      <div class="text-end">INCLUIDO</div>
                                  </v-col>
                              </v-row>
                          </v-col>
                          <v-col cols="12" xl="12" lg="12" md="12" sm="4" style="background-color: #B2DFDB">
                            <v-col cols="12" style="background-color: #B2DFDB">
                                <div class="text-end font-weight-bold" style="color: #3ba2a9; font-size: 1.45rem">
                                      $0.00 MXN
                                </div>
                            </v-col>
                            <v-col cols="12" style="background-color: #B2DFDB" class="mt-n6">
                                <div class="text-uppercase text-end">
                                    Total
                                </div>
                            </v-col>
                          </v-col>
                          <v-col cols="12" xl="12" lg="12" md="12" sm="4">
                            <v-checkbox
                            v-if="localWindowStepModel == 4"
                            class="mx-3 mb-n5"
                            v-model="checkboxPrivacyTermsAndContinue"
                            label="He leído y estoy de acuerdo con el Aviso de Privacidad">
                            </v-checkbox>
                            <v-card-actions>
                              <v-btn
                                v-if="localWindowStepModel > 0 && localWindowStepModel < 4"
                                :disabled="(localWindowStepModel >= 3) ? false : true"
                                large
                                block
                                color="orange darken-1"
                                class="white--text font-weight-bold rounded-lg mx-auto mt-3"
                                :class="localWindowStepModel <= 3 ? '' : 'mb-7'"
                              >
                                {{btnContinuarTitle}}
                                  <v-icon
                                  size="30"
                                    right
                                    dark
                                  >
                                    mdi-arrow-right
                                  </v-icon>
                              </v-btn>
                              <v-btn
                                v-else-if="(localWindowStepModel == 4)"
                                :disabled="((localWindowStepModel == 4) && checkboxPrivacyTermsAndContinue) ? false : true"
                                large
                                block
                                color="orange darken-1"
                                class="white--text font-weight-bold rounded-lg mx-auto mt-3"
                                :class="localWindowStepModel <= 3 ? '' : 'mb-7'"
                              >
                                {{btnContinuarTitle}}
                                  <v-icon
                                  size="30"
                                    right
                                    dark
                                  >
                                    mdi-arrow-right
                                  </v-icon>
                              </v-btn>
                            </v-card-actions>
                            <div v-if="localWindowStepModel <= 3" class="text-decoration-underline text-center mt-n1 mb-4" style="font-size: 0.77rem">Agregar otra persiana</div>
                          </v-col>
                          </v-row>
                        </v-card>
                      </v-col>
                  </v-row>
              </v-col>
          </v-row>
      </v-container>
  </div>
</template>

<script>
import OrdersCardsStepOne from '../../components/Dashboard/Marketcar/OrdersCardsStepOne.vue'
export default {
    data() {
        return {
            checkboxPrivacyTermsAndContinue: false,
            localWindowStepModel: 1,
            navigationDrawerItems: [
                { title: 'Mi perfil', icon: 'mdi-view-dashboard' },
                { title: 'Órdenes',
                  childItems: [
                    { title: 'Mis Órdenes' },
                    { title: 'Órdenes Distribuidores' }
                  ],
                  active: false,
                  icon: 'mdi-image' },
                { title: 'Cotizaciones',
                  childItems: [
                    { title: 'Mis Cotizaciones' },
                    { title: 'Cotizaciones Distribuidores' }
                  ],
                  active: false,
                  icon: 'mdi-help-box' },
                { title: 'Mis compras', icon: 'mdi-help-box' },
            ],
            marketStepsItems: [
                { title: 'Elegir producto(s)', icon: 'mdi-numeric-1' },
                { title: 'Cotizar producto(s)', icon: 'mdi-numeric-2' },
                { title: 'Revisar y pagar', icon: 'mdi-numeric-3' },
                { title: 'Confirmar compra', icon: 'mdi-numeric-4' },
            ],
        }
    },
    methods:{
        changeStepWindowFromAlerts(index){
            if(index <= 4 && index != this.localWindowStepModel){
                this.localWindowStepModel = index;
            }
        }
    },
    computed:{
        computedNavigationDrawerItemsWithChild(){
            return [{...this.navigationDrawerItems[1]}, {...this.navigationDrawerItems[2]}]
        },
        btnContinuarTitle(){
            return this.localWindowStepModel == 4 ? 'Pagar' : 'Continuar';
        }
    },
    components:{
        OrdersCardsStepOne
    }
}
</script>
