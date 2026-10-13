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
                $('#sutotalfact, #impuestofact, #todpagarfact').val('0.00');
                $('#cod_cliente, #nomcliente').val('');
            })
            .fail(function () { alert('No se pudo obtener el número de factura.'); })
            .always(function () { boton.prop('disabled', false); });
    });

    $('#btn2').on('click', function () {
        const codigo = $('#codpro').val().trim();
        const cantidad = $('#cantpro').val().trim();
        const nombre = $('#despro').val().trim();
        const precio = Number($('#prepro').val());
        const total = Number($('#totpro').val());
        if (!/^\d+$/.test(codigo) || !/^\d+$/.test(cantidad) || Number(cantidad) < 1 || !nombre
            || !Number.isFinite(precio) || precio < 0 || !Number.isFinite(total) || total < 0) {
            alert('Escribe el código de un producto existente, una cantidad y comprueba su precio.');
            return;
        }

        const fila = $('<tr class="w3-hover-green"></tr>');
        [
            [codigo, 'Id_Producto[]'], [cantidad, 'Cantidad[]'], [nombre, 'Descripcion[]'],
            [precio.toFixed(2), 'Precio[]'], [total.toFixed(2), 'Total[]']
        ].forEach(function ([valor, campo]) {
            const entrada = $('<input type="text" class="w3-input w3-border w3-sand" readonly>')
                .attr('name', campo).val(valor);
            $('<td></td>').append(entrada).appendTo(fila);
        });
        $('.tabla').append(fila);
        calcularTotales(total, Number($('#sutotalfact').val()) || 0);
        $('#codpro, #cantpro, #despro, #prepro, #totpro').val('');
    });

    function calcularTotales(total, subtotalActual) {
        const subtotal = Number((subtotalActual + total).toFixed(2));
        const impuesto = Number((subtotal * 0.15).toFixed(2));
        $('#sutotalfact').val(subtotal.toFixed(2));
        $('#impuestofact').val(impuesto.toFixed(2));
        $('#todpagarfact').val((subtotal + impuesto).toFixed(2));
    }

    $('#cod_cliente').on('input', function () {
        const codigo = this.value.trim();
        $('#nomcliente').val('');
        clearTimeout(timerCliente);
        if (peticionCliente) peticionCliente.abort();
        if (!/^\d+$/.test(codigo)) return;
        timerCliente = setTimeout(function () {
            peticionCliente = $.ajax({
                url: 'buscarclientes.php', method: 'POST', dataType: 'json', data: { buscarcliente: codigo }
            }).done(function (clientes) {
                if ($('#cod_cliente').val().trim() !== codigo) return;
                $('#nomcliente').val(clientes?.[0]?.nombrecliente || '');
            }).fail(function (xhr, estado) {
                if (estado !== 'abort') $('#nomcliente').val('');
            });
        }, 250);
    });

    $('#codpro').on('input', function () {
        const codigo = this.value.trim();
        $('#prepro, #despro, #totpro').val('');
        clearTimeout(timerProducto);
        if (peticionProducto) peticionProducto.abort();
        if (!/^\d+$/.test(codigo)) return;
        timerProducto = setTimeout(function () {
            peticionProducto = $.ajax({
                url: 'buscarproducto.php', method: 'POST', dataType: 'json', data: { producto: codigo }
            }).done(function (productos) {
                if ($('#codpro').val().trim() !== codigo) return;
                const producto = productos?.[0];
                if (producto) $('#prepro').val(producto.preproducto).trigger('input');
                if (producto) $('#despro').val(producto.nomproducto);
            });
        }, 250);
    });

    $('#cantpro').add('#prepro').on('input', function () {
        const cantidad = Number($('#cantpro').val());
        const precio = Number($('#prepro').val());
        $('#totpro').val(Number.isFinite(cantidad * precio) ? (cantidad * precio).toFixed(2) : '');
    });

    $('form[action="guardarfactura.php"]').on('submit', function (evento) {
        if (!$('#numfacturar').val() || !$('#cod_cliente').val().trim() || !$('.tabla input[name="Id_Producto[]"]').length) {
            evento.preventDefault();
            alert('Inicia una factura, selecciona un cliente y agrega al menos un producto.');
        }
    });
});
