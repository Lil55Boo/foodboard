<template>
  <div v-if="visible" class="modal-overlay" @click.self="close">
    <div class="modal-content">
      <button class="close-btn" @click="close">×</button>
      <h2>Créer une nouvelle recette</h2>
      <form @submit.prevent="handleFormSubmit">
        <label>
          Titre *
          <input v-model="title" type="text" required />
        </label>

        <label>
          Description
          <textarea v-model="description" rows="4"></textarea>
        </label>

        <label>
          Ingrédients (séparés par des virgules)
          <input v-model="ingredients" type="text" />
        </label>

        <button type="submit" class="submit-btn">Créer</button>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  name: "Create",
  props: {
    visible: Boolean,
  },
  data() {
    return {
      title: "",
      description: "",
      ingredients: ""
    };
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

      const payload = {
        title: this.title.trim(),
        description: this.description.trim(),
        ingredients: this.ingredients
          .split(",")
          .map(i => i.trim())
          .filter(i => i.length > 0),
      };

      this.$emit("create", payload);
      this.close();
    }
  }
};
</script>

<style scoped>
/* styles identiques à avant (modal, inputs, etc.) */
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 999;
}

.modal-content {
  background: white;
  padding: 30px;
  border-radius: 10px;
  width: 90%;
  max-width: 400px;
  position: relative;
  box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
}

.close-btn {
  position: absolute;
  top: 10px;
  right: 15px;
  background: none;
  border: none;
  font-size: 25px;
  cursor: pointer;
}

form label {
  display: block;
  margin-bottom: 15px;
  font-weight: 600;
  font-size: 14px;
}

input[type="text"],
textarea {
  width: 100%;
  padding: 8px 10px;
  margin-top: 5px;
  border-radius: 6px;
  border: 1px solid #ccc;
  font-size: 14px;
  box-sizing: border-box;
}

.submit-btn {
  background: linear-gradient(to right, #3B82F6, #06b6d4);
  border: none;
  padding: 12px 20px;
  color: white;
  font-weight: 700;
  font-size: 15px;
  border-radius: 25px;
  cursor: pointer;
  width: 100%;
  transition: transform 0.2s ease;
}

.submit-btn:hover {
  transform: scale(1.05);
}
</style>