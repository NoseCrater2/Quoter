<template>
  <v-container id="quoter">
      <v-dialog
        persistent
        v-model="pdfDialog"
        width="auto"
      >
        <v-card height="100%">
          <v-toolbar
            dark
            color="#47a5ad"
          >
            <v-btn
              icon
              dark
              @click="closePdfDialog()"
            >
              <v-icon>mdi-close</v-icon>
            </v-btn>
            <v-spacer></v-spacer>
            <v-toolbar-items>
                <v-btn
                  icon
                  class="white--text"
                  :disabled="(zoomPdf < 100) ? false : true"
                    @click="editPdfZoom('plus')"
                >
                  <v-icon>mdi-magnify-plus</v-icon>
                </v-btn>

                <v-btn
                  icon
                  class="white--text"
                  :disabled="(zoomPdf == 0) ? true : false"
                    @click="editPdfZoom('minus')"
                >
                  <v-icon>mdi-magnify-minus</v-icon>
                </v-btn>

              <v-btn
                dark
                @click="downloadButtonPdfAuth()"
              >
              <v-icon>mdi-arrow-collapse-down</v-icon>
              </v-btn>
            </v-toolbar-items>
          </v-toolbar>
          <v-col cols="12" class="d-flex justify-center">
            <pdf :src="urlPdfVisor" style="height: 100%"  :style="`width: ${zoomPdf}%`">
            </pdf>
          </v-col>
        </v-card>
      </v-dialog>
    <v-row justify="center" align="center">
      <v-card style="background-color: #ffffffc2">
        <v-card-title style="color: white" :style="editable?'background-color: red;':'background-color: #404042;'">
          {{ cardTitle }}
          {{ typeof order.id == 'undefined'?'':order.id }}

          <v-spacer></v-spacer>
          <div>
            TOTAL: {{mxCurrencyFormat.format(totalPrice) }} MXN
          </div >
        </v-card-title>
        <v-form ref="form" v-model="valid" lazy-validation class="my-4 mx-4">
          <v-row>
            <v-col class="pa-1" cols="6">
              <span style="font-size: 1em"> 1.Seleccione tipo de persiana</span>

              <v-autocomplete
                :rules="[(v) => !!v || 'Requerido']"
                @change="chargeTypeModels(order.type)"
                hide-details
                dense
                :items="getProduct ? getProduct.types : []"
                item-text="name"
                item-value="slug"
                v-model="order.type"
                label="Selecciona tu persiana"
                outlined
                color="#47a5ad"
                background-color="white"
                class="ma-1"
              ></v-autocomplete>
              <v-autocomplete
                v-if="getType && order.type != 'vertical'"
                :rules="[(v) => !!v || 'Requerido']"
                hide-details
                dense
                :items="getType.lines"
                item-text="name"
                item-value="slug"
                v-model="order.manufacturer"
                label="Selecciona la Línea"
                outlined
                color="#47a5ad"
                background-color="white"
                class="ma-1"
              ></v-autocomplete>
              <div v-if="order.type != 'celular' && order.type != 'horizontal-madera-2' && order.type != 'horizontal-aluminio-2' ">
              <v-autocomplete
                v-if="getType && getType.weaves.length > 0"
                :rules="[(v) => !!v || 'Requerido']"
                @change="chargeModels()"
                hide-details
                dense
                :items="getType.weaves"
                item-text="name"
                item-value="slug"
                v-model="order.line"
                label="Selecciona Material"
                outlined
                color="#47a5ad"
                background-color="white"
                class="ma-1"

              ></v-autocomplete>
              <div v-if="order.type == 'vertical'">
              <v-radio-group
              row
              :mandatory="false"
              v-model="order.cloth_holder"
              :append-icon="order.cloth_holder != null?'mdi-close-circle':undefined"
              @click:append="order.cloth_holder = null"
              >
                <v-radio  label="Con galería PVC"  color="#47a5ad" value="Galería PVC"></v-radio>
                <v-radio  label="Con galería Portatela"  color="#47a5ad" value="Galería Portatela"></v-radio>
              </v-radio-group>
              </div>

              <span style="font-size: 1em"> 2.Seleccione características</span>
              <v-autocomplete
                class="ma-1"
                hide-details
                :rules="[(v) => !!v || 'Requerido']"
                :loading="loadingModels"
                dense
                v-model="order.variant"
                :items="variants"
                item-text="name"
                item-value="slug"
                @change="chargeColors()"
                outlined
                color="#47a5ad"
                background-color="white"
                label="Modelo"
              ></v-autocomplete>
              <v-autocomplete
                v-if="order.type != 'horizontal-aluminio-1' && order.type != 'horizontal-aluminio-2'"
                class="ma-1"
                hide-details
                :rules="[(v) => !!v || 'Requerido']"
                :loading="loadingColors"
                :disabled="disabledSelectColor"
                dense
                return-object
                v-model="order.color"
                :items="colors"
                item-text="color"
                outlined
                @change="selectColor(order.color)"
                color="#47a5ad"
                background-color="white"
                label="Color"
              ></v-autocomplete>

              <v-switch
                v-if="showRotate"
                class="ml-5"
                v-model="order.rotate"
                label="Rotar"
              ></v-switch>
              <div v-if="order.type=='flexibalet'">
                <span style="font-size: 1em">3.Seleccione las medidas.</span>
                <v-text-field
                color="#47a5ad"
                class="ma-1"
                dense
                hide-details
                label="Ancho"
                outlined
                :placeholder="widthMargins"
                :rules="[
                  ...flexiballetWidthRules()]"
                suffix="mts"
                v-model.number="order.canvas[0].width"
                ></v-text-field>
                <v-text-field
                color="#47a5ad"
                class="ma-1"
                dense
                hide-details=""
                label="Alto"
                 outlined
                 :placeholder="heightMargins"
                :rules="[
                  ...flexiballetHeightRules()]"
                suffix="mts"
                v-model.number="order.canvas[0].height"
                ></v-text-field>
              </div>


              <div v-else>
                <span style="font-size: 1em">
                  3.Seleccione las medidas (El mínimo a cobrar es 1.0 x
                  1.0)</span>
                <v-text-field

                  :disabled="disabledSelectSize"
                  dense
                  type="number"
                  label="Ancho"
                  class="ma-1"
                  :placeholder="widthMargins"
                  outlined
                  color="#47a5ad"
                  background-color="white"
                  v-model.number="order.canvas[0].width"
                  :rules="[
                  buttonCanvasRules(maxwidth, 0),
                    ...widthCanvasRules(getType ? getType.min_width : 0, maxwidth,0)
                  ]"
                  :messages="extraEnrollableRule(0)"
                ></v-text-field>

                <v-text-field

                  class="ma-1"
                  hide-details
                  :disabled="disabledSelectSize"
                  :rules="[
                    ...heightCanvasRules(getType ? getType.min_height : 0, maxheight,0),
                  ]"
                  dense
                  type="number"
                  label="Alto"
                  background-color="white"
                  :placeholder="heightMargins"
                  outlined
                  color="#47a5ad"

                  v-model.number="order.canvas[0].height"
                ></v-text-field>
              </div>
              <div >
               <v-btn
               v-if="showButtonDialog"
               color="#47a5ad"
               dark
               small
               block
               @click="openCanvasDialog">
               <v-icon left>mdi-plus</v-icon>
               Añadir más lienzos
               </v-btn>
              </div>
              <div v-if="order.type == 'sheer' || order.type == 'triple-shade-sangri-la' || order.type == 'romantic'">
                <span style="font-size: 1em">
                  4.Elige el tipo de instalación
                </span>
                <v-radio-group
                :rules="[(v) => !!v || 'Requerido']"
                row
                :mandatory="false"
                v-model="order.instalation_side"
                >
                  <v-radio label="A techo"  color="#47a5ad" value="techo"></v-radio>
                  <v-radio label="A pared"  color="#47a5ad" value="pared"></v-radio>
                </v-radio-group>
              </div>
              <span style="font-size: 1em" v-if="order.type == 'sheer' || order.type == 'triple-shade-sangri-la' || order.type == 'romantic'">
                5.Seleccione modo de accionamiento (opcional)
              </span>
               <span v-else style="font-size: 1em">
                4.Seleccione modo de accionamiento (opcional)
              </span>
              <v-radio-group
              :disabled="(order.canvas[0].height != null && order.canvas[0].width != null)?false:true"
              row
              :mandatory="false"
              v-model="order.motor_type"
              >
                <v-radio @click="openMotorizationDialog" label="Manual"  color="#47a5ad" value="Manual"></v-radio>
                <v-radio
                v-if="order.type != 'horizontal-aluminio-1' && order.type != 'horizontal-aluminio-2' && order.type != 'vertical'"
                @click="openMotorizationDialog"
                label="Motorizado"
                color="#47a5ad"
                value="Motorizado">
                </v-radio>
              </v-radio-group>
              <div v-if="user != null">
                <span style="font-size: 1em" class="font-weight-bold">
                  Agregue un cargo por instalación (opcional)</span>
                <v-text-field
                  min="0"
                  :value="0"
                  dense
                  type="number"
                  label="Cargo por instalación"
                  class="ma-1"
                  hide-details
                  placeholder="0.00"
                  outlined
                  color="#47a5ad"
                  background-color="white"
                  v-model.number="order.installmentCharge"
                ></v-text-field>
              </div>
              </div>
               <div  v-else-if="order.type == 'celular'">
                <v-item-group  v-model="order.celular_type" @change="showMargins" >
                    <span>2. Selecciona el tipo de persiana celular que quieres</span>
                    <v-row >
                      <v-col
                        cols="12"
                        md="4"
                        sm="12"
                        v-for="celular in celulares"
                        :key="celular.title">
                        <v-item v-slot="{ active, toggle }" :value="celular.title">
                            <v-card
                              width="120"
                              flat
                              height="120"
                              :style="active?'border: 2px solid #47a5ad':''"
                            >




                            <div class="d-flex  justify-space-around">
                              <div>
                                <v-img
                               style="margin-top:10px"
                                @click="toggle"
                                max-height="75"
                                max-width="90"
                                :src="celular.img"

                              >
                              </v-img>
                              <div>
                                 {{ celular.title }}
                              </div>
                              </div>

                            </div>
                            </v-card>
                        </v-item>
                      </v-col>
                    </v-row>
                  </v-item-group>

              </div>

              <div v-else-if="order.type === 'horizontal-madera-2' || order.type === 'horizontal-aluminio-2'">
                 <!-- && order.type === 'horizontal-aluminio-2' -->
                <v-alert dense outlined color="orange" v-if="order.motor_type == 'Motorizado'">
                  Para persiana motorizada el accionamiento solo es posible con escalerilla.
                </v-alert>
                <span>2. Seleccione modo de accionamiento</span>
                <v-radio-group
                @change="chargeWoodPrices"
                row
                :mandatory="false"
                v-model="order.motor_type">
                  <v-radio  label="Manual"  color="#47a5ad" value="Manual"></v-radio>
                  <v-radio
                  label="Motorizado"
                  color="#47a5ad"
                  value="Motorizado">
                  </v-radio>
                </v-radio-group>

                <span style="font-size: 1em" >
                3. Selecciona accionamiento
                </span>
                <v-radio-group
                :rules="[(v) => !!v || 'Requerido']"
                row
                :mandatory="false"
                v-model="order.motor.drive">
                  <v-radio label="Escalerilla"  color="#47a5ad" value="escalerilla"></v-radio>
                  <v-radio v-if="order.motor_type != 'Motorizado'" label="Cinta"  color="#47a5ad" value="cinta"></v-radio>
                </v-radio-group>

                  <span >4. Seleccione el lado del mando o motor</span>
                  <v-radio-group
                  row
                  @change="disabledWoodText = false"
                  :mandatory="false"
                  :rules="[(v) => !!v || 'Requerido']"
                  v-model="order.motor.side_control">
                <v-radio color="#47a5ad" label="Izquierdo" value="Izquierdo"></v-radio>
                <v-radio color="#47a5ad" label="Derecho" value="Derecho"></v-radio>
              </v-radio-group>
              <span style="font-size: 1em">
                  5.Seleccione las medidas</span>
                <v-text-field
                dense
                type="number"
                label="Ancho"
                class="ma-1"
                hide-details
                :disabled="disabledWoodText"
                :placeholder="widthMargins"
                outlined
                color="#47a5ad"
                background-color="white"
                v-model.number="order.canvas[0].width"
                :rules="[
                  ...widthWoodRules(),
                ]"
                ></v-text-field>

                <v-text-field
                class="ma-1"
                hide-details
                :disabled="disabledWoodText"
                :rules="[
                  ...heightWoodRules(),
                ]"
                dense
                type="number"
                label="Alto"
                background-color="white"
                :placeholder="heightMargins"
                outlined
                color="#47a5ad"
                v-model.number="order.canvas[0].height"
                ></v-text-field>
                 <span style="font-size: 1em">
                  6.Marco
                </span>
                <v-radio-group
                style="max-width: 244px;"
                @click:append="order.motor.frame = null"
                :append-icon="order.motor.frame?'mdi-close-circle':undefined"
                row
                v-model="order.motor.frame">
                  <v-radio label="Fuera"  color="#47a5ad" value="fuera"></v-radio>
                  <v-radio label="Adentro"  color="#47a5ad" value="adentro"></v-radio>
                </v-radio-group>
                <v-autocomplete
                v-if="getType && getType.lines > 0"
                :rules="[(v) => !!v || 'Requerido']"
                @change="chargeModels()"
                hide-details
                dense
                :items="lines"
                item-text="name"
                item-value="slug"
                v-model="order.line"
                label="Selecciona Material"
                outlined
                color="#47a5ad"
                background-color="white"
                class="ma-1"

              ></v-autocomplete>
               <span style="font-size: 1em"> 7.Seleccione características</span>
              <v-autocomplete
              class="ma-1"
              hide-details
              :rules="[(v) => !!v || 'Requerido']"
              :loading="loadingModels"
              dense
              v-model="order.variant"
              :items="variants"
              item-text="name"
              item-value="slug"
              @change="chargeColors()"
              outlined
              color="#47a5ad"
              background-color="white"
              label="Modelo"
              ></v-autocomplete>
              <div v-if="user != null">
                <span style="font-size: 1em" class="font-weight-bold">
                  Agregue un cargo por instalación (opcional)</span>
                <v-text-field
                  min="0"
                  :value="0"
                  dense
                  type="number"
                  label="Cargo por instalación"
                  class="ma-1"
                  hide-details
                  placeholder="0.00"
                  outlined
                  color="#47a5ad"
                  background-color="white"
                  v-model.number="order.installmentCharge"
                ></v-text-field>
              </div>
              </div>
            </v-col>

            <v-col class="pa-1" cols="6">
              <div v-if="order.type == null || order.type != 'celular'">
               <v-hover  v-slot="{ hover }">
                <v-img
                max-height="328"
                max-width="328"
                v-if="(order.type === 'horizontal-aluminio-1' || order.type === 'horizontal-aluminio-2' || order.type === 'horizontal-madera-2') && order.variant != null"
                :src=" `/img/modelos/medium/${order.type}/${order.manufacturer}/${$store.getters.getVariant(order.variant, order.type).image}.jpg`"
                >
                </v-img>
                <v-img
                v-else-if="order.color"
                max-height="328"
                max-width="328"
                :src=" `/img/modelos/medium/${order.type}/${$store.getters.getVariant(order.variant, order.type).line.slug}/${order.color.code}.jpg`"
                >
                  <template v-slot:placeholder>
                    <v-img src="/img/modelos/medium-unavailable.jpg"></v-img>
                  </template>
                  <v-slide-y-transition>
                    <div v-if="hover && order.color.code" style="background-color: rgba(0,0,0,0.2)" class=" d-flex transition-fast-in-fast-out justify-center"  >
                       <v-btn icon dark @click="downloadImage(order.type, order.manufacturer, order.color.code)">
                         <v-icon>mdi-cloud-download</v-icon>
                      </v-btn>
                    </div>
                </v-slide-y-transition>
                </v-img>
                <v-img
                 max-height="328"
                  max-width="328"
                v-else src="/img/modelos/medium-unavailable.jpg">
                </v-img>

               </v-hover>

               <div class="ma-2">
               <div class="d-flex  justify-center">
                PERSIANA

               </div>
               <div v-if="order.type == 'horizontal-madera-2'" class="d-flex  justify-center overline" style="color: #47a5ad; font-size: 1.5em !important;line-height: normal;">
                  {{mxCurrencyFormat.format( roundToOneDecimal(findWoodPrice))}} MXN
               </div>

                <div v-else class="d-flex  justify-center overline" style="color: #47a5ad; font-size: 1.5em !important;line-height: normal;" >
                    {{mxCurrencyFormat.format(roundToOneDecimal(unitaryPrice) + parseFloat(extraEnrollablePrice) + parseFloat(extraVerticalPrice))}} MXN
                 </div>

               <v-divider></v-divider>
               <div class="d-flex  justify-center ">
                 MOTOR y CONTROL/GALERÍA:

               </div>
               <div class="d-flex justify-center overline" style="color: #47a5ad; font-size: 1.5em !important;line-height: normal;" >
                    {{mxCurrencyFormat.format(order.motor.price +
                          order.motor.flexiballetPrice +
                          order.motor.galleryPrice +
                          order.motor.manufacturerPrice +
                          order.motor.stringPrice)}}
                      MXN
                 </div>
                 </div>
              <div
                v-for="(c, index) in order.canvas"
                :key="index"
                class="d-flex flex-row my-1"
              >
                <v-chip
                  v-if="c.height != null"
                  color="#47a5ad"
                  text-color="white"
                >
                  <strong>Lienzo {{ index + 1 }}:</strong> &nbsp;
                  {{ c.width }}M(Ancho)&nbsp;
                  {{ c.height }}M (Alto)
                </v-chip>
              </div>

           </div>
           <div v-else>
             <span style="font-size: 1em">
                  3.Seleccione las medidas (El mínimo a cobrar es 1.0 x
                  1.0)</span>
                <v-text-field
                  dense
                  type="number"
                  label="Ancho"
                  class="ma-1"
                  hide-details
                  :disabled="!order.celular_type"
                  :placeholder="widthMargins"
                  outlined
                  color="#47a5ad"
                  background-color="white"
                  v-model.number="order.canvas[0].width"
                  :rules="[
                    ...widthCelularRules(order.celular_type),
                  ]"
                ></v-text-field>

                <v-text-field
                  class="ma-1"
                  hide-details
                  :disabled="!order.celular_type"
                  :rules="[
                    ...heightCelularRules(order.celular_type),
                  ]"
                  dense
                  type="number"
                  label="Alto"
                  background-color="white"
                  :placeholder="heightMargins"
                  outlined
                  color="#47a5ad"
                  v-model.number="order.canvas[0].height"
                ></v-text-field>
                 <span>4. Seleccione modo de accionamiento</span>
                  <v-radio-group
                  :disabled="!order.canvas[0].width && !order.canvas[0].height"
                  row
                  :mandatory="false"
                  :rules="[(v) => !!v || 'Requerido']"
                  v-model="order.celular_drive">
                    <v-radio @click="openCelularDialog"  color="#47a5ad" label="Muelle" value="Muelle"></v-radio>
                    <v-radio @click="openCelularDialog"  color="#47a5ad" label="Cordón" value="Cordón"></v-radio>
                    <v-radio @click="openCelularDialog"  color="#47a5ad" label="Motor" value="Motor"></v-radio>
                </v-radio-group>

              <div v-if="user != null">
                <span style="font-size: 1em" class="font-weight-bold">
                  Agregue un cargo por instalación (opcional)</span>
                <v-text-field
                  min="0"
                  :value="0"
                  dense
                  type="number"
                  label="Cargo por instalación"
                  class="ma-1"
                  hide-details
                  placeholder="0.00"
                  outlined
                  color="#47a5ad"
                  background-color="white"
                  v-model.number="order.installmentCharge"
                ></v-text-field>
              </div>

                <v-row v-if="order.celular_drive == 'Muelle' && order.motor.frame != null" no-gutters justify="center" align="center">
                  <v-col cols="12" md="6" sm="12">
                    <v-img
                    src="/img/cotizador/celulares/MuelleDiaNoche.png"
                    v-if="order.celular_type == 'Día y Noche'">
                    </v-img>
                    <v-img
                    src="/img/cotizador/celulares/MuelleMuelle.png"
                     v-if="order.celular_type == 'Muelle'">
                     </v-img>
                  </v-col>
                  <v-col cols="12" md="6" sm="12" >
                    <div class="d-block" style="color: #47a5ad">
                      Muelle
                    </div>
                    <div class="d-block">
                      Operación manual
                    </div>
                    <div class="d-block" style="font-size: 10px">
                     *La imagen es ilustrativa
                    </div>
                  </v-col>
                </v-row>
                <div>
                    <div class="d-flex  justify-center">
                        PERSIANA
                    </div>
                    <div class="d-flex  justify-center overline" style="color: #47a5ad; font-size: 1.5em !important;line-height: normal;" >
                        {{mxCurrencyFormat.format(roundToOneDecimal(unitaryPrice) + parseFloat(extraEnrollablePrice) + parseFloat(extraVerticalPrice))}} MXN
                    </div>

                    <v-divider></v-divider>

                    <div class="d-flex  justify-center ">
                         MOTOR y CONTROL/GALERÍA:
                    </div>
                    <div v-if="order.motor.motor > 0 && order.motor.control == null" class="d-flex justify-center overline" style="color: #47a5ad; font-size: 1.5em !important;line-height: normal;" >
                         {{mxCurrencyFormat.format($store.getters.getMotor(order.motor.motor).price)}} MXN
                    </div>
                    <div v-else-if="order.motor.motor == 0 && order.motor.control != null" class="d-flex justify-center overline" style="color: #47a5ad; font-size: 1.5em !important;line-height: normal;" >
                         {{mxCurrencyFormat.format(order.motor.control.price)}} MXN
                    </div>
                    <div v-else-if="order.motor.control != null && order.motor.motor > 0" class="d-flex justify-center overline" style="color: #47a5ad; font-size: 1.5em !important;line-height: normal;" >
                         {{mxCurrencyFormat.format(parseFloat($store.getters.getMotor(order.motor.motor).price) + parseFloat(order.motor.control.price))}} MXN
                    </div>
                </div>

           </div>
            </v-col>


          </v-row>
          <v-row no-gutters>
            <v-col cols="12" md="4" sm="12">
              <v-btn
              color="#d87c01"
              @click="addBlind()"
              depressed
              dark
              block
              tile
              class="mb-1"
              >{{ btnOrderTitle }}
              </v-btn>
              <v-btn
              class="mt-1"
              tile
              v-if="editable"
              color="red"
              small
              @click="cancelEdit()"
              depressed
              dark
              >CANCELAR EDICIÓN
              </v-btn>

              <v-btn
              color="red"
              @click="deleteAllBlinds()"
              depressed
              dark
              block
              tile
              class="mb-1"
              v-if="orders.length > 0"
              >Nuevo pedido
              </v-btn>

            </v-col>
            <v-col cols="12" md="4" sm="12" class="my-1 text-center">
               <v-tooltip top>
                  <template v-slot:activator="{ on, attrs }">
                    <v-btn
                      :disabled="(orders.length > 0 && !isPrintRolluxQuotingPDF) ? false: true"
                      :loading="isPrintRolluxQuotingPDF"
                      small
                      v-bind="attrs"
                      v-on="on"
                      color="#47a5ad"
                      fab
                      @click="openPDFView"
                    >
                      <v-icon color="white">mdi-printer</v-icon>
                    </v-btn>
                  </template>
                  <span>Imprimir</span>
                </v-tooltip>

                <v-tooltip top>
                  <template v-slot:activator="{ on, attrs }">
                    <v-btn @click="dialogSendEmail = true" small v-bind="attrs" v-on="on" color="#47a5ad" :disabled="orders.length > 0 ? false: true" fab>
                      <v-icon color="white">mdi-email-send</v-icon>
                    </v-btn>
                  </template>
                  <span>Enviar por Email</span>
                </v-tooltip>
            </v-col>
            <v-col v-if="orders.length > 0" cols="12" md="4" sm="12">
               <v-btn class="mb-2"  block @click="saveOrders" dark depressed  color="#3ca927">
                 Realizar pedido
              </v-btn>
              <v-btn class="mt-2"  block @click="saveQuotations" dark depressed outlined color="#3ca927">
                 Guardar cotización
              </v-btn>
            </v-col>
          </v-row>
        </v-form>

        <v-dialog v-if="getType && order.motor_type" v-model="dialogMotorization" persistent max-width="600" >
          <MotorizationDialog
          @saveMotorization="saveMotorization"
          @CloseMotorizationDialog="CloseMotorizationDialog"
          :typeName="getType.name"
          :parentMotor="order.motor"
          :action="order.motor_type"
          :canvas="order.canvas.length"
          :canvases="order.canvas"
          :line="order.line"
          />
        </v-dialog >
        <QuotedBlinds
        @editOrder="editOrder"
        @deleteOrder="deleteOrder"
        />

      </v-card>
    </v-row>
    <v-row>
      <v-dialog v-model="canvasDialog" persistent max-width="600">
        <v-form ref="canvasForm" lazy-validation>
          <v-card>
            <v-card-title class="mb-n7">
                <v-spacer></v-spacer>
                <v-btn
                  icon
                  @click="closeCanvasForm"
                >
                  <v-icon>mdi-close</v-icon>
                </v-btn>
            </v-card-title>
            <v-card-title>
              Indique ancho alto para cada lienzo
              <v-spacer></v-spacer>
              ${{
                parseFloat((Math.round(unitaryPrice * 10) / 10) + parseFloat(extraEnrollablePrice)).toFixed(2)
              }}
              MXN
            </v-card-title>

            <v-card-text>
              <v-row >
                <v-col
                  cols="12"

                  v-for="c in order.canvas.length"
                  :key="c"
                >
                  <v-card flat>
                    <v-row no-gutters>
                      <v-col cols="12" md="6" sm="12">
                        <div >
                        <span>Lienzo {{ c }}</span>
                        <v-img
                          max-width="255"
                          src="/img/cotizador/canvas.png"
                        >
                        <v-row no-gutters>
                          <v-col md="6" offset="6">
                            <v-input style="margin-top: 70px; margin-left:65px;">
                              {{ order.canvas[c - 1].height || '0.0'}} mts
                            </v-input>

                          </v-col>
                        </v-row>
                     <v-row no-gutters>
                       <v-col cols="3" offset="5">
                         <v-input style="margin-top: 15px;">
                             {{ order.canvas[c - 1].width || '0.0' }} mts
                          </v-input>

                       </v-col>
                     </v-row>
                    </v-img>
                    </div>
                      </v-col>
                      <v-col cols="12" md="6" sm="12" style="margin-top: auto" >
                        <div >
                        <v-text-field
                          :placeholder="heightMargins"
                          v-model.number="order.canvas[c - 1].height"
                          :rules="[
                            ...heightCanvasRules(
                              getType ? getType.min_height : 0,
                              maxheight,
                              c - 1
                            ),
                          ]"
                          style="max-width: 255px"
                          label="alto"
                          outlined
                          type="number"

                          dense
                        ></v-text-field>
                          <v-text-field
                          style="max-width: 255px"
                          v-model.number="order.canvas[c - 1].width"
                          :rules="[
                            ...widthCanvasRules(
                              getType ? getType.min_width : 0,
                              maxwidth,
                              c - 1
                            ),
                          ]"
                          label="ancho"

                          outlined
                          :placeholder="widthMargins"
                          type="number"

                          dense
                        ></v-text-field>
                      </div>
                      </v-col>
                    </v-row>
                  </v-card>
                  <v-divider class="ma-2"></v-divider>
                </v-col>
              </v-row>
            </v-card-text>
            <v-card-actions>
              <v-btn
                      outlined
                      v-if="order.canvas.length < 3"
                      @click="addCanvas"
                      color="#47a5ad"
                      >Añadir lienzo</v-btn
                    >
                    <v-spacer></v-spacer>
                    <v-btn
                      outlined
                      v-if="order.canvas.length > 1"
                      @click="deleteCanvas()"
                      color="#47a5ad"
                      >Eliminar último lienzo</v-btn>
            </v-card-actions>
            <v-card-actions>
                <v-btn dark color="red" @click="closeCanvasForm">CANCELAR</v-btn>
                <v-spacer></v-spacer>
              <v-btn dark color="#47a5ad" @click="validateCanvas">ACEPTAR</v-btn>
            </v-card-actions>
          </v-card>
        </v-form>
      </v-dialog>
      <v-dialog v-model="celularDialog" persistent max-width="600">
        <v-form ref="celularForm" >
          <v-card>
            <v-card-title style="font-style: Italic; color:#47a5ad;">
              Persiana Celular {{order.celular_type}}
            </v-card-title>
            <v-card-subtitle>
              <div class="d-inline" style="font-style: Italic;">
                Tipo de sistema
              </div>
              <div class="d-inline" style="font-style: Italic; color:#47a5ad;">
                ({{order.celular_drive}})
              </div>

            </v-card-subtitle>
            <v-row class="mx-3" v-if="order.celular_type == 'Muelle/Cordón'" >

              <v-col class="pa-0" cols="6" >
                <div v-if="order.celular_drive == 'Muelle'">
                  <span class="ma-1 font-weight-black">Muelle implica operación manual</span>
                  <v-img
                  src="/img/cotizador/celulares/Sistema Muelle.png"
                  max-height="328"
                  max-width="328">
                  </v-img>
                  <div class="font-italic font-weight-thin text--disabled" style="font-family: Arial; font-size: 12px">
                    Imagen ilustrativa, NO se selecciona.
                  </div>
                </div>
                <div v-if="order.celular_drive == 'Motor' || order.celular_drive == 'Cordón'">
                <span>5. Seleccione el lado del mando o motor</span>
                <v-radio-group :rules="[(v) => !!v || 'Requerido']" row v-model="order.motor.side_control">
                <v-radio  label="Izquierdo"  color="#47a5ad" value="Izquierdo"></v-radio>
                <v-radio  label="Derecho"  color="#47a5ad" value="Derecho"></v-radio>
              </v-radio-group>
              </div>
              <div class="mt-6" style="font-size: 1em"> 6.Seleccione características</div>
              <v-autocomplete
                class="ma-1"
                hide-details
                :rules="[(v) => !!v || 'Requerido']"
                dense
                v-model="order.variant"
                :items="variants"
                item-text="name"
                item-value="slug"
                @change="chargeColors()"
                outlined
                color="#47a5ad"
                background-color="white"
                label="Modelo"
              ></v-autocomplete>
              <v-autocomplete
                class="ma-1"
                hide-details
                :rules="[(v) => !!v || 'Requerido']"
                :loading="loadingColors"
                :disabled="disabledSelectColor"
                dense
                return-object
                v-model="order.color"
                :items="colors"
                item-text="color"
                outlined
                @change="selectColor(order.color)"
                color="#47a5ad"
                background-color="white"
                label="Color"
              ></v-autocomplete>
                <span style="font-size: 1em">
                  7. Marco
                </span>
                <v-radio-group
                style="max-width: 244px;"
                @click:append="order.motor.frame = null"
                :append-icon="order.motor.frame?'mdi-close-circle':undefined"
                :disabled="disabledFrameRadio"
                row
                v-model="order.motor.frame"
                @change="disabledCommentText = false"
                >
                  <v-radio label="Fuera"  color="#47a5ad" value="fuera"></v-radio>
                  <v-radio label="Adentro"  color="#47a5ad" value="adentro"></v-radio>
                </v-radio-group>

              </v-col>
              <v-col cols="6">
                <v-hover  v-slot="{ hover }">
                  <v-img
                    v-if="order.color"
                    max-height="328"
                    max-width="328"
                    :src=" `/img/modelos/medium/${order.type}/${order.manufacturer}/${order.color.code }.jpg`"
                  >
                    <template v-slot:placeholder>
                      <v-img src="/img/modelos/medium-unavailable.jpg"></v-img>
                    </template>
                    <v-slide-y-transition>
                      <div v-if="hover && order.color.code" style="background-color: rgba(0,0,0,0.2)" class=" d-flex transition-fast-in-fast-out justify-center"  >
                         <v-btn icon dark @click="downloadImage(order.type, order.manufacturer, order.color.code)">
                           <v-icon>mdi-cloud-download</v-icon>
                        </v-btn>
                      </div>
                    </v-slide-y-transition>
                  </v-img>
                  <v-img
                    max-height="328"
                    max-width="328"
                    v-else src="/img/modelos/medium-unavailable.jpg">
                  </v-img>
               </v-hover>
              </v-col>
            </v-row>
            <v-row class="mx-3" v-if="order.celular_type == 'Día y Noche' ">
              <v-col class="pa-0" >
                <div v-if="order.celular_drive == 'Motor' || order.celular_drive == 'Cordón'">
                <span>5. Seleccione el lado del mando o motor</span>
                <v-radio-group :rules="[(v) => !!v || 'Requerido']" row v-model="order.motor.side_control">
                <v-radio  label="Izquierdo"  color="#47a5ad" value="Izquierdo"></v-radio>
                <v-radio  label="Derecho"  color="#47a5ad" value="Derecho"></v-radio>
              </v-radio-group>
              </div>
                <span  style="font-size: 1em"> 6.Seleccione características</span>
                <v-autocomplete
                  class="ma-1"
                  hide-details
                  :rules="[(v) => !!v || 'Requerido']"

                  dense
                  v-model="order.celular_variant"
                  :items="celular_variants"
                  item-text="title"
                  return-object
                  @change="chargeCelularColors()"
                  outlined
                  color="#47a5ad"
                  background-color="white"
                  label="Modelo"
                ></v-autocomplete>
                <div>
                  <span>Color-</span>
                  <span style="color: #47a5ad">Día</span>
                </div>
                <v-autocomplete
                  class="ma-1"
                  :disabled="disabledSelectColor"
                  hide-details
                  :rules="[(v) => !!v || 'Requerido']"
                  :loading="loadingColors"
                  dense
                  return-object
                  v-model="order.color"
                  :items="colors"
                  item-text="color"
                  outlined
                  color="#47a5ad"
                  background-color="white"
                  label="Color"
                  @change="order.second_color != null?disabledFrameRadio = false:true"
                ></v-autocomplete>
                <v-hover  v-slot="{ hover }">
                  <v-img
                    v-if="order.color"
                    max-height="328"
                    max-width="328"
                    :src=" `/img/modelos/medium/${order.type}/${order.manufacturer}/${order.color.code }.jpg`"
                  >
                    <template v-slot:placeholder>
                      <v-img src="/img/modelos/medium-unavailable.jpg"></v-img>
                    </template>
                    <v-slide-y-transition>
                      <div v-if="hover && order.color.code" style="background-color: rgba(0,0,0,0.2)" class=" d-flex transition-fast-in-fast-out justify-center"  >
                         <v-btn icon dark @click="downloadImage(order.type, order.manufacturer, order.color.code)">
                           <v-icon>mdi-cloud-download</v-icon>
                        </v-btn>
                      </div>
                    </v-slide-y-transition>
                  </v-img>
                  <v-img
                    max-height="328"
                    max-width="328"
                    v-else src="/img/modelos/medium-unavailable.jpg">
                  </v-img>
               </v-hover>

              </v-col>
              <v-col >
                <div :style="order.celular_drive == 'Motor' || order.celular_drive == 'Cordón'?'margin-top: 140px':'margin-top: 50px'">
                <div>
                  <span>Color-</span>
                  <span style="color: #47a5ad">Noche</span>
                </div>
                <v-autocomplete
                  class="ma-1"
                  hide-details
                  :rules="[(v) => !!v || 'Requerido']"
                  :disabled="disabledSelectColor"
                  :loading="loadingColors"
                  dense
                  return-object
                  v-model="order.second_color"
                  :items="colors2"
                  item-text="color"
                  outlined
                  color="#47a5ad"
                  background-color="white"
                  label="Color"
                  @change="order.color != null?disabledFrameRadio = false:true"
                ></v-autocomplete>
                </div>
                <v-hover  v-slot="{ hover }">
                  <v-img
                    v-if="order.second_color"
                    max-height="328"
                    max-width="328"
                    :src=" `/img/modelos/medium/${order.type}/${order.manufacturer}/${order.second_color.code }.jpg`"
                  >
                    <template v-slot:placeholder>
                      <v-img src="/img/modelos/medium-unavailable.jpg"></v-img>
                    </template>
                    <v-slide-y-transition>
                      <div v-if="hover && order.second_color.code" style="background-color: rgba(0,0,0,0.2)" class=" d-flex transition-fast-in-fast-out justify-center"  >
                         <v-btn icon dark @click="downloadImage(order.type, order.manufacturer, order.second_color.code)">
                           <v-icon>mdi-cloud-download</v-icon>
                        </v-btn>
                      </div>
                    </v-slide-y-transition>
                  </v-img>
                  <v-img
                    max-height="328"
                    max-width="328"
                    v-else src="/img/modelos/medium-unavailable.jpg">
                  </v-img>
               </v-hover>
              </v-col>
              <v-col cols="12">
                <span style="font-size: 1em">
                  7 .Marco
                </span>
                <v-radio-group
                style="max-width: 244px;"
                @click:append="order.motor.frame = null"
                :append-icon="order.motor.frame?'mdi-close-circle':undefined"
                @change="disabledCommentText = false"
                :disabled="disabledFrameRadio"
                row
                v-model="order.motor.frame"
                >
                  <v-radio label="Fuera"  color="#47a5ad" value="fuera"></v-radio>
                  <v-radio label="Adentro"  color="#47a5ad" value="adentro"></v-radio>
                </v-radio-group>
              </v-col>
            </v-row>
            <v-row class="mx-3" no-gutters>
              <v-col cols="12" v-if="order.celular_drive === 'Motor'">
                <span>
                    8. Seleccione motor
                  </span>
                  <v-select
                    outlined
                    color="#47a5ad"
                    clearable
                    clear-icon="mdi-close-circle"
                    label="Motor"
                    :items="celularMotors"
                    item-text="system"
                    item-value="id"
                    v-model="order.motor.motor"
                    placeholder="Sin Control"
                  ></v-select>
                  <span>
                    9. Seleccione características de control (opcional)
                  </span>
                  <v-select
                    outlined
                    color="#47a5ad"
                    clearable
                    clear-icon="mdi-close-circle"
                    label="Canal(es) de Control Remoto"
                    :items="controls"
                    item-text="description"
                    return-object
                    v-model="order.motor.control"
                    placeholder="Sin Control"
                  ></v-select>
              </v-col>
              <v-col  cols="12">
                <v-textarea
                :disabled="disabledCommentText"
                v-model="order.motor.comment"
                color="#47a5ad"
                outlined
                height="100"
                label="Observaciones"
                ></v-textarea>
              </v-col>
            </v-row>
            <v-card-actions>
              <v-btn dark @click="validateCelularDialog" color="#47a5ad">
                GUARDAR
              </v-btn>
              <v-spacer></v-spacer>
              <v-btn dark @click="resetCelularAttributes" color="red">
                CANCELAR
              </v-btn>
            </v-card-actions>
          </v-card>
        </v-form>
      </v-dialog>

       <v-dialog v-model="flexibaletExtraDialog" persistent max-width="390">
        <v-card>
          <v-card-subtitle style="color: #47a5ad" class="pa-4">
            Motorizar las persianas FLEXIBALET añadirá un costo extra de $25,500.00 MXN a la cotización.
          </v-card-subtitle>
          <v-card-title class="px-4 py-0 justify-center">
            ¿DESEA CONTINUAR?
          </v-card-title>

          <v-divider></v-divider>
          <v-card-actions>
            <v-btn text color="red" @click="flexibaletExtraDialog = false">NO</v-btn>
            <v-spacer></v-spacer>
            <v-btn text @click="openMotorizationDialogConfirm()"  color="#47a5ad">SÍ</v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>

       <v-dialog v-model="beforePrint" persistent max-width="390">
        <v-card>
          <v-card-title class="px-4 py-0 justify-center">
           No has iniciado sesión
          </v-card-title>
          <v-card-subtitle style="color: #47a5ad; text-align: center" class="pa-4" >
            ¿Iniciar sesión para generar una impresión personalizada?
          </v-card-subtitle>
          <v-divider></v-divider>
          <v-card-actions>

            <v-btn block text @click="redirectToLogin"  color="#47a5ad">INICIAR SESIÓN</v-btn>
          </v-card-actions>
           <v-divider></v-divider>
          <v-card-actions>
          <v-btn block text @click="printRolluxQuoting">IMPRIMIR SIN INICIAR SESIÓN</v-btn>
          </v-card-actions>
           <v-divider></v-divider>
          <v-card-actions>
          <v-btn block text @click="beforePrint = false"  color="red">CANCELAR</v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>

      <v-dialog v-model="sellerPrint" persistent max-width="390">
        <v-card>
          <v-card-title class="px-4 py-2 justify-center">
           Opciones de impresión
          </v-card-title>
          <v-card-text>
              <v-card-actions>
                  <v-row justify="space-between">
                      <v-col cols="12" class="mb-n8">
                        <v-btn :disabled="isPrintingSuperAdminUserPDF" color="#47a5ad" small fab v-if="showUserForm || showUserSelectDialog" @click="fnArrowLeftFromPrintOptions">
                          <v-icon color="white">
                              mdi-arrow-left
                          </v-icon>
                        </v-btn>

                        <p style="font-size: 1rem;" class="text-uppercase text-center font-weight-bold">{{showUserSelectDialog ? 'Seleccionar distribuidor' : showUserForm ? 'Distribuidor no registrado' : ''}}</p>
                      </v-col>
                      <v-col cols="4" class="d-flex flex-column align-center">
                        <v-btn ref="btnShowUserSelectDialog" :disabled="isPrintRolluxQuotingPDF" color="#47a5ad" fab @click="showUserSelectDialog = true" v-if="!showUserForm && !showUserSelectDialog">
                          <v-icon color="white">
                              mdi-account
                          </v-icon>
                        </v-btn>
                        <div v-if="!showUserForm && !showUserSelectDialog" style="font-size: 0.85rem; line-height: 15px;" class="text-center font-weight-bold mt-1">Seleccionar distribuidor</div>
                      </v-col>
                      <v-col cols="4" class="d-flex flex-column align-center">
                        <v-btn ref="btnShowUserForm" :disabled="isPrintRolluxQuotingPDF" color="#47a5ad" fab @click="showUserForm = true" v-if="!showUserForm && !showUserSelectDialog">
                            <v-icon color="white">
                              mdi-plus
                          </v-icon>
                        </v-btn>
                        <div v-if="!showUserForm && !showUserSelectDialog" style="font-size: 0.85rem; line-height: 15px;" class="text-center font-weight-bold mt-1">Distribuidor no registrado</div>
                      </v-col>
                      <v-col cols="4" class="d-flex flex-column align-center">
                        <v-btn color="#47a5ad" :loading="isPrintRolluxQuotingPDF" :disabled="isPrintRolluxQuotingPDF" fab @click="printRolluxQuoting" v-if="(showUserForm==false) && (showUserSelectDialog == false) && (!enableBtnPrintLogInAdmin)">
                          <v-icon color="white">
                              mdi-printer
                          </v-icon>
                        </v-btn>
                        <div v-if="!showUserForm && !showUserSelectDialog" style="font-size: 0.85rem; line-height: 15px;" class="text-center font-weight-bold mt-1">Imprimir sin distribuidor</div>
                      </v-col>
                  </v-row>
              </v-card-actions>
            <v-autocomplete
            :disabled="isPrintingSuperAdminUserPDF"
            v-if="showUserSelectDialog"
            :items="distributors"
            class="mt-4"
            prepend-inner-icon="mdi-account"
            item-text="name"
            return-object
            @change="fnOnChangeResetObjectSelectedUser"
            v-model="selectedUser"
            label="Selecciona un usuario registrado"
            outlined
            color="#47a5ad"
            background-color="white">
              <template v-slot:selection="data">
                <v-chip
                small
                v-bind="data.attrs"
                :input-value="data.selected"
                >
                  {{ data.item.name+' '+ data.item.last_name}}
                </v-chip>
              </template>
              <template v-slot:item="data">
                <template>
                  <v-list-item-content>
                    <v-list-item-title>{{data.item.name +' '+ data.item.last_name}}</v-list-item-title>
                    <v-list-item-subtitle>{{data.item.discount_percent + '% '+data.item.company}}</v-list-item-subtitle>
                  </v-list-item-content>
                </template>
              </template>
            </v-autocomplete>
          <v-form ref="userForm" :disabled="isPrintingSuperAdminUserPDF" v-show="showUserForm" class="mt-4">
            <v-text-field
            prepend-inner-icon="mdi-account"
            outlined
            dense
            :rules="[(v) => !!v || 'Requerido']"
            v-model="selectedUser.name"
            label="Nombre"
            ></v-text-field>
            <v-text-field
            prepend-inner-icon="mdi-account"
            outlined
            dense
            :rules="[(v) => !!v || 'Requerido']"
            v-model="selectedUser.last_name"
            label="Apellidos"
            ></v-text-field>
            <v-text-field
            prepend-inner-icon="mdi-sale"
            outlined
            dense
            :rules="[(v) => !!v || 'Requerido']"
            v-model="selectedUser.discount_percent"
            type="number"
            label="Descuento"
            ></v-text-field>
            <v-text-field
            prepend-inner-icon="mdi-phone"
            outlined
            dense
            v-model="selectedUser.phone"
            label="Telefono"
            ></v-text-field>
            <v-text-field
            prepend-inner-icon="mdi-email"
            outlined
            dense
            v-model="selectedUser.email"
            label="Email"
            ></v-text-field>
            <v-text-field
            prepend-inner-icon="mdi-account"
            outlined
            dense
            v-model="selectedUser.rfc"
            label="RFC"
            ></v-text-field>
            <v-text-field
            prepend-inner-icon="mdi-domain"
            outlined
            dense
            v-model="selectedUser.company"
            label="Nombre de la empresa"
            ></v-text-field>
            <v-text-field
            prepend-inner-icon="mdi-truck"
            outlined
            dense
            v-model="selectedUser.ship_address"
            label="Dirección de envío"
            ></v-text-field>
          </v-form>
          </v-card-text>
          <v-divider></v-divider>
          <v-card-actions>
          <v-btn tile depressed @click="fnCancelFromPrintOptions" color="red" class="white--text">CANCELAR</v-btn>
          <v-spacer></v-spacer>
           <v-btn v-if="(showUserForm || showUserSelectDialog) && enableBtnPrintLogInAdmin" tile depressed :loading="isPrintingSuperAdminUserPDF" :disabled="isPrintingSuperAdminUserPDF" color="#47a5ad" @click="checkUserValid" class="white--text">IMPRIMIR</v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>


    <v-dialog v-model="distributorPrintDialog" persistent max-width="390">
        <v-card>
          <v-card-title class="px-4 py-2 justify-center">
           Opciones de impresión
          </v-card-title>
          <v-card-text>
              <v-card-actions>
                  <v-row justify="space-between">
                      <v-col v-if="showUserFormFromDistributorPrintDialog" cols="12" class="mb-n8">
                        <v-btn color="#47a5ad" small fab @click="closeDistributorPrintDialog()">
                          <v-icon color="white">
                              mdi-arrow-left
                          </v-icon>
                        </v-btn>

                        <p style="font-size: 1rem;" class="text-uppercase text-center font-weight-bold">{{showUserFormFromDistributorPrintDialog ? 'Imprimir para cliente' : ''}}</p>
                      </v-col>

                      <v-col v-if="!showUserFormFromDistributorPrintDialog" cols="4" class="d-flex flex-column align-center">
                        <v-btn ref="btnShowUserSelectDialog" color="#47a5ad" fab @click="methodPrintFromDistributorDialog('distributor')" :loading="isPrintinDistributorPDF" :disabled="(isPrintinDistributorPDF || isPrintRolluxQuotingPDF) ? true : false">
                          <v-icon color="white">
                              mdi-account
                          </v-icon>
                        </v-btn>
                        <div style="font-size: 0.85rem; line-height: 15px;" class="text-center font-weight-bold mt-1">Imprimir como distribuidor</div>
                      </v-col>
                      <v-col v-if="!showUserFormFromDistributorPrintDialog" cols="4" class="d-flex flex-column align-center">
                        <v-btn :loading="isPrintingSpecificClientFromDistributorDialog" :disabled="(isPrintinDistributorPDF || isPrintRolluxQuotingPDF || isPrintingSpecificClientFromDistributorDialog) ? true : false" color="#47a5ad" fab @click="showUserFormFromDistributorPrintDialog = true">
                          <v-icon color="white">
                              mdi-account
                          </v-icon>
                        </v-btn>
                        <div style="font-size: 0.85rem; line-height: 15px;" class="text-center font-weight-bold mt-1">Imprimir para cliente</div>
                      </v-col>
                      <v-col v-if="!showUserFormFromDistributorPrintDialog" cols="4" class="d-flex flex-column align-center">
                        <v-btn color="#47a5ad" fab @click="methodPrintFromDistributorDialog('everyone')" :loading="(isPrintRolluxQuotingPDF && !isPrintinDistributorPDF) ? true : false" :disabled="isPrintRolluxQuotingPDF">
                          <v-icon color="white">
                              mdi-printer
                          </v-icon>
                        </v-btn>
                        <div style="font-size: 0.85rem; line-height: 15px;" class="text-center font-weight-bold mt-1">Imprimir sin distribuidor</div>
                      </v-col>
                  </v-row>
              </v-card-actions>

          <v-form ref="userFormFromDistributorPrintDialog" :disabled="isPrintingSuperAdminUserPDF" v-show="showUserFormFromDistributorPrintDialog" class="mt-4">
            <v-text-field
            prepend-inner-icon="mdi-account"
            outlined
            dense
            :rules="[(v) => !!v || 'Requerido']"
            v-model="selectedUser.name"
            label="Nombre"
            ></v-text-field>
            <v-text-field
            prepend-inner-icon="mdi-account"
            outlined
            dense
            :rules="[(v) => !!v || 'Requerido']"
            v-model="selectedUser.last_name"
            label="Apellidos"
            ></v-text-field>
            <v-text-field
            prepend-inner-icon="mdi-sale"
            outlined
            dense
            :rules="[(v) => !!v || 'Requerido']"
            v-model="selectedUser.discount_percent"
            type="number"
            label="Descuento"
            ></v-text-field>
            <v-text-field
            prepend-inner-icon="mdi-phone"
            outlined
            dense
            v-model="selectedUser.phone"
            label="Telefono"
            ></v-text-field>
            <v-text-field
            prepend-inner-icon="mdi-email"
            outlined
            dense
            v-model="selectedUser.email"
            label="Email"
            ></v-text-field>
            <v-text-field
            prepend-inner-icon="mdi-account"
            outlined
            dense
            v-model="selectedUser.rfc"
            label="RFC"
            ></v-text-field>
            <v-text-field
            prepend-inner-icon="mdi-domain"
            outlined
            dense
            v-model="selectedUser.company"
            label="Nombre de la empresa"
            ></v-text-field>
            <v-text-field
            prepend-inner-icon="mdi-truck"
            outlined
            dense
            v-model="selectedUser.ship_address"
            label="Dirección de envío"
            ></v-text-field>
          </v-form>

          </v-card-text>
          <v-divider></v-divider>
          <v-card-actions>
          <v-btn tile depressed color="red" class="white--text" @click="closeDistributorPrintDialog('closeAndReset')">CANCELAR</v-btn>
          <v-spacer></v-spacer>
          <v-btn v-if="(showUserFormFromDistributorPrintDialog) && enableBtnPrintLogInAdmin" tile depressed color="#47a5ad" class="white--text" :loading="isPrintingSpecificClientFromDistributorDialog" :disabled="isPrintingSpecificClientFromDistributorDialog" @click="methodPrintFromDistributorDialog('client')">IMPRIMIR</v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>


      <v-dialog v-model="dialogSendEmail" persistent max-width="390">
        <v-card>
          <v-card-title class="px-4 py-2 justify-center">
           Enviar email
          </v-card-title>
          <v-card-text>
              <v-card-actions>
                  <v-row justify="space-between">
                      <v-col cols="12" class="mb-n8">
                        <v-btn @click="closeAndResetSendEmailDialog()" :disabled="(isSendindEmailToLoginMyAccount || isSendindEmailToAnotherAccount) ? true : false" color="#47a5ad" small fab v-if="showEmailFormFromDialog">
                          <v-icon color="white">
                              mdi-arrow-left
                          </v-icon>
                        </v-btn>
                        <p style="font-size: 1rem;" class="text-uppercase text-center font-weight-bold">{{showEmailFormFromDialog ? 'A otro email' : ''}}</p>
                      </v-col>
                      <v-col cols="6" class="d-flex flex-column align-center">
                        <v-btn :loading="isSendindEmailToLoginMyAccount" :disabled="(isSendindEmailToLoginMyAccount || isSendindEmailToAnotherAccount) ? true : false" @click="methodSendEmailFromDialog('myAccount')" v-if="!showEmailFormFromDialog" ref="btnShowUserSelectDialog" color="#47a5ad" fab>
                          <v-icon color="white">
                              mdi-account
                          </v-icon>
                        </v-btn>
                        <div v-if="!showEmailFormFromDialog" style="font-size: 0.85rem; line-height: 15px;" class="text-center font-weight-bold mt-1">A mi email</div>
                      </v-col>
                      <v-col cols="6" class="d-flex flex-column align-center">
                        <v-btn ref="btnShowUserForm" color="#47a5ad" fab @click="showEmailFormFromDialog = true" :disabled="(isSendindEmailToLoginMyAccount || isSendindEmailToAnotherAccount) ? true : false" v-if="!showEmailFormFromDialog">
                            <v-icon color="white">
                              mdi-email
                          </v-icon>
                        </v-btn>
                        <div v-if="!showEmailFormFromDialog" style="font-size: 0.85rem; line-height: 15px;" class="text-center font-weight-bold mt-1">A otro email</div>
                      </v-col>
                  </v-row>
              </v-card-actions>
          <v-form ref="dialogEmailForm" v-show="showEmailFormFromDialog" class="mt-4">

            <v-text-field
            prepend-inner-icon="mdi-account"
            outlined
            dense
            :rules="[(v) => !!v || 'Requerido']"
            v-model="selectedUser.name"
            label="Nombre"
            ></v-text-field>
            <v-text-field
            prepend-inner-icon="mdi-account"
            outlined
            dense
            :rules="[(v) => !!v || 'Requerido']"
            v-model="selectedUser.last_name"
            label="Apellidos"
            ></v-text-field>
            <v-text-field
            prepend-inner-icon="mdi-sale"
            outlined
            dense
            :rules="[(v) => !!v || 'Requerido']"
            v-model="selectedUser.discount_percent"
            type="number"
            label="Descuento"
            ></v-text-field>
            <v-text-field
            prepend-inner-icon="mdi-phone"
            outlined
            dense
            v-model="selectedUser.phone"
            label="Telefono"
            ></v-text-field>
            <v-text-field
            prepend-inner-icon="mdi-email"
            outlined
            dense
            v-model="selectedUser.email"
            label="Email"
            ></v-text-field>
            <v-text-field
            prepend-inner-icon="mdi-account"
            outlined
            dense
            v-model="selectedUser.rfc"
            label="RFC"
            ></v-text-field>
            <v-text-field
            prepend-inner-icon="mdi-domain"
            outlined
            dense
            v-model="selectedUser.company"
            label="Nombre de la empresa"
            ></v-text-field>
            <v-text-field
            prepend-inner-icon="mdi-truck"
            outlined
            dense
            v-model="selectedUser.ship_address"
            label="Dirección de envío"
            ></v-text-field>


          </v-form>
          </v-card-text>
          <v-divider></v-divider>
          <v-card-actions>
          <v-btn @click="closeAndResetSendEmailDialog('resetAndClose')" tile depressed color="red" class="white--text">CANCELAR</v-btn>
          <v-spacer></v-spacer>
           <v-btn v-if="(showEmailFormFromDialog) && enableBtnPrintLogInAdmin" :loading="isSendindEmailToAnotherAccount" :disabled="(isSendindEmailToLoginMyAccount || isSendindEmailToAnotherAccount) ? true : false" @click="methodSendEmailFromDialog('anotherAccount')" tile depressed color="#47a5ad" class="white--text">ENVIAR</v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>



    </v-row>
    <!-- <PreviewPDF :distributor="selectedUser"></PreviewPDF>
    <PreviewPdfRollux></PreviewPdfRollux> -->
      <v-snackbar
      v-model="savedBlindMessage"
      :timeout="2000"
      >
      <span class="ml-4">Cotización guardada</span>
       <template v-slot:action>
        <v-icon>mdi-check</v-icon>
        </template>
      </v-snackbar>
      <v-snackbar
      v-model="savedorderMessage"
      :timeout="2000"
      >
      <span class="ml-4">Orden guardada</span>
       <template v-slot:action>
        <v-icon>mdi-check</v-icon>
        </template>
      </v-snackbar>
  </v-container>
