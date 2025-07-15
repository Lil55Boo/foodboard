<template>
  <v-container fluid class="empty-state-container">
    <v-row align="center" justify="center" class="flex-column text-center">
      <v-sheet
        class="circle"
        elevation="6"
        rounded="circle"
        width="120"
        height="120"
        color="deep-purple accent-4"
        dark
      >
        <v-row align="center" justify="center" class="fill-height">
          <v-icon size="60">mdi-silverware-fork-knife</v-icon>
        </v-row>
      </v-sheet>

      <h2 class="mt-6 font-weight-medium">Aucune recette pour le moment</h2>
      <p class="text-center mx-auto mb-8" style="max-width: 300px; color: #6b7280;">
        Commencez à construire votre collection de recettes en ajoutant votre première création culinaire.
      </p>

      <v-btn
        class="create-btn"
        color="primary"
        rounded
        large
        elevation="4"
        @click="$emit('open-create')"
      >
        <v-icon left>mdi-plus</v-icon>
        Créer ma première recette
      </v-btn>
    </v-row>
  </v-container>
</template>

<script>
export default {
  name: "EmptyState",
};
</script>

<style scoped>
.empty-state-container {
  min-height: 60vh;
  display: flex;
  align-items: center;
  justify-content: center;
}

.circle {
  box-shadow: 0 6px 20px rgba(59, 130, 246, 0.3);
}

.create-btn {
  transition: transform 0.2s ease;
}

.create-btn:hover {
  transform: scale(1.05);
}
</style>