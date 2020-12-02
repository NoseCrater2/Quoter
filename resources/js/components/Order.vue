<template>
    <div id="app">
            <v-card max-width="600">
                <v-card-title>
                    ORDEN
                </v-card-title>
                <v-data-table
                :headers="headers"
                :items="orders"
                disable-pagination
                hide-default-footer
                class="elevation-1"
                ></v-data-table>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <p class="display-1"> {{ totalPrice }} </p>
                </v-card-actions>
                <v-card-actions>
                    <v-spacer></v-spacer>

                    <v-tooltip top>
                        <template v-slot:activator="{ on, attrs }">
                           <v-btn fab class="ma-2" v-bind="attrs"  v-on="on"> <v-icon>mdi-account-voice</v-icon></v-btn>
                        </template>
                        <span>Realizar pedido</span>
                    </v-tooltip>
                    <v-tooltip top>
                       <template v-slot:activator="{ on, attrs }">
                           <v-btn fab class="ma-2" v-bind="attrs"  v-on="on"> <v-icon>mdi-cloud-print</v-icon></v-btn>
                        </template>
                        <span>Imprimir o envíar por email</span>
                    </v-tooltip>
                    <v-spacer></v-spacer>
                </v-card-actions>
            </v-card>
    </div>
</template>

<script>
export default {
    data(){
        return{
            headers: [
                {text: 'Modelo', align: 'start', sortable: 'false', value:'variant'},
                {text: 'Color',  value:'color'},
                {text: 'Alto',  value:'height'},
                {text: 'Ancho',  value:'width'},
                {text: 'Precio',  value:'price'},
            ]
        }
    },

    computed: {
        orders(){
            return this.$store.getters.orderBlinds
        },

        totalPrice(){
            return this.$store.getters.totalPrice
        }

    }
}
</script>