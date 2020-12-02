<template>
 <!-- :src="`../../img/persianas/${idProduct}.jpg`" -->
  <div id="app" :style="selectedType?`background-image: url('../../img/persianas/${selectedType.id}.jpg')`:''" style="background-size: cover;">
      <v-row  justify="center" >
          <v-card max-width="1000" class="ma-1" :height="scHeight-150" :max-height="scHeight" style="background-color: #ffffffc2">
            <v-card-title style="background-color: #404042; color: white" >
               Persiana {{ countBlinds + 1}}
              <v-spacer></v-spacer>
              <v-tooltip top>
                <template v-slot:activator="{ on, attrs }">
                  <v-btn fab class="mx-2" v-bind="attrs"  @click="addBlind()" v-on="on"> <v-icon>mdi-plus</v-icon></v-btn>
                </template>
                <span>Agregar persiana a la orden</span>
             </v-tooltip>
              <v-tooltip top>
           <template v-slot:activator="{ on, attrs }">
                <v-btn fab class="mx-2" v-bind="attrs"  v-on="on"> <v-icon>mdi-cog-clockwise</v-icon></v-btn>
            </template>
            <span>Agregar motorización</span>
        </v-tooltip>
               <v-snackbar centered v-model="alertSuccess" dark color="#47a5ad" :timeout="2000">Persiana añadida al pedido</v-snackbar>
                    <v-tooltip top>
                      <template v-slot:activator="{ on, attrs }">
                        <v-badge :content="countBlinds" :value="countBlinds" color="#47a5ad" overlap bordered left >
                            <v-btn fab class="mx-2"  v-bind="attrs"  v-on="on" @click="dialog = true" > <v-icon>mdi-clipboard-list</v-icon></v-btn>
                         </v-badge>
                      </template>
                      <span>Ver Persianas</span>
                    </v-tooltip>
               </v-card-title>
             
            <v-form ref="form" v-model="valid" lazy-validation>
              <v-col cols="12" md="12" sm="12" class="py-0">   
                  <span style="font-size: 1.1em"> 1.Seleccione tipo de persiana</span>
                     <v-autocomplete
                     :rules="[v => !!v || 'Requerido']"
                     @change="chargeModels(selectedType)"
                     dense
                    :items="types"
                    item-text="name"
                    v-model="selectedType"
                    return-object
                    label="Selecciona tu persiana"
                    outlined
                    color="#47a5ad"
                    background-color="white"
                    :menu-props="{ bottom: true, offsetY: true }"
                    ></v-autocomplete>
                </v-col> 

                <v-row class="mx-1">
                    <v-col cols="12" md="6" sm="12" class="py-0" >
                        <span style="font-size: 1.1em"> 2.Seleccione características</span>
                        <v-select
                        :rules="[v => !!v || 'Requerido']"
                        :loading="loadingModels"
                        :disabled="disabledSelectModel"
                        dense
                        v-model="selectedModel"
                        :items="variants"
                        return-object
                        item-text="name"
                        @change="chargeColors(selectedModel)"
                        outlined
                        color="#47a5ad"
                        background-color="white"
                        label="Modelo"
                        :menu-props="{ bottom: true, offsetY: true }"
                        ></v-select>

                        <v-select
                        :rules="[v => !!v || 'Requerido']"
                         :loading="loadingColors"
                        :disabled="disabledSelectColor"
                        dense
                        return-object
                        v-model="selectedColor"
                        :items="colors"
                        item-text="color"
                        outlined
                        @change="selectColor(selectedColor)"
                        color="#47a5ad"
                        background-color="white"
                        label="Color"
                        :menu-props="{ bottom: true, offsetY: true }"
                        ></v-select>
                    </v-col>
                  

                    <v-col cols="12" md="6" sm="12" align-self="center" class="py-0">
                        <div class="d-flex justify-center" >
                           <v-img 
                            :src="`../../img/modelos/medium/${selectedColor.code}.jpg`"
                            max-width="200"  
                            max-height="200" 
                           v-if="selectedColor"
                          
                            >
                            </v-img>
                            <v-img 
                            :src="`../../img/black-r.png`"
                            max-width="200"  
                            max-height="200" 
                             style="border: 1px solid gray"
                          v-else
                            ></v-img>
                        </div>
                    </v-col>
                </v-row>

     
                 
                     <v-switch
                     v-if="showRotate"
                     class="ml-5"
                     @change="setRotateMargins(switch1)"
                      v-model="switch1"
                      label="Rotar"
                      ></v-switch>


                <v-row class="mx-1">
                   <span  style="font-size: 1.1em"> 3.Seleccione las medidas (EL mínimo a cobrar es 1.0 x 1.0)</span>
                    <v-col cols="12" md="6" sm="6" xs="6" class="py-0">
                        <v-tooltip
                        bottom
                        nudge-bottom="-37"
                        v-model="appearToolTipInvalidMeasures"
                        >
                            <template v-slot:activator="{ on }">
                                <v-text-field
                                :disabled="disabledSelectSize" 
                                dense
                                type="number"
                                label="Ancho"
                                v-on="on"
                                :placeholder="widthMargins"
                                outlined
                                color="#47a5ad"
                                 background-color="white"
                                v-model="persWidth"
                                :rules="[...widthRules(selectedType?selectedType.min_width:0, maxwidth)]"
                                ></v-text-field>
                            </template>
                            <span>Ancho fuera de rango</span>
                        </v-tooltip>
                  </v-col>
              <!-- "   @input="validateMeasuresRegex(selectedType.min_width, maxwidth)"
              @change="validateMeasuresRegex(this, selectedType.min_height, maxheight)"-->
                  <v-col cols="12" md="6" sm="6" xs="6" class="py-0"> 
                      <v-tooltip bottom nudge-bottom="-37">
                          <template v-slot:activator="{ on, attrs }">
                              <v-text-field
                              :disabled="disabledSelectSize"
                             :rules="[...heightRules(selectedType?selectedType.min_height:0, maxheight)]"
                              dense
                              type="number"
                              label="Alto"
                              v-bind="attrs"
                               background-color="white"
                              v-on="on"
                              :placeholder="heightMargins"
                              outlined
                              color="#47a5ad"
                                v-model="persHeight"
                              ></v-text-field>
                          </template>
                          <span>Alto fuera de rango</span>
                      </v-tooltip>
                  </v-col>
                </v-row>

                <v-row class="mx-1">
                    <v-col cols="12" md="6" sm="12" class="py-0">
                     <span style="font-size: 1.1em"> 4.Seleccione lado del control </span>
                      <v-radio-group :mandatory="false" :rules="[v => !!v || 'Requerido']" v-model="sideControl">
                        <v-radio label="Izquierda" value="left"></v-radio>
                        <v-radio label="Derecha" value="rigth"></v-radio>
                      </v-radio-group>
                    </v-col>
                    <v-col>
                    <div class="d-flex justify-center">
                       <b>PRECIO UNITARIO:</b> 
                    </div>
                    <div class="d-flex justify-center" style="font-size: 2.5em; color: #47a5ad" >
                      <div class="display-1 d-inline-flex" style="color: #47a5ad; margin-top: 10px">$ </div>
                        <div  class="display-2 d-inline-flex" style="color: #47a5ad; font-weight: bolder;">{{unitaryPrice}}</div>
                        <div class="display-1 d-inline-flex" style="color: #47a5ad; margin-top: 10px">MXN </div>
                    </div>
                    </v-col>
                </v-row>
           

       
      
      <!-- <v-btn
      width="300px"
        block
        class="mb-1 mt-n2"
        dark
        @click="typeId != null ? modifyClassReceiveSteps() : ''"
        >Configurar</v-btn> -->
      </v-form>
      </v-card>
