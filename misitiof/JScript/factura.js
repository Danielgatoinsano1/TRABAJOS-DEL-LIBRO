$(function () {
    let timerCliente = null;
    let peticionCliente = null;
    let timerProducto = null;
    let peticionProducto = null;

    $('#btnNueva').on('click', function () {
        const tieneProductos = $('.tabla .factura-linea').length > 0;
        const tieneCliente = $('#cod_cliente').val().trim() !== '';
        const tieneProductoEnCaptura = $('#codpro').val().trim() !== '';
        const tieneBorrador = tieneProductos || tieneCliente || tieneProductoEnCaptura;

        const boton = $(this);
        boton.prop('disabled', true);
        $.ajax({ url: 'obtenerfacturamax.php', dataType: 'json' })
            .done(function (facturas) {
                mostrarEstadoFactura('');
                const ultimo = Number(facturas?.[0]?.ultimafactura) || 999;
                const numeroActual = Number($('#numfacturar').val()) || 999;
                const numero = Math.max(ultimo + 1, numeroActual + (tieneBorrador ? 1 : 0));
                $('#numfacturar').val(numero);
                $('#numfactura').text(numero);
                $('#vistaPreviaFactura').show();
            })
            .fail(function () { mostrarEstadoFactura('No se pudo obtener el número de factura.'); })
            .always(function () { boton.prop('disabled', false); });
    });

    $('#btn2').on('click', agregarProducto);

    $('#cod_cliente').on('input', function () {
        const codigo = this.value.trim();
        $('#nombrecliente').val('');
        window.clearTimeout(timerCliente);
        if (peticionCliente) peticionCliente.abort();
        if (!/^\d+$/.test(codigo)) return;

        timerCliente = window.setTimeout(function () {
            peticionCliente = $.ajax({
                url: 'buscarclientes.php',
                method: 'POST',
                dataType: 'json',
                data: { buscarcliente: codigo }
            }).done(function (clientes) {
                if ($('#cod_cliente').val().trim() !== codigo) return;
                const nombre = clientes?.[0]?.nombrecliente || '';
                $('#nombrecliente').val(nombre);
            }).fail(function (xhr, estado) {
                if (estado !== 'abort' && $('#cod_cliente').val().trim() === codigo) {
                    $('#nombrecliente').val('');
                }
            });
        }, 250);
    });

    $('#codpro').on('input', function () {
        const codigo = this.value.trim();
        $('#prepro, #despro, #totpro').val('');
        actualizarTotalesFactura();
        window.clearTimeout(timerProducto);
        if (peticionProducto) peticionProducto.abort();
        if (!/^\d+$/.test(codigo)) return;

        timerProducto = window.setTimeout(function () {
            peticionProducto = $.ajax({
                url: 'buscarproducto.php',
                method: 'POST',
                dataType: 'json',
                data: { producto: codigo }
            }).done(function (productos) {
                if ($('#codpro').val().trim() !== codigo) return;
                const producto = productos?.[0];
                if (!producto) return;
                $('#prepro').val(producto.preproducto).trigger('input');
                $('#despro').val(producto.nomproducto);
                calcularTotalProducto();
            });
        }, 250);
    });

    $('#cantpro, #prepro').on('input', calcularTotalProducto);

    $('#formFactura').on('submit', function (event) {
        const tieneProductos = $('.tabla .factura-linea').length > 0;
        const productoPendiente = $('#codpro').val().trim() !== '';
        if (!$('#numfacturar').val() || !tieneProductos) {
            event.preventDefault();
            mostrarEstadoFactura('Genera el número de factura y agrega al menos un producto.');
        } else if (productoPendiente) {
            event.preventDefault();
            mostrarEstadoFactura('Agrega a la factura el producto que estás capturando antes de guardar.');
        } else if (!$('#cod_cliente').val() || !$('#nombrecliente').val()) {
            event.preventDefault();
            mostrarEstadoFactura('Ingresa el código de un cliente existente.');
        } else {
            mostrarEstadoFactura('');
        }
    });
});

function calcularTotalProducto() {
    const cantidad = Number($('#cantpro').val());
    const precioTexto = $('#prepro').val();
    const precio = Number(precioTexto);
    const total = cantidad * precio;
    $('#totpro').val(precioTexto !== '' && Number.isFinite(total) && cantidad > 0 ? total.toFixed(2) : '');
}

function agregarProducto() {
    if (!$('#numfacturar').val()) {
        mostrarEstadoFactura('Primero inicia una factura.');
        return;
    }

    const codigo = $('#codpro').val().trim();
    const cantidad = Number($('#cantpro').val());
    const descripcion = $('#despro').val().trim();
    const precio = Number($('#prepro').val());
    const total = cantidad * precio;
    if (!/^\d+$/.test(codigo) || !Number.isInteger(cantidad) || cantidad < 1
        || !descripcion || !Number.isFinite(precio) || precio < 0 || !Number.isFinite(total)) {
        mostrarEstadoFactura('Selecciona un producto e indica una cantidad mayor que cero.');
        return;
    }

    const fila = $('<tr class="w3-hover-green factura-linea"></tr>');
    const celdaId = $('<td></td>').text(codigo);
    celdaId.append($('<input type="hidden">').attr('name', 'Id_Producto[]').val(codigo));
    fila.append(celdaId);
    const campos = [
        ['Cantidad[]', cantidad],
        ['Descripcion[]', descripcion],
        ['Precio[]', precio.toFixed(2)],
        ['Total[]', total.toFixed(2)]
    ];
    campos.forEach(([nombre, valor]) => {
        const celda = $('<td></td>').text(valor);
        const entrada = $('<input type="hidden">').attr('name', nombre).val(valor);
        celda.append(entrada);
        fila.append(celda);
    });

    $('#filaFacturaVacia').hide();
    $('.tabla').append(fila);
    $('#vistaPreviaFactura').show();
    mostrarEstadoFactura('');
    $('#codpro, #cantpro, #despro, #prepro, #totpro').val('');
    actualizarTotalesFactura();
}

function mostrarEstadoFactura(mensaje) {
    const estado = $('#estadoFactura');
    estado.text(mensaje);
    estado.toggle(mensaje !== '');
}

function actualizarTotalesFactura() {
    let subtotal = 0;
    $('.factura-linea input[name="Total[]"]').each(function () {
        const totalLinea = Number($(this).val());
        if (Number.isFinite(totalLinea)) subtotal += totalLinea;
    });

    subtotal = Number(subtotal.toFixed(2));
    const impuesto = Number((subtotal * 0.15).toFixed(2));
    const granTotal = Number((subtotal + impuesto).toFixed(2));
    $('#subtotalfact').val(subtotal.toFixed(2));
    $('#impuestofact').val(impuesto.toFixed(2));
    $('#todpagarfact').val(granTotal.toFixed(2));
}
