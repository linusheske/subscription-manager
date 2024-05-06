import { createApp } from 'vue'
import './style.css'
import App from './App.vue'
import Keycloak from 'keycloak-js';

const keycloakInitOptions = {
    url: import.meta.env.VITE_KEYCLOAK_URL,
    clientId: import.meta.env.VITE_KEYCLOAK_CLIENT_ID,
    realm: import.meta.env.VITE_KEYCLOAK_REALM,
    onLoad: 'login-required'
}

const keycloak = new Keycloak(keycloakInitOptions);

keycloak.init({ onLoad: keycloakInitOptions.onLoad }).then((auth) => {

    if (!auth) {
        window.location.reload();
        console.log('not worked');
    } else {
        console.log("Authenticated");
        localStorage.setItem("vue-token", keycloak.token);
        localStorage.setItem("vue-refresh-token", keycloak.refreshToken);
        createApp(App).mount('#app')
    }

}).catch(() => {
    console.log("Authenticated Failed");
});
