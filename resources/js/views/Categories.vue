<template>
    <div id="app">
           
        <v-container fluid style="max-width: 1200px">
        <v-row justify="space-between"  class="mx-2" v-if="getProduct" >
           
                <v-row justify="center">
                <v-col cols="11"  align-self="center">
                <h1 class="text-center" :style="$vuetify.breakpoint.mobile?'font-weight: bolder;font-size: 1.5em;':'font-weight: bolder;font-size: 3em;'"  >
                    {{getProduct.name}}
                </h1>
                <div class="d-flex justify-center">
                  <hr align="center" noshade="noshade" class="divider" style="height: 5px" size="3" width="15%" />
              </div>
               <br>
                <h2 class="text-center" :style="$vuetify.breakpoint.mobile?'font-size: 1em':''"> 
                    {{getProduct.description}}
                </h2>
                </v-col>
                </v-row>
                <v-row justify="center" align="center" v-if="getProduct">
                    <v-col v-for="type in getProduct.types" :key="type.id" cols="12" md="4" sm="6">
                        <TypeProductCard :type='type'/>
                    </v-col>
                </v-row>
                
        </v-row>
         <v-row justify="center" align="center" class="ma-4">
                    <v-col v-for="n in options.length" :key="n" cols="6" align-self="center" md="3" sm="6">
                        <v-hover v-slot="{hover}">
                            <v-btn :to="options[n-1].route" rounded :outlined="hover?false:true" :style="hover?'color: white':''" style="font-weight: bolder;" block color="#47a5ad">
                                {{options[n-1].name}}
                            </v-btn>
                        </v-hover>
                    </v-col>
        </v-row>
       </v-container>
    </div>
</template>
<script>

import TypeProductCard from '../components/CustomCards/TypeProductCard';

export default {
    data(){
        return{
           // slug: this.$route.params.slugType,
            widths: [500,380,380,420,420,420,420,420,420,420,420],
            options: [
               { name: 'Galería/Fascia', route: {name:'Home'}},
                {name: 'Motorización', route: {name:'Motorized'}},
                {name: 'Accesorios', route: {name:'Home'}},
                {name: 'Muestrario', route: {name:'Home'}},
            ]
        }
    },

    components:{
        TypeProductCard,
    },

    created(){
         document.title = this.slugProduct
    },

    mounted(){
         this.$store.dispatch('getProducts')         
    },
    computed:{
    //      ...mapState({
    //   persianas: state => state.productsModule.types,
    // }),

    getProduct(){
         return  this.$store.getters.getTypes(this.slugProduct)
    },
   
    },

    props: {
        slugProduct: String,
        required: true
    },
    
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