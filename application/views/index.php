<!DOCTYPE html>
<html lang="en">
  <head>
    <title>ELEMENTOH</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito+Sans:200,300,400,700,900|Roboto+Mono:300,400,500"> 
    <link rel="stylesheet" href="<?=base_url();?>public/fonts/icomoon/style.css">

    <link rel="stylesheet" href="<?=base_url();?>public/css/bootstrap.min.css?v=2.3">
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
      .bg-dark {
        background-color: #000000 !important;
      }
    </style>
  </head>
  <body>
  
  <div class="site-loader"></div>
  
  <div class="site-wrap" id="menu">
    <?php include('menu.php'); ?>    
  </div>

  <div class="slide-one-item home-slider owl-carousel carrusel-auto"><?=$ultimas_propiedades?></div>


    <div class="site-section site-section-sm bg-light pb-0" id="propiedades">
      <div class="container">
        <form class="form-search col-md-12" id="form-busqueda" name="form-busqueda" style="margin-top: -100px; box-shadow: 0 0 10px -2px rgba(0, 0, 0, 0.1);" onsubmit="buscar(1,event);">
          <div class="row">
            <div class="col-md-4">
              <label for="list-types">Estado</label>
              <div class="select-wrap">
                <span class="icon icon-arrow_drop_down"></span>
                <select name="estado" id="estado" class="form-control d-block rounded-0">
                  <option value="0">--Todos--</option>
                  <?=$options_entidad?>
                </select>
              </div>
            </div>

            <!--<div class="col-md-2">
              <label for="list-types">Municipio</label>
              <div class="select-wrap">
                <span class="icon icon-arrow_drop_down"></span>
                <select name="municipio" id="municipio" onchange="cargar_options('localidades_propiedades',this);" class="form-control d-block rounded-0">
                  <option value="0">--Todos--</option>
                  <?=$options_municipio?>
                </select>
              </div>
            </div>

            <div class="col-md-2">
              <label for="list-types">Ciudad</label>
              <div class="select-wrap">
                <span class="icon icon-arrow_drop_down"></span>
                <select name="localidad" id="localidad" class="form-control d-block rounded-0" onchange="cargar_options('asentamientos',this);">
                  <option value="0">--Todas--</option>
                  <?=$options_localidad?>
                </select>
              </div>
            </div>-->

            <div class="col-md-4">
              <label for="offer-types">Tipo de operación</label>
              <div class="select-wrap">
                <span class="icon icon-arrow_drop_down"></span>
                <select name="tipo_operacion" id="tipo_operacion" class="form-control d-block rounded-0">
                    <option value="0">--Todas--</option>
                    <?=$options_tipo_operacion?>
                </select>
              </div>
            </div>

            <div class="col-md-4">
              <label for="list-types">Tipo de propiedad</label>
              <div class="select-wrap">
                <span class="icon icon-arrow_drop_down"></span>
                <select name="tipo_propiedad" id="tipo_propiedad" class="form-control d-block rounded-0">
                  <option value="0">--Todas--</option>
                  <?=$options_tipo_propiedad?>
                </select>
              </div>
            </div>

            <!--<div class="col-md-3">
              <label for="list-types">Col./Fracc.</label>
              <div class="select-wrap">
                <span class="icon icon-arrow_drop_down"></span>
                <select name="id_asentamiento" id="id_asentamiento" class="form-control d-block rounded-0" onchange="cargar_options('codigos_postales',this);" min="1">
                  <option value="0">-Todas-</option>
                  <?=$options_asentamiento?>
                </select>
              </div>
            </div>-->

           
          </div>
          <!--
          <div class="row">
            <div class="col-md-3">
              <label for="list-types">Zona</label>
              <div class="select-wrap">
                <span class="icon icon-arrow_drop_down"></span>
                <select name="zona" id="zona" class="form-control d-block rounded-0">
                  <option value="0">--Todas--</option>
                  <?=$options_zona?>
                </select>
              </div>
            </div>
            <div class="col-md-3">
              <label for="select-city">Recamara(s)</label>
               <input type="number" name="recamaras" id="recamaras" class="form-control">
            </div>

            <div class="col-md-3">
              <label for="select-city">Baño(s)</label>
              <input type="number" name="banios" id="banios" class="form-control">
            </div>

            <div class="col-md-3">
              <label for="select-city">Garage(s)</label>
              <input type="number" name="garage" id="garage" class="form-control">
            </div>
          </div>

          <div class="row">
            <div class="col-md-3">
              <label for="offer-types">Tipo de operación</label>
              <div class="select-wrap">
                <span class="icon icon-arrow_drop_down"></span>
                <select name="tipo_operacion" id="tipo_operacion" class="form-control d-block rounded-0">
                    <option value="0">--Todas--</option>
                    <?=$options_tipo_operacion?>
                </select>
              </div>
            </div>

            <div class="col-md-3">
              <label for="list-types">Tipo de propiedad</label>
              <div class="select-wrap">
                <span class="icon icon-arrow_drop_down"></span>
                <select name="tipo_propiedad" id="tipo_propiedad" class="form-control d-block rounded-0">
                  <option value="0">--Todas--</option>
                  <?=$options_tipo_propiedad?>
                </select>
              </div>
            </div>


          </div>-->

          <div class="row">
            <div class="col-md-12">
                <input style="margin-top: 20px;" type="submit" class="btn btn-dark text-white btn-block rounded-0" value="Buscar">
            </div>
          </div>
        </form>
        

        <div class="row">
          <div class="col-md-12">
            <div class="view-options py-3 px-3 d-md-flex align-items-center">
              <div class="ml-auto d-flex align-items-center">
                <!--<div>
                  <a href="#" class="view-list px-3 border-right active">Todos</a>
                  <a href="#" class="view-list px-3 border-right">Venta</a>
                  <a href="#" class="view-list px-3 border-right">Renta</a>
                  <a href="#" class="view-list px-3 border-right">Renta por días</a>
                  <a href="#" class="view-list px-3">Renta por vacaciones</a>
                </div>-->
                <!--<div class="row">            
                  <div class="col-md-12">Precio
                    <div class="row">
                      <div class="col-md-6">
                        <input type="text" name="min_precio" id="min_precio" value="" class="form-control form-control-sm" placeholder="Mín">
                      </div>

                      <div class="col-md-6">
                        <input type="text" name="max_precio" id="max_precio" value="" class="form-control form-control-sm" placeholder="Máx">
                      </div>
                    </div>
                  </div>
                </div>

                 <div class="row">            
                  <div class="col-md-12">Precio
                    <div class="row">
                      <div class="col-md-6">
                        <input type="text" name="min_precio" id="min_precio" value="" class="form-control form-control-sm" placeholder="Mín">
                      </div>

                      <div class="col-md-6">
                        <input type="text" name="max_precio" id="max_precio" value="" class="form-control form-control-sm" placeholder="Máx">
                      </div>
                    </div>
                  </div>
                </div>

                 <div class="row">            
                  <div class="col-md-12">Precio
                    <div class="row">
                      <div class="col-md-6">
                        <input type="text" name="min_precio" id="min_precio" value="" class="form-control form-control-sm" placeholder="Mín">
                      </div>

                      <div class="col-md-6">
                        <input type="text" name="max_precio" id="max_precio" value="" class="form-control form-control-sm" placeholder="Máx">
                      </div>
                    </div>
                  </div>
                </div>

               -->

                <div class="row">
                  <div class="col-md-12"> 
                    <div class="select-wrap">
                      <span class="icon icon-arrow_drop_down"></span>
                      <select class="form-control form-control-sm  rounded-0" id="order_by" name="order_by" onchange="buscar(1,event)">
                        <option value="">Ordenar por</option>
                        <option value="precio ASC">Precio: De más bajo a más alto</option>
                        <option value="precio DESC">Precio: De más alto a más bajo</option>
                        <option value="fecha_captura DESC">Fecha: Más reciente</option>
                        <option value="fecha_captura ASC">Fecha: Menos reciente </option>
                      </select>
                    </div>
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>
       
      </div>
    </div>

    <div class="site-section site-section-sm bg-light">
      <div class="container" id="listado">
      <?=$listado_propiedades?>
      </div>
    </div>
    <?php include('footer.php') ?>
   

  </div>

  <script src="<?=base_url();?>public/js/jquery-3.3.1.min.js"></script>
  <script src="<?=base_url();?>public/js/jquery-migrate-3.0.1.min.js"></script>
  <script src="<?=base_url();?>public/js/jquery-ui.js"></script>
  <script src="<?=base_url();?>public/js/popper.min.js"></script>
  <script src="<?=base_url();?>public/js/bootstrap.min.js"></script>
  <script src="<?=base_url();?>public/js/owl.carousel.min.js"></script>
  <script src="<?=base_url();?>public/js/mediaelement-and-player.min.js"></script>
  <script src="<?=base_url();?>public/js/jquery.stellar.min.js"></script>
  <!--<script src="<?=base_url();?>public/js/jquery.countdown.min.js"></script>-->
  <script src="<?=base_url();?>public/js/jquery.magnific-popup.min.js"></script>
  <script src="<?=base_url();?>public/js/bootstrap-datepicker.min.js"></script>
  <script src="<?=base_url();?>public/js/aos.js"></script>
  <script src="<?=base_url();?>public/js/main.js?v=1"></script>
  <script type="text/javascript">
    function buscar(pag,e){
      if (!e) { var e = window.event; }
      e.preventDefault();

      var pag = pag || 1;

      var variables = $("#form-busqueda").serialize();
      variables += '&pag=' + pag;
      variables += '&order_by=' + $("#order_by").val();

      cargar('<?=base_url();?>C_seguridad/buscar_propiedades','#listado','POST',variables);

      $('html, body').animate({
          scrollTop: $("#listado").offset().top
      }, 1500);
    }

    function cargar_options(listado,elemento){
      var valor = $("#"+elemento.id).val();
    

      $.post("<?=base_url();?>C_propiedades/cargar_options/",{listado:listado,valor:valor},function(resultado,status){
        
        if(listado == 'municipios_propiedades'){                
          $('#municipio option[value!="0"]').remove();
          $('#localidad option[value!="0"]').remove();
          $('#id_asentamiento option[value!="0"]').remove();
          $('#codigo_postal option[value!="0"]').remove();

          $('#municipio').append(resultado);
        }

        if(listado == 'localidades_propiedades'){
          $('#localidad option[value!="0"]').remove();
          $('#id_asentamiento option[value!="0"]').remove();
          $('#codigo_postal option[value!="0"]').remove();

          $('#localidad').append(resultado);
        }
        
        /*if(listado == 'asentamientos'){
          $('#id_asentamiento option[value!="0"]').remove();
          $('#codigo_postal option[value!="0"]').remove();

          $('#id_asentamiento').append(resultado);
        }

        if(listado == 'codigos_postales'){
          $('#codigo_postal option[value!="0"]').remove();

          $('#codigo_postal').append(resultado);
        }*/
        
      });
    }
  </script>
  </body>
</html>