<template>
    <div id="app">
        <v-parallax dark  src="/img/nosotros/1.jpg" :height="max_height-170">
            <v-row align="center" justify="center">
                <v-col class="text-center" cols="11" md="7" sm="12" style="background-color: rgba(10, 10, 10, 0.5);">
                    <h1>NOSOTROS</h1>
                   
                </v-col>
            </v-row>
        </v-parallax>
        <v-container fluid style="max-width: 1200px" class="my-4">
        
        <Slogan/>
        <!-- <iframe width="100%" height="500"  src="http://test.siilkaab.com/bookings/1" frameborder="0">

        </iframe> -->
        </v-container>
        <v-row style="background-color: #47a5ad;"  align="center" justify="center"  class="pa-0 ma-0">
                <v-col cols="12" md="5" sm="12" class="pa-0 " align-self="center">
                    <v-img max-width="650" max-height="600" src="../../img/nosotros/2.jpg">

                    </v-img>
                </v-col>
                <v-col cols="12" md="7" sm="12" class="pa-0" align-self="center">
                    <div style= "margin-top: 20px" :style="$vuetify.breakpoint.mobile?'margin-left: 15px;margin-right: 15px;':'margin-left: 100px;margin-right: 100px;'" >
                    <div class="d-block" style="color: white; max-width: 750px" :style="$vuetify.breakpoint.mobile?'0.7':'font-size: 1.4em'">
                        <p style="text-align: justify">
                            <b class="especial">Rollux</b> integra en su línea de textiles para persianas
                            Enrollables la mas amplia gama de texturas y colores de todo
                            mercado nacional para el recubrimiento de ventanas, suficiente
                            para cubrir cualquier necesidad, requerimiento y gusto.
                        </p>
                    </div>
                    <br>
                    <div class="d-block" :style="$vuetify.breakpoint.mobile?'0.7':'font-size: 1.4em'" style="color: white; max-width: 750px">
                        <p style="text-align: justify">
                      <b class="especial">Rollux</b> es innovación y evolución por lo que costantamente nos
                      actualizamos para brindar nuevos y mejores productos, la autorización
                      y la tecnología de nuestros motores para persianas, cortinas y toldos
                      están pensados siempre con el objetivo de dar mayor satisfacción.
                      </p>
                    </div>
                  <br>
                    <div class="d-block"  style="color: white; font-size: 1.7em">
                      <p class="especial"><b>... una Satisfacción Garantizada</b></p>
                    </div>
                    </div>
                </v-col>
        </v-row>
        <v-row class="pa-0 ma-0">
            <v-img src="../../img/nosotros/3.jpg" :height="$vuetify.breakpoint.mobile?'400':max_height">
                <v-col cols="8" >
                    <v-img src="../../img/nosotros/4.jpg" class="white--text align-center" >
                     <v-container fluid style="max-width: 570px">
                        <div class="d-block">
                            <span class="especial " :style="$vuetify.breakpoint.mobile?'font-size: 1.8em':'font-size: 4.8em'">Rollux es</span>
                            <p class="especial" :style="$vuetify.breakpoint.mobile?'font-size: 2.5em;':'font-size: 6em; margin-top: -60px!important;'">Experiencia</p>
                        </div>
                        <div class="d-block">
                            <h1  :style="$vuetify.breakpoint.mobile?'font-size: 16px;':'font-size: 32px;'">
                                Más de 25 años en el mercado marcan garantía y reconocimiento
                                de la calidad de nuestros productos.
                            </h1>
                        </div>
                    </v-container>
                    </v-img>
                </v-col>
            </v-img>
        </v-row>
        <v-row class="grey lighten-3 pa-0 ma-0">
            <v-container fluid style="max-width: 1200px; width: 1200px; min-width: 200px" class="my-4">
                <v-row>
                    <v-col cols="12" md="6" sm="12" v-for="(t, index) in team" :key="index">
                        <v-card color="transparent"  flat tile>
                            <v-card-title>
                                  <p style="font-size: 1.3em" class="especial">{{ t.title}}</p>
                            </v-card-title>
                            <v-card-text>
                                <p style="font-size: 1.4em; text-align: justify">
                                    {{ t.text }}
                                </p>
                            </v-card-text>
                        </v-card>
                        <div class="d-block" >
                           
                        </div>
                        <div class="d-block">
                            
                        </div>
                    </v-col>
                </v-row>
            </v-container>
        </v-row>

        <v-row class="pa-0 ma-0">
            <v-container fluid style="max-width: 1200px" >
                <v-row justify="center">
                    <v-col cols="12" md="7" sm="12" align-self="center">
                        <p :style="$vuetify.breakpoint.mobile?'font-size: 1em':'font-size: 1.4em'"  class="ma-4" style="text-align: justify">
                            Como empresa solcialmente responsable, nos preocupamos
                            por crear ambientes limpios y saludables, somos defensores
                            activos del cuidado del ecosistema, por ello, muchos de nuestros
                            tejidos cuentan con características especiales en su composición
                            y fabricación, en pro del medio ambiente y el cuidado de la salud
                        </p>
                       
                    </v-col>
                    <v-col cols="12" md="5" sm="12">
                        <v-img max-width="500" src="/img/nosotros/5.jpg"></v-img>
                    </v-col>
                    <v-col cols="12" align-self="center" >
                         <v-img class="ma-16" max-width="250" src="/img/nosotros/6.png"></v-img>
                    </v-col>
                </v-row>
            </v-container>
        </v-row>


    </div>
</template>
<script>

import Slogan from '../components/Slogan';
export default {
    data(){
        return{
            max_height: screen.height,
            team: [
                {title: 'Además, proveemos...',
                text: 'Ambientes de trabajo en el que cada individuo encuentra las condiciones perfectas para maximizar su potencial, lo que permite una mejor calidad de vida y un mejor desarrollo de ideas que se verán reflejadas en la satisfacción de nuestros clientes.'},
                {title: 'Todos son importantes para nosotros', 
                text: 'Nuestros clientes, proveedores, distribuidores y empleados, son igual de importantes para nosotros, por lo que tenemos una filosofía de respeto y valor por igual para todos.'},
            ],
        }
    },

    components: {
        Slogan,
    },

     created(){
        document.title = 'Rollux Nosotros'
    }
}
</script>

<style >


.divider{
    border: none;
    height: 5px;
    background-color: #47a5ad;
}

.especial{
    font-style: italic;
    font-weight: 900;
}




@keyframes blink {
  0%, 100% {
    opacity: 1;
  }
  
  50% {
    opacity: 0;
  }
}
</style>