<template>
     <v-container fluid style="max-width: 1200px" class="my-4">
         <v-row justify="space-between">
             <v-col cols="12" md="3" sm="12">
                  <v-list-group :value="isMobile?false:true" v-if="types">
                       <template v-slot:activator>    
                     <strong style="color: black">GALERÍA DE PERSIANAS</strong>
                    </template>
                        <v-list-item-group  color="#47a5ad">
                            <v-list-item 
                            v-model="selectedType"
                            :class="$route.path.includes(type.slug)?'v-item--active v-list-item--active':''"
                            v-for="type in types.types" 
                            :key="type.id" 
                            :to="{name: 'Gallery', params: {slugProduct: 'PERSIANAS',slugType: type.slug}} ">
                                <v-list-item-content>
                                    <v-list-item-title v-text="type.name"></v-list-item-title>
                                </v-list-item-content>
                            </v-list-item>
                        </v-list-item-group>
                      </v-list-group>
             </v-col>
             <v-col cols="12" md="9" sm="12">
                 <v-row justify="space-around">
                     <v-col v-for="n in 5" :key="n" cols="12" md="4" sm="12">
                         <v-img :src="`/img/galerias/enrollable/${n}.jpg`"></v-img>
                     </v-col>
                 </v-row>
             </v-col>
         </v-row>
    </v-container>
</template>

<script>
export default {
    data(){
        return{
            selectedType: null,
            isMobile: false,
        }
    },

    mounted(){
        this.onResize()
        window.addEventListener('resize', this.onResize, { passive: true })
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
        types(){
            return  this.$store.getters.getTypes(this.slugProduct)
        }
    },

    methods:{
        onResize(){
            this.isMobile = window.innerWidth < 958
        }
    }


    
}
</script>