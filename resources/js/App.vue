<template>
<div id="app">
  <v-app id="inspire">
    <v-content>
      <v-container>
        <v-row>
          <v-col class="d-flex justify-center">
            <h1>Laravel + Vuetify</h1>
          </v-col>
        </v-row>
        <v-row>
          <v-col>
            <v-card>
              <v-card-text>
                <v-text-field label="Foo"></v-text-field>
                <v-btn>Bar</v-btn>
              </v-card-text>
            </v-card>
            <div class="sass">
                styled from sfc style block with SASS
            </div>
            <div class="scss">
                styled from sfc style block with SCSS
            </div>
          </v-col>
        </v-row>
      </v-container>
    </v-content>
  </v-app>
  </div>
</template>

<script>
export default {
}
</script>

