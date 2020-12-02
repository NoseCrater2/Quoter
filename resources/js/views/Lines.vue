<template>
    <div>
        <v-container fluid style="max-width: 1200px" class="my-4">
            <v-row justify="space-between" class="mx-4">
                <v-col cols="12" align-self="center" class="text-center">
                    <div class="d-inline-flex" v-if="getProduct.product === 'PERSIANAS' ">
                         <h1>PERSIANA</h1>
                    </div>
                   <div class="d-inline-flex" v-if="getProduct" style="color: #47a5ad;">
                         <h1>{{getProduct.name}}</h1>
                    </div>
                     <div class="d-flex justify-center">
                  <hr align="center" noshade="noshade" class="divider" style="height: 5px" size="3" width="35%" />
              </div>
                   
                </v-col>
                <v-col cols="12" align-self="center" class="text-center">
                    <p style="font-size: 1.5em" v-if="getProduct.product === 'PERSIANAS' ">
                    Nuestro tejidos  black out o traslúcidos son ideales para los lugares en los que deseas tener un manejo de la luz natural, 
                    pues la función principal de este estilo de persianas es bloquear el ingreso de los rayos solares, 
                    ya sea a través de alguno de nuestros tejidos black out o un tejido traslúcido, ambienta tus espacios 
                    de una forma natural con los destellos de luz solar y da a tus espacios un toque excepcional.
                    </p>
                     <p style="font-size: 1.5em" v-if="getProduct.name === 'CAÍDA LIBRE' ">
                         Esta colección tiene una infinidad de aplicaciones y una ámplia gama de tejidos a elegir.
                    </p>
                    
                </v-col>
                 <v-col cols="12" align-self="center" class="text-center" v-if="getProduct.product === 'PERSIANAS' ">
                     <p style="font-size: 1.5em">
                         Este tipo de persianas modernas permite mantener la elegancia del lugar sin perder la efectividad de las mismas.
                    Así que si lo que buscas es bloquear el ingreso de luz sin perder el estilo, una persiana black out es la opción 
                    para ti, pero si lo que deseas es decorar tu espacio con un poco de luz natural, Recuerda que nuestro catálogo 
                    es el más completo en el mercado, en el encontraras la textura o color que buscas.
                     </p>
                   
                </v-col>
                <v-col cols="12" align-self="center" class="text-center" >
                   <v-row  justify="center" align="center">
                       <v-col cols="12" md="4" sm="6"  v-for="line in lines" :key="line.id">
                            <v-hover v-slot="{ hover }">
                            <v-card height="340" width="380" class="ma-4">
                             <v-img class="white--text align-end"  :class="{'escalada':hover}" width="390" height="340" :aspect-ratio="16/9"  :src="`../../img/lineas/${line.slug}.jpg`" :gradient="hover?'rgba(71, 165, 173, 0.7) 100%, transparent 72px':''"  >
                                <v-slide-y-reverse-transition>
                                    <div v-if="!hover" class="title d-flex transition-fast-in-fast-out justify-center"  > 
                                        <h3 class="text-center">{{ line.name}}</h3> 
                                    </div> 
                                </v-slide-y-reverse-transition>
                                <v-slide-x-transition>
                                    <div
                                    v-if="hover"
                                    class="d-flex transition-fast-in-fast-out  v-card--reveal white--text"
                                    style="height: 100%;"
                                    >
                                        <v-hover v-slot="{ hover }">
                                            <v-btn :to="line.weaves > 0? {name: 'Tejidos', params: {slugWeave: line.slug}}:{name: 'Products', params: {slugModel: line.slug}}" :outlined="!hover" depressed  tile color="white" >
                                                {{ line.name }}
                                            </v-btn>
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
                   
                           


                </v-col>
                <!-- <v-col v-for="n in 3" :key="n" cols="4">
                   <v-card width="420" height="380">
                       {{n}}
                   </v-card>
                </v-col> -->
                <v-col cols="12"  class="text-center">
                    <v-btn rounded color="#47a5ad" x-large dark>Ver Galería</v-btn>
                   
                </v-col>
               
            </v-row>

             <v-row justify="center" align="center" class="ma-4">
                  <v-col cols="12" align-self="center" class="text-center">
                    <div class="d-inline-flex">
                         <h2>MÁS</h2>
                    </div>
                   <div class="d-inline-flex" style="color: #47a5ad;">
                         <h2>PERSIANAS</h2>
                    </div>
                     <div class="d-flex justify-center">
                  <hr align="center" noshade="noshade" class="divider" style="height: 5px" size="3" width="10%" />
              </div>
                   
                </v-col>
                    <v-col v-for="n in persianas" :key="n.id" cols="6" align-self="center" md="3" sm="6">
                        <v-hover  v-slot="{ hover }">
                            <v-btn rounded :outlined="hover?false:true" :style="hover?'color: white':''"  block color="#47a5ad"  :to="{name: 'Lines', params: {slugLine: n.slug}}">
                                {{n.name}}
                            </v-btn>
                        </v-hover>
                    </v-col>
        </v-row>
        </v-container>
    </div>
</template>

<script>
import { mapActions, mapState, productModule} from 'vuex';
export default {
    data(){
        return{
            model: null,
        }
    },

     mounted(){
         
         this.$store.dispatch('getLines',this.getProduct.id)
    },
    computed:{
         ...mapState({
      persianas: state => state.productsModule.types,
      lines: state => state.productsModule.lines,
    }),

    getProduct(){
         return  this.$store.state.productsModule.types.find((type => type.slug === this.slugLine))
    }
    },

    props: {
        slugLine: String,
        required: true
    },

}
</script>
<style>
.divider{
    border: none;
    height: 5px;
    background-color: #47a5ad;
}

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


.v-slide-group.v-item-group>.v-slide-group__next i, .v-slide-group.v-item-group>.v-slide-group__prev i{
  font-size: 65px ;
}

.v-slide-group__next--disabled i, .v-slide-group__prev--disabled i{
    display: none !important;
   /* font-size: 24px !important; */
}


/* .v-slide-group__wrapper{
    border-width: 0 40px 0  0;
  border-style: solid;
  border-image: 
    linear-gradient(
      to left, 
       red, 
      rgba(0, 0, 0, 0)
    ) 1 100%;
} */

.v-slide-group__next--disabled, .v-slide-group__prev--disabled{
   font-size: 24px !important;
}
 /* border-style: solid;
  border-image: 
    linear-gradient(
      to left, 
      white, 
      rgba(0, 0, 0, 0)
    ) 1 100%; */

</style>

