<template>
    <div id="app">
         <v-app id="inspire">
             <v-main>
                 <v-container align="start" justify="center">
          <!--Aqui se vera con router-view la informacion de hoteles, usuarios, etc-->
                     <router-view></router-view>
                 </v-container>
            </v-main>
        </v-app>
    </div>
</template>

<script>

export default {
  data() {
    return {
    
    };
  },
  props: {
   
  },
  
  components: {
   
  }
};
</script>