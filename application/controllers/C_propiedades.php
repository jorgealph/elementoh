<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_propiedades extends CI_Controller {
	public function __construct()
    {
        parent::__construct();
        session_start();
        $this->load->helper('url');
        $this->load->helper('Funciones');
        $this->load->library('Class_seguridad');
        $this->load->model('M_propiedades','mp');
    }

    public function index()
    {
    	$datos['tabla_registros'] = $this->listar_propiedades();
    	
    	$this->load->view('propiedades/index',$datos);
    }

    function buscar(){
    	if(isset($_POST['texto_busqueda']))
    	{
    		$like = $this->input->post('texto_busqueda');
    		$pag = $this->input->post('pag');

    		echo $this->listar_propiedades($pag, '',$like);
    	}
    }

    function listar_propiedades($pag=1, $where='',$like='')
    {
    	$query = $this->mp->buscar($where,$like);

    	$tabla = '<p>No se encontraron registros para mostrar.</p>';
    	
    	if($query->num_rows() > 0)
    	{
    		$tabla = '<div class="table-responsive">
    					<table class="table" id="tabla_registros">
    					<thead>
    						<tr>
    							<th>ID</th>
                                <th>Titulo</th>
    							<th>Tipo</th>
    							<th>Baños</th>
    							<th>Superificie terreno (m2)</th>
    							<th>Precio</th>
    							<th>Estado</th>
    							<th width="200px">Acciones</th>
    						</tr>
    					</thead>
    					<tbody>';

    		$registros = $query->result();
            //var_dump($registros);
    		foreach ($registros as $registro) {
                if($registro->exclusiva == 1) $registro->titulo = '<i class="text-warning fa fa-star" title="Propiedad exclusiva"></i>'.$registro->titulo;
    			//$acciones = '<i class="fa fa-key manita text-warning" ></i>&nbsp;';
    			$acciones = '<i class="fa fa-pencil-alt manita text-success" onclick="capturar('.$registro->id_propiedad.')"></i>&nbsp;';
    			$acciones.= '<i class="fa fa-trash-alt manita text-danger" onclick="confirmar(\'¿Desea eliminar este registro?\',eliminar,'.$registro->id_propiedad.');"></i>';
    		 	$tabla.= "<tr>
    		 			<td>{$registro->id_propiedad}</td>
                        <td>{$registro->titulo}</td>
    		 			<td>{$registro->tipo_propiedad}</td>
    		 			<td>{$registro->banios}</td>
    		 			<td>{$registro->superficie_terreno}</td>
    		 			<td>{$registro->precio}</td>
    		 			<td>{$registro->estado}</td>    		 			
    		 			<td>$acciones</td>
    		 		</tr>";
                    
    		} 
    		$tabla .= '</tbody>
    				</table>
    			</div>';
    		$tabla .= '<script type="text/javascript">
                    $(document).ready(function(){
                        $(\'#tabla_registros\').DataTable({
                            responsive: true,
                            searching: false,
                            lengthChange: false
                        });
                    });
                    </script>';
    	}

    	return $tabla;
    }

     function eliminar()
    {
    	if(isset($_POST['id']) && !empty($_POST['id']))
    	{
    		$this->load->model('M_seguridad');
    		$m_seg = new M_seguridad();
    		$where['id_propiedad'] = $this->input->post('id');
    		
    		echo ($m_seg->desactivar_registro('propiedades',$where)) ? "0":"El registro no pudo ser eliminado";
    	}
    }

    function capturar()
    {
    	if(isset($_POST['id']))
    	{
    		$id_propiedad = $this->input->post('id');
            // Datos para las previews de las imagenes
            $datos['numimgsprev'] = 0;
            $datos['initialPreview_img'] = '';
            $datos['initialPreviewConfig_img'] = '';
            $datos['initialPreview_ficha'] = '';
            $datos['initialPreviewConfig_ficha'] = '';
            $datos['iframe'] = '';
            $datos['link_youtube'] = '';
            $initialPreview = $initialPreviewConfig = '';
    		if($id_propiedad > 0)
    		{
    			$registro = $this->mp->datos_propiedad($id_propiedad);

    			foreach ($registro as $campo => $valor)
    			{
    				$datos[$campo] = $valor;
    			}

                if($datos['id_video_youtube'] != '')
                {
                    $datos['link_youtube'] = 'https://www.youtube.com/watch?v='.$datos['id_video_youtube'];
                    $datos['iframe'] = '<pre><div class="video-responsive" id="div_video"><iframe  src="https://www.youtube.com/embed/'.$datos['id_video_youtube'].'?autoplay=0" frameborder="0" allowfullscreen="allowfullscreen"></iframe></div><pre>';
                }
                
                /**
                *  Ficha técnica
                **/
                if($datos['ficha_tecnica'] != '')
                {
                    $datos['initialPreview_ficha'] = '\''.base_url().'/public/images/'.$datos['ficha_tecnica'].'\'';
                    $datos['initialPreviewConfig_ficha'] = '{caption: "'.$datos['ficha_tecnica'].'", url: "'.base_url().'C_propiedades/eliminar_imagen", previewAsData:true, key:'.$id_propiedad.'}';
                }

    			$datos['exclusiva'] = ($datos['exclusiva'] > 0) ? 'checked="checked"':'';
                /**
                * .--Ficha técnica
                **/

                /**
                *   Archivos adjuntos
                **/
                $registros = $this->mp->propiedad_adjuntos($id_propiedad);
                $registros = $registros->result();
            
                foreach ($registros as $registro) 
                {
                    $initialPreview .= ($initialPreview != '') ? ',':'';
                    $initialPreview .= '\''.base_url().'/public/images/'.$registro->nombre.'\'';

                    $initialPreviewConfig .= ($initialPreviewConfig != '') ? ',':'';
                    if($registro->tipo == 1)
                    {
                        $initialPreviewConfig .= '{caption: "'.$registro->nombre.'",  height: "120px", url: "'.base_url().'C_propiedades/eliminar_imagen", previewAsData:true, key:'.$registro->id_propiedad_adjunto.'}' ;
                    }
                    if($registro->tipo == 2)
                    {
                        $initialPreviewConfig .= '{type: "pdf", caption: "'.$registro->nombre.'",  height: "120px", url: "'.base_url().'C_propiedades/eliminar_imagen", previewAsData:true, key:'.$registro->id_propiedad_adjunto.'}' ;
                    }
                    $datos['numimgsprev']++;
                }

                $datos['initialPreview_img'] = $initialPreview;
                $datos['initialPreviewConfig_img'] = $initialPreviewConfig;

                /**
                *   .--Archivos adjuntos
                **/
    		}
    		else
    		{
    			$query = $this->mp->campos_tabla();
    			if($query)
				{
					$query = $query->result();
					foreach ($query as $registro)
					{
						$datos[$registro->Field] = $registro->Default;
					}

					$datos['exclusiva'] = ($datos['exclusiva'] > 0) ? 'checked="checked"':'';
					$datos['id_propiedad'] = 0;
					$datos['id_entidad'] = 0;
					$datos['id_municipio'] = 0;
					$datos['id_localidad'] = 0;
					$datos['id_asentamiento'] = 0;
					$datos['latitud'] = $datos['longitud'] = 0;
				}	
    		}

    		$where_municipio['id_entidad'] = $datos['id_entidad'];
    		$where_localidad['id_municipio'] = $datos['id_municipio'];
    		$where_asentamiento['id_localidad'] = $datos['id_localidad'];
    		$where_codigo['id_asentamiento'] = $datos['id_asentamiento'];
    		$this->load->library('Class_options');
    		$cls_opts = new Class_options();
            $datos['options_periodicidad'] = $cls_opts->options_tabla('periodicidad',$datos['id_periodicidad']);
    		$datos['options_tipo_propiedad'] = $cls_opts->options_tabla('tipos_propiedad',$datos['id_tipo_propiedad']);
            $datos['options_tipo_operacion'] = $cls_opts->options_tabla('tipos_operacion',$datos['id_tipo_operacion']);
    		$datos['options_entidad'] = $cls_opts->options_tabla('entidades',$datos['id_entidad']);
    		$datos['options_municipio'] = $cls_opts->options_tabla('municipios',$datos['id_municipio'],$where_municipio);
    		$datos['options_localidad'] = $cls_opts->options_tabla('localidades',$datos['id_localidad'],$where_localidad);
    		$datos['options_asentamiento'] = $cls_opts->options_tabla('asentamientos',$datos['id_asentamiento'],$where_asentamiento);
    		$datos['options_codigo_postal'] = $cls_opts->options_tabla('codigos_postales',$datos['codigo_postal'],$where_codigo);
    		$datos['options_zona'] = $cls_opts->options_tabla('zonas',$datos['id_zona']);
    		
    		$this->load->view('propiedades/capturar',$datos);
    	}
    }

    function guardar()
    {
    	$this->load->model('M_seguridad');
    	$mseg = new M_seguridad();
    	$id_propiedad = $this->input->post('id_propiedad');
    	$datos['titulo'] = $this->input->post('titulo');
    	$datos['descripcion'] = $this->input->post('descripcion');
    	$datos['precio'] = $this->input->post('precio');
    	$datos['id_tipo_propiedad'] = $this->input->post('id_tipo_propiedad');
    	$datos['exclusiva'] = (isset($_POST['exclusiva'])) ? 1:0;
    	$datos['recamaras'] = $this->input->post('recamaras');
    	$datos['banios'] = $this->input->post('banios');
    	$datos['garage_autos'] = $this->input->post('garage_autos');
    	$datos['niveles'] = $this->input->post('niveles');
    	$datos['anio_construccion'] = $this->input->post('anio_construccion');
    	$datos['superficie_construccion'] = $this->input->post('superficie_construccion');
    	$datos['superficie_terreno'] = $this->input->post('superficie_terreno');
    	$datos['estado'] = $this->input->post('estado');
    	$datos['id_tipo_operacion'] = $this->input->post('id_tipo_operacion');
    	$datos['id_zona'] = $this->input->post('id_zona');
    	$datos['id_asentamiento'] = $this->input->post('id_asentamiento');
    	$datos['codigo_postal'] = $this->input->post('codigo_postal');
    	$datos['latitud'] = $this->input->post('latitud');
    	$datos['longitud'] = $this->input->post('longitud');
    	$datos['id_video_youtube'] = $this->input->post('id_video_youtube');
        $datos['fecha_captura'] = date('Y-m-d H:i:s');
    	$datos['id_usuario'] = $_SESSION[PREFIJO.'_idusuario'];
        $datos['id_periodicidad'] = $this->input->post('id_periodicidad');
        //$fichaelim = (int)$this->input->post('fichaelim');

    	if($id_propiedad > 0)
    	{
            /*if($fichaelim > 1)
            {
                $ruta_ficha = 'public/images/ficha-'.$id_propiedad.'.pdf';
                if(file_exists($ruta_ficha))
                {
                    if(unlink($ruta_ficha)) $datos['ficha_tecnica'] = '';
                }
            }*/
    		$where['id_propiedad'] = $id_propiedad;
    	   	$id_usuario = $mseg->actualizar_registro('propiedades',$where,$datos);
            //echo $_SESSION['sql'];
    	   	echo "0-$id_propiedad";
    	}
    	else
    	{
    		$con = $mseg->iniciar_transaccion();
    		$id_propiedad = $mseg->insertar_registro('propiedades',$datos,$con);

    		if($mseg->terminar_transaccion($con)) echo "0-$id_propiedad";
    		else echo $_SESSION['ultimo_error_bd']; //echo 'Ha ocurrido un error';
    	}

    }

    public function cargar_options()
    {
    	if(isset($_POST['listado']) && isset($_POST['valor']))
    	{
    		$listado = $this->input->post('listado');
    		$valor = $this->input->post('valor');

    		$this->load->library('Class_options');
    		$cls_opts = new Class_options();

    		if($listado == 'municipios')
    		{
    			$where['id_entidad'] = $valor;
    			echo $cls_opts->options_tabla('municipios',0,$where);
    		}

    		if($listado == 'localidades')
    		{
    			$where['id_municipio'] = $valor;
    			echo $cls_opts->options_tabla('localidades',0,$where);
    		}

    		if($listado == 'asentamientos')
    		{
    			$where['id_localidad'] = $valor;
    			echo $cls_opts->options_tabla('asentamientos',0,$where);
    		}

    		if($listado == 'codigos_postales')
    		{
    			$where['id_asentamiento'] = $valor;
    			echo $cls_opts->options_tabla('codigos_postales',0,$where);
    		}

            if($listado == 'municipios_propiedades')
            {
                $where['m.id_entidad'] = $valor;
                echo $cls_opts->options_tabla('municipios_propiedades',0,$where);
            }

            if($listado == 'localidades_propiedades')
            {
                $where['l.id_municipio'] = $valor;
                echo $cls_opts->options_tabla('localidades_propiedades',0,$where);
            }
    	}
    }

    function subir_fotos()
    {
        if(isset($_POST['id_propiedad']) && !empty($_POST['id_propiedad']))
        {
            $this->load->model('M_seguridad');
            $mseg = new M_seguridad();
            $id_propiedad = $this->input->post('id_propiedad');
            $num = $this->input->post('num');
            $elim = $this->input->post('elim');
            $ruta = 'public/images/';

            //  Guardamos los nuevos archivos
            if(!empty($_FILES))
            {
                $n = $this->mp->numero_imagenes_por_propiedad($id_propiedad);
                $n++;

                for ($i=0; $i < $num ; $i++)
                {

                    $nombre_orig = $_FILES["adjuntoFotos"]["name"][$i];
                    $nombre_temp = $_FILES["adjuntoFotos"]["tmp_name"][$i];                    
                    
                    $resto = explode(".", $nombre_orig); 
                    $extension = end($resto);
                    $nombre_img = 'prop-'.$id_propiedad.'-'.$n.'.'.$extension;
                    $tipo = ($extension == 'pdf') ? 2:1;
                    if(move_uploaded_file($nombre_temp, $ruta.$nombre_img))
                    {
                        $datos = array( 'id_propiedad' => $id_propiedad,
                                        'numero' => $n,
                                        'nombre' => $nombre_img,
                                        'nombre_original' => $nombre_orig,
                                        'ext' => $extension,
                                        'tipo' => $tipo,
                                        'activo' => 1 );
                        $mseg->insertar_registro('propiedades_adjuntos',$datos);
                        $n++;
                    }
                }

            }

            //  Eliminamos los viejos adjuntos
            if(isset($_POST['elim']) && !empty($_POST['elim']))
            {
                $elim = explode(",",$elim);
                for ($i=0; $i < count($elim); $i++)
                { 
                    $adj = $this->mp->datos_adjunto($elim[$i]);

                    if(file_exists($ruta.$adj->nombre))
                    { 
                        if(unlink($ruta.$adj->nombre))
                        {
                            $mseg->actualizar_registro('propiedades_adjuntos',array('id_propiedad_adjunto' => $elim[$i]),array('activo' => 0));
                        }
                    }
                }

            }
            
            echo json_encode(true);
            
        }
    }

    function eliminar_imagen()
    {
        echo json_encode(true);
    }

    function subir_ficha()
    {
        if(isset($_POST['id_propiedad']) && !empty($_POST['id_propiedad']))
        {
            $this->load->model('M_seguridad');
            $mseg = new M_seguridad();
            $id_propiedad = $this->input->post('id_propiedad');
            //$elim = $this->input->post('elim');
            $ruta = 'public/images/';

            //  Guardamos los nuevos archivos
            if(!empty($_FILES))
            {
                $i = 0;
                $nombre = $_FILES["adjuntoFicha"]["name"][$i];
                $nombre_temp = $_FILES["adjuntoFicha"]["tmp_name"][$i];                    
                
                $resto = explode(".", $nombre); 
                $extension = end($resto);
                $nombre_ficha = 'ficha-'.$id_propiedad.'.'.$extension;

                if(move_uploaded_file($nombre_temp, $ruta.$nombre_ficha))
                {
                    $datos = array('ficha_tecnica' => $nombre_ficha);
                    $where = array('id_propiedad' => $id_propiedad);
                    $mseg->actualizar_registro('propiedades',$where,$datos);
                }
            }   
            echo json_encode(true);
        }
    }

    function generar_ficha_propiedad($id)
    {
        
        //$id_propiedad = $this->input->post('id');
        $this->load->library('Class_pdf');

        //$dimensiones = array(216,279);  // Tamaño carta:216 x 279
        $dimensiones = array(210,297);  // Tamaño carta:216 x 279
        $altoencabezado = 30;
        $PDF = new Class_PDF('L', 'mm', $dimensiones, true, 'UTF-8', false);

        $PDF->AddPage('P',$dimensiones);
        $PDF->SetFont('helvetica','',10);
        $PDF->SetTopMargin($altoencabezado);
        $PDF->SetTextColor(0,0,0);      //  Color de los textos
        $PDF->SetDrawColor(0,0,0);      //  Color de los bordes
        $PDF->SetFillColor(217,217,217);//  Color de relleno
        $PDF->SetLineWidth(0.1);        // Ancho de borde
        $PDF->SetLineStyle(array('width' => 0.2, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(217, 217, 217)));

        $datos = $this->mp->datos_propiedad($id);
        $datos_contacto = $this->mp->datos_contacto();
        $datos->precio = '$'.DecimalMoneda($datos->precio);
        $datos->superficie_terreno = ($datos->superficie_terreno > 0) ? DecimalMoneda($datos->superficie_terreno):'N/D';
        $datos->superficie_construccion = ($datos->superficie_construccion > 0) ? DecimalMoneda($datos->superficie_construccion):'N/D';
        if($datos->recamaras == 0) $datos->recamaras = 'N/D';
        if($datos->banios == 0) $datos->banios = 'N/D';
        if($datos->garage_autos == 0) $datos->garage_autos = 'N/D';

        $imagenes = $this->mp->listar_imagenes_propiedad($id,3);
        $img_principal = 'public/images/'.$this->mp->imagen_principal($id);
        $img_logo = 'public/images/logotipo_pajarito_blanco.jpg';
        $ubicación = $datos->asentamiento.' '.$datos->codigo_postal.' '.$datos->municipio.','.$datos->entidad;
       
        $yinicio = 10;
        $PDF->Image($img_principal, 0, $yinicio, 216, 80, '', '', '', false, 300, 'C', false, false, 0,false, false,true);
        
        $PDF->Image($img_logo, $PDF->GetX(), 80+$yinicio, 75, 37, '', '', '', false, 300, '', false, false, 0);
        //Titulo
        $PDF->SetFont('helvetica','B',16);
        $PDF->Multicell(0,0,$datos->titulo,0,'L',false,1,$PDF->GetX()+100,90+$yinicio);

        if($imagenes->num_rows() > 0)
        {
            $imagenes = $imagenes->result();
            $n = 0;
            $x = $PDF->GetX();
            $horizontal_alignments = array('L', 'C', 'R');
            foreach ($imagenes as $imagen)
            {
                $img = 'public/images/'.$imagen->nombre;
                //$PDF->Image($img, $n*80, 128, 0, 40, '', '', '', true, 300, '', false, false, 0);
                $PDF->Image($img, $x, 128, 60, 0, '', '', '', true, 300, $horizontal_alignments[$n], false, false, 0,true);
                $x = $x+60;
                $n++;
            }
        }



        $y = 170;
        $altot1 = 14;
        $altot2 = 7;
        $altot3 = 10;
        $PDF->SetFont('helvetica','B',18);
        $PDF->SetTextColor(124, 189, 30);
        $PDF->Multicell(80,$altot1,$datos->precio,'B','L',false,0,'',$y);
        $PDF->SetFont('helvetica','',7);
        $PDF->SetTextColor(33,37,41);
        $xtemp = $PDF->GetX();
        $PDF->Multicell(20,$altot1/2,'RECAMARAS',0,'L',false,0,'','');
        $PDF->Multicell(20,$altot1/2,'BAÑOS',0,'L',false,0,'','');
        $PDF->Multicell(20,$altot1/2,'GARAGE (AUTOS)',0,'L',false,1,'','');
        $PDF->SetFont('helvetica','B',8);
        $PDF->Multicell(20,$altot1/2,$datos->recamaras,'B','L',false,0,$xtemp,'');
        $PDF->Multicell(20,$altot1/2,$datos->banios,'B','L',false,0,'','');
        $PDF->Multicell(20,$altot1/2,$datos->garage_autos,'B','L',false,1,'','');
        //140

        $PDF->SetFont('helvetica','',8);
        $PDF->Multicell(60,$altot2,'ZONA',0,'L',false,0,'','');
        $PDF->Multicell(80,$altot2,'TIPO DE PROPIEDAD',0,'L',false,0,'','');
        $PDF->Multicell(5,$altot2,'',0,'L',false,0,'','');
        $PDF->Multicell(40,$altot2,'CONTACTO',0,'L',false,1,'','');

        $PDF->SetFont('helvetica','B',9);
        $PDF->Multicell(60,$altot2,$datos->zona,'B','L',false,0,'','');
        $PDF->Multicell(80,$altot2,$datos->tipo_propiedad,'B','L',false,0,'','');
        $PDF->Multicell(5,$altot2,'',0,'L',false,0,'','');
        $PDF->Multicell(0,$altot2,'Dirección',0,'L',false,1,'','');

        $PDF->SetFont('helvetica','',8);
        $PDF->Multicell(60,$altot2,'M2 DEL TERRENO',0,'L',false,0,'','');
        $PDF->Multicell(80,$altot2,'M2 DE CONSTRUCCIÓN',0,'L',false,0,'','');
        $PDF->Multicell(5,$altot2,'',0,'L',false,0,'','');
        $PDF->Multicell(0,10,$datos_contacto->direccion,0,'L',false,1,'','');

        $PDF->SetFont('helvetica','B',9);
        $PDF->Multicell(60,$altot2,$datos->superficie_terreno,'B','L',false,0,'','');
        $PDF->Multicell(80,$altot2,$datos->superficie_construccion,'B','L',false,0,'','');
        $PDF->Multicell(5,$altot2,'',0,'L',false,0,'','');
        $PDF->Multicell(40,$altot2,'Teléfono',0,'L',false,1,'','');
        

        $PDF->SetFont('helvetica','B',14);
        $PDF->Multicell(140,$altot3,'Ubicación',0,'L',false,0,'','');
        $PDF->SetFont('helvetica','',8);
        $PDF->Multicell(5,$altot3,'',0,'L',false,0,'','');
        $PDF->Multicell(140,$altot3,$datos_contacto->telefono,0,'L',false,1,'','');

        $PDF->Multicell(140,$altot3,$ubicación,'B','L',false,0,'','');
        $PDF->SetFont('helvetica','B',9);
        $PDF->Multicell(5,$altot3,'',0,'L',false,0,'','');
        $PDF->Multicell(140,$altot3,'Email',0,'L',false,1,'','');

        $PDF->SetFont('helvetica','B',14); 
        $PDF->Multicell(140,$altot3,'Detalles',0,'L',false,0,'','');
        $PDF->SetFont('helvetica','',8);
        $PDF->Multicell(5,$altot3,'',0,'L',false,0,'','');
        $PDF->Multicell(140,$altot3,$datos_contacto->email,0,'L',false,1,'','');

        $PDF->Multicell(140,$altot1,$datos->descripcion,0,'L',false,0,'','');
        
        try
        {

            //$ruta = base_url()."docs/pdf/$repobraid.pdf";
            $ruta = "docs/fichas/repobraid.pdf";
            //$PDF->Output($ruta, 'F');
            $PDF->Output($ruta, 'I');
            echo '0';
        }
        catch (Exception $e)
        {   
            echo 'Error: '.$e->getMessage();
        }
    }

        
    

}
?>