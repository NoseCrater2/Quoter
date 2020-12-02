<template>
    <div>
         <v-card >
            <v-toolbar color="black" class="white--text">
                <v-toolbar-title>Tipos</v-toolbar-title>
            </v-toolbar>  
            <v-list >
                <v-list-item-group
                active-class="black--text"
                multiple
                >
                    <template v-for="(type, t) in types">
                        <v-list-item :key="type.id">
                            <template >
                                <v-list-item-content>
                                    <v-list-item-title v-text="type.name"></v-list-item-title>
                                </v-list-item-content> 
                            </template>
                        </v-list-item>
                        <v-divider :key="type.name"></v-divider>
                    </template>

                </v-list-item-group>
            </v-list>
        </v-card>
    </div>
</template>

<script>
import { mapActions, mapState } from 'vuex';
export default {
    data(){
        return {
            
        }
    },

    mounted(){
       this.$store.dispatch('getTypes',this.product.id)  
    },

    computed:{
        ...mapState({
            types: state => state.productsModule.types,
        }),
    },
    props:{
        product: {
            type: Object, 
            required: true,
        }, 
    },


}
</script>