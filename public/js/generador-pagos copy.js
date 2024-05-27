function generarFechasDePago(diaDePago, mesInicial, anioInicial, cantidadPagos) {
    const fechasDePago = [];
    let mes = mesInicial - 1; // En JavaScript, los meses van de 0 (enero) a 11 (diciembre)
    let anio = anioInicial;
    
    for (let i = 0; i < cantidadPagos; i++) {
        let fechaPago;
        
        if (diaDePago > 30) {
            diaDePago = 30; // Ajustamos el día de pago si es mayor a 30
        }

        // Obtenemos el último día del mes actual
        let ultimoDiaDelMes = new Date(anio, mes + 1, 0).getDate();
        
        if (diaDePago > ultimoDiaDelMes) {
            // Si el día de pago no existe en el mes actual, lo movemos al primero del mes siguiente
            fechaPago = new Date(anio, mes + 1, 1);
        } else {
            // Si el día de pago existe en el mes actual
            fechaPago = new Date(anio, mes, diaDePago);
        }
        
        fechasDePago.push(fechaPago);

        // Avanzamos al siguiente mes
        mes++;
        if (mes > 11) {
            mes = 0;
            anio++;
        }
    }
    
    return fechasDePago.map(fecha => fecha.toISOString().split('T')[0]); // Convertimos a formato YYYY-MM-DD
}

// Ejemplo de uso
const diaDePago = 31;
const mesInicial = 1;
const anioInicial = 2024;
const cantidadPagos = 3;

const fechasDePago = generarFechasDePago(diaDePago, mesInicial, anioInicial, cantidadPagos);
console.log(fechasDePago);
