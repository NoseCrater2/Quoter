<template>
    <div>
        <!-- <div id="string" @click="animationed">
            <div id="ball" ></div>
        </div> -->
        <v-parallax   src="/img/motorized/Motorizacion-Slide.jpg" height="900">
            <v-row align="center" justify="center">
                <v-col class="text-center white--text" cols="11" md="7" sm="12" style="background-color: rgba(10, 10, 10, 0.5);">
                    <h1 :class="$vuetify.breakpoint.smAndDown?'display-1':'display-2'">PERSIANAS MOTORIZADAS</h1>
                </v-col>
            </v-row>
        </v-parallax>
        <v-container fluid style="max-width: 1200px; margin: auto">
            <v-card flat class="mt-10">
                <v-row justify="center" class="pa-0  ma-0" >
                    <v-col cols="12" class="text-center pa-0 ma-0" >
                        <div  class="d-inline-flex my-1"  >
                            <h1  :style="$vuetify.breakpoint.smAndDown?'font-size: 16px':'font-size: 32px'">BENEFICIOS DE</h1>
                        </div> 
                        <div  class="d-inline-flex my-1" style="color: #47a5ad;"  >
                            <h1 :style="$vuetify.breakpoint.smAndDown?'font-size: 16px':'font-size: 32px'">MOTORIZAR TUS PERSIANAS</h1>
                        </div>
                        <div class="d-flex justify-center">
                            <hr align="center"  class="divider" style="height: 5px; background-color: #47a5ad;" size="3" width="20%" />
                        </div>
                    </v-col>

                    <v-col cols="12" class="text-center">
                        <p class="font-italic" :style="$vuetify.breakpoint.smAndDown?'font-size: 16px':'font-size: 32px'">Empecemos a definir</p>
                        <div  class="d-inline-flex my-1">
                            <h1 :style="$vuetify.breakpoint.smAndDown?'font-size: 16px':'font-size: 32px'">¿Qué son las</h1>
                        </div> 
                        <div  class="d-inline-flex my-1" style="color: #47a5ad;">
                            <h1 :style="$vuetify.breakpoint.smAndDown?'font-size: 16px':'font-size: 32px'">persianas motorizadas?</h1>
                        </div>
                    </v-col>
                </v-row>
                <v-row no-gutters style="max-width: 1200px; margin: auto">
                    <v-col cols="12" md="12" sm="12" class="text-center pa-0" style="margin:auto;">
                        <p :style="$vuetify.breakpoint.smAndDown?'font-size: 13px':'font-size: 22px'">
                            Son mecanismos que funcionan con energía eléctrica a través de baterías de acuerdo al gusto
                            del cliente o al tipo de persianas que se desee motorizar, ambas presentaciones vienen con un
                            mando de control a distancia el cual funciona a través de radio frecuencia para que no tengan
                            que apuntar directamente a la persiana para su accionamiento, los motores se incorporan en los
                            tubos de las persianas enrollables o al lado de los rieles de un panel japonés, vertical, romanas,
                            entre otras y mediante su accionamiento permiten que las persianas o cortinas se recojan o se
                            cierren de manera automática otorgando con ello grandes beneficios.
                        </p>
                    </v-col>
                </v-row>
            </v-card>
        </v-container>
        <v-row no-gutters>
            <v-col style="background-color:#47a5ad" cols="12" md="6" sm="12" class="d-flex justify-end"> 
                <v-card color="transparent" flat max-width="550" class="mr-8" style="margin:auto">
                    <v-card-title class="white--text d-flex justify-center font-italic" :style="$vuetify.breakpoint.smAndDown?'font-size: 1.2em':'font-size: 2.4em'">La ventaja más relevante</v-card-title>
                    <v-card-text class="white--text" style="text-align: justify;line-height: 1.2em;" :style="$vuetify.breakpoint.smAndDown?'font-size: 0.75em':'font-size: 1.5em'">
                        La ventaja más relevante está en evitar el
                        esfuerzo de tener que manipular las
                        persianas manualmente logrando con esto
                        mucha comodidad, confort y generando un 
                        ambiente totalmente innovador y moderno
                        al solo accionar y dar la orden de apertura de 
                        cierre de las persianas y cortinas por medio
                        de un mando a distancia - control remoto.
                    </v-card-text>
                    <v-card-text class="white--text" style="text-align: justify;line-height: 1.2em;" :style="$vuetify.breakpoint.smAndDown?'font-size: 0.75em':'font-size: 1.5em'">
                        El motorizar las persianas también ayuda
                        alargando la vida útil de las persianas.
                    </v-card-text>
                </v-card>
            </v-col>
            <v-col cols="12" md="6" sm="12"> 
                   <v-card  flat class="d-flex justify-start">
                       <v-img :aspect-ratio="16/10" width="70%" src="/img/motorized/main-adventage.png">

                       </v-img>
                   </v-card>
            </v-col>
        </v-row>
           <v-row no-gutters style="max-width: 1200px;margin: auto;">
            <!-- <v-col cols="0" md="2" sm="0" >
                <v-card  flat class="d-flex justify-right align-right">
                    <v-img aspect-ratio="0.5" src="/img/motorized/recuadros-izquierda.png"></v-img>
                </v-card>
                
            </v-col> -->
            <v-col cols="0" md="4" sm="0" >
               
                    <v-img aspect-ratio="0.5" src="/img/motorized/Tu-casa-inteligente.jpg"></v-img>
              
            </v-col>
            <v-col cols="12" md="" sm="0" style="margin: auto" >
                <v-card class="ml-8 "  max-width="800" flat >
                   
                        <v-img :width="$vuetify.breakpoint.smAndDown?'50':'100'" class="mx-auto mt-4"  src="/img/motorized/casa-inteligente.png"></v-img>
                    
                    <v-card-title class="font-italic justify-center " style="font-size: 2em" >
                        <div class="d-inline" :style="$vuetify.breakpoint.smAndDown?'font-size: 16px':'font-size: 32px'">
                            Tu casa&nbsp;
                        </div>
                         <div class="d-inline" style="color: #47a5ad" :style="$vuetify.breakpoint.smAndDown?'font-size: 16px':'font-size: 32px'">
                            inteligente
                        </div>
                    </v-card-title>
                    <v-card-text style="text-align: center; ;line-height: 1.2em;" :style="$vuetify.breakpoint.smAndDown?'font-size: 0.75em':'font-size: 1.5em'">
                        El segundo punto importante es que a través de la motorización de tus
                        persianas y mediante un dispositivo adicional, podrás automatizar todas
                        las persianas de tu casa, este proceso se llama <strong>domótica</strong> o 
                        <strong>casa inteligente</strong>, y que el accionamiento no solo se pueda hacer desde
                        un control remoto, sino también por medio de tu celular desde cualquier
                        parte del mundo, siempre y cuando tengas servicios de internet en tu casa
                        y al mismo tiempo datos en tu dispositivo móvil.
                    </v-card-text>
                    <v-card-text class="pb-8" style="text-align: center;line-height: 1.2em;" :style="$vuetify.breakpoint.smAndDown?'font-size: 0.75em':'font-size: 1.5em'">
                        También podrás temporizar las persianas escogiendo un horario de
                        cierre y de apertura para cada día de la semana y también a través de un
                        sensor podrás hacer que todas las persianas o las que desees se abran
                        con la salida del Sol y dejen pasar los rayos, con el fin de que la casa
                        se caliente un poco o simplemente que funcione haciendo las veces de tu
                        despertador natural.
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
        

       
                  <v-row  no-gutters >
            <v-col style="background-color:#EEEEEE;" cols="12" md="6" sm="12" class="d-flex justify-end" > 
                <v-card color="transparent" flat max-width="550" style="margin: auto" class="text-center" :class="$vuetify.breakpoint.smAndDown?'':'mr-8'"  >
                     
                        <v-img class="mx-auto mt-4" :width="$vuetify.breakpoint.smAndDown?'50':'100'"  src="/img/motorized/seguridad.png"></v-img>
                   
                    <v-card-title class="font-italic justify-center" style="font-size: 2em" >
                        <div class="d-inline" :style="$vuetify.breakpoint.smAndDown?'font-size: 16px':'font-size: 32px'">
                            Otorga más&nbsp;
                        </div>
                         <div class="d-inline" style="color: #47a5ad" :style="$vuetify.breakpoint.smAndDown?'font-size: 16px':'font-size: 32px'">
                            seguridad
                        </div>
                    </v-card-title>
                    <v-card-text  style="text-align: justify;line-height: 1.2em;" :style="$vuetify.breakpoint.smAndDown?'font-size: 0.75em':'font-size: 1.5em'" >
                        No solo la comodiad y confort juega un
                        papel importante  a la hora de motorizar tus
                        persianas, el hecho de que no se cuente con
                        cuerdas y cordeles hacen de las persianas
                        motirizadas sean la mejor solución para
                        otorgar seguridad tanto a los niños como a
                        tus mascotas, eliminando totalmente el riesgo
                        de accidentes o ahorcamiento.
                    </v-card-text>
                </v-card>
            </v-col>
            <v-col cols="12" md="6" sm="12"> 
                   
                       <v-img height="100%" src="/img/motorized/seguridad.jpg">
                      
                       </v-img>
                 
            </v-col>
        </v-row>
        
        <v-img  src="/img/motorized/smart-home.jpg"  >
        
            <v-row justify="space-around" style="height: 100%">
                <v-col md="4">

                </v-col>
               <v-col md="4" style="background-color: rgba(71, 165, 173, .8)"  >
                     <v-card color="transparent" flat max-width="550"  class="white--text text-center" style="margin-top: 25%"   >
                    <v-card-title class="font-italic justify-center mb-8 d-block" :style="$vuetify.breakpoint.smAndDown?'font-size: 16px':'font-size: 32px'">
                        Smart Home
                    </v-card-title>
                    <v-card-text  class="white--text d-block" style="text-align: justify; line-height: 1.2em;" :style="$vuetify.breakpoint.smAndDown?'font-size: 0.75em':'font-size: 1.5em'"  >
                       Otro beneficio es poder mantener la
                       temperatura apropiada en tu hogar ya que a
                       distancia podrás dar la orden de apertura
                       o cierre de las persianas dependiendo del 
                       clima que este haciendo en el sector donde
                       esté ubicada tu casa, aunque hay que tener
                       en cuenta que esto depende en gran medida
                       de las condiciones de aislamiento térmico
                       que tengan tus paredes y ventanas.
                    </v-card-text>
                    </v-card>
        
               </v-col>
                       
             </v-row>
        </v-img>

        
               
        
              
         
        
      
        <v-row no-gutters style="z-index: 3">
            <v-col cols="12" md="6" sm="12" class="d-flex justify-end"> 
                <v-card flat max-width="550"  style="margin: auto; z-index: 2"  :class="$vuetify.breakpoint.smAndDown?'':'mr-8'" >
                   <v-card-title class="font-italic justify-center mb-8" style="font-size: 2em" >
                        <div class="d-inline" :style="$vuetify.breakpoint.smAndDown?'font-size: 16px':'font-size: 32px'">
                           Para tener&nbsp;
                        </div>
                         <div class="d-inline" style="color: #47a5ad" :style="$vuetify.breakpoint.smAndDown?'font-size: 16px':'font-size: 32px'">
                            en cuenta...
                        </div>
                    </v-card-title>
                    <v-card-text  style="text-align: justify; line-height: 1.2em;" :style="$vuetify.breakpoint.smAndDown?'font-size: 0.75em':'font-size: 1.5em'" >
                        En algunos casos, se podrán motorizar las
                        persianas manuales que ya tienes, pero hay
                        que tener en cuenta que, en este caso, es 
                        necesario contactarnos, para que una persona 
                        experta en el tema te asesore, ya que se 
                        deben considerar varios factores cómo son: 
                        tipo de persiana, medida del tubo o riel, 
                        entre otras especificaciones técnicas.
                    </v-card-text>
                   
                </v-card>
            </v-col>
            <v-col cols="12" md="6" sm="12" > 
                 
                       <v-img style="z-index: 2" :aspect-ratio="16/9" width="100%" src="/img/motorized/to-considerate.jpg">

                       </v-img>
                  
            </v-col>
        </v-row>
    </div>
   
</template>

<script>

export default {
    data(){
        return{
            screenWidtH: screen.width,
        }
    },

    mounted(){
    
    },

    methods:{
        animationed(){
            let element = document.getElementById("string");
            element.classList.toggle("pull");
            //element.classList.remove("pull");  
            element.classList.toggle("cilck"); 
           // element.classList.remove("click");    
        }
    }

  
}
</script>

<style>
    #string{
        position: sticky;
        height: 700px;
        width: 3px;
        top: -30%;
        background-color: #47a5ad;
        left: 5%;
        cursor: pointer;
        float: left;
        z-index: 2;
    }

    #ball {
    position: relative;
    top: 100%;
    left: -8px;
    border-radius: 50%;
    background-color: gray;
    height: 20px;
    width: 20px;
    }  

    .pull {
  animation: pull 0.5s 1 ease;
}

.click {
  animation: click 0.5s 1 ease;
}


@keyframes pull {
  0% {
    animation-timing-function: linear;
  }
  100% {
    transform: translateY(20%);
  }
}
@keyframes click {
  0% {
    transform: translateY(20%);
  }
  10% {
    transform: translateY(30%);
  }
  100% {
    transform: translateY(0%);
  }
}
</style>