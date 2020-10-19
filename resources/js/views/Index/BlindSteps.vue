<template>
  <div>
    <v-card class="mx-auto my-auto" width="1000" elevation="0" tile>
      <v-col>
        <div class="d-flex align-center mb-3">
          <div class="ml-auto">
            <v-btn fab large depressed dark>
              <v-icon>mdi-plus</v-icon>
            </v-btn>
            <v-btn fab large depressed dark>
              <v-icon>mdi-calculator</v-icon>
            </v-btn>
          </div>
        </div>

        <v-card>
          <v-toolbar flat color="grey" dark>
            <v-icon class="mr-1">mdi-blinds</v-icon>
            <v-toolbar-title>Persiana 1</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-btn icon fab depressed dark>
              <v-icon>mdi-pen</v-icon>
            </v-btn>
            <v-btn icon fab depressed dark class="mr-1 ml-3">
              <v-icon>mdi-trash-can</v-icon>
            </v-btn>
          </v-toolbar>
          <v-card-text>
            <div class="my-3">
              <span class="display-1 text--primary"
                >PASO 2 Seleccione características</span
              >
            </div>
            <v-row>
              <v-col cols="12" md="6" sm="12" xs="8">
                <v-select
                  outlined
                  color="black"
                  background-color="white"
                  label="Linea"
                  :menu-props="{ bottom: true, offsetY: true }"
                ></v-select>
              </v-col>
              <v-col cols="12" md="6" sm="12" xs="8">
                <v-select
                  outlined
                  color="black"
                  background-color="white"
                  label="Modelo"
                  :menu-props="{ bottom: true, offsetY: true }"
                ></v-select>
              </v-col>
            </v-row>
            <v-row class="mb-6">
              <v-col cols="12" md="6" sm="12" xs="8">
                <v-select
                  outlined
                  color="black"
                  background-color="white"
                  label="Color"
                  :menu-props="{ bottom: true, offsetY: true }"
                ></v-select>
              </v-col>
              <v-col cols="12" md="6" sm="12" xs="8">
                <v-img
                  lazy-src="/storage/img/persiana.jpg"
                  height="auto"
                  width="auto"
                  src="/storage/img/persiana.jpg"
                ></v-img>
              </v-col>
            </v-row>
            <div class="mt-n2 mb-2">
              <span class="display-1 text--primary"
                >PASO 3 Ingrese las medidas requeridas</span
              >
            </div>
            <span class="text-body-1 text--primary"
              >Las medidas deben estar dadas en metros (m)</span
            >
            <br />
            <br />
            <v-row>
              <v-col cols="6" md="6" sm="6" xs="6">
                <v-tooltip
                  bottom
                  nudge-bottom="-37"
                  :open-on-hover="false"
                  :open-on-click="false"
                  :open-on-focus="false"
                  v-model="appearToolTipInvalidMeasures"
                >
                  <template v-slot:activator="{ on }">
                    <v-text-field
                      type="tel"
                      label="Ancho"
                      v-on="on"
                      placeholder=".6 a 3.5"
                      outlined
                      v-model="persWidth"
                      @keyup="validateMeasuresRegex(this, 0.5, 2.4)"
                    ></v-text-field>
                  </template>
                  <span>Ancho fuera de rango</span>
                </v-tooltip>
              </v-col>
              <v-col cols="6" md="6" sm="6" xs="6">
                <v-tooltip bottom nudge-bottom="-37" :open-on-focus="true">
                  <template v-slot:activator="{ on, attrs }">
                    <v-text-field
                      type="tel"
                      label="Alto"
                      v-bind="attrs"
                      v-on="on"
                      placeholder=".6 a 3"
                      outlined
                    ></v-text-field>
                  </template>
                  <span>Alto fuera de rango</span>
                </v-tooltip>
              </v-col>
            </v-row>
            <div class="mt-n2">
              <span class="display-1 text--primary"
                >PASO 4 Seleccione su accionamiento</span
              >
            </div>
            <v-radio-group :mandatory="false">
              <v-radio label="Manual" value="radio-1"></v-radio>
              <v-radio label="Motorizado" value="radio-2"></v-radio>
            </v-radio-group>
            <v-radio-group :mandatory="false">
              <v-radio label="Izquierda" value="radio-3"></v-radio>
              <v-radio label="Derecha" value="radio-4"></v-radio>
            </v-radio-group>
            <br />
            <div class="mt-n2">
              <span class="display-1 text--primary"
                >PASO 5 Seleccione agrupamiento</span
              >
            </div>
            <div class="d-flex justify-center mt-5">
              <v-img
                lazy-src="/storage/img/agrupamientos.jpg"
                height="auto"
                width="auto"
                src="/storage/img/agrupamientos.jpg"
              ></v-img>
            </div>
            <br />
            <br />
            <div class="mt-n2">
              <span class="display-1 text--primary">PASO 6 Galeria</span>
            </div>
            <v-radio-group :mandatory="false">
              <v-radio label="Galeria portatela" value="radio-1"></v-radio>
              <v-radio
                label="Galeria PVC con cubrepolvo"
                value="radio-2"
              ></v-radio>
            </v-radio-group>
            <br />
            <div class="mt-n2 mb-3">
              <span class="display-1 text--primary"
                >PASO 7 Sistema de motorización</span
              >
            </div>
            <v-row>
              <v-col cols="12" md="6" sm="12" xs="8">
                <v-select
                  outlined
                  color="black"
                  background-color="white"
                  label="Sistema"
                  :menu-props="{ bottom: true, offsetY: true }"
                ></v-select>
              </v-col>
              <v-col cols="12" md="6" sm="12" xs="8">
                <v-select
                  outlined
                  color="black"
                  background-color="white"
                  label="Opciones"
                  :menu-props="{ bottom: true, offsetY: true }"
                ></v-select>
              </v-col>
            </v-row>
            <br />
            <!-- <v-sheet color="grey" class="mx-n4 mb-8">
                  <div class="ml-4 d-flex align-center">
                    <span class="text-h5 mt-5 white--text">Marco</span>
                  </div>
                  <v-radio-group class="ml-4" row dark>
                    <v-radio
                      label="Fuera"
                      value="radio-1"
                      class="mr-16"
                    ></v-radio>
                    <v-radio label="Dentro" value="radio-2"></v-radio>
                  </v-radio-group>
                </v-sheet> -->
            <!-- <v-col cols="12" md="6" sm="12" xs="8">
                      <v-img
                        src="https://picsum.photos/510/300?random"
                        max-height="330"
                        min-height="330"
                        max-width="auto"
                        min-width="auto"
                        class="mt-3"
                      ></v-img>
                    </v-col> -->
            <br />
            <br />
            <span class="text-h5 text--primary">Zona</span>
            <br />
            <v-textarea
              class="mt-4"
              name="input-7-1"
              filled
              outlined
              auto-grow
            ></v-textarea>
            <v-btn block color="secondary" dark>Terminar esta persiana</v-btn>
          </v-card-text>
        </v-card>
      </v-col>
    </v-card>
  </div>