</template>

<script>

// import VueHtml2pdf from 'vue-html2pdf'
import { mapState } from "vuex";
import QuotedBlinds from './QuotedBlinds';
import MotorizationDialog from './MotorizationDialog';
import watermark from 'watermarkjs';
import woodMatrix from '../utils/woodMatrixOne';
import woodMotorized from '../utils/woodMatrixTwo';
// import PreviewPDF from '../views/PreviewPDF';
// import PreviewPdfRollux from '../views/PreviewPdfRollux';
const FileDownload = require('js-file-download');

import pdf from 'vue-pdf';

export default {
  name: "Quoter",
  data() {
    return {
        savedBlindMessage: false,
        savedorderMessage:false,
        isSendindEmailToAnotherAccount: false,
        isSendindEmailToLoginMyAccount: false,
        isPrintingSpecificClientFromDistributorDialog: false,
        showUserFormFromDistributorPrintDialog: false,
        showEmailFormFromDialog: false,
        dialogSendEmail: false,
        distributorPrintDialog: false,
        distributorImagePrint: null,
        isPrintinDistributorPDF: false,
        isPrintingSuperAdminUserPDF: false,
        isPrintRolluxQuotingPDF: false,
        urlPdfVisor: '',
        pdfDialog: '',
        numPdfPages: 0,
        zoomPdf: 100,
        downloadButtonPdf: null,
      cancelShowBtnUserForm: false,
      showBtnUserForm: true,
      showUserForm: false,
      showUserSelectDialog: false,
      selectedUser: {
        name: null,
        rfc: null,
        last_name: null,
        email: null,
        discount_percent: 0,
        phone: null,
        ship_address: null,
        company: null
      },
      sellerPrint: false,
      beforePrint: false,
      pdfComponentKey: 1,
      disabledWoodText: true,
      dialogKey :false,
      flexibaletExtraDialog: false,
      mxCurrencyFormat : new Intl.NumberFormat('en-US', {style: 'currency', currency: 'USD'}),
      disabledCelularText: true,
      disabledDriveRadio: true,
      disabledFrameRadio: true,
      disabledCommentText: true,
      celular_variants: [
        {title:'CELULAR BOLERO 25 MM (3.66 MM)', day: 'BOLERO TRASLUCIDA', night: 'BOLERO BLACKOUT'},
        {title:'CELULAR ROMANCE 25 MM (3.66 MM)', day: 'ROMANCE TRASLUCIDA', night: 'ROMANCE BLACKOUT'},
        {title:'CELULAR SOLIS 38 MM 118\'\' (3.00)', day: 'SOLIS TRASLUCIDA', night: 'SOLIS TRASLUCIDA'},
      ],
      celularDialog: false,
      celulares: [
        { title: "Día y Noche", img: "/img/cotizador/celulares/dianoche.png" },
        { title: "Muelle/Cordón", img: "/img/cotizador/celulares/Muelle.png" },
      ],
      flexibaletHeights:[],
      showButtonDialog: false,
      canvasDialog: false,
      panelSelected: 1,
      valid: true,
      selectedAgrupation: null,
      selectedAgrupation2: null,
      dialogMotorization: false,
      scHeight: screen.height,
      alertSuccess: false,
      editable: false,
      order: {
        type: this.$route.query.type || null,
        manufacturer: this.$route.query.manufacturer || null,
        celular_type: null,
        celular_drive: null,
        celular_variant: null,
        line: this.$route.query.line || null,
        variant: this.$route.query.variant || null,
        variant2: null,
        color: this.$route.query.color || null,
        second_color: null,
        canvas: [
          { width: null, height: null},
        ],
        instalation_side: null,
        cloth_holder: null,
        price: 0,
        discount_price: 0,
        installmentCharge: 0,
        rotate: false,
        motor_type: null,
        extraVertical: 0,
        extraEnrollable: 0,
        motor: {
          side_control: null,
          price: 0,
          action: null,
          type: null,
          canvas: 0,
          manufacturer: null,
          control: null,
          motor: 0,
          panels: 0,
          control_color: 0,
          selected_panel: 0,
          string_type: null,
          gallery: null,
          gallery_color: null,
          comment: null,
          instalation_side: null,
          frame: null,
          rail_color: null,
          drive: null,
          extra: 0,
          height_control: null,
          flexiballetPrice: 0,
          galleryPrice: 0,
          manufacturerPrice: 0,
          stringPrice: 0,
          extraEnrollable: 0,
          extraVertical: 0,

        },
      },
      defaultOrder: {
        type: null,
        manufacturer: null,
        celular_type: null,
        celular_drive: null,
        celular_variant: null,
        line: null,
        variant: null,
        variant2: null,
        color: null,
        second_color: null,
        canvas: [
          { width: null, height: null},
        ],
        instalation_side: null,
        cloth_holder: null,
        price: 0,
        discount_price: 0,
        installmentCharge: 0,
        rotate: false,
        motor_type: null,
        extraVertical: 0,
        extraEnrollable: 0,
        motor: {
          side_control: null,
          price: 0,
          action: null,
          type: null,
          canvas: 0,
          manufacturer: null,
          control: null,
          motor: 0,
          panels: 0,
          control_color: 0,
          selected_panel: 0,
          string_type: null,
          gallery: null,
          gallery_color: null,
          comment: null,
          instalation_side: null,
          frame: null,
          rail_color: null,
          drive: null,
          extra: 0,
          height_control: null,
          flexiballetPrice: 0,
          galleryPrice: 0,
          manufacturerPrice: 0,
          stringPrice: 0,
          extraEnrollable: 0,
          extraVertical: 0,
        },
      },
      heightMargins: null,
      widthMargins: null,
      disabledSelectModel: true,
      loadingModels: false,
      disabledSelectColor: true,
      loadingColors: false,
      disabledSelectSize: true,
      selected: null,

      defaultMotor: {
        side_control: null,
        price: 0,
        action: null,
        type: null,
        canvas: 0,
        manufacturer: null,
        control: null,
        motor: 0,
        panels: 0,
        control_color: 0,
        selected_panel: 0,
        string_type: null,
        gallery: null,
        gallery_color: null,
        comment: null,
        instalation_side: null,
        frame: null,
        rail_color: null,
        drive: null,
        extra: 0,
        height_control: null,
        flexiballetPrice: 0,
        galleryPrice: 0,
        manufacturerPrice: 0,
        stringPrice: 0,
        extraEnrollable: 0,
        extraVertical: 0,
      },

    };
  },
  methods: {
      fnCancelFromPrintOptions(){
        this.sellerPrint = false;
        this.resetSelectedUser('cancelar');
      },
      fnArrowLeftFromPrintOptions(){
        this.showUserForm = false;
        this.showUserSelectDialog = false;
        this.resetSelectedUser();
      },
      resetSelectedUser(stateDialog = 'default'){

        this.selectedUser = {
            name: null,
            rfc: null,
            last_name: null,
            email: null,
            discount_percent: 0,
            phone: null,
            ship_address: null,
            company: null
        }
        if(stateDialog == 'cancelar'){
            this.showUserForm = false;
            this.showUserFormFromDistributorPrintDialog = false;
            this.showUserSelectDialog = false;
            this.distributorPrintDialog = false;
        }
      },
      fnOnChangeResetObjectSelectedUser(objectLocalSelectedUser){
        if(objectLocalSelectedUser == null){
            this.resetSelectedUser();
        }
      },
    roundToOneDecimal (value ) {
      return Math.round(value * 10) / 10

    },

    downloadButtonPdfAuth(){
        FileDownload(this.downloadButtonPdf, 'modelos.pdf');
    },
    editPdfZoom(zoomState){
        if(zoomState == 'plus'){
            this.zoomPdf = this.zoomPdf + 10;
        }
        else if(zoomState == 'minus'){
            this.zoomPdf = this.zoomPdf - 10;
        }
    },
    closePdfDialog(){
        this.pdfDialog = false;
        this.downloadButtonPdf = null;
        this.urlPdfVisor = '';
        this.numPdfPages = 0;
    },
    checkUserValid(){
        this.isPrintingSuperAdminUserPDF = true;
      if(this.$refs.userForm.validate()){
        // this.$children[6].$refs.html2Pdf2.generatePdf()
        // axios.post("/api/auth-order-list-pdf-admins", {orders: this.orders, user: this.selectedUser, distributorImagePrint: false}, {responseType: 'blob',}).then((response)=>{
        //     this.isPrintingSuperAdminUserPDF = false;
        //     this.resetSelectedUser();
        //     //FileDownload(response.data, 'modelos.pdf')
        //     const objectUrl = URL.createObjectURL(response.data);
        //     this.urlPdfVisor = objectUrl;
        //     this.downloadButtonPdf = response.data;
        //     this.pdfDialog = true;
        //     this.sellerPrint = false
        // }).catch(()=>{
        //     this.isPrintingSuperAdminUserPDF = false;
        // })
        axios.post("/api/auth-order-list-pdf-distributor", {orders: this.orders, user: this.selectedUser}, {responseType: 'blob',}).then((response)=>{
            this.isPrintingSuperAdminUserPDF = false;
            this.resetSelectedUser('cancelar');
            //FileDownload(response.data, 'modelos.pdf')
            const objectUrl = URL.createObjectURL(response.data);
            this.urlPdfVisor = objectUrl;
            this.downloadButtonPdf = response.data;
            this.pdfDialog = true;
            this.sellerPrint = false
        }).catch(()=>{
            this.isPrintingSuperAdminUserPDF = false;
        })
      }
    },

    redirectToLogin(is_quotation = ''){
        if(is_quotation == 0 || is_quotation == 1){
            this.$router.push({name: 'login', query: {redirect: '/quoter', is_quotation: is_quotation}});
        }
        else{
            this.$router.push({name: 'login', query: {redirect: '/quoter'}});
        }
    },

    closeAndResetSendEmailDialog(option='reset'){
        this.showEmailFormFromDialog = false;
        this.isSendindEmailToLoginMyAccount = false;
        this.isSendindEmailToAnotherAccount = false;
        this.resetSelectedUser();
        if(option == 'resetAndClose'){
            this.dialogSendEmail = false;
        }
    },

    methodPrintDistributorSpecificClient(){
      this.isPrintingSpecificClientFromDistributorDialog = true;
      if(this.$refs.userFormFromDistributorPrintDialog.validate()){
        axios.post("/api/auth-order-list-pdf-distributor", {orders: this.orders, user: this.selectedUser}, {responseType: 'blob',}).then((response)=>{
            this.isPrintingSpecificClientFromDistributorDialog = false;
            this.resetSelectedUser('cancelar');
            this.closeDistributorPrintDialog('closeAndReset');
            //FileDownload(response.data, 'modelos.pdf')
            const objectUrl = URL.createObjectURL(response.data);
            this.urlPdfVisor = objectUrl;
            this.downloadButtonPdf = response.data;
            this.pdfDialog = true;
        }).catch(()=>{

        })
      }
    },


    methodPrintFromDistributorDialog(printTo){
        //distributor, client, everyone
        if(printTo == 'distributor'){
            this.dialogAcceptPrintPdfDistribuitor();
        }
        else if(printTo == 'client'){
            this.methodPrintDistributorSpecificClient();
        }
        else if(printTo == 'everyone'){
            this.printRolluxQuoting();
        }
    },
    methodSendEmailFromDialog(isSendTo){
        //myAccount and anotherAccount
        if(isSendTo == 'myAccount'){
            this.isSendindEmailToLoginMyAccount = true;
            // axios.post("/api/auth-order-list-pdf-distributor", {orders: this.orders, user: this.user}, {responseType: 'blob',}).then((response)=>{
            // const objectUrl = URL.createObjectURL(response.data);
            // FileDownload(response.data, 'fromEmail.pdf');
            // console.log(objectUrl);
            // this.closeAndResetSendEmailDialog('resetAndClose');
            // }).catch(()=>{

            // })
            axios.post("/api/send-order-email-pdf", {orders: this.orders, user: this.user}, {responseType: 'blob',}).then((response)=>{
            this.closeAndResetSendEmailDialog('resetAndClose');
            }).catch(()=>{
                this.isSendindEmailToLoginMyAccount = false;
            })

        }
        else if(isSendTo == 'anotherAccount'){
            this.isSendindEmailToAnotherAccount = true;
            axios.post("/api/send-order-email-pdf", {orders: this.orders, user: this.selectedUser}, {responseType: 'blob',}).then((response)=>{
            this.closeAndResetSendEmailDialog('resetAndClose');
            this.resetSelectedUser();
            }).catch(()=>{
                this.isSendindEmailToAnotherAccount = false;
            })
        }
    },

	  printRolluxQuoting(){
          this.isPrintRolluxQuotingPDF = true;
    //    this.$children[7].$refs.html2Pdf.generatePdf()
    axios.post("/api/order-list-pdf", this.orders, {responseType: 'blob',}).then((response)=>{
        this.isPrintRolluxQuotingPDF = false;
        const objectUrl = URL.createObjectURL(response.data);
            this.sellerPrint = false;
            this.urlPdfVisor = objectUrl;
            this.downloadButtonPdf = response.data;
            this.pdfDialog = true;
            this.closeDistributorPrintDialog();
    }).catch(()=>{
        this.isPrintRolluxQuotingPDF = false;
    })
    // this.$store.dispatch('printOrders', this.orders)

       this.beforePrint = false
    },
    dialogAcceptPrintPdfDistribuitor(){
        this.isPrintinDistributorPDF = true;
        this.isPrintRolluxQuotingPDF = true;
        // this.$children[5].$refs.html2Pdf2.generatePdf()
        axios.post("/api/auth-order-list-pdf-distributor", {orders: this.orders, user: this.user}, {responseType: 'blob',}).then((response)=>{
        this.isPrintinDistributorPDF = false;
        this.isPrintRolluxQuotingPDF = false;
        const objectUrl = URL.createObjectURL(response.data);
        this.urlPdfVisor = objectUrl;
        this.downloadButtonPdf = response.data;
        this.pdfDialog = true;
        this.closeDistributorPrintDialog();
        }).catch(()=>{
            this.isPrintRolluxQuotingPDF = false;
            this.isPrintinDistributorPDF = false;
        })
    },

    closeDistributorPrintDialog(option = 'close'){
        this.showUserFormFromDistributorPrintDialog = false;
        this.resetSelectedUser();
        if(option == 'closeAndReset'){
            this.distributorPrintDialog = false;
            this.distributorImagePrint = null;
        }
    },
    viewAndPrintPdfDistribuitor(){
        //Distribuidor
        this.distributorPrintDialog = true
    },

    openPDFView(){
      if(this.$store.state.isLoggedIn == true){

        if(this.user.role === 'Superadministrador' || this.user.role === 'Administrador' || this.user.role === 'Vendedor'){
          this.$store.dispatch('getDistributors').then(() => {
            this.sellerPrint = true
          })

        }else{
            //Opciones de visualizacion e impresion para distribuidores
            this.viewAndPrintPdfDistribuitor();
        }

      }else{
        this.beforePrint = true
      }

    },

    chargeWoodPrices(){
		  if (this.order.motor_type == 'Manual') {
		  	    this.widthMargins = woodMatrix[0].width + ' a ' + woodMatrix[10].width
        		this.heightMargins = woodMatrix[0].height + ' a ' + woodMatrix[woodMatrix.length-1].height
		  }else if(this.order.motor_type == 'Motorizado'){
        this.widthMargins = woodMotorized[0].width + ' a ' + woodMotorized[8].width
        this.heightMargins = woodMotorized[0].height + ' a ' + woodMotorized[woodMotorized.length-1].height
      }
    },

    cancelEdit(){
       this.order = Object.assign({}, this.defaultOrder);
       this.editable = false
    },

    deleteAllBlinds(){
        this.$store.dispatch('actionDeleteAllBlinds');
    },

    exportPDF(){

    },
    saveOrders(){
      if(this.user == null ){
          this.redirectToLogin(0);
      }else{
            if(this.$route.params.order_id){
              this.$store.dispatch('updateOrders', {'orders': this.orders, 'id': this.$route.params.order_id,'is_quotation': false}).then( () =>{
                this.savedorderMessage = true
                this.$store.dispatch('actionDeleteAllBlinds')
              } )
            }else{
              this.$store.dispatch('saveOrders', this.orders).then( () => {
                this.savedorderMessage = true
                this.$store.dispatch('actionDeleteAllBlinds')
              })
            }
      }
    },

    saveQuotations(){
      if(this.user == null){
          this.redirectToLogin(1);
      }else{
          if(this.$route.params.order_id){
            this.$store.dispatch('updateQuotations', {'orders': this.orders, 'id': this.$route.params.order_id}).then( () => {
              this.savedBlindMessage = true
              this.$store.dispatch('actionDeleteAllBlinds')
            })
          }else{
            this.$store.dispatch('saveQuotations', this.orders).then( ()=>{
              this.savedBlindMessage = true
              this.$store.dispatch('actionDeleteAllBlinds')
            })
          }

      }
    },

    openCelularDialog(){
      this.resetCelularAttributes()
      this.celularDialog = true
    },
    validateCelularDialog(){
      if(this.$refs.celularForm.validate()){
        this.celularDialog = false
      }
    },

    resetCelularAttributes(){
      if(this.$refs.celularForm){
        this.$refs.celularForm.reset()
      }
      this.order.variant = null
      this.order.variant2 = null
      this.order.motor.control = null
      this.order.motor.motor = 0
      this.celularDialog = false
      this.disabledSelectColor = true
      this.disabledFrameRadio = true
      this.disabledCommentText = true
    },

    chargeCelularColors(){
        // let variants = this.$store.state.productsModule.variants.filter(v => v.name.includes(this.order.celular_variant))
        const variant1 = this.$store.state.productsModule.variants.find(v => v.name.includes(this.order.celular_variant.day))
        const variant2 = this.$store.state.productsModule.variants.find(v => v.name.includes(this.order.celular_variant.night))

        this.$store.dispatch("getRelatedColors", {'slug': variant1.slug, 'type':this.order.type}).then(()=>{
            this.order.variant = variant1.slug
        })
        this.$store.dispatch("getRelatedColors2", {'slug': variant2.slug, 'type':this.order.type}).then(() => {
            this.order.variant2 = variant2.slug
            this.loadingColors = false;
            this.disabledSelectColor = false
        });
    },

    showMargins(){
      this.disabledDriveRadio = false
      this.disabledCelularText = false

      this.heightMargins = 1+' a '+3.00
      this.widthMargins = 0.60+' a '+3.00
    },

    createHeights(width){
      if(width == 1){
        return [22]
      }else if(width == 2){
        return [11]
      }else if(width == 3){
        return [5]
      }else if(width == 4 || width == 5){
        return [4]
      }else if(width == 6 || width == 7){
        return [3]
      }else if(width >= 8 && width <= 11){
        return [2]
      }else if(width >= 12 && width <= 22){
        return [1]
      }
      else{
        return []
      }
    },

    downloadImage(type, manufacturer, code){
      watermark(['/img/modelos/full/'+type+'/'+manufacturer+'/'+code+'.jpg','/img/cotizador/watermarklogo.png'])
     .image(function (model, logo) {
    const context = model.getContext('2d');
    context.save();
    context.globalAlpha = 0.3
    context.drawImage(logo,0,0,model.width,model.height);
    context.restore();
    return model;
  })
      .then(img => {
        var a = document.createElement('a');
        a.href = img.src
        a.download = code+".jpg";
        a.click()
      });

    },


    buttonCanvasRules(max, index){
       let n = parseFloat(this.order.canvas[index].width);
       if(this.getType){
          if(n > max && (  this.getType.name == 'ENROLLABLE' || this.getType.name == 'ROMANA' )){
         this.showButtonDialog = true
         return "Si tu ventana rebasa los limites permitidos puedes agregar más lienzos"
       }else{
         this.showButtonDialog = false
         return true
       }
       }else{
         return true
       }

    },

    extraEnrollableRule(index){
       let n = parseFloat(this.order.canvas[index].width);
       if(this.getType){
          if(n > 2.45 && (  this.getType.name == 'ENROLLABLE')){
         return "Si el lienzo rebasa los 2.45 metros de ancho, se hará un cargo extra de $350.00 MXN"
       }else{
         return ''
       }
       }else{
         return ''
       }

    },

    validateCanvas() {
      if (this.$refs.canvasForm.validate()) {
        this.canvasDialog = false;
      }
    },
    closeCanvasForm(){
        this.$refs.canvasForm.resetValidation();
        this.canvasDialog = false;
        while (this.order.canvas.length > 1) {
            this.order.canvas.pop();
        }

    },
    addCanvas() {
      if (this.order.canvas.length < 3) {
        this.order.canvas.push({ width: null, height: null})
      }
    },
    deleteCanvas(){
      if (this.order.canvas.length > 1) {
        this.order.canvas.pop()
      }
    },
    openCanvasDialog() {
      this.canvasDialog = true;
    },
    saveMotorization(motor) {
      this.order.motor = Object.assign({}, motor);
    },

    CloseMotorizationDialog() {
      if (this.editable) {
        this.dialogMotorization = false;
      } else {

        this.dialogMotorization = false;
      }
    },

    openMotorizationDialog() {
      if(this.order.motor_type == 'Motorizado' && this.order.type == 'flexibalet'){
        this.flexibaletExtraDialog = true
      }else{
        this.dialogMotorization = true;

      }

    },

    openMotorizationDialogConfirm(){
       this.dialogMotorization = true;
      // this.$store.dispatch("getControls");
      this.flexibaletExtraDialog = false

    },

    closeDialog() {
      this.dialogMotorization = false;
    },

    motorCelularPrice(){
      let price = 0
      if(this.order.motor.motor){
        price += parseFloat(this.$store.getters.getMotor(this.order.motor.motor).price)
      }
      if(this.order.motor.control){
        price += parseFloat(this.order.motor.control.price)
      }
      return price
    },
    addBlind() {
      if(this.order.celular_drive != null && !this.$refs.celularForm.validate()){
          this.celularDialog = true
        }else{
        if (this.$refs.form.validate()) {
          if(this.order.type == 'horizontal-madera-2'){
            this.order.price = this.roundToOneDecimal(this.findWoodPrice)
          }else if(this.order.type == 'celular'){

            this.order.price = this.roundToOneDecimal(this.unitaryPrice)
            this.order.motor.price = this.roundToOneDecimal(this.motorCelularPrice())

          }else if(this.order.type == 'vertical'){
            this.order.extraVertical = this.extraVerticalPrice;
            this.order.price = this.roundToOneDecimal(this.unitaryPrice)
          }else{
            this.order.extraEnrollable = this.extraEnrollablePrice * 1;
            this.order.price = this.roundToOneDecimal(this.unitaryPrice)
          }

        //   if(this.user != null){
        //     this.order.discount_price = this.order.price - ((this.user.discount_percent/100)*this.order.price)
        //   }
        //   if(this.selectedUser.discount_percent > 0){
        //     this.order.discount_price = this.order.price - ( (this.order.discount_pricet/100)*this.order.price)
        //   }

        if(typeof(this.order.installmentCharge) != 'string'){
            if(this.order.installmentCharge < 0){
                this.order.installmentCharge = 0;
            }
        }
        else{
            this.order.installmentCharge = 0;
        }

        if (this.editable) {
          this.$store.dispatch("editOrder", this.order).then(() => {
            this.order = Object.assign({}, this.defaultOrder);
            this.order.canvas = [{width: null, height: null}],
            this.$refs.form.resetValidation()
            this.editable = false;
          });
        } else {
          this.$store.dispatch("addToOrder", this.order).then(() => {
            this.order = Object.assign({}, this.defaultOrder);
            this.order.canvas = [{width: null, height: null}],
            this.order.motor =  Object.assign({}, this.defaultMotor);
           this.$refs.form.resetValidation()
          });
        }
      }
        }

    },

    editOrder(value) {
      this.$vuetify.goTo(0, this.options)
      let result = this.orders.find((item) => item.id === value);
      this.order = Object.assign({}, result);
      this.editable = true;
      this.$store.dispatch("getRelatedColors", {'slug': this.order.variant, 'type':this.order.type}).then(() => {
        this.loadingColors = false;
        this.disabledSelectColor = false;
        this.disabledSelectSize = false;
      });
    },

    deleteOrder(id) {
      this.$store.dispatch("deleteOrder", id).then(() => {});
    },

    widthCanvasRules(min, max, index) {

      let n = parseFloat(this.order.canvas[index].width);
      return (
        (!isNaN(n) && n >= min && n <= max) ||
        "Requerido"
      );
    },

    heightCanvasRules(min, max, index) {
      let n = parseFloat(this.order.canvas[index].height);
      return (
        (!isNaN(n) && n >= min && n <= max) ||
        "Requerido"
      );
    },

    flexiballetWidthRules(){
      let n = parseFloat(this.order.canvas[0].width);
      return (
        (!isNaN(n) && n >= 1 && n <= 22) ||
        "Requerido"
      );
    },

    flexiballetHeightRules(){
      let w = parseFloat(this.order.canvas[0].width);
      let h = parseFloat(this.order.canvas[0].height);
      if(w >= 1 && w <= 1.99){
        this.heightMargins = 1+' a '+22
        return ((!isNaN(h) && h >= 1 && h <= 22));
      }else if(w >= 2 && w <= 2.99){
        this.heightMargins = 1+' a '+11
        return ((!isNaN(h) && h >= 1 && h <= 11));
      }else if(w >= 3 && w <= 3.99){
        this.heightMargins = 1+' a '+5
        return ((!isNaN(h) && h >= 1 && h <= 5));
      }else if(w >= 4 && w <= 5.99){
        this.heightMargins = 1+' a '+4
        return ((!isNaN(h) && h >= 1 && h <= 4));
      }else if(w >= 6 && w <= 7.99){
        this.heightMargins = 1+' a '+3
        return ((!isNaN(h) && h >= 1 && h <= 3));
      }else if(w >= 8 && w <= 11.99){
        this.heightMargins = 1+' a '+2
        return ((!isNaN(h) && h >= 1 && h <= 2));
      }else if(w >= 12 && w <= 22){
        this.heightMargins = 1+' a '+1
        return ((!isNaN(h) && h >= 1 && h <= 1));
      }


      return true

    },

    widthWoodRules(){
      let n = parseFloat(this.order.canvas[0].width);
      if(this.order.motor_type == 'Manual'){
        return (
          (!isNaN(n) && n >= 0.60 && n <= 2.4) ||
          "Requerido"
        );
      }else if(this.order.motor_type == 'Motorizado'){
        return (
          (!isNaN(n) && n >= 0.80 && n <= 2.4) ||
          "Requerido"
        );
      }else{
        return true
      }
    },

    heightWoodRules(){
      let n = parseFloat(this.order.canvas[0].height);
        return (
          (!isNaN(n) && n >= 0.80 && n <= 3) ||
          "Requerido"
        );

    },

    widthCelularRules(type){
      let n = parseFloat(this.order.canvas[0].width);
        return (
          (!isNaN(n) && n >= 0.60 && n <= 3) ||
          "Requerido"
        );
    },

    heightCelularRules(type){
      let n = parseFloat(this.order.canvas[0].height);
        return (
          (!isNaN(n) && n >= 1 && n <= 3) ||
          "Requerido"
        )
    },

    chargeModels() {
      this.heightMargins = null;
      this.widthMargins = null;
      // if(order.type === 'horizontal-aluminio-1' || order.type === 'horizontal-aluminio-2' || order.type === 'horizontal-madera-2'){
      //   console.log('asigna color por default')
      // }
    },

    chargeTypeModels(type) {
      // this.order.line = null
      // this.order.celular_type = null
      // this.order.celular_drive = null
      // this.disabledDriveRadio = true
      // this.disabledCelularText = true
      // this.disabledSelectModel = false;
      // this.chargeModels()
      this.order = Object.assign({}, this.defaultOrder);
      this.order.canvas = [{width: null, height: null}],
      this.order.motor =  Object.assign({}, this.defaultMotor);
      this.order.type = type
      if(this.order.type == 'flexibalet'){
        this.widthMargins = '1.00 a 22'
      }
      // this.order.canvas = [{width: null, height: null}]
    },

    chargeColors() {
      this.selectedColor = null;
      this.loadingColors = true;

      this.$store.dispatch("getRelatedColors", {'slug': this.order.variant, 'type':this.order.type}).then(() => {
        this.loadingColors = false;
        this.disabledSelectColor = false;
        this.disabledSelectSize = false;
        if(this.order.type === 'horizontal-aluminio-1' || this.order.type === 'horizontal-aluminio-2' || this.order.type === 'horizontal-madera-2'){
          this.order.color = this.colors[0];
        }
      });


    },

    selectColor(color) {
      this.disabledFrameRadio = false
      if (this.order.color.rotate) {
        this.rotate = true;
      } else {
        this.rotate = false;
      }
    },
  },

  created() {
    document.title = "Cotizador de Rollux";
  },

  mounted() {
    this.$store.dispatch("getMotorizations");
    this.$store.dispatch("getControls");

    if (this.order.variant) {
      this.chargeColors();
    }

    if(typeof(this.$route.query.is_quotation) != 'undefined'){
        if(this.$route.query.is_quotation == 0){
            this.saveOrders();
        }
        else if(this.$route.query.is_quotation == 1){
            this.saveQuotations();
        }
    }
  },



  computed: {
      verifyUserSuperadminRole(){
          if(this.user != null){
              if(this.user.role === 'Superadministrador' || this.user.role === 'Administrador'){
                  return true;
              }
              else{
                  return false;
              }
          }
          return false;
      },
      enableBtnPrintLogInAdmin(){

        // name: null,
        // last_name: null,
        // discount_percent: 0,
        let filteredArray = Object.values(this.selectedUser).filter(el=> (el!=null && el!=''));
        //Longitud >= 3 por que es el numero minimo de propiedades de usuario para poder imprimir
        if((filteredArray.length >= 4) && ((this.selectedUser['name'] != null && this.selectedUser['name'] != '') && (this.selectedUser['last_name'] != null && this.selectedUser['last_name'] != '') && (this.selectedUser['discount_percent'] != null && this.selectedUser['discount_percent'] != '') && this.selectedUser['email'] != null && this.selectedUser['email'] != '')){
            return true;
        }
        else{
            return false;
        }
      },

    extraVerticalPrice(){
      if(this.order.type === 'vertical' && this.order.canvas[0].width != null){
        if(this.order.cloth_holder === 'Galería PVC'){
          return Math.ceil(this.order.canvas[0].width) * 250
        }else if(this.order.cloth_holder === 'Galería Portatela'){
          return Math.ceil(this.order.canvas[0].width) * 120
        }
      }else{
        return 0
      }
    },

    computedInstallmentCharge(){
        if(typeof(this.order.installmentCharge) != 'string'){
            if(this.order.installmentCharge >= 0){
                return this.order.installmentCharge;
            }
            else{
                this.order.installmentCharge = 0;
                return this.order.installmentCharge;
            }
        }
        else{
            this.order.installmentCharge = 0;
            return this.order.installmentCharge;
        }
    },

    celularMotors (){
      if(this.order.canvas[0].width){
        return this.motorizations.filter(m => m.type === "PERSIANAS CELULARES" && parseFloat(m.width) >= this.order.canvas[0].width)
      }
    },

    extraEnrollablePrice(){
      let enrollablePrice = 0
        this.order.canvas.forEach(canvas => {
            if(canvas.width > 2.45){
                enrollablePrice += 350;
            }
        });
      return enrollablePrice
    },

    findWoodPrice(){
      let result = 'Medida no válida'
      if(this.order.motor_type == 'Manual'){
         result  =  woodMatrix.filter((m) => m.width >= this.order.canvas[0].width && m.height >= this.order.canvas[0].height)
      }else if(this.order.motor_type == 'Motorizado'){
         result  =  woodMotorized.filter((m) => m.width >= this.order.canvas[0].width && m.height >= this.order.canvas[0].height)
      }

      if(result[0]){
        if(this.order.motor_type == 'Manual' && this.order.motor.drive == 'cinta'){
          return result[0].price + (result[0].price * 0.15)
        }else{
          return result[0].price
        }
      }
    },

    options () {
      return {
        duration: 1000,
        offset: 0,
        easing: 'easeInOutQuint',
      }
    },
    btnOrderTitle() {
      if(this.order.type == 'panel-japones'){
        return this.editable ? "terminar edición" : "terminar panel japonés";
      }else{
        return this.editable ? "terminar edición" : "terminar persiana";
      }

    },
    btnMotorTitle() {
      return this.editable ? "editar motorización" : "terminar motorización";
    },

    cardTitle() {
      return this.editable ? "EDITA TU PERSIANA" : "COTIZA TU PERSIANA";
    },

    lines() {
      if (this.getType) return this.$store.getters.getLines(this.getType.slug);
    },



    maxheight() {
      let w = 0;

        if (this.getType && this.variant) {
          if (this.order.rotate) {
            w = this.variant.width - 0.2;
            this.heightMargins = this.getType.min_height + " a " + w;
            return w;
          }

          if (this.getType.max_height <= 0) {
            w = this.maxwidth;
            this.heightMargins = this.getType.min_height + " a " + w;
            return w;
          } else {
            w = this.getType.max_height;
            this.heightMargins = this.getType.min_height + " a " + w;
            return w;
          }
        } else {
          return w;
        }

    },

    maxwidth() {
      let w = 0;
      if (this.getType && this.variant) {
        if (this.order.rotate) {
          w = this.getType.max_width_rot;
          this.widthMargins = this.getType.min_width + " a " + w;
          return w;
        }
        if (this.getType.max_width <= 0) {
          w = parseFloat(this.variant.width - this.getType.profit_margin).toFixed(2);
          this.widthMargins = this.getType.min_width + " a " + w;
          return w;
        } else {
          w = this.getType.max_width;
          this.widthMargins = this.getType.min_width + " a " + w;
          return parseFloat(w).toFixed(2);
        }
      } else {
        return w;
      }
    },

    getType() {
      if (this.getProduct && this.order.type) {
        return this.getProduct.types.find(
          (type) => type.slug === this.order.type
        );
      }
    },

    variants() {
      if(this.order.type === 'vertical' && this.order.line){
        return this.$store.state.productsModule.variants.filter(
          (variant) => variant.type.slug === this.order.type && variant.weave.slug === this.order.line
        );
      }
      else if (this.order.type && this.order.line && this.order.manufacturer) {
        return this.$store.state.productsModule.variants.filter(
          (variant) => variant.type.slug === this.order.type && variant.weave.slug === this.order.line && variant.line.slug === this.order.manufacturer
        );
      } else if (this.order.type && this.order.manufacturer) {
        return this.$store.state.productsModule.variants.filter(
          (variant) => variant.type.slug === this.order.type && variant.line.slug === this.order.manufacturer
        );
      }
    },

    manufacturers(){
      if(this.order.type){
        return this.$store.state.productsModule.variants.filter((v) => v.type === this.order.type)
      }
    },

    variant() {
      if (this.order.variant &&  this.order.type) {
        return this.$store.state.productsModule.variants.find(
          (variant) => variant.slug === this.order.variant && variant.type.slug === this.order.type
        );
      }
    },

    variantTwo() {
      if (this.order.variant2 && this.order.type) {
        return this.$store.state.productsModule.variants.find(
          (variant) => variant.slug === this.order.variant2 && variant.type.slug === this.order.type
        );
      }
    },

    totalPrice() {
      return this.$store.getters.totalPrice;
    },
    countBlinds() {
      return this.$store.getters.countBlinds;
    },

    ...mapState({
      colors: (state) => state.modelsModule.relatedColors,
      colors2: (state) => state.modelsModule.relatedColors2,
      orders: (state) => state.ordersModule.orders,
      distributors: (state) => state.userModule.distributors,
      controls: (state) => state.motorizationModule.controls,
      motorizations: (state) => state.motorizationModule.motorizations,
      user: (state) => state.user,
    }),


    showRotate() {
      if (this.order.color) {
        return this.order.color.rotate === 1 ? true : false;
      }
    },

    getProduct() {
      return this.$store.getters.getTypes("PERSIANAS");
    },

    unitaryPrice() {
        if(this.order.variant2 != null){
        let partialHeight  = this.order.canvas[0].height / 2
        let price = 0
        if (
            this.order.canvas[0].width > 1 &&
            partialHeight > 1
          ) {
            return parseFloat( (this.variant.price * this.order.canvas[0].width * partialHeight) +
             (this.variantTwo.price * this.order.canvas[0].width * partialHeight));
          } else if (this.order.canvas[0].width > 1) {
            price =  parseFloat(
              (this.variant.price * this.order.canvas[0].width) + (this.variantTwo.price * this.order.canvas[0].width)
            );
            return price
          } else if (partialHeight > 1) {
            price =  parseFloat(
              (this.variant.price * partialHeight) + (this.variantTwo.price * partialHeight)
            );
            return price;
          } else {

            price = parseFloat(this.variant.price) + parseFloat(this.variantTwo.price)
            return price;
          }

      }
      else if (this.order.canvas.length > 0 && this.variant) {
        let price = 0;
        for (let index = 0; index < this.order.canvas.length; index++) {
          if (
            this.order.canvas[index].width > 1 &&
            this.order.canvas[index].height > 1
          ) {
            price += parseFloat(
              this.variant.price *
                this.order.canvas[index].width *
                this.order.canvas[index].height
            );
          } else if (this.order.canvas[index].width > 1) {
            price += parseFloat(
              this.variant.price * this.order.canvas[index].width
            );
          } else if (this.order.canvas[index].height > 1) {
            price += parseFloat(
              this.variant.price * this.order.canvas[index].height
            );
          } else {
            price += parseFloat(this.variant.price);
          }
        }

        return price;
      } else if (this.variant) {
        return this.variant.price;
      } else {
        return 0;
      }


    },


  },

  components: {
    // PreviewPDF,
    QuotedBlinds,
    MotorizationDialog,
    // PreviewPdfRollux,

    pdf
  },

};
</script>

