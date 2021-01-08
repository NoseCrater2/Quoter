<template>
    <div id="app">
            <v-card max-width="600" flat>
                <v-data-table
                :headers="headers"
                :items="orders"
                disable-pagination
                hide-default-footer
                >
                    <template v-slot:item.actions="{ item }">
                        <v-icon class="mr-2" small @click="editItem(item)">mdi-pencil</v-icon>
                        <v-icon small>mdi-delete</v-icon>
                    </template>
                </v-data-table>
                <v-card-actions>
                    <p>Total</p>
                    <v-spacer></v-spacer>
                    <p class="display-1" color="#47a5ad"> ${{ totalPrice }} MXN </p>
                </v-card-actions>
                <v-card-actions>
                    <v-spacer></v-spacer>
                        <v-btn class="ma-2"  color="#47a5ad" dark  small >Realizar pedido</v-btn>

                        <v-btn class="ma-2"  color="#47a5ad" dark small :loading="loading"  :disabled="orders.length>0?false:true" @click="downloadPdf()">Imprimir</v-btn>

                         <v-btn class="ma-2"  color="#47a5ad" dark small >Enviar por Email</v-btn>
                    <v-spacer></v-spacer>
                </v-card-actions>
            </v-card>
    </div>
</template>

<script>
import { mapActions, mapState, productModule} from 'vuex';
const FileDownload = require('js-file-download');
export default {
    data(){
        return{
            loading: false,
            headers: [
                {text: 'Modelo', align: 'start', sortable: 'false', value:'variant'},
                {text: 'Color',  value:'color'},
                {text: 'Alto',  value:'height'},
                {text: 'Ancho',  value:'width'},
                {text: 'Precio',  value:'price'},
                { text: 'Acciones', value: 'actions', sortable: false}
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

    },

    methods: {
        downloadPdf(){
            this.loading = true;
            axios.post( '/api/order-list-pdf',
                this.orders, {responseType: 'blob',}
            ).then(response =>{
                FileDownload(response.data, 'orders.pdf')
                this.loading = false
            })
            .catch( errors => {
                this.loading = false
           
            });
        },

        editItem(item){
           this.$emit('edit', item.id)
        }
        
    }
}
</script>