</template>

<script>
export default {
  name: "BlindSteps",
  data() {
    return {
      persWidth: "",
      appearToolTipInvalidMeasures: false,
    };
  },
  methods: {
    validateMeasuresRegex(e, floMin, floMax) {
      let validateNumRangesRegex = new RegExp(
        "^(\\.|[0-9]{1,2}|\\.[0-9]+|[0-9]?\\.([0-9]+)?)$"
      );

      let localPersWidthString = this.persWidth;

      if (!validateNumRangesRegex.test(localPersWidthString)) {
        this.persWidth = "";
        this.appearToolTipInvalidMeasures = true;
        //$(obj).popover("show");
        //return;
      }

      let floatPersWidth = parseFloat(localPersWidthString);
      let intMin = Math.floor(floMin);
      let intMax = Math.floor(floMax);

      if (localPersWidthString.length == 1) {
        if (floatPersWidth < intMin || floatPersWidth > intMax) {
          this.persWidth = "";
          this.appearToolTipInvalidMeasures = true;
          //$(obj).popover("show");
        } else {
          this.appearToolTipInvalidMeasures = false;
          console.log(""); //$(obj).popover("hide");
        }
      } else if (
        localPersWidthString.length == 2 &&
        localPersWidthString.charAt(0) == "."
      ) {
        var strFloMin = floMin + "",
          floSub = parseFloat(strFloMin.substring(1, 3));

        if (floatPersWidth < floSub) {
          this.persWidth = "";
          this.appearToolTipInvalidMeasures = true;
          //$(obj).popover("show");
        }
      } else if (floatPersWidth < floMin || floatPersWidth > floMax) {
        this.persWidth = "";
        this.appearToolTipInvalidMeasures = true;
        //$(obj).popover("show");
      } else {
        console.log("");
        this.appearToolTipInvalidMeasures = false;
      } //$(obj).popover("hide");
    },
  },
};
</script>