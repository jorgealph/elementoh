<?php
class M_propiedades extends CI_Model {

	function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('elementoh',TRUE);
	}

	public function buscar($where='',$like='')
	{
		$this->db->select('p.id_propiedad, p.titulo, tp.tipo_propiedad, p.banios, p.superficie_terreno, p.precio, p.estado, p.exclusiva');
		$this->db->from('propiedades p');
		$this->db->join('tipos_propiedad tp','tp.id_tipo_propiedad = p.id_tipo_propiedad','INNER');
		$this->db->where('p.activo',1);

		if(!empty($where)) $this->db->where($where);
		if(!empty($like)){
			$this->db->where("p.titulo LIKE '%$like%'");
		}

		return $this->db->get();
	}

	public function campos_tabla()
	{
		$sql = "SHOW COLUMNS FROM propiedades FROM {$this->db->database};";
		return $this->db->query($sql); 
	}

	public function datos_propiedad($id)
	{
		$this->db->select('p.*');
		$this->db->select('a.asentamiento, l.id_localidad, l.localidad, m.id_municipio, m.municipio, e.id_entidad, e.entidad, z.zona, tp.tipo_propiedad');
		$this->db->select("to.tipo_operacion, IFNULL(per.periodicidad,'') AS periodicidad",FALSE);
		$this->db->from('propiedades p');
		$this->db->join('asentamientos a','a.id_asentamiento = p.id_asentamiento','INNER');
		$this->db->join('localidades l','l.id_localidad = a.id_localidad','INNER');
		$this->db->join('municipios m','m.id_municipio = l.id_municipio','INNER');
		$this->db->join('entidades e','e.id_entidad = m.id_entidad','INNER');
		$this->db->join('zonas z','z.id_zona = p.id_zona','INNER');
		$this->db->join('tipos_operacion to','to.id_tipo_operacion = p.id_tipo_operacion','INNER');
		$this->db->join('tipos_propiedad tp','tp.id_tipo_propiedad = p.id_tipo_propiedad','INNER');
		$this->db->join('periodicidad per','per.id_periodicidad = p.id_periodicidad','LEFT OUTER');
		$this->db->where('p.activo',1);
		$this->db->where('p.id_propiedad',$id);

		return $this->db->get()->row();
	}

	public function buscar_propiedades($where='',$like='',$order_by='')
	{
		$this->db->select('p.id_propiedad, p.titulo, p.descripcion, to.tipo_operacion, to.class, p.recamaras, p.banios, p.garage_autos, e.entidad, m.municipio, l.localidad, a.asentamiento, p.codigo_postal, p.superficie_construccion, p.superficie_terreno, p.precio, p.id_video_youtube, tp.tipo_propiedad');
		$this->db->select("IFNULL(per.periodicidad,'') AS periodicidad",FALSE);
		$this->db->select('l.id_localidad, m.id_municipio, e.id_entidad');
		$this->db->from('propiedades p');
		$this->db->join('asentamientos a','a.id_asentamiento = p.id_asentamiento','INNER');
		$this->db->join('localidades l','l.id_localidad = a.id_localidad','INNER');
		$this->db->join('municipios m','m.id_municipio = l.id_municipio','INNER');
		$this->db->join('entidades e','e.id_entidad = m.id_entidad','INNER');
		$this->db->join('zonas z','z.id_zona = p.id_zona','INNER');
		$this->db->join('tipos_operacion to','to.id_tipo_operacion = p.id_tipo_operacion','INNER');
		$this->db->join('tipos_propiedad tp','tp.id_tipo_propiedad = p.id_tipo_propiedad','INNER');
		$this->db->join('periodicidad per','per.id_periodicidad = p.id_periodicidad','LEFT OUTER');
		$this->db->where('p.activo',1);

		if(!empty($where)) $this->db->where($where);
		if(!empty($like)) $this->db->where("(p.titulo LIKE '%$like%' OR p.descripcion LIKE '%$like%' OR l.localidad LIKE '%$like%' OR z.zona LIKE '%$like%' OR a.asentamiento LIKE '%$like%' OR t.tipo_propiedad LIKE '%$like%')");
		if(!empty($order_by)) $this->db->order_by($order_by);

		return $this->db->get();
	}

	public function listar_ultimas_propiedades($limit='')
	{
		$sql = "SELECT p.id_propiedad, p.titulo, p.precio, top.tipo_operacion,  top.class, IFNULL(per.periodicidad,'') periodicidad
				FROM propiedades p
				INNER JOIN tipos_operacion top ON top.id_tipo_operacion = p.id_tipo_operacion 
				LEFT OUTER JOIN periodicidad per ON per.id_periodicidad = p.id_periodicidad 
				WHERE p.activo = 1 AND p.exclusiva = 1
				ORDER BY p.fecha_captura DESC ";
		if($limit != '') $sql.= "LIMIT $limit";
		return $this->db->query($sql);
	}

	public function listar_imagenes_propiedad($id_propiedad,$limit=0)
	{
		$this->db->select('id_propiedad_adjunto, nombre, numero');
		$this->db->from('propiedades_adjuntos');
		$this->db->where('id_propiedad',$id_propiedad);
		$this->db->where('activo',1);
		$this->db->where('tipo',1);
		$this->db->order_by('numero');
		if($limit > 0) $this->db->limit($limit);

		return $this->db->get();
	}

	public function numero_imagenes_por_propiedad($id)
	{
		$sql = "SELECT COUNT(id_propiedad_adjunto) numero_imagenes FROM propiedades_adjuntos WHERE tipo = 1 AND id_propiedad = $id";
		return $this->db->query($sql)->row()->numero_imagenes;
	} 

	function datos_adjunto($id_propiedad_adjunto)
	{
		$this->db->select('p.id_propiedad_adjunto, p.id_propiedad, p.nombre, p.ext, p.numero');
		$this->db->from('propiedades_adjuntos p');
		$this->db->where('p.activo',1);
		$this->db->where('p.id_propiedad_adjunto',$id_propiedad_adjunto);

		return $this->db->get()->row();
	}

	function imagen_principal($id_propiedad)
	{
		$sql = "SELECT id_propiedad_adjunto, nombre FROM propiedades_adjuntos WHERE activo = 1 AND tipo = 1 AND id_propiedad = $id_propiedad LIMIT 1";
		$query = $this->db->query($sql);

		return ($query->num_rows() > 0) ? $query->row()->nombre:'no_foto.png'; 
	}

	function propiedad_adjuntos($id_propiedad)
	{
		$sql = "SELECT p.id_propiedad_adjunto, p.nombre, p.nombre_original, p.ext, p.tipo
				FROM propiedades_adjuntos p
				WHERE p.activo = 1 AND p.id_propiedad = '$id_propiedad'
				ORDER BY p.tipo, p.numero";
		return $this->db->query($sql);
	}

	function datos_contacto()
	{
		$sql = "SELECT id_contacto, titulo_seccion, imagen_seccion, direccion, telefono, email FROM contacto WHERE id_contacto = 1";
		return $this->db->query($sql)->row();
	}
}
?>