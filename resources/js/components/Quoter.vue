<template>
  <!-- :src="`../../img/persianas/${idProduct}.jpg`" -->
  <!-- <div :style="selectedType?`background-image: url('../../img/persianas/${selectedType.id}.jpg')`:''" style="background-size: cover;"> -->
  <v-container>
    <v-row justify="center" align="center">
      <v-card style="background-color: #ffffffc2">
        <v-card-title style="background-color: #404042; color: white">
          {{ cardTitle }}
          <v-spacer></v-spacer>
          <div>
            TOTAL: $
            {{ parseFloat(Math.round(totalPrice * 100) / 100).toFixed(2) }} MXN
          </div>
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

              <div v-if="order.type == 'enrollable' || order.type == 'romana'">
                <span style="font-size: 1em">
                  3.Seleccione la cantidad de lienzos</span
                >
                <v-select
                  :rules="[(v) => !!v || 'Requerido']"
                  v-model="order.canvasSize"
                  @change="openCanvasDialog"
                  outlined
                  label="Lienzos"
                  :items="[1, 2]"
                  dense
                  color="#47a5ad"
                  background-color="white"
                ></v-select>
              </div>
              <div v-else>
                <span style="font-size: 1em">
                  3.Seleccione las medidas (El mínimo a cobrar es 1.0 x
                  1.0)</span
                >
                <v-text-field
                  hide-details
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
              <span style="font-size: 1em">
                4.Seleccione lado del control
              </span>
              <v-radio-group
                color="#47a5ad"
                :mandatory="false"
                :rules="[(v) => !!v || 'Requerido']"
                v-model="order.side_control"
              >
                <v-radio label="Izquierdo" value="Izquierdo"></v-radio>
                <v-radio label="Derecho" value="Derecho"></v-radio>
              </v-radio-group>

              <div class="d-flex justify-center">
                <v-btn
                  class="mx-2"
                  color="#47a5ad"
                  block
                  @click="addBlind()"
                  depressed
                  dark
                  small
                  >{{ btnOrderTitle }}</v-btn
                >
              </div>
              <div class="d-flex justify-center">
                <v-btn
                  class="mx-2 my-2"
                  color="#47a5ad"
                  block
                  outlined
                  :disabled="order.type ? false : true"
                  depressed
                  dark
                  x-small
                  @click="openMotorizationDialog"
                  >{{ btnMotorTitle }}</v-btn
                >
              </div>
            </v-col>
            <v-col class="pa-1" cols="6">
              <div>
                <v-img
                  max-height="328"
                  max-width="328"
                  :src="
                    order.color
                      ? `/img/modelos/medium/${order.color.code}.jpg`
                      : '/img/modelos/medium/unavailable.jpg'
                  "
                >
                  <template v-slot:placeholder>
                    <v-img src="/img/modelos/medium/unavailable.jpg"></v-img>
                  </template>
                </v-img>
              </div>

              <v-list dense>
                <v-list-item>
                  <v-list-item-content>
                    <v-list-item-title>PERSIANA:</v-list-item-title>
                  </v-list-item-content>
                  <v-list-item-action>
                    <v-list-item-action-text>
                      ${{
                        parseFloat(
                          Math.round(unitaryPrice * 100) / 100
                        ).toFixed(2)
                      }}
                      MXN
                    </v-list-item-action-text>
                  </v-list-item-action>
                </v-list-item>
                <v-list-item>
                  <v-list-item-content>
                    <v-list-item-title>MOTOR:</v-list-item-title>
                  </v-list-item-content>
                  <v-list-item-action>
                    <v-list-item-action-text>
                      ${{
                        parseFloat(
                          Math.round(motorizationPrice * 100) / 100
                        ).toFixed(2)
                      }}
                      MXN
                    </v-list-item-action-text>
                  </v-list-item-action>
                </v-list-item>
              </v-list>

              <div class="d-flex justify-center">
                <v-tooltip top>
                  <template v-slot:activator="{ on, attrs }">
                    <v-btn v-bind="attrs" v-on="on" color="#47a5ad" dark fab>
                      <v-icon>mdi-cart-arrow-right</v-icon>
                    </v-btn>
                  </template>
                  <span>Realizar pedido</span>
                </v-tooltip>

                <v-tooltip top>
                  <template v-slot:activator="{ on, attrs }">
                    <v-btn
                      class="mx-2"
                      v-bind="attrs"
                      v-on="on"
                      color="#47a5ad"
                      dark
                      fab
                    >
                      <v-icon>mdi-printer</v-icon>
                    </v-btn>
                  </template>
                  <span>Imprimir</span>
                </v-tooltip>

                <v-tooltip top>
                  <template v-slot:activator="{ on, attrs }">
                    <v-btn v-bind="attrs" v-on="on" color="#47a5ad" dark fab>
                      <v-icon>mdi-email-send</v-icon>
                    </v-btn>
                  </template>
                  <span>Enviar por Email</span>
                </v-tooltip>
              </div>
            </v-col>
          </v-row>
        </v-form>
        <v-card tile flat>
          <v-tabs v-model="tab" background-color="#47a5ad" dark show-arrows>
            <v-tab v-for="o in orders" :key="o.id"> PERSIANA {{ o.id }} </v-tab>
          </v-tabs>
        </v-card>

        <v-tabs-items v-model="tab">
          <v-tab-item v-for="o in orders" :key="o.id">
            <v-card tile flat>
              <v-card-title>
                {{ $store.getters.getVariant(o.variant).name }}
                <v-spacer></v-spacer>
                <v-tooltip top>
                  <template v-slot:activator="{ on, attrs }">
                    <v-btn
                      v-bind="attrs"
                      v-on="on"
                      color="indigo"
                      icon
                      @click="editOrder(o.id)"
                    >
                      <v-icon>mdi-pencil</v-icon>
                    </v-btn>
                  </template>
                  <span>Editar</span>
                </v-tooltip>
                <v-divider vertical></v-divider>
                <v-tooltip top>
                  <template v-slot:activator="{ on, attrs }">
                    <v-btn
                      v-bind="attrs"
                      v-on="on"
                      color="red"
                      icon
                      @click="deleteOrder(o.id)"
                    >
                      <v-icon>mdi-delete</v-icon>
                    </v-btn>
                  </template>
                  <span>Eliminar</span>
                </v-tooltip>
              </v-card-title>

              <v-divider></v-divider>

              <v-row justify="center" class="ma-0 pa-0">
                <v-col cols="12">

                  <v-list-item three-line>
                    <v-list-item-content>
                      <div class="overline">
                         CODIGO (SKU): {{ o.color.code }}
                      </div>
                      <v-list-item-title class="headline">
                         ${{parseFloat(Math.round(o.price * 100) / 100).toFixed(2)}} MXN
                      </v-list-item-title>
                      <v-list-item-subtitle>
                         COLOR: {{ o.color.color }}
                      </v-list-item-subtitle>
                    </v-list-item-content>
                    <v-list-item-avatar tile size="80">
                      <v-img
                    :src="`/img/modelos/medium/${o.color.code}.jpg`"
                    alt="color"
                  >
                    <template v-slot:placeholder>
                      <v-img
                        src="/img/modelos/medium/unavailable.jpg"
                      ></v-img>
                    </template>
                  </v-img>
                    </v-list-item-avatar>
                  </v-list-item>

                </v-col>
              </v-row>
              <v-row class="ma-0 pa-0">
                <v-col cols="6" class="ma-0 pa-0">

                  <div class="d-flex flex-column my-1">
                     <v-chip color="#47a5ad" text-color="white">
                      <strong>Tipo:</strong>&nbsp;
                      <span>
                        (  {{ o.type.toUpperCase() }})
                      </span>    
                    </v-chip>
                  </div>

                  <div class="d-flex flex-column my-1">
                     <v-chip color="#47a5ad" text-color="white">
                      <strong>Material:</strong>&nbsp;
                      <span>
                        (  {{ o.line.toUpperCase() }})
                      </span>    
                    </v-chip>
                  </div>
                  <div class="d-flex flex-column my-1">
                     <v-chip color="#47a5ad" text-color="white">
                      <strong>Lado del control:</strong>&nbsp;
                      <span>
                        (  {{ o.side_control.toUpperCase() }})
                      </span>    
                    </v-chip>
                  </div>

                  <div v-for="(c, index) in o.canvas" :key="index" class="d-flex flex-row my-1">
                   
                     <v-chip v-if="c.height != null" color="#47a5ad" text-color="white" >
                       <strong>Lienzo {{(index+1)}}:</strong> &nbsp;
                      <v-icon size="15">mdi-arrow-right</v-icon>{{ c.width }}M (Ancho)&nbsp;
                       <v-icon size="15">mdi-arrow-up</v-icon>{{c.height }}M (Alto)
                    </v-chip>

                    <!-- <v-chip v-if="c.height != null" color="#47a5ad" text-color="white" >
                     
                    </v-chip> -->
                  </div>

                </v-col>
                <v-col cols="6" class="ma-0 pa-0"  v-if="o.motor.motor > 0">
                  <div class="d-flex flex-column my-1">
                    <v-chip color="#47a5ad" outlined>
                      <strong>Motorización:</strong>&nbsp;
                      <span>({{ o.motor.action }})</span>
                    </v-chip>
                  </div>

                   <div class="d-flex flex-column my-1">
                     <v-chip color="#47a5ad" outlined>
                      <strong>Descripción:</strong>&nbsp;
                      <span>
                        ({{
                          $store.getters.getMotor(o.motor.motor).description +" " +
                          $store.getters.getMotor(o.motor.motor).system
                        }})
                      </span>    
                    </v-chip>
                  </div>
                  <div class="d-flex flex-column my-1">
                     <v-chip color="#47a5ad" outlined>
                      <strong>Tipo:</strong>&nbsp;
                      <span>
                        ( {{$store.getters.getMotor(o.motor.motor).motorizationType}})
                      </span>    
                    </v-chip>
                  </div>
                  <div class="d-flex flex-column my-1">
                     <v-chip color="#47a5ad" outlined>
                      <strong>Precio:</strong>&nbsp;
                      <span>
                        ( ${{$store.getters.getMotor(o.motor.motor).price}} MXN)
                      </span>    
                    </v-chip>
                  </div>
                  <div class="d-flex flex-column my-1">
                     <v-chip color="#47a5ad" outlined>
                      <strong>Fabricante:</strong>&nbsp;
                      <span>
                        ( {{$store.getters.getMotor(o.motor.motor).manufacturer }})
                      </span>    
                    </v-chip>
                  </div>
                
                 
                </v-col>
                <v-col cols="6" class="ma-0 pa-0" v-if="o.motor.gallery">
                  <div class="d-flex flex-column my-1">
                     <v-chip color="#47a5ad" outlined>
                      <strong>Motorización:</strong>&nbsp;
                      <span>
                        ( {{ o.motor.action }})
                      </span>    
                    </v-chip>
                  </div>
                  <div class="d-flex flex-column my-1">
                     <v-chip color="#47a5ad" outlined>
                      <strong>Paneles:</strong>&nbsp;
                      <span>
                        ({{ o.motor.panels }})
                      </span>    
                    </v-chip>
                  </div>
                  <div class="d-flex flex-column my-1">
                     <v-chip color="#47a5ad" outlined>
                      <strong>Agrupamiento:</strong>&nbsp;
                      <span>
                        ({{ o.motor.selected_panel }})
                      </span>    
                    </v-chip>
                  </div>
                  <div class="d-flex flex-column my-1">
                     <v-chip color="#47a5ad" outlined>
                      <strong>Color de control:</strong>&nbsp;
                      <span>
                        ({{ o.motor.control_color }})
                      </span>    
                    </v-chip>
                  </div>
                  <div class="d-flex flex-column my-1">
                     <v-chip color="#47a5ad" outlined>
                      <strong>Fabricante:</strong>&nbsp;
                      <span>
                        ({{ o.motor.manufacturer }} )
                      </span>    
                    </v-chip>
                  </div>
                  <div class="d-flex flex-column my-1">
                     <v-chip color="#47a5ad" outlined>
                      <strong>Tipo de cadena:</strong>&nbsp;
                      <span>
                        ({{ o.motor.string_type }})
                      </span>    
                    </v-chip>
                  </div>
                  <div class="d-flex flex-column my-1">
                     <v-chip color="#47a5ad" outlined>
                      <strong>Galería/Fascia:</strong>&nbsp;
                      <span>
                        ({{ o.motor.gallery.model }})
                      </span>    
                    </v-chip>
                  </div>
                  <div class="d-flex flex-column my-1">
                     <v-chip color="#47a5ad" outlined>
                      <strong>Precio:</strong>&nbsp;
                      <span>
                        (${{ o.motor.gallery.price }} MXN)
                      </span>    
                    </v-chip>
                  </div>
                  <div class="d-flex flex-column my-1">
                     <v-chip color="#47a5ad" outlined>
                      <strong>Color:</strong>&nbsp;
                      <span>
                        ({{ o.motor.gallery_color }})
                      </span>    
                    </v-chip>
                  </div>
                </v-col>
              </v-row>
            </v-card>
          </v-tab-item>
        </v-tabs-items>

        <v-dialog v-model="dialogMotorization" max-width="600" persistent>
          <v-card height="auto" width="auto" max-width="600" min-width="300">
            <v-form ref="formMotor" v-model="valid2" lazy-validation>
              <v-col cols="12" class="pb-0">
                <span style="font-size: 1em">
                  6. Seleccionar modo de accionamiento</span
                >
                <v-radio-group
                  @change="loadAditionalInfo()"
                  row
                  :mandatory="false"
                  :rules="[(v) => !!v || 'Requerido']"
                  v-model="order.motor.action"
                >
                  <v-radio
                    color="#47a5ad"
                    label="Manual"
                    value="manual"
                  ></v-radio>
                  <v-radio
                    v-if="
                      getType &&
                      (getType.name === 'ENROLLABLE' ||
                        getType.name === 'CELULAR' ||
                        getType.name === 'PANEL JAPONES')
                    "
                    color="#47a5ad"
                    label="Motorizado"
                    value="motorizado"
                  ></v-radio>
                </v-radio-group>
              </v-col>
              <v-row
                v-if="order.motor.action === 'motorizado'"
                class="ma-0 pa-0"
                ><!-------------------------------------------------- MODO AUTOMATICO -->
                <span class="mx-2">7. Seleccione características de motor</span>
                <v-col
                  cols="12"
                  v-if="getType && getType.name === 'ENROLLABLE'"
                  class="my-0 py-0"
                >
                  <v-radio-group
                    row
                    :mandatory="false"
                    :rules="[(v) => !!v || 'Requerido']"
                    v-model="order.motor.type"
                  >
                    <v-radio
                      color="#47a5ad"
                      label="Recargable (batería)"
                      value="RECARGABLE"
                    ></v-radio>
                    <v-radio
                      color="#47a5ad"
                      label="Eléctrico"
                      value="ELECTRICO"
                    ></v-radio>
                  </v-radio-group>
                </v-col>
                <v-col
                  :cols="getType && getType.name === 'ENROLLABLE' ? 6 : 12"
                  class="my-0 py-0"
                >
                  <v-select
                    v-if="getType && getType.name === 'ENROLLABLE'"
                    :rules="[(v) => !!v || 'Requerido']"
                    color="#47a5ad"
                    dense
                    outlined
                    label="Lienzo(s)"
                    :items="motorizations"
                    item-value="canvas"
                    item-text="canvas"
                    v-model="order.motor.canvas"
                  ></v-select>
                </v-col>
                <v-col cols="6" class="my-0 py-0">
                  <v-select
                    :rules="[(v) => !!v || 'Requerido']"
                    outlined
                    dense
                    color="#47a5ad"
                    label="Fabricante"
                    :items="motorizations"
                    item-text="manufacturer"
                    item-value="manufacturer"
                    v-model="order.motor.manufacturer"
                  ></v-select>
                </v-col>
                <v-col cols="12" class="my-0 py-0">
                  <span
                    >8. Seleccione características de control (opcional)</span
                  >
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
                <v-col cols="12" class="my-0 py-0">
                  <v-card
                    width="auto"
                    height="auto"
                    max-height="auto"
                    tile
                    flat
                    outlined
                  >
                    <v-toolbar dark dense color="teal lighten-2">
                      <v-toolbar-title>9. Selecciona Motor</v-toolbar-title>
                    </v-toolbar>
                    <v-list
                      two-line
                      max-height="300"
                      height="300"
                      style="overflow-y: auto"
                      tile
                      expand
                    >
                      <v-list-item-group
                        v-if="filteredControls"
                        mandatory
                        v-model="order.motor.motor"
                        active-class="teal--text"
                      >
                        <template v-for="(c, index) in filteredControls">
                          <v-list-item :key="c.id" :value="c.id">
                            <template v-slot:default="{ active }">
                              <v-list-item-content>
                                <v-list-item-title
                                  v-text="c.description"
                                ></v-list-item-title>
                                <v-list-item-subtitle
                                  class="text--primary"
                                  v-text="c.system"
                                ></v-list-item-subtitle>
                              </v-list-item-content>
                              <v-list-item-action>
                                <v-list-item-action-text>
                                  {{ c.width }} x {{ c.height }}
                                </v-list-item-action-text>
                                <v-list-item-action-text>
                                  ${{ c.price }}MXN
                                </v-list-item-action-text>
                              </v-list-item-action>
                            </template>
                          </v-list-item>
                          <v-divider
                            v-if="index < filteredControls.length - 1"
                            :key="index"
                          ></v-divider>
                        </template>
                      </v-list-item-group>
                    </v-list>
                  </v-card>
                </v-col> </v-row
              ><!--------------------------------------------------------------------------------TERMINA MODO AUTOMATICO-------->

              <v-row class="ma-2" v-else-if="order.motor.action === 'manual'"
                ><!------------------------------------------MODO MANUAL -->
                <v-item-group
                  v-model="order.motor.selected_panel"
                  v-if="getType && getType.name === 'VERTICAL'"
                >
                  <span>SELECCIONA AGRUPAMIENTO</span>
                  <v-row>
                    <v-col cols="3" v-for="v in verticales" :key="v.title">
                      <v-item v-slot="{ active, toggle }" :value="v.title">
                        <v-badge
                          bordered
                          color="#47a5ad"
                          icon="mdi-check-bold"
                          overlap
                          :value="active"
                        >
                          <v-card class="mx-auto" width="90" flat height="100">
                            <v-img
                              class="align-start text-right"
                              @click="toggle"
                              height="80"
                              width="90"
                              :src="v.img"
                            >
                            </v-img>
                            <div class="justify-center">
                              {{ v.title }}
                            </div>
                          </v-card>
                        </v-badge>
                      </v-item>
                    </v-col>
                  </v-row>
                </v-item-group>

                <v-col
                  cols="12"
                  class="my-0"
                  v-if="getType && getType.name === 'PANEL JAPONES'"
                >
                  <span>7. Selecciona el número de paneles</span>
                  <v-select
                    color="#47a5ad"
                    v-model="order.motor.panels"
                    dense
                    outlined
                    label="Número de paneles"
                    :items="paneles"
                  ></v-select>
                  <v-item-group v-model="order.motor.selected_panel">
                    <span>SELECCIONA AGRUPAMIENTO</span>
                    <v-row v-if="filteredPanels">
                      <v-col
                        :cols="12 / filteredPanels.length"
                        v-for="p in filteredPanels"
                        :key="p.title"
                      >
                        <v-item v-slot="{ active, toggle }" :value="p.title">
                          <v-badge
                            bordered
                            color="#47a5ad"
                            icon="mdi-check-bold"
                            overlap
                            :value="active"
                          >
                            <v-card
                              class="mx-auto"
                              width="90"
                              flat
                              height="100"
                            >
                              <v-img
                                class="align-start text-right"
                                @click="toggle"
                                height="80"
                                width="90"
                                :src="p.img"
                              >
                              </v-img>
                              <div class="justify-center">
                                {{ p.title }}
                              </div>
                            </v-card>
                          </v-badge>
                        </v-item>
                      </v-col>
                    </v-row>
                  </v-item-group>
                </v-col>
                <v-col cols="12" class="my-0">
                  <span>8. Seleccione Marca</span>
                  <v-radio-group
                    row
                    :mandatory="false"
                    v-model="order.motor.manufacturer"
                    :rules="[(v) => !!v || 'Requerido']"
                  >
                    <v-radio
                      color="#47a5ad"
                      label="GENÉRICO"
                      value="genérico"
                    ></v-radio>
                    <v-radio color="#47a5ad" label="VTX" value="vtx"></v-radio>
                  </v-radio-group>
                </v-col>
                <v-col cols="6" class="my-0">
                  <span>9. Seleccione color de control</span>
                  <v-select
                    color="#47a5ad"
                    :items="controlColors"
                    v-model="order.motor.control_color"
                    outlined
                    dense
                    label="Color"
                  ></v-select>
                </v-col>
                <v-col cols="6" class="my-0">
                  <span>10. Seleccione tipo de Cadena</span>
                  <v-radio-group
                    class="my-1 py-1"
                    v-model="order.motor.string_type"
                    row
                    :mandatory="false"
                    :rules="[(v) => !!v || 'Requerido']"
                  >
                    <v-radio
                      color="#47a5ad"
                      label="PLÁSTICO"
                      value="plastico"
                    ></v-radio>
                    <v-radio
                      color="#47a5ad"
                      label="METAL"
                      value="metal"
                    ></v-radio>
                  </v-radio-group>
                </v-col>
                <v-col cols="12" class="my-0" v-if="filteredGalleries">
                  <span>11. Seleccione GALERÍA/FASCIA</span>
                  <v-select
                    dense
                    v-model="order.motor.gallery"
                    :items="filteredGalleries"
                    item-text="model"
                    return-object
                    color="#47a5ad"
                    outlined
                    label="Galería/Fascia"
                  ></v-select>
                </v-col>
                <v-col cols="12" class="my-0" v-if="order.motor.gallery">
                  <span>12. Seleccione color</span>
                  <v-select
                    dense
                    v-model="order.motor.gallery_color"
                    color="#47a5ad"
                    :items="order.motor.gallery.colors"
                    item-text="color"
                    outlined
                    label="Color"
                  ></v-select>
                </v-col> </v-row
              ><!--------------------------------------------------------------------------------------------- MODO MANUAL -->
            </v-form>
            <v-card-actions>
              <v-btn dark @click="saveMotorization()" color="#47a5ad">
                GUARDAR
              </v-btn>
              <v-spacer></v-spacer>
              <v-btn dark @click="CloseMotorizationDialog()" color="red">
                CANCELAR
              </v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>
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
                  
                  v-for="c in order.canvasSize"
                  :key="c"
                >
                  <v-card flat>
                    <div class="d-flex flex-no-wrap justify-center">
                      <div >
                        <span>Lienzo {{ c }}</span>
                        <v-img
                          max-height="165"
                          max-width="255"
                          src="/img/cotizador/canvas.png"
                        >
                        <v-row no-gutters>
                          <v-col md="6" offset="6">
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
                          
                          label="alto"
                          outlined
                          single-line
                          type="number"
                          style="width: 115px; margin-top: 60px; margin-left: 10px"
                          dense
                        ></v-text-field>
                          </v-col>
                        </v-row>
                      
                           
                     <v-row no-gutters>
                       <v-col md="6" offset-md="3">
                          <v-text-field
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
                          single-line
                          :placeholder="widthMargins"
                          type="number"
                          style="width: 115px; margin: 5px auto"
                          dense
                        ></v-text-field>
                       </v-col>
                     </v-row>
                          
                       

                        
                        </v-img>
                       
                      </div>
                      <div >
                       
                      
                      </div>
                    </div>
                  </v-card>
                  <v-divider class="ma-2"></v-divider>
                </v-col>
                <v-col cols="12">
                  <div class="justify-center">
                    <v-alert outlined type="warning" border="left">
                      Si las medidas de tu persiana excenden los valores máximos permitos añade un lienzo.
                      Puedes añadir crear hasta 3 lienzos.
                    </v-alert>
                    <v-btn
                    block
                      outlined
                      v-if="order.canvasSize < 3"
                      @click="addCanvas"
                      color="#47a5ad"
                      >Añadir lienzo</v-btn
                    >
                  </div>
                </v-col>
              </v-row>
            </v-card-text>
            <v-card-actions>
              <v-btn dark block  color="#47a5ad" @click="validateCanvas">ACEPTAR</v-btn>
            </v-card-actions>
          </v-card>
        </v-form>
      </v-dialog>
    </v-row>
  </v-container>
