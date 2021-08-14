<template>
    <div>
        <v-card tile flat>
            <v-tabs v-model="tab" background-color="white" show-arrows color="#47a5ad" >
                <v-tab v-for="(o, index) in localOrders" :key="o.id"> PERSIANA {{ index + 1 }} </v-tab>
            </v-tabs>
        </v-card>
        <v-tabs-items  v-model="tab" >
            <v-tab-item v-for="(o, index) in localOrders" :key="o.id">
               <v-progress-linear
               v-if="$store.state.productsModule.variants.length == 0"
              color="#47a5ad"
              indeterminate
              rounded
              height="6"
              ></v-progress-linear>
                <v-card tile flat v-else>
                  <v-toolbar dense>
                    <v-toolbar-title>
                      TOTAL: {{
                        mxCurrencyFormat.format(
                          o.price +
                          o.motor.price +
                          o.motor.flexiballetPrice +
                          o.motor.galleryPrice +
                          o.motor.manufacturerPrice +
                          o.motor.stringPrice
                        )}} MXN
                    </v-toolbar-title>
                  </v-toolbar>

                  <v-row no-gutters>
                    <v-col :cols="o.variant2 != null?'6':'12'">
                      <v-card flat>
                        <v-card-title  class="py-2 px-4 justify-center" style="line-height: normal; font-size: 0.7em; font-weight: bolder">
                          {{$store.getters.getVariant(o.variant).name}}
                        </v-card-title>
                        <v-divider ></v-divider>
                        <div class="d-flex flex-xs-column justify-space-around">
                          <div >
                            <v-card-subtitle class="overline" style="line-height: normal">
                              <div class="d-inline" style="font-weight: bolder; color:black">TIPO:</div>
                              {{$store.getters.getVariant(o.variant).type.slug}} <br>
                              <div
                              v-if="o.color"
                              class="d-inline" style="font-weight: bolder; color:black">CODIGO:
                                {{o.color.code}} <br>
                              </div>

                              <div class="d-inline" style="font-weight: bolder; color:black">LINEA:</div>
                              {{$store.getters.getVariant(o.variant).line.slug}} <br>
                              <div
                               v-if="o.color"
                              class="d-inline" style="font-weight: bolder; color:black">COLOR:
                                 {{o.color.color}}
                              </div>


                            </v-card-subtitle>
                          </div>
                          <v-avatar
                            class="ma-1"
                            size="80"
                            tile
                          >
                          <v-img
                          v-if="o.color === null"
                          :src="`/img/modelos/medium/${o.type}/${o.manufacturer}/${$store.getters.getVariant(o.variant).image}.jpg`" >
                          {{o.type +''+ o.manufacturer +''+ $store.getters.getVariant(o.variant).image}}
                            <template v-slot:placeholder>
                              <v-img  src="/img/modelos/medium-unavailable.jpg"></v-img>
                            </template>
                          </v-img>
                            <v-img
                            v-else
                            :src="`/img/modelos/medium/${o.type}/${o.manufacturer}/${o.color.code}.jpg`" >
                              <template v-slot:placeholder>
                                <v-img  src="/img/modelos/medium-unavailable.jpg"></v-img>
                              </template>
                            </v-img>
                          </v-avatar>
                        </div>
                      </v-card>
                    </v-col>

                    <v-col v-if="o.variant2 != null" cols="6">

                       <v-card flat >
                        <v-card-title class="py-2 px-4 justify-center" style="line-height: normal;font-size: 0.7em; font-weight: bolder">
                          {{$store.getters.getVariant(o.variant2).name}}
                        </v-card-title>
                        <v-divider></v-divider>
                        <div class="d-flex flex-xs-column justify-space-around">
                          <div >
                            <v-card-subtitle class="overline" style="line-height: normal">
                              <div class="d-inline" style="font-weight: bolder; color:black">TIPO:</div>
                              {{$store.getters.getVariant(o.variant).type.slug}} <br>
                              <div class="d-inline" style="font-weight: bolder; color:black">CODIGO:</div>
                              {{o.second_color.code}} <br>
                              <div class="d-inline" style="font-weight: bolder; color:black">LINEA:</div>
                              {{$store.getters.getVariant(o.variant2).line.slug}} <br>
                              <div class="d-inline" style="font-weight: bolder; color:black">COLOR:</div>
                             {{o.second_color.color}}

                            </v-card-subtitle>
                          </div>
                          <v-avatar
                            class="ma-1"
                            size="80"
                            tile
                          >
                            <v-img  :src="`/img/modelos/medium/${o.type}/${o.manufacturer}/${o.second_color.code}.jpg`" >
                              <template v-slot:placeholder>
                                <v-img  src="/img/modelos/medium-unavailable.jpg"></v-img>
                              </template>
                            </v-img>
                          </v-avatar>
                        </div>
                      </v-card>
                    </v-col>
                  </v-row>
                  <v-divider class="mx-4"></v-divider>
                  <v-card-title class="py-1 px-4 justify-center" style="line-height: normal; font-size: 0.7em; font-weight: bolder">
                    MEDIDAS:
                  </v-card-title>
                  <v-row no-gutters justify="center">
                    <v-col cols="auto" v-for="(l, index) in o.canvas" :key="index">
                      <v-list-item dense two-line >
                        <v-list-item-content class="overline">
                          <v-list-item-title>Lienzo {{ index + 1 }}</v-list-item-title>
                          <v-list-item-subtitle>Ancho: {{l.width}}M | Alto: {{l.height}}M</v-list-item-subtitle>
                        </v-list-item-content>
                      </v-list-item>
                    </v-col>
                  </v-row>
                   <v-divider class="mx-4"></v-divider>
                  <v-card-title class="py-1 px-4 justify-center" style="line-height: normal; font-size: 0.7em; font-weight: bolder">
                    CARACTERISTICAS DE PERSIANA:
                  </v-card-title>
                  <v-list-item class="overline" dense>
                    <v-list-item-title>PRECIO</v-list-item-title>
                    <v-list-item-subtitle class="text-right">
                      {{mxCurrencyFormat.format(o.price)}} MXN
                    </v-list-item-subtitle>
                  </v-list-item>
                    <v-list-item class="overline" dense v-if="o.extraEnrollable > 0">
                        <v-list-item-title class="blue--text">CARGO EXTRA</v-list-item-title>
                        <v-list-item-subtitle class="blue--text text-right">
                          {{mxCurrencyFormat.format(o.extraEnrollable)}} MXN
                        </v-list-item-subtitle>
                    </v-list-item>
                    <v-list-item class="overline" dense v-if="o.extraVertical > 0">
                        <v-list-item-title class="blue--text">CARGO EXTRA</v-list-item-title>
                        <v-list-item-subtitle class="blue--text text-right">
                          {{mxCurrencyFormat.format(o.extraVertical)}} MXN
                        </v-list-item-subtitle>
                    </v-list-item>
                  <v-list-item class="overline" v-if="o.cloth_holder != null" dense>
                    <v-list-item-title>CON {{o.cloth_holder}}</v-list-item-title>
                  </v-list-item>
                  <v-list-item class="overline" v-if="o.celular_type != null" dense>
                    <v-list-item-title>Tipo</v-list-item-title>
                    <v-list-item-subtitle class="text-right">
                      {{o.celular_type}}
                    </v-list-item-subtitle>
                  </v-list-item>
                  <v-list-item class="overline" v-if="o.celular_drive != null" dense>
                    <v-list-item-title>Accionamiento</v-list-item-title>
                    <v-list-item-subtitle class="text-right">
                      {{o.celular_drive}}
                    </v-list-item-subtitle>
                  </v-list-item>
                  <v-list-item class="overline" v-if="o.instalation_side != null" dense>
                    <v-list-item-title>Tipo de instalación</v-list-item-title>
                    <v-list-item-subtitle class="text-right">
                      {{o.motor.instalation_side}}
                    </v-list-item-subtitle>
                  </v-list-item>
                  <v-list-item class="overline" v-if="o.motor.instalation_side != null" dense>
                    <v-list-item-title>Tipo de instalación</v-list-item-title>
                    <v-list-item-subtitle class="text-right">
                      {{o.motor.instalation_side}}
                    </v-list-item-subtitle>
                  </v-list-item>
                  <v-list-item class="overline" v-if="o.motor.frame != null" dense>
                    <v-list-item-title>Marco</v-list-item-title>
                    <v-list-item-subtitle class="text-right">
                      {{o.motor.frame}}
                    </v-list-item-subtitle>
                  </v-list-item>
                  <v-list-item class="overline" v-if="o.motor.rail_color != null" dense>
                    <v-list-item-title>Riel</v-list-item-title>
                    <v-list-item-subtitle class="text-right">
                      {{o.motor.rail_color}}
                    </v-list-item-subtitle>
                  </v-list-item>


                   <v-list-item class="overline" v-if="o.motor.drive != null" dense>
                    <v-list-item-title>Accionamiento</v-list-item-title>
                    <v-list-item-subtitle class="text-right">
                      {{o.motor.drive}}
                    </v-list-item-subtitle>
                  </v-list-item>
                  <v-list-item class="overline" v-if="o.motor.selected_panel && o.motor.selected_panel != 0" dense>
                    <v-list-item-title>Agrupamiento</v-list-item-title>
                    <v-list-item-subtitle class="text-right">
                      {{o.motor.selected_panel}}
                    </v-list-item-subtitle>
                  </v-list-item>
                  <v-divider class="mx-4"></v-divider>
                  <v-card-title class="py-1 px-4 justify-center" style="line-height: normal; font-size: 0.7em; font-weight: bolder">
                    ACCIONAMIENTO: {{o.motor_type}}
                  </v-card-title>
                  <v-list-item class="overline" v-if="o.motor.side_control != null" dense>
                    <v-list-item-title v-if="o.motor_type == 'Motorizado'">Lado del motor</v-list-item-title>
                    <v-list-item-title v-if="o.motor_type == 'Manual'">Lado del control</v-list-item-title>
                    <v-list-item-subtitle class="text-right">
                      {{o.motor.side_control}}
                    </v-list-item-subtitle>
                  </v-list-item>
                  <v-list-item class="overline" v-if="o.motor.manufacturer != null" dense>
                    <v-list-item-title v-if="o.motor_type == 'Motorizado'">Fabricante del motor</v-list-item-title>
                    <v-list-item-title v-if="o.motor_type == 'Manual'">Fabricante del control</v-list-item-title>
                    <v-list-item-subtitle class="text-right">
                      {{o.motor.manufacturer}}
                    </v-list-item-subtitle>
                      <v-list-item-subtitle v-if="o.motor.manufacturerPrice > 0" class="text-right">
                      ${{o.motor.manufacturerPrice}}
                    </v-list-item-subtitle>
                  </v-list-item>
                  <v-list-item class="overline" v-if="o.motor.control_color != null &&  o.motor.control_color != 0" dense>
                    <v-list-item-title v-if="o.motor_type == 'Motorizado'">Color del motor</v-list-item-title>
                    <v-list-item-title v-if="o.motor_type == 'Manual'">Color del control</v-list-item-title>
                    <v-list-item-subtitle class="text-right">
                      {{o.motor.control_color}}
                    </v-list-item-subtitle>
                  </v-list-item>
                  <v-list-item class="overline" v-if="o.motor.string_type != null" dense>
                    <v-list-item-title>Tipo de cadena</v-list-item-title>
                    <v-list-item-subtitle class="text-right">
                      {{o.motor.string_type}}
                    </v-list-item-subtitle>
                    <v-list-item-subtitle v-if="o.motor.stringPrice > 0" class="text-right">
                      ${{o.motor.stringPrice}}
                    </v-list-item-subtitle>
                  </v-list-item>
                  <v-list-item class="overline" v-if="o.motor.height_control != null" dense>
                    <v-list-item-title>Altura de mando</v-list-item-title>
                    <v-list-item-subtitle class="text-right">
                      {{o.motor.height_control}} mts
                    </v-list-item-subtitle>
                  </v-list-item>
                  <v-list-group  no-action v-if="o.motor.gallery != null"  :value="true">
                    <template v-slot:activator>
                      <v-list-item-content>
                        <v-list-item-title>GALERIA/FASCIA</v-list-item-title>
                      </v-list-item-content>
                    </template>
                    <v-list-item class="overline" dense>
                      <v-list-item-title>Modelo</v-list-item-title>
                      <v-list-item-subtitle class="text-right">{{o.motor.gallery.model}}</v-list-item-subtitle>
                    </v-list-item>
                     <v-list-item class="overline" dense>
                      <v-list-item-title>Precio</v-list-item-title>
                      <v-list-item-subtitle v-if="o.motor.galleryPrice > 0" class="text-right">{{mxCurrencyFormat.format(o.motor.galleryPrice)}}MXN</v-list-item-subtitle>
                      <v-list-item-subtitle v-else class="text-right">{{mxCurrencyFormat.format(o.motor.gallery.price)}}MXN</v-list-item-subtitle>
                    </v-list-item>
                    <v-list-item class="overline" dense v-if="o.motor.gallery_color != null">
                      <v-list-item-title>Color</v-list-item-title>
                      <v-list-item-subtitle class="text-right">{{o.motor.gallery_color}}</v-list-item-subtitle>
                    </v-list-item>
                  </v-list-group>

                  <v-list-group no-action v-if="o.motor.motor != 0 && o.motor.motor != null"  :value="true">
                    <template v-slot:activator>
                      <v-list-item-content>
                        <v-list-item-title>MOTOR</v-list-item-title>
                      </v-list-item-content>
                    </template>
                    <!-- <v-list-item class="overline" dense>
                      <v-list-item-title>Descripción</v-list-item-title>
                      <v-list-item-subtitle class="text-right">{{$store.getters.getMotor(o.motor.motor).description}}</v-list-item-subtitle>
                    </v-list-item> -->
                    <v-list-item class="overline" dense>
                      <v-list-item-title>Sistema</v-list-item-title>
                      <v-list-item-subtitle class="text-right">{{$store.getters.getMotor(o.motor.motor).system}}</v-list-item-subtitle>
                    </v-list-item>
                     <v-list-item class="overline" dense>
                      <v-list-item-title>Tipo</v-list-item-title>
                      <v-list-item-subtitle class="text-right">{{$store.getters.getMotor(o.motor.motor).motorizationType}}</v-list-item-subtitle>
                    </v-list-item>

                     <v-list-item class="overline" dense>
                      <v-list-item-title>Precio</v-list-item-title>
                      <v-list-item-subtitle class="text-right">{{mxCurrencyFormat.format($store.getters.getMotor(o.motor.motor).price)}}MXN</v-list-item-subtitle>
                    </v-list-item>
                  </v-list-group>

                  <v-list-group no-action v-if="o.motor.control != null"  :value="true">
                    <template v-slot:activator>
                      <v-list-item-content>
                        <v-list-item-title>CONTROL DEL MOTOR</v-list-item-title>
                      </v-list-item-content>
                    </template>
                    <v-list-item class="overline" dense>
                      <v-list-item-title>Descripción</v-list-item-title>
                      <v-list-item-subtitle class="text-right">{{o.motor.control.description}}</v-list-item-subtitle>
                    </v-list-item>
                     <v-list-item class="overline" dense>
                      <v-list-item-title>Precio</v-list-item-title>
                      <v-list-item-subtitle class="text-right">{{mxCurrencyFormat.format(o.motor.control.price)}}MXN</v-list-item-subtitle>
                    </v-list-item>
                  </v-list-group>

                  <v-list-item class="overline" dense v-if="o.motor.flexiballetPrice > 0">
                      <v-list-item-title>EXTRA</v-list-item-title>
                      <v-list-item-subtitle class="text-right">${{o.motor.flexiballetPrice}} MXN</v-list-item-subtitle>
                    </v-list-item>

                    <v-alert
                      text
                      dense
                      color="teal"
                      icon="mdi-comment-account"
                      border="left"
                      v-if="o.motor.comment != null"
                    >
                      COMENTARIOS: {{o.motor.comment}}
                    </v-alert>
        </v-card>
      </v-tab-item>
    </v-tabs-items>
  </div>
