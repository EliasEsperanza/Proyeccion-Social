    const fechaInicio = document.getElementById("fechaInicio");
    const fechaFin = document.getElementById("fechaFin");

    // Establecer la fecha mínima para el campo de fecha inicial (hoy)
    const hoy = new Date().toISOString().split("T")[0];
    fechaInicio.min = hoy;

    // Deshabilitar el campo de fecha final por defecto
    fechaFin.disabled = true;

    fechaInicio.addEventListener("change", function () {
      if (fechaInicio.value) {
        const fechaInicialSeleccionada = new Date(fechaInicio.value);
        
        // Habilitar el campo de fecha final
        fechaFin.disabled = false;

        // Calcular la fecha mínima (6 meses )
        const fechaMin = new Date(fechaInicialSeleccionada);
        fechaMin.setMonth(fechaMin.getMonth() + 6);
        fechaFin.min = fechaMin.toISOString().split("T")[0];

        // Calcular la fecha máxima (5 años)
        const fechaMax = new Date(fechaInicialSeleccionada);
        fechaMax.setFullYear(fechaMax.getFullYear() + 5);
        fechaFin.max = fechaMax.toISOString().split("T")[0];
    } else {
        // Si no se selecciona una fecha inicial, deshabilitar la fecha final
        fechaFin.disabled = true;
    }
    });