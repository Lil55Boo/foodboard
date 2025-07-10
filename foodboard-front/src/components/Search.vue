<template>
    <div class="search-container">
        <i class='bx bx-search'></i>
        <input type="text" v-model="searchQuery" placeholder="Rechercher par ingrédient ou nom de recette..." class="search-input" />
    </div>
</template>
    
<script>
</script>
    
<style scoped>
.search-container {
  position: relative;             /* important pour positionner l’icône */
  max-width: 500px;
  margin: 20px auto;
}

.search-input {
  width: 100%;
  padding: 12px 16px 12px 40px;   /* padding à gauche pour laisser la place à l’icône */
  border-radius: 25px;
  border: none;
  background-color: white;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
  font-size: 16px;
  outline: none;
}

i.bx {
  position: absolute;
  top: 50%;
  left: 14px;
  transform: translateY(-50%);
  font-size: 20px;
  color: #6A7280;
}
</style>