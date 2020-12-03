<template>
    <div>
      
    </div>
</template>

<script>
export default {
    data(){
        return{
            showProducts: true,
        }
    },

    computed:{
        drawer(){
            return this.draw   
        }
    },

    props:{
        products:{
            type: Array,
            required: true,
        },

        draw: {
            type: Boolean,
            required: true,
        }
    }
}
</script>
