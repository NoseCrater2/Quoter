<template>
    <div>
        <v-container fluid style="max-width: 1200px" class="my-4">
            
            <v-row v-if="details.colors">
                <v-col cols="12" md="4" sm="12" class="mt-3">
                    <v-card width="400"  >
                        <v-img  
                        :height="458" 
                        :width="380" 
                        :src="`/img/modelos/full/${details.type}/${details.manufacturer}/${details.colors[position].code}.jpg`"  >
                            <template v-slot:placeholder>
                                <v-img src="/img/modelos/medium-unavailable.jpg"></v-img>
                            </template>
                        </v-img>
                        <v-card-actions  v-if="$vuetify.breakpoint.mobile">
                            <ItemColors 
                            @changeIndex="changeIndex" 
                            :type="details.type" 
                            :manufacturer="details.manufacturer" 
                            :colors="details.colors" />
                            
                        </v-card-actions>
                        <v-card-actions v-else>
                            <SlideColors 
                            @openDialog="openDialog" 
                            @changeIndex="changeIndex" 
                            :type="details.type" 
                            :manufacturer="details.manufacturer" 
                            :colors="details.colors" />
                        </v-card-actions>
                    </v-card>
                     <i style="font-family: Roboto, sans-serif; font-size: 8px">*El color puede variar dependiendo de tu dispositivo</i>
                </v-col>
                 <v-col cols="12" md="8" sm="12">
                    <v-card  flat>
                        <v-card-title class="text-center font-weight-black" :style="$vuetify.breakpoint.mobile?'font-size: 1.1em':'font-size: 1.6em'" >
                          
                                  {{ details.name}}
                          
                            </v-card-title>
                        <v-divider></v-divider>
                        <div class="d-inline" v-if="user != null">
                            <div class="d-block">
                                <div  class=" d-inline-flex" style="color: #47a5ad; font-size: 28px;">$ </div>
                            <div 
                            class="display-1 d-inline-flex " 
                            style="color: #47a5ad; font-weight: bolder;">
                                <div class="d-inline text-decoration-line-through">
                                    {{ maskPrice(details.price)[0] }}
                                </div>
                                <div class="d-inline cents">
                                     {{ maskPrice(details.price)[1] }}
                                </div>
                            </div>
                             <div class="d-inline-flex" style="color: #47a5ad;font-size: 28px;">MXN </div>
                            </div>
                            <div class="d-block">
                                <div  class="display-1 d-inline-flex" style="color: red">$ </div>
                            <div 
                            class="display-2 d-inline-flex" 
                            style="color: red; font-weight: bolder;">
                                <div class="d-inline">
                                    {{ maskPrice(details.price - ((user.discount_percent / 100) * details.price))[0] }}
                                </div>
                                <div class="d-inline cents">
                                     {{ maskPrice(details.price - ((user.discount_percent / 100) * details.price))[1] }}
                                </div>
                               
                            </div>
                            <div class="display-1 d-inline-flex" style="color: red">MXN </div>
                            </div>
                        </div>
                        <div v-else class="d-inline">
                        <div  class="display-1 d-inline-flex" style="color: #47a5ad">$ </div>
                        
                        <div  class="display-2 d-inline-flex" style="color: #47a5ad; font-weight: bolder;">
                           <div class="d-inline">
                                    {{ maskPrice(details.price)[0] }}
                                </div>
                                <div class="d-inline cents">
                                     {{ maskPrice(details.price)[1] }}
                                </div>
                        </div>
                        
                       
                        <div class="display-1 d-inline-flex" style="color: #47a5ad">MXN </div>
                        </div>
                  
                        <div  class="d-inline ml-4" >
                             <div class="display-1 d-inline-flex" style="color: #47a5ad">
                                
                                 <v-btn 
                                 dark
                                 color= "#47a5ad" 
                                 depressed 
                                 :to="{name:'Quoter', query:{type: this.slugType, line: details.slugLine ,variant: details.id, color: details.colors[selected]}}">
                                     COTIZAR ESTE PRODUCTO
                                 </v-btn>
                             </div>
                        </div>
                        <v-card-text>
                            <v-row align="center">
                                <v-col>
                                     <b> SELECCIONA MÁS COLORES:</b>
                                </v-col>
                               
                            </v-row>
                           
                            <v-row v-if="!$vuetify.breakpoint.mobile">
                                <ItemColors 
                                :type="details.type" 
                                :manufacturer="details.manufacturer" 
                                @changeIndex="changeIndex" 
                                :colors="details.colors" />
                            </v-row>
                            <v-row class="my-5">
                                <span>SKU: {{ details.colors[position].code}}</span> 
                            </v-row>
                        </v-card-text>
                    </v-card>
                    <v-tabs v-model="tab" align-with-title  background-color="#47a5ad" dark>
                    <v-tabs-slider color="#47a5ad"></v-tabs-slider>
                        <v-tab v-if="details.type_product_id === 1">FICHA TÉCNICA</v-tab>
                       <v-tab v-if="details.type_product_id === 1">TELAS</v-tab>
                       <v-tab v-if="details.type_product_id === 2">DESCRIPCIÓN</v-tab>
                        <v-tab v-if="details.type_product_id === 2">CARACTERÍSTICAS</v-tab>
                        <v-tab v-if="details.type_product_id === 2">PESOS</v-tab>
                    </v-tabs>

                    <v-tabs-items v-model="tab" >
                        <v-tab-item v-if="details.type_product_id === 1">
                             <v-simple-table>
                                <template>
                                    <tbody>
                                        <tr>
                                            <td>LINEA</td>
                                            <td> {{ details.line }} </td>
                                            
                                        </tr>
                                        <tr>
                                            <td>TIPO DE PRODUCTO</td>
                                            <td> {{ details.type }} </td>
                                        </tr>
                                        <tr v-if="details.type != 'HORIZONTAL DE MADERA 2'">
                                            <td>ANCHO MÁXIMO DE TELA</td>
                                            <td v-if="details.max_width == 0">{{ details.width }} </td>
                                            <td v-else>{{details.max_width}}</td>
                                             <td>ANCHO MÍNIMO DE TELA</td>
                                            <td >{{ details.min_width }} </td>
                                        </tr>
                                        <tr v-if="details.type != 'HORIZONTAL DE MADERA 2'">
                                           <td>ALTO MÁXIMO DE TELA</td>
                                           <td v-if="details.max_height == 0">{{ details.width }} </td>
                                            <td v-else>{{details.max_height}}</td>
                                           
                                             <td>ALTO MÍNIMO DE TELA</td>
                                            <td >{{ details.min_height }} </td>
                                        </tr>

                                        <tr v-if="!details.max_width_rot == 0 && !details.type =='HORIZONTAL DE MADERA 2'">
                                            <td>
                                                ANCHO MÁXIMO ROTADO
                                            </td>
                                            <td>{{ details.max_width_rot }}</td>
                                             <td>
                                                ANCHO MÍNIMO ROTADO
                                            </td>
                                            <td>{{details.min_width_rot}}</td>
                                        </tr>
                                         <tr v-if="!details.max_width_rot == 0 && !details.type =='HORIZONTAL DE MADERA 2'">
                                            <td>
                                                ALTO MÁXIMO ROTADO
                                            </td>
                                            <td>{{ details.max_height_rot }}</td>
                                             <td>
                                                ALTO MÍNIMO ROTADO
                                            </td>
                                            <td>{{details.min_height_rot}}</td>
                                        </tr>
                                    </tbody>
                                </template>
                    </v-simple-table>
                        </v-tab-item>

                        <v-tab-item v-if="details.type_product_id === 1">
                            <v-simple-table fixed-header height="220px">
                                <template>
                                    <thead>
                                        <td>
                                            COLOR
                                        </td>
                                    </thead>
                                    <tbody>
                                        <tr v-for="color in details.colors" :key="color.id">
                                            <td>
                                                {{ color.color }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </template>
                            </v-simple-table>
                        </v-tab-item>

                        <v-tab-item v-if="details.type_product_id === 2">
                            <v-card>
                                <v-card-text>
                                    {{ details.description }}
                                </v-card-text>
                            </v-card>
                        </v-tab-item>

                        <v-tab-item v-if="details.type_product_id === 2">
                            <v-simple-table>
                                <template>
                                    <tbody>
                                        <tr v-if="details.finished !== null">
                                            <td>ACABADO</td>
                                            <td>{{details.finished}}</td>
                                        </tr>
                                        <tr v-if="details.strip_width > 0">
                                            <td>ANCHO</td>
                                            <td>{{details.strip_width}}</td>
                                        </tr>
                                        <!-- <tr v-if="details.ceiling_price > 0">
                                            <td>PRECIO TECHO</td>
                                            <td>{{details.ceiling_price }}</td>
                                        </tr>
                                        <tr v-if="details.wall_price > 0">
                                            <td>PRECIO MURO</td>
                                            <td>{{details.wall_price }}</td>
                                        </tr>
                                        <tr v-if="details.wall_extended_price > 0">
                                            <td>PRECIO MURO EXTENDIDO</td>
                                            <td>{{details.wall_extended_price }}</td>
                                        </tr>
                                        <tr v-if="details.wall_double_price > 0">
                                            <td>PRECIO MURO DOBLE</td>
                                            <td>{{details.wall_double_price }}</td>
                                        </tr>
                                        <tr v-if="details.ceiling_wall_price > 0">
                                            <td>PRECIO MURO TECHO</td>
                                            <td>{{details.ceiling_wall_price }}</td>
                                        </tr>
                                        <tr v-if="details.curve_price > 0">
                                            <td>PRECIO TECHO MURO CURVO</td>
                                            <td>{{details.curve_price }}</td>
                                        </tr> -->
                                    </tbody>
                                </template>
                            </v-simple-table>
                        </v-tab-item>
                        <v-tab-item v-if="details.type_product_id === 2">
                            <v-simple-table v-if="details.weights">
                                <template>
                                    <tr>
                                        <td>CÓDIGO</td>
                                        <td>PESO</td>
                                        <td>ANCHO</td>
                                    </tr>
                                    <tr v-for="weight in details.weights"  :key="weight.code">
                                        <td> {{weight.code }} </td>
                                        <td> {{weight.weight}}mt </td>
                                        <td> {{weight.width}}kg </td>
                                    </tr>
                                </template>
                            </v-simple-table>
                        </v-tab-item>
                    </v-tabs-items>
                </v-col>
                 <!-- <v-col cols="12" md="4" sm="12">
                    
                   
                </v-col> -->
            </v-row>

            <v-row v-else>
                 <v-col cols="12" md="4" sm="12" class="mt-3">
                <v-skeleton-loader
                height="567"
                width="400"
                v-bind="attrs"
                type="image, actions"
                 ></v-skeleton-loader>
                 </v-col>

                 <v-col cols="12" md="8" sm="12">
                     <v-skeleton-loader
                    v-bind="attrs"
                    type="date-picker"
                    ></v-skeleton-loader>
                 </v-col>
            </v-row>

            <v-row>
                <v-col cols="12">
                      <v-card tile flat>
                         <v-card-title > PRODUCTOS RELACIONADOS</v-card-title>
                        <v-divider></v-divider>
                   
                     <v-row justify="space-around" v-if="relationed">
                         <v-col cols="12" md="3" sm="12" v-for="r in relationed" :key="r.id">
                                 <v-card max-width="200" height="230" color="grey lighten-4" class="mx-auto" flat >
                            <v-img class="white--text align-end"  width="200" height="185" :aspect-ratio="16/9" :src="`/img/modelos/medium/${r.type}/${r.manufacturer}/${r.image}.jpg`"  >
                            <template v-slot:placeholder>
                                <v-img src="/img/modelos/medium-unavailable.jpg"></v-img>
                            </template>

                                 <div
                             
                              class="d-flex transition-fast-in-fast-out  v-card--reveal white--text"
                              style="height: 100%;"
                              >
                              <v-hover v-slot="{ hover }">
                              <v-btn :to="{name: 'Details', params: {slugDetail: r.slug}}" depressed :outlined="!hover" tile color="white"  x-small>VER</v-btn>
                              </v-hover>
                              </div>
                              
                            
                               <v-card-text style="padding: 0px; padding-left: 5px; font-size: 0.8rem !important;" class="title" >{{ r.name}}</v-card-text> 
                            </v-img>
                            

                            <v-card-text
                            
                            style="position: relative"
                            >

                            <h2 class=" font-weight-light black--text text-center">
                             ${{ r.price}}
                            </h2>
                           
                            </v-card-text>
                          </v-card>
                             
                         </v-col>
                        
                     </v-row>
                     <v-row v-else>
                          <v-skeleton-loader
                           height="230"
                              v-bind="attrs"
                              type="image, article"
                            ></v-skeleton-loader>
                     </v-row>
                       </v-card>
                </v-col>
            </v-row>
        </v-container>

        <v-dialog v-model="dialog" width="600">
            <v-card >
                <v-carousel hide-delimiters v-model="position" height="700">
                    <v-carousel-item 
                    v-for="color in details.colors" 
                    :key="color.code"
                    :src="`/img/modelos/full/${details.type}/${details.manufacturer}/${color.code}.jpg`"
                    >
                    </v-carousel-item>
                </v-carousel>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>

import { mapState } from 'vuex';
import SlideColors from '../components/CustomCards/SlideColors';
import ItemColors from '../components/CustomCards/ItemColors';

export default {
    data(){
        return{
            attrs: {
            class: 'mb-6',
            boilerplate: true,
            elevation: 2,
            },
            dialog: false,
            wrapper:  null,
            selected: 0,
            position: 0,
            showVariant: null,
            model: null,
            tab: null,

            sheets: [
                {feature: 'Ancho de tela', value: '3.00 mts'},
                {feature: 'Alto de tela', value: '5.00 mts'},
                {feature: 'GIrar tela', value: '90°'},
            ],

        }

        
    },


    computed:{
        ...mapState({
        details: state => state.variantsModule.variant,
        relationed: state => state.variantsModule.related,
        user: state => state.user,
        }),

        getProduct(){
         return this.$store.state.productsModule.variants.find((variant => variant.slug === this.slugDetail && variant.type === this.slugType))
        },


    },

    mounted(){
        if(this.getProduct){
             if(this.$route.params.id){
                 document.title = this.getProduct.name
                this.$store.dispatch('getVariant',this.$route.params.id).then(()=>{
                this.$store.dispatch('getRelated', this.$route.params.id);
            })  
        }else{
             document.title = this.getProduct.name
             this.$store.dispatch('getVariant',this.getProduct.id).then(()=>{
            this.$store.dispatch('getRelated', this.getProduct.id);
            }) 
        }
        }
       
    },

    methods:{
        maskPrice(price){
            return parseFloat(price).toFixed(2).toString().split('.')
        },
        changeIndex(index){
            if(index === undefined){
                index = 0
            }
           this.position = index;
        },

        openDialog(index){
            this.dialog = true
        }
    },

    props:{
        slugDetail: {
           type:  String,
           required: true
        },

        slugType: {
           type:  String,
           required: true
        },

    },

    watch:{
      getProduct(after, before){
          if(this.getProduct){
                document.title = this.getProduct.name
                this.$store.dispatch('getVariant',this.getProduct.id).then(()=>{
                this.$store.dispatch('getRelated', this.getProduct.id);
            })
          }
      }
    },

    components:{
        SlideColors,
        ItemColors,
    },
}
</script>

<style>
.cents{
  position: relative;
  bottom: 0.4em;
  font-size: 0.7em;
  right: 0.1em;
}
.selected{
    padding: 1px;
    border: 1px solid black;
}

.title{
  background-color: #47a5ad;  word-break: break-word !important;
}

.v-card--reveal {
align-items: center;
bottom: 0;
justify-content: center;
position: absolute;
width: 100%;

}
</style>