<template>
    <div>
        <v-container fluid style="max-width: 1200px" class="my-4">
           <v-row justify="space-between" class="mx-4">
                <v-col cols="12" align-self="center" class="text-center">
                    <div class="d-inline-flex">
                         <h1>TEJIDOS</h1>
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
                <v-col cols="12" align-self="center" class="text-center" v-if="getProduct">
                   <v-row v-if="getType" justify="center" align="center" >
                       <v-col cols="12" md="4" sm="6"  v-for="weave in getType.weaves" :key="weave.id">
                            <WeaveProductDetail :line="slugLine" :type="slugType" :weave="weave"/>
                           <!-- <v-card
                           height="340" 
                           width="380" 
                           tile flat 
                           :to="{name: 'Products', params: {slugLine: getProduct.slug, slugWeave: weave.slug}}">
                           <v-hover v-slot="{ hover }">
                                <v-img :src="`/img/weaves/${weave.slug}.png`" class="align-end"  height="340" width="380" :class="{'opacado':hover}">
                                    <div class="weave d-flex justify-center"  > 
                                        <h3 class="text-center">{{ weave.name}}</h3> 
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

import WeaveProductDetail from '../components/CustomCards/WeaveProductCard';
export default {
    data(){
        return{
        
        }
    },

    created(){
        document.title = this.slugLine
    },

    mounted(){
        // this.$store.dispatch('getWeaves',this.slugLine)
    },
    computed:{
        getProduct(){
             return  this.$store.getters.getTypes(this.slugProduct)
        },

        getType(){
            if(this.getProduct){
                 return this.$store.getters.getTypes(this.slugProduct).types.find(type => type.slug === this.slugType)
            }
           
        },
    },

    props: {
        slugType: {
            type: String,
            required: false
        },

        slugProduct: {
            type: String,
            required: false
        },
        slugLine: {
            type: String,
            required: false
        },
    },

    
    components:{
        WeaveProductDetail
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