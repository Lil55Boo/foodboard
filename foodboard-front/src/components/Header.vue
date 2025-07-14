<template>
    <img :src="logo" alt="Logo" class="logo" />
    <p>Votre collection personnelle de recettes culinaires</p>
  
</template>

<script>
import logo from '../assets/logo.svg'

export default {
  data() {
    return {
      logo
    }
  }
}
</script>



<style scoped>
.logo {
  width: 200px;
  height: 50px;
  margin: auto;
  display: block;
}

p {
    text-align: center;
    font-size: 1.2em;
    color: #333;
}

</style> 