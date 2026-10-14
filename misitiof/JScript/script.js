window.addEventListener('DOMContentLoaded', () => {
    const botonPdf = document.getElementById('btnPdf');
    const contenido = document.getElementById('documentoFactura') || document.body;

    if (!botonPdf || !contenido) return;

    botonPdf.addEventListener('click', () => {
        if (typeof window.html2pdf !== 'function') {
            window.alert('No se pudo cargar la biblioteca para crear el PDF.');
            return;
        }

        window.html2pdf()
            .set({
                margin: 0,
                filename: 'facturaFares.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 1, letterRendering: true },
                jsPDF: { unit: 'in', format: 'letter', orientation: 'landscape' }
            })
            .from(contenido)
            .save();
    });
});
