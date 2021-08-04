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
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<h4 class="card-title">Buscar propiedades</h4>
					<form action="#" id="formbusqueda">
                        <div class="form-body">
                            <div class="row">
                            	<div class="col-md-10">
                            		<label>Nombre</label>
                            		<div class="input-group mb-12">
                                        <input type="text" class="form-control" name="texto_busqueda" id="texto_busqueda" placeholder="" aria-label="" aria-describedby="basic-addon1">
                                        <div class="input-group-append">
                                            <button class="btn btn-info" type="submit" onclick="buscar(0,event);"><i class="ti-search"></i>&nbsp;Buscar</button>
                                        </div>
                                    </div>
                            	</div>
                            	<div class="col-md-2">
                        			<button class="btn btn-success" type="button" onclick="capturar(0);" style="margin-top:25px;">Crear propiedad</button>
                            	</div>
                            </div>
                           
                        </div>
                    </form>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-12">
            <div class="card">
                <div class="card-body" id="contenidomodulo"><?=$tabla_registros?></div>
            </div>
		</div>
	</div>
</body>
<script type="text/javascript">
	function eliminar(id){
        $.post("<?=base_url();?>C_propiedades/eliminar",{id:id},function(resultado,status){
        	if(resultado == "0"){                		
        	 	notificacion('Registro eliminado','success');
        	 	cargar('<?=base_url()?>C_propiedades/index','#contenido');
        	}
    		else notificacion(resultado,'error');					
    	});
	}

	function buscar(pag,e){
        if (!e) { var e = window.event; }
        e.preventDefault();

		var pag = pag || 1;

		var variables = $("#formbusqueda").serialize();
		variables = variables + '&pag=' + pag;

		cargar('<?=base_url();?>C_propiedades/buscar','#contenidomodulo','POST',variables);
	}
    

	function capturar(id){
		var vars = 'id=' + id;
		cargar('<?=base_url();?>C_propiedades/capturar','#contenidomodulo','POST',vars);
	}
</script>
</html>