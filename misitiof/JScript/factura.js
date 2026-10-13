$(function () {

    $('#btnNueva').click(function () {
    $.ajax({
        url: 'obtenerfacturamax.php',
        dataType: 'json',
        success: function (varfacturas) {
            if (Array.isArray(varfacturas)) {
            let varultimafac = "";
            varfacturas.forEach(varfacturas => {
                varultimafac = varfacturas.ultimafactura;
            });
                if (varultimafac > 0) {
                    let nuevafactura = Number(varultimafac) + 1;
                    $("#numfacturar").val(nuevafactura);
                    $("#numfactura").text(nuevafactura);
                } else {
                    $("#numfactura").text("1000");
                    $("#numfacturar").val("1000");
                }
            }
        }
    })
});

    $("#btn2").click(function () {
        //Declaracion de variables
        let codproducto = $("#codpro").val();
        let canproducto = $("#cantpro").val();
        let nomproducto = $("#despro").val();
        let preproducto = $("#prepro").val();
        let todproducto = $("#totpro").val();
        let subtota = $("#sutotalfact").val();

        //Creo una nueva fila
        var fila = '<tr class="w3-hover-green">' +
        '<td style="width: 10%;"><input type="text" id="Id_Producto[]" value=' + codproducto +
        ' name="Id_Producto[]" class="w3-input w3-border w3-sand"></td>' +
        '<td style="width: 10%;"><input type="text" value=' + canproducto +
        ' name="Cantidad[]" class="w3-input w3-border w3-sand"></td>' +
        '<td style="width: 50%;"><input type="text" value=' + nomproducto +
        ' name="Descripcion[]" class="w3-input w3-border w3-sand"></td>' +
        '<td style="width: 15%;"><input type="text" value=' + preproducto +
        ' name="Precio[]" class="w3-input w3-border w3-sand"></td>' +
        '<td style="width: 15%;"><input type="text" value=' + todproducto +
        ' name="Total[]" class="w3-input w3-border w3-sand"></td></tr>';

        //Añado fila a la tabla
        $('.tabla').append(fila);
        $("#codpro").val("");
        $("#cantpro").val("");
        $("#despro").val("");
        $("#prepro").val("");
        $("#totpro").val("");

        let numer1 = Number(todproducto);
        let numer2 = Number(subtota);
        calcularTotales(numer1, numer2)
    });

    function calcularTotales(total, subtoalactual) {
        //Calcular el nuevo subtotal
        let nuevosubtotal = parseFloat(subtoalactual) + parseFloat(total);
        //Realizar el calculo del impuesto
        let impuesto = nuevosubtotal * (15 / 100);
        //Realizar el calculo del total a pagar
        let grantotal = parseFloat(nuevosubtotal) + parseFloat(impuesto);
        //Mostrar los resultados
        $("#sutotalfact").val(nuevosubtotal);
        $("#impuestofact").val(impuesto);
        $("#todpagarfact").val(grantotal);
    }

    $('#cod_cliente').keyup(function () { 
        if ($('#cod_cliente').val()) {
            let buscarcliente = $('#cod_cliente').val();
            $.ajax({
                url: 'buscarclientes.php',
                data: {
                    buscarcliente
                },
                type: 'POST',
        dataType: 'json',
        success: function (varclientes) {
                    if (Array.isArray(varclientes)) {
                        let varnomcliente = "";
                        varclientes.forEach(varclientes => {
                            varnomcliente = varclientes.nombrecliente;
                        });
                        if (varnomcliente) {
                            $("#nomcliente").val(varnomcliente);
                        }
                    }
                }
            })
        }
        $("#nomcliente").val("");
    })
    
    $('#cantpro').keyup(function () {
        //Asignar los valores de los inputs a las variables
        let varcant = $("#cantpro").val();
        let varprepro = $("#prepro").val();
        //Realizar el calculo
        let vartotal = varprepro * varcant;
        //Mostrar el resultado en el input totpro
        $("#totpro").val(vartotal);
    })

    $('#codpro').keyup(function () {
        if($('#codpro').val()) {
            let producto = $('#codpro').val();
            $.ajax({
                url: 'buscarproducto.php',
                data: {
                    producto
                },
                type: 'POST',
                    dataType: 'json',
                    success: function (varproductos) {
                    if (Array.isArray(varproductos)) {
                        let varnomproducto = "";
                        let varpreciopro = "";
                        varproductos.forEach(varproductos => {
                            varnomproducto = varproductos.nomproducto;
                            varpreciopro = varproductos.preproducto;
                        });
                        if (varpreciopro) {
                            $("#prepro").val(varpreciopro);
                            $("#despro").val(varnomproducto);
                        }
                    }
                }
            })
            $("#prepro").val("");
            $("#despro").val("");
        }
    });
});
