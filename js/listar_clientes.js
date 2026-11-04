document.addEventListener("DOMContentLoaded", () => {
    // Llamamos al controlador mediante fetch para pedir los datos en JSON
    fetch('../controllers/cliente_controller.php?accion=listar')
        .then(response => response.json())
        .then(data => {
            console.log("Clientes recibidos:", data);
            const tbody = document.querySelector("#tabla-clientes tbody");
            tbody.innerHTML = ""; // Limpiamos la tabla por si acaso

            if (data && data.length > 0) {
                data.forEach(cliente => {
                    const tr = document.createElement("tr");
                    tr.innerHTML = `
                        <td>${cliente.dni}</td>
                        <td>${cliente.nombre}</td>
                        <td>${cliente.email || 'N/D'}</td>
                        <td>${cliente.telefono}</td>
                        <td class="acciones-links">
                            <a href="#">Editar</a>
                            <a href="#" style="color: #f87171;">Eliminar</a>
                        </td>
                    `;
                    tbody.appendChild(tr);
                });
            } else {
                tbody.innerHTML = `<tr><td colspan="5" class="no-data">No hay clientes registrados en el sistema.</td></tr>`;
            }
        })
        .catch(error => {
            console.error("Error al cargar los clientes:", error);
        });
});