</v-row>

  <!-- <v-card
        class="mx-auto my-auto"
        width="500"
        elevation="9"
        color="rgba(255,255,255,0.8)"
        :style="classReceiveSteps"
      >
        <Quoter @modifyClassReceiveSteps="modifyClassReceiveSteps"></Quoter>
      </v-card>
      <div
        class="d-flex flex justify-center"
        v-if="classReceiveSteps != null"
        id="scrollito"
        :style="classAddingStepsSection"
      >
        <BlindSteps></BlindSteps>
      </div> -->
<!-- 
<v-card class="mx-auto my-4" width="1000"  tile v-if="classReceiveSteps != null"
        id="scrollito"
        :style="classAddingStepsSection">
      <v-col>
        <div class="d-flex align-center mb-3">
          <div class="ml-auto">
            <v-btn fab large depressed dark>
              <v-icon>mdi-plus</v-icon>
            </v-btn>
            <v-btn fab large depressed dark>
              <v-icon>mdi-calculator</v-icon>
            </v-btn>
          </div>
        </div>

        <v-card>
          <v-toolbar flat color="grey" dark>
            <v-icon class="mr-1">mdi-blinds</v-icon>
            <v-toolbar-title>Persiana 1</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-btn icon fab depressed dark>
              <v-icon>mdi-pen</v-icon>
            </v-btn>
            <v-btn icon fab depressed dark class="mr-1 ml-3">
              <v-icon>mdi-trash-can</v-icon>
            </v-btn>
          </v-toolbar>
          <v-card-text>
             <div class="mt-n2 mb-2">
              <span class="display-1 text--primary"
                >PASO 2 Ingrese las medidas requeridas</span
              >
            </div>
            <span class="text-body-1 text--primary"
              >Las medidas deben estar dadas en metros (m)</span
            >
            <br />
            <br />
            <v-row>
              <v-col cols="6" md="6" sm="6" xs="6">
                <v-tooltip
                  bottom
                  nudge-bottom="-37"
                  :open-on-hover="false"
                  :open-on-click="false"
                  :open-on-focus="false"
                  v-model="appearToolTipInvalidMeasures"
                >
                  <template v-slot:activator="{ on }">
                    <v-text-field
                      type="tel"
                      label="Ancho"
                      v-on="on"
                      placeholder=".6 a 3.5"
                      outlined
                      v-model="persWidth"
                      
                    ></v-text-field>
                  </template>
                  <span>Ancho fuera de rango</span>
                </v-tooltip>
              </v-col>
              <v-col cols="6" md="6" sm="6" xs="6">
                <v-tooltip bottom nudge-bottom="-37" :open-on-focus="true">
                  <template v-slot:activator="{ on, attrs }">
                    <v-text-field
                      type="tel"
                      label="Alto"
                      v-bind="attrs"
                      v-on="on"
                      placeholder=".6 a 3"
                      outlined
                    ></v-text-field>
                  </template>
                  <span>Alto fuera de rango</span>
                </v-tooltip>
              </v-col>
            </v-row>
            <div class="my-3">
              <span class="display-1 text--primary"
                >PASO 3 Seleccione características</span
              >
            </div>
            <v-row>
              <v-col cols="12" md="12" sm="12" xs="8">
             
              </v-col>
            </v-row>
            <v-row class="mb-6">
              <v-col cols="12" md="6" sm="12" xs="8">
               
              </v-col>
              <v-col cols="12" md="6" sm="12" xs="8">
                <v-img
                  lazy-src="/storage/img/persiana.jpg"
                  height="auto"
                  width="auto"
                  src="/storage/img/persiana.jpg"
                ></v-img>
              </v-col>
            </v-row>
           

            <v-radio-group :mandatory="false">
              <v-radio label="Manual" value="radio-1"></v-radio>
              <v-radio label="Motorizado" value="radio-2"></v-radio>
            </v-radio-group>
            <v-radio-group :mandatory="false">
              <v-radio label="Izquierda" value="radio-3"></v-radio>
              <v-radio label="Derecha" value="radio-4"></v-radio>
            </v-radio-group>
            <br />
            <div class="mt-n2">
              <span class="display-1 text--primary"
                >PASO 5 Seleccione agrupamiento</span
              >
            </div>
            <div class="d-flex justify-center mt-5">
              <v-img
                lazy-src="/storage/img/agrupamientos.jpg"
                height="auto"
                width="auto"
                src="/storage/img/agrupamientos.jpg"
              ></v-img>
            </div>
            <br />
            <br />
            <div class="mt-n2">
              <span class="display-1 text--primary">PASO 6 Galeria</span>
            </div>
            <v-radio-group :mandatory="false">
              <v-radio label="Galeria portatela" value="radio-1"></v-radio>
              <v-radio
                label="Galeria PVC con cubrepolvo"
                value="radio-2"
              ></v-radio>
            </v-radio-group>
            <br />
            <div class="mt-n2 mb-3">
              <span class="display-1 text--primary"
                >PASO 7 Sistema de motorización</span
              >
            </div>
            <v-row>
              <v-col cols="12" md="6" sm="12" xs="8">
                <v-select
                  outlined
                  color="black"
                  background-color="white"
                  label="Sistema"
                  :menu-props="{ bottom: true, offsetY: true }"
                ></v-select>
              </v-col>
              <v-col cols="12" md="6" sm="12" xs="8">
                <v-select
                  outlined
                  color="black"
                  background-color="white"
                  label="Opciones"
                  :menu-props="{ bottom: true, offsetY: true }"
                ></v-select>
              </v-col>
            </v-row>
            <br />
            <v-sheet color="grey" class="mx-n4 mb-8">
                  <div class="ml-4 d-flex align-center">
                    <span class="text-h5 mt-5 white--text">Marco</span>
                  </div>
                  <v-radio-group class="ml-4" row dark>
                    <v-radio
                      label="Fuera"
                      value="radio-1"
                      class="mr-16"
                    ></v-radio>
                    <v-radio label="Dentro" value="radio-2"></v-radio>
                  </v-radio-group>
                </v-sheet>
             <v-col cols="12" md="6" sm="12" xs="8">
                      <v-img
                        src="https://picsum.photos/510/300?random"
                        max-height="330"
                        min-height="330"
                        max-width="auto"
                        min-width="auto"
                        class="mt-3"
                      ></v-img>
                    </v-col>
            <br />
            <br />
            <span class="text-h5 text--primary">Zona</span>
            <br />
            <v-textarea
              class="mt-4"
              name="input-7-1"
              filled
              outlined
              auto-grow
            ></v-textarea>
            <v-btn block color="secondary" dark>Terminar esta persiana</v-btn>
          </v-card-text>
        </v-card>
      </v-col>
    </v-card> -->
   <v-dialog v-model="dialog" width="600">
     <Order/>
   </v-dialog>

  </div>
