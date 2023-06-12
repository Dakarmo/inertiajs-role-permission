<template>
   
        <div v-if="status === 404">
            <div class="container">
                <div>
                    <div>
                        <h1>404</h1>
                        <h2>Vous êtes perdu... ?</h2>
                        <p>Ne vous inquiétez pas...<br/>
                            <strong>Nous pouvons tout de même vous aider à trouver une maison !</strong></p>
                        <a :href="route('find-a-home')" class="mt-4">Trouver une maison maintenant !</a>
                    </div>
                </div>
            </div>
        </div>
        <div v-else>
            <h1>noparse_b7f3919a99d4093361004e8fd25d5a1e</h1>
            <div>noparse_e976016c7fa0a88cf04d9d783cbd57e1</div>
        </div>
    
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
  status: Number,

});

console.log(status);

    computed( () => {
        title : ()=> {
            return {
                503: '503: Service Indisponible',
                500: '500: Erreur',
                403: '403: Accès refusé',
            }[this.status]
        };
        description : ()=> {
            return {
                503: "Désolé, nous sommes en train d'effectuer une maintenance. Revenez plus tard.",
                500: 'Oups, une erreur est survenue.',
                403: "Désolé, vous n'avez pas accès à cette page.",
            }[this.status]
        };
    })

</script>
