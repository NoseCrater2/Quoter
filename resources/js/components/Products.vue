<template>
  <div>
    <v-container fluid style="max-width: 1200px;" class="my-4">
      <v-row justify="space-between" >
        <v-col md="3" sm="12" :style="(isMobile && $vuetify.breakpoint.width > 779) ? 'background-color: white; position: sticky; top: 84px; z-index: 2;' : (isMobile && $vuetify.breakpoint.width < 780) ? 'background-color: white; position: sticky; top: 56px; z-index: 2;' : '' ">
            <!-- MENU INICIA -->
          <v-row :style="!isMobile ? 'position: sticky; top: 77px': ''">
            <v-col class="line" cols="12" md="12" sm="12" >
              <v-list dense flat subheader v-if="types.types && !isMobile">
                <v-subheader>PERSIANA</v-subheader>
                <v-list-item-group
                    v-model="type"
                    mandatory
                >
                  <v-list-item
                  dense
                  v-for="type in types.types"
                  :key="type.id"
                  :value="type.slug"
                  style="min-height: 20px;height:20px"
                  >
                    <template v-slot:default="{ active }">
                      <v-list-item-action>
                        <v-checkbox
                        dense
                        :input-value="active"
                        color="#47a5ad"
                        ></v-checkbox>
                      </v-list-item-action>
                      <v-list-item-content class="pa-0">
                        <v-list-item-title>{{ type.name }}</v-list-item-title>
                      </v-list-item-content>
                    </template>
                  </v-list-item>
                </v-list-item-group>
              </v-list>
              <v-menu offset-y v-if="types.types && isMobile">
                <template v-slot:activator="{attrs, on}">
                  <v-btn v-bind="attrs" v-on="on" text color="#47a5ad" block>
                    PERSIANA: {{selectedType }}
                    <v-icon right>mdi-chevron-down</v-icon>
                  </v-btn>
                </template>
                 <v-list  dense flat>
                <v-list-item-group
                mandatory
                v-model="type">
                  <v-list-item
                  :value="type.slug"
                  dense
                  v-for="type in types.types"
                  :key="type.id"
                  >
                    <template v-slot:default="{ active }">
                      <v-list-item-action>
                        <v-checkbox
                        dense
                        :input-value="active"
                        color="#47a5ad"
                        ></v-checkbox>
                      </v-list-item-action>
                      <v-list-item-content>
                        <v-list-item-title>{{ type.name }}</v-list-item-title>
                      </v-list-item-content>
                    </template>
                  </v-list-item>
                </v-list-item-group>
              </v-list>
              </v-menu>
              <v-divider></v-divider>

               <v-list dense flat subheader v-if="getType && !isMobile && selectedType != 'vertical'">
                <v-subheader>LÍNEA</v-subheader>
                <v-list-item-group
                mandatory
                v-model="line">
                  <v-list-item
                  :value="line.slug"
                  dense
                  v-for="line in getType.lines"
                  :key="line.id"
                  style="min-height: 20px;height:20px">
                    <template v-slot:default="{ active }">
                      <v-list-item-action>
                        <v-checkbox
                        dense
                        :input-value="active"
                        color="#47a5ad"
                        ></v-checkbox>
                      </v-list-item-action>
                      <v-list-item-content class="pa-0">
                        <v-list-item-title>{{ line.name }}</v-list-item-title>
                      </v-list-item-content>
                    </template>
                  </v-list-item>
                </v-list-item-group>
              </v-list>

              <v-menu offset-y v-if="getType && isMobile && selectedType != 'vertical'">
                <template v-slot:activator="{attrs, on}">
                  <v-btn v-bind="attrs" v-on="on" text color="#47a5ad" block>
                    LÍNEA: {{ selectedLine }}
                    <v-icon right>mdi-chevron-down</v-icon>
                  </v-btn>
                </template>
                 <v-list  dense flat>
                <v-list-item-group
                mandatory
                v-model="line">
                  <v-list-item
                  :value="line.slug"
                  dense
                  v-for="line in getType.lines"
                  :key="line.id"
                  >
                    <template v-slot:default="{ active }">
                      <v-list-item-action>
                        <v-checkbox
                        dense
                        :input-value="active"
                        color="#47a5ad"
                        ></v-checkbox>
                      </v-list-item-action>
                      <v-list-item-content>
                        <v-list-item-title>{{ line.name }}</v-list-item-title>
                      </v-list-item-content>
                    </template>
                  </v-list-item>
                </v-list-item-group>
              </v-list>
              </v-menu>

               <v-divider></v-divider>
              <v-list  dense flat subheader v-if="getType && !isMobile">
                <v-subheader>TEJIDO</v-subheader>
                <v-list-item-group
                mandatory
                v-model="weave">
                  <v-list-item
                  :value="weave.slug"
                  dense
                  v-for="weave in getType.weaves"
                  :key="weave.id"
                  style="min-height: 20px;height:20px">
                    <template v-slot:default="{ active }">
                      <v-list-item-action>
                        <v-checkbox
                        dense
                        :input-value="active"
                        color="#47a5ad"
                        ></v-checkbox>
                      </v-list-item-action>
                      <v-list-item-content class="pa-0" >
                        <v-list-item-title>{{ weave.name }}</v-list-item-title>
                      </v-list-item-content>
                    </template>
                  </v-list-item>
                </v-list-item-group>
              </v-list>
              <v-menu offset-y v-if="getType.weaves.length > 0 && isMobile" >
                <template v-slot:activator="{attrs, on}">
                  <v-btn
                  v-bind="attrs"
                  v-on="on"
                  text
                  color="#47a5ad"
                  block>
                    TEJIDO: {{ selectedWeave }}
                    <v-icon right>mdi-chevron-down</v-icon>
                  </v-btn>
                </template>
                 <v-list  dense flat>
                <v-list-item-group
                mandatory
                v-model="weave">
                  <v-list-item
                  :value="weave.slug"
                  dense
                  v-for="weave in getType.weaves"
                  :key="weave.id"
                  >
                    <template v-slot:default="{ active }">
                      <v-list-item-action>
                        <v-checkbox
                        dense
                        :input-value="active"
                        color="#47a5ad"
                        ></v-checkbox>
                      </v-list-item-action>
                      <v-list-item-content class="pa-0">
                        <v-list-item-title>{{ weave.name }}</v-list-item-title>
                      </v-list-item-content>
                    </template>
                  </v-list-item>
                </v-list-item-group>
              </v-list>
              </v-menu>
              <v-divider></v-divider>
            </v-col>
          </v-row>
        <!-- MENU TERMINA -->

        </v-col>
        <v-col cols="12" md="9" sm="12" >
          <v-row v-if="selectedLine && selectedType">
            <v-col cols="12">
              <h1 v-if="selectedWeave != 'pvc-vertical'">
                  <span v-if="selectedType != 'vertical'">{{ selectedLine.toUpperCase()+' - '+ selectedType.toUpperCase()}}</span>
                  <span v-else-if="selectedType == 'vertical'">{{selectedWeave.toUpperCase().split('-').join(" ")}}</span>
              </h1>
              <h1 v-else-if="selectedWeave == 'pvc-vertical'">{{selectedWeave.toUpperCase().split('-').join(" ")}}</h1>
              <div >
                  <Descriptions :nameLine="selectedLine"/>
              </div>

              <v-divider></v-divider>
            </v-col>
            <v-col cols="12"  >
                  <v-data-iterator
                  v-if="products"
                  :items="products"
                  :items-per-page="itemsPerPage"
                  :page="parseInt(page)"
                  :search="search"
                  :sort-by="sortBy"
                  :sort-desc="sortDesc"
                  hide-default-footer
                  no-data-text="No hay modelos disponibles">
                    <template v-slot:header>
                      <v-row class="mt-2" justify="space-between">
                       <v-spacer></v-spacer>
                        <span class="mr-4 grey--text"> Página {{page}} de {{numberOfPages}}</span>
                        <v-btn fab dark depressed color="white" class="mr-1" @click="formerPage()">
                          <v-icon color="black">mdi-chevron-left</v-icon>
                        </v-btn>
                        <v-btn depressed fab dark color="white" class="mr-1" @click="nextPage()">
                          <v-icon color="black">mdi-chevron-right</v-icon>
                        </v-btn>
                        <v-spacer></v-spacer>
                        <v-toolbar flat class="mb-1">
                          <template>
                            <v-select
                            solo-inverted
                            color="black"
                            v-model="sortBy"
                            flat
                            hide-details
                            :items="keys"
                            item-value="attribute"
                            item-text="name"
                            label="Filtrar por"
                            style="width: 40px"
                            class="mr-2"
                            ></v-select>

                            <v-select
                            class="ml-2"
                            solo-inverted
                            color="black"
                            v-model="sortDesc"
                            flat
                            hide-details
                            :items="orderKeys"
                            item-value="attribute"
                            item-text="name"
                            label="Ordenar"
                            style="width: 60px"
                            ></v-select>
                          </template>
                        </v-toolbar>
                      </v-row>
                    </template>
                    <template v-slot:default="props" >
                      <v-row >
                        <v-col
                        style="justify-content: center; display: flex;"
                        v-for="item in props.items"
                        :key="item.name"
                        cols="12"
                        sm="6"
                        md="4">

                          <v-hover v-slot="{ hover }" v-if="item">
                            <v-card width="240"  color="grey lighten-4" flat :to="{name: 'Details', params: {slugWeave:item.weave != null ? item.weave.slug : null, slugDetail: item.slug}}">
                              <v-img class="tag" width="85"  v-if="item.rotate == 1" src="/img/modelos/rotable.png"></v-img>
                              <v-img
                              class="white--text align-end"
                              :class="{'escalada':hover}"
                              width="240" height="270"
                              :aspect-ratio="16/9"
                              :src="`/img/modelos/medium/${item.type.slug}/${item.line.slug}/${item.image}.jpg`"
                              :gradient="hover?'rgba(71, 165, 173, 0.7) 100%, transparent 72px':''"  >
                                <template v-slot:placeholder>
                                  <v-img src="/img/modelos/medium-unavailable.jpg"></v-img>
                                </template>
                                <!-- <v-slide-y-reverse-transition>

                                </v-slide-y-reverse-transition> -->
                                <v-slide-x-transition>
                                  <div
                                  v-if="hover"
                                  class="d-flex transition-fast-in-fast-out  v-card--reveal white--text "
                                  style="height: 100%;">
                                    <v-hover v-slot="{ hover }">
                                      <v-btn :to="{name: 'Details', params: {slugWeave:item.weave != null ? item.weave.slug : null, slugDetail: item.slug}}" depressed :outlined="!hover" tile color="white"  small>Detalles del producto</v-btn>
                                    </v-hover>
                                  </div>
                                </v-slide-x-transition>
                                <v-expand-transition>
                                  <div
                                  v-if="hover"
                                  class="d-flex transition-fast-in-fast-out  v-card--reveal white--text"
                                  style="height: 20%;">
                                    <v-hover v-slot="{ hover }">
                                      <v-btn @click="openDialog(item.id)" depressed :outlined="!hover" tile color="white"  small><v-icon>mdi-arrow-expand</v-icon></v-btn>
                                    </v-hover>
                                  </div>
                                </v-expand-transition>
                              </v-img>
                                <v-card-title class="title d-flex justify-center white--text ">
                                    <b class="text-center" style="font-size: 12px; line-height: 20px;" >
                                      {{ item.name}}
                                    </b>
                                  </v-card-title>
                              <v-card-text
                              v-if="item.type != 'horizontal-madera-2'"
                              style="position: relative">
                                <!-- <h2 v-if="user != null" class="text-center">
                                  <div class="d-block font-weight-light ">
                                    $<div class="d-inline text-decoration-line-through">{{ maskPrice(item.price)[0] }}</div>
                                    <div class="d-inline cents" >{{ maskPrice(item.price)[1] }}</div>
                                   MXN
                                  </div>
                                  <div class="d-block red--text" >
                                    $<div class="d-inline">
                                      {{ maskPrice(item.price - ((user.discount_percent / 100) * item.price))[0] }}
                                    </div>
                                    <div class="d-inline cents">
                                      {{ maskPrice(item.price - ((user.discount_percent / 100) * item.price))[1] }}
                                    </div> MXN
                                  </div>
                                </h2> -->
                                <h2 class="font-weight-light black--text text-center">
                                  $<div class="d-inline">{{ maskPrice(item.price)[0] }}</div>
                                  <div class="d-inline cents">{{ maskPrice(item.price)[1] }}</div>
                                  MXN
                                </h2>
                              </v-card-text>
                              <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn
                                v-if="item.product != 'TOLDOS'"
                                color="#47a5ad"
                                class="white--text"
                                small
                                :to="{name:'Quoter', query:{type: item.type.slug, line: item.weave != null ? item.weave.slug : null, manufacturer: item.line.slug,variant: item.id}}"
                                >
                                  COTIZAR
                                </v-btn>
                                <v-spacer></v-spacer>
                              </v-card-actions>
                            </v-card>
                          </v-hover>
                        </v-col>
                      </v-row>
                      <v-divider></v-divider>
                    </template>
                    <template v-slot:footer="pagination">
                      <div style="display: none">
                          {{pagination.options.page = page }}
                      </div>
                      <v-row
                      class="mt-2"
                      align="center"
                      justify="center">
                        <v-spacer></v-spacer>
                        <span class="mr-4 grey--text"> Página {{page}} de {{numberOfPages}}</span>
                        <v-btn
                        fab
                        dark
                        depressed
                        color="white"
                        class="mr-1"
                        @click="formerPage()">
                          <v-icon color="black">mdi-chevron-left</v-icon>
                        </v-btn>
                        <v-btn
                        depressed
                        fab
                        dark
                        color="white"
                        class="mr-1"
                        @click="nextPage()">
                          <v-icon color="black">mdi-chevron-right</v-icon>
                        </v-btn>
                        <v-spacer></v-spacer>
                      </v-row>
                    </template>
                  </v-data-iterator>
                  <!-- <v-btn fab small bottom absolute color="#BDBDBD">
                    <v-icon>mdi-arrow-down</v-icon>
                  </v-btn> -->
                </v-col>
              </v-row>
            </v-col>
          </v-row>
          <v-dialog
          v-if="getSelectedProduct"
          v-model="dialog"
          width="700px" >
            <v-card width="700px" height="500px">
              <v-row justify="space-around">
                <v-col cols="12" md="6"  sm="12">
                  <v-img :width="350" :height="475" :src="`/img/modelos/full/${getSelectedProduct.type.slug}/${getSelectedProduct.line.slug}/${getSelectedProduct.image}.jpg`" >
                    <template v-slot:placeholder>
                      <v-img src="/img/modelos/medium-unavailable.jpg"></v-img>
                    </template>
                  </v-img>
                </v-col>
                <v-col cols="12" md="6"  sm="12">
                  <v-card-title>
                    <v-spacer></v-spacer>
                    <v-tooltip top>
                      <template v-slot:activator="{ on, attrs }">
                         <v-btn icon v-bind="attrs" v-on="on" @click="dialog = false">
                           <v-icon>mdi-close-thick</v-icon>
                          </v-btn>
                      </template>
                      <span>Cerrar</span>
                    </v-tooltip>
                  </v-card-title>
                  <v-card-subtitle class="display-1" >
                    <p style="color: #000"> {{ getSelectedProduct.name }}</p>
                  </v-card-subtitle>
                  <v-card-subtitle class="display-2" >
                    <p style="color: #47a5ad">$ {{ getSelectedProduct.price }}</p>
                  </v-card-subtitle>
                  <v-card-text>
                  <v-list-item v-if="true" >
                     <v-list-item-icon><v-icon color="#47a5ad">mdi-clipboard-check</v-icon></v-list-item-icon>
                     <v-list-item-title style="color: #47a5ad" >En Stock</v-list-item-title>
                  </v-list-item>
                  <v-list-item v-else >
                    <v-list-item-icon><v-icon color="red">mdi-cancel</v-icon></v-list-item-icon>
                    <v-list-item-title style="color: red">Fuera de stock</v-list-item-title>
                  </v-list-item>
                </v-card-text>
              </v-col>
            </v-row>
          </v-card>
        </v-dialog>
      </v-container>
  </div>
