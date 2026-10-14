$(function () {
    let timerCliente = null;
    let peticionCliente = null;
    let timerProducto = null;
    let peticionProducto = null;

    $('#btnNueva').on('click', function () {
        const boton = $(this);
        boton.prop('disabled', true);
        $.ajax({ url: 'obtenerfacturamax.php', dataType: 'json' })
            .done(function (facturas) {
                const ultimo = Number(facturas?.[0]?.ultimafactura) || 999;
                const numero = ultimo + 1;
                $('#numfacturar').val(numero);
                $('#numfactura').text(numero);
                $('.tabla tr:not(.ajaxTitle)').remove();
                $('#subtotalfact, #impuestofact, #todpagarfact').val('0.00');
                $('#cod_cliente, #nombrecliente').val('');
            })
            .fail(function () { window.alert('No se pudo obtener el numero de factura.'); })
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
                $('#nombrecliente').val(clientes?.[0]?.nombrecliente || '');
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
            });
        }, 250);
    });

    $('#cantpro, #prepro').on('input', calcularTotalProducto);

    $('#formFactura').on('submit', function (event) {
        const tieneProductos = $('.tabla tr:not(.ajaxTitle)').length > 0;
        if (!$('#numfacturar').val() || !tieneProductos) {
            event.preventDefault();
            window.alert('Genera el numero de factura y agrega al menos un producto.');
        } else if (!$('#cod_cliente').val() || !$('#nombrecliente').val()) {
            event.preventDefault();
            window.alert('Ingresa el codigo de un cliente existente.');
        }
    });
});

function calcularTotalProducto() {
    const cantidad = Number($('#cantpro').val());
    const precio = Number($('#prepro').val());
    const total = cantidad * precio;
    $('#totpro').val(Number.isFinite(total) && cantidad > 0 ? total.toFixed(2) : '');
}

function agregarProducto() {
    const codigo = $('#codpro').val().trim();
    const cantidad = Number($('#cantpro').val());
    const descripcion = $('#despro').val().trim();
    const precio = Number($('#prepro').val());
    const total = cantidad * precio;
    if (!/^\d+$/.test(codigo) || !Number.isInteger(cantidad) || cantidad < 1
        || !descripcion || !Number.isFinite(precio) || precio < 0 || !Number.isFinite(total)) {
        window.alert('Selecciona un producto valido e indica una cantidad mayor que cero.');
        return;
    }

    const fila = $('<tr class="w3-hover-green"></tr>');
    const campos = [
        ['Id_Producto[]', codigo, '10%'],
        ['Cantidad[]', cantidad, '10%'],
        ['Descripcion[]', descripcion, '50%'],
        ['Precio[]', precio.toFixed(2), '15%'],
        ['Total[]', total.toFixed(2), '15%']
    ];
    campos.forEach(([nombre, valor, ancho]) => {
        const celda = $('<td></td>').css('width', ancho);
        const entrada = $('<input type="text" class="w3-input w3-border w3-sand" readonly>')
            .attr('name', nombre).val(valor);
        celda.append(entrada);
        fila.append(celda);
    });

    $('.tabla').append(fila);
    calcularTotales(total, Number($('#subtotalfact').val()) || 0);
    $('#codpro, #cantpro, #despro, #prepro, #totpro').val('');
}

function calcularTotales(total, subtotalActual) {
    const nuevoSubtotal = Number((Number(subtotalActual) + Number(total)).toFixed(2));
    const impuesto = Number((nuevoSubtotal * (15 / 100)).toFixed(2));
    const granTotal = Number((nuevoSubtotal + impuesto).toFixed(2));
    $('#subtotalfact').val(nuevoSubtotal.toFixed(2));
    $('#impuestofact').val(impuesto.toFixed(2));
    $('#todpagarfact').val(granTotal.toFixed(2));
}
