<template>
  <v-dialog v-model="internalVisible" persistent max-width="500">
    <v-card>
      <v-card-title class="d-flex justify-space-between align-center">
        <span class="text-h6">Modifier la recette</span>
        <v-btn icon @click="close">
          <v-icon>mdi-close</v-icon>
        </v-btn>
      </v-card-title>

      <v-card-text>
        <v-form @submit.prevent="handleFormSubmit" ref="formRef">
          <v-text-field
            v-model="title"
            label="Titre *"
            required
          ></v-text-field>

          <v-textarea
            v-model="description"
            label="Description"
            rows="3"
          ></v-textarea>

          <v-text-field
            v-model="ingredients"
            label="Ingrédients (séparés par des virgules)"
          ></v-text-field>
        </v-form>
      </v-card-text>

      <v-card-actions>
        <v-btn
          color="primary"
          block
          @click="handleFormSubmit"
        >
          Modifier
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
export default {
  name: "Edit",
  props: {
    visible: Boolean,
    recipe: {
      type: Object,
      default: null,
    },
  },
  data() {
    return {
      title: "",
      description: "",
      ingredients: "",
      internalVisible: false,
    };
  },
  watch: {
    visible(val) {
      this.internalVisible = val;
      if (val && this.recipe) {
        this.title = this.recipe.title || "";
        this.description = this.recipe.description || "";
        this.ingredients = (this.recipe.ingredients || [])
          .map(i => i.name || i)
          .join(", ");
      }
    },
    internalVisible(val) {
      if (!val) this.close();
    },
  },
  methods: {
    close() {
      this.$emit("close");
      this.resetForm();
    },
    resetForm() {
      this.title = "";
      this.description = "";
      this.ingredients = "";
    },
    handleFormSubmit() {
      if (!this.title.trim()) {
        alert("Le titre est obligatoire");
        return;
      }

      const updated = {
        id: this.recipe.id,
        title: this.title.trim(),
        description: this.description.trim(),
        ingredients: this.ingredients
          .split(",")
          .map(i => i.trim())
          .filter(i => i.length > 0),
      };

      this.$emit("update", updated);
      this.close();
    },
  },
};
</script>

<style scoped>
.v-card-title {
  padding-bottom: 0;
}
</style>