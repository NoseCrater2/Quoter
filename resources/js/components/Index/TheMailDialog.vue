<template>
     <v-dialog v-model="openDialog" persistent max-width="600px">
                        <v-card>
                            <v-card-title>
                                Contáctanos
                            </v-card-title>
                            <v-card-text>
                      <!-- <v-btn class="mt-6" text color="error" @click="sheet = !sheet">close</v-btn> -->
                      
                           <v-container>
                               <v-row>
                                   <v-col cols="12" md="6">
                                        <v-text-field label="Nombre"></v-text-field>
                                   </v-col>
                                   <v-col cols="12" md="6">
                                         <v-text-field label="Teléfono"></v-text-field>
                                   </v-col>
                               </v-row>
                               <v-row>
                                   <v-col cols="12" md="12">
                                        <v-text-field label="Correo electrónico"></v-text-field>
                                   </v-col>
                               </v-row>

                               <v-row>
                                   <v-col cols="12" md="6">
                                         <v-text-field label="Estado"></v-text-field>
                                   </v-col>
                                   <v-col cols="12" md="6">
                                         <v-text-field label="Ciudad"></v-text-field>
                                   </v-col>
                               </v-row>
                               <v-row>
                                   <v-col cols="12" md="12">
                                         <v-textarea outlined label="Mensaje"></v-textarea>
                                   </v-col>
                                  
                               </v-row>
                            </v-container>
                      </v-card-text>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn color="blue darken-1" text @click="closeDialog"> Cancelar </v-btn>
                            <v-btn color="blue darken-1" text @click="sendMail"> Enviar </v-btn>
                            <v-spacer></v-spacer>
                        </v-card-actions>
         </v-card>
    </v-dialog>
</template>

<script>
export default {
    props: {
        openDialog: {
            type: Boolean,
            required: true,
        }
    },

    methods:{
        sendMail(){

        },

        closeDialog(){
           this.$emit('clickCloseDialog', false)
        }
    }
}
</script>