<template>
  <div class="recipe-container">
    <Empty v-if="recipes.length === 0" />

    <div v-else class="recipe-grid">
      <div v-for="recipe in recipes" :key="recipe.id" class="recipe-card">
        <h3>{{ recipe.title }}</h3>
        <p>{{ recipe.description }}</p>
        <ul>
          <li v-for="ingredient in recipe.ingredients" :key="ingredient.id || ingredient.name">
            {{ ingredient.name || ingredient }}
          </li>
        </ul>

        <div class="actions">
          <button @click="$emit('edit', recipe)">✏️ Modifier</button>
          <button @click="$emit('delete', recipe)">🗑️ Supprimer</button>
        </div>
      </div>
    </div>

    <!-- Popup Création -->
    <Create
      :visible="isCreateOpen"
      @close="closeCreatePopup"
      @create="handleCreate"
    />

    <!-- Popup Édition -->
    <Edit
      :visible="isEditOpen"
      :recipe="selectedRecipe"
      @close="closeEditPopup"
      @update="handleUpdate"
    />
  </div>
</template>

<script setup>
import { ref, watch } from 'vue'
import Empty from './Empty.vue'
import Create from './Create.vue'
import Edit from './Edit.vue'

const props = defineProps({
  recipes: {
    type: Array,
    required: true
  }
})

const emit = defineEmits(['edit', 'delete', 'create', 'update'])

const isCreateOpen = ref(false)
const isEditOpen = ref(false)
const selectedRecipe = ref(null)

// Écoute des événements venant de l'extérieur (App.vue) pour ouvrir les modals
watch(() => props.recipes, () => {
  // Rien à faire ici, recettes mises à jour par le parent
})

// Fonction pour ouvrir la popup création (appelée par App.vue)
function openCreate() {
  isCreateOpen.value = true
}

// Fonction pour ouvrir la popup édition (appelée par App.vue)
function openEdit(recipe) {
  selectedRecipe.value = recipe
  isEditOpen.value = true
}

// Fermeture popups
function closeCreatePopup() {
  isCreateOpen.value = false
}

function closeEditPopup() {
  isEditOpen.value = false
  selectedRecipe.value = null
}

// Gestion création (émission vers App.vue)
function handleCreate(recipeData) {
  emit('create', recipeData)
  closeCreatePopup()
}

// Gestion modification (émission vers App.vue)
function handleUpdate(recipeData) {
  emit('update', recipeData)
  closeEditPopup()
}
</script>

<style scoped>
.recipe-container {
  padding: 20px;
}

.recipe-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 20px;
}

.recipe-card {
  background: #fff;
  border-radius: 8px;
  padding: 15px;
  box-shadow: 0 2px 8px rgb(0 0 0 / 0.1);
}

.recipe-card h3 {
  margin: 0 0 10px;
}

.recipe-card ul {
  padding-left: 20px;
  margin: 0;
  list-style-type: disc;
}

.recipe-card ul li {
  font-size: 14px;
  margin-bottom: 4px;
}

.actions {
  margin-top: 10px;
}

.actions button {
  margin-right: 8px;
  cursor: pointer;
}
</style>