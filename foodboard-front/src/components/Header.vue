<template>
  <v-container class="text-center py-6">
    <v-img
      :src="logo"
      alt="Logo"
      width="200"
      height="50"
      class="mx-auto mb-3"
      contain
    />
    <p class="text-subtitle-1 font-weight-medium" style="color: #333;">
      Votre collection personnelle de recettes culinaires
    </p>
  </v-container>
</template>

<script>
import logo from '../assets/logo.svg'

export default {
  name: 'AppHeader',
  data() {
    return {
      logo
    }
  }
}
</script>