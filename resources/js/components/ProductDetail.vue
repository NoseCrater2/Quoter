<template>
    <div>
        <v-container fluid style="max-width: 1200px" class="my-4">
            <v-card flat>
                <v-row>
                    <v-col cols="12" md="4" sm="12">
                         <v-card width="400" flat>
                        <v-img
                        :height="458"
                        :width="380"
                        :src="`/img/modelos/full/${details.type.slug}/${details.line.slug}/${details.colors[position].code}.jpg`"  >
                            <template v-slot:placeholder>
                                <v-img src="/img/modelos/medium-unavailable.jpg"></v-img>
                            </template>
                        </v-img>
                        <v-card-actions  v-if="$vuetify.breakpoint.mobile">
                            <ItemColors
                            @changeIndex="changeIndex"
                            :type="details.type.slug"
                            :manufacturer="details.line.slug"
                            :colors="details.colors" />

                        </v-card-actions>
                        <v-card-actions v-else>
                            <SlideColors
                            @openDialog="openDialog"
                            @changeIndex="changeIndex"
                            :type="details.type.slug"
                            :manufacturer="details.line.slug"
                            :colors="details.colors" />
                        </v-card-actions>
                    </v-card>
                    <i style="font-family: Roboto, sans-serif; font-size: 8px">*El color puede variar dependiendo de tu dispositivo</i>
                    </v-col>
                    <v-col cols="12" md="8" sm="12">
                        <v-card flat>
                            <v-card-title class="text-center font-weight-black" :style="$vuetify.breakpoint.mobile?'font-size: 1.1em':'font-size: 1.6em'" >
                                {{ details.name}}

                            <v-chip label class="mx-2 white--text" color="#47a5ad" style="font-family: 'Montserrat';">
                                SKU: {{ details.colors[position].code}}
                            </v-chip>
                            </v-card-title>
                             <v-divider></v-divider>
                             <v-card-text>
                        <div v-if="details.type.product_id != 3 " class="d-inline"  >
                        <div  v-if="user != null">
                            <div >
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
                            <div >
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
                        </div>

                        <div class="d-inline" >
                             <div class="display-1 d-inline" style="color: #47a5ad">
                                 <v-btn
                                 v-if="details.type.product_id != 3"
                                 dark
                                 color= "#47a5ad"
                                 depressed
                                 :to="{name:'Quoter', query:{type: details.type.slug, line: details.weave != null ? details.weave.slug : null, variant: details.id,manufacturer: details.line.slug, color: details.colors[selected]}}">
                                    COTIZAR ESTE PRODUCTO
                                 </v-btn>
                                <v-btn
                                target="_blank"
                                :href="`https://api.whatsapp.com/send?phone=5215548948279?&amp;text=Hola+quiero+saber+el+precio+del+toldo+${details.name}+de+color+${details.colors[selected].color}`"
                                v-else
                                dark
                                color= "#47a5ad"
                                depressed>
                                    PREGUNTAR POR PRECIO
                                 </v-btn>
                             </div>
                        </div>

                            <v-row align="center" class="mt-6" no-gutters>
                                <b> SELECCIONA MÁS COLORES:</b>
                            </v-row>

                            <ItemColors
                            v-if="!$vuetify.breakpoint.mobile"
                            :type="details.type.slug"
                            :manufacturer="details.line.slug"
                            @changeIndex="changeIndex"
                            :colors="details.colors" />
                        </v-card-text>
                        <v-list dense>
                        <v-list-item>
                            <v-list-item-content>
                                <v-list-item-title>TIPO</v-list-item-title>
                                <v-list-item-subtitle class="text--primary">
                                    {{ details.type.name }}
                                </v-list-item-subtitle>
                            </v-list-item-content>
                        </v-list-item>
                        <v-list-item>
                            <v-list-item-content>
                                <v-list-item-title>LÍNEA</v-list-item-title>
                                <v-list-item-subtitle class="text--primary">
                                    {{ details.line.name }}
                                </v-list-item-subtitle>
                            </v-list-item-content>
                        </v-list-item>
                        <v-list-item v-if="details.subweave != null">
                            <v-list-item-content >
                                <v-list-item-title>MODELO</v-list-item-title>
                                <v-list-item-subtitle class="text--primary">
                                    {{ details.subweave.name }}
                                </v-list-item-subtitle>
                            </v-list-item-content>
                        </v-list-item>
                        <v-list-item v-if="details.weave != null">
                            <v-list-item-content>
                                <v-list-item-title>TEJIDO</v-list-item-title>
                                <v-list-item-subtitle class="text--primary">
                                    {{ details.weave.name }}
                                </v-list-item-subtitle>
                            </v-list-item-content>
                        </v-list-item>
                        <v-list-item v-if="details.rotate != 0">
                            <v-list-item-avatar>
                              <v-icon color="#47a5ad" dark>
                                mdi-format-rotate-90
                              </v-icon>
                            </v-list-item-avatar>
                            <v-list-item-content>
                                <v-list-item-title>ROTABLE</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list>
                        </v-card>
                    </v-col>
                </v-row>
            </v-card>

            <v-row>
                <v-col cols="12">
                      <v-card tile flat>
                         <v-card-title > PRODUCTOS RELACIONADOS</v-card-title>
                        <v-divider></v-divider>

                     <v-row justify="space-around" v-if="relationed">
                         <v-col cols="12" md="3" sm="12" v-for="r in relationed" :key="r.id">
                                 <v-card max-width="200" height="230" color="grey lighten-4" class="mx-auto" flat >
                            <v-img class="white--text align-end"  width="200" height="185" :aspect-ratio="16/9" :src="`/img/modelos/medium/${r.type.slug}/${r.line.slug}/${r.image}.jpg`"  >
                            <template v-slot:placeholder>
                                <v-img src="/img/modelos/medium-unavailable.jpg"></v-img>
                            </template>

                                 <div

                              class="d-flex transition-fast-in-fast-out  v-card--reveal white--text"
                              style="height: 100%;"
                              >
                              <v-hover v-slot="{ hover }">
                              <v-btn :to="{name: 'Details', params: {slugWeave:r.weave != null ? r.weave.slug : null, slugDetail: r.id.toString()}}" depressed :outlined="!hover" tile color="white"  x-small>VER</v-btn>
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
                    :src="`/img/modelos/full/${details.type.slug}/${details.line.slug}/${color.code}.jpg`"
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
        details: state => state.variantsModule.variant[0],
        relationed: state => state.variantsModule.related,
        user: state => state.user,
        }),

        // getProduct(){
        //  return this.$store.state.productsModule.variants.find(variant => variant.slug === this.slugDetail && variant.type.slug === this.slugType)
        // },


    },

    mounted(){
        if(this.slugDetail){
             if(this.$route.params.id){
                //  document.title = this.getProduct.name
                this.$store.dispatch('getVariant',this.$route.params.id).then(()=>{
                this.$store.dispatch('getRelated', this.$route.params.id);
            })
            }else{
                //  document.title = this.getProduct.name
                 this.$store.dispatch('getVariant',parseInt(this.slugDetail)).then(()=>{
                this.$store.dispatch('getRelated', parseInt(this.slugDetail));
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
