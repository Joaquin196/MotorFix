document.addEventListener("DOMContentLoaded", () => {
    cargarVehiculosCliente();

    const formCita = document.getElementById("formCitaCliente");
    if (formCita) {
        formCita.addEventListener("submit", async (e) => {
            e.preventDefault();
            const formData = new FormData(formCita);

            // Hacemos la petición fetch al controlador indicando la acción crear
            try {
                const response = await fetch("../controllers/cita_controller.php?accion=crear", {
                    method: "POST",
                    body: formData
                });
                const resultado = await response.json();

                const alertaDiv = document.getElementById("alerta");
                alertaDiv.style.display = "block";

                if (resultado.status === "success" || resultado.success) {
                    alertaDiv.className = "alert-message alert-success";
                    alertaDiv.textContent = "¡Cita solicitada con éxito!";
                    formCita.reset();
                } else {
                    alertaDiv.className = "alert-message alert-error";
                    alertaDiv.textContent = resultado.message || "Error al solicitar la cita.";
                }
            } catch (error) {
                console.error("Error en la petición:", error);
            }
        });
    }
});

// Función para obtener los vehículos del cliente vía AJAX
async function cargarVehiculosCliente() {
    try {
        const response = await fetch("../controllers/vehiculo_controller.php?accion=listar");
        const data = await response.json();

        const tbody = document.querySelector("#tabla-vehiculos tbody");
        const selectVehiculo = document.getElementById("matricula");
        
        if (tbody) tbody.innerHTML = "";
        if (selectVehiculo) selectVehiculo.innerHTML = '<option value="">Selecciona un vehículo</option>';

        // Comprobamos si nos devuelve los datos correctamente
        const vehiculos = data.vehiculos || data; 

        if (Array.isArray(vehiculos)) {
            vehiculos.forEach(v => {
                // Rellenar la tabla
                if (tbody) {
                    tbody.innerHTML += `
                        <tr>
                            <td>${v.matricula}</td>
                            <td>${v.marca}</td>
                            <td>${v.modelo}</td>
                            <td>${v.anio || '-'}</td>
                        </tr>
                    `;
                }
                // Rellenar el select de la cita
                if (selectVehiculo) {
                    selectVehiculo.innerHTML += `<option value="${v.matricula}">${v.marca} ${v.modelo} (${v.matricula})</option>`;
                }
            });
        }
    } catch (error) {
        console.error("Error al cargar los vehículos:", error);
    }
}