</template>

<script>
import { mapState } from 'vuex'
import Descriptions from './Descriptions.vue';
export default {
  data(){
    return{
      modelMenuVerticalBlind: '',
      selectedWeave: this.slugWeave,
      selectedLine: this.slugLine,
      selectedType: this.slugType,
      productName: null,
      selectedIndex: 1,
      isMobile:false,
      dialog: false,
      model: null,
      search: '',
      filter: {},
      sortDesc: false,
      page: this.$route.query.page || 1,
      itemsPerPage: 18,
      sortBy: 'price',
      keys: [
        {name: 'Nombre', attribute: 'name'},
        {name: 'Precio', attribute: 'price'},
        {name: 'Rotable', attribute: 'rotate'}
      ],
      orderKeys: [
        {name: 'Ascendente', attribute: false},
        {name: 'Descendente', attribute: true}
      ],
      chargeBlinds : true,
    }
  },

  created(){
    document.title = 'Catálogo de '+this.slugProduct
  },

  mounted(){
    this.onResize()
    window.addEventListener('resize', this.onResize, { passive: true })
  },

  props:{
    slugLine: {
      type: String,
      required: false,
    },
     slugType: {
      type: String,
      required: true,
    },
    slugProduct: {
      type: String,
      required: true,
    },
    slugWeave:{
      type: String,
      required: false,
    }
  },

  computed:{
    ...mapState({
      user: state => state.user,
    }),

    line: {
	    get: function() {
        return this.slugLine
      },
	    set: function(newValue) {
        this.page = 1;
        this.$router.push({query: {...this.$route.query, page: this.page}, params: {slugLine: newValue}})
        this.selectedLine = newValue
	    }
	  },
    weave: {
	    get: function() {
        return this.slugWeave
      },
	    set: function(newValue) {
            this.page = 1;
            this.$router.push({query: {...this.$route.query, page: this.page}, params: {slugWeave: newValue}})
        this.selectedWeave = newValue
	    }
	  },

    products(){
        if(this.getType.weaves.length > 0){
            if(this.selectedType == 'vertical'){
                return this.$store.state.productsModule.variants.filter((variant) => variant.type.slug === this.selectedType && variant.weave.slug === this.selectedWeave)
            }
            return this.$store.state.productsModule.variants.filter((variant) => variant.type.slug === this.selectedType && variant.line.slug === this.selectedLine && variant.weave.slug === this.selectedWeave)
        }
        else{
            return this.$store.state.productsModule.variants.filter((variant) => variant.type.slug === this.selectedType && variant.line.slug === this.selectedLine)

        }
    },

    numberOfPages(){
      return Math.ceil(this.products.length / this.itemsPerPage)
    },

    type: {
      get: function () {
         return this.slugType
      },
      set: function(newValue) {
          this.page = 1;
          this.$router.push({query: {...this.$route.query, page: this.page}, params: {slugType: newValue}})
        this.selectedType = newValue
	    }
    },

    types(){
      return  this.$store.getters.getTypes(this.slugProduct)
    },

    getProduct(){
      return this.$store.state.productsModule.lines.find((line) => line.slug === this.slugLine) || null
    },

    getSelectedProduct(){
      return  this.$store.state.productsModule.variants.find((variant => variant.id === this.selectedIndex)) || 0
    },

    getType(){
      let returned = this.$store.getters.getTypes(this.slugProduct).types.find(type => type.slug === this.selectedType)
    //   let findedVertical = false;
    //   returned.weaves.forEach(element => {
    //       if(element.name == 'PVC VERTICAL'){
    //           findedVertical = true;
    //       }
    //   });
    //   if(findedVertical){
    //     let returnedShifted = returned.weaves.shift();
    //     return returned;
    //   }
      return returned
    },
},

  methods: {
    changeRouteVertical(){
        if(this.modelMenuVerticalBlind == 'TELA VERTICAL'){

        }
        else if(this.modelMenuVerticalBlind == 'PVC VERTICAL'){
            this.$router.push({query: {...this.$route.query, page: this.page}, params: {slugWeave: 'pvc-vertical'}})
        }
    },
    nextPage(){
      this.page = parseInt(this.page)
        if(this.page + 1 <= this.numberOfPages){
          this.page += 1
          this.$router.push({query: {...this.$route.query, page: this.page}})
        }
      },
    formerPage(){
      this.page = parseInt(this.page)
      if(this.page - 1 >= 1){
        this.page -= 1
        this.$router.push({query: {...this.$route.query, page: this.page}})
      }
    },

    updateItemsPerPage(number){
      this.itemsPerPage = number
    },

    onResize(){
      this.isMobile = window.innerWidth < 958
    },

    openDialog(id){
      this.dialog = true
      this.selectedIndex = id;
    },
    maskPrice(price){
        return parseFloat(price).toFixed(2).toString().split('.')
      },
    },
    components:{
      Descriptions,
    },
}
</script>


