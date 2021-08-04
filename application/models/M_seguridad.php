<?php
class M_seguridad extends CI_Model {


	function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('elementoh',TRUE);
	}

	/*	Funciones para usar transacciones
	======================================
	*/
	public function iniciar_transaccion()
	{
	  $con = $this->db;
	  $con->trans_begin();
	  return  $con;
	}

	public function terminar_transaccion($con)
	{
		if ($con->trans_status() === FALSE)
		{
			$con->trans_rollback();
			$_SESSION['ultimo_error_bd'] = $con->last_query();
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
		$query = $con->update($tabla, $datos);
		$_SESSION['sql'] = $con->last_query();
		return $query;
	}

	public function eliminar_registro($tabla,$where,$con)
	{
		if($con == '') $con = $this->db;
		return $con->delete($tabla,$where);
	}

	public function desactivar_registro($tabla,$where,$con='')
	{
		if($con == '') $con = $this->db;
		$con->where($where);
		return $con->update($tabla, array('activo' => 0));
	}

	public function activar_registro($tabla,$where,$con='')
	{
		if($con == '') $con = $this->db;
		$con->where($where);
		return $con->update($tabla, array('activo' => 1));
	}
	/*	Funciones para usar transacciones
	======================================
	*/

	public function consulta_existe_usuario($where='')
	{
		$this->db->select('u.id_usuario, u.nombres, u.apellido_paterno, u.apellido_materno, u.correo, u.puesto, u.foto');
		$this->db->select('r.id_rol, r.rol');
		$this->db->from('usuarios u');
		$this->db->join('roles r','r.id_rol = u.id_rol','INNER');
		$this->db->where('u.activo',1);

		if(!empty($where)) $this->db->where($where);

		return $this->db->get();
	}

	public function traer_menu_sistema($id_usuario=0, $id_padre=0)
	{	
		$sql = "SELECT t.id_permiso, t.permiso, t.icono, t.url, t.tipo_acceso, t.orden
				FROM ((SELECT p.id_permiso, p.permiso, p.icono, up.tipo_acceso, p.url, p.orden
						FROM permisos p
						INNER JOIN usuarios_permisos up ON up.id_permiso = p.id_permiso AND up.id_usuario = '$id_usuario' AND p.id_permiso_padre = '$id_padre' AND p.tipo = 1)
				UNION
					(SELECT p.id_permiso, p.permiso, p.icono, rp.tipo_acceso, p.url, p.orden
						FROM permisos p
						INNER JOIN roles_permisos rp ON rp.id_permiso = p.id_permiso
						INNER JOIN usuarios u ON u.id_rol = rp.id_rol
					WHERE u.id_usuario = '$id_usuario' AND p.id_permiso_padre = '$id_padre' AND p.tipo = 1)) t
				WHERE t.tipo_acceso > 0
				ORDER BY t.orden ASC";
		return $this->db->query($sql);
	}

	public function consultar_tipo_acceso($id_usuario,$id_permiso)
	{
		$con1 = $this->db;
		$con1->select('up.tipo_acceso');
		$con1->from('usuarios_permisos up');
		$con1->join('permisos p','p.id_permiso = up.id_permiso AND p.activo = 1','INNER');
		$con1->join('usuarios u','u.id_usuario = up.id_usuario AND u.activo = 1','INNER');
		$con1->where('up.id_permiso',$id_permiso);
		$con1->where('up.id_usuario',$id_usuario);

		$query = $con1->get();

		if($query->num_rows() == 0)
		{
			$con2 = $this->db;
			$con2->select('rp.tipo_acceso');
			$con2->from('usuarios u');
			$con2->join('roles_permisos rp','rp.id_rol = u.id_rol','INNER');
			$con2->join('permisos p','p.id_permiso = rp.id_permiso AND p.activo = 1','INNER');
			$con2->join('roles r','r.id_rol = rp.id_rol AND r.activo = 1','INNER');
			$con2->where('rp.id_permiso',$id_permiso);
			$con2->where('u.id_usuario',$id_usuario);
			$con2->where('u.activo',1);

			$query = $con2->get();
		}

		return ($query->num_rows() > 0) ? (int)$query->row()->tipo_acceso:0;
	}

	public function consulta_valor_parametros($where='')
	{
		$this->db->select('p.vValor, p.vId, p.vDescripcion');
		$this->db->from('Parametro p');		
		$this->db->where('p.iActivo',1);	// Se excluyen usuarios eliminados

		$query =  $this->db->get();

		return $query;
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
}

?>