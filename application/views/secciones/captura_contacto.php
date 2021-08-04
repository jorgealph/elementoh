<html>

<head>
    <link rel="stylesheet" href="<?=base_url();?>admin/assets/plugins/bs-file/bs-filestyle.css" type="text/css" />
</head>

<body>
	<div class="panel panel panel-inverse">
		<div class="panel-heading ui-sortable-handle">Contacto</div>
		<div class="panel-body">
		<form class="form" onsubmit="guardar(this,event);" id="form-captura" name="form-captura">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Titulo de la sección</label>
                        <input type="hidden" name="id_contacto" id="id_contacto" value="<?=$id_contacto;?>">
                        <input type="text" id="titulo_seccion" name="titulo_seccion" class="form-control" value="<?=$titulo_seccion;?>" data-parsley-required="true">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <label>Imagen de la sección</label><br>
                    <small>Extensiones permitidas: jpeg, jpg, png. Hasta 2 MB por acrhivo.</small>
                    <input id="adjuntoFotos" name="adjuntoFotos[]" type="file" class="file" accept="image/*" multiple data-show-upload="false" data-show-caption="true" data-show-preview="true" data-show-upload="false">
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Dirección</label>
                        <textarea id="direccion" name="direccion" rows="6" class="form-control"><?=$direccion?></textarea>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                    	<label>Teléfono</label>
                        <input type="text" id="telefono" name="telefono" class="form-control" value="<?=$telefono;?>" data-parsley-required="true">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" id="email" name="email" class="form-control" value="<?=$email;?>">
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
    <script src="<?=base_url();?>admin/assets/plugins/bs-file/bs-filestyle.js"></script>
    <script type="text/javascript"> 
        var idReturn = <?=$id_contacto?>;
        var fotoselim = [];
        var numfotos = 0;
        var numimgsprev = <?=$numimgsprev;?>;
        $("#adjuntoFotos").fileinput({
            uploadUrl: '<?=base_url();?>C_secciones/subir_fotos_contacto',
            maxFileCount: 1,
            allowedFileExtensions: ["jpg", "png", "gif"],
            maxFileSize: 2048,
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
                    id: idReturn,
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

        function guardar(form,event){
            event.preventDefault();
            var loading;
            if(validarFormulario(form)){
                $.ajax({
                    url: '<?=base_url()?>C_secciones/guardar_contacto',
                    type: 'POST',
                    async: false,   //  Para obligar al usuario a esperar una respuesta
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
                                if( $('#adjuntoFotos').fileinput('getFilesCount') > 0 || numimgsprev > 0 )
                                {
                                    numfotos = $('#adjuntoFotos').fileinput('getFilesCount');
                                    $('#adjuntoFotos').fileinput('upload');
                                }
                                notificacion('Los datos han sido guardados','success');
                                cargar('<?=base_url()?>C_secciones/contacto','#contenido');
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
</body>
</html>