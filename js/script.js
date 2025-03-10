// js/script.js

document.querySelector('form').addEventListener('submit', function(e) {
    let usuario = document.querySelector('input[name="usuario"]').value;
    let clave = document.querySelector('input[name="clave"]').value;
 
    if (usuario === '' || clave === '') {
        alert('Por favor, complete todos los campos.');
        e.preventDefault(); // Evita el envío del formulario si hay campos vacíos.
    }
 });
 