<script language="javascript">

    function sumatoriaSalidasFabrics() {
        var totalRollos = 0, totalMetros = 0;
        $("#ingreso-datos-salida > tbody > tr").each(function(key, value) {
            totalMetros += parseInt($(this).find("td:eq(2) > input").val());
            totalRollos++;
        });
        $("#suma-salidas-fabrics").html('Totales: ' + totalRollos + ' Rollos || ' + totalMetros + ' Metros');
    }

    function eliminarSalida(obj){
        obj.closest("tr").remove();
        sumatoriaSalidasFabrics();
    }

    function iniciarCapturaSalida(){
        var statesDemos = {
            state0: {
                title: 'Capture Codigo',
                html:'<label><input id="codigo-a-buscar-salida">Codigo del Rollo</label>'
                    + '<div id ="metros-opciones"><label><input type="checkbox" id="todo-rollo-salida">Todo el rollo?</label>'
                    + '<label><input id="metros-sa">Metros del rollo</label><label></label>',
                buttons: { Agregar: 1, Listo: 2 },
                focus: 0,
                submit:function(e,v,m,f){

                    if (v === 2) {
                        $.prompt.close();
                    } else {

                        $obj = $(m[0]);
                        var codigo = $obj.find('#codigo-a-buscar-salida').val();
                        var metros = $obj.find('#metros-sa').val();

                        var todoRollo = ($obj.find("#todo-rollo-salida"));

                        if (codigo !== "" && metros !== "" && $.isNumeric(codigo) && $.isNumeric(metros)) {

                            $.ajax({
                                url: 'administrador/movimientos/registroAjax.php',
                                type: 'post',
                                data: { 'codigoBarras': codigo, 'action' : 'entradasKeyUp'},
                                dataType: 'json',
                                success: function (data) {
                                    if (data.success) {

                                        campos = "<tr>"
                                        +"<td><button type='button' class='btn btn-danger' onclick=eliminarSalida($(this))>Eliminar</button><p></td>"
                                        +"<td><input type='hidden' placeholder='Codigo' name='codigo[]' value='" +  data.codigo + "' />" + data.codigo + "</td>"
                                        +"<td><input type='hidden' placeholder='Metros' name='cantidad[]' value='" +  metros + "' />" +  metros + "</td>"
                                        +"<td><input type='hidden' placeholder='Codigo' name='id-art-tela[]' value='" +  data.id_art_telas + "' />" + data.id_art_telas + "</td>"
                                        +"</tr>";

                                        if ($("#form-datos-salidas").find("#ingreso-datos-salida > tbody > tr:eq(0) > td:eq(0)").attr('class') === 'dataTables_empty') {
                                            $("#form-datos-salidas").find("#ingreso-datos-salida > tbody > tr:eq(0)").remove();
                                        }

                                        $("#form-datos-salidas").find("#ingreso-datos-salida > tbody").append(campos);


                                        $("#error-registro-salida").html('');

                                        if (todoRollo.is(':checked')) {
                                            todoRollo.removeAttr('checked');
                                            $obj.find('#metros-sa').removeAttr('readonly');
                                        }

                                        sumatoriaSalidasFabrics();
                                    } else {
                                        alert("Codigo no encontrado, favor de intentar nuevamente");
                                    }

                                    $obj.val('');
                                    $obj.find('#metros-sa').val('');
                                    $obj.find('#metros-sa').focus();

                                },
                                error: function (jqXHR, textStatus, errorThrown){
                                    $("#error-registro-salida").html(JSON.stringify(jqXHR));
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
                $("#codigo-a-buscar-salida").focus();

                var ob = $(this);

                ob.find("#todo-rollo-salida").click(function(){
                    if ($(this).is(':checked')) {
                        ob.find('#metros-sa').attr('readonly', 'readonly');
                        $.ajax({
                            url: 'administrador/movimientos/registroAjax.php',
                            type: 'post',
                            data: { 'codigoBarras': $("#codigo-a-buscar-salida").val(), 'action' : 'todoRollo'},
                            dataType: 'json',
                            success: function (data) {
                                if (data.success) {
                                    ob.find('#metros-sa').val(data.metros);
                                } else {
                                    alert("Codigo no encontrado, favor de intentar nuevamente. " + data.error);
                                }

                            },
                            error: function (jqXHR, textStatus, errorThrown){
                                $("#error-registro-salida").html(JSON.stringify(jqXHR));
                                //alert(textStatus);
                            }
                        });
                    } else {
                        ob.find('#metros-sa').removeAttr('readonly');
                        ob.find('#metros-sa').val('');
                    };
                })
            }
        });

    }

    $(document).ready(function(){
        $('#form-datos-salidas').submit(function(event) {
            var total = []
            $("#ingreso-datos-salida > tbody > tr").each(function(i, item){
                if (i > 0) {
                    total.push($(this).find("td:eq(1)").find('input').val());
                }
            });
            var comp = total.length;
            $.unique(total);
            if (comp !== total.length) {
                alert('Existen codigos repetidos, favor de verificar');
                event.preventDefault();
            }
        });
    });


</script>


<div id="error-registro-salida">

</div>

<form id="form-datos-salidas" action="administrador/movimientos/registro.php" method="POST">

    <input type="hidden" name="tipo-movimiento" class='tipo-movimiento' id="tipo-movimiento" value='salida' />

    <div class="datos">
         <table id="ingreso-datos-salida" class='table'>
            <thead>
                <tr>
                    <th>Acciones</th>
                    <th>Codigo</th>
                    <th>Metros</th>
                    <th>Id Tela</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>

  <p id='acciones-form-datos-salida'><input type="button" onclick="iniciarCapturaSalida();" class="btn btn-primary" value="Agregar" /><p align="right">
    <input type="submit" value="cargar datos" class="btn btn-success" name="nuevoprod" />
    </p>
</form>

<h3 id="suma-salidas-fabrics">Totales: 0 Rollos || 0 Metros</h3>
