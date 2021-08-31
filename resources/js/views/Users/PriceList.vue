<template>
    <div>
        <v-container fluid style="max-width: 1200px" class="my-4">
            <v-row justify="center">
                <v-col cols="12" align-self="center" class="text-center">
                    <div class="d-inline-flex">
                        <h1>LISTAS DE</h1>
                    </div>
                    <div class="d-inline-flex" style="color: #47a5ad;">
                        <h1>PRECIOS ROLLUX</h1>
                    </div>
                    <div class="d-flex justify-center">
                        <hr
                            align="center"
                            noshade="noshade"
                            class="divider"
                            style="height: 5px"
                            size="3"
                            width="35%"
                        />
                    </div>
                    <div class="my-3">
                        Manténte siempre actualizado con los mejores precios del mercado a nivel nacional.
                    </div>
                    <!-- TODOS LOS BOTONES LOS CARGO MANUALMENTE DEBIDO A QUE NO SE PUDO LEER EL FOLDER DE PDF COMPLETO -->

                    <v-row justify="center" justify-xl="start" justify-lg="start" justify-ms="start" justify-sm="start" class="mt-1">

                        <v-col cols="12" xl="3" lg="3" md="3" sm="4" v-for="itemPdf in prices" :key="itemPdf.id">
                            <v-card
                                outlined
                                elevation="0"
                                height="350"
                                width="300"
                                class="d-flex flex-column"
                            >
                              <v-img
                               height="310"
                               width="300"
                                :src="`/img/${itemPdf.thumbnail}`"
                              ></v-img>
                              <v-card-title class="d-flex justify-center">{{itemPdf.title}}</v-card-title>
                              <v-card-actions class="d-flex justify-center mb-2">
                                <v-btn
                                    rounded
                                    color="#47a5ad"
                                    class="white--text"
                                    target="_blank" :href="'http://127.0.0.1:8000/img/'+itemPdf.path"
                                  >
                                    Descargar
                                </v-btn>
                              </v-card-actions>
                            </v-card>
                        </v-col>

                    </v-row>
                </v-col>
            </v-row>
        </v-container>
    </div>
</template>

<script>
import { mapState } from 'vuex';
//NO LO IMPLEMENTE POR QUE NO SE PODIAN LEER TODO EL FOLDER DE PDFS
// const fs = require('fs');
export default {
    data(){
        return{
            pdfRoute:[
                {fileName: 'ROLLTEX 2021', link: '/img/pdfs/ROLLTEX 2021.pdf'},
                {fileName: 'TECNO SHADES 2021', link: '/img/pdfs/TECNO SHADES 2021.pdf'},
                {fileName: 'TREESHADES 2021', link: '/img/pdfs/TREESHADES 2021.pdf'},
                {fileName: 'VERTILUX ENROLLABLES 2021', link: '/img/pdfs/VERTILUX ENROLLABLES 2021.pdf'},
                {fileName: 'VERTILUX NEOLUX 2021', link: '/img/pdfs/VERTILUX NEOLUX  2021.pdf'},
            ]
            // pdfs: []
        }
    },
    mounted() {
        this.$store.dispatch('getPrices')
        // this.importAll(require.context('../../../../public/img/pdfs/', false, /\.(pdf)$/));
  },

  methods: {
    // importAll(r) {
    //   r.keys().forEach(key => (this.pdfs.push({ pathLong: r(key), pathShort: key })));
    //   console.log(this.pdfs)
    // },
  },

  computed: {
    ...mapState({
        prices: state => state.priceModule.prices,
    }),
  }
};
</script>

<style></style>
