<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_usuarios extends CI_Controller {
	public function __construct()
    {
        parent::__construct();
        session_start();
        $this->load->helper('url');
        $this->load->helper('Funciones');
        $this->load->library('Class_seguridad');
        $this->load->model('M_usuarios','m_usr');
    }

    public function index()
    {
    	$datos['tabla_registros'] = $this->listar_usuarios();
    	
    	$this->load->view('usuarios/index',$datos);
    }

    function buscar(){
    	if(isset($_POST['texto_busqueda']))
    	{
    		$like = $this->input->post('texto_busqueda');
    		$pag = $this->input->post('pag');

    		echo $this->listar_usuarios($pag, '',$like);
    	}
    }

    function listar_usuarios($pag=1, $where='',$like='')
    {
    	$query = $this->m_usr->buscar_usuario($where,$like);
        //$query = $this->m_usr->buscar();
    	$reg = paginador($query,$pag);

    	$tabla = '<p>No se encontraron registros para mostrar.</p>';
    	//var_dump($datos);
    	if($reg['total_registros'] > 0)
    	{
    		$tabla = '<div class="table-responsive">
    					<table class="table">
    					<thead>
    						<tr>
    							<th>Nombre</th>
    							<th>Puesto</th>
    							<th>Miembro desde</th>
    							<th width="200px">Acciones</th>
    						</tr>
    					</thead>
    					<tbody>';       


    		$registros = $reg['registros'];
            //var_dump($registros);
    		foreach ($registros as $registro) {
    			$acciones = '<i class="fa fa-key manita text-warning" onclick="cambiarPassword('.$registro->id_usuario.')"></i>&nbsp;';
    			$acciones.= '<i class="fa fa-pencil-alt manita text-success" onclick="capturar('.$registro->id_usuario.')"></i>&nbsp;';
    			$acciones.= '<i class="fa fa-trash-alt manita text-danger" onclick="confirmar(\'¿Desea eliminar este registro?\',eliminar,'.$registro->id_usuario.');"></i>';
    		 	$tabla.= "<tr>
    		 			<td>{$registro->nombres} {$registro->apellido_paterno}</td>
    		 			<td>{$registro->puesto}</td>
    		 			<td>{$registro->fecha_registro}</td>
    		 			<td>$acciones</td>
    		 		</tr>";
                    
    		} 
    		$tabla .= '</tbody>
    				</table>
    			</div>';

    		$tabla.= $reg['botones_paginacion'];

    		return $tabla;
    	}
    	else
    	{
    		return 'No se encontraron registros que coincidan con los criterios de búsqueda';
    	}
    }

    function eliminar()
    {
    	if(isset($_POST['id']) && !empty($_POST['id']))
    	{
    		$this->load->model('M_seguridad');
    		$m_seg = new M_seguridad();
    		$where['id_usuario'] = $this->input->post('id');
    		echo ($m_seg->desactivar_registro('usuarios',$where)) ? "0":"El registro nu pudo ser eliminado";
    	}
    }

    function capturar()
    {
    	if(isset($_POST['id']))
    	{
    		$id_usuario = $this->input->post('id');
    		if($id_usuario > 0)
    		{
    			$registro = $this->m_usr->datos_usuario($id_usuario);

    			foreach ($registro as $campo => $valor)
    			{
    				$datos[$campo] = $valor;
    			}
    		}
    		else
    		{
    			$query = $this->m_usr->campos_tabla();
    			if($query)
				{
					$query = $query->result();
					foreach ($query as $registro)
					{
						$datos[$registro->Field] = $registro->Default;
					}
				}	
    		}

    		$this->load->library('Class_options');
    		$cls_opts = new Class_options();
    		$datos['options_rol'] = $cls_opts->options_tabla('roles',$datos['id_rol']);
    		
    		$this->load->view('usuarios/capturar',$datos);
    	}
    }

    function cambiar_password()
    {
        if(isset($_POST['id']))
        {
            $datos['id_usuario'] = $this->input->post('id');            
            $this->load->view('usuarios/cambiar_password',$datos);
        }
    }

    function guardar()
    {
    	$this->load->model('M_seguridad');
    	$m_seg = new M_seguridad();
    	$id_usuario = $this->input->post('id_usuario');
    	$datos['nombres'] = trim($this->input->post('nombres'));
    	$datos['apellido_paterno'] = trim($this->input->post('apellido_paterno'));
    	$datos['apellido_materno'] = trim($this->input->post('apellido_materno'));
    	$datos['id_rol'] = $this->input->post('id_rol');
    	$datos['correo'] = trim($this->input->post('correo'));
    	$datos['puesto'] = trim($this->input->post('puesto'));

    	if($id_usuario > 0)
    	{
    		$where['id_usuario'] = $id_usuario;
    	   	$id_usuario = $m_seg->actualizar_registro('usuarios',$where,$datos);
    	   	echo "0";
    	}
    	else
    	{
    	    $datos['password'] = sha1($this->input->post('password'));   
            $id_usuario = $m_seg->insertar_registro('usuarios',$datos);
    		echo "0";
    	}

    }


    function actualizar_password()
    {
        $this->load->model('M_seguridad');
        $m_seg = new M_seguridad();
        $id_usuario = $this->input->post('id_usuario');
        $datos['password'] = sha1(trim($this->input->post('password')));

        if($id_usuario > 0)
        {
            $where['id_usuario'] = $id_usuario;
            $id_usuario = $m_seg->actualizar_registro('usuarios',$where,$datos);
            echo "0";
        }
    }
}
