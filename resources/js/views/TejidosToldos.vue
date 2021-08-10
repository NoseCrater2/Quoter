<template>
    <div>
        <v-container fluid style="max-width: 1200px" class="my-4">
           <v-row justify="space-between" class="mx-4">
               <v-col class="text-center">
                    <div class="d-inline-flex">
                         <h2>{{slugProduct}}</h2>
                    </div>
                    <div class="d-inline-flex"  >
                         <h2> {{slugType.toUpperCase().split('-').join(" ")}} </h2>
                    </div>
               </v-col>
                <!-- IF DE VERIFICACION INICIA -->
                <!-- SI NO HAY DESCRIPCION NI IMAGEN, SE PONE ESTE -->
                <v-col cols="12" align-self="center" class="text-center" v-if="computedArrayParagraphs.length == 0">
                    <div class="d-inline-flex">
                         <h1>TEJIDOS</h1>
                    </div>
                   <div class="d-inline-flex"  v-if="subweaves" style="color: #47a5ad;">
                         <h1> {{subweaves.name}} </h1>
                    </div>
                    <div class="d-flex justify-center">
                        <hr align="center" noshade="noshade" class="divider" style="height: 5px" size="3" width="35%" />
                    </div>
                </v-col>
                <!-- SI HAY DESCRIPCION NI IMAGEN, SE PONE ESTE -->
                <v-col cols="12" align-self="center" class="text-center" v-else>
                   <div class="d-inline-flex"  v-if="subweaves" style="color: #47a5ad; font-size: 2em">
                         <h1> {{subweaves.name}} </h1>
                    </div>
                    <div class="d-flex justify-center">
                        <hr align="center" noshade="noshade" class="divider" style="height: 5px" size="3" width="35%" />
                    </div>
                </v-col>
                <!-- IF DE VERIFICACION TERMINA -->
           </v-row>
            <!-- DESCRIPCION INICIA -->
            <v-row justify="space-between" class="mx-4" v-if="computedArrayParagraphs.length > 0">
                <div>
                    <v-col cols="12" align-self="center" class="text-center">
                        <p style="font-size: 1.5em" >
                            {{computedArrayParagraphs[0]}}
                        </p>
                    </v-col>
                </div>
            </v-row>
            <!-- https://via.placeholder.com/500x300 -->
            <!-- /img/subweaves/descriptions/${slugType}-${slugSubweave}.jpg -->
            <v-col cols="12" class="d-flex justify-center">
                <v-img :src="`/img/subweaves/descriptions/${slugType}-${slugSubweave}.jpg`" :max-height="$vuetify.breakpoint.xl ? 600 : $vuetify.breakpoint.lg ? 500 : 500" ></v-img>
            </v-col>
            <div v-if="computedArrayParagraphs.length > 0">
                <v-col cols="12" align-self="center" class="text-center">
                    <p v-for="(item, index) in computedArrayParagraphs" :key="index" style="font-size: 1.5em" >
                        {{index > 0 ? item : ''}}
                    </p>
                </v-col>
            </div>
            <!-- DESCRIPCION TERMINA -->
            <v-row justify="space-between" class="mx-4">
                <v-col cols="12" align-self="center" class="text-center" v-if="computedArrayParagraphs.length > 0">
                    <div class="d-inline-flex">
                         <h1>TEJIDOS</h1>
                    </div>
                   <div class="d-inline-flex"  v-if="subweaves" style="color: #47a5ad;">
                         <h1> {{subweaves.name}} </h1>
                    </div>
                    <div class="d-flex justify-center">
                        <hr align="center" noshade="noshade" class="divider" style="height: 5px" size="3" width="35%" />
                    </div>
                </v-col>


                <v-col cols="12" align-self="center" class="text-center">
                   <v-row v-if="subweaves"  justify="center" align="center" >
                       <v-col cols="12" md="4" sm="6"  v-for="weave in subweaves.weaves" :key="weave.id">
                           <v-card
                           :to="{name: 'Catalogo', params: {slugProduct: slugProduct, slugType: slugType, slugLine: slugLine, slugSubweave: subweaves.slug, slugWeave: weave.slug}}"
                           height="340"
                           width="380"
                           tile flat
                           >
                           <v-hover v-slot="{ hover }">
                                <v-img :src="`/img/weaves/${weave.slug}.png`" class="align-end"  height="340" width="380" :class="{'opacado':hover}">
                                    <div class="weave d-flex justify-center"  >
                                        <h3 class="text-center">{{ weave.name}}</h3>
                                    </div>
                                </v-img>
                             </v-hover>
                           </v-card>
                       </v-col>
                   </v-row>
                </v-col>
                <v-col cols="12" class="text-center mt-5">
                    <v-btn rounded color="#47a5ad" x-large dark>Ver Galería</v-btn>
                </v-col>
            </v-row>
        </v-container>
    </div>
</template>

<script>

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
        subweaves(){
            return this.$store.state.productsModule.subweaves.find(sw => sw.line.slug === this.slugLine && sw.type.slug === this.slugType && sw.slug === this.slugSubweave)
        },
        computedArrayParagraphs(){
            let arr = [];
            if(typeof(this.subweaves.description) != 'undefined'){
                if(this.subweaves.description != null){
                    arr = this.subweaves.description.split("\n");
                }
            }
            return arr.filter(item => item != '');
        }
    },

    props: {
        // slugWeave: {
        //     type: String,
        //     required: false
        // },
        slugSubweave: {
            type: String,
            required: false
        },
        slugLine: {
            type: String,
            required: false
        },

        slugType: {
            type: String,
            required: false
        },
        slugProduct: {
            type: String,
            required: true,
        }
    },

    // components:{
    //     SubweaveProductDetail
    // },
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
