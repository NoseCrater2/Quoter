<template>
  <div id="imageBackground" :style="{'background-image': 'url(' + image + ')'}">
    <v-app id="inspire">
      <div>
        <v-app-bar dense flat color="#3ba2a9" dark>
          <v-toolbar-title>ROLLUX</v-toolbar-title>

          <v-spacer></v-spacer>

          <v-btn icon class="ma-1" rounded depressed dark>
            <v-badge color="red" content="3" overlap>
              <v-icon>mdi-cart-outline</v-icon>
            </v-badge>
          </v-btn>

          <v-btn icon class="ma-1" rounded depressed dark>
            <v-icon>mdi-account-circle</v-icon>
          </v-btn>
        </v-app-bar>
      </div>
      <v-card class="mx-auto my-auto" width="500" elevation="9" color="rgba(255,255,255,0.8)">
        <Quoter></Quoter>
      </v-card>
    </v-app>
  </div>
</template>

<script>
import Quoter from "../../components/Quoter";

export default {
  mounted() {},
  data() {
    return {
      image: "/storage/img/Madera.jpeg",
    };
  },
  components: {
    Quoter,
  },
};
</script>

<style scoped>
#inspire {
  background: rgba(0, 0, 0, 0);
}

#imageBackground {
  background-size: cover;
  -webkit-transition: background-image 0.2s ease-in-out;
  transition: background-image 0.2s ease-in-out;
}
</style>
