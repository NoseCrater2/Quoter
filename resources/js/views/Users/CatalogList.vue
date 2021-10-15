<template>
    <v-container fluid style="max-width: 1200px" class="my-4">
        <v-row justify="center">
            <v-col cols="12" align-self="center" class="text-center">
                <div class="d-inline-flex">
                   <h1>CATÁLOGO</h1> 
                </div>
                <div class="d-inline-flex" style="color: #47a5ad;">
                    <h1>DIGITAL</h1>
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
                 <v-row justify="center" justify-xl="start" justify-lg="start" justify-ms="start" justify-sm="start" class="mt-1">

                        <v-col cols="12" xl="3" lg="3" md="3" sm="12" v-for="itemPdf in catalogs" :key="itemPdf.id">
                            <v-card
                                elevation="0"
                                height="350"
                                width="250"
                                class="d-flex flex-column"
                            >
                            <v-card-text >
                                 <v-img
                                 style="box-shadow: 17px 14px 25px -21px rgba(0,0,0,1);"
                                height="210"
                                width="250"
                                :src="`/img/${itemPdf.thumbnail}`"
                              ></v-img>
                            </v-card-text>
                                <!-- <span>Última actualización: {{itemPdf.updated_at}}</span> -->
                                <span class="font-weight-bold" style="font-size: 13px">{{itemPdf.title}}</span>
                            <v-card-actions  class="mt-0 pt-0 d-flex justify-center ">
                                <v-btn
                                    rounded
                                    color="#47a5ad"
                                    class="white--text"
                                    target="_blank" :href="'https://rollux.com.mx/img/'+itemPdf.path"
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
</template>

<script>
import { mapState } from 'vuex';
//NO LO IMPLEMENTE POR QUE NO SE PODIAN LEER TODO EL FOLDER DE PDFS
// const fs = require('fs');
export default {
    data(){
        return{
        }
    },
    mounted() {
        this.$store.dispatch('getCatalogs')
        // this.importAll(require.context('../../../../public/img/pdfs/', false, /\.(pdf)$/));
  },

  methods: {
  },

  computed: {
    ...mapState({
        catalogs: state => state.catalogsModule.catalogs,
    }),
  }
};
</script>
</script>
