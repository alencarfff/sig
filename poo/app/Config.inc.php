<?php

//CONFIGURAÇÕES DO SITE ############################################################
//CONFIGURAÇOES GERAIS
define("HOME", "http://localhost/sig/");
define("BASE", "http://localhost/sig/");
define("PEGASUS", HOME . "/");
define("PAGINAS", HOME . "");
define("SITENOME", "Sig");
define("DESCRICAO", "");

//CONFIGURAÇÕES DO BANCO DE DADOS
define("HOST", "localhost");
define("USER", "root");
define("PASS", '$Projeto00');
define("DBSA", "sig");

//SERVIDOR DE E-MAIL
define("MAILUSER", "");
define("MAILPASS", "");
define("MAILPORT", "");
define("MAILHOST", "");

//E-MAIL UTILIZADO NO PROJETO
define("EMAILSUPORTE", "");
define("EMAILATENDIMENTO", "");
define("EMAILVENDAS", "");


// URL AMIGAVEL  ############################################################
$atual = (isset($_GET['pg'])) ? $_GET['pg'] : 'home';
$permissao = array(
    'home', '404', 'sair', 'recupera_senha', 'newsletter','busca','captcha','validar',
);
$pasta = '';

if (substr_count($atual, '/') > 0) {
    $atual = explode('/', $atual);
    $pagina = (file_exists($atual[0] . '.php') && in_array($atual[0], $permissao)) ? $atual[0] : '404';
} else {
    $pagina = (file_exists($atual . '.php') && in_array($atual, $permissao)) ? $atual : '404';
}

// AUTO LOAD DE CLASSES  ############################################################
function __autoload($Class) {
    $cDir = ['Conn', 'Helpers', 'Models'];
    $iDir = null;
    foreach ($cDir as $dirName):
        if (!$iDir && file_exists(__DIR__ . DIRECTORY_SEPARATOR . "{$dirName}" . DIRECTORY_SEPARATOR . "{$Class}.class.php") && !is_dir(__DIR__ . DIRECTORY_SEPARATOR . "{$dirName}" . DIRECTORY_SEPARATOR . "{$Class}.class.php")):
            include_once (__DIR__ . DIRECTORY_SEPARATOR . "{$dirName}" . DIRECTORY_SEPARATOR . "{$Class}.class.php");
            $iDir = true;
        endif;
    endforeach;

    if (!$iDir):
        trigger_error("Não foi possível incluir {$Class}.class.php", E_USER_ERROR);
        die;
    endif;
}

// TRATAMENTOS DE ERROS  ############################################################
// CSS CONSTANTES :: MENSAGENS DE ERRO
define('CDS_ACCEPT', 'accept');
define('CDS_INFOR', 'infor');
define('CDS_ALERT', 'alert');
define('CDS_ERROR', 'error');

// CDSERRO :: EXIBIR ERROS LANÇADOS :: FRONT
function CDSErro($ErrMsg, $ErrNo, $ErrDie = null) {
    $CssClass = ($ErrNo == E_USER_NOTICE ? CDS_INFOR : ($ErrNo == E_USER_WARNING ? CDS_ALERT : ($ErrNo == E_USER_ERROR ? CDS_ERROR : $ErrNo)));
    echo "<p class=\"trigger {$CssClass}\">{$ErrMsg}<span class=\"\ajax_close\"></span></p>";
    if ($ErrDie):
        die;
    endif;
}

//PHPERRO :: PERSONALIZA O GATILHO DO PHP
function PHPErro($ErrNo, $ErrMsg, $ErrFile, $ErrLine) {
    $CssClass = ($ErrNo == E_USER_NOTICE ? CDS_INFOR : ($ErrNo == E_USER_WARNING ? CDS_ALERT : ($ErrNo == E_USER_ERROR ? CDS_ERROR : $ErrNo)));
    echo "<p class=\"trigger {$CssClass}\">";
    echo "<b> Erro na Linha: #{$ErrLine} ::</b> {$ErrMsg}</br>";
    echo "<small>{$ErrFile}</small>";
    echo "<span class=\"ajax_closse\"></span></p>";
    if ($ErrNo == E_USER_ERROR):
        die;
    endif;
}

set_error_handler("PHPErro");

// COMO USAR OS ERROS   ############################################################
//trigger_error("Essa e uma Notice", E_USER_NOTICE);
//trigger_error("Esta e um Alerta", E_USER_WARNING);
//trigger_error("Esta é um Erro", E_USER_ERROR);
//echo '<hr>';
//CDSErro("Esse é um accept", CDS_ACCEPT);

/* * ******************************************************************************************************
  SEO AVANÇADO
 * ****************************************************************************************************** */

//GOOGLE+
$pg_autor = '';
$pg_empresa = '';

$face_app = '';
$face_autor = '';
$face_page = '';

$pg_name = SITENOME;
$pg_sitekit = HOME . 'imagens_site/imagem_kit';
$indice = $atual[1];

switch ($pagina):

    case 'busca':
        $pg_titulo = 'Buscar';
        $pg_descricao = 'Buscar';
        $pg_url = HOME . 'busca';
        $pg_imagem = $pg_sitekit . '/home.jpg';
        break;
 
    case 'home':
        $pg_titulo = $pg_name;
        $pg_descricao = DESCRICAO;
        $pg_url = HOME . '';
        $pg_imagem = $pg_sitekit . '/home.jpg';
        break;

    default :
        $pg_titulo = '404, oooopssss!!!! página não encontrada.';
        $pg_descricao = 'Desculpe página não encontrada!';
        $pg_url = HOME . '404';
        $pg_imagem = $pg_sitekit . '/home.jpg';
        break;

endswitch;
