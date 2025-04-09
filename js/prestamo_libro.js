// Función para calcular la fecha de devolución (sumando 3 días hábiles)
function calcularFechaDevolucion() {
    // Obtener la fecha de préstamo del campo input
    const fechaPrestamo = new Date(document.getElementById('fecha_prestamo').value);
    
    if (!fechaPrestamo.getTime()) {
        alert("Por favor, seleccione una fecha de préstamo válida.");
        return;
    }

    // Inicializar la fecha de devolución (empezamos con la fecha de préstamo)
    let fechaDevolucion = new Date(fechaPrestamo);

    // Contar 3 días hábiles
    let diasAgregados = 0;
    while (diasAgregados < 3) {
        // Sumar un día
        fechaDevolucion.setDate(fechaDevolucion.getDate() + 1);
        
        // Verificar si el día es un día hábil (lunes a viernes)
        // Los días de la semana en JavaScript son: 0 = domingo, 1 = lunes, ..., 6 = sábado
        if (fechaDevolucion.getDay() !== 0 && fechaDevolucion.getDay() !== 6) {
            diasAgregados++;
        }
    }

    // Mostrar la fecha de devolución en formato DD/MM/YYYY
    const fechaDevolucionFormatted = formatDateToDDMMYYYY(fechaDevolucion);
    document.getElementById('fecha_devolucion').value = fechaDevolucionFormatted;
}

// Función para formatear la fecha a formato DD/MM/YYYY
function formatDateToDDMMYYYY(date) {
    const day = String(date.getDate()).padStart(2, '0'); // Día con 2 dígitos
    const month = String(date.getMonth() + 1).padStart(2, '0'); // Mes con 2 dígitos
    const year = date.getFullYear();

    return `${day}/${month}/${year}`;
}

// Asignar el evento a la función cuando se haga clic en el botón "Calcular Fecha de Devolución"
document.querySelector('.btn-calculate').addEventListener('click', calcularFechaDevolucion);