</template>

<script>
import { mapState } from "vuex";
export default {
    mounted(){
        console.log(this.localOrders)
    },
  data() {
    return {
      tab: 0,
      mxCurrencyFormat : new Intl.NumberFormat('en-US', {style: 'currency', currency: 'USD'}),
    }
  },


  methods:{
    extraEnrollablePrice(index) {
        let enrollablePrice = 0
          this.localOrders[index].canvas.forEach(canvas => {
              if(canvas.width > 2.45){
                  enrollablePrice += 350;
              }
          });
        return parseFloat(enrollablePrice)
    },
    extraVerticalPrice(index) {
        if(this.localOrders[index].type === 'vertical' && this.localOrders[index].canvas[0].width != null){
            if(this.localOrders[index].cloth_holder === 'Galería PVC'){
              return parseFloat(Math.ceil(this.localOrders[index].canvas[0].width) * 250)
            }else if(this.localOrders[index].cloth_holder === 'Galería Portatela'){
              return parseFloat(Math.ceil(this.localOrders[index].canvas[0].width) * 120)
            }
        }else{
            return 0
        }
    },
  },


  computed: {
    ...mapState({
      user: (state) => state.user,
    }),
  },

  props:{
      localOrder: Object,
      localOrders: Array

  }


}
</script>

<style scoped>
@media (max-width: 420px){
.flex-xs-column {
    flex-direction: column!important;
}
}
</style>
