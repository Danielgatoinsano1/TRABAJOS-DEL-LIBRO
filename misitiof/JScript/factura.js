$(function () {
    $('#codpro').on('keyup', function () {
        const producto = $(this).val().trim();

        if (producto === '') {
            $('#despro, #prepro, #totpro').val('');
            return;
        }

        $.ajax({
            url: 'buscarproducto.php',
            data: { producto: producto },
            type: 'POST',
            dataType: 'json',
            success: function (response) {
                if (!response.error && response.length > 0) {
                    const productoEncontrado = response[0];
                    $('#prepro').val(productoEncontrado.preproducto);
                    $('#despro').val(productoEncontrado.nomproducto);
                    calcularTotalProducto();
                } else {
                    $('#despro, #prepro, #totpro').val('');
                }
            },
            error: function () {
                $('#despro, #prepro, #totpro').val('');
            }
        });
    });

    $('#cantpro').on('input keyup', calcularTotalProducto);
});

function calcularTotalProducto() {
    const cantidad = Number($('#cantpro').val());
    const precio = Number($('#prepro').val());
    const total = cantidad * precio;

    $('#totpro').val(Number.isFinite(total) && cantidad > 0 ? total.toFixed(2) : '');
}
