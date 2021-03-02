<template>
    <div>
          <v-card height="auto" width="auto" max-width="600" min-width="300">
             <v-card-title  v-if="action === 'Motorizado'">
                  <strong style="font-style: italic; color:#47a5ad ">Persiana Motorizada</strong>
                </v-card-title>
                 <v-card-title  v-else-if="action === 'Manual'">
                  <strong style="font-style: italic; color:#47a5ad ">Persiana Manual</strong>
                </v-card-title>
            <v-form ref="formMotor" v-model="valid2" lazy-validation>
              <v-col cols="12" class="my-0 py-0">
                  <span class="mx-2">5. Seleccione lado del motor</span>
                  <v-radio-group
                  row
                  :mandatory="false"
                  :rules="[(v) => !!v || 'Requerido']"
                  v-model="motor.side_control">
                <v-radio color="#47a5ad" label="Izquierdo" value="Izquierdo"></v-radio>
                <v-radio color="#47a5ad" v-if="(typeName != 'FLEXIBALET' || action != 'Motorizado')" label="Derecho" value="Derecho"></v-radio>
              </v-radio-group>
                </v-col>

           
                <v-col
                  cols="12"
                  v-if="typeName == 'PANEL JAPONES'"
                  class="my-0"
                >
                  <span>6. Selecciona el número de vías</span>
                  <v-select
                    color="#47a5ad"
                    v-model="motor.panels"
                    dense
                    outlined
                    label="Número de paneles"
                    :items="paneles"
                  ></v-select>
                  <v-item-group v-model="motor.selected_panel">
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

                <v-col
                cols="12"
                v-if="typeName == 'FLEXIBALET' || typeName == 'VERTICAL'"
                class="my-0">
                 <v-item-group
                  v-model="motor.selected_panel"
                 
                >
                
                  <span>SELECCIONA AGRUPAMIENTO</span>
                  <v-row>
                    <v-col cols="3" v-for="f in flexballets" :key="f.title">
                      <v-item v-slot="{ active, toggle }" :value="f.title">
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
                              :src="f.img"
                            >
                            </v-img>
                            <div class="justify-center">
                              {{ f.title }}
                            </div>
                          </v-card>
                        </v-badge>
                      </v-item>
                    </v-col>
                  </v-row>
                </v-item-group>
                  <span style="font-size: 1em">
                  7 .Elige el tipo de instalación
                </span>
                <v-radio-group
                :rules="[(v) => !!v || 'Requerido']"
                row
                :mandatory="false"
                v-model="motor.instalation_side"
                >
                  <v-radio label="A techo"  color="#47a5ad" value="techo"></v-radio>
                  <v-radio label="A pared"  color="#47a5ad" value="pared"></v-radio>
                </v-radio-group>
                 <span style="font-size: 1em">
                  8 .Marco
                </span>
                <v-radio-group
                :rules="[(v) => !!v || 'Requerido']"
                row
                :mandatory="false"
                v-model="motor.frame"
                >
                  <v-radio label="Fuera"  color="#47a5ad" value="fuera"></v-radio>
                  <v-radio label="Adentro"  color="#47a5ad" value="adentro"></v-radio>
                </v-radio-group>
                <span style="font-size: 1em">
                  9 .Riel
                </span>
                <v-select
                v-model="motor.rail_color"
                dense
                outlined
                :items="['BLANCO', 'IVORY']"
                label="Color"
                ></v-select>
                </v-col>

                <v-col
                cols="12"
                v-if="typeName == 'HORIZONTAL DE MADERA 2' && action == 'Manual'"
                class="my-0">
                  <span style="font-size: 1em">
                  7 .Selecciona accionamiento
                </span>
                <v-radio-group
                :rules="[(v) => !!v || 'Requerido']"
                row
                :mandatory="false"
                v-model="motor.drive"
                >
                  <v-radio label="Escalerilla"  color="#47a5ad" value="escalerilla"></v-radio>
                  <v-radio label="Cinta"  color="#47a5ad" value="cinta"></v-radio>
                </v-radio-group>
                 <span style="font-size: 1em">
                  8 .Marco
                </span>
                <v-radio-group
                :rules="[(v) => !!v || 'Requerido']"
                row
                :mandatory="false"
                v-model="motor.frame"
                >
                  <v-radio label="Fuera"  color="#47a5ad" value="fuera"></v-radio>
                  <v-radio label="Adentro"  color="#47a5ad" value="adentro"></v-radio>
                </v-radio-group>
                </v-col>

                <v-col
                cols="12"
                v-if="(typeName == 'HORIZONTAL DE MADERA 2' && action == 'Motorizado') || 
                      (typeName == 'HORIZONTAL DE ALUMINIO 1\'\'' && action == 'Manual') ||
                      (typeName == 'HORIZONTAL DE ALUMINIO 2\'\'' && action == 'Manual')"
                class="my-0">
                
                 <span style="font-size: 1em">
                  8 .Marco
                </span>
                <v-radio-group
                :rules="[(v) => !!v || 'Requerido']"
                row
                :mandatory="false"
                v-model="motor.frame"
                >
                  <v-radio label="Fuera"  color="#47a5ad" value="fuera"></v-radio>
                  <v-radio label="Adentro"  color="#47a5ad" value="adentro"></v-radio>
                </v-radio-group>
                </v-col>

          

            

              <v-row
               v-if="(action == 'Motorizado') && (typeName === 'ENROLLABLE' || typeName === 'ROMANA')"
                class="ma-0 pa-0">

                <span class="mx-2"  >6. Seleccione características de motor</span>
                <v-col
                  cols="12"
                  class="my-0 py-0"
                 
                >
                  <v-radio-group
                    row
                    :mandatory="false"
                    :rules="[(v) => !!v || 'Requerido']"
                    v-model="motor.type"
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
                <v-col cols="6" class="my-0 py-0" >
                  <v-select
                    :rules="[(v) => !!v || 'Requerido']"
                    outlined
                    dense
                    color="#47a5ad"
                    label="Fabricante"
                    :items="motorizations"
                    item-text="manufacturer"
                    item-value="manufacturer"
                    v-model="motor.manufacturer"
                  ></v-select>
                </v-col>
                <v-col cols="12" class="my-0 py-0" >
                  <span
                    >7. Seleccione características de control (opcional)</span
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
                    v-model="motor.control"
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
                      <v-toolbar-title>8. Selecciona Motor</v-toolbar-title>
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
                        v-model="motor.motor"
                        active-class="teal--text"
                      >
                        <template v-for="(c, index) in filteredControls">
                          <v-list-item :key="c.id" :value="c.id">
                            <template>
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
                </v-col>
               
                </v-row>

              <v-row class="ma-2" v-if="(action == 'Manual') && (typeName === 'ENROLLABLE' || typeName === 'ROMANA')">

                <v-col cols="12" class="my-0">
                  <span>7. Seleccione Marca</span>
                  <v-radio-group
                    row
                    :mandatory="false"
                    v-model="motor.manufacturer"
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
                <v-col cols="6" class="my-0" >
                  <span>8. Seleccione color de control</span>
                  <v-select
                    color="#47a5ad"
                    :items="controlColors"
                    v-model="motor.control_color"
                    outlined
                    dense
                    label="Color"
                  ></v-select>
                </v-col>
                <v-col cols="6" class="my-0" >
                  <span>9. Seleccione tipo de Cadena</span>
                  <v-radio-group
                    class="my-1 py-1"
                    v-model="motor.string_type"
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
                
                
                </v-row>
              <v-col 
              cols="12" 
              class="my-0" 
              v-if="filteredGalleries && typeName != 'PANEL JAPONES' && typeName != 'FLEXIBALET' && typeName != 'HORIZONTAL DE MADERA 2' && typeName != 'VERTICAL' && ((action == 'Manual') || (typeName != 'ENROLLABLE' && typeName != 'ROMANA' ))" >
                  <span>10. Seleccione GALERÍA/FASCIA</span>
                  <v-select
                    dense
                    v-model="motor.gallery"
                    :items="filteredGalleries"
                    item-text="model"
                    return-object
                    color="#47a5ad"
                    outlined
                    label="Galería/Fascia"
                  ></v-select>
                </v-col>
                <v-col cols="12" class="my-0" v-if="motor.gallery">
                  <span>11. Seleccione color (opcional)</span>
                  <v-select
                    dense
                    v-model="motor.gallery_color"
                    color="#47a5ad"
                    :items="motor.gallery.colors"
                    item-text="color"
                    outlined
                    label="Color"
                  ></v-select>
                </v-col>
              <v-col cols="12" class="my-0" >
                  
                  <v-textarea
                    v-model="motor.comment"
                    color="#47a5ad"
                    outlined
                    height="100"
                    label="Observaciones"
                  ></v-textarea>
                </v-col>
            </v-form>
            <v-card-actions>
              <v-btn dark @click="save()" color="#47a5ad">
                GUARDAR
              </v-btn>
              <v-spacer></v-spacer>
              <v-btn dark @click="close()" color="red">
                CANCELAR
              </v-btn>
            </v-card-actions>
          </v-card>
    </div>