</template>

<script>

import Order from './Order';
import { mapActions, mapState } from 'vuex';
export default {
  name: "Quoter",
  data() {
    return {
       scHeight : screen.height,
      alertSuccess: false,
      dialog: false,
      sideControl: null,
      order:{
        id: 0,
        type: null,
        variant: null,
        color: null,
        width: 0,
        height: 0,
        price: 0,
        control: null,
        quantity: 1,
      },
      valid: true,
      persHeight: null,
      switch1: false,
      rotate: false,
      maxwidth: 0,
      maxheight: 0,
      heightMargins: null,
      widthMargins: null,
      selectedType: null,
      selectedModel: null,
      selectedColor: null,
      disabledSelectModel: true,
      loadingModels: false,
      disabledSelectColor: true,
      loadingColors: false,
      disabledSelectSize: true,

       persWidth: null,
      appearToolTipInvalidMeasures: false,
    };
  },
  methods: {

    addBlind(){
      if(this.$refs.form.validate()){
        this.order.id = this.countBlinds + 1
        this.order.type = this.selectedType.name
        this.order.variant = this.selectedModel.name
        this.order.color = this.selectedColor.color
        this.order.width = this.persWidth
        this.order.height = this.persHeight
        this.order.price = this.unitaryPrice
        this.order.control = this.sideControl
        console.log(this.order)
        this.$store.dispatch('addToOrder',this.order).then(()=>{
          this.resetVariables()
          this.alertSuccess = true
         
        })
      }
      
    },

    resetVariables(){
       this.$refs.form.reset()
      this.order = {
        id: 0,
        type: null,
        variant: null,
        color: null,
        width: 0,
        height: 0,
        price: 0,
        control: null,
        quantity: 1,
      } 
    },

    widthRules(min, max){
      let n = parseFloat(this.persWidth);
       return (!isNaN(n) && n >= min && n <= max) || 'Requerido'
    },

    heightRules(min, max){
      let n = parseFloat(this.persHeight);
       return (!isNaN(n) && n >= min && n <= max) || 'Requerido'
    },

    chargeModels(type){
        this.loadingModels = true
       
        this.$store.dispatch('getVariants', type.id).then(()=>{
            this.loadingModels = false
            this.disabledSelectModel= false
           this.selectedColor = null
           this.heightMargins = null 
           this.widthMargins = null
        })
    },

    chargeColors(model){
      this.selectedColor = null
      this.loadingColors = true
        this.$store.dispatch('getRelatedColors', model.id).then(()=>{
          this.loadingColors = false
          this.disabledSelectColor = false
          this.disabledSelectSize = false
           this.calculateMargins()
          
        })
    },

    selectColor(selectedColor){
      if(selectedColor.rotate){
        this.rotate = true
      }else{
        this.rotate = false
      }
    },
    //  modifyClassReceiveSteps(style) {
    //   this.$emit("modifyClassReceiveSteps", "");
    //   this.classReceiveSteps = true;
    //   this.scrollToSteps();
    // },

    calculateMargins(){
      if(this.selectedType.max_width <= 0){
       this.maxwidth =  (this.selectedModel.width - this.selectedType.profit_margin)
      }else{
        this.maxwidth = this.selectedType.max_width
      }

       if(this.selectedType.max_height <= 0){
       this.maxheight =  this.maxwidth
      }else{
        this.maxheight = this.selectedType.max_height
      }

      this.widthMargins = this.selectedType.min_width+' a '+this.maxwidth
      this.heightMargins = this.selectedType.min_height+' a '+this.maxheight

    },

    setRotateMargins(switch1){
      if(switch1){
        this.maxwidth = this.selectedType.max_width_rot
        this.maxheight = this.selectedType.max_height_rot
         this.widthMargins = this.selectedType.min_width+' a '+this.maxwidth
      this.heightMargins = this.selectedType.min_height+' a '+this.maxheight
      }else{
        this.calculateMargins()
      }
    },

 

  },

   updated() {
    //this.scrollToSteps();
  },




  mounted(){
    this.$store.dispatch('getTypes')
  },

  computed: {

    countBlinds(){
            return this.$store.getters.countBlinds
        },

     ...mapState({
      types: state => state.modelsModule.types,
      colors: state => state.modelsModule.relatedColors,
      variants: state => state.productsModule.variants,
    }),
    showRotate(){
      console.log(this.selectedColor)
      if(this.selectedColor){
        return this.selectedColor.rotate === 1?true:false
      }
    },

    unitaryPrice(){
      if(this.selectedModel){
        if(this.persWidth >= 1 && this.persHeight >= 1 ){
           return this.selectedModel.price * this.persWidth * this.persHeight
        }
        else if(this.persWidth >= 1 ){
           return this.selectedModel.price * this.persWidth
        }else if(this.persHeight >= 1){
           return this.selectedModel.price * this.persHeight
        }
        else{
           return this.selectedModel.price
        }
       
      }else{
        return 0
      }

    }

  },

  components:{
    Order
  }

};
</script>

<style scoped>

</style>