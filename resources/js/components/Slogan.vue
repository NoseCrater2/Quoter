<template>
    <div >
       <v-row  class="ma-0" >
            <v-col cols="12" align-self="center" class="text-center">

                      <div class="d-inline-flex">
                         <h1>ROLLUX</h1>
                    </div>
                   <div class="d-inline-flex" style="color: #47a5ad;">
                         <h1>MÉXICO</h1>
                    </div>
                     <div class="d-flex justify-center">
                  <hr align="center" noshade="noshade" class="divider" style="height: 5px" size="3" width="20%" />
                  </div>
            </v-col>

           
             <v-col cols="12"  class="text-center ">
               
                 <div class="d-block">
                     <div class="d-inline-flex">
                         <h1>''Para nosotros,</h1>
                          <h1 style="color: #47a5ad;">&nbsp;las persianas&nbsp;</h1>
                          <h1>no son solo </h1>
                    </div>
                </div>

                <div class="d-block">
                    <div class="d-inline-flex ">
                        <h1> un elemento decorativo en tu ventana,</h1>
                    </div>
                </div>
                <div class="d-block">
                    <div class="d-inline-flex" >
                         <h1 style="color: #47a5ad;">las persianas&nbsp;</h1>
                          <h1>de <b class="especial">Rollux</b> </h1>
                    </div>
                </div>
                    <div class="d-inline-flex" style="color: #47a5ad;">
                        <h1>crean &nbsp;</h1>
                        <p class="word"><span id="word-container" class="especial"></span></p>
                    </div>
                    <div class="d-inline-flex">
                         <h1>...''</h1>
                    </div>
                    
                </v-col>
        </v-row>
    </div>
</template>

<script>

const wordContainer = document.getElementById("word-container");

const myWords = 'Ambientes Emociones Sensaciones'.split(" ");

const typeWord = (element, word) => {
    const letters = word.split("");

    letters.forEach((letter, index) => {
        setTimeout(()=> (element.innerHTML += letter), 80 * index);
    });
    
    
};

const typingLoop = (words, element, index) => {
  let nextIndex = index + 1;
  if (nextIndex >= words.length) nextIndex = 0;

  element.innerText = "";
  setTimeout(() => typeWord(element, words[index]), 500);

  let delay = Math.sqrt(words[index].length) * 1000;
  if (delay < 800) delay = 800;

  setTimeout(() => typingLoop(words, element, nextIndex), delay);
};
export default {
    data(){
        return{

        }
    },

    mounted(){
          typingLoop(myWords, document.getElementById("word-container"), 0);
    }
}
</script>

<style scoped>
.divider{
    border: none;
    height: 5px;
    background-color: #47a5ad;
}

.especial{
    font-style: italic;
}

.word{
    font-size: 32px;
}

.word::after{
font-size: 32px;
content: "|";
opacity: 1;

margin-left: 2.5px;
display: inline-block;
animation: blink 0.7s infinite;
}

@media only screen and (max-width: 778px) {
  h1 {
    font-size:16px;
  }
  .word {
    font-size:16px;
  }

  .word::after{
    font-size: 16px;
    }
}


</style>