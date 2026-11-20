import './stimulus_bootstrap.js';
import Swal from 'sweetalert2';

/*
 * Welcome to your app's main JavaScript file!
 */
import './styles/app.css';

console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');

Swal.fire({
    title: 'Bienvenue !',
    text: 'SweetAlert2 fonctionne avec Symfony AssetMapper.',
    icon: 'success',
    confirmButtonText: 'OK'
});
