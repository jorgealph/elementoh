<?php if (!defined('BASEPATH')) exit('No permitir el acceso directo al script');

class Class_seguridad {

    function __construct()
    {
        $CI =& get_instance();
        $CI->load->helper('url');
        $CI->load->model('M_seguridad');
    }

    function pintar_menu($idusuario)
    {
        $resp = array('menu'=>'','modulo_inicial'=>'');
        $str = $modulo_inicial = '';
        $id_permiso_ant = 0;
        $modseguridad =  new M_seguridad();
        $menu = $modseguridad->traer_menu_sistema($idusuario, 0);
        if($menu)
        {
            if($menu->num_rows () > 0)
            {
                $menu = $menu->result();
                
                $str = '<ul class="nav">
                        <li class="nav-header">Menú</li>';
                foreach ($menu as $padre)
                {

                    $submenu = $modseguridad->traer_menu_sistema($idusuario, $padre->id_permiso);
                    if($submenu != false && $submenu->num_rows() > 0)
                    {
                        $submenu = $submenu->result();
                        $str .=  '<li class="has-sub">
                                    <a href="javascript:;">
                                        <b class="caret"></b>
                                        <i class="'.$padre->icono.'"></i>
                                        <span>'.$padre->permiso.'</span>
                                    </a>
                                    <ul class="sub-menu">';
                        foreach ($submenu as $hijo)
                        {
                            if($modulo_inicial == '') $modulo_inicial = base_url().$hijo->url;
                            $str.= '<li><a style="cursor:pointer;" onclick="cargar(\''.base_url().$hijo->url.'\',\'#contenido\');" >'.$hijo->permiso.'</a></li>';
                        }
                                
                        $str .= '   </ul>
                                </li>';
                    }
                    else
                    {
                        if($modulo_inicial == '') $modulo_inicial = base_url().$padre->url;
                        $str.= '<li>
                            <a style="cursor:pointer;" onclick="cargar(\''.base_url().$padre->url.'\',\'#contenido\');">
                                <!-- En caso de querer un icono personalizado
                                <div class="icon-img">
                                    <img src="../assets/img/logo/logo-bs4.png" alt="" />
                                </div>-->
                                <i class="'.$padre->icono.'"></i><span>'.$padre->permiso.'</span> 
                            </a>
                        </li>';
                    }
                }

                $str .= '</ul>';

            }
        }

        $resp['menu'] = $str;
        $resp['modulo_inicial'] = $modulo_inicial;

        return $resp;
    }
    
    function validar_acceso($id_permiso)
    {
        $mseg = new M_seguridad();

        if(isset($_SESSION[PREFIJO.'_idusuario']) && !empty($_SESSION[PREFIJO.'_idusuario']))
        {
            return $mseg->consultar_tipo_acceso($_SESSION[PREFIJO.'_idusuario'],$id_permiso);
        }

        return -1;
    }
    
}