</template>

<script>
import { mapState } from "vuex";
export default {
    data(){
        return{
            valid2: true,
            motor: {
                side_control: null,
                price: 0,
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
                comment: null,//nueva
                instalation_side: null,//nueva
                frame: null,//nueva
                rail_color: null,//nueva
                drive: null,
            },
            defaultMotor: {
                side_control: null,
                price: 0,
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
            controlColors: ["BLANCO", "IVORY", "GRIS", "CHOCOLATE", "NEGRO"],
             verticales: [
                { title: "Normal", img: "/img/cotizador/verticales/normal.png" },
                { title: "Inverso", img: "/img/cotizador/verticales/inverso.png" },
                { title: "Extremos", img: "/img/cotizador/verticales/extremos.png" },
                {title: "Extemos Inverso",img: "/img/cotizador/verticales/extremos-inverso.png",},
            ],
            flexballets: [
                { title: "Izquierda", img: "/img/cotizador/flexballet/izquierda.png" },
                { title: "Derecha", img: "/img/cotizador/flexballet/derecha.png" },
                { title: "Central", img: "/img/cotizador/flexballet/central.png" },
                {title: "Exterior",img: "/img/cotizador/flexballet/exterior.png",},
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
        }
    },

    props:{
        typeName : {
            type: String,
            required: true,
        },
        parentMotor: {
            type: Object,
            required: false,
        },
        action: {
          type: String,
          required: true,
        },
        canvas:{
          type: Number,
          required: true,
        },
    },

    created(){
        this.motor = Object.assign({}, this.parentMotor);
        this.$store.dispatch("getGalleries");
    },

    methods:{
        close(){
             this.motor = Object.assign({}, this.defaultMotor);
             this.$refs.formMotor.reset();
            this.$emit('CloseMotorizationDialog')
        },

        save(){
          if(this.action === 'Motorizado'){
            if(this.$refs.formMotor.validate() && this.motor.motor > 0){
              this.motor.price = this.motorizationPrice
              this.$emit('saveMotorization', this.motor)
              this.close()
            }
          }else if(this.action === 'Manual'){
            if(this.$refs.formMotor.validate()){
              this.motor.price = this.motorizationPrice
              this.$emit('saveMotorization', this.motor)
              this.close()
            }
          }
          
           
        }
    },

    computed:{

        ...mapState({
            controls: (state) => state.motorizationModule.controls,
            galleries: (state) => state.motorizationModule.galleries,
            motorizations: (state) => state.motorizationModule.motorizations,
        }),

         filteredControls() {
              let m =  this.motorizations.filter((c) => c.canvas == this.canvas && c.manufacturer == this.motor.manufacturer && c.motorizationType == this.motor.type);
              return m

        },

        filteredGalleries() {
            if (this.typeName) {
                return this.galleries.filter((g) => g.type === this.typeName);
            }
        },

         filteredPanels() {
                if (this.motor.panels > 1) {
                    return this.panelesj.filter((pj) =>
                    pj.matches.some((j) => j === this.motor.panels)
                );
            }
        },

        motorizationPrice() {
            if (this.motor.motor != 0 && this.motor.control != null && this.motorizations) {
              let p = parseFloat(
                this.motorizations.find((m) => m.id === this.motor.motor).price
              );
              let m = parseFloat(this.motor.control.price);
              return p + m;
            } else if (this.motor.motor != 0 &&  this.motorizations) {
              return parseFloat(
                this.motorizations.find((m) => m.id === this.motor.motor).price
              );
            } else if (this.motor.gallery != null) {
              return parseFloat(this.motor.gallery.price);
            } else {
              return 0;
            }
        },
    }
}
</script>