<!DOCTYPE html>
<html lang="es">
  <head>
    <title>ELEMENTOH</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito+Sans:200,300,400,700,900|Roboto+Mono:300,400,500"> 
    <link rel="stylesheet" href="<?=base_url();?>public/fonts/icomoon/style.css">
    <link rel="stylesheet" href="<?=base_url();?>public/css/bootstrap.min.css?v=2.2">
    <link rel="stylesheet" href="<?=base_url();?>public/css/magnific-popup.css">
    <link rel="stylesheet" href="<?=base_url();?>public/css/jquery-ui.css">
    <link rel="stylesheet" href="<?=base_url();?>public/css/owl.carousel.min.css">
    <link rel="stylesheet" href="<?=base_url();?>public/css/owl.theme.default.min.css">
    <link rel="stylesheet" href="<?=base_url();?>public/css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="<?=base_url();?>public/css/mediaelementplayer.css">
    <link rel="stylesheet" href="<?=base_url();?>public/css/animate.css">
    <link rel="stylesheet" href="<?=base_url();?>public/fonts/flaticon/font/flaticon.css">
    <link rel="stylesheet" href="<?=base_url();?>public/css/fl-bigmug-line.css">
    <link rel="stylesheet" href="<?=base_url();?>public/css/aos.css">
    <link rel="stylesheet" href="<?=base_url();?>public/css/style.css?v=2.1">
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

    .video-responsive{
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }

    .bg-dark {
      background-color: #000000 !important;
    }
    </style>
  </head>
  <body>
  
  <div class="site-loader"></div>
  
  <div class="site-wrap">
    <?php include('menu.php'); ?>
    <div class="site-blocks-cover inner-page-cover overlay" style="background-image: url(<?=base_url();?>public/images/<?=$imagen_principal?>);" data-aos="fade" data-stellar-background-ratio="0.5">
      <div class="container">
        <div class="row align-items-center justify-content-center text-center">
          <div class="col-md-10">
            <span class="d-inline-block text-white px-3 mb-3 property-offer-type rounded">Detalles de la propiedad</span>
            <h1 class="mb-2"><?=$titulo?></h1>
            <p class="mb-5"><strong class="h2 text-success font-weight-bold"><?=$precio?></strong></p>
          </div>
        </div>
      </div>
    </div>

    <div class="site-section site-section-sm">
      <div class="container">
        <div class="row">
          <div class="col-lg-8">
            <div>
              <div class="slide-one-item home-slider owl-carousel carrusel">
                <?php 
                  if($iframe != '') echo $iframe;
                  echo $slider_imagenes
                ?>
              </div>
            </div>
            <div class="bg-white property-body border-bottom border-left border-right">
              <div class="row mb-5">
                <div class="col-md-6">
                  <?php $h = (strlen($precio) > 15) ? 'h3':'h1'; ?>
                  <strong class="text-success <?=$h?> mb-3"><?=$precio?></strong>
                </div>
                <div class="col-md-6">
                  <ul class="property-specs-wrap mb-3 mb-lg-0  float-lg-right">
                  <li>
                    <span class="property-specs">Recamaras&nbsp;<i class="icon-bed"></i></span>
                    <div class="text-center"><span class="property-specs-number"><?=$recamaras?></span></div>                    
                  </li>
                  <li>
                    <span class="property-specs">Baños&nbsp;<i class="icon-bath"></i></span>
                    <div class="text-center"><span class="property-specs-number"><?=$banios?></span></div>
                  </li>
                  <li>
                    <span class="property-specs">Estacionamiento &nbsp;<i class="icon-car"></i></span>
                    <div class="text-center"><span class="property-specs-number"><?=$garage_autos?></span></div>
                  </li>
                  <li>
                    <span class="property-specs">M<sup>2</sup> Terreno</span>
                    <div class="text-center"><span class="property-specs-number text-center"><?=$superficie_terreno?></span></div>
                  </li>
                  <li>
                    <span class="property-specs">M<sup>2</sup> Construcci&oacute;n</span>
                    <div class="text-center"><span class="property-specs-number text-center"><?=$superficie_construccion?></span></div>
                  </li>
                </ul>
                </div>
              </div>
              <div class="row mb-5">
                <div class="col-md-4 col-lg-4 border-bottom border-top py-3 text-center">
                  <span class="d-inline-block text-black mb-0 caption-text">Zona</span>
                  <strong class="d-block"><?=$zona?></strong>
                </div>
                <div class="col-md-4 col-lg-4 border-bottom border-top py-3 text-center">
                  <span class="d-inline-block text-black mb-0 caption-text">Tipo</span>
                  <strong class="d-block"><?=$tipo_propiedad?></strong>
                </div>
                <div class="col-md-4 col-lg-4 border-bottom border-top py-3 text-center">
                  <span class="d-inline-block text-black mb-0 caption-text">Operación</span>
                  <strong class="d-block"><?=$tipo_operacion?></strong>
                </div>
                <!--<div class="col-md-4 col-lg-4 border-bottom border-top py-3">
                  <span class="d-inline-block text-black mb-0 caption-text">Ficha técnica</span>
                  <a href="<?=base_url()?>ficha/<?=$id_propiedad?>" target="_blank">
                    <img src="<?=base_url()?>admin/assets/img/icon_pdf_download.png" class="img-thumbnail" width="100px;" title="Clic para descargar">
                  </a>
                </div>-->
              </div>
              <h4 class="h4 text-black">Detalles</h4>
              <div class="row">
                <div class="col-md-12 text-justify"><p><?=$descripcion?></p></div>
              </div>
              <hr>

              <h4 class="h4 text-black">Ubicación</h4>              
              <div class="row">
                <div class="col-md-12 col-lg-12"><p><?=$ubicacion?></p></div>
              </div>
              
              <?php
              if( $latitud != 0 && $longitud != 0 ) { ?>
              <div class="row">
                <div class="col-md-12">
                  <div id="map" style="height:300px;z-index: 1;"></div>
                  <input type="hidden" id="latitud" name="latitud" value="<?=$latitud;?>">
                  <input type="hidden" id="longitud" name="longitud" value="<?=$longitud;?>">
                </div>
              </div>
              <?php } ?>
              <hr>

              <h4 class="h4 text-black">Imágenes</h4>
              <div class="row no-gutters mt-5">
                <?=$galeria_imagenes?>
              </div>
              <hr>

              <h4 class="h4 text-black">Documentación</h4>
              <div class="row no-gutters mt-5">
                <?=$documentacion;?>
              </div>
            </div>
          </div>
          <div class="col-lg-4">

            <div class="bg-white widget border rounded">

              <h3 class="h4 text-black widget-title mb-3">Contactar agente</h3>
              <form action="" class="form-contact-agent" onsubmit="enviarMensaje(event,this);">
                <div class="form-group">
                  <label for="name">Nombre</label>
                  <input type="hidden" name="id_propiedad" id="id_propiedad" value="<?=$id_propiedad?>">
                  <input type="hidden" name="titulo" id="titulo" value="<?=$titulo?>">
                  <input type="text" id="nombre" name="nombre" class="form-control">
                </div>
                <div class="form-group">
                  <label for="email">Email</label>
                  <input type="email" id="correo" name="correo" class="form-control">
                </div>
                <div class="form-group">
                  <label for="phone">Teléfono</label>
                  <input type="text" id="telefono" name="telefono" class="form-control">
                </div>
                <div class="form-group">
                  <input type="submit" class="btn btn-primary" value="Enviar mensaje">
                </div>
              </form>
            </div>
          </div>
          
        </div>
      </div>
    </div>

  <?php include('footer.php'); ?>
  </div>

  <script src="<?=base_url();?>public/js/jquery-3.3.1.min.js"></script>
  <script src="<?=base_url();?>public/js/jquery-migrate-3.0.1.min.js"></script>
  <script src="<?=base_url();?>public/js/jquery-ui.js"></script>
  <script src="<?=base_url();?>public/js/popper.min.js"></script>
  <script src="<?=base_url();?>public/js/bootstrap.min.js"></script>
  <script src="<?=base_url();?>public/js/owl.carousel.min.js"></script>
  <script src="<?=base_url();?>public/js/mediaelement-and-player.min.js"></script>
  <script src="<?=base_url();?>public/js/jquery.stellar.min.js"></script>
  <script src="<?=base_url();?>public/js/jquery.countdown.min.js"></script>
  <script src="<?=base_url();?>public/js/jquery.magnific-popup.min.js"></script>
  <script src="<?=base_url();?>public/js/bootstrap-datepicker.min.js"></script>
  <script src="<?=base_url();?>public/js/aos.js"></script>
  <script src="<?=base_url();?>public/js/main.js?v=1"></script>
  <?php
  if( $latitud != 0 && $longitud != 0 ) { ?>
  <script src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyBC6BjKMI_xUdG7R0wEnvZMxHpwzYGFLMw&callback=initMap" async defer></script>
  <script type="text/javascript">
    var map;
    var opt = {maxHeight:200,maxWidth:200};
    $(document).ready(function(){
        $(".carrusel").owlCarousel({
            center: false,
            items: 1,
            loop: true,
            stagePadding: 0,
            margin: 0,
            autoplay: false,
            pauseOnHover: false,
            nav: true,
            animateOut: 'fadeOut',
            animateIn: 'fadeIn',
            navText: ['<span class="icon-arrow_back">', '<span class="icon-arrow_forward">']
          });
    })

     function initMap() {
      var centro = new google.maps.LatLng(<?=$latitud?>, <?=$longitud?>);
      map = new google.maps.Map(document.getElementById('map'), {
        center: centro,
          zoom: 16
      });

      var marker = new google.maps.Marker({
        position: centro,
        map: map
      });

      /*var service = new google.maps.places.PlacesService(map);
      
  
      service.nearbySearch({
        location: centro,
        radius: 1000,
        type: "restaurant"
      }, function (results, status) {
        if (status === google.maps.places.PlacesServiceStatus.OK) {
          var html = '';
          var n = 0;
          for (var i = 0; i < results.length; i++) {
            
            if(results[i].hasOwnProperty('photos')){
              var img = results[i].photos[0].getUrl(opt);
              html += htmlPlace(results[i].name,img);
              n++;
            }
          }
          $("#div_lugares_cerca").html(html);
          $("#div_resultado").html('<b>'+n+'</b> lugares cerca');
        }else{
           $("#div_lugares_cerca").html('');
          $("#div_resultado").html('<b>0</b> lugares cerca');
        }
      });*/
    }
  </script>
  <?php } ?>
  <script type="text/javascript">
    /*function buscarCerca(){
      var n = 0;
      var centro = new google.maps.LatLng(<?=$latitud?>, <?=$longitud?>);
      var type = $("#near_type").val();
      var service = new google.maps.places.PlacesService(map);
  
      service.nearbySearch({
        location: centro,
        radius: 1000,
        type: type
      }, function (results, status) {
        if (status === google.maps.places.PlacesServiceStatus.OK) {
          var html = '';
          for (var i = 0; i < results.length; i++) {
            
            if(results[i].hasOwnProperty('photos')){
              var img = results[i].photos[0].getUrl(opt);
              html += htmlPlace(results[i].name,img);
              n++;
            }
          }
          $("#div_lugares_cerca").html(html);
          $("#div_resultado").html('<b>'+n+'</b> lugares cerca');
        }else{
          $("#div_lugares_cerca").html('');
          $("#div_resultado").html('<b>0</b> lugares cerca');
        }
      });
    }
    
    function htmlPlace(titulo,img){
      
      //var html = '<div class="row">';
      var html =    '<div class="col-md-12 text-left">';
      html+=      '<div class="property-entry horizontal d-lg-flex">';

      html+=        '<a href="#" class="property-thumbnail h-100">';
      html+=          '<img src="'+img+'" class="img-thumbnail" alt="Image" width="200px" height="100px">';
      html+=        '</a>';

      html+=        '<div class="p-4 property-body">';
      html+=          '<h2 class="property-title"><a href="#">'+titulo+'</a></h2>';     
      html+=       ' </div>';

      html+=      '</div>';
      html+=    '</div>';

      return html;
    }
    */

    function enviarMensaje(e,form) {
      e.preventDefault();
      
      $.ajax({
        url: '<?=base_url()?>C_seguridad/enviar_correo2',
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
            $("#telefono").val('');
            
            alert('Correo enviado');
          }
          else alert(htmlcode);
         
        }
      });
    }
  </script>
  </body>
</html>