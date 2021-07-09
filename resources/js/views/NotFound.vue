<template>
    <div id="app">
       <v-app>
        <v-row justify="center" align="center">
             <v-container style="max-width: 750px" >
            <v-col  cols="12" align-self="center" class="text-center">
             <v-card width="750" height="750" flat tile>
                  <v-card-subtitle>
                     <p class="display-2">
                        No hemos encontrado esta pagina. Intente de nuevo
                    </p>
                 </v-card-subtitle>
                 <v-card-subtitle>
                     <v-img src="../img/logo.svg" width="750" height="200" :to="{name: 'Home'}">

                     </v-img>
                </v-card-subtitle>
                 <v-card-actions>
                     <v-btn block dark color="#47a5ad" :to="{name:'Home'}">
                         REGRESAR A HOME
                     </v-btn>
                     
                 </v-card-actions>
            </v-card>
           </v-col>
             </v-container>   
        </v-row>
       
      
   </v-app>
        
    </div>
</template>

<style scoped>
*{
    font-family: 'Raleway';
}
</style>

