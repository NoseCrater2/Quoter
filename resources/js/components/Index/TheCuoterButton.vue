<template>
     <v-btn v-if="!$route.path.includes('quoter')"  :to="{name:'Quoter'}" class="vertical" right fixed top tile height="44px"  width="210px" style="margin-right: -85px; z-index:5; border-radius: 15px 15px 0px 0px; margin-top: 30px"  dark x-large color="#f1c40f">      
        <v-icon size="30" class="horizontal" left>mdi-calculator</v-icon>
        <b><p style="font-size: 1.2em" class="my-4 ml-4 mr-n5">COTIZADOR</p></b>
    </v-btn>
</template>

<style scoped>
.vertical
{
  -webkit-transform: rotate(-90deg);
  -moz-transform: rotate(-90deg);
  -ms-transform: rotate(-90deg);
  -o-transform: rotate(-90deg);
  transform: rotate(-90deg);
 
  -webkit-transform-origin: 50% 50%;
  -moz-transform-origin: 50% 50%;
  -ms-transform-origin: 50% 50%;
  -o-transform-origin: 50% 50%;
  transform-origin: 50% 50%;
  font-size: 1em;
 
}

.horizontal
{
  -webkit-transform: rotate(90deg);
  -moz-transform: rotate(90deg);
  -ms-transform: rotate(90deg);
  -o-transform: rotate(90deg);
  transform: rotate(90deg);
 
  -webkit-transform-origin: 0% 0%;
  -moz-transform-origin: 0% 0%;
  -ms-transform-origin: 0% 0%;
  -o-transform-origin: 0% 0%;
  transform-origin: 0% 0%;
}
</style>