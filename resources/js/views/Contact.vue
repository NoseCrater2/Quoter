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
                    <v-list-item>
                        <v-list-item-icon><v-icon>mdi-at</v-icon></v-list-item-icon>
                        <v-list-item-content>contacto@rollux.com.mx</v-list-item-content>
                    </v-list-item>
                    <v-list-item>
                        <v-list-item-icon><v-icon>mdi-whatsapp</v-icon></v-list-item-icon>
                        <v-list-item-content>443 471 3271</v-list-item-content>
                    </v-list-item>
                    <v-list-item>
                        <v-list-item-icon><v-icon>mdi-map-marker</v-icon></v-list-item-icon>
                        <v-list-item-content>Calzada Juárez 499 Col. Ventura Puente CP 58020 en Morelia, Mich</v-list-item-content>
                    </v-list-item>
                </v-card>
            </v-col>
            <v-col cols="12" md="6" sm="12" align-self="center">
                <v-card flat>
                    
                <iframe 
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3609.4639216929395!2d-101.1971075780396!3d19.692317650857703!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x842d0dd8042d1c91%3A0x3463136d53b34e91!2sMadec!5e0!3m2!1ses!2smx!4v1606505528852!5m2!1ses!2smx"
                :width="$vuetify.breakpoint.mobile?screenW :600"
              
                :height="$vuetify.breakpoint.mobile?270:450" 
                frameborder="0" 
                style="border:0;max-width: 600px; min-width: 300px; max-height: 450px; min-height:225px" 
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