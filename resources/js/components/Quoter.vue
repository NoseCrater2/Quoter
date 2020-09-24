<template>
  <div>
    <v-col>
      <v-card-text>
        <p class="display-1 text--primary text-center">Elige tu persiana</p>
      </v-card-text>
      <v-select
        :items="items"
        v-model="computedItems"
        class="mt-n5"
        label="Selecciona tu persiana"
        outlined
        color="black"
        background-color="white"
        :menu-props="{ bottom: true, offsetY: true }"
      ></v-select>
      <v-btn block class="mb-1 mt-n2" dark>Configurar</v-btn>
    </v-col>
  </div>
</template>

<script>
export default {
  name: "Quoter",
  data() {
    return {
      items: ["Madera", "Plastico", "Romantica"],
    };
  },
  computed: {
    computedItems: {
      get() {
        return this.items;
      },
      set(model) {
        //this.image = `'/storage/img/${model}.jpg'`;
        return this.items;
      },
    },
  },
};
</script>