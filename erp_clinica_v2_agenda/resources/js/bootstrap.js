import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import Alpine from 'alpinejs';
import intersect from '@alpinejs/intersect'; // Importar el plugin

Alpine.plugin(intersect); // Registrar el plugin

window.Alpine = Alpine;

Alpine.start();
