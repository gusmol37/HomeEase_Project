// Validación de formulario de registro
document.addEventListener('DOMContentLoaded', () => {
    const registroForm = document.getElementById('registroForm');
    const loginForm = document.getElementById('loginForm');

    // Validación de registro
    if (registroForm) {
        registroForm.addEventListener('submit', (event) => {
            const nombre = document.getElementById('nombre').value.trim();
            const correo = document.getElementById('correo').value.trim();
            const contraseña = document.getElementById('contraseña').value.trim();

            if (!nombre || !correo || !contraseña) {
                event.preventDefault();
                alert('Por favor, completa todos los campos.');
            } else if (contraseña.length < 6) {
                event.preventDefault();
                alert('La contraseña debe tener al menos 6 caracteres.');
            }
        });
    }

    // Validación de inicio de sesión
    if (loginForm) {
        loginForm.addEventListener('submit', (event) => {
            const correo = document.getElementById('correo').value.trim();
            const contraseña = document.getElementById('contraseña').value.trim();

            if (!correo || !contraseña) {
                event.preventDefault();
                alert('Por favor, ingresa tu correo y contraseña.');
            }
        });
    }
});
