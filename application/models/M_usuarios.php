<?php
class M_usuarios extends CI_Model {

	function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('elementoh',TRUE);
	}

	public function buscar_usuario($where='',$like='')
	{
		$this->db->select('u.id_usuario, u.nombres, u.apellido_paterno, u.apellido_materno, u.correo, u.puesto, u.foto, u.fecha_registro');
		$this->db->select('r.id_rol, r.rol');
		$this->db->from('usuarios u');
		$this->db->join('roles r','r.id_rol = u.id_rol AND r.activo = 1','INNER');
		$this->db->where('u.activo',1);

		if(!empty($where)) $this->db->where($where);
		if(!empty($like)){
			$this->db->where("CONCACT( u.nombres,' ',u.apellido_paterno,' ',u.apellido_materno) LIKE '%$like%'");
		}

		return $this->db->get();
	}
	
	public function campos_tabla()
	{
		$sql = "SHOW COLUMNS FROM usuarios FROM {$this->db->database};";
		return $this->db->query($sql); 
	}

	public function datos_usuario($id_usuario)
	{
		$this->db->select('u.id_usuario, u.nombres, u.apellido_paterno, u.apellido_materno, u.correo, u.puesto, u.foto, u.fecha_registro, id_rol');
		$this->db->from('usuarios u');
		$this->db->where('u.activo',1);
		$this->db->where('u.id_usuario',$id_usuario);

		return $this->db->get()->row();
	}

}
?>