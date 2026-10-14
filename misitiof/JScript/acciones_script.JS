window.addEventListener("DOMContentLoaded", iniciarf);

function iniciarf() {
    const costo = document.getElementById("costop");
    const porcentaje = document.getElementById("porcentajev");
    const imagen = document.getElementById("simagen");

    if (costo) costo.addEventListener("input", mostrarpventa);
    if (porcentaje) porcentaje.addEventListener("input", mostrarpventa);
    if (imagen) imagen.addEventListener("input", mostrarImagen);
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
    const vcosto = document.getElementById("costop");
    const vporcentaje = document.getElementById("porcentajev");
    const salida = document.getElementById("pventa");
    if (!vcosto || !vporcentaje || !salida) return;

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
            salida.value = calculo.toFixed(2);
        } else {
            // Limpiar el campo con el id pventa si los valores no son válidos
            salida.value = "";
        }
    } else {
        // Si no se ingresó el costo o el porcentaje entonces
        // Limpiar el campo con el id pventa
        salida.value = "";
    }
}

function mostrarImagen() {
    const entrada = document.getElementById("simagen");
    const verimagen = document.querySelector("#csimagen img");
    if (!entrada || !verimagen) return;
    const archivof = entrada.files[0];
    var leerarchivo = new FileReader();
    leerarchivo.onload = function() {
        verimagen.src = leerarchivo.result;
    }
    if (archivof) {
        leerarchivo.readAsDataURL(archivof);
    } else {
        verimagen.removeAttribute("src");
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
    fnproducto.open("GET", "conProductoId.php?dato=" + encodeURIComponent(produc), true);
    fnproducto.send();
}
