<template>
  <v-row align="center" justify="center" >
    <v-container style="max-width: 1200px">
  <v-card min-width="350" width="600" min-height="200" flat>

    <v-col cols="12">
      COMPRESOR DE IMAGENES
    </v-col>
    <v-col cols="12">
    <v-file-input
      v-model="files"
      color="#47a5ad"
      counter
      multiple
      @change="images"
       accept="image/png, image/jpeg, image/bmp"
      placeholder="Seleccione imagenes"
      prepend-icon="mdi-paperclip"
      outlined
      :show-size="1000"
    >
      <template v-slot:selection="{ index, text }">
        <v-chip
          v-if="index < 2"
          color="#47a5ad"
          dark
          label
          small
        >
          {{ text }}
        </v-chip>

        <span
          v-else-if="index === 2"
          class="overline grey--text text--darken-3 mx-2"
        >
          +{{ files.length - 2 }} Imagen(es)
        </span>
      </template>
    </v-file-input>
    </v-col>
    </v-card>
    <v-row >
      <v-col
        v-for="(img, index) in imgs"
        :key="index"
        class="d-flex child-flex"
        cols="12"
        md="3"
        sm="12"

      >
      <v-card width="300">
            <v-img
              width="300"
              height="300"
              :src="img"

              class="grey lighten-2 white--text align-end"
            >
            <div style="background-color: rgba(0, 0, 0, 0.6)">
              <v-card-title class="mb-n3">{{ files[index].name }}</v-card-title>
              <span class="ml-4">({{ humanFileSize(files[index].size) }})</span>
            </div>

            </v-img>
            <v-card-actions style="background-color: white">
              <v-select dense label="nivel de compresión" outlined :items="compressorLevels">
              </v-select>
              <v-select dense label="Destino" outlined :items="destinyPaths">

              </v-select>
            </v-card-actions>
            <v-card-actions style="background-color: white">
              <v-btn color="#47a5ad" dark>SUBIR</v-btn>
            </v-card-actions>
        </v-card>
      </v-col>
    </v-row>
    </v-container>
     </v-row>

</template>

<script>
export default {
    data(){
        return{
            files:[],
            imgs: [],
            currentImage: null,
            compressorLevels: [0.3,0.4,0.5,0.6,0.7,0.8,0.9],
            destinyPaths: ['Modelos', 'Carrusel', 'Cortina', 'Toldo'],
        }
    },

    methods: {
      print(){

      },
        selectImage(event){
            this.currentImage = event.target.files[0];

            //Declaramos una variable llamada "sizeImageQuality" que llevara el porcentaje de calidad de la imagen
            let sizeImageQuality;
            //Las imagenes estan en bytes
            //Menor a 512,000bytes q = 0.8
            //Menor a 1,048,576bytes q = 0.6
            //Menor a 5,242,880bytes q = 0.4
            //Menor a 11,534,336bytes q = 0.2

            //Se asigna un valor de quality a la variable "sizeImageQuality" de acuerdo a su tamaño (en bytes)
            if (this.currentImage.size < 512000) {
              sizeImageQuality = 0.8;
            }
            if (this.currentImage.size >= 512000 && this.currentImage.size < 1048576) {
              sizeImageQuality = 0.6;
            }
            if (
              this.currentImage.size >= 1048576 &&
              this.currentImage.size < 11534336
            ) {
              sizeImageQuality = 0.4;
            }
            if (this.currentImage.size >= 11534336) {
              sizeImageQuality = 0.2;
            }

            //Se crea una instancia de Compressor.js y se le manda la imagen recien seleccionada y la calidad
            //A la cual dejara la imagen una vez terminada la compresion
            let compressImg = new Compressor(this.currentImage, {
              quality: sizeImageQuality,
              //success(result) {
              //},
              //error(err) {
              //console.log(err.message);
              //},
            });

            //La variable state "this.hotel" en su propiedad "image" ahora pasa a contener la imagen comprimida
            //(Es un objeto, y realmente la imagen esta contenida de la siguiente manera
            //"this.hotel.image.result"; sin embargo, no se puede añadir desde aqui directamente la propiedad "result"
            //del compressor a la variable state)
            this.currentImage = {compressImage: compressImg};

            const reader = new FileReader();
            //Esto trae la URL temporal de la imagen actual
            reader.readAsDataURL(this.currentImage);
            reader.onload = (e) => {
              //Guarda el base64 de la imagen
            this.urlTemporal = e.target.result;
            };
            //Seteamos la variable para que quede vacia y el contenedor de imagen <v-img> no la cargue
            this.currentImage = "";
        },

        humanFileSize(size) {
          var i = Math.floor( Math.log(size) / Math.log(1024) );
          return ( size / Math.pow(1024, i) ).toFixed(2) * 1 + ' ' + ['B', 'kB', 'MB', 'GB', 'TB'][i];
        },
    },

    computed:{
      images(){
           this.imgs = [];
            if(this.files.length > 0){
                this.files.forEach(file => {
                    const reader = new FileReader()
                    reader.readAsDataURL(file)
                    reader.onload = (e) => {
                        this.imgs.push(e.target.result)
                    }
                });
            }
      }
    }
}
</script>
