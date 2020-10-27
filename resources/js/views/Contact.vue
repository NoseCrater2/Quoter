<template>
    <div id="app">
        <v-container fluid style="max-width: 1400px" class="my-4">
        <v-row justify="space-around">
            <v-col cols="12" md="6" sm="6" align-self="center">
                <v-card flat>
                    <v-card-title>CUSTOMER SERVICE - CONTACT US</v-card-title>
                    <v-card-text>
                        Transformer theme is an elegant, powerful and 
                        fully responsive prestashop theme with modern design. 
                        Suitable for every type of store.
                    </v-card-text>
                    <v-list-item>
                        <v-list-item-icon><v-icon>mdi-at</v-icon></v-list-item-icon>
                        <v-list-item-content>support@support.com</v-list-item-content>
                    </v-list-item>
                    <v-list-item>
                        <v-list-item-icon><v-icon>mdi-phone</v-icon></v-list-item-icon>
                        <v-list-item-content>support@support.com</v-list-item-content>
                    </v-list-item>
                      <v-list-item>
                        <v-list-item-icon><v-icon>mdi-clock-outline</v-icon></v-list-item-icon>
                        <v-list-item-content>09: - 16:00</v-list-item-content>
                    </v-list-item>
                      <v-list-item>
                        <v-list-item-icon><v-icon>mdi-skype</v-icon></v-list-item-icon>
                        <v-list-item-content>Skype001</v-list-item-content>
                    </v-list-item>
                    <v-list-item>
                        <v-list-item-icon><v-icon>mdi-cellphone-android</v-icon></v-list-item-icon>
                        <v-list-item-content>1256698855</v-list-item-content>
                    </v-list-item>
                      <v-list-item>
                        <v-list-item-icon><v-icon>mdi-printer</v-icon></v-list-item-icon>
                        <v-list-item-content>+222 568954</v-list-item-content>
                    </v-list-item>
                    <v-list-item>
                        <v-list-item-icon><v-icon>mdi-map-marker</v-icon></v-list-item-icon>
                        <v-list-item-content>Collins Street West Victoria 8007</v-list-item-content>
                    </v-list-item>
                </v-card>
            </v-col>
            <v-col cols="12" md="6" sm="6" align-self="center">
                <v-card flat>
                    <v-card-title></v-card-title>
                <iframe 
                src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d2848.52270726363!2d-101.19171797887016!3d19.702374961885237!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1ses!2smx!4v1603230488891!5m2!1ses!2smx" 
                width="600" 
                height="450" 
                frameborder="0" 
                style="border:0;" 
                allowfullscreen="" 
                aria-hidden="false" 
                tabindex="0">
                </iframe>
            </v-card>
            </v-col>
        </v-row>

        <v-row justify="space-around" >
            <v-col cols="12" md="4" sm="12">
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
            </v-col>
            <v-col cols="12" md="8" sm="12">
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
       
    }
}
</script>