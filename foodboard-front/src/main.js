import { createApp } from 'vue'
import App from './App.vue'

// Vuetify
import 'vuetify/styles' // Import des styles Vuetify
import '@mdi/font/css/materialdesignicons.css' // Import des icônes MDI
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'

const vuetify = createVuetify({
  components,
  directives,
  icons: {
    defaultSet: 'mdi', // ← Activation de l'icône par défaut : mdi
  },
})

createApp(App)
  .use(vuetify)
  .mount('#app')