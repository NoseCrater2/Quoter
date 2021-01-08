<template>
    <v-card >
        <v-form ref="formMotor" v-model="valid" lazy-validation>
            <v-row class="ma-2">
                <span style="font-size: 1em"> Seleccionar modo de accionamiento</span>
                <v-col cols="12">
                    <v-radio-group row  :mandatory="false" :rules="[v => !!v || 'Requerido']" v-model="motor.action">
                    <v-radio color="#47a5ad" label="Manual" value="manual"></v-radio>
                    <v-radio color="#47a5ad" label="Motorizado" value="motorizado"></v-radio>
                </v-radio-group>
                </v-col>
            </v-row>
            <v-row class="ma-2" v-if="motor.action === 'motorizado'">
                <span>Seleccione tipo</span>
                <v-col cols="12">
                    <v-radio-group row :mandatory="false" @change="addTypeCriteria" :rules="[v => !!v || 'Requerido']" v-model="motor.type" >
                        <v-radio color="#47a5ad" label="Recargable (batería)" value="RECARGABLE" ></v-radio>
                        <v-radio color="#47a5ad" label="Eléctrico" value="ELECTRICO"></v-radio>
                    </v-radio-group>
                </v-col>
                <v-row>
                    <v-col cols="6">
                    <v-select
                    :rules="[v => !!v || 'Requerido']"
                    color="#47a5ad"
                    dense
                    outlined
                    label="Lienzo(s)"
                    :items="motorizations"
                    item-value="canvas"
                    item-text="canvas"
                    @change="addCanvasCriteria"
                    v-model="motor.canvas"
                    ></v-select>
                   
                </v-col>
                <v-col cols="6">
                      <v-select
                      :rules="[v => !!v || 'Requerido']"
                      outlined
                      dense
                      color="#47a5ad"
                    label="Fabricante"
                    :items="motorizations"
                    item-text="manufacturer"
                    item-value="manufacturer"
                     @change="addManufacturerCriteria"
                    v-model="motor.manufacturer"
                    ></v-select>
                </v-col>
                </v-row>
                
                <v-col cols="12">
                    <v-select
                    outlined
                    color="#47a5ad"
                    clearable
                    clear-icon="mdi-close-circle"
                    label="Canal(es) de Control Remoto"
                    :items="controls"
                    item-text="channel"
                    return-object
                    placeholder="Sin Control"
                    ></v-select>
                </v-col>
                <v-col cols="12">
                    <v-card  width="auto" height="auto" max-height="auto" tile flat>
                    <v-toolbar dark dense color="teal lighten-2">
                        <v-toolbar-title>SELECCIONA CONTROL</v-toolbar-title>
                    </v-toolbar>
                    <v-list  two-line max-height="300" height="300" style="overflow-y: auto" tile expand>
                        <v-list-item-group
                        mandatory
                       v-model="selected"
                        active-class="teal--text">
                            <template v-for="(c, index ) in filteredControls">
                                <v-list-item :key="c.id">
                                    <template v-slot:default="{active }">
                                        <v-list-item-content>
                                            <v-list-item-title v-text="c.description"></v-list-item-title>
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
                                               ${{c.price}}MXN
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
                    <!-- <v-data-table
                    :items="filteredControls"
                    :headers="cHeaders"
                    ></v-data-table> -->
                     <!-- <v-select
                    label="Motor"
                    :items="filteredControls"
                    item-text="price"
                    return-object
                    ></v-select> -->
                </v-col>
                <v-col cols="12">
                    <v-btn dark @click="saveMotorization()" block color="#47a5ad">
                        GUARDAR
                    </v-btn>
                    <v-btn dark block @click="intentCloseDialog()" color="red">
                        CANCELAR
                    </v-btn>
                </v-col>
            </v-row >

            <v-row class="ma-2" v-else-if="motor.action === 'manual'">
                <span>Accion manual seleccionada</span>
            </v-row>
        </v-form>
    </v-card>
</template>

<script>

function filterArray(array, filters) {
    console.log(filters)
  const filterKeys = Object.keys(filters);
  return array.filter(item => {
    // validates all filter criteria
    return filterKeys.every(key => {
      // ignores non-function predicates
      if (typeof filters[key] !== 'function') return true;
      return filters[key](item[key]);
    });
  });
}

import { mapActions, mapState } from 'vuex';
export default {
    data(){
        return{
            selected: null,
            select: null,
            motor:{
                action: null,
                type: null,
                canvas: null,
                manufacturer: null,
            },
            cHeaders:[
                {
                    text: 'Código',
                    align: 'start',
                    sortable: false,
                    value: 'code',
                },
                { text: 'Lienzo', value: 'canvas' },
                { text: 'Sistema', value: 'system' },
                { text: 'Descripción', value: 'description' },
                { text: 'Ancho', value: 'width' },
                { text: 'Alto', value: 'height' },
                { text: 'Via', value: 'via' },
                { text: 'Tipo', value: 'type' },
                { text: 'Fabricante', value: 'manufacturer' },
            ],
            valid: true,
            criteria: {
                motorizationType: ['RECARGABLE', 'ELECTRICO'],
                canvas: [1,2,3],
                manufacturer: ['VERTILUX', 'TUBE','B-MIGHTY','MOVATTI','SOMFY']
            }
        }
    },

    methods:{
        saveMotorization(){
             if(this.$refs.formMotor.validate()){
                console.log(this.filteredControls[this.selected])
                this.$refs.formMotor.reset() 
             }
        },
        intentCloseDialog(){
            this.$refs.formMotor.reset() 
            this.$emit('closeDialog')
        },
        addCanvasCriteria(){
             this.criteria.canvas = [this.motor.canvas]
            
        },

        addManufacturerCriteria(){
          this.criteria.manufacturer = [this.motor.manufacturer]
        },

        addTypeCriteria(){
            this.criteria.motorizationType = [this.motor.type]
        }
    },

    computed: {
        ...mapState({
            motorizations: state => state.motorizationModule.filteredMotorizations,
            controls: state => state.motorizationModule.controls,
        }),

        getype(){
            if(this.getType){
                 this.$store.dispatch('getFilteredMotorizations', this.getType.id)
            this.$store.dispatch('getControls')
            }
          
        },

        filteredControls(){
           return  this.motorizations.filter(
               c => (c.canvas === this.motor.canvas &&
                    c.manufacturer === this.motor.manufacturer &&
                    c.motorizationType === this.motor.type
                ))
        }


    },

    mounted(){
    
        
    },

    props:{
        getType :{
            type: Object,
        }
    }
}
</script>