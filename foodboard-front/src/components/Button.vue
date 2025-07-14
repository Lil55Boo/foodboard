<template>
  <button class="floating-btn" aria-label="Créer une nouvelle recette" @click="$emit('open-create')">
    <i class="bx bx-plus"></i>
  </button>
</template>

<script>
export default {
  name: 'FloatingButton',
};
</script>

<style scoped>
.floating-btn {
  position: fixed;
  bottom: 20px;
  right: 20px;
  width: 56px;
  height: 56px;
  border-radius: 50%;
  border: none;
  background: linear-gradient(45deg, #3B82F6, #06b6d4);
  box-shadow: 0 4px 12px rgba(59, 130, 246, 0.6);
  color: white;
  font-size: 28px;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.floating-btn:hover {
  transform: scale(1.1);
  box-shadow: 0 6px 18px rgba(59, 130, 246, 0.8);
}
</style>