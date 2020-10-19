<template>
  <div>
    <v-col>
      <v-card-text>
        <p class="text-center">PASO 1</p>
        <p class="display-1 text--primary text-center mt-n4">
          Seleccione su producto
        </p>
      </v-card-text>
      <v-autocomplete
        :items="items"
        v-model="computedItems"
        class="mt-n5"
        label="Selecciona tu persiana"
        outlined
        color="black"
        background-color="white"
        :menu-props="{ bottom: true, offsetY: true }"
      ></v-autocomplete>
      <v-btn
        block
        class="mb-1 mt-n2"
        dark
        @click="itemSelected != null ? modifyClassReceiveSteps() : ''"
        >Configurar</v-btn
      >
    </v-col>
  </div>
</template>

<script>
export default {
  name: "Quoter",
  data() {
    return {
      items: [
        "Persiana enrollable",
        "Persiana sheer",
        "Persiana panel japones",
        "Persiana romana",
        "Persiana romantic",
        "Persiana triple shade / shangri La",
        "Persiana flexballet",
        "Persiana horizontal de aluminio 1”",
        "Persiana horizontal de aluminio 2”",
        "Persiana horizontal de madera 2”",
        "Persiana celular",
        "Persiana vertical"
      ],
      itemSelected: null,
    };
  },
  methods: {
    modifyClassReceiveSteps() {
      this.$emit("modifyClassReceiveSteps", "");
    },
  },

  computed: {
    computedItems: {
      get() {
        return this.items;
      },
      set(model) {
        //this.image = `'/storage/img/${model}.jpg'`;
        this.itemSelected = model;
        return this.items;
      },
    },
  },
};
</script>