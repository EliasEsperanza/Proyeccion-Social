document.addEventListener('DOMContentLoaded', function() {
    // Evento para el botón de Generar PDF
    const btnPDF = document.querySelector('.btn-success');
    if (btnPDF) {
        btnPDF.addEventListener('click', function() {
            alert('Generando PDF...');
            // Aquí iría la lógica para generar el PDF
        });
    }

    // Evento para el botón de Generar Excel    
    const btnExcel = document.querySelector('.btn-primary');
    if (btnExcel) {
        btnExcel.addEventListener('click', function() {
            alert('Generando Excel...');
            // Aquí iría la lógica para generar el archivo Excel
        });
    }
});
