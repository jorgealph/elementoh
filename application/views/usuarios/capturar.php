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
		<div class="panel-heading ui-sortable-handle">Captura de usuario</div>
		<div class="panel-body">
		<form class="form" onsubmit="guardar(this,event);" id="form-captura" name="form-captura">
			<div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                    	<label>Nombres</label>
                    	<input type="hidden" name="id_usuario" id="id_usuario" value="<?=$id_usuario;?>">
                        <input type="text" id="nombres" name="nombres" class="form-control" value="<?=$nombres;?>" data-parsley-required="true">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                    	<label>Apellido paterno</label>
                        <input type="text" id="apellido_paterno" name="apellido_paterno" class="form-control" value="<?=$apellido_paterno;?>" data-parsley-required="true">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                    	<label>Apellido materno</label>
                        <input type="text" id="apellido_materno" name="apellido_materno" class="form-control" value="<?=$apellido_materno;?>">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                    	<label>Puesto</label>
                        <input type="text" id="puesto" name="puesto" class="form-control" value="<?=$puesto;?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                    	<label>Correo</label>
                        <input type="text" id="correo" name="correo" class="form-control" value="<?=$correo;?>" data-parsley-type="email" data-parsley-required="true">
                    </div>
                </div>
                
            </div>
            <?php if($id_usuario == 0){ ?>
            <div class="row">
            	<div class="col-md-4">
                    <div class="form-group">
                    	<label>Password</label>
                        <input type="password" id="password" name="password" class="form-control" value="" data-parsley-required="true">
                    </div>
                </div>
            	<div class="col-md-4">
            		 <div class="form-group">
                    	<label>Confirmar password</label>
	            		<input type="password" id="confirmar_password" name="confirmar_password" class="form-control" data-parsley-equalto="#password" value="" data-parsley-required="true">
	            	</div>
            	</div>
            </div>
            <?php } ?>
            <div class="row">
            	<div class="col-md-4">
                    <div class="form-group">
                    	<label>Rol</label>
                        <select name="id_rol" id="id_rol" class="form-control" min="1">
                        	<?=$options_rol?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
				<div class="col-md-12 text-center">
					<div class="form-group">
						<button class="btn btn-success" id="register-form-submit" name="register-form-submit" value="register">Guardar</button>
                        <button class="btn btn-white" type="button" onclick="buscar(1);">Regresar</button>
					</div>
				</div>
			</div>
		</form>
		</div>
	</div>

</body>

<script type="text/javascript">	

	function guardar(form,event){
        console.log(form.id);
		event.preventDefault();
		var loading;
		if(validarFormulario(form)){
			$.ajax({
		        url: '<?=base_url()?>C_usuarios/guardar',
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
		                	notificacion('Los datos han sido guardados','success');
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