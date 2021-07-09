<template>
    <v-col cols="12"  class="text-center" v-if="nameLine === 'SHEER'">
        <div class="d-block">
            <div  style="font-size: 1.5em">
                La <b style="color: #47a5ad">Persiana Sheer</b>  es la unión del minimalismo y la funcionalidad. Esta persiana representa la nueva generación
                de persiana enrollable con doble funcionalidad en un sólo producto: transparencia y privacidad a elegir. 
                Con accionamiento a cadena o motor, y en modernos y decorativos modelos y colores que satisfacen cualquier necesidad y gusto.
            </div>
        </div>
    </v-col>
    <v-col cols="12"  class="text-center"  v-else-if="nameLine === 'TRIPLE SHADE SANGRI LA'">
        <div class="d-block">
            <div  style="font-size: 1.5em">
                La <b style="color: #47a5ad">Triple shade / Shangri La</b>  es un tejido único y versátil de triple función, 
                el cual brinda la capacidad de controlar la intensidad de la luz en su totalidad; creando espacios 
                donde es empleado y sensaciones de máximo confort gracias a la funcionalidad del triple tejido.
            </div>
        </div>
    </v-col>
     <v-col cols="12"  class="text-center"  v-else-if="nameLine === 'FLEX BALLET'">
        <div class="d-block">
            <div  style="font-size: 1.5em">
                La <b style="color: #47a5ad">Persiana FlexiBallet </b>  es una línea de productos premium y contamos
                 con una variedad de colores y texturas pensados para brindar a tus espacios calidez y elegancia, 
                 encontrarás una opción para cada espacio.
            </div>
        </div>
    </v-col>
    <v-col cols="12"  class="text-center"  v-else-if="nameLine === 'HORIZONTAL ALUMINIO 1'">
        <div class="d-block">
            <div  style="font-size: 1.5em">
                Líneas puras y una extensa gama de colores y acabados completan esta  <b style="color: #47a5ad">Persiana Horizontal de Aluminio 1” </b>
                funcional. ideal para orientar la luz solar y mantener la privacidad.
            </div>
        </div>
    </v-col>
    <v-col cols="12"  class="text-center"  v-else-if="nameLine === 'HORIZONTAL ALUMINIO 2'">
        <div class="d-block">
            <div  style="font-size: 1.5em">
                Las <b style="color: #47a5ad">Persiana Horizontal de Aluminio 2” </b>
               son comúnmente utilizadas en las oficinas; sin embargo, con la llegada de
               nuevos materiales y modelos, se han convertido en las favoritas de muchos hogares
               gracias a algunas de sus características como la durabilidad, practicidad, facilidad de instalación y su limpieza.
            </div>
        </div>
    </v-col>
    <v-col cols="12"  class="text-center"  v-else-if="nameLine === 'VERTICAL'">
        <div class="d-block">
            <div  style="font-size: 1.5em">
                Nuestra <b style="color: #47a5ad">persiana Vertical </b>
              es una solución práctica e inteligente. Ideales para cualquier dimensión de ventana, ventanas inclinadas o en desnivel, 
              ventanas en escaleras y sobre todo económica. En definitiva no hay obstáculos para nuestra persiana más funcional y versátil.
              Disponible en la más extensa selección de tejidos decorativos y técnicos, con tratamientos repelentes al polvo y anti-manchas 
              perfectamente lavables y que no se encogen ni se decoloran.

            </div>
        </div>
    </v-col>
    <v-col cols="12"  class="text-center"  v-else-if="nameLine === 'TEJIDOS SCREEN'">
        <div class="d-block">
            <div  style="font-size: 1.5em">
                La linea de <b style="color: #47a5ad">Tejidos Screen </b>
             más completa del mercado en colores y aperturas.
            </div>
        </div>
    </v-col>
    <v-col cols="12"  class="text-center"  v-else-if="nameLine === 'TEJIDOS TRASLUCIDOS '">
        <div class="d-block">
            <div  style="font-size: 1.5em">
                La gama más completa de  <b style="color: #47a5ad">Tejidos Traslucidos</b>
             más completa del mercado en colores y aperturas.
            </div>
        </div>
    </v-col>
    <v-col cols="12"  class="text-center"  v-else-if="nameLine === 'TEJIDOS BLACKOUT'">
        <div class="d-block">
            <div  style="font-size: 1.5em">
                La gama más completa de  <b style="color: #47a5ad">Tejidos Blackout</b>
                en todo el país.
            </div>
        </div>
    </v-col>
    <v-col cols="12"  class="text-center"  v-else-if="nameLine === 'ROMANTIC'">
        <div class="d-block">
            <div  style="font-size: 1.5em">
                La línea de <b style="color: #47a5ad">Persianas Romantic</b>
              está creada con la finalidad de vestir espacios que generen
               atmósferas elegantes a través de su funcionamiento suave y 
               delicado que permite la interacción entre estilos clásicos y 
               las nuevas tendencias de diseño al ofrecer un tejido exclusivo e innovador.
            </div>
        </div>
    </v-col>
     <v-col cols="12"  class="text-center"  v-else-if="nameLine === 'HORIZONTAL DE MADERA 2'">
        <div class="d-block">
            <div  style="font-size: 1.5em">
                La nobleza de la madera se convierte en elegancia en esta <b style="color: #47a5ad">Persiana Horizontal de Madera 2''. </b>
              Sutiles líneas transforman la luz en calidez, con un perfecto acabado natural.
            </div>
        </div>
    </v-col>
    <v-col cols="12"  class="text-center"  v-else-if="nameLine === 'CELULAR'">
        <div class="d-block">
            <div  style="font-size: 1.5em">
                Nuestra <b style="color: #47a5ad">Persiana Vertical </b>
                vienen con una amplia selección de tejidos técnicos traslucidos y black out,
                estos últimos con un laminado de material aluminizado que garantiza e
                incrementa el bloqueo y la protección solar, además de ser un excelente
                aislante térmico.
            </div>
        </div>
    </v-col>
</template>


<script>
export default {
    props: {
        nameLine:{
            type: String,
            required: true,
        },
        
    },
}
</script>