<style>
.hide-scroll::-webkit-scrollbar {
  display: none;
}

/* Hide scrollbar for IE, Edge and Firefox */
.hide-scroll {
  -ms-overflow-style: none;  /* IE and Edge */
  scrollbar-width: none;  /* Firefox */
}

.cents{
  position: relative;
  bottom: 0.4em;
  font-size: 0.7em;
  right: 0.4em;
}
.line > .v-list-group:first-child >.v-list-group__header{
background-color: #47a5ad;
color: white;
font-weight: bolder;
}

.line > .v-list-group:last-child >.v-list-group__header{
background-color: #867d7e;
color: white;
font-weight: bolder;
}


.v-card--reveal {
align-items: center;
bottom: 0;
justify-content: center;
position: absolute;
width: 100%;

}
.tag{
    z-index: 1;
    position: absolute;
    margin-top: -8px;
    right: 30%;
}

.title{
  background-color: #47a5ad;
  padding: 5px;
  word-break: break-word !important;
  line-height: 12px;
  font-size: 12px !important;
}

.escalada{
   transform: scale(1.02);
    -moz-transform: scale(1.02);
    -webkit-transform: scale(1.02);
    -o-transform: scale(1.02);
    -ms-transform: scale(1.02);
    transition-duration: 0.5s;
}

</style>
