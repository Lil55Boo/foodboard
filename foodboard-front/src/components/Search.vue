<template>
  <v-container class="d-flex justify-center mt-6">
    <v-text-field
      v-model="inputValue"
      prepend-inner-icon="mdi-magnify"
      placeholder="Rechercher par ingrédient ou nom de recette..."
      hide-details
      clearable
      rounded
      variant="outlined"
      class="search-field"
    />
  </v-container>
</template>

<script>
export default {
  name: "Search",
  props: {
    modelValue: {
      type: String,
      default: ""
    }
  },
  computed: {
    inputValue: {
      get() {
        return this.modelValue
      },
      set(value) {
        this.$emit("update:modelValue", value)
      }
    }
  }
}
</script>

<style scoped>
.search-field {
  max-width: 500px;
  width: 100%;
}
</style>