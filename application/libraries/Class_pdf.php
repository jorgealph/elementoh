<?php if (!defined('BASEPATH')) exit('No permitir el acceso directo al script');

require_once dirname(__FILE__) . '/tcpdf/tcpdf.php';

class Class_pdf extends TCPDF{
    function __construct()
    {
        parent::__construct();
    }
}
?>