<template>
  <div id="app">
    <Header />

    <Search v-model="searchQuery" />

    <Empty
      v-if="filteredRecipes.length === 0"
      @open-create="openCreateModal"
    />

    <Recipe
      v-else
      :recipes="filteredRecipes"
      @edit="openEditModal"
      @delete="handleDelete"
    />

    <Button @open-create="openCreateModal" />

    <Create
      :visible="isCreateOpen"
      @close="closeCreateModal"
      @create="handleCreate"
    />

    <Edit
      :visible="isEditOpen"
      :recipe="selectedRecipe"
      @close="closeEditModal"
      @update="handleUpdate"
    />
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import axios from 'axios'

// Composants
import Header from './components/Header.vue'
import Search from './components/Search.vue'
import Empty from './components/Empty.vue'
import Button from './components/Button.vue'
import Recipe from './components/Recipe.vue'
import Create from './components/Create.vue'
import Edit from './components/Edit.vue'

// ✅ Base API URL depuis .env
const baseUrl = 'https://foodboard.onrender.com'

// États globaux
const recipes = ref([])
const searchQuery = ref("")
const isCreateOpen = ref(false)
const isEditOpen = ref(false)
const selectedRecipe = ref(null)

// Recettes filtrées
const filteredRecipes = computed(() => {
  const q = searchQuery.value.toLowerCase().trim()
  if (!q) return recipes.value

  return recipes.value.filter(recipe =>
    recipe.title.toLowerCase().includes(q) ||
    recipe.ingredients.some(ingredient => {
      const name = typeof ingredient === 'string' ? ingredient : ingredient.name
      return name.toLowerCase().includes(q)
    })
  )
})

// Ouvrir / fermer modals
function openCreateModal() {
  selectedRecipe.value = null
  isCreateOpen.value = true
}
function closeCreateModal() {
  isCreateOpen.value = false
}
function openEditModal(recipe) {
  selectedRecipe.value = recipe
  isEditOpen.value = true
}
function closeEditModal() {
  isEditOpen.value = false
  selectedRecipe.value = null
}

// 🔁 Charger les recettes
async function fetchRecipes() {
  try {
    const response = await axios.get(`${baseUrl}/api/recipes`)
    recipes.value = response.data
  } catch (error) {
    console.error('❌ Erreur récupération recettes:', error)
  }
}
onMounted(fetchRecipes)

// ➕ Créer recette
function handleCreate(newRecipe) {
  axios.post(`${baseUrl}/api/recipes`, newRecipe)
    .then(response => {
      alert('✅ Recette créée avec succès !')
      recipes.value.push(response.data.recipe)
      closeCreateModal()
    })
    .catch(error => {
      alert("❌ Erreur création : " + (error.response?.data?.message || error.message))
      console.error(error)
    })
}

// ✏️ Modifier recette
function handleUpdate(updatedRecipe) {
  axios.put(`${baseUrl}/api/recipes/${updatedRecipe.id}`, updatedRecipe)
    .then(response => {
      alert("✅ Recette modifiée !")
      const index = recipes.value.findIndex(r => r.id === updatedRecipe.id)
      if (index !== -1) {
        recipes.value[index] = response.data.recipe
      }
      closeEditModal()
    })
    .catch(error => {
      alert("❌ Erreur modification : " + (error.response?.data?.message || error.message))
      console.error(error)
    })
}

// 🗑️ Supprimer recette
function handleDelete(recipe) {
  if (!confirm(`🗑️ Supprimer la recette "${recipe.title}" ?`)) return
  axios.delete(`${baseUrl}/api/recipes/${recipe.id}`)
    .then(() => {
      alert("✅ Recette supprimée !")
      recipes.value = recipes.value.filter(r => r.id !== recipe.id)
    })
    .catch(error => {
      alert("❌ Erreur suppression : " + (error.response?.data?.message || error.message))
      console.error(error)
    })
}
</script>