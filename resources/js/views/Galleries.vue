<template>
     <v-container fluid style="max-width: 1200px" class="my-4">
         <v-row justify="space-between">
             <v-col cols="12" md="3" sm="12">
                    <v-list-group :value="isMobile?false:true" v-if="persianas" class="mb-5">
                       <template v-slot:activator>
                            <strong style="color: black">GALERÍA DE PERSIANAS</strong>
                        </template>
                        <v-list-item-group  color="#47a5ad">
                            <v-list-item
                            v-model="selectedType"
                            v-for="type in persianas.types"
                            :key="type.id"
                            :to="{name: 'Gallery', params: {slugProduct: 'PERSIANAS',slugType: type.slug}} ">
                                <v-list-item-content>
                                    <v-list-item-title v-text="type.name"></v-list-item-title>
                                </v-list-item-content>
                            </v-list-item>
                        </v-list-item-group>
                    </v-list-group>

                    <v-list-group :value="isMobile?false:true" v-if="toldos" class="mt-5">
                       <template v-slot:activator>
                            <strong style="color: black">GALERÍA DE TOLDOS</strong>
                        </template>
                        <v-list-item-group  color="#47a5ad">
                            <v-list-item
                            v-model="selectedType"
                            v-for="type in toldos.types"
                            :key="type.id"
                            :to="{name: 'Gallery', params: {slugProduct: 'TOLDOS',slugType: type.slug}} ">
                                <v-list-item-content>
                                    <v-list-item-title v-text="type.name"></v-list-item-title>
                                </v-list-item-content>
                            </v-list-item>
                        </v-list-item-group>
                    </v-list-group>
             </v-col>
             <v-col cols="12" md="9" sm="12" >

                 <v-row justify="center" align="center" no-gutters style="text-align: center">
                     <v-col cols="12">
                         <h1 style="font-size: 2.5em">Galería de imagenes</h1>
                     </v-col>
                     <v-col cols="12">
                         <h2  style="color: #47a5ad; font-weight: normal;">
                             {{slugProduct.toLowerCase().replace(/^\w/, (c) => c.toUpperCase())}} {{slugType.replace(/^\w/, (c) => c.toUpperCase())}}
                         </h2>
                     </v-col>
                 </v-row>

                 <v-row v-if="images.length > 0"  justify="center">
                    <v-col cols="12" md="4" sm="6" v-for="(image, index) in images" :key="index">
                        <v-hover v-slot="{ hover }">
                            <v-img
                            @click="openDialog(index)"
                            :src="`/img/${image}`"
                            :class="hover?'expanded':''"
                            class="align-center grey darken-4"
                            :gradient="hover?'rgba(0, 0, 0, 0.7) 100%, transparent 72px':''" >
                                <v-row justify="center" align="center">
                                     <v-icon class="zooom" dark v-if="hover" size="75">mdi-magnify</v-icon>
                                </v-row>
                            </v-img>
                        </v-hover>

                            <!-- <img  :alt="index"> -->
                    </v-col>
                 </v-row>
                 <v-row  v-else justify="center" align="center">
                     <v-col style="text-align:center; height: 500px">
                         <span >NO HAY IMAGENES</span>
                     </v-col>
                 </v-row>

             </v-col>
         </v-row>
          <v-dialog persistent v-model="dialog" fullscreen hide-overlay transition="dialog-bottom-transition">
              <v-carousel height="100%" hide-delimiter-background hide-delimiters v-model="position" >
                    <v-carousel-item
                    eager
                    v-for="(image,i) in images"
                    :key="i"
                    class="grey darken-4"
                    >
                    <template v-slot:default>
                        <div style="height: 60px; background-color: rgba(0, 0, 0, 0.5); position: fixed; z-index: 2; width: 100%; text-align: end;">
                            <v-btn small class="ma-2" dark style="background: rgba(0, 0, 0, 0.3);" icon fab rounded @click="dialog = false">
                                <v-icon>mdi-close</v-icon>
                            </v-btn>
                        </div>
                            <v-img :src="`/img/${image}`" aspect-ratio="1" contain height="100%"></v-img>
                    </template>
                    </v-carousel-item>
              </v-carousel>
          </v-dialog>
    </v-container>
</template>

<script>
export default {
    data(){
        return{
            overlay:  false,
            position: 0,
            dialog: false,
            images: [],
            selectedType: null,
            isMobile: false,
            error: null,
        }
    },

    mounted(){
        this.overlay = true
        this.onResize()
        window.addEventListener('resize', this.onResize, { passive: true })
        axios.get('/api/directory?product='+this.slugProduct+'&type='+this.slugType).then(response => {
            this.images = response.data
            this.overlay = false
        }).catch(error =>{
           this.error = error.data
        })
    },

     props: {
        slugType: {
            type: String,
            required: false
        },
         slugProduct: {
            type: String,
            required: false
        }
    },

    computed:{
        persianas(){
            return  this.$store.getters.getTypes('PERSIANAS')
        },
        toldos(){
            return  this.$store.getters.getTypes('TOLDOS')
        },



    },

    methods:{
        onResize(){
            this.isMobile = window.innerWidth < 958
        },

        openDialog(index){
            this.position = index
            this.dialog = true
        }
    }
}
</script>

<style >
  .overlay {
    background: rgba(0, 0, 0, 0.6);
    transition: background 400ms ease;
  }
  .overlay:hover {
    background: rgba(0, 0, 0, 0);
  }

.expanded div:not(.zooom){
    transition: all .7s;
 transform: scale(1.1);
  }


.expanded:last-child div i{
 transform: none;
  }

</style>
