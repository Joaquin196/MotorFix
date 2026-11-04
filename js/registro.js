// Verificamos si el formulario de registro ha sido enviado mediante AJAX
document.getElementById("form-registro").addEventListener("submit", function(e) {
    e.preventDefault(); // Evitamos la recarga clásica de la página

    const email = document.getElementById("email").value;
    const password = document.getElementById("password").value;

    // Obtenemos los datos del formulario
    const formData = new FormData();
    formData.append("email", email);
    formData.append("password", password);

    // Instanciamos la llamada al controlador de usuarios llamando al método registrar
    fetch('../controllers/usuario_controller.php?accion=registrar', {
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
            alertaDiv.textContent = "¡Usuario registrado con éxito! Redirigiendo al login...";
            setTimeout(() => {
                window.location.href = "login.html"; // Redirigimos al login tras el éxito
            }, 1500);
        } else {
            alertaDiv.className = "alert-message alert-error";
            alertaDiv.textContent = data.mensaje || "Hubo un error al registrar el usuario.";
        }
    })
    .catch(error => {
        console.error("Error en el registro:", error);
    });
});