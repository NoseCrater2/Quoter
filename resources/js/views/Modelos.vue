<template>
    <div>
        <v-container fluid style="max-width: 1200px" class="my-4">
           <v-row justify="space-between" class="mx-4">
                <v-col cols="12" align-self="center" class="text-center">
                    <div class="d-inline-flex">
                         <h1>MODELOS</h1>
                    </div>
                   <div class="d-inline-flex"  style="color: #47a5ad;">
                         <h1> {{slugLine.toUpperCase()}} </h1>
                    </div>
                     <div class="d-flex justify-center">
                  <hr align="center" noshade="noshade" class="divider" style="height: 5px" size="3" width="35%" />
              </div>
                   
                </v-col>
                <!-- <v-col cols="12" align-self="center" class="text-center" v-if="getProduct.name == 'TERRACE'">
                    <p style="font-size: 1.5em" >
                        Es un toldo de caída vertical ideal para restaurantes, terrazas, areas de fumar y/o 
                        lugar de esparcimiento donde quieres un espacio cubierto, pero al mismo tiempo que
                        permita la circulación de aire.
                    </p>
                    <p style="font-size: 1.5em" >
                        ¡Conoce nuestra variedad de tejidos!
                    </p>
                </v-col>
                <v-col cols="12" align-self="center" class="text-center" v-if="getProduct.name == 'ARION'">
                    <p style="font-size: 1.5em" >
                        Es un toldo de sistema enrrollable de grandes dimensiones y son perfectos para espacios amplios,
                        ya sea para exterior o interior.
                    </p>
                    <p style="font-size: 1.5em" >
                        ¡Conoce nuestra variedad de tejidos!
                    </p>
                </v-col>
                <v-col cols="12" align-self="center" class="text-center" v-if="getProduct.name == 'BALCONY'">
                    <p style="font-size: 1.5em" >
                        Este toldo te ofrece una caída vertical libre con capacidad de incuir un ángulo
                        gracias a la extensión de sus brazos, o que hace que sea una excelente opción 
                        para terrazas ubicadas en edificios.
                    </p>
                    <p style="font-size: 1.5em" >
                        ¡Conoce nuestra variedad de tejidos!
                    </p>
                </v-col> -->
                <v-col cols="12" align-self="center" class="text-center">
                   <v-row v-if="models"  justify="center" align="center" >
                       <v-col cols="12" md="4" sm="6"  v-for="model in models" :key="model.id">
                           <SubweaveProductDetail :model="model"/>
                           <!-- :to="{name: 'Tejidos', params: {slugLine: getProduct.slug, slugWeave: weave.slug}}" -->
                           <!-- <v-card
                           height="340" 
                           width="380" 
                           tile flat 
                           >
                           <v-hover v-slot="{ hover }">
                                <v-img :src="`/img/weaves/${model.slug}.png`" class="align-end"  height="340" width="380" :class="{'opacado':hover}">
                                    <div class="weave d-flex justify-center"  > 
                                        <h3 class="text-center">{{ model.name}}</h3> 
                                    </div> 
                                </v-img>
                             </v-hover>
                           </v-card> -->
                          
                       </v-col>
                   </v-row>
                </v-col>
                <v-col cols="12"   class="text-center mt-5">
                    <v-btn rounded color="#47a5ad" x-large dark>Ver Galería</v-btn>
                </v-col>
            </v-row>
        </v-container>
    </div>
</template>

<script>

import SubweaveProductDetail from '../components/CustomCards/SubweaveProductCard';
// import {mapState } from 'vuex';
export default {
    data(){
        return{
        
        }
    },

    created(){
        document.title = 'Modelos '+ this.slugType
    },

    mounted(){

    },
     computed:{
        // getProduct(){
        //      return  this.$store.getters.getTypes(this.slugProduct)
        // },

        models(){
            return this.$store.state.productsModule.subweaves.filter(sw => sw.line.slug === this.slugLine && sw.type.slug === this.slugType)
        },
    },

    props: {
        slugType: {
            type: String,
            required: false
        },

        // slugProduct: {
        //     type: String,
        //     required: false
        // },
        slugLine: {
            type: String,
            required: false
        },
    },

    
    components:{
        SubweaveProductDetail
    },
}
</script>

<style>
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
.weave{
    color: #47a5ad; padding: 5px; font-size: 1rem; word-break: break-word !important;
}

.opacado{
    opacity: 0.5;
}
</style>