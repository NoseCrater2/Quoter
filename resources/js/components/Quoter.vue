<template>
 
  <v-container>
    <v-row justify="center" align="center">
      <v-card style="background-color: #ffffffc2">
        <v-card-title style="background-color: #404042; color: white">
          {{ cardTitle }}
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
                @change="chargeModels()"
                hide-details
                dense
                :items="getProduct ? getProduct.types : null"
                item-text="name"
                item-value="slug"
                v-model="order.type"
                label="Selecciona tu persiana"
                outlined
                color="#47a5ad"
                background-color="white"
                class="ma-1"
              ></v-autocomplete>
              <div v-if="order.type == null || order.type != 'celular'">
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
              <div v-if="order.line == 'tela-vertical'">
                <v-radio-group
              row
              :mandatory="false"
              v-model="order.cloth_holder"
              >
                <v-radio  label="Con portatela"  color="#47a5ad" :value="true"></v-radio>
                <v-radio  label="Sin portatela"  color="#47a5ad" :value="false"></v-radio>
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
                item-value="id"
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

              <v-switch
                v-if="showRotate"
                class="ml-5"
                v-model="order.rotate"
                label="Rotar"
              ></v-switch>
              <div v-if="order.type=='flexibalet'">
                <span style="font-size: 1em">3.Seleccione las medidas.</span>
                <v-select
                color="#47a5ad"
                class="ma-1"
                dense
                hide-details
                :items="[1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22]"
                label="Ancho"
                outlined
                placeholder="1.00 a 22.00"
                :rules="[(v) => !!v || 'Requerido']"
                suffix="mts"
                v-model="order.canvas[0].width"
                ></v-select>
                <v-select
                color="#47a5ad"
                class="ma-1"
                dense
                hide-details=""
                :items="createHeights(order.canvas[0].width)"
                label="Ancho"
                 outlined
                placeholder="1.00 a 22.00"
                :rules="[(v) => !!v || 'Requerido']"
                suffix="mts"
                v-model="order.canvas[0].height"
                ></v-select>
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
                  v-model="order.canvas[0].width"
                  :rules="[
                  buttonCanvasRules(maxwidth, 0),
                    ...widthCanvasRules(getType ? getType.min_width : 0, maxwidth,0),
                  ]"
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
                  
                  v-model="order.canvas[0].height"
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
              <div v-if="order.type == 'sheer' || order.type == 'triple-shade-shangri-la' || order.type == 'romantic'">
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
              </div>
               <div v-else>
                <v-item-group  v-model="order.celular_type" @change="showMargins" >
                    <span>2. Haz clic en la imagen para seleccionar una opción</span>
                    <v-row >
                      <v-col
                        cols="12"
                        md="4"
                        sm="12"
                        v-for="celular in celulares"
                        :key="celular.title"
                      >
                        <v-item  v-slot="{ active, toggle }" :value="celular.title">
                         
                            <v-card
                           
                              width="100"
                              flat
                              height="100"
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
                  <span>4. Seleccione modo de accionamiento</span>
                  <v-radio-group
                  :disabled="order.celular_type != null?false:true"
                  row
                  :mandatory="false"
                  :rules="[(v) => !!v || 'Requerido']"
                  v-model="order.celular_drive">
                    <v-radio @click="openCelularDialog"  color="#47a5ad" label="Muelle" value="Muelle"></v-radio>
                    <v-radio @click="openCelularDialog"  color="#47a5ad" label="Cordón" value="Cordón"></v-radio>
                    <v-radio @click="openCelularDialog"  color="#47a5ad" label="Motor" value="Motor"></v-radio>
                </v-radio-group>
              </div>

             
             
            
            </v-col>
           
            <v-col class="pa-1" cols="6">
              <div v-if="order.type == null || order.type != 'celular'">
               <v-hover  v-slot="{ hover }">

                <v-img
                 v-if="order.color"
                  max-height="328"
                  max-width="328"
                  :src=" `/img/modelos/medium/${order.color.code }.jpg`"
                >
                  <template v-slot:placeholder>
                    <v-img src="/img/modelos/medium/unavailable.jpg"></v-img>
                  </template>
                  <v-slide-y-transition>
                    <div v-if="hover && order.color.code" style="background-color: rgba(0,0,0,0.2)" class=" d-flex transition-fast-in-fast-out justify-center"  > 
                       <v-btn icon dark @click="downloadImage(order.color.code)">
                         <v-icon>mdi-cloud-download</v-icon>
                      </v-btn>
                    </div> 
                </v-slide-y-transition>
                </v-img>
                <v-img 
                 max-height="328"
                  max-width="328"
                v-else src="/img/modelos/medium/unavailable.jpg">
                </v-img>

               </v-hover>

              <v-list dense>
                <v-list-item>
                  <v-list-item-content>
                    <v-list-item-title>PERSIANA:</v-list-item-title>
                  </v-list-item-content>
                  <v-list-item-action>
                    <v-list-item-action-text>
                      {{mxCurrencyFormat.format(unitaryPrice)}}
                      MXN
                    </v-list-item-action-text>
                  </v-list-item-action>
                </v-list-item>
                <v-list-item>
                  <v-list-item-content>
                    <v-list-item-title>MOTOR y CONTROL/GALERÍA:</v-list-item-title>
                  </v-list-item-content>
                  <v-list-item-action>
                    <v-list-item-action-text>
                      {{mxCurrencyFormat.format(order.motor.price)}}
                      MXN
                    </v-list-item-action-text>
                  </v-list-item-action>
                </v-list-item>
              </v-list>
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
                <v-text-field                  dense
                  type="number"
                  label="Ancho"
                  class="ma-1"
                  hide-details
                  :disabled="disabledCelularText"
                  :placeholder="widthMargins"
                  outlined
                  color="#47a5ad"
                  background-color="white"
                  v-model="order.canvas[0].width"
                  :rules="[
                    ...widthCelularRules(order.celular_type),
                  ]"
                ></v-text-field>

                <v-text-field
                  class="ma-1"
                  hide-details
                  :disabled="disabledCelularText"
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
                  v-model="order.canvas[0].height"
                ></v-text-field>
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
           </div>
            </v-col>

            
          </v-row>
          <v-row no-gutters>
            <v-col cols="12" md="4" sm="12">
              <v-btn
                  block
                  color="#d87c01"
                  @click="addBlind()"
                  depressed
                  dark
                  >{{ btnOrderTitle }}
                  </v-btn>
            </v-col>
            <v-col cols="12" md="4" sm="12" class="my-1 text-center">
               <v-tooltip top>
                  <template v-slot:activator="{ on, attrs }">
                    <v-btn
                   
                      small
                      v-bind="attrs"
                      v-on="on"
                      color="#47a5ad"
                      dark
                      fab
                      @click="exportPDF"
                    >
                      <v-icon>mdi-printer</v-icon>
                    </v-btn>
                  </template>
                  <span>Imprimir</span>
                </v-tooltip>

                <v-tooltip top>
                  <template v-slot:activator="{ on, attrs }">
                    <v-btn  small v-bind="attrs" v-on="on" color="#47a5ad" dark fab>
                      <v-icon>mdi-email-send</v-icon>
                    </v-btn>
                  </template>
                  <span>Enviar por Email</span>
                </v-tooltip>
           
           
             
           
            </v-col>
            <v-col cols="12" md="4" sm="12">
               <v-btn
               block
            @click="saveOrders"
            dark
            depressed 
            color="#3ca927"
            >Realizar pedido
            </v-btn>
            </v-col>
          </v-row>
        </v-form>
        
        <v-dialog v-if="getType" v-model="dialogMotorization" persistent max-width="600" >
          <MotorizationDialog 
          @saveMotorization="saveMotorization"  
          @CloseMotorizationDialog="CloseMotorizationDialog" 
          :typeName="getType.name"
          :parentMotor="order.motor"
          :action="order.motor_type"
          :canvas="order.canvas.length"
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
            <v-card-title>
              Indique ancho alto para cada lienzo
              <v-spacer></v-spacer>
              ${{
                parseFloat(Math.round(unitaryPrice * 100) / 100).toFixed(2)
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
                          v-model="order.canvas[c - 1].height"
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
                          v-model="order.canvas[c - 1].width"
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
              <v-btn dark block  color="#47a5ad" @click="validateCanvas">ACEPTAR</v-btn>
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
            <v-row class="mx-3" v-if="order.celular_type == 'Muelle' || order.celular_type == 'Cordón'" >
              <v-col class="pa-0" cols="6" >
                <div v-if="order.celular_drive == 'Motor' || order.celular_drive == 'Cordón'">
                <span>5. Selecciona lado del motor</span>
                <v-radio-group :rules="[(v) => !!v || 'Requerido']" row v-model="order.motor.side_control">
                <v-radio  label="Izquierdo"  color="#47a5ad" value="Izquierdo"></v-radio>
                <v-radio  label="Derecho"  color="#47a5ad" value="Derecho"></v-radio>
              </v-radio-group>
              </div>
              <span style="font-size: 1em"> 6.Seleccione características</span>
              <v-autocomplete
                class="ma-1"
                hide-details
                :rules="[(v) => !!v || 'Requerido']"
                dense
                v-model="order.variant"
                :items="variants"
                item-text="name"
                item-value="id"
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
                  7 .Marco
                </span>
                <v-radio-group
                :disabled="disabledFrameRadio"
                :rules="[(v) => !!v || 'Requerido']"
                row
                :mandatory="false"
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
                    :src=" `/img/modelos/medium/${order.color.code }.jpg`"
                  >
                    <template v-slot:placeholder>
                      <v-img src="/img/modelos/medium/unavailable.jpg"></v-img>
                    </template>
                    <v-slide-y-transition>
                      <div v-if="hover && order.color.code" style="background-color: rgba(0,0,0,0.2)" class=" d-flex transition-fast-in-fast-out justify-center"  > 
                         <v-btn icon dark @click="downloadImage(order.color.code)">
                           <v-icon>mdi-cloud-download</v-icon>
                        </v-btn>
                      </div> 
                    </v-slide-y-transition>
                  </v-img>
                  <v-img 
                    max-height="328"
                    max-width="328"
                    v-else src="/img/modelos/medium/unavailable.jpg">
                  </v-img>
               </v-hover>
              </v-col>
            </v-row>
            <v-row class="mx-3" v-if="order.celular_type == 'Día y Noche' ">
              <v-col class="pa-0" >
                <div v-if="order.celular_drive == 'Motor' || order.celular_drive == 'Cordón'">
                <span>5. Selecciona lado del motor</span>
                <v-radio-group :rules="[(v) => !!v || 'Requerido']" row v-model="order.motor.side_control">
                <v-radio  label="Izquierdo"  color="#47a5ad" value="Izquierdo"></v-radio>
                <v-radio  label="Derecho"  color="#47a5ad" value="Derecho"></v-radio>
              </v-radio-group>
              </div>
                <span style="font-size: 1em"> 6.Seleccione características</span>
                <v-autocomplete
                  class="ma-1"
                  hide-details
                  :rules="[(v) => !!v || 'Requerido']"
                  
                  dense
                  v-model="order.celular_variant"
                  :items="celular_variants"
                  item-text="title"
                  item-value="flag"
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
                    :src=" `/img/modelos/medium/${order.color.code }.jpg`"
                  >
                    <template v-slot:placeholder>
                      <v-img src="/img/modelos/medium/unavailable.jpg"></v-img>
                    </template>
                    <v-slide-y-transition>
                      <div v-if="hover && order.color.code" style="background-color: rgba(0,0,0,0.2)" class=" d-flex transition-fast-in-fast-out justify-center"  > 
                         <v-btn icon dark @click="downloadImage(order.color.code)">
                           <v-icon>mdi-cloud-download</v-icon>
                        </v-btn>
                      </div> 
                    </v-slide-y-transition>
                  </v-img>
                  <v-img 
                    max-height="328"
                    max-width="328"
                    v-else src="/img/modelos/medium/unavailable.jpg">
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
                    :src=" `/img/modelos/medium/${order.second_color.code }.jpg`"
                  >
                    <template v-slot:placeholder>
                      <v-img src="/img/modelos/medium/unavailable.jpg"></v-img>
                    </template>
                    <v-slide-y-transition>
                      <div v-if="hover && order.second_color.code" style="background-color: rgba(0,0,0,0.2)" class=" d-flex transition-fast-in-fast-out justify-center"  > 
                         <v-btn icon dark @click="downloadImage(order.second_color.code)">
                           <v-icon>mdi-cloud-download</v-icon>
                        </v-btn>
                      </div> 
                    </v-slide-y-transition>
                  </v-img>
                  <v-img 
                    max-height="328"
                    max-width="328"
                    v-else src="/img/modelos/medium/unavailable.jpg">
                  </v-img>
               </v-hover>
              </v-col>
              <v-col cols="12">
                <span style="font-size: 1em">
                  7 .Marco
                </span>
                <v-radio-group
                @change="disabledCommentText = false"
                :disabled="disabledFrameRadio"
                :rules="[(v) => !!v || 'Requerido']"
                row
                :mandatory="false"
                v-model="order.motor.frame"
                >
                  <v-radio label="Fuera"  color="#47a5ad" value="fuera"></v-radio>
                  <v-radio label="Adentro"  color="#47a5ad" value="adentro"></v-radio>
                </v-radio-group>
              </v-col>
            </v-row>
            <v-row class="mx-3">
              <v-col class="pa-0" cols="12">
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
    </v-row>
  </v-container>
</template>

<script>
import { mapState } from "vuex";
import QuotedBlinds from './QuotedBlinds';
import MotorizationDialog from './MotorizationDialog';
import watermark from 'watermarkjs';

export default {
  name: "Quoter",
  data() {
    return {
      mxCurrencyFormat : new Intl.NumberFormat('en-US', {style: 'currency', currency: 'USD'}),
      disabledCelularText: true,
      disabledDriveRadio: true,
      disabledFrameRadio: true,
      disabledCommentText: true,
      celular_variants: [
        {title:'CELULAR BOLERO 25 MM (3.66 MM)', flag: 'BOLERO'},
        {title:'CELULAR ROMANCE 25 MM (3.66 MM)', flag: 'ROMANCE'},
        {title:'CELULAR SOLIS 38 MM 118\'\' (3.00)', flag: 'SOLIS'},
      ],
      celularDialog: false,
      celulares: [
        { title: "Día y Noche", img: "/img/cotizador/celulares/dianoche.png" },
        { title: "Muelle", img: "/img/cotizador/celulares/Muelle.png" },
        { title: "Cordón", img: "/img/cotizador/celulares/Cordon.png" },
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
      dialog: false,
      editable: false,
      order: {
        type: this.$route.query.type || null,
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
        cloth_holder: false,
        price: 0,
        rotate: false,
        motor_type: null,
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
        },
      },
      defaultOrder: {
        type: null,
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
        cloth_holder: false,
        price: 0,
        rotate: false,
        motor_type: null,
        motor: {
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
      },

    };
  },
  methods: {
    exportPDF(){

    },
    saveOrders(){
      if(this.user == null){
         this.$router.push({name: "login"})
      }else{
        this.$store.dispatch('saveOrders', this.orders)
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
      this.celularDialog = false
      this.disabledSelectColor = true
      this.disabledFrameRadio = true
      this.disabledCommentText = true
    },

    chargeCelularColors(){
        let variants = this.variants.filter(v => v.name.includes(this.order.celular_variant))
        this.$store.dispatch("getRelatedColors", variants[0].id).then(()=>{
          this.order.variant = variants[0].id
        })
        
        if(variants[1]){
          this.$store.dispatch("getRelatedColors2", variants[1].id).then(() => {
            this.order.variant2 = variants[1].id
            this.loadingColors = false;
            this.disabledSelectColor = false
          });
        }else{
          this.$store.dispatch("getRelatedColors2", variants[0].id).then(() => {
            this.order.variant2 = variants[0].id
            this.loadingColors = false;
            this.disabledSelectColor = false
          });
        }
     
    },

    showMargins(){
      this.disabledDriveRadio = false
      this.disabledCelularText = false
      if(this.order.celular_type == 'Día y Noche' || this.order.celular_type == 'Muelle'){
        this.heightMargins = 1+' a '+1.90
        this.widthMargins = 0.60+' a '+2.20
      }else if(this.order.celular_type == 'Cordón'){
        this.heightMargins = 1+' a '+3.00
        this.widthMargins = 0.60+' a '+3.00
      }
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

    downloadImage(code){
      watermark(['/img/modelos/full/'+code+'.jpg','/img/cotizador/watermarklogo.png'])
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
         return "Si tu ventana revasa los limites permitidos puedes agregar más lienzos"
       }else{
         this.showButtonDialog = false
         return true
       }
       }else{
         return true
       }
      
    },
 
    validateCanvas() {
      if (this.$refs.canvasForm.validate()) {
        this.canvasDialog = false;
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
      this.dialogMotorization = true;
      // this.$store.dispatch('getFilteredMotorizations', this.getType.id)
      this.$store.dispatch("getControls");
    },

    closeDialog() {
      this.dialogMotorization = false;
    },

    addBlind() {
      if(this.order.celular_drive != null && !this.$refs.celularForm.validate()){
          this.celularDialog = true
        }else{
          if (this.$refs.form.validate()) {
        
        this.order.price = this.unitaryPrice;

         //this.order.motor.price = this.motorizationPrice;
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
           this.$refs.form.resetValidation()
          });
        }
      }
        }
      
    },

    editOrder(value) {
      let order = this.orders.find((item) => item.id === value);
      this.order = Object.assign({}, order);
      this.editable = true;
      this.dialog = false;
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

    widthCelularRules(type){
      let n = parseFloat(this.order.canvas[0].width);
      if(type == 'Día y Noche' || type == 'Muelle'){
        return (
          (!isNaN(n) && n >= 0.60 && n <= 2.20) ||
          "Requerido"
        );
      }else if(type == 'Cordón'){
        return (
          (!isNaN(n) && n >= 0.60 && n <= 3) ||
          "Requerido"
        );
      }else{
        return true
      }
      
       
    },
    
    heightCelularRules(type){
      let n = parseFloat(this.order.canvas[0].height);
       if(type == 'Día y Noche' || type == 'Muelle'){
        return (
        (!isNaN(n) && n >= 1 && n <= 1.90) ||
        "Requerido"
      );
      }else if(type == 'Cordón'){
        return (
          (!isNaN(n) && n >= 1 && n <= 3) ||
          "Requerido"
        );
      }else{
        return true
      }
    },

    chargeModels() {
      this.order.line = null
      this.order.celular_type = null
      this.order.celular_drive = null
      this.disabledDriveRadio = true
      this.disabledCelularText = true
      this.disabledSelectModel = false;

      this.selectedColor = null;
      this.heightMargins = null;
      this.widthMargins = null;
    },

    chargeColors() {
      this.selectedColor = null;
      this.loadingColors = true;

      this.$store.dispatch("getRelatedColors", this.order.variant).then(() => {
        this.loadingColors = false;
        this.disabledSelectColor = false;
        this.disabledSelectSize = false;
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
    if (this.order.variant) {
      this.chargeColors();
    }
  },

  computed: {
    
    btnOrderTitle() {
      return this.editable ? "terminar edición" : "agregar a la orden";
    },
    btnMotorTitle() {
      return this.editable ? "editar motorización" : "agregar motorización";
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
      if (this.order.type && this.order.line) {
        return this.$store.state.productsModule.variants.filter(
          (variant) =>
            variant.type === this.order.type && variant.line === this.order.line
        );
      } else if (this.order.type) {
        return this.$store.state.productsModule.variants.filter(
          (variant) => variant.type === this.order.type
        );
      }
    },

    variant() {
      if (this.order.variant) {
        return this.$store.state.productsModule.variants.find(
          (variant) => variant.id === this.order.variant
        );
      }
    },

    variantTwo() {
      if (this.order.variant2) {
        return this.$store.state.productsModule.variants.find(
          (variant) => variant.id === this.order.variant2
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
            return parseInt( (this.variant.price * this.order.canvas[0].width * partialHeight) +
             (this.variantTwo.price * this.order.canvas[0].width * partialHeight));
          } else if (this.order.canvas[0].width > 1) {
            price =  parseInt(
              (this.variant.price * this.order.canvas[0].width) + (this.variantTwo.price * this.order.canvas[0].width)
            );
            return price
          } else if (partialHeight > 1) {
            price =  parseInt(
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
            price += parseInt(
              this.variant.price *
                this.order.canvas[index].width *
                this.order.canvas[index].height
            );
          } else if (this.order.canvas[index].width > 1) {
            price += parseInt(
              this.variant.price * this.order.canvas[index].width
            );
          } else if (this.order.canvas[index].height > 1) {
            price += parseInt(
              this.variant.price * this.order.canvas[index].height
            );
          } else {
            price += parseInt(this.variant.price);
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
    QuotedBlinds,
    MotorizationDialog,
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
  min-height: 30px !important;
  height: 30px !important;
}
</style>