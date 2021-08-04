<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_seguridad extends CI_Controller {
	public function __construct()
    {
        parent::__construct();
        session_start();
        $this->load->helper('url');
        $this->load->helper('Funciones');
        $this->load->library('Class_seguridad');
        $this->load->model('M_seguridad','ms');
    }

    public function index()
	{
		$this->load->library('Class_options');
		$this->load->model('M_propiedades');
		$mp = new M_propiedades();
		$options = new Class_options();
		$where_municipio['id_entidad'] = 0;
		$where_localidad['id_municipio'] = 0;
		$where_asentamiento['id_localidad'] = 0;
		$datos['options_tipo_propiedad'] = $options->options_tabla('tipos_propiedad');
		$datos['options_tipo_operacion'] = $options->options_tabla('tipos_operacion');
    	$datos['options_entidad'] = $options->options_tabla('entidades_propiedades',0);
    	$datos['options_municipio'] = $options->options_tabla('municipios',0,$where_municipio);
    	$datos['options_localidad'] = $options->options_tabla('localidades',0,$where_localidad);
    	//$datos['options_asentamiento'] = $options->options_tabla('asentamientos',0,$where_asentamiento);
    	
    	//$datos['options_zona'] = $options->options_tabla('zonas',0);
    	//$datos['options_recamara'] = $options->options_tabla('recamaras',0);
    	//$datos['options_banio'] = $options->options_tabla('banios',0);
    	//$datos['options_garage'] = $options->options_tabla('garage_autos',0);

    	$query = $mp->buscar_propiedades();
		$datos['listado_propiedades'] = $this->listar_propiedades($query,1);
		$datos['ultimas_propiedades'] = $this->listar_ultimas_propiedades('');
		$this->load->view('index.php',$datos);
		
	}

	public function acceder_administrador()
	{		
		if(!isset($_SESSION[PREFIJO.'_idusuario']) || empty($_SESSION[PREFIJO.'_idusuario']))
		{
			$this->mostrar_login();
		}
		else
		{
			$this->mostrar_inicio();	
		}
	}

	public function mostrar_login()
	{
		$this->load->view('seguridad/login');
	}

	function mostrar_inicio()
	{
		if(isset($_SESSION[PREFIJO.'_idrol']) && !empty($_SESSION[PREFIJO.'_idrol']))
		{
			$idrol = (int)$_SESSION[PREFIJO.'_idrol'];
			$idusuario = (int)$_SESSION[PREFIJO.'_idusuario'];
			
			$this->load->library('Class_seguridad');
			$ms = new Class_seguridad();
			$aux = $ms->pintar_menu($idusuario);
			$datos['menu'] = $aux['menu'];
			$datos['modulo_inicial'] = $aux['modulo_inicial'];;
			
			$this->load->view('seguridad/admin',$datos);

		}else $this->index();
	}

	public function iniciar_sesion()
	{
		if(isset($_POST['usuario']) && !empty($_POST['usuario']) && isset($_POST['password']) && !empty($_POST['password']))
		{
			//	Datos Recaptcha Google
			/*$secret = '6LcFNH0UAAAAANR1lPEs3ezWT_mUor1PiT60wn_P';
	    	$response = $_POST["g-recaptcha-response"];
	    	$remoteip =  $_SERVER['REMOTE_ADDR'];

	    	$url = 'https://www.google.com/recaptcha/api/siteverify';

	    	$captcha = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$response&remoteip=$remoteip");
			$json = json_decode($captcha);
			
			if($json->success)
			{*/
				$where['u.correo'] =  $this->input->post('usuario');
                $where['u.password'] = sha1($this->input->post('password'));
				$query = $this->ms->consulta_existe_usuario($where);
				
				if($query)
				{
					if($query->num_rows() > 0)
					{
						$du = $query->row();
                        $_SESSION[PREFIJO.'_idusuario'] = $du->id_usuario;
                        $_SESSION[PREFIJO.'_idrol'] = $du->id_rol;
                        $_SESSION[PREFIJO.'_nombre'] = $du->nombres.' '.$du->apellido_paterno.' '.$du->apellido_materno ;
                        $_SESSION[PREFIJO.'_usuario'] = $du->correo;

                        echo '0';
					}
					else echo 'Datos incorrectos';
				}else echo 'Ha ocurrido un error. Contacte al administrador.';
			/*
			}
			else
			{
				echo 'Resuelva el captcha para continuar';
			}*/
			
		}else echo 'Datos insuficientes';
	}

	public function cerrar_sesion()
	{
		/*if(isset($_SESSION) && !empty($_SESSION))
		{
			foreach ($_SESSION as $key => $value)
			{
				session_unset($key);
			}
		}*/
		/*session_unset(PREFIJO.'_idusuario');
        session_unset(PREFIJO.'_idrol');
        session_unset(PREFIJO.'_nombre');
        session_unset(PREFIJO.'_usuario');*/
        session_unset();
        session_destroy();

		$this->acceder_administrador();
	}

	function buscar_propiedades()
	{
		if($_POST)
		{
			$this->load->model('M_propiedades');
			$mp = new M_propiedades();

			$where = array();
			$estado = $this->input->post('estado');
			//$municipio = $this->input->post('municipio');
			//$localidad = $this->input->post('localidad');
			$tipo_propiedad = $this->input->post('tipo_propiedad');
			$tipo_operacion = $this->input->post('tipo_operacion');
			/*$asentamiento = $this->input->post('id_asentamiento');
			$zona = $this->input->post('zona');			
			$recamaras = $this->input->post('recamaras');
			$banios = $this->input->post('banios');
			$garage = $this->input->post('garage');*/

			$pag = $this->input->post('pag');

			$order_by = $this->input->post('order_by');

			if($estado > 0) $where['m.id_entidad'] = $estado;
			//if($municipio > 0) $where['m.id_municipio'] = $municipio;
			//if($localidad > 0) $where['l.id_localidad'] = $localidad;
			if($tipo_propiedad > 0) $where['p.id_tipo_propiedad'] = $tipo_propiedad;
			if($tipo_operacion > 0) $where['p.id_tipo_operacion'] = $tipo_operacion;
			/*if($asentamiento > 0) $where['p.id_asentamiento'] = $asentamiento;
			if($zona > 0) $where['p.id_zona'] = $zona;			
			if($recamaras > 0) $where['p.recamaras'] = $recamaras;
			if($banios > 0) $where['p.banios'] = $banios;
			if($garage > 0) $where['p.garage_autos'] = $garage;*/
			
			$query = $mp->buscar_propiedades($where,'',$order_by);

			echo $this->listar_propiedades($query,$pag);
		}
	}

	function listar_propiedades($query,$pag=1)
	{
		$this->load->model('M_propiedades');
		$mp = new M_propiedades();

		$html = '<p>Sin resultados</p>';

		$aux = paginador($query,$pag,9,2);
		if($aux['total_registros'] > 0)
		{
			$html = '';
			$registros = $aux['registros'];
			$html .= '<div class="row mb-5">';
			foreach ($registros as $registro)
			{
				$registro->precio = '$'.DecimalMoneda($registro->precio).' M.N.';
				$registro->superficie_construccion = ($registro->superficie_construccion > 0) ? DecimalMoneda($registro->superficie_construccion):'N/A';
				$registro->superficie_terreno = ($registro->superficie_terreno > 0) ? DecimalMoneda($registro->superficie_terreno):'N/A';
				// Slider
				$slider = '';

				if($registro->id_video_youtube != '') $slider.= ' <iframe allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen="" frameborder="0" height="220" src="https://www.youtube.com/embed/'.$registro->id_video_youtube.'" width="100%"></iframe>';

				$imagenes = $mp->listar_imagenes_propiedad($registro->id_propiedad);
				if($imagenes->num_rows() > 0)
				{
					$imagenes = $imagenes->result();

					foreach ($imagenes as $imagen)
					{
						$slider.= '<div><img alt="Image" class="img-fluid" src="'.base_url().'public/images/'.$imagen->nombre.'" height="500px;" /></div>';
					}
				}
				else
				{
					if($slider == '')
					{ 
						$slider.= '<div><img alt="Image" class="img-fluid" src="'.base_url().'public/images/no_foto.png" /></div>';
					}
				}
				//.-Slider

				$periodicidad = ($registro->periodicidad != '') ? '<a class="property-thumbnail" href="property-details-serena.html"><span class="offer-type '.$registro->class.'">'.$registro->periodicidad.'</span></a>':'';
				$ubicacion = "{$registro->entidad}, {$registro->municipio}";
				$html.= '<div class="col-md-6 col-lg-4 mb-4">
							<div class="property-entry h-100">
							<div class="offer-type-wrap"><a class="property-thumbnail" href="property-details-serena.html"><span class="offer-type '.$registro
							->class.'">'.$registro->tipo_operacion.'</span></a>'.$periodicidad.'
							</div>

							<div class="slide-one-item home-slider owl-carousel carrusel">
								'.$slider.'
							</div>

							<div class="p-4 property-body">
								<h2 class="property-title"><a href="'.base_url().'detalle_propiedad
								/'.$registro->id_propiedad.'">'.$registro->titulo.'</a></h2>
								<span class="property-location d-block mb-3"><b>'.$registro->tipo_propiedad.'</b></span>
								<span class="property-location d-block mb-3">'.$ubicacion.'</span> 
								<strong class="property-price text-primary mb-3 d-block text-success">'.$registro->precio.'</strong>
								<ul class="property-specs-wrap mb-3 mb-lg-0">
									<li><span class="property-specs text-center">Rec&aacute;maras</span><div class="text-center"><span class="property-specs-number">'.$registro->recamaras.' </span></div></li>
									<li><span class="property-specs">Ba&ntilde;os</span><div class="text-center"><span class="property-specs-number">'.$registro->banios.'</span></div></li>
									<li><span class="property-specs">Estacionamiento</span><div class="text-center"><span class="property-specs-number">'.$registro->garage_autos.'</span></div></li>
									<li><span class="property-specs">m&sup2; Terreno</span><div class="text-center"><span class="property-specs-number">'.$registro->superficie_terreno.'</span></div></li>
									<li><span class="property-specs">m&sup2; Construcci&oacute;n</span><div class="text-center"><span class="property-specs-number">'.$registro->superficie_construccion.'</span></div></li>
								</ul>								
							</div>
						</div>
					</div>';
		    }
		    $html.= '</div>';
		    $html.= $aux['botones_paginacion'];
		    $html.= '<script type="text/javascript">
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
					    animateOut: \'fadeOut\',
					    animateIn: \'fadeIn\',
					    navText: [\'<span class="icon-arrow_back">\', \'<span class="icon-arrow_forward">\']
					  });
				})
		    </script>';

		}

		return $html;
	}

	public function listar_ultimas_propiedades($num)
	{
		$this->load->model('M_propiedades');
		$mp = new M_propiedades();
		$query = $mp->listar_ultimas_propiedades($num);
		$html = '';
		if($query->num_rows() > 0)
	    {
			$registros = $query->result();
			foreach ($registros as $registro)
			{
				$imagen = '';
				$query = $mp->listar_imagenes_propiedad($registro->id_propiedad,1);
				if($query->num_rows() > 0) $imagen = $query->row()->nombre;

				$periodicidad = ($registro->periodicidad != '') ? '<br><span class="d-inline-block '.$registro->class.' text-white px-3 mb-3 property-offer-type rounded">'.$registro->periodicidad.'</span>':'';

				$html.= '<div class="site-blocks-cover overlay" style="background-image: url('.base_url().'public/images/'.$imagen.');" data-aos="fade" data-stellar-background-ratio="0.8">
				  <div class="container">
				      <div class="row align-items-center justify-content-center text-center">
				          <div class="col-md-10">
				          	<span class="d-inline-block '.$registro->class.' text-white px-3 mb-3 property-offer-type rounded">'.$registro->tipo_operacion.'</span>'.$periodicidad.'
				              <h1 class="mb-2">'.$registro->titulo.'</h1>
				              <p class="mb-5"><strong class="h2 text-success font-weight-bold">$'.DecimalMoneda($registro->precio).' M.N.</strong></p>
				              <p><a href="'.base_url().'detalle_propiedad/'.$registro->id_propiedad.'" class="btn btn-white btn-outline-white py-3 px-5 rounded-0 btn-2">Ver Detalles</a></p>
				          </div>
				      </div>
				  </div>
				</div>';
			}      
	    }

	    return $html;
	}

	public function detalle_propiedad($id)
	{
		$id_propiedad = (int)$id;
		$this->load->model('M_propiedades');
		$mp = new M_propiedades();

		$datos['iframe'] = '';

		$registro = $mp->datos_propiedad($id);
		foreach ($registro as $campo => $valor)
		{
			$datos[$campo] = $valor;
		}

		if($datos['id_video_youtube'] != '')
        {
           // $datos['iframe'] = '<div class="video-responsive" id="div_video"><iframe  src="https://www.youtube.com/embed/'.$datos['id_video_youtube'].'?autoplay=0" frameborder="0" allowfullscreen="allowfullscreen"></iframe></div>';

        	 $datos['iframe'] = '<iframe width="100%" height="315" src="https://www.youtube.com/embed/'.$datos['id_video_youtube'].'?autoplay=0" frameborder="0" allowfullscreen="allowfullscreen"></iframe>';
        }

		$datos['slider_imagenes'] = $datos['galeria_imagenes'] = $datos['imagen_principal'] = $datos['documentacion'] = '';
		$registros = $mp->propiedad_adjuntos($id);
		if($registros->num_rows() > 0)
		{
			$registros = $registros->result();
			foreach ($registros as $registro)
			{
				if(empty($datos['imagen_principal']) && $registro->tipo == 1) $datos['imagen_principal'] = $registro->nombre;

				if($registro->tipo == 1)
				{
					$datos['slider_imagenes'].= '<div><img src="'.base_url().'public/images/'.$registro->nombre.'" alt="Image" class="img-fluid"></div>';
					$datos['galeria_imagenes'].= '<div class="col-sm-6 col-md-4 col-lg-3">
		                  <a href="'.base_url().'public/images/'.$registro->nombre.'" class="image-popup gal-item"><img src="'.base_url().'public/images/'.$registro->nombre.'" title="'.$registro->nombre_original.'"  alt="Image" class="img-fluid" height="500px;"></a>
		                </div>';
		        }

		        if($registro->tipo == 2)
				{
                	$datos['documentacion'].= '<div class="col-md-4"><h5>'.$registro->nombre_original.'</h5>
		                <a href="'.base_url().'public/images/'.$registro->nombre.'" target="_blank">
		                  <img src="'.base_url().'admin/assets/img/icon_pdf_download.png" class="img-thumbnail" width="150px;" title="Clic para descargar">
		                </a>
		            </div>';
		        }
			}
		}
		$datos['tipo_operacion'] =$datos['tipo_operacion'];
		if($datos['periodicidad'] != '') $datos['tipo_operacion'].= ' ('.$datos['periodicidad'].')';
		$datos['anio_construccion'] = ($datos['anio_construccion'] > 0) ? $datos['anio_construccion']:'N/A';
		$datos['precio'] = "$".DecimalMoneda($datos['precio']).' M.N.';
		$datos['superficie_terreno'] = ($datos['superficie_terreno'] > 0) ? DecimalMoneda($datos['superficie_terreno']):'N/A';
		$datos['superficie_construccion'] = ($datos['superficie_construccion'] > 0) ? DecimalMoneda($datos['superficie_construccion']):'N/A';
		$datos['visitas'] = 144;
		$datos['ubicacion'] = $datos['asentamiento'].' '.$datos['codigo_postal'].' '.$datos['municipio'].','.$datos['entidad'];
		$this->load->view('detalle_propiedad',$datos);
	}

	function enviar_correo(){
		if(isset($_POST['correo']) && !empty($_POST['correo'])){
			$correo = $this->input->post('correo');
			$correo_reply = 'noreply@elementoh.com.mx';
			$asunto = $this->input->post('asunto');
			$mensaje = $this->input->post('mensaje');
			$nombre = $this->input->post('nombre');

			$headers = "From: " . strip_tags($correo_reply) . "\r\n";
			$headers .= "CC: jorge.alph@gmail.com\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
			
			$html = "<p><b>$nombre</b>  escribió el siguiente mensaje:</p>
					<p><b>Asunto:</b> $asunto</p>

					<p><b>Mensaje:</b> $mensaje</p>
					<p><b>Correo de contacto:</b> $correo</p>";

			// Enviarlo
			if(mail('josue.herrera@elementoh.com.mx', $asunto, $html,$headers)) echo '0';
			else echo 'No se ha podido enviar el correo';

			/*$this->load->library('Class_mail');
			$mail = new Class_mail();

			//$template = 'templates/confirmar_correo.html';
			//$mensaje = file_get_contents($template);
			$nombre = htmlentities($nombre, ENT_QUOTES, "UTF-8");
			
			$asunto = utf8_decode($asunto);

			if($mail->enviar_correo($correo,$asunto,$mensaje)) echo '0';		    			
			else echo 'No se ha podido enviar el correo';*/
		}
	}

	function enviar_correo2(){
		if(isset($_POST['correo']) && !empty($_POST['correo'])){
			$correo = trim($this->input->post('correo'));
			$correo_reply = 'noreply@elementoh.com.mx';
			$titulo = $this->input->post('titulo');
			$asunto = 'Interesado en la propiedad '.$titulo;
			$telefono = trim($this->input->post('telefono'));
			$nombre = $this->input->post('nombre');

			$headers = "From: " . strip_tags($correo_reply) . "\r\n";
			$headers .= "CC: jorge.alph@gmail.com\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
			
			$html = "<p><b>$nombre</b>  esta interesado en la propiedad: <b>$titulo</b></p>
					<p><b>Telefono de contacto:</b> $telefono</p>
					<p><b>Correo de contacto:</b> $correo</p>";

			// Enviarlo
			if(mail('josue.herrera@elementoh.com.mx', $asunto, $html,$headers)) echo '0';
			else echo 'No se ha podido enviar el correo';

			/*$this->load->library('Class_mail');
			$mail = new Class_mail();

			//$template = 'templates/confirmar_correo.html';
			//$mensaje = file_get_contents($template);
			$nombre = htmlentities($nombre, ENT_QUOTES, "UTF-8");
			
			$asunto = utf8_decode($asunto);

			if($mail->enviar_correo($correo,$asunto,$mensaje)) echo '0';		    			
			else echo 'No se ha podido enviar el correo';*/
		}
	}
}