</template>

<script>
import { mapState } from "vuex";
export default {
  name: "Quoter",
  data() {
    return {
      canvasDialog: false,
      tab: null,
      filteredGallery: {
        colors: [],
      },
      defaultfilteredGallery: {
        colors: [],
      },
      controlColors: ["BLANCO", "IVORY", "GRIS", "CHOCOLATE", "NEGRO"],
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
        line: this.$route.query.line || null,
        variant: this.$route.query.variant || null,
        color: this.$route.query.color || null,
        canvasSize: 0,
        canvas: [
          { width: null, height: null},
          { width: null, height: null},
          { width: null, height: null},
        ],
        price: 0,
        side_control: null,
        rotate: false,
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
        },
      },
      defaultOrder: {
        type: null,
        variant: null,
        canvasSize: 0,
        canvas: [
          { width: null, height: null},
          { width: null, height: null},
          { width: null, height: null},
        ],
        color: null,
        price: 0,
        rotate: false,
        side_control: null,
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
      },
      valid2: true,
      verticales: [
        { title: "Normal", img: "/img/cotizador/verticales/normal.png" },
        { title: "Inverso", img: "/img/cotizador/verticales/inverso.png" },
        { title: "Extremos", img: "/img/cotizador/verticales/extremos.png" },
        {
          title: "Extemos Inverso",
          img: "/img/cotizador/verticales/extremos-inverso.png",
        },
      ],

      paneles: [2, 3, 4, 5, 6, 8, 9],
      panelesj: [
        {
          title: "Lateral",
          img: "/img/cotizador/paneles/lateral.png",
          matches: [2, 3, 4, 5],
        },
        {
          title: "Ambos Lados",
          img: "/img/cotizador/paneles/ambos-lados.png",
          matches: [4, 5, 6, 8, 9],
        },
        {
          title: "Opuesto",
          img: "/img/cotizador/paneles/opuesto.png",
          matches: [2, 3, 4, 5],
        },
        {
          title: "Centro",
          img: "/img/cotizador/paneles/centro.png",
          matches: [3, 5],
        },
      ],
    };
  },
  methods: {
    validateCanvas() {
      if (this.$refs.canvasForm.validate()) {
        this.canvasDialog = false;
      }
    },
    addCanvas() {
      if (this.order.canvasSize <= 3) {
        this.order.canvasSize++;
      }
    },
    openCanvasDialog() {
      this.canvasDialog = true;
    },
    saveMotorization() {
      if (this.$refs.formMotor.validate()) {
        this.dialogMotorization = false;
      }
    },

    loadAditionalInfo() {
      if (this.order.motor.action === "manual") {
        this.$store.dispatch("getGalleries");
      }
    },

    CloseMotorizationDialog() {
      if (this.editable) {
        this.dialogMotorization = false;
      } else {
        this.order.motor = Object.assign({}, this.defaultMotor);
        this.$refs.formMotor.reset();
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
      if (this.$refs.form.validate()) {
        this.order.price = this.unitaryPrice;

        // this.order.motor.price = this.motorizationPrice;
        if (this.editable) {
          this.$store.dispatch("editOrder", this.order).then(() => {
            this.order = Object.assign({}, this.defaultOrder);
            this.$refs.form.reset();
            this.editable = false;
          });
        } else {
          this.$store.dispatch("addToOrder", this.order).then(() => {
            this.order = Object.assign({}, this.defaultOrder);
            this.$refs.form.reset();
          });
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

    chargeModels() {
      this.loadingModels = true;
      this.loadingModels = false;
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
    getSelectedMotor() {
      if (this.order.motor.motor !== 0) {
        console.log(this.order.motor.motor);
        return this.$store.getters.getMotor(this.order.motor.motor);
      }
    },
    btnOrderTitle() {
      return this.editable ? "terminar edición" : "agregar a la orden";
    },
    btnMotorTitle() {
      return this.editable ? "editar motorización" : "agregar motorización";
    },

    cardTitle() {
      return this.editable ? "EDITA TU PERSIANA" : "COTIZA TU PERSIANA";
    },
    filteredGalleries() {
      if (this.getType) {
        return this.galleries.filter((g) => g.type === this.getType.name);
      }
    },
    lines() {
      if (this.getType) return this.$store.getters.getLines(this.getType.slug);
    },

    filteredPanels() {
      if (this.order.motor.panels > 1) {
        return this.panelesj.filter((pj) =>
          pj.matches.some((j) => j === this.order.motor.panels)
        );
      }
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
          w = this.variant.width - this.getType.profit_margin;
          this.widthMargins = this.getType.min_width + " a " + w;
          return w;
        } else {
          w = this.getType.max_width;
          this.widthMargins = this.getType.min_width + " a " + w;
          return w;
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

    totalPrice() {
      return this.$store.getters.totalPrice;
    },
    countBlinds() {
      return this.$store.getters.countBlinds;
    },

    ...mapState({
      colors: (state) => state.modelsModule.relatedColors,
      orders: (state) => state.ordersModule.orders,
      controls: (state) => state.motorizationModule.controls,
      galleries: (state) => state.motorizationModule.galleries,
    }),

    motorizations() {
      if (this.getType && this.getType.id) {
        return this.$store.getters.getFilteredMotorizations(this.getType.name);
      }
    },

    filteredControls() {
      if(this.motorizations){
        return this.motorizations.filter(
        (c) =>
          c.canvas === this.order.motor.canvas &&
          c.manufacturer === this.order.motor.manufacturer &&
          c.motorizationType === this.order.motor.type
        );
        }
      },
      

    showRotate() {
      if (this.order.color) {
        return this.order.color.rotate === 1 ? true : false;
      }
    },

    getProduct() {
      return this.$store.getters.getTypes("PERSIANAS");
    },

    motorizationPrice() {
      if (this.order.motor.motor != 0 && this.order.motor.control != null && this.motorizations) {
        let p = parseFloat(
          this.motorizations.find((m) => m.id === this.order.motor.motor).price
        );
        let m = parseFloat(this.order.motor.control.price);
        return p + m;
      } else if (this.order.motor.motor != 0 &&  this.motorizations) {
        return parseFloat(
          this.motorizations.find((m) => m.id === this.order.motor.motor).price
        );
      } else if (this.order.motor.gallery != null) {
        return parseFloat(this.order.motor.gallery.price);
      } else {
        return 0;
      }
    },

    unitaryPrice() {
      if (this.order.canvas.length > 0 && this.variant) {
        let price = 0;
        for (let index = 0; index < this.order.canvasSize; index++) {
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

  components: {},
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