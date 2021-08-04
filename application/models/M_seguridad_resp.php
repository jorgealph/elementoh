<?php
class M_seguridad extends CI_Model {


	function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default',TRUE);
	}

	/*	Funciones para usar transacciones
	======================================
	*/
	public function iniciar_transaccion()
	{
	  $con = $this->load->database('default',TRUE);
	  $con->trans_begin();
	  return  $con;
	}

	public function terminar_transaccion($con)
	{
		if ($con->trans_status() === FALSE)
		{
			$con->trans_rollback();
			return false;
		}
		else 
		{
			$con->trans_commit();
			return true;
		}
	}

	public function insertar_registro($tabla,$datos,$con='')
	{
		if($con == '') $con = $this->db;

		if($con->insert($tabla,$datos)) return $con->insert_id();
		else return false;
	}

	public function insertar_registro_no_pk($tabla,$datos,$con='')
	{
		if($con == '') $con = $this->db;

		if($con->insert($tabla,$datos)) return true;
		else return false;
	}

	public function actualizar_registro($tabla,$where,$datos,$con='')
	{
		if($con == '') $con = $this->db;
		$con->where($where);
		return $con->update($tabla, $datos);
	}

	public function eliminar_registro($tabla,$where,$con)
	{
		return $con->delete($tabla,$where);
	}

	public function desactivar_registro($tabla,$where,$con='')
	{
		if($con == '') $con = $this->db;
		$con->where($where);
		return $con->update($tabla, array('activo' => 0));

		return ($con->affected_rows() > 0);
	}

	public function activar_registro($tabla,$where,$con='')
	{
		if($con == '') $con = $this->db;
		$con->where($where);
		$con->update($tabla, array('activo' => 1));

		return ($con->affected_rows() > 0);
	}

	/*	Funciones para usar transacciones
	======================================
	*/

	public function consulta_existe_usuario($where='')
	{
		$this->db->select('u.id_usuario, u.nombres, u.apellido_paterno, u.apellido_materno, u.email');
		$this->db->select('r.id_rol, r.rol');
		$this->db->from('usuarios u');
		$this->db->join('roles r','r.id_rol = u.id_rol','INNER');
		$this->db->where('u.activo',1);

		if($where != '') $this->db->where($where);

		$query = $this->db->get();
		$_SESSION['consulta'] = $this->db->last_query();

		return $query;
	}

	public function traer_menu_sistema($idusuario=0, $idpadre=0)
	{	
		$sql = "SELECT * 
				FROM ((SELECT p.id_permiso, p.permiso, p.icono, up.tipo_acceso, p.url, p.orden
						FROM permisos p
						INNER JOIN usuarios_permisos up ON up.id_permiso = p.id_permiso AND up.id_usuario = '$idusuario' AND p.id_permiso_padre = '$idpadre' AND p.tipo = 1)
				UNION
					(SELECT p.id_permiso, p.permiso, p.icono, rp.tipo_acceso, p.url, p.orden
						FROM permisos p
						INNER JOIN roles_permisos rp ON rp.id_permiso = p.id_permiso
						INNER JOIN usuarios u ON u.id_rol = rp.id_rol
					WHERE u.id_usuario = '$idusuario' AND p.id_permiso_padre = '$idpadre' AND p.tipo = 1)) t
				ORDER BY t.orden ASC";
		return $this->db->query($sql);
	}

	public function buscar_usuarios($where ='',$palabra='')
	{
		$this->db->select('u.iIdUsuario, u.vNombre, u.vApellidoPaterno, u.vApellidoMaterno, u.vCorreo, r.vRol, r.iIdRol, u.iEstatus');
		$this->db->from('Usuario u');
		$this->db->join('Rol r','r.iIdRol = u.iIdRol','INNER');
		$this->db->where('u.iEstatus >',0);
		if($palabra != '')
		{
			//$this->db->where("CONCACT( u.vNombre,' ',u.vApellidoPaterno,' ',u.vApellidoMaterno) LIKE '%$palabra%'");
			$this->db->like("u.vNombre",$palabra);
		}

		if(!empty($where)) $this->db->where($where);

		
		$this->db->order_by('u.vNombre');
		

		return $this->db->get();
	}

	public function consultar_usuario_por_token($idusuario, $token)
	{
		$this->db->select('u.iIdUsuario, u.vNombre, u.vApellidoPaterno, u.vApellidoMaterno, u.vCorreo, r.vRol, r.iIdRol');
		$this->db->from('Usuario u');
		$this->db->join('Rol r','r.iIdRol = u.iIdRol','INNER');
		$this->db->where('u.iEstatus >',0);
		$this->db->where('u.iIdUsuario',$idusuario);
		$this->db->where('u.vToken',$token);
		$response = false;

		$query =  $this->db->get();
		if($query)
		{
			if($query->num_rows() == 1) $response = true;
		}

		return $response;
	}

	public function consultar_usuario_por_correo($correo)
	{
		$this->db->select('u.iIdUsuario, u.vNombre, u.vApellidoPaterno, u.vApellidoMaterno');
		$this->db->from('Usuario u');
		$this->db->join('Rol r','r.iIdRol = u.iIdRol','INNER');
		$this->db->where('u.iEstatus ',2);
		$this->db->where('u.vCorreo',$correo);
		$this->db->limit(1);	//Sólo debe haber un correo registrado
		$response = false;

		$query =  $this->db->get();
		
		return $query;
	}

	public function verificar_existe_correo_usuario($correo,$excepcion=0)
	{
		$this->db->select('u.iIdUsuario');
		$this->db->from('Usuario u');
		$this->db->join('Rol r','r.iIdRol = u.iIdRol','INNER');
		$this->db->where('u.iEstatus >',0);	// Se excluyen usuarios eliminados
		$this->db->where('u.vCorreo',$correo);
		if($excepcion != 0) $this->db->where('u.iIdUsuario !=',$excepcion);
		$response = false;

		$query =  $this->db->get();

		if($query->num_rows() > 0) $response = true;
		
		return $response;
	}

	public function consulta_valor_parametros($where='')
	{
		$this->db->select('p.vValor, p.vId, p.vDescripcion');
		$this->db->from('Parametro p');		
		$this->db->where('p.iActivo',1);	// Se excluyen usuarios eliminados

		$query =  $this->db->get();

		return $query;
	}

	public function datos_usuarios($where ='')
	{
		$this->db->select('u.iIdUsuario, u.vNombre, u.vApellidoPaterno, u.vApellidoMaterno, u.vCorreo, u.dFechaNacimiento, u.iGenero, u.iIdGradoEstudio, u.iIdOcupacion, u.iIdAsentamiento, u.iIdRol, u.iEstatus');
		$this->db->select('l.iIdLocalidad, l.vLocalidad, m.iIdMunicipio, m.vMunicipio, iCodigoPostal, vToken');
		$this->db->from('Usuario u');		
		$this->db->join('Asentamiento a','a.iIdAsentamiento = u.iIdAsentamiento','INNER');
		$this->db->join('Localidad l','l.iIdLocalidad = a.iIdLocalidad','INNER');
		$this->db->join('Municipio m','m.iIdMunicipio = l.iIdMunicipio','INNER');
		//$this->db->where('u.iEstatus >',0);

		if(!empty($where)) $this->db->where($where);

		$this->db->order_by('u.vNombre');

		return $this->db->get();
	}
	
}

?>