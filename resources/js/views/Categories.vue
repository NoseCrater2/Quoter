<template>
    <div id="app">
           
        <v-container fluid style="max-width: 1200px">
        <v-row justify="space-between"  class="mx-2">
           
                <v-row justify="center">
                <v-col cols="8"  align-self="center">
                <h1 class="text-center" style="font-weight: bolder;font-size: 3em;"  v-if="getProduct" >
                    {{getProduct.name}}
                </h1>
                <div class="d-flex justify-center">
                  <hr align="center" noshade="noshade" class="divider" style="height: 5px" size="3" width="15%" />
              </div>
               <br>
                <h2 class="text-center" > 
                    {{getProduct.description}}
                </h2>
                </v-col>
                </v-row>
                <v-row justify="center" align="center" v-if="persianas">
                    <v-col v-for="p in persianas" :key="p.id" cols="12" md="4" sm="6">
                       <v-hover v-slot="{ hover }">
                          <v-card width="420" height="300" color="grey lighten-4"  flat >
                             <!-- -->
                            <v-img class="white--text align-end"  :class="{'escalada':hover}" width="420" height="300" :aspect-ratio="16/9"  :src="`../../img/tipos/${p.slug}.jpg`" :gradient="hover?'rgba(71, 165, 173, 0.7) 100%, transparent 72px':''"  >
                                <v-slide-y-reverse-transition>
                                    <div v-if="!hover" class="title d-flex transition-fast-in-fast-out justify-center"  > 
                                        <h4 class="text-center">{{ p.name}}</h4> 
                                    </div> 
                                </v-slide-y-reverse-transition>
                                <v-slide-x-transition>
                                    <div
                                    v-if="hover"
                                    class="d-flex transition-fast-in-fast-out  v-card--reveal white--text"
                                    style="height: 100%;"
                                    >
                                        <v-hover v-slot="{ hover }">
                                            <v-btn :to=" p.lines > 0?{name: 'Lines', params: {slugLine: p.slug}}:{name: 'Products', params: {slugLine: p.slug,slugModel: p.slug}}" depressed :outlined="!hover" tile color="white" >
                                                {{p.name}}</v-btn>
                                        </v-hover>
                                    </div>
                                </v-slide-x-transition>
                                <v-expand-transition>
                                    <div
                                    v-if="hover"
                                    class="d-flex transition-fast-in-fast-out  v-card--reveal white--text"
                                    style="height: 20%;"
                                    >
                                            <v-btn   title dark color="transparent" depressed>
                                                <v-icon size="35" class="mr-4" left>mdi-plus-circle-outline</v-icon>Ver más
                                            </v-btn>
                                    </div>
                                </v-expand-transition>
                            </v-img>
                          </v-card>
                        </v-hover>
                    </v-col>
                </v-row>
                
        </v-row>
         <v-row justify="center" align="center" class="ma-4">
                    <v-col v-for="n in options.length" :key="n" cols="6" align-self="center" md="3" sm="6">
                        <v-hover v-slot="{hover}">
                            <v-btn rounded :outlined="hover?false:true" :style="hover?'color: white':''" block color="#47a5ad">
                                {{options[n-1]}}
                            </v-btn>
                        </v-hover>
                    </v-col>
        </v-row>
       </v-container>
    </div>
</template>
<script>
import { mapActions, mapGetters, mapState, productModule} from 'vuex';
export default {
    data(){
        return{
           // slug: this.$route.params.slugType,
            widths: [500,380,380,420,420,420,420,420,420,420,420],
            options: [
                'Galería/Facsia',
                'Motorización',
                'Accesorios',
                'Muestrario'
            ]
        }
    },

    created(){
         this.$store.dispatch('getTypes',this.getProduct.id)     
    },
    computed:{
         ...mapState({
      persianas: state => state.productsModule.types,
    }),

    getProduct(){
         return  this.$store.state.productsModule.products.find((product => product.slug === this.slugType))
    },
   
    },

    props: {
        slugType: String,
        required: true
    }
}
</script>

<style >
.v-card--reveal {
align-items: center;
bottom: 0;
justify-content: center;
position: absolute;
width: 100%;

}

.title{
  background-color: #47a5ad; padding: 5px; font-size: 1rem; word-break: break-word !important;
}

.escalada{
   transform: scale(1.02);
    -moz-transform: scale(1.02);
    -webkit-transform: scale(1.02);
    -o-transform: scale(1.02);
    -ms-transform: scale(1.02);
    transition-duration: 0.5s;
}

.divider{
    border: none;
    height: 5px;
    background-color: #47a5ad;
    
}
</style>