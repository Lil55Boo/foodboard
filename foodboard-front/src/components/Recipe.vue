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
        <v-card
          class="d-flex flex-column fill-height pa-4"
          flat
          color="white"
        >
          <!-- Titre + Actions -->
          <div class="d-flex justify-space-between align-center mb-2">
            <v-card-title class="text-h6 pa-0">{{ recipe.title }}</v-card-title>
            <div>
              <v-icon
                class="mr-2"
                color="primary"
                size="20"
                @click="$emit('edit', recipe)"
                title="Modifier"
              >
                mdi-pencil
              </v-icon>
              <v-icon
                color="error"
                size="20"
                @click="$emit('delete', recipe)"
                title="Supprimer"
              >
                mdi-delete
              </v-icon>
            </div>
          </div>

          <!-- Description -->
          <v-card-text class="truncate-description">
            {{ recipe.description }}
          </v-card-text>

          <!-- Ingrédients -->
          <div class="ingredient-scroll mt-auto pt-3">
            <v-chip
              v-for="(ingredient, index) in recipe.ingredients"
              :key="ingredient.id || ingredient.name || index"
              class="ma-1"
              :color="getColor(index)"
              text-color="white"
              label
              small
            >
              {{ ingredient.name || ingredient }}
            </v-chip>
          </div>
        </v-card>
      </v-col>
    </v-row>

    <!-- Modals -->
    <Create
      :visible="isCreateOpen"
      @close="closeCreatePopup"
      @create="handleCreate"
    />
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
function handleCreate(recipeData) {
  emit('create', recipeData)
  closeCreatePopup()
}
function handleUpdate(recipeData) {
  emit('update', recipeData)
  closeEditPopup()
}

// 🎨 Couleurs variées pour chips
const chipColors = [
  'deep-purple accent-4',
  'cyan darken-2',
  'indigo',
  'green darken-2',
  'red darken-1',
  'pink lighten-1',
  'teal darken-3',
  'orange darken-1',
  'blue-grey darken-1'
]

function getColor(index) {
  return chipColors[index % chipColors.length]
}
</script>

<style scoped>
.truncate-description {
  max-height: 60px;
  overflow: hidden;
  display: -webkit-box;
  display: box;
  -webkit-line-clamp: 3;
  line-clamp: 3;
  -webkit-box-orient: vertical;
  box-orient: vertical;
  text-overflow: ellipsis;
  white-space: normal;
  font-size: 14px;
  color: #444;
}

.ingredient-scroll {
  display: flex;
  overflow-x: auto;
  white-space: nowrap; /* empêche le retour à la ligne */
  gap: 8px;
  padding-bottom: 4px;
  scrollbar-width: none; /* Firefox */
  -ms-overflow-style: none;  /* IE 10+ */
}

.ingredient-scroll::-webkit-scrollbar {
  display: none; /* Chrome, Safari, Opera */
}

.ingredient-scroll .v-chip {
  flex-shrink: 0; /* empêche les chips de se compresser */
}
</style>