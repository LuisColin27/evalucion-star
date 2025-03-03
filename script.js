
// Función para generar y descargar el archivo CSV
function downloadCSV(data) {
    const csv = data.map(row => row.join(",")).join("\n");
    const blob = new Blob([csv], { type: "text/csv" });
    const url = URL.createObjectURL(blob);
    const a = document.createElement("a");
    a.href = url;
    a.download = "contacto.csv";
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
}

// Función para manejar el formulario
document.getElementById("contactForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Prevenir el envío tradicional del formulario

    // Obtener los datos del formulario
    const name = document.getElementById("name").value;
    const lastName = document.getElementById('lastName').value;
    const email = document.getElementById("email").value;
    const phone = document.getElementById("phone").value;

    // Crear una fila con la información del contacto
    const data = [
        ["Nombre","Apellidos", "Correo Electrónico", "Teléfono"],
        [name, lastName, email, phone]
    ];

    // Llamar a la función para descargar el CSV
    downloadCSV(data);

    // Limpiar el formulario después de guardarlo
    document.getElementById("contactForm").reset();
});
