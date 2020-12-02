<template>
    <div>
        <v-navigation-drawer app v-model="drawer" style="z-index: 8;" temporary>
            <v-divider></v-divider>
            <v-list dense>
                <v-list-item :to="{name:'Home'}">
                    <v-list-item-icon>
                        <v-icon>mdi-home</v-icon>
                    </v-list-item-icon>
                </v-list-item>
                <v-divider></v-divider>
                <v-list-item >
                    <v-list-item-content>
                        <v-list-item-title>GALERÍA</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                <v-divider></v-divider>
                <v-list-item to="/contact">
                    <v-list-item-content>
                        <v-list-item-title>CONTACTO</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                <v-divider></v-divider>
                <v-list-item  to='/aboutus'>
                    <v-list-item-content>
                        <v-list-item-title>NOSOTROS</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                <v-divider></v-divider>
                <v-list-group  v-model="showProducts" no-action>
                    <template v-slot:activator>
                        <v-list-item-content>
                            <v-list-item-title >PRODUCTOS</v-list-item-title>
                        </v-list-item-content> 
                    </template>
                    <v-list-item v-for="p in products" :key="p.name" :to="{name: 'Categories', params: {slugType: p.slug}}">
                        <v-list-item-title> {{ p.name }} </v-list-item-title>
                    </v-list-item>
                </v-list-group>
            </v-list>
      </v-navigation-drawer>
    </div>
</template>

<script>
export default {
    data(){
        return{
            showProducts: true,
        }
    },

    computed:{
        drawer(){
            return this.draw   
        }
    },

    props:{
        products:{
            type: Array,
            required: true,
        },

        draw: {
            type: Boolean,
            required: true,
        }
    }
}
</script>
