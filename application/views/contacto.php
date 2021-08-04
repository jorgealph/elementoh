<!DOCTYPE html>
<html lang="en">
  <head>
    <title>ELEMENTOH</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito+Sans:200,300,400,700,900|Roboto+Mono:300,400,500"> 
    <link rel="stylesheet" href="<?=base_url();?>public/fonts/icomoon/style.css">

    <link rel="stylesheet" href="<?=base_url()?>public/css/bootstrap.min.css?v=2.2">
    <link rel="stylesheet" href="<?=base_url()?>public/css/magnific-popup.css">
    <link rel="stylesheet" href="<?=base_url()?>public/css/jquery-ui.css">
    <link rel="stylesheet" href="<?=base_url()?>public/css/owl.carousel.min.css">
    <link rel="stylesheet" href="<?=base_url()?>public/css/owl.theme.default.min.css">
    <link rel="stylesheet" href="<?=base_url()?>public/css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="<?=base_url()?>public/css/mediaelementplayer.css">
    <link rel="stylesheet" href="<?=base_url()?>public/css/animate.css">
    <link rel="stylesheet" href="<?=base_url()?>public/fonts/flaticon/font/flaticon.css">
    <link rel="stylesheet" href="<?=base_url()?>public/css/fl-bigmug-line.css">
    <link rel="stylesheet" href="<?=base_url()?>public/css/aos.css">
    <link rel="stylesheet" href="<?=base_url()?>public/css/style.css?v=2.2">
    <style type="text/css">
      .bg-dark {
        background-color: #000000 !important;
      }
    </style>
  </head>
  <body>
  
  <div class="site-loader"></div>
  
  <div class="site-wrap">
    <?php include('menu.php'); ?>

    <div class="site-blocks-cover inner-page-cover overlay" style="background-image: url('<?=$imagen_seccion?>');" data-aos="fade" data-stellar-background-ratio="0.5">
      <div class="container">
        <div class="row align-items-center justify-content-center text-center">
          <div class="col-md-10">
            <h1 class="mb-2"><?=$titulo_seccion?></h1>
          </div>
        </div>
      </div>
    </div>
    

    <div class="site-section">
      <div class="container">
        <div class="row">
       
          <div class="col-md-12 col-lg-8 mb-5">
          
            
          
            <form action="#" class="p-5 bg-white border" onsubmit="enviarMensaje(this,event);">

              <div class="row form-group">
                <div class="col-md-12 mb-3 mb-md-0">
                  <label class="font-weight-bold" for="fullname">Nombre completo</label>
                  <input type="text" name="nombre" id="nombre" class="form-control" placeholder="">
                </div>
              </div>
              <div class="row form-group">
                <div class="col-md-12">
                  <label class="font-weight-bold" for="email">Correo electrónico</label>
                  <input type="email" name="correo" id="correo" class="form-control" placeholder="">
                </div>
              </div>
              <div class="row form-group">
                <div class="col-md-12">
                  <label class="font-weight-bold" for="email">Asunto</label>
                  <input type="text" name="asunto" id="asunto" class="form-control" placeholder="">
                </div>
              </div>
              

              <div class="row form-group">
                <div class="col-md-12">
                  <label class="font-weight-bold" for="message">Mensaje</label> 
                  <textarea name="mensaje" id="mensaje" cols="30" rows="5" class="form-control" placeholder="Escriba su mensaje"></textarea>
                </div>
              </div>

              <div class="row form-group">
                <div class="col-md-12">
                  <input type="submit" value="Enviar mensaje" class="btn btn-primary  py-2 px-4 rounded-0">
                </div>
              </div>

  
            </form>
          </div>

          <div class="col-lg-4">
            <div class="p-4 mb-3 bg-white widget border rounded">
              <h3 class="h6 text-black mb-3 text-uppercase">Informaci&oacute;n de contacto</h3>
              <p class="mb-0 font-weight-bold">Dirección</p>
              <p class="mb-4"><?=$direccion?></p>

              <p class="mb-0 font-weight-bold">Teléfono</p>
              <p class="mb-4"><a href="#"><?=$telefono?></a></p>

              <p class="mb-0 font-weight-bold">Correo electrónico</p>
              <p class="mb-0"><a href="#"><?=$email?></a></p>

            </div>
            
          </div>
        </div>
      </div>
    </div>

    <?php include('footer.php'); ?>
  </div>

  <script src="<?=base_url()?>public/js/jquery-3.3.1.min.js"></script>
  <script src="<?=base_url()?>public/js/jquery-migrate-3.0.1.min.js"></script>
  <script src="<?=base_url()?>public/js/jquery-ui.js"></script>
  <script src="<?=base_url()?>public/js/popper.min.js"></script>
  <script src="<?=base_url()?>public/js/bootstrap.min.js"></script>
  <script src="<?=base_url()?>public/js/owl.carousel.min.js"></script>
  <script src="<?=base_url()?>public/js/mediaelement-and-player.min.js"></script>
  <script src="<?=base_url()?>public/js/jquery.stellar.min.js"></script>
  <script src="<?=base_url()?>public/js/jquery.countdown.min.js"></script>
  <script src="<?=base_url()?>public/js/jquery.magnific-popup.min.js"></script>
  <script src="<?=base_url()?>public/js/bootstrap-datepicker.min.js"></script>
  <script src="<?=base_url()?>public/js/aos.js"></script>

  <script src="<?=base_url()?>public/js/main.js?v=1"></script>
  <script type="text/javascript">
    function enviarMensaje(form,e){
      e.preventDefault();

      $.ajax({
            url: '<?=base_url()?>C_seguridad/enviar_correo',
            type: 'POST',
            async: false, //  Para obligar al usuario a esperar una respuesta
            data: $(form).serialize(),
            beforeSend: function(){
            },
            error: function(XMLHttpRequest, errMsg, exception){
                var msg = "Ha fallado la petición al servidor";               
            },
            success: function(htmlcode){
              if(htmlcode == '0'){ 
                $("#nombre").val('');
                $("#correo").val('');
                $("#asunto").val('');
                $("#mensaje").val('');
                
                alert('Correo enviado');
              }
              else alert(htmlcode);
             
            }
        });
    }
  </script>
    
  </body>
</html>