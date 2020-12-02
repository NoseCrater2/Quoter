<template>
    <div>
        <v-container fluid style="max-width: 1200px" class="my-4">
            
            <v-row v-if="details.colors">
                <v-col cols="12" md="4" sm="12" class="mt-3">
                    <v-card width="400" height="567">
                         <!-- :src="`img/modelos/medium/${item.image}`" -->
                        <!-- <v-img  :aspect-ratio="16/9" height="400"  :src="details.colors[position].image"></v-img> -->
                        <vue-h-zoom  :height="458" :width="380" :image="`../../img/modelos/full/${details.colors[position].code}.jpg`"  :zoom-level="3" :zoom-window-size="1.5"></vue-h-zoom>
                        <v-card-actions>
                            <v-sheet  width="370">
                                <v-slide-group v-model="model"   show-arrows  >
                                    <v-slide-item v-for="n in details.colors.length" :key="n" v-slot="{ }">
                                       
                                        <v-hover   v-slot="{ hover }">
                                        <v-card
                                         :class="{'selected':hover}"
                                        outlined
                                        tile
                                      @click="openDialog(n-1)"
                                       @mouseenter="changeIndex(n-1)"
                                        class="ma-3"
                                        height="80"
                                        width="60"
                                        
                                        >
                                        <v-tooltip bottom>
                                            <template v-slot:activator="{ on, attrs}">
                                                <div>
                                                  
                                                    <v-img  v-bind="attrs" v-on="on"   :aspect-ratio="16/9" height="80"  :src="`../../img/modelos/medium/${details.colors[n-1].code}.jpg`"></v-img>
                                                </div>
                                            </template>
                                            <span>{{ details.colors[n-1].color }}</span>
                                        </v-tooltip>
                                        </v-card>
                                        </v-hover>
                                    </v-slide-item>
                                </v-slide-group>
                            </v-sheet>
                        </v-card-actions>
                    </v-card>
                </v-col>
                 <v-col cols="12" md="4" sm="12">
                    <v-card  flat>
                        <v-card-title style="font-size: 2.2em">{{ details.name}}</v-card-title>
                        <v-divider></v-divider>
                        <div class="d-flex justify-center">
                        <div class="display-1 d-inline-flex" style="color: #47a5ad">$ </div>
                        <div  class="display-2 d-inline-flex" style="color: #47a5ad; font-weight: bolder;">{{details.price}}</div>
                        <div class="display-1 d-inline-flex" style="color: #47a5ad">MXN </div>
                        </div>
                        <v-card-text>
                            <v-row align="center" class="mx-10">
                                <v-col>
                                     <b> SELECCIONA MÁS COLORES:</b>
                                </v-col>
                               
                            </v-row>
                           
                            <v-row>
                            <v-item-group v-model="selected" @change="changeIndex(selected)">
                                <v-row  align="center" class="mb-10 mx-12">
                                    <v-col
                                    cols="2"
                                    align-self="center"
                                    v-for="n in details.colors.length" :key="n"
                                    >
                                        <v-item v-slot="{ active, toggle}" >
                                            <v-card
                                            outlined
                                            tile
                                            class="d-flex align-center"
                                            height="20"
                                            width="20"
                                            @click="toggle"
                                            >
                                               <v-tooltip bottom>
                                                    <template v-slot:activator="{ on, attrs}">
                                                        <div :class="{'selected':active}" v-bind="attrs" v-on="on">
                                                            <v-img  :aspect-ratio="16/9" height="20"  width="20" :src="`../../img/modelos/tumb/${details.colors[n-1].code}.jpg`"></v-img>
                                                        </div>
                                                    </template>
                                                    <span>{{ details.colors[n-1].color }}</span>
                                                </v-tooltip>   
                                            </v-card>
                                        </v-item>
                                    </v-col>
                                </v-row>
                            </v-item-group>
                            </v-row>
                        </v-card-text>
                    </v-card>
                </v-col>
                 <v-col cols="12" md="4" sm="12">
                    
                     <v-card tile flat>
                         <v-card-title > PRODUCTOS RELACIONADOS</v-card-title>
                        <v-divider></v-divider>
                   
                     <v-row justify="space-around">
                         <v-col cols="12" md="6" sm="12" v-for="r in relationed" :key="r.id">
                                 <v-card max-width="200" height="230" color="grey lighten-4" class="mx-auto" flat >
                            <v-img class="white--text align-end"  width="200" height="185" :aspect-ratio="16/9" :src="`../../img/modelos/medium/${r.image}.jpg`"  >

                                 <div
                             
                              class="d-flex transition-fast-in-fast-out  v-card--reveal white--text"
                              style="height: 100%;"
                              >
                              <v-hover v-slot="{ hover }">
                              <v-btn :to="{name: 'SunblindDetails', params: {slugDetail2: r.slug}}" depressed :outlined="!hover" tile color="white"  x-small>VER</v-btn>
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
                    :src="`../img/modelos/full/${color.code}.jpg`"
                    >
                    </v-carousel-item>
                </v-carousel>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>

import VueHZoom from 'vue-h-zoom';
import { mapActions, mapState, variantsModule, sunblindModule} from 'vuex';
export default {
    data(){
        return{
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

    components:{
      VueHZoom,
    },

    computed:{
        ...mapState({
        details: state => state.sunblindModule.sunblind,
        relationed: state => state.sunblindModule.relatedSunblinds,
        }),

        getProduct(){
         return this.$store.state.productsModule.sunblinds.find((sunblind => sunblind.slug === this.slugDetail2)) 
        },
    },

    mounted(){
        if(this.$route.params.id){
               this.$store.dispatch('getSunblind',this.getProduct.id).then(()=>{
                this.$store.dispatch('getRelatedSunblind', this.getProduct.id);
            }) 
        }else{

            this.$store.dispatch('getSunblind',this.getProduct.id).then(()=>{
                this.$store.dispatch('getRelatedSunblind', this.getProduct.id);
            }) 
       }
    },

    methods:{
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
        slugDetail2: {
           type:  String,
           required: true
        },

        isSunblind: {
            type: Boolean,
            required: false
        }

    }
}
</script>

<style>
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