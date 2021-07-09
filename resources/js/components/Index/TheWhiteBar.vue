<template>
    <v-row justify="center" class="mx-3 my-1"  style="max-height: 90px" >
        <v-card  width="1200px" class="d-flex" max-height="77" tile flat>
            <v-card tile flat class="mr-auto" :to="{name: 'Home'}">
                <v-img width="200"  src="/img/logo.svg" ></v-img>
            </v-card>                          
                
            <v-card tile  flat class="mt-6" >
                <v-btn  x-small icon color="#3b5999" fab href="https://www.facebook.com/rolluxmexico"  class="mr-3">
                    <v-icon  size="30">mdi-facebook</v-icon>
                </v-btn>
                <v-btn icon  x-small color="#2caae1" fab href="https://twitter.com/rolluxmexico" class="mr-3">
                    <v-icon size="30">mdi-twitter</v-icon>
                </v-btn>
                <v-btn  icon x-small fab  class="mr-3">
                    <v-img src="/img/instagram-logo.png" ></v-img>
                </v-btn>
                <v-btn icon  x-small color="#cc2127" href="https://www.pinterest.com.mx/rolluxmexico" fab class="mr-3" >
                    <v-icon size="30">mdi-pinterest</v-icon>
                </v-btn>
            </v-card>    
        </v-card>
    </v-row>
</template>