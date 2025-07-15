<template>
  <v-btn
    icon
    color="primary"
    class="floating-btn"
    @click="$emit('open-create')"
    elevation="10"
    aria-label="Créer une nouvelle recette"
  >
    <v-icon size="28">mdi-plus</v-icon>
  </v-btn>
</template>

<script>
export default {
  name: "FloatingButton",
};
</script>

<style scoped>
.floating-btn {
  position: fixed;
  bottom: 20px;
  right: 20px;
  border-radius: 50% !important; /* assure que le bouton reste rond */
  width: 56px;
  height: 56px;
  display: flex;
  align-items: center;
  justify-content: center;
}
</style>