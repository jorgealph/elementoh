<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_secciones extends CI_Controller {
	public function __construct()
    {
        parent::__construct();
        session_start();
        $this->load->helper('url');
        $this->load->helper('Funciones');
        $this->load->library('Class_seguridad');
        $this->load->model('M_secciones','m');
    }

    function contacto()
    {
        $datos['initialPreview_img'] = $datos['initialPreviewConfig_img']  = '';
        $datos['numimgsprev'] = 0;

        $registro= $this->m->contacto();
        foreach ($registro as $campo => $valor)
        {
            $datos[$campo] = $valor;
        }

        if($datos['imagen_seccion'] != '')
        {
            $datos['initialPreview_img'] = '\''.base_url().'/public/images/'.$datos['imagen_seccion'].'\'';
            $datos['initialPreviewConfig_img'] .= '{caption: "'.$datos['imagen_seccion'].'",  height: "120px", url: "'.base_url().'C_secciones/eliminar_adjunto", previewAsData:true, key:1}' ;
            $datos['numimgsprev']++;

        }

        $this->load->view('secciones/captura_contacto',$datos);
    }

    function guardar_contacto()
    {
        $this->load->model('M_seguridad');
        $mseg = new M_seguridad();
        $where['id_contacto'] = $this->input->post('id_contacto');

        $datos['titulo_seccion'] = trim($this->input->post('titulo_seccion'));
        $datos['direccion'] = trim($this->input->post('direccion'));
        $datos['telefono'] = trim($this->input->post('telefono'));
        $datos['email'] = trim($this->input->post('email'));
        
        $id_usuario = $mseg->actualizar_registro('contacto',$where,$datos);
        
        echo "0";

    }

    function subir_fotos_contacto()
    {
        if(isset($_POST['id']) && !empty($_POST['id']))
        {
            $this->load->model('M_seguridad');
            $mseg = new M_seguridad();
            $where['id_contacto'] = $this->input->post('id');
            $num = $this->input->post('num');
            $elim = $this->input->post('elim');
            $ruta = 'public/images/';


            //  Eliminamos los viejos adjuntos
            if(isset($_POST['elim']) && !empty($_POST['elim']))
            {
                $imagen = $this->m->consulta_imagen_contacto($where['id_contacto']);
                if(file_exists($ruta.$imagen) && !is_dir($ruta.$imagen))
                { 
                    if(unlink($ruta.$imagen))
                    {
                        $mseg->actualizar_registro('contacto',$where,array('imagen_seccion' => ''));
                    }
                }
            }


            //  Guardamos los nuevos archivos
            if(!empty($_FILES))
            {
                for ($i=0; $i < $num ; $i++)
                {

                    $nombre_orig = $_FILES["adjuntoFotos"]["name"][$i];
                    $nombre_temp = $_FILES["adjuntoFotos"]["tmp_name"][$i];                    
                    
                    $resto = explode(".", $nombre_orig); 
                    $extension = end($resto);
                    $nombre_img = 'contacto.'.$extension;
                    
                    if(move_uploaded_file($nombre_temp, $ruta.$nombre_img))
                    {
                        $datos = array( 'imagen_seccion' =>  $nombre_img);
                        $mseg->actualizar_registro('contacto',$where,$datos);
                    }
                }

            }

            
            
            echo json_encode(true);
            
        }
    }

    function nosotros()
    {   
        $datos['initialPreview_img'] = $datos['initialPreviewConfig_img']  = '';
        $datos['numimgsprev'] = 0;
        $registro= $this->m->nosotros();
        $datos['tabla_secciones'] = $this->tabla_secciones();

        foreach ($registro as $campo => $valor)
        {
            $datos[$campo] = $valor;
        }

        if($datos['imagen_seccion'] != '')
        {  
            $datos['initialPreview_img'] = '\''.base_url().'/public/images/'.$datos['imagen_seccion'].'\'';
            $datos['initialPreviewConfig_img'] .= '{caption: "'.$datos['imagen_seccion'].'",  height: "120px", url: "'.base_url().'C_secciones/eliminar_adjunto", previewAsData:true, key:1}' ;
            $datos['numimgsprev']++;

        }
        $this->load->view('secciones/captura_nosotros',$datos);
    }

    function agregar_seccion()
    {
        $this->load->model('M_seguridad');
        $mseg = new M_seguridad();

        $datos = array('titulo'=>'','contenido'=>'');
        $id = $mseg->insertar_registro('secciones_nosotros',$datos);
    }

    function eliminar_seccion()
    {
        $this->load->model('M_seguridad');
        $mseg = new M_seguridad();

        $where['id_seccion'] = $this->input->post('id_seccion');
        $id = $mseg->desactivar_registro('secciones_nosotros',$where);
    }

    function imprimir_tabla_secciones()
    {
        echo $this->tabla_secciones();
    }

    function tabla_secciones()
    {
        $query = $this->m->secciones_nosotros();
        $html = '';

        foreach ($query as $seccion)
        { 
            $html .= '<div class="row">
            <div class="col-md-12">
                <div class="form-group">
                        <label>Título de la sección</label>
                        <input type="text" id="titulo'.$seccion->id_seccion.'" name="titulo" class="form-control" value="'.$seccion->titulo.'">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Contenido de la sección</label>
                        <textarea id="contenido'.$seccion->id_seccion.'" name="contenido" rows="5" class="form-control">'.$seccion->contenido.'</textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <button type="button" class="btn btn-block btn-success" onclick="guardarSeccion(event,'.$seccion->id_seccion.')"><i class="fa fa-check"></i></button>
                </div>
                <div class="col-md-6">
                    <button type="button" class="btn btn-block btn-danger" onclick="confirmar(\'¿Desea eliminar esta sección?\',eliminarSeccion,'.$seccion->id_seccion.');"><i class="fa fa-times"></i></button>
                </div>
            </div>';
        }

        return $html;
    }

    function guardar_seccion()
    {
        $this->load->model('M_seguridad');
        $mseg = new M_seguridad();
        $where['id_seccion'] = $this->input->post('id_seccion');
        $datos['titulo'] = trim($this->input->post('titulo'));
        $datos['contenido'] = trim($this->input->post('contenido'));
        $id_usuario = $mseg->actualizar_registro('secciones_nosotros',$where,$datos);
        
        echo "0";

    }

    function guardar_nosotros()
    {
        $this->load->model('M_seguridad');
        $mseg = new M_seguridad();
        $where['id_nosotros'] = $this->input->post('id_nosotros');
        $datos['titulo_seccion'] = trim($this->input->post('titulo_seccion'));
        $datos['introduccion'] = trim($this->input->post('introduccion'));
        /*$datos['historia'] = trim($this->input->post('historia'));
        $datos['valores'] = trim($this->input->post('valores'));
        $datos['mision'] = trim($this->input->post('mision'));
        $datos['vision'] = trim($this->input->post('vision'));*/
        
        $id_usuario = $mseg->actualizar_registro('nosotros',$where,$datos);
        
        echo "0";

    }

    function subir_fotos_nosotros()
    {
        if(isset($_POST['id']) && !empty($_POST['id']))
        {
            $this->load->model('M_seguridad');
            $mseg = new M_seguridad();
            $where['id_nosotros'] = $this->input->post('id');
            $num = $this->input->post('num');
            $elim = $this->input->post('elim');
            $ruta = 'public/images/';


            //  Eliminamos los viejos adjuntos
            if(isset($_POST['elim']) && !empty($_POST['elim']))
            {
                $imagen = $this->m->consulta_imagen_nosotros($where['id_nosotros']);
                if(file_exists($ruta.$imagen) && !is_dir($ruta.$imagen))
                { 
                    if(unlink($ruta.$imagen))
                    {
                        $mseg->actualizar_registro('nosotros',$where,array('imagen_seccion' => ''));
                    }
                }
            }

            //  Guardamos los nuevos archivos
            if(!empty($_FILES))
            {
                for ($i=0; $i < $num ; $i++)
                {

                    $nombre_orig = $_FILES["adjuntoFotos"]["name"][$i];
                    $nombre_temp = $_FILES["adjuntoFotos"]["tmp_name"][$i];                    
                    
                    $resto = explode(".", $nombre_orig); 
                    $extension = end($resto);
                    $nombre_img = 'nosotros.'.$extension;
                    
                    if(move_uploaded_file($nombre_temp, $ruta.$nombre_orig))
                    {
                        $datos = array( 'imagen_seccion' =>  $nombre_orig);
                        $mseg->actualizar_registro('nosotros',$where,$datos);
                    }
                }
            }
            
            echo json_encode(true);
        }
    }

    function eliminar_adjunto()
    {
        echo json_encode(true);
    }

    public function mostrar_nosotros()
    {
        $registro= $this->m->nosotros();
        $secciones = $this->m->secciones_nosotros();
        $html = '';
        foreach ($registro as $campo => $valor)
        {
            $datos[$campo] = $valor;
        }
        if($datos['imagen_seccion'] != '') $datos['imagen_seccion'] = base_url().'public/images/'.$datos['imagen_seccion'];

        foreach ($secciones as $seccion)
        {
            $html.= '<div class="row justify-content-center">
                        <div class="col-md-12 text-center">
                            <div class="site-section-title">
                                <h2 style="font-size: 22px; font-weight:bold; color:rgba(0, 0, 0, 0.6);">'.$seccion->titulo.'</h2>
                            </div>
                            <p class="text-justify" style="color:#000000;">'.$seccion->contenido.'</p>
                        </div>
                    </div>
                    <br>'; 
        }
        $datos['secciones'] = $html;

        $this->load->view('nosotros',$datos);
    }

    public function mostrar_contacto()
    {
        $registro= $this->m->contacto();
        foreach ($registro as $campo => $valor)
        {
            $datos[$campo] = $valor;
        }
        if($datos['imagen_seccion'] != '') $datos['imagen_seccion'] = base_url().'public/images/'.$datos['imagen_seccion'];
        $this->load->view('contacto',$datos);
    }
}
?>