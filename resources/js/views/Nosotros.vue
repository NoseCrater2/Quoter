<template>
    <div id="app">
        <v-container fluid style="max-width: 1400px" class="my-4">
        <h1>Acerca de nosotros</h1>
        <v-row justify="space-around" >
            <v-col cols="12" md="4" sm="12">
                <v-card flat>
                    <v-card-title>OUR COMPANY</v-card-title>
                     <v-divider></v-divider>
                    <v-card-subtitle>
                        Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididun.
                    </v-card-subtitle>
                    <v-card-text>
                        Lorem ipsum dolor sit amet conse ctetur adipisicing elit,
                         sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                        Ut enim ad minim veniam. Lorem ipsum dolor sit amet conse ctetur adipisicing elit.
                    </v-card-text>
                  
                        <v-list-item>
                            <v-list-item-icon>
                                <v-icon color="green">mdi-check-bold</v-icon>
                            </v-list-item-icon>
                            <v-list-item-content color="green">Top quality products</v-list-item-content>
                        </v-list-item>
                        <v-divider></v-divider>
                        <v-list-item>
                            <v-list-item-icon>
                                <v-icon color="green">mdi-check-bold</v-icon>
                            </v-list-item-icon>
                            <v-list-item-content color="green">Best customer service</v-list-item-content>
                        </v-list-item>
                        <v-divider></v-divider>
                        <v-list-item>
                            <v-list-item-icon>
                                <v-icon color="green">mdi-check-bold</v-icon>
                            </v-list-item-icon>
                            <v-list-item-content color="green">30-days money back guarantee</v-list-item-content>
                        </v-list-item>
                    
                </v-card>
            </v-col>
            <v-col cols="12" md="4" sm="12">
                <v-card flat>
                    <v-card-title>OUR TEAM</v-card-title>
                    <v-divider></v-divider>
                    <v-img max-width="300px" class="align-text" src="https://www.utel.edu.mx/blog/wp-content/uploads/2014/06/Copia-de-shutterstock_167031578.jpg"></v-img>
                    <v-card-subtitle>
                        Lorem set sint occaecat cupidatat non
                    </v-card-subtitle>
                    <v-card-text>
                        Eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                        quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo.
                    </v-card-text>
                </v-card>
            </v-col>
            <v-col cols="12" md="4" sm="12">
                 <v-card flat>
                    <v-card-title>TESTIMONIALS</v-card-title>
                    <v-divider></v-divider>
                    <div class="polygon">
                        <p>
                             Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim.
                        </p>
                    </div>
                    <v-card-subtitle>
                        Lorem ipsum dolor sit
                    </v-card-subtitle>
                    <div class="polygon">
                        <p>
                        Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim.
                        </p>
                    </div>
                    <v-card-subtitle>
                        Lorem ipsum dolor sit
                    </v-card-subtitle>
                </v-card>
            </v-col>

        </v-row>
        </v-container>
    </div>
</template>
<script>
export default {
    data(){
        return{

        }
    }
}
</script>

<style >

.polygon{
 
position: relative;
  display: inline-block;
   height: 100%;
  width: 100%;
padding:  10px 20px;
 background: #d1d1d0;
  top: calc(100% - 1px);
 
  
  box-sizing: border-box;
    clip-path: polygon(0 0, 100% 0, 100% 75%, 15% 75%, 10% 100%, 10% 75%, 0 75%);
}

</style>