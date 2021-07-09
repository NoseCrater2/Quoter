<template>
    <v-row justify="space-around" class="pa-0 ma-0">
        <v-col cols="auto" class="pa-0 ma-0">
            <v-dialog v-model="dialog" transition="dialog-top-transition" max-width="600">
                <v-card >
                    <v-row class="ma-0 pa-0">
                        <v-col class="ma-0 pa-0" cols="12" md="6" sm="12" style="background-color: #1E1E1E; width: 300px; height: 300px;"  >
                             <v-list class="mt-13 ml-5" dark dense>
                                 <v-subheader  style="font-size: 1em; font-style: italic;">
                                     REGÍSTRATE PARA OBTENER BENEFICIOS EXCLUSIVOS
                                </v-subheader>
                                <v-list-item>
                                    <v-list-item-icon>
                                        <v-icon>mdi-calculator</v-icon>
                                    </v-list-item-icon>
                                    <v-list-item-content>
                                        <v-list-item-title>COTIZADOR EN LÍNEA</v-list-item-title>
                                    </v-list-item-content>
                                </v-list-item>
                                <v-list-item>
                                    <v-list-item-icon>
                                        <v-icon>mdi-label-percent</v-icon>
                                    </v-list-item-icon>
                                    <v-list-item-content>
                                        <v-list-item-title>DESCUENTOS ESPECIALES</v-list-item-title>
                                    </v-list-item-content>
                                </v-list-item>
                                <v-list-item>
                                    <v-list-item-icon>
                                        <v-icon>mdi-whatsapp</v-icon>
                                    </v-list-item-icon>
                                    <v-list-item-content>
                                        <v-list-item-title>ATENCIÓN PERSONALIZADA</v-list-item-title>
                                    </v-list-item-content>
                                </v-list-item>
                            </v-list>
                        </v-col>
                        <v-col class="ma-0 pa-0" cols="12" md="6" sm="12" style="background-color: #47a5ad; width: 300px; height: 300px;" >
                            <div class="d-flex justify-end" >
                                 <v-btn @click="dialog = false" dark icon>
                                    <v-icon >mdi-close</v-icon>
                                </v-btn>
                            </div>
                            <div class="d-flex justify-center" style="margin-top: 95px;">
                                <v-hover v-slot="{ hover }">
                                    <v-btn :to="{name: 'Register'}" @click="dialog = false" class="pulseBtn" :outlined="hover" rounded style="color:#47a5ad "  color="white">REGISTRARME</v-btn>
                                </v-hover>
                            </div>
                        </v-col>
                    </v-row>
                </v-card>
            </v-dialog>
        </v-col>
    </v-row>
</template>

<script>
export default {
    data(){
        return{
            dialog: false,
        }
    },

      mounted(){
        setTimeout(() => {
            this.dialog = true
        }, 60000);
    },
}
</script>

<style  scoped>
.pulseBtn {
    box-shadow: 0 0 0 0 rgba(230, 237, 255, 0.7);
    animation: pulse 1.75s infinite cubic-bezier(0.66, 0, 0, 1);
}

@keyframes pulse {
    to {
      box-shadow: 0 0 0 100px rgba(255, 255, 255, 0);
    }
}
</style>