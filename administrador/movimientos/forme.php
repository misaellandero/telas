<script language="javascript">

    function sumatoriaEntradasFabrics() {
        var totalRollos = 0, totalMetros = 0;
        $("#ingreso-datos > tbody > tr").each(function(key, value) {
            totalMetros += parseFloat($(this).find("td:eq(2) > input").val());
            totalRollos++;
        });
        $("#suma-entradas-fabrics").html('Totales: ' + totalRollos + ' Rollos || ' + totalMetros + ' Metros');
    }

    function eliminarEntrada(obj){
        obj.closest("tr").remove();
        sumatoriaEntradasFabrics();
    }

    function verificarCodigo(codigo){
        var contador = 0;
        $("#form-datos").find("#ingreso-datos > tbody > tr").each(function(){

            if (typeof($(this).find("td:eq(1) span.valor-codigo").html()) !== "undefined") {

                if ($(this).find("td:eq(1) span.valor-codigo").html().substring(0,6) === codigo) {
                    contador = $(this).find("td:eq(1) span.valor-codigo").html().substr(9,3);
                }
            } else {
                $(this).remove();
            }
        });

        return parseFloat(contador) + 1;
    }

    function iniciarCapturaEntrada(){
        var statesDemos = {
            state0: {
                title: 'Capture Codigo',
                html:'<label><input id="codigo-a-buscar">Codigo De Tela</label>'
                    + '<label><input id="metros-en" >Metros del Rollo</label>'
                    + '<label><input id="detalles-en">Detalles</label><label></label>',

                buttons: { Agregar: 1, Listo: 2 },
                focus: 0,
                submit:function(e, v, m, f){

                    if (v === 2) {
                        $.prompt.close();
                    } else {

                        $obj = $(m[0]);
                        codigo = $obj.find('#codigo-a-buscar').val();
                        metros = $obj.find('#metros-en').val();
                        var detalles = $obj.find('#detalles-en').val();
                        if (codigo !== "" && metros !== "" && $.isNumeric(codigo) && metros > 0) {

                            $.ajax({
                                url: 'administrador/movimientos/registroAjax.php',
                                type: 'post',
                                data: { 'codigoBarras': codigo, 'action' : 'entradas'},
                                dataType: 'json',
                                success: function (data) {
                                    if (data.success) {
                                        if (metros !== ""  && $.isNumeric(metros)) {
                                            var diff = 1;

                                            if (verificarCodigo(codigo) > parseFloat(data.contador)) {
                                                diff = verificarCodigo(codigo) - parseFloat(data.contador);
                                            }

                                            var consecutivo = parseFloat(data.contador) + diff;
                                            if (consecutivo.toString().length === 1) {consecutivo = '00' + consecutivo;} else
                                            if (consecutivo.toString().length === 2) {consecutivo = '0' + consecutivo;}

                                            var codi = codigo + parseInt(metros) + consecutivo;


                                            campos = "<tr>"
                                            +"<td><button type='button' class='btn btn-danger' onclick=eliminarEntrada($(this))>Eliminar</button><p></td>"
                                            +"<td><input type='hidden' class='codigo-barras-keyup' name='codigo[]' value='" +  codi + "' /><span class='valor-codigo'>" + codi + "</span></td>"
                                            +"<td><input type='hidden' name='cantidad[]' value='" +  metros + "' />" +  metros + "</td>"
                                            +"<td><input type='hidden' name='cadetalles[]' value='" +  detalles + "' />" +  detalles + "</td>"
                                            +"<td><input type='hidden' name='id-art-tela[]' value='" +  data.id_art_telas + "' />" + data.id_art_telas + "</td>"
                                            +"<td><div class='codigo-imagen'/></div></td>"
                                            +"</tr>";

                                            $("#form-datos").find("#ingreso-datos > tbody").append(campos);

                                            var ob = $("#form-datos").find("#ingreso-datos > tbody > tr:last");
                                            var $this = ob.find(".codigo-barras-keyup"),
                                            text = $this.val(),
                                            filtered = "",
                                            c = '';
                                            for(var i=0; i<text.length; i++){
                                              c = text.charAt(i);
                                              if ( (c >= '0') && (c <= '9') ){
                                                filtered += c;
                                              }
                                            }
                                            $this.val(filtered);
                                            ob.find('.codigo-imagen').barcode(filtered, "ean13");
                                            var nuevoValor = ob.find('.codigo-imagen').find("div").last().html()
                                            ob.find(".codigo-barras-keyup").val(nuevoValor);
                                            ob.find(".valor-codigo").html(nuevoValor);

                                            $obj.find('#metros-en').val('');
                                            $obj.find('#metros-en').focus();

                                            $("#error-registro").html('');

                                            sumatoriaEntradasFabrics();
                                        } else {
                                            alert("Numero de metros no valido, solo se permiten numeros y 3 caracteres como maximo");
                                            $obj.find('#metros-en').val('');
                                            $obj.find('#metros-en').focus();
                                        }
                                    } else {
                                        alert("Codigo no encontrado, favor de intentar nuevamente");
                                        $obj.find('#codigo-a-buscar').val('');
                                        $obj.find('#metros-en').val('');

                                        $obj.find('#codigo-a-buscar').focus();
                                    }

                                },
                                error: function (jqXHR, textStatus, errorThrown){
                                    $("#error-registro").html(JSON.stringify(jqXHR));
                                    //alert(textStatus);
                                }
                            });
                        } else {
                            alert("Codigo o metros no valido, favor de verificar");
                        }

                    e.preventDefault();

                    }

                }
            }

        }

        $.prompt(statesDemos, {
            loaded: function(){
                $("#codigo-a-buscar").focus();
            }
        });

    }

</script>


<div id="error-registro">

</div>

<form id="form-datos" action="administrador/movimientos/registro.php" method="POST">

    <input type="hidden" name="tipo-movimiento" class='tipo-movimiento' id="tipo-movimiento" value='entrada' />

    <div class="datos">
        <table id="ingreso-datos" class='table'>
            <thead>
                <tr>
                    <th>Acciones</th>
                    <th>Codigo</th>
                    <th>Metros</th>
                    <th>Detalles</th>
                    <th>Id Tela</th>
                    <th>Imagen Codigo</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>

    <p id='acciones-form-datos'><input type="button" onclick="iniciarCapturaEntrada();" class="btn btn-primary" value="Agregar" /><p align="right">
      <input type="submit" value="cargar datos" class="btn btn-success" name="nuevoprod" />
    </p>
</form>

<h3 id="suma-entradas-fabrics">Totales: 0 Rollos || 0 Metros</h3>
