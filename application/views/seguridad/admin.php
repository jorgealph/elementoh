<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<head>
	<meta charset="utf-8" />
	<title>ELEMENTOH | Panel</title>
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />
	
	<!-- ================== BEGIN BASE CSS STYLE ================== -->
	<link href="<?=base_url();?>admin/assets/plugins/jquery-ui/jquery-ui.min.css" rel="stylesheet" />
	<link href="<?=base_url();?>admin/assets/plugins/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" />
	<link href="<?=base_url();?>admin/assets/plugins/font-awesome/5.0/css/fontawesome-all.min.css" rel="stylesheet" />
	<link href="<?=base_url();?>admin/assets/plugins/animate/animate.min.css" rel="stylesheet" />
	<link href="<?=base_url();?>admin/assets/css/default/style.min.css" rel="stylesheet" />
	<link href="<?=base_url();?>admin/assets/css/default/style-responsive.min.css" rel="stylesheet" />
	<link href="<?=base_url();?>admin/assets/css/default/theme/default.css" rel="stylesheet" id="theme" />
	<link href="<?=base_url();?>admin/assets/plugins/modal-loading/css/modal-loading.css" rel="stylesheet" id="theme" />	
	<!-- ================== END BASE CSS STYLE ================== -->
	<link href="<?=base_url();?>admin/assets/plugins/gritter/css/jquery.gritter.css" rel="stylesheet" />
	<!-- ================== BEGIN BASE JS ================== -->
	<script src="<?=base_url();?>admin/assets/plugins/pace/pace.min.js"></script>
	<!-- ================== END BASE JS ================== -->
	<!-- ================== DataTable ================== -->
	<link href="<?=base_url();?>admin/assets/plugins/DataTables/media/css/dataTables.bootstrap.min.css" rel="stylesheet" />
	<link href="<?=base_url();?>admin/assets/plugins/DataTables/extensions/Responsive/css/responsive.bootstrap.min.css" rel="stylesheet" />
	<!-- ================== Fin DataTable ================== -->
	<style type="text/css">
		.manita{
			cursor: pointer;
		}
	</style>
</head>
<body>
	<!-- begin #page-loader -->
	<div id="page-loader" class="fade show"><span class="spinner"></span></div>
	<!-- end #page-loader -->
	
	<!-- begin #page-container -->
	<div id="page-container" class="page-container fade page-sidebar-fixed page-header-fixed">
		<!-- begin #header -->
		<div id="header" class="header navbar-default">
			<!-- begin navbar-header -->
			<div class="navbar-header">
				<a href="#" class="navbar-brand"><img src="<?=base_url();?>admin/assets/img/logo/logo-elementoh.jpg" height="40px;"></a>
				<button type="button" class="navbar-toggle" data-click="sidebar-toggled">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div>
			<!-- end navbar-header -->
			
			<!-- begin header-nav -->
			<ul class="navbar-nav navbar-right">
				<li class="dropdown navbar-user">
					<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
						<img src="<?=base_url();?>admin/assets/img/user/user.png" alt="" /> 
						<span class="d-none d-md-inline"><?=$_SESSION[PREFIJO.'_usuario']?></span> <b class="caret"></b>
					</a>
					<div class="dropdown-menu dropdown-menu-right">
						<!--<a href="javascript:;" class="dropdown-item">Edit Profile</a>-->
						<div class="dropdown-divider"></div>
						<a href="#" onclick="confirmar('¿Realmente desea cerrar sesión?',cerarSesion);" class="dropdown-item">Cerrar sesión</a>
					</div>
				</li>
			</ul>
			<!-- end header navigation right -->
		</div>
		<!-- end #header -->
		
		<!-- begin #sidebar -->
		<div id="sidebar" class="sidebar">
			<!-- begin sidebar scrollbar -->
			<div data-scrollbar="true" data-height="100%">
				<!-- inicia menú -->
				<?php echo $menu; ?>
				<!-- termina menú -->
			</div>
			<!-- end sidebar scrollbar -->
		</div>
		<div class="sidebar-bg"></div>
		<!-- end #sidebar -->
		
		<!-- begin #content -->
		<div id="contenido" class="content">
		</div>
	</div>
	<!-- end page container -->
	
	<!-- ================== BEGIN BASE JS ================== -->
	<script src="<?=base_url();?>admin/assets/plugins/jquery/jquery-3.2.1.min.js"></script>
	<script src="<?=base_url();?>admin/assets/plugins/jquery-ui/jquery-ui.min.js"></script>
	<script src="<?=base_url();?>admin/assets/plugins/bootstrap/4.0.0/js/bootstrap.bundle.min.js"></script>
	<!--[if lt IE 9]>
		<script src="../assets/crossbrowserjs/html5shiv.js"></script>
		<script src="../assets/crossbrowserjs/respond.min.js"></script>
		<script src="../assets/crossbrowserjs/excanvas.min.js"></script>
	<![endif]-->
	<script src="<?=base_url();?>admin/assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
	<script src="<?=base_url();?>admin/assets/plugins/js-cookie/js.cookie.js"></script>
	<script src="<?=base_url();?>admin/assets/js/theme/default.min.js"></script>
	<script src="<?=base_url();?>admin/assets/js/apps.min.js"></script>
	<script src="<?=base_url();?>admin/assets/plugins/parsley/dist/parsley.js?v=0.1"></script>
	<!-- ================== END BASE JS ================== -->
	<!-- ================== DataTable ================== -->
	<script src="<?=base_url();?>admin/assets/plugins/DataTables/media/js/jquery.dataTables.js"></script>
	<script src="<?=base_url();?>admin/assets/plugins/DataTables/media/js/dataTables.bootstrap.min.js"></script>
	<script src="<?=base_url();?>admin/assets/plugins/DataTables/extensions/Responsive/js/dataTables.responsive.min.js"></script>
	<script src="<?=base_url();?>admin/assets/js/demo/table-manage-responsive.demo.min.js"></script>
	<!-- ================== FIN DataTable ================== -->
	<!--Libreria de notificaciones y funciones base -->
	<script src="<?=base_url();?>admin/assets/plugins/gritter/js/jquery.gritter.js"></script>
	<script src="<?=base_url();?>admin/assets/plugins/bootstrap-sweetalert/sweetalert.min.js"></script>
	<script src="<?=base_url();?>admin/assets/plugins/modal-loading/js/modal-loading.js"></script>
	<script src="<?=base_url();?>admin/assets/js/funciones.js?v=1"></script>
	
	<script>
		$(document).ready(function() {
			App.init();
		});
    </script>
    <script type="text/javascript">
    	var base_url = '<?=base_url();?>';
        $(document).ready(function(){
            <?php if ($modulo_inicial != ''){ ?>
            cargar('<?=$modulo_inicial;?>','#contenido');
            <?php } ?>
        });

        function cerarSesion(){
        	$.ajax({
                url: base_url + 'salir',
                type: 'POST',
                async: true,
                success: function(htmlcode){
                    window.location.href = base_url + 'panel';
                },
                error: function(XMLHttpRequest, errMsg, exception){
                    notificacion('No pudimos cerrar su sesión','error');
                }
        	});
        }
    </script>
</body>
</html>