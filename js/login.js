// Verificamos si el formulario ha sido enviado mediante AJAX
document.getElementById("form-login").addEventListener("submit", function(e) {
    e.preventDefault(); // Evitamos que recargue la página de forma clásica

    const email = document.getElementById("email").value;
    const password = document.getElementById("password").value;

    // Obtenemos los datos del formulario
    const formData = new FormData();
    formData.append("email", email);
    formData.append("password", password);

    // Llamamos al controlador de usuarios mediante fetch
    fetch('../controllers/usuario_controller.php?accion=login', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        const alertaDiv = document.getElementById("alerta");
        alertaDiv.style.display = "block";

        // Verificamos el resultado devuelto por el controlador
        if (data.success) {
            alertaDiv.className = "alert-message alert-success";
            alertaDiv.textContent = "¡Login exitoso! Bienvenido, " + email;
            setTimeout(() => {
                window.location.href = "listar_clientes.html"; // Redirección al panel
            }, 1500);
        } else {
            alertaDiv.className = "alert-message alert-error";
            alertaDiv.textContent = data.mensaje || "Correo o contraseña incorrectos.";
        }
    })
    .catch(error => {
        console.error("Error en el login:", error);
    });
});