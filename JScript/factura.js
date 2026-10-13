$(function () {
    let solicitudCliente;
    let solicitudProducto;

    $('#codcliente').on('input', function () {
        const codigo = $(this).val().trim();
        $('#nomcliente').val('');
        if (solicitudCliente) solicitudCliente.abort();
        if (!codigo) return;
        solicitudCliente = $.ajax({
            url: 'buscarclientes.php', type: 'POST', dataType: 'json',
            data: { buscarcliente: codigo }
        }).done(function (clientes) {
            if (clientes.length) $('#nomcliente').val(clientes[0].nombreCliente);
        });
    });

    $('#codpro').on('input', function () {
        const codigo = $(this).val().trim();
        $('#despro, #prepro, #totpro').val('');
        if (solicitudProducto) solicitudProducto.abort();
        if (!codigo) return;
        solicitudProducto = $.ajax({
            url: 'buscarproducto.php', type: 'POST', dataType: 'json',
            data: { producto: codigo }
        }).done(function (productos) {
            if (productos.length) {
                $('#despro').val(productos[0].nomproducto);
                $('#prepro').val(productos[0].preproducto);
                calcularTotalProducto();
            }
        });
    });

    $('#cantpro, #prepro').on('input change', calcularTotalProducto);
    $('#btn2').on('click', agregarProducto);
    $('#btnNueva').on('click', function () { window.location.href = 'frmFactura.php'; });
    $('#formFactura').on('submit', function (evento) {
        if (!$('#codcliente').val() || !$('#nomcliente').val()) {
            evento.preventDefault(); alert('Escriba un código de cliente válido.'); return;
        }
        if (!$('#tablaFactura tbody tr').length) {
            evento.preventDefault();
        }
    });
});

function calcularTotalProducto() {
    const cantidad = Number($('#cantpro').val()) || 0;
    const precio = Number($('#prepro').val()) || 0;
    const subtotal = cantidad * precio;
    $('#totpro').val(Number.isFinite(subtotal) && cantidad > 0 && precio >= 0 ? subtotal.toFixed(2) : '');
}

function agregarProducto() {
    const codigo = $('#codpro').val().trim();
    const cantidad = Number($('#cantpro').val());
    const precio = Number($('#prepro').val());
    const nombre = $('#despro').val();
    if (!codigo || !nombre || !Number.isInteger(cantidad) || cantidad <= 0 || !Number.isFinite(precio) || precio < 0) {
    return;
    }
    const fila = $('<tr>');
    fila.append($('<td>').text(codigo).append($('<input>', { type: 'hidden', name: 'productos[]', value: codigo })));
    fila.append($('<td>').text(cantidad).append($('<input>', { type: 'hidden', name: 'cantidades[]', value: cantidad })));
    fila.append($('<td>').text(nombre));
    fila.append($('<td>').text(precio.toFixed(2)));
    fila.append($('<td class="subtotal-fila">').text((cantidad * precio).toFixed(2)));
    fila.append($('<td>').append($('<button type="button" class="quitar-producto">Quitar</button>')));
    $('#tablaFactura tbody').append(fila);
    fila.find('.quitar-producto').on('click', function () { fila.remove(); calcularTotalesFactura(); });
    $('#codpro, #cantpro, #despro, #prepro, #totpro').val('');
    calcularTotalesFactura();
}

   let subtotal = 0;
    $('#tablaFactura tbody .subtotal-fila').each(function () { subtotal += Number($(this).text()) || 0; });
    const iva = subtotal * 0.15;
    $('#subtotalfact').val(subtotal.toFixed(2));
    $('#impuestofact').val(iva.toFixed(2));
    $('#todpagarfact').val((subtotal + iva).toFixed(2));
    $('#cod_cliente').keyup(function () {
    if ($('cod_cliente ').val()) {
        let buscarcliente = $('cod_cliente').val();
        $.ajax({
            url: 'buscarclientes.php',
            data: { 
                buscarcliente
             
    },
    type: 'POST',
    success: function (response) {
        if (!response.error) {
            let varnomcliente = "";
            let varclientes = JSON.parse(response);
            varclientes.forEach(cliente => {
                varnomcliente = cliente.nombreCliente;
            });
            if (varnomcliente) {
            $('#nom_cliente').val(varnomcliente);
        }
}
        }
    })
 
}
$("nom_cliente").val("");

})
