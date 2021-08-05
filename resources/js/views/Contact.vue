<template>
    <div id="app">
        <v-container fluid style="max-width: 1200px" class="my-4">
        <v-row justify="space-between">
            <v-col cols="12" xl="6" lg="6" md="6" sm="12" >
                <v-card flat>
                    <v-card-title>CONTÁCTANOS</v-card-title>
                    <v-card-text>
                        Ponte en contacto con nosotros, llena el formulario y un asesor
                        se comunicará contigo a la brevedad posible.
                    </v-card-text>
                    <v-list-item-group >
                    <v-list-item >
                        <v-list-item-icon><v-icon color="primary">mdi-at</v-icon></v-list-item-icon>
                        <v-list-item-content>contacto@rollux.com.mx</v-list-item-content>
                    </v-list-item>
                    <v-list-item href="https://api.whatsapp.com/send?phone=5215548948279" target="_blank">
                        <v-list-item-icon><v-icon color="#31ba45">mdi-whatsapp</v-icon></v-list-item-icon>
                        <v-list-item-content>55 4894 8279</v-list-item-content>
                    </v-list-item>
                    <!-- <v-list-item>
                        <v-list-item-icon><v-icon color="red">mdi-map-marker</v-icon></v-list-item-icon>
                        <v-list-item-content>Calzada Juárez 499 Col. Ventura Puente CP 58020 en Morelia, Mich</v-list-item-content>
                    </v-list-item> -->
                    </v-list-item-group>
                </v-card>
                <v-card-title class="ml-n4 text-uppercase">Para cotizaciones e instalaciones:</v-card-title>
                <l-map
                    v-if="showMap"
                    :zoom="zoom"
                    :center="center"
                    :options="mapOptions"
                    style="z-index: 0"
                    :style="$vuetify.breakpoint.mdAndUp ? 'height: 47vh; width: 100%;' : 'height: 50vh; width: 100%;'"
                    @update:center="centerUpdate"
                    @update:zoom="zoomUpdate"
                  >
                    <l-tile-layer :url="url" :attribution="attribution" />
                    <div v-for="(itemMark, index) in arrCities" :key="index">
                      <l-marker :lat-lng="itemMark.location">
                        <l-tooltip :options="{ permanent: true, interactive: true }">
                          <div>
                            {{itemMark.city}}
                          </div>
                        </l-tooltip>
                      </l-marker>
                    </div>
                </l-map>
            </v-col>
            <v-col cols="12" xl="6" lg="6" md="6" sm="12" >
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
import { latLng } from "leaflet";
import { LMap, LTileLayer, LMarker, LPopup, LTooltip } from "vue2-leaflet";
import "leaflet/dist/leaflet.css";
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
                'Si un problema técnico ocurrre en este sitio web' ],

            zoom: 5,
            center: latLng(23.6043041, -102.7332577),
            url: 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
            attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors',
            arrCities: [
              {city: 'Morelia', location: latLng(19.7038033, -101.2761649)},
              {city: 'Aguascalientes', location: latLng(21.8830692, -102.2978658)},
              {city: 'Querétaro', location: latLng(20.5725833, -100.3889541)},
              {city: 'Toluca', location: latLng(19.2901055, -99.6613604)},
              {city: 'Acapulco', location: latLng(16.8530356, -99.8204611)},
              {city: 'Oaxaca', location: latLng(17.0550731, -96.7715414)},
              {city: 'Saltillo', location: latLng(25.4390194, -100.9740975)},
              {city: 'Tijuana', location: latLng(32.5137784, -117.0638385)},
              {city: 'Villahermosa', location: latLng(17.9919465, -92.9449881)}
            ],
            currentZoom: 11.5,
            currentCenter: latLng(23.6043041, -102.7332577),
            showParagraph: false,
            mapOptions: {
              zoomSnap: 0.5,
            },
            showMap: true,
        }
    },

    components:{
        LMap,
        LTileLayer,
        LMarker,
        LPopup,
        LTooltip,
    },

    methods:{
        zoomUpdate(zoom) {
          this.currentZoom = zoom;
        },
        centerUpdate(center) {
          this.currentCenter = center;
        },
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
