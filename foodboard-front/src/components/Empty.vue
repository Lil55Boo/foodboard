<template>
  <div class="empty-state-container">
    <div class="circle">
      <i class="bx bx-knife"></i>
    </div>
    <h2>Aucune recette pour le moment</h2>
    <p>Commencez à construire votre collection de recettes en ajoutant votre première création culinaire.</p>
    <button class="create-btn" @click="$emit('open-create')">
      <i class="bx bx-plus"></i>
      Créer ma première recette
    </button>
  </div>
</template>

<script>
export default {
  name: "EmptyState",
};
</script>

<style scoped>
.empty-state-container {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  height: 50vh;
  text-align: center;
  padding: 20px;
}

.circle {
  width: 120px;
  height: 120px;
  border-radius: 50%;
  background: linear-gradient(to right, #5737EF, #D9C1FF);
  display: flex;
  align-items: center;
  justify-content: center;
  margin-bottom: 20px;
  box-shadow: 0 6px 20px rgba(59, 130, 246, 0.3);
}

.bx-knife {
  font-size: 60px;
  color: white;
}

h2 {
  font-weight: 600;
  font-size: 22px;
  margin-bottom: 10px;
  color: #1f2937;
}

p {
  font-size: 15px;
  color: #6b7280;
  margin-bottom: 30px;
  max-width: 300px;
}

.create-btn {
  display: flex;
  align-items: center;
  gap: 8px;
  background: linear-gradient(to right, #3B82F6, #06b6d4);
  border: none;
  border-radius: 25px;
  color: white;
  padding: 12px 20px;
  font-size: 15px;
  font-weight: 600;
  box-shadow: 0 4px 14px rgba(59, 130, 246, 0.3);
  cursor: pointer;
  transition: transform 0.2s ease;
}

.create-btn:hover {
  transform: scale(1.05);
}
</style>