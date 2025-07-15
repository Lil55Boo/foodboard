<template>
  <v-container class="py-6">
    <Empty v-if="recipes.length === 0" />

    <v-row v-else dense>
      <v-col
        v-for="recipe in recipes"
        :key="recipe.id"
        cols="12"
        sm="6"
        md="4"
      >
        <v-card class="pa-4" elevation="4">
          <v-card-title class="text-h6">{{ recipe.title }}</v-card-title>
          <v-card-text>
            <p class="mb-2">{{ recipe.description }}</p>
            <v-list dense>
              <v-list-item
                v-for="ingredient in recipe.ingredients"
                :key="ingredient.id || ingredient.name"
              >
                <v-list-item-content>
                  <v-list-item-title class="text-subtitle-2">
                    {{ ingredient.name || ingredient }}
                  </v-list-item-title>
                </v-list-item-content>
              </v-list-item>
            </v-list>
          </v-card-text>
          <v-card-actions>
            <v-btn color="primary" @click="$emit('edit', recipe)" variant="text">
              ✏️ Modifier
            </v-btn>
            <v-btn color="error" @click="$emit('delete', recipe)" variant="text">
              🗑️ Supprimer
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-col>
    </v-row>

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
  </v-container>
</template>

<script setup>
import { ref } from 'vue'
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

// Ouverture / fermeture modales
function openCreate() {
  isCreateOpen.value = true
}

function closeCreatePopup() {
  isCreateOpen.value = false
}

function openEdit(recipe) {
  selectedRecipe.value = recipe
  isEditOpen.value = true
}

function closeEditPopup() {
  isEditOpen.value = false
  selectedRecipe.value = null
}

// Gestion des envois
function handleCreate(recipeData) {
  emit('create', recipeData)
  closeCreatePopup()
}

function handleUpdate(recipeData) {
  emit('update', recipeData)
  closeEditPopup()
}
</script>

<style scoped>
/* plus besoin de grid CSS manuelle : Vuetify gère ça avec <v-row> et <v-col> */
</style>