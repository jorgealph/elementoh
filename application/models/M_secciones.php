<?php
class M_secciones extends CI_Model {


	function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('elementoh',TRUE);
	}

	function contacto()
	{
		$sql = "SELECT id_contacto, titulo_seccion, imagen_seccion, direccion, telefono, email FROM contacto WHERE id_contacto = 1";
		return $this->db->query($sql)->row();
	}

	function nosotros()
	{
		$sql = "SELECT id_nosotros, titulo_seccion, imagen_seccion, introduccion FROM nosotros WHERE id_nosotros = 1";
		return $this->db->query($sql)->row();
	}

	function consulta_imagen_contacto($id_contacto)
	{
		$sql = "SELECT imagen_seccion FROM contacto WHERE id_contacto = $id_contacto";
		return $this->db->query($sql)->row()->imagen_seccion;
	}

	function consulta_imagen_nosotros($id_nosotros)
	{
		$sql = "SELECT imagen_seccion FROM nosotros WHERE id_nosotros = $id_nosotros";
		return $this->db->query($sql)->row()->imagen_seccion;
	}

	function secciones_nosotros()
	{
		$sql = "SELECT id_seccion, titulo, contenido 
		FROM secciones_nosotros 
		WHERE activo = 1";
		return $this->db->query($sql)->result();
	}
}
?>