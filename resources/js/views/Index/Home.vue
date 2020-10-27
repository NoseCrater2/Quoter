<template>
  <div
    id="imageBackground"
    :style="{ 'background-image': 'url(' + image + ')' }"
  >
    <v-app id="inspire">
      <div>
        <v-app-bar
          flat
          color="#3ba2a9"
          dark
          style="position: fixed; top: 0; z-index: 1"
        >
          <v-toolbar-title>ROLLUX</v-toolbar-title>

          <v-spacer></v-spacer>

          <v-btn icon large class="ma-2" rounded depressed dark>
            <v-badge color="red" content="3" overlap>
              <v-icon>mdi-cart-outline</v-icon>
            </v-badge>
          </v-btn>

          <v-btn icon large rounded depressed dark>
            <v-icon>mdi-account-circle</v-icon>
          </v-btn>
        </v-app-bar>
      </div>
      <v-card
        class="mx-auto my-auto"
        width="500"
        elevation="9"
        color="rgba(255,255,255,0.8)"
        :style="classReceiveSteps"
      >
        <Quoter @modifyClassReceiveSteps="modifyClassReceiveSteps"></Quoter>
      </v-card>
      <div
        class="d-flex flex justify-center"
        v-if="classReceiveSteps != null"
        id="scrollito"
        :style="classAddingStepsSection"
      >
        <BlindSteps></BlindSteps>
      </div>
    </v-app>
  </div>
</template>

<script>
import Quoter from "../../components/Quoter";
import BlindSteps from "../Index/BlindSteps";
//    /(^(0{0,1}|([1-9][0-9]*))((\.)([0-9]{1,3}))?$)/g
export default {
  updated() {
    this.scrollToSteps();
  },
  mounted() {},
  data() {
    return {
      image: "/storage/img/Madera.jpeg",
      classReceiveSteps: null,
      classAddingStepsSection:
        "position: absolute; margin-left: auto; margin-right: auto; left: 0; right: 0; top: 100%; background-color: white;",
      //r = top: 27%
    };
  },
  methods: {
    modifyClassReceiveSteps(style) {
      this.classReceiveSteps = style;
      this.scrollToSteps();
      //this.changeStyle2()
    },
    scrollToSteps() {
      window.scrollTo({ top: 593, behavior: "smooth" });
    },
  },
  components: {
    Quoter,
    BlindSteps,
  },
};
</script>

<style scoped>
#inspire {
  background: rgba(0, 0, 0, 0);
}

#imageBackground {
  -webkit-transition: background-image 0.2s ease-in-out;
  transition: background-image 0.2s ease-in-out;
  background-attachment: fixed;
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
}

html {
  scroll-behavior: smooth;
}
</style>
