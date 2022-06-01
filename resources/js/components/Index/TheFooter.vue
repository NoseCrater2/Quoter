<template>
                 <v-footer color="#47a5ad" >
               <v-container fluid style="max-width: 1200px" >
                 <v-row justify="space-between">
                     <v-col cols="12" md="3" sm="6" class="white--text" align-self="start" >
                       <v-list-item dense>
                           <v-img  max-width="250px" src="/img/white-logo.svg" > </v-img>
                        </v-list-item >
                        <v-list-item dark dense>
                            ventas@rollux.com.mx
                        </v-list-item>
                         <v-list-item dark dense>
                            distribuidores@rollux.com.mx
                        </v-list-item>
                        <v-list-item dark dense>
                            De Lunes a Viernes
                            9:00 am a 05:00 pm
                        </v-list-item>
                         </v-col>

                     <v-col cols="12" md="3" sm="6"  class=" white--text"  >
                         <v-list-item dark>
                             <v-list-item-icon>
                                <v-icon size="50">mdi-cellphone-android</v-icon>
                            </v-list-item-icon>
                            <v-list-item-content>
                                  <strong> DESCARGA LA APP DEL COTIZADOR</strong>
                            </v-list-item-content>
                            </v-list-item>
                            <v-list-item>
                                <a href="https://play.google.com/store/apps/details?id=grupo.lidhber.rollux.app" target="blank">
                                    <img src="/img/dashboard/disponible-en-google-play-badge.svg" alt="">
                                </a>
                           </v-list-item>
                            <v-list-item dark>
                                <v-list-item-content>
                                <div :class="{'text-center':!isMobile}"> <b>SÍGUENOS EN:</b> </div>
                                </v-list-item-content>
                            </v-list-item>
                            <v-list-item>
                                <v-btn dark  x-small icon href="https://www.facebook.com/rolluxmexico"  fab>
                                    <v-icon   size="30">mdi-facebook</v-icon>
                                </v-btn><v-spacer v-if="!isMobile"></v-spacer>
                                 <v-btn dark icon  x-small href="https://twitter.com/rolluxmexico"  fab>
                                    <v-icon size="30">mdi-twitter</v-icon>
                                </v-btn><v-spacer v-if="!isMobile"></v-spacer>
                                <v-btn dark  icon x-small fab>
                                    <v-icon size="30">mdi-instagram</v-icon>
                                </v-btn><v-spacer v-if="!isMobile"></v-spacer>
                                <v-btn dark icon href="https://www.pinterest.com.mx/rolluxmexico"  x-small fab>
                                    <v-icon size="30">mdi-pinterest</v-icon>
                                </v-btn>
                            </v-list-item>
                     </v-col>

                     <v-col cols="12" md="3" sm="6" class=" white--text "  align-self="start">

                       <v-list-group :value="isMobile?false:true"  color="white" dark >
                         <template v-slot:activator>

                            <v-list-item-title style="color: white;" dark> <b>PRODUCTOS</b> </v-list-item-title>
                         </template>

                         <v-list-item class="mt-n4" dark>
                             <v-list-item-icon><v-icon>mdi-chevron-right</v-icon></v-list-item-icon>
                               <v-list-item-content>PERSIANAS </v-list-item-content>
                        </v-list-item>
                        <v-list-item class="mt-n4" dark>
                             <v-list-item-icon><v-icon>mdi-chevron-right</v-icon></v-list-item-icon>
                             <v-list-item-content>TOLDOS </v-list-item-content>
                        </v-list-item>
                       </v-list-group>


                     </v-col>
                     <v-col cols="12" md="3" sm="6" class=" white--text"  align-self="start">
                          <v-list-group :value="isMobile?false:true"  color="white" dark >
                         <template v-slot:activator>
                          <v-list-item-title style="color: white;" dark> <b>POLÍTICAS</b> </v-list-item-title>
                            </template>
                         <v-list-item dark class="mt-n6">
                             <v-list-item-icon><v-icon>mdi-chevron-right</v-icon></v-list-item-icon>
                               <v-list-item-content>Envíos</v-list-item-content>
                        </v-list-item>
                        <v-list-item dark class="mt-n6">
                             <v-list-item-icon><v-icon>mdi-chevron-right</v-icon></v-list-item-icon>
                             <v-list-item-content>Términos y Condiciones</v-list-item-content>
                        </v-list-item>
                        <v-list-item dark class="mt-n6" :to="{name: 'Legal'}">
                             <v-list-item-icon><v-icon>mdi-chevron-right</v-icon></v-list-item-icon>
                             <v-list-item-content>Aviso de Privacidad</v-list-item-content>
                        </v-list-item>
                        <v-list-item dark class="mt-n6">
                             <v-list-item-icon><v-icon>mdi-chevron-right</v-icon></v-list-item-icon>
                             <v-list-item-content>Compra segura</v-list-item-content>
                        </v-list-item>
                      </v-list-group>
                     </v-col>
                 </v-row>
                 </v-container>
             </v-footer>
</template>

<script>
export default {
    props: {
        isMobile: {
            type: Boolean,
            required: true,
        }
    }
}
</script>
