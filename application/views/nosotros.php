<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Elementoh &mdash; Inmobiliaria</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito+Sans:200,300,400,700,900|Roboto+Mono:300,400,500"> 
    <link rel="stylesheet" href="<?=base_url()?>public/fonts/icomoon/style.css">

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
    <link rel="stylesheet" href="<?=base_url()?>public/css/style.css?v=2.1">
    <style type="text/css">
      .bg-dark {
        background-color: #000000 !important;
      }
    </style>
  </head>
  <body>
  
  <div class="site-loader"></div>

    <div class="site-wrap">
        <?php include('menu.php')?>
    </div>
           

    </div>
        </div>
      </div>
    </div>

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
        <div class="row justify-content-center">
          <div class="col-md-12 text-center">
            <img src="<?=base_url()?>public/images/logotipo_nosotros.png" alt="Image" class="img-fluid">
          </div>
        </div>

        <div class="row justify-content-center">
          <div class="col-md-12 text-center">
            <p><?=$introduccion?></p>
          </div>
        </div>
        <br>

        <?=$secciones;?>
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
  <!--<script src="<?=base_url()?>public/js/mediaelement-and-player.min.js"></script>-->
  <script src="<?=base_url()?>public/js/jquery.stellar.min.js"></script>
  <script src="<?=base_url()?>public/js/jquery.countdown.min.js"></script>
  <script src="<?=base_url()?>public/js/jquery.magnific-popup.min.js"></script>
  <script src="<?=base_url()?>public/js/bootstrap-datepicker.min.js"></script>
  <script src="<?=base_url()?>public/js/aos.js"></script>
  <!--<script src="<?=base_url()?>public/js/circleaudioplayer.js"></script>-->

  <script src="<?=base_url()?>public/js/main.js"></script>
    
  </body>
</html>