<template>
    <div id="app">
        <v-container fluid style="max-width: 1200px" class="my-4">
        <v-row justify="space-between">
            <v-col cols="12" md="6" sm="12" >
                <v-card flat>
                    <v-card-title>CONTÁCTANOS</v-card-title>
                    <v-card-text>
                        Ponte en contacto con nosotros, llena el formulario y un asesor
                        se comunicará contigo a la brevedad posible.
                    </v-card-text>
                    <v-list-item-group >
                    <v-list-item >
                        <v-list-item-icon><v-icon color="primary">mdi-at</v-icon></v-list-item-icon>
                        <v-list-item-content>contacto@rollux.com.mx</v-list-item-content>
                    </v-list-item>
                    <v-list-item href="https://api.whatsapp.com/send?phone=5214434713271">
                        <v-list-item-icon><v-icon color="#31ba45">mdi-whatsapp</v-icon></v-list-item-icon>
                        <v-list-item-content>443 471 3271</v-list-item-content>
                    </v-list-item>
                    <!-- <v-list-item>
                        <v-list-item-icon><v-icon color="red">mdi-map-marker</v-icon></v-list-item-icon>
                        <v-list-item-content>Calzada Juárez 499 Col. Ventura Puente CP 58020 en Morelia, Mich</v-list-item-content>
                    </v-list-item> -->
                    </v-list-item-group>
                </v-card>
            </v-col>
            <v-col cols="12" md="6" sm="12" align-self="center">
                <v-card flat>
                    <v-form class="ma-4">
                        <v-select
                        v-model="select" 
                        :items="items"
                        item-text="name"
                        item-value="id"
                        label="-- Elegir--"
                        outlined
                        :messages="messages[select] || null"
                        ></v-select>
                        <v-text-field
                        v-model="email"
                        label="Email"
                        outlined
                        >
                        </v-text-field>
                         <v-text-field
                        v-model="reference"
                        label="Orden de referencia"
                        outlined
                        >
                        </v-text-field>
                    </v-form>
                </v-card>
                    <v-card flat>
                        <v-textarea
                        rows="6"
                        class="ma-5"
                        outlined
                        name="input-7-4"
                        label="Mensaje"
                        ></v-textarea>
                        <v-card-actions>
                            <v-btn
                            dark
                            class="ml-2 mt-n10"
                            color="#47a5ad"
                            >Enviar</v-btn>
                            <v-spacer></v-spacer>
                        </v-card-actions>
                    </v-card>
            </v-col>
        </v-row>
        </v-container>
    </div>
</template>

<script>
export default {
    data(){
        return{
            reference: null,
            email: null,
            select: null,
           
            items: [
                {id:1, name:'Webmaster'},
                 {id:0, name:'Servicio al cliente'}
            ],
            messages: [
                'Para cualquier pregunta acerca de un producto u orden',
                'Si un problema técnico ocurrre en este sitio web' ]
        }
    },

    methods:{
       
    },

    computed:{
        screenW(){
            return screen.width - 20;
        }
    },

    created(){
        document.title = 'Rollux Contacto'
    }

}
</script>