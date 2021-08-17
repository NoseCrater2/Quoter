<template>
     <v-row style="max-width: 1200px; margin: auto;" justify="space-around" >
            <v-col  v-for="(item, i) in items" :key="i" cols="12" md="6" sm="12" >
                <v-card  flat  :to="{name: 'Categories', params: {slugProduct: item.title}}">
                    <v-card-title class="justify-center">
                        <div class="d-inline font-weight-bold" style="font-size: 1.5em">{{ item.title }}</div>
                        <div class="d-inline font-weight-bold" style="color: #47a5ad;font-size: 1.5em" >&nbsp;ROLLUX</div>
                    </v-card-title>
                    <div style="display: grid; height: 240px">
                        <v-hover v-slot:default="{ hover }" >
                            <v-img
                            :width="item.height" style="margin: auto;"
                            :class="{'opacado':hover}" :src="item.img">
                            </v-img>
                        </v-hover>
                    </div>
                    <v-card-subtitle class="justify-center mx-10"  style="font-size: 1.2em; color: black; text-align: center">
                        {{item.subtext}}
                    </v-card-subtitle>
                </v-card>
            </v-col>
        </v-row>
</template>

<script>
export default {
    data(){
        return {
            icons: [
                {image: 'img/cortinas.png', width:130, mobilew:85},
                {image: 'img/toldos.png', width:180, mobilew:105}
            ],
            transparent: 'rgba(255, 255, 255, 0)',
            items: [
                {
                    title: 'PERSIANAS',
                    subtext: 'Contamos con la más amplia gama de texturas y colores de todo el mercado nacional para el recubrimiento de ventanas, suficiente para cubrir cualquier necesidad, requerimiento y gusto.',
                    img: 'img/home/PERSIANAS.svg',
                    height: '150',

                },
                {
                    title: 'TOLDOS',
                    subtext: 'Contamos con una gran variedad de toldos retráctiles, toldos de caída libre, palilleria y brazos rectos para cubrir cualquer necesidad en el exterior de tu jardín, terraza, entre otros.',
                    img: 'img/home/TOLDOS.svg',
                    height: '270',
                },
            ],
        }
    }
}
</script>

<style  scoped>
.on-hover {

    transform: scale(1.02);
    -moz-transform: scale(1.02);
    -webkit-transform: scale(1.02);
    -o-transform: scale(1.02);
    -ms-transform: scale(1.02);
    transition-duration: .25s;

 }

 .condensed{
   font-stretch: ultra-expanded;
     font-weight: normal !important;
      transition-duration: 1.5s;
      font-weight: bolder !important;

 }

 .reset {
    transition-duration: .25s;
 }


.marco{
    border: 4px solid white;

}

.force-center{
    flex-grow: 0 !important;
}

.opacado{
    opacity: 0.5;
}
</style>
