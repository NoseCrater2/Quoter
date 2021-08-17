<template>
  <div id="app">
    <router-view></router-view>
  </div>
</template>
<script>
export default {
    //insert the following code for vue-meta to work
    metaInfo() {
        return {
            title: 'Rollux México',
            meta: [
                // { name: 'description', content: 'Connect and follow ' + this.userData.name + ' on Epiloge - ' + this.userData.tagline},
                // { property: 'og:title', content: this.userData.name + ' - Epiloge'},
                // { property: 'og:site_name', content: 'Epiloge'},
                { property: 'og:description', content: 'Rollux integra en su línea de textiles para persianas Enrollables la mas amplia gama de texturas y colores de todo Mercado Nacional para el recubrimiento de ventanas, suficiente para cubrir cualquier necesidad, requerimiento y gusto'},
                // { property: 'og:type', content: 'profile'},
                // { property: 'og:url', content: 'https://epiloge.com/@' + this.userData.username},
                // { property: 'og:image', content: this.aws_url + '/users/' + this.userData.profileurl + '-main.jpg' }
            ]
        }
    },
}
</script>
