<template>
    <v-snackbar   left bottom timeout="5000" height="100" color="white" v-model="snackbar">
        <div class="d-flex justify-end">
            <v-btn @click="snackbar = false" height="0" width="0" class="pt-3 pr-1"  icon><v-icon size="15" color="black">mdi-close</v-icon></v-btn>
        </div>
            
        <div v-if="variant" style="color: black" class="d-flex flex-no-wrap   mb-2 mx-2">
             <v-avatar size="90" tile>
                <v-img :src="`/img/modelos/medium/${variant.image}.jpg`"></v-img>
            </v-avatar>
            <div>
                <v-card-subtitle class="py-1 px-4">
                    {{ fakeName}} compró
                </v-card-subtitle>
                <v-card-title style="font-size: 16px; font-weight: bolder" class="py-0 px-4">{{variant.name}} - {{fakeWidth}} x {{fakeHeight}}</v-card-title>
                <v-card-text class="pa-1 px-4">Hace unos segundos</v-card-text>
            </div>
        </div>
    </v-snackbar>
</template>

<script>
import { mapState} from 'vuex';
const faker = require('faker/locale/es_MX')
export default {
    data(){
        return{
            variant: null,
            snackbar: false,
            fakeName: null,
            fakeWidth: 0,
            fakeHeight: 0,
        }
    },

    mounted(){
        setInterval(() => {
                this.fakeWidth = Math.floor(Math.random() * (500 - 100) + 100) / 100
                this.fakeHeight = Math.floor(Math.random() * (500 - 100) + 100) / 100
                this.fakeName = faker.name.firstName()+' '+faker.name.lastName()
                this.variant =   this.variants[Math.floor(Math.random() * this.variants.length)]
                this.snackbar = true
        }, 60000);
    },

    computed: {
        ...mapState({
            variants: state => state.productsModule.variants,
        }),
    },
}
</script>

<style >
.v-snack__content{
    padding: 0;
}
</style>