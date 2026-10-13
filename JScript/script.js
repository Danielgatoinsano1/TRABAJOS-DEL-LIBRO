window.addEventListener("load", iniciarf);
function iniciarf() {
    //Capturar el evento click del boton btnPdf y ejecutar la funcion crearPDF()
    btnPdf.addEventListener("click", crearPDF);
}
function crearPDF(){
    //Capturar el elemento HTML, en este ejemplo se
    //captura el body y se asigna a la constante elementoHTMLaConvertir
    const $elementoHTMLaConvertir = document.body;
    html2pdf() //Inicializar el proceso de configuracion
        .set({
            margin: 0,
            filename: 'facturaFares.pdf',
            image: { type: 'jpeg', quality: 0.98
            },
            html2canvas: { scale: 1, letterRendering: true, },
            jsPDF: { unit: "in", format: "letter", orientation: 'landscape'}
        })
        .from($elementoHTMLaConvertir) //Asignar el elemento a convertir
        .save() //Guardar el documento
}