<style >
.v-text-field--filled.v-input--dense.v-text-field--outlined.v-text-field--filled
  > .v-input__control
  > .v-input__slot,
.v-text-field--filled.v-input--dense.v-text-field--outlined
  > .v-input__control
  > .v-input__slot,
.v-text-field--filled.v-input--dense.v-text-field--single-line
  > .v-input__control
  > .v-input__slot,
.v-text-field--full-width.v-input--dense.v-text-field--outlined.v-text-field--filled
  > .v-input__control
  > .v-input__slot,
.v-text-field--full-width.v-input--dense.v-text-field--outlined
  > .v-input__control
  > .v-input__slot,
.v-text-field--full-width.v-input--dense.v-text-field--single-line
  > .v-input__control
  > .v-input__slot,
.v-text-field--outlined.v-input--dense.v-text-field--outlined.v-text-field--filled
  > .v-input__control
  > .v-input__slot,
.v-text-field--outlined.v-input--dense.v-text-field--outlined
  > .v-input__control
  > .v-input__slot,
.v-text-field--outlined.v-input--dense.v-text-field--single-line
  > .v-input__control
  > .v-input__slot {
  min-height: 35px !important;
  height: 35px !important;
}
.row {
  box-sizing: border-box;
  display: table;
  table-layout: fixed;
  width: 100%;
}

.cell {
  display: table-cell;
  flex: 1;
  flex-direction: column;
  position: relative;
}

@supports (display: flex) {
  .row {
    display: flex;
  }

  .cell {
    display: block;
  }

  .cell-valign-middle,
.cell-valign-bottom {
    display: flex;
  }
}
.cell-min {
  width: 1%;
  flex: none auto;
}

.cell-max {
  width: 100%;
  flex: 1 100%;
}

.row {
  border-collapse: seperate;
  border-spacing: 8px 0;
  padding: 4px;
}

.cell {
  border-radius: 6px;
}
.cell.cell-1-5 {
  flex: none;
  width: 20%;
}
.cell.cell-nowrap {
  overflow: hidden;
  white-space: nowrap;
}
.cell.cell-valign-middle {
  vertical-align: middle;
  justify-content: center;
}
.cell.cell-valign-bottom {
  vertical-align: bottom;
  justify-content: flex-end;
}
.cell.cell-align-center {
  text-align: center;
}
.cell.cell-align-right {
  text-align: right;
}
.cell.cell-100px {
  flex: none;
  width: 100px;
  max-width: 100px;
}


</style>
