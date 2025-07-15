<template>
  <div id="app">
    <Header />
    <Search />

    <!-- Si aucune recette, afficher un message vide -->
    <Empty v-if="recipes.length === 0" @open-create="openCreateModal" />

    <!-- Sinon afficher la grille de recettes -->
    <Recipe
      v-else
      :recipes="recipes"
      @edit="openEditModal"
      @delete="handleDelete"
    />

    <!-- Bouton flottant en bas à droite -->
    <Button @open-create="openCreateModal" />

    <!-- Modal de création -->
    <Create  
      :visible="isCreateOpen"
      @close="closeCreateModal"
      @create="handleCreate"
    />

    <!-- Modal de modification -->
    <Edit
      :visible="isEditOpen"
      :recipe="selectedRecipe"
      @close="closeEditModal"
      @update="handleUpdate"
    />
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

import Header from './components/Header.vue'
import Search from './components/Search.vue'
import Empty from './components/Empty.vue'
import Button from './components/Button.vue'
import Recipe from './components/Recipe.vue'
import Create from './components/Create.vue'
import Edit from './components/Edit.vue'  // Nouveau modal edit

const isCreateOpen = ref(false)
const isEditOpen = ref(false)
const selectedRecipe = ref(null)
const recipes = ref([])

// Ouvrir modal création
function openCreateModal() {
  selectedRecipe.value = null
  isCreateOpen.value = true
}

// Fermer modal création
function closeCreateModal() {
  isCreateOpen.value = false
}

// Ouvrir modal édition
function openEditModal(recipe) {
  selectedRecipe.value = recipe
  isEditOpen.value = true
}

// Fermer modal édition
function closeEditModal() {
  isEditOpen.value = false
  selectedRecipe.value = null
}

// Charger recettes
async function fetchRecipes() {
  try {
    const response = await axios.get('http://127.0.0.1:8000/api/recipes')
    recipes.value = response.data
  } catch (error) {
    console.error('❌ Erreur récupération recettes:', error)
  }
}

onMounted(fetchRecipes)

// Créer recette
function handleCreate(newRecipe) {
  axios.post('http://127.0.0.1:8000/api/recipes', newRecipe, {
    headers: {
      'Content-Type': 'application/json',
      'Accept': 'application/json',
    }
  })
  .then(response => {
    alert('✅ Recette créée avec succès !')
    recipes.value.push(response.data.recipe)
    closeCreateModal()
  })
  .catch(error => {
    alert("❌ Erreur lors de la création : " + (error.response?.data?.message || error.message))
    console.error(error)
  })
}

// Mettre à jour recette
function handleUpdate(updatedRecipe) {
  axios.put(`http://127.0.0.1:8000/api/recipes/${updatedRecipe.id}`, updatedRecipe, {
    headers: {
      'Content-Type': 'application/json',
      'Accept': 'application/json',
    }
  })
  .then(response => {
    alert("✅ Recette modifiée avec succès !")
    const index = recipes.value.findIndex(r => r.id === updatedRecipe.id)
    if (index !== -1) {
      recipes.value[index] = response.data.recipe
    }
    closeEditModal()
  })
  .catch(error => {
    alert("❌ Erreur lors de la modification : " + (error.response?.data?.message || error.message))
    console.error(error)
  })
}

// Supprimer recette
function handleDelete(recipe) {
  if (!confirm(`🗑️ Supprimer la recette "${recipe.title}" ?`)) return

  axios.delete(`http://127.0.0.1:8000/api/recipes/${recipe.id}`)
    .then(() => {
      alert("✅ Recette supprimée !")
      recipes.value = recipes.value.filter(r => r.id !== recipe.id)
    })
    .catch(error => {
      alert("❌ Erreur lors de la suppression : " + (error.response?.data?.message || error.message))
      console.error(error)
    })
}
</script>