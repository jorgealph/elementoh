<!DOCTYPE html>
<html lang="es" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
</head>

<body>
	<div class="panel panel panel-inverse">
		<div class="panel-heading ui-sortable-handle">Cambiar password</div>
		<div class="panel-body">
		<form class="form" onsubmit="guardar(this,event);" id="form-captura" name="form-captura">
            <div class="row">
            	<div class="col-md-6">
                    <div class="form-group">
                    	<label>Nuevo password</label>
                        <input type="hidden" name="id_usuario" name="id_usuario" value="<?=$id_usuario?>">
                        <input type="password" id="password" name="password" class="form-control" data-parsley-required="true">
                    </div>
                </div>
            </div>

            <div class="row">
            	<div class="col-md-6">
            		 <div class="form-group">
                    	<label>Confirmar password</label>
	            		<input type="password" id="confirmar_password" name="confirmar_password" class="form-control" data-parsley-equalto="#password" data-parsley-required="true">
	            	</div>
            	</div>
            </div>
            <div class="row">
				<div class="col-md-12 text-center">
					<div class="form-group">
						<button class="btn btn-success" id="register-form-submit" name="register-form-submit" value="register">Guardar</button>
					</div>
				</div>
			</div>
		</form>
		</div>
	</div>

</body>

<script type="text/javascript">	

	function guardar(form,event){
		event.preventDefault();
		var loading;
		if(validarFormulario(form)){
			$.ajax({
		        url: '<?=base_url()?>C_usuarios/actualizar_password',
		        type: 'POST',
		        async: false,	//	Para obligar al usuario a esperar una respuesta
		        data: $(form).serialize(),
		        beforeSend: function(){
		           /*loading = new Loading({
		                discription: 'Espere...',
		                defaultApply: true
		            });*/
		        },
		        error: function(XMLHttpRequest, errMsg, exception){
		            var msg = "Ha fallado la petición al servidor";
		            //loading.out();
		            notificacion(msg);
		        },
		        success: function(htmlcode){
		        	//loading.out();
		        	var cod = htmlcode.split("-");
		        	switch(cod[0]){
		                case "0":
		                	notificacion('Los cambios han sido guardados','success');
		                	buscar(1);
		                    break;
		                default:
		                    notificacion(htmlcode,'error');
		                    break;
		            }
		        }
		    });
		}
	}
</script>
</html>