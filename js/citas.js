document.addEventListener("DOMContentLoaded", () => {
    const formCrearCita = document.getElementById("formCrearCita");

    if (formCrearCita) {
        formCrearCita.addEventListener("submit", async (e) => {
            e.preventDefault(); // Evitamos que recargue la página

            // Recogemos los datos del formulario
            const formData = new FormData(formCrearCita);

            try {
                // Hacemos la petición fetch al controlador indicando la acción 'crear'
                const response = await fetch("../controllers/cita_controller.php?accion=crear", {
                    method: "POST",
                    body: formData
                });

                const resultado = await response.json();

                if (resultado.status === "success") {
                    alert("¡Éxito! " + resultado.message);
                    formCrearCita.reset(); // Limpiamos el formulario
                    // Aquí podrías llamar a una función para recargar la tabla de citas si la tienes en la misma vista
                } else {
                    alert("Error: " + resultado.message);
                }
            } catch (error) {
                console.error("Error en la petición AJAX:", error);
                alert("Hubo un problema al conectar con el servidor.");
            }
        });
    }
});