window.addEventListener("load", iniciarf);

function iniciarf() {
    // Capturar el elemento HTML con el id costop
    vcosto = document.getElementById("costop");
    // Capturar el elemento HTML con el id porcentajev
    vporcentaje = document.getElementById("porcentajev");
    vimage = document.getElementById("simagen");
    // Preparar el evento input del objeto vcosto
    vcosto.addEventListener("input", mostrarpventa);
    vporcentaje.addEventListener("input", mostrarpventa);
    vimage.addEventListener("input", mostrarImagen);
}

function calcularPorcentaje(costof, porcentajef) {
    // Realizar el cálculo del porcentaje
    let TantoTotal = costof * (porcentajef / 100);
    // Calcular el precio de venta
    let PVenta = parseFloat(costof) + parseFloat(TantoTotal);
    // Retornar el precio de venta a la función
    return PVenta;
}

function mostrarpventa() {
    // Si el costo y el porcentaje son distintos de vacío entonces
    if (vcosto.value !== "" && vporcentaje.value !== "") {
        // Convertir los valores a números
        let costoNum = parseFloat(vcosto.value);
        let porcentajeNum = parseFloat(vporcentaje.value);
        
        // Verificar que los valores sean números válidos
        if (!isNaN(costoNum) && !isNaN(porcentajeNum)) {
            // Llamar a la función calcularPorcentaje y almacenar el resultado en la variable calculo
            let calculo = calcularPorcentaje(costoNum, porcentajeNum);
            // Mostrar el precio de venta
            document.getElementById("pventa").value = calculo;
        } else {
            // Limpiar el campo con el id pventa si los valores no son válidos
            document.getElementById("pventa").value = "";
        }
    } else {
        // Si no se ingresó el costo o el porcentaje entonces
        // Limpiar el campo con el id pventa
        document.getElementById("pventa").value = "";
    }
}

function mostrarImagen() {
    var verimagen = document.querySelector('img');
    var archivof = document.querySelector('input[type=file]').files[0];
    var leerarchivo = new FileReader();
    leerarchivo.onload = function() {
        verimagen.src = leerarchivo.result;
    }
    if (archivof) {
        leerarchivo.readAsDataURL(archivof);
    } else {
        verimagen.src = "";
    }
}
function mostrarProducto(produc) {
    if (produc.length == 0) { //Si no se ha introducido ningún id del producto
        //Mostrar en producto "Producto no seleccionado"
        document.getElementById("nompro").value = "Producto no seleccionado";
        return; //Salir de la función
    }

    //Declarar el objeto fnproducto de tipo XMLHttpRequest
    var fnproducto = new XMLHttpRequest();

    //Ejecutar esta función anónima dependiendo del valor de onreadystatechange
    fnproducto.onreadystatechange = function() {
        //Si el valor readyState es 4 y el de stadus es 200 entonces
        if (this.readyState == 4 && this.status == 200) {
            //Mostrar el valor devuelto en el como Producto
            document.getElementById("nompro").value = this.responseText;
        }
    }

    //Enviar el id del producto a través de la variable dato y método get
    //al archivo conProductoId.php
    fnproducto.open("GET", "conProductoId.php?dato=" + produc, true);
    fnproducto.send();
}
