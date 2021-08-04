<!DOCTYPE html>
<html lang="es" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Bootstrap File Upload Plugin -->
    <link rel="stylesheet" href="<?=base_url();?>admin/assets/plugins/bs-file/bs-filestyle.css" type="text/css" />
    <style type="text/css">
        .video-responsive {
            position: relative;
            padding-bottom: 56.25%; /* 16/9 ratio */
            padding-top: 30px; /* IE6 workaround*/
            height: 0;
            overflow: hidden;
        }

        .video-responsive iframe,
        .video-responsive object,
        .video-responsive embed {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
    </style>
</head>

<body>

	<div class="panel panel panel-inverse">
		<div class="panel-heading ui-sortable-handle">Captura propiedad</div>
		<div class="panel-body">
		<form class="form" onsubmit="guardar(this,event);" id="form-captura" name="form-captura">
            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <label>Titulo</label>
                        <input type="text" id="titulo" name="titulo" class="form-control" value="<?=$titulo?>" data-parsley-required="true">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <input type="checkbox" name="exclusiva" id="exclusiva" <?=$exclusiva;?>>Propiedad exclusiva
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Descripción</label>
                       <textarea name="descripcion" id="descripcion" class="form-control" data-parsley-required="true"><?=$descripcion?></textarea>
                    </div>
                </div>
            </div>

			<div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Tipo de propiedad</label>
                        <input type="hidden" name="id_propiedad" id="id_propiedad" value="<?=$id_propiedad;?>">
                        <select name="id_tipo_propiedad" id="id_tipo_propiedad" class="form-control">
                            <?=$options_tipo_propiedad;?>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                    	<label>Tipo de operación</label>
                    	<input type="hidden" name="id_propiedad" id="id_propiedad" value="<?=$id_propiedad;?>">
                        <select name="id_tipo_operacion" id="id_tipo_operacion" class="form-control">
                        	<?=$options_tipo_operacion?>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Periodicidad</label>
                        <input type="hidden" name="id_propiedad" id="id_propiedad" value="<?=$id_propiedad;?>">
                        <select name="id_periodicidad" id="id_periodicidad" class="form-control">
                            <option value="0">--N/A--</option>
                            <?=$options_periodicidad?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                    	<label>Recámaras</label>
                        <input type="text" id="recamaras" name="recamaras" class="form-control" value="<?=$recamaras;?>" onKeyPress="return soloNumeros(event,'decNO');">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                    	<label>Baños</label>
                        <input type="text" id="banios" name="banios" class="form-control" value="<?=$banios;?>" onKeyPress="return soloNumeros(event,'decOK');">
                    </div>
                </div>
                 <div class="col-md-4">
                    <div class="form-group">
                    	<label>Garage</label>
                        <input type="text" id="garage_autos" name="garage_autos" class="form-control" value="<?=$garage_autos;?>" onKeyPress="return soloNumeros(event,'decNO');">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                    	<label>Niveles</label>
                        <input type="text" id="niveles" name="niveles" class="form-control" value="<?=$niveles;?>" onKeyPress="return soloNumeros(event,'decNO');">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                    	<label>Año de contrucción</label>
                        <input type="text" id="anio_construccion" name="anio_construccion" class="form-control" value="<?=$anio_construccion;?>" maxleght="4" onKeyPress="return soloNumeros(event,'decNO');" data-parsley-required="true">
                    </div>
                </div>
                 <div class="col-md-4">
                    <div class="form-group">
                    	<label>Precio</label>
                        <input type="text" id="precio" name="precio" class="form-control" value="<?=$precio;?>" onKeyPress="return soloNumeros(event,'decOK');" min="1" data-parsley-required="true">
                    </div>
                </div>
            </div>

            <div class="row">
            	<div class="col-md-4">
                    <div class="form-group">
                    	<label>Superficie</label>
                        <input type="text" id="superficie_construccion" name="superficie_construccion" class="form-control" value="<?=$superficie_construccion?>" onKeyPress="return soloNumeros(event,'decOK');">
                    </div>
                </div>
            	<div class="col-md-4">
            		 <div class="form-group">
                    	<label>Terreno</label>
	            		<input type="text" id="superficie_terreno" name="superficie_terreno" class="form-control" value="<?=$superficie_terreno?>" onKeyPress="return soloNumeros(event,'decOK');">
	            	</div>
            	</div>
            	<div class="col-md-4">
            		<div class="form-group">
                    	<label>Estatus</label>
	            		<select name="estado" id="estado" class="form-control">
	            			<option value="1">Publicada</option>
	            			<option value="2">Vendida</option>
	            			<option value="3">Rentada</option>
	            		</select>
	            	</div>
            	</div>
            </div>


            <legend>Ubicación</legend>
            <fieldset>
                <div class="row">

                    <div class="col-md-8">
                    	<div class="row">
                    		<div class="col-md-6">
                                <div class="form-group">
                        			<label>Estado</label>
                        			<select name="entidad" id="entidad" class="form-control" onchange="cargar_options('municipios',this);" min="1">
                        				<option value="0">-Seleccione una opción-</option>
                        				<?=$options_entidad?>	
                        			</select>
                                </div>
                    		</div>
                    		<div class="col-md-6">
                                <div class="form-group">
                        			<label>Municipio</label>
                        			<select name="municipio" id="municipio" class="form-control" onchange="cargar_options('localidades',this);" min="1">
                        				<option value="0">-Seleccione una opción-</option>
                        				<?=$options_municipio?>		
                        			</select>
                                </div>
                    		</div>
                       	</div>

                       	<div class="row">
                    		<div class="col-md-6">
                                <div class="form-group">
                        			<label>Ciudad</label>
                        			<select name="localidad" id="localidad" class="form-control" onchange="cargar_options('asentamientos',this);" min="1">
                        				<option value="0">-Seleccione una opción-</option>
                        				<?=$options_localidad?>
                        			</select>
                                </div>
                    		</div>
                    		<div class="col-md-6">
                                <div class="form-group">
                        			<label>Colonia</label>
                        			<select name="id_asentamiento" id="id_asentamiento" class="form-control" onchange="cargar_options('codigos_postales',this);" min="1">
                        				<option value="0">-Seleccione una opción-</option>
                        				<?=$options_asentamiento?>
                        			</select>
                                </div>
                    		</div>
                       	</div>

                   		<div class="row">
                   			<div class="col-md-6">
                                <div class="form-group">
                        			<label>C.P.</label>
                        			<select name="codigo_postal" id="codigo_postal" class="form-control" min="1">
                        			<?=$options_codigo_postal?>		
                        			</select>
                                </div>
                    		</div>
                    		
                    		<div class="col-md-6">
                                <div class="form-group">
                        			<label>Zona</label>
                        			<select name="id_zona" id="id_zona" class="form-control" min="1">
                        			<?=$options_zona?>
                        			</select>
                                </div>
                    		</div>
                       	</div>
                    </div>

                    <div class="col-md-4">
                        <div id="map" style="height:300px;z-index: 1;"></div>
                        <input type="hidden" id="latitud" name="latitud" value="<?=$latitud;?>">
                        <input type="hidden" id="longitud" name="longitud" value="<?=$longitud;?>">
                    </div>

                </div>
            </fieldset>

            
            <legend>Multimedia</legend>
            <fieldset>
                <!--<div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>FICHA TÉCNICA</label><br>
                            <input id="adjuntoFicha" name="adjuntoFicha[]" type="file" class="file"  accept="application/pdf" data-show-upload="false" data-show-caption="true" data-show-preview="false" data-show-upload="false">
                        </div>
                    </div>
                </div>
                -->

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>IMAGENES/DOCUMENTOS</label><br>
                            <small>Extensiones permitidas: jpeg, jpg, png, pdf; hasta 5 MB por acrhivo.</small>
                            <!--<input id="adjuntoFotos" name="adjuntoFotos[]" type="file" class="file" accept="image/*" multiple data-show-upload="false" data-show-caption="true" data-show-preview="true" data-show-upload="false">-->
                            <input id="adjuntoFotos" name="adjuntoFotos[]" type="file" class="file" multiple data-show-upload="false" data-show-caption="true" data-show-preview="true" data-show-upload="false">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>VIDEO</label><br>
                            <small>Link de Youtube.</small>
                            <input type="text" name="link_youtube" id="link_youtube" class="form-control" value="<?=$link_youtube?>" onblur="validateYouTubeUrl();">
                             <input type="hidden" name="id_video_youtube" id="id_video_youtube" value="<?=$id_video_youtube?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8 text-center" id="div_video"><?=$iframe;?></div>
                </div>
            </fieldset>



            <div class="row">
				<div class="col-md-12 text-center">
					<div class="form-group">
						<button class="btn btn-success" id="register-form-submit" name="register-form-submit" value="register">Guardar</button>&nbsp;
						<button class="btn btn-white" type="button" onclick="">Regresar</button>
					</div>
				</div>
			</div>
		</form>
		</div>
	</div>

</body>
<!--<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBnOBLYrneZlLUF5_bhWzGnwc6I7s01qEs&callback=initMap" async defer></script>-->
<!-- Bootstrap File Upload Plugin -->
<script src="<?=base_url();?>admin/assets/plugins/bs-file/bs-filestyle.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBC6BjKMI_xUdG7R0wEnvZMxHpwzYGFLMw&callback=initMap" async defer></script>
<script type="text/javascript">
    var idReturn = 0;
    var numfotos = 0;
    var fotoselim = [];
    var fichaelim = 0;
    var numimgsprev = <?=$numimgsprev;?>;
	$(document).ready(function(){
		//iniciarMapa();
       
	});

    $("#adjuntoFotos").fileinput({
        uploadUrl: '<?=base_url();?>C_propiedades/subir_fotos',
        //maxFileCount: 4,
        allowedFileExtensions: ["jpg", "png", "gif","pdf"],
        maxFileSize: 5120,
        showUpload: false,
        uploadAsync: false,
        overwriteInitial: false,
        //minImageHeight:800,
        initialPreviewAsData: true,
        initialPreviewFileType: 'image',
        initialPreview: [<?=$initialPreview_img;?>],
        initialPreviewConfig: [<?=$initialPreviewConfig_img;?>],
        uploadExtraData: function() {
            return {
                id_propiedad: idReturn,
                num: numfotos,
                elim: fotoselim
            }
        }
    }).on('filebeforedelete', function(event, key) {
        var confirmacion = window.confirm('¿Realmente desea eliminar este archivo?');
        
        if(confirmacion) fotoselim.push(key);

        return !confirmacion;
    }).on('filedeleted', function() {
        setTimeout(function() {
           //window.alert('File deletion was successful! ');
        }, 900);
    });

    /*$("#adjuntoFicha").fileinput({
        uploadUrl: '<?=base_url();?>C_propiedades/subir_ficha',
        maxFileCount: 1,
        allowedFileExtensions: ["pdf"],
        showUpload: false,
        uploadAsync: false,
        overwriteInitial: false,
        initialPreviewAsData: true,
        initialPreviewFileType: 'image',
        initialPreview: [<?=$initialPreview_ficha?>],
        initialPreviewConfig: [<?=$initialPreviewConfig_ficha?>],
        uploadExtraData: function() {
            return {
                id_propiedad: idReturn,
                elim: fichaelim
            }
        }
    }).on('fileclear', function(event) {
       fichaelim = 1;
    });*/

	function guardar(form,event){
		event.preventDefault();
		var loading;
		if(validarFormulario(form)){
			$.ajax({
		        url: '<?=base_url()?>C_propiedades/guardar',
		        type: 'POST',
		        async: false,	//	Para obligar al usuario a esperar una respuesta
		        data: $(form).serialize() + '&fichaelim=' + fichaelim,
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
                    console.log(cod);
		        	switch(cod[0]){
		                case "0":
                            idReturn = cod[1];
                            if( $('#adjuntoFotos').fileinput('getFilesCount') > 0 || numimgsprev > 0 )
                            {
                                numfotos = $('#adjuntoFotos').fileinput('getFilesCount');
                                $('#adjuntoFotos').fileinput('upload');
                            }
                            
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

	function cargar_options(listado,elemento){
		var valor = $("#"+elemento.id).val();
		

		$.post(base_url + "C_propiedades/cargar_options/",{listado:listado,valor:valor},function(resultado,status){
			
			if(listado == 'municipios'){								
				$('#municipio option[value!="0"]').remove();
				$('#localidad option[value!="0"]').remove();
				$('#id_asentamiento option[value!="0"]').remove();
				$('#codigo_postal option[value!="0"]').remove();

				$('#municipio').append(resultado);
			}

			if(listado == 'localidades'){
				$('#localidad option[value!="0"]').remove();
				$('#id_asentamiento option[value!="0"]').remove();
				$('#codigo_postal option[value!="0"]').remove();

				$('#localidad').append(resultado);
			}
			
			if(listado == 'asentamientos'){
				$('#id_asentamiento option[value!="0"]').remove();
				$('#codigo_postal option[value!="0"]').remove();

				$('#id_asentamiento').append(resultado);
			}

			if(listado == 'codigos_postales'){
				$('#codigo_postal option[value!="0"]').remove();

				$('#codigo_postal').append(resultado);
			}
			
		});
	}

	function initMap() {
        var centro_lat = <?php echo ($latitud == 0) ? '20.97636467031955':$latitud; ?>;
        var centro_lng = <?php echo ($longitud == 0) ? '-89.62927700124328':$longitud; ?>;
    	var latitud = <?=$latitud?>;
    	var longitud = <?=$longitud?>;
    	//console.log(latitud);
    	//console.log(longitud);
    	map = new google.maps.Map(document.getElementById('map'), {
        	center: { lat: centro_lat, lng: centro_lng },
          	zoom: 15
        });

        
        marker = new google.maps.Marker({
        <?php if($latitud != 0 && $longitud != 0){?>
            position: { lat: latitud, lng: longitud },
        <?php }?>
            map: map
        });
        

        map.addListener('click', function(e){

        	var lat = e.latLng.lat();
        	var lng = e.latLng.lng();            
        	var lat_lng = new google.maps.LatLng(lat,lng);
        	marker.setPosition(lat_lng);
        	map.setZoom(11);
        	map.panTo(lat_lng);

        	document.getElementById('latitud').value = lat;
        	document.getElementById('longitud').value = lng;
        });
    }

    function validateYouTubeUrl()
    {
        var url = $('#link_youtube').val();
        console.log(url);
        if (url != undefined || url != '') {
            var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=|\?v=)([^#\&\?]*).*/;
            var match = url.match(regExp);
            if (match && match[2].length == 11) {
                // Do anything for being valid
                // if need to change the url to embed url then use below line
                //$('#preview_video').attr('src', 'https://www.youtube.com/embed/' + match[2] + '?autoplay=0');
                var src = 'https://www.youtube.com/embed/' + match[2] + '?autoplay=0';
                var html = '<pre><div class="video-responsive" id="div_video"><iframe  src="'+src+'" frameborder="0" allowfullscreen="allowfullscreen"></iframe></div><pre>';
                $("#id_video_youtube").val(match[2]);
                $("#div_video").html(html);
            }
            else {
                $("#id_video_youtube").val('');
                $("#div_video").html('');
                notificacion('URL incorrecto o vacío');
            }
        }
    }
</script>
</html>