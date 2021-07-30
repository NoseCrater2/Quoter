<template>
    <div>
        <v-container fluid style="max-width: 1200px" class="my-4">
            <v-row justify="space-between" class="mx-4" no-gutters>
                <v-col cols="12"  class="text-center">
                    <div>
                        <h2>{{slugProduct}}</h2>
                    </div>
                </v-col>
                <v-col cols="12" align-self="center" class="text-center">
                    <div class="d-inline-flex">
                        <h1>LÍNEAS</h1>
                    </div>
                    <div class="d-inline-flex" v-if="getType"  style="color: #47a5ad;">
                         <h1> {{getType.name}} </h1>
                    </div>
                   <!-- <div class="d-inline-flex" v-if="getProduct" style="color: #47a5ad;">
                         <h1 v-if="nameLine.includes('ALUMINIO')">{{nameLine+"''"}}</h1>
                         <h1 v-else>{{nameLine}}</h1>
                    </div> -->
                     <div class="d-flex justify-center">
                    <hr align="center" noshade="noshade" class="divider" style="height: 5px" size="3" width="35%" />
                    </div>

                </v-col>
                <v-row v-if="!$vuetify.breakpoint.mobile">
                <!-- <Descriptions :nameLine="nameLine"/> -->
                </v-row>
                <v-col cols="12" align-self="center" class="text-center my-7">
                   <v-row v-if="getType"  justify="center" align="center">
                       <v-col cols="12" md="4" sm="6"  v-for="line in getType.lines" :key="line.id">
                          <LineProductDetail :type="getType" :line="line"/>
                       </v-col>
                   </v-row>




                </v-col>
                <v-col cols="12"  class="text-center">
                    <v-btn rounded color="#47a5ad" :to="{name:'Gallery', props: {slugProduct: slugProduct, slugType: slugType}}" x-large dark>Ver Galería</v-btn>
                </v-col>

            </v-row>

            <!-- <v-row v-if="$vuetify.breakpoint.mobile">

              <Descriptions :nameLine="nameLine"/>
            </v-row> -->

             <v-row justify="center" align="center" class="ma-4" v-if="getProduct">
                  <v-col cols="12" align-self="center" class="text-center">
                    <div class="d-inline-flex">
                         <h2>MÁS</h2>
                    </div>
                   <div class="d-inline-flex" style="color: #47a5ad;">
                         <h2>{{getProduct.name}}</h2>
                    </div>
                     <div class="d-flex justify-center">
                  <hr align="center" noshade="noshade" class="divider" style="height: 5px" size="3" width="10%" />
              </div>

                </v-col>
                    <v-col v-for="n in getProduct.types" :key="n.id" cols="12" align-self="center" md="3" sm="6">
                        <v-hover  v-slot="{ hover }">
                            <v-btn rounded :outlined="hover?false:true" :style="hover?'color: white':''"  style="font-size:0.70em; font-weight: bolder;" block color="#47a5ad"
                            :to="{name: 'Lines', params: {slugType: n.slug}}">
                                {{n.name}}
                            </v-btn>
                        </v-hover>
                    </v-col>
            </v-row>
        </v-container>
    </div>
</template>

<script>
import LineProductDetail from '../components/CustomCards/LineProductCard';
export default {
    data(){
        return{
            model: null,
            nameLine: this.slugType.split('-').join(' ').toUpperCase(),

        }
    },

    components:{
        LineProductDetail,
    },


    beforeRouteEnter(to, from, next){

        next(um => {
             document.title = 'Líneas '+um.slugType
        })
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
        }
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

