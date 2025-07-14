<template>
  <div id="app">
    <Header />
    <Search />
    <Empty @open-create="isCreateOpen = true" />
    <Button @open-create="isCreateOpen = true" />

    <!-- Modale création -->
    <Create 
      :visible="isCreateOpen" 
      @close="isCreateOpen = false" 
      @submit="handleSubmit" 
    />
  </div>
</template>

<script setup>
import { ref } from 'vue';

import Header from './components/Header.vue';
import Search from './components/Search.vue';
import Empty from './components/Empty.vue';
import Button from './components/Button.vue';
import Create from './components/Create.vue';

const isCreateOpen = ref(false);

function handleSubmit(newRecipe) {
  console.log('Nouvelle recette reçue:', newRecipe);
  // Ici, tu peux envoyer newRecipe à ton backend avec axios ou autre
  isCreateOpen.value = false; // Ferme la modale après soumission
}
</script>