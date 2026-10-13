window.addEventListener("load",iniciarf);
function iniciarf() {
    //Capturar el elemento HTML con el id costop
    vcosto = document.getElementById("costop");
    //Capturar el elemento HTML con el id porcentajev
    vporcentaje = document.getElementById("porcentajev");
    vimage = document.getElementById("simagen");
    //Preparar el evento input del objeto vcosto
    vcosto.addEventListener("input", mostrarpventa);
    vporcentaje.addEventListener("input", mostrarpventa);
    vimage.addEventListener("input", mostrarImagen);
}
function calcularPorcentaje(costof, porcentajef) {
    //Realizar el calculo del porcentaje
    let TantoTotal = costof * (porcentajef / 100);
    //Calcular el precio de venta
    let PVenta = parseFloat(costof) + parseFloat(TantoTotal);
    //Retornar el precio de venta a la funcion
    return PVenta;
}
function mostrarpventa() {
    //Si el costo y el porcentaje es distinto de vacio entonces
    if (vcosto.value != "" && vporcentaje.value != "") {
        //Lamar a la funcion calcularPorcentaje y almacenar el
        //Resultado en la variable calculo
        let calculo = calcularPorcentaje(vcosto.value, vporcentaje.value);
        //Mostrar el precio de venta
        document.getElementById("pventa").value = calculo;

    }else {//Si no se ingreso el costo o el porcentaje entonces
        //Limpiar el campo con el id pventa
        document.getElementById("pventa").value = "";
    }
}
function mostrarImagen() {
    /*Asignar la etiqueta img a la variable verimagen */
    var verimagen = document.querySelector('img');
    /*Asignar el input de tipo file a la variable archivof */
    var archivof = document.querySelector('input[type=file]').files[0];
    /*Asignar el archivo leido a la variable leerarchivo */
    var leerarchivo = new FileReader();
    /*Ejecutar la funcion anonima cuando el archivo se cargue*/
    leerarchivo.onloadend = function () {
        /*Asignar la direccion del archivo al atributo src de img.
        para mostrar la imagen cargada */
        verimagen.src = leerarchivo.result;
    }
    /*Si existen datos en la variable archivof entonces*/
    if (archivof) {
        /*Asignar la direccion de la variable archivof a la varible leerarchivo*/
        leerarchivo.readAsDataURL(archivof);
    }else{/*Si no existen datos en la variable archivof, entonces */
        /*Asignar un valor vacio al atributo src de img */
        verimagen.src = "";
    }
}

function mostrarProducto(produc) {
    if (produc.length == 0) { //Si no se ha introducido ningun id del producto
        //Mostrar en producot "Producto no seleccionado"
        document.getElementById("nompro").value = "Producto no seleccionado";
        return; //Salir de la funcion
    }
    //Declarar el objeto fnproducto de tipo XMLHttpRequest
    var fnproducto = new XMLHttpRequest();
    //Ejecutar esta funcion anonima dependiendo del valor de onreadystatechange
    fnproducto.onreadystatechange = function() {
        //Si el valor readyState es 4 y el de stadus es 200 entonces
        if (this.readyState == 4 && this.status == 200) {
            //Mostrar el valor devuelto en el como Producto
            document.getElementById("nompro").value = this.responseText;
        }
    }
    //Enviar el id del producto a traves de la variable dato y metodo get
    //al archivo conProductoId.php
    fnproducto.open("GET", "conProductoId.php?dato=" + produc, true);
    fnproducto.send();
}