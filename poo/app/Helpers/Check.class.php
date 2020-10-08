<?php

/**
 * Check.class [ HELPER ]
 * CLASSE ERESPONSÁVEL PARA VALIDAR OS DADOS.
 * @copyright (c) 2014, Fabio Augusto CASA DOS SITES
 */
class Check {

   private static $Data;
   private static $Format;

   /**
    * ****************************************
    * ********** VALIDA E-MAIL ***************
    * ****************************************
     COMO USAR:
    * *****************************************
     $Email = 'contato@casadossites.com';
     if(Check::Email($Email)):
     echo 'Válido!';
     else:
     echo 'inválido!';
     endif;
    */
   public static function Email($Email) {
      self::$Data = (string) $Email;
      self::$Format = '/[a-z0-9_\.\-]+@[a-z0-9_\.\-]*[a-z0-9_\.\-]+\.[a-z]{2,4}$/';

      if (preg_match(self::$Format, self::$Data)):
         return true;
      else:
         return false;
      endif;
   }

   /**
    * ****************************************
    * ********** CRIAR URL AMIGÁVEIS  ********
    * ****************************************
     COMO USAR:
    * *****************************************
     $nome = 'Estamos aprendendo PHP. Veja você com é!';
     echo  Check::Name($nome);
    */
   public static function Name($Name) {
      self::$Format = array();
      self::$Format['a'] = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜüÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿRr"!@#$%&*()_-+={[}]/?;:.,\\\'<>°ºª';
      self::$Format['b'] = 'aaaaaaaceeeeiiiidnoooooouuuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr                                 ';

      self::$Data = strtr(utf8_decode($Name), utf8_decode(self::$Format['a']), self::$Format['b']);
      self::$Data = strip_tags(trim(self::$Data));
      self::$Data = str_replace(' ', '-', self::$Data);
      self::$Data = str_replace(array('-----', '----', '---', '--'), '-', self::$Data);

      return strtolower(utf8_encode(self::$Data));
   }

   /**
    * ****************************************
    * ***** TRANSFORMA DATA EM TIMESTAMP  ****
    * ****************************************
     COMO USAR:
    * *****************************************
     $data = '05/01/2014';
     echo Check::Datastamp($data);
    */
   public static function Datastamp($Data) {
      self::$Format = explode(' ', $Data);
      self::$Data = explode('/', self::$Format[0]);

//if (empty(self::$Format[1])):
//  self::$Format[1] = date('H:i:s');
// endif;

      self::$Data = self::$Data[2] . '-' . self::$Data[1] . '-' . self::$Data[0]; //. ' ' . self::$Format[1];
      return self::$Data;
   }

   /**
    * ****************************************
    * ***** TRANSFORMA TIMESTAMP EM DATA  ****
    * ****************************************
     COMO USAR:
    * *****************************************
     $data = '2015-01-15';
     echo Check::TimesData($data);
    */
   public static function TimesData($Data) {
      self::$Format = explode(' ', $Data);
      self::$Data = explode('-', self::$Format[0]);

//        if (empty(self::$Format[1])):
//            self::$Format[1] = date('H:i:s');
//        endif;

      self::$Data = self::$Data[2] . '/' . self::$Data[1] . '/' . self::$Data[0];
      return self::$Data;
   }

   /**
    * ****************************************
    * ******* LIMITADOR DE PALAVRAS  *********
    * ****************************************
     COMO USAR:
    * *****************************************
     $string = 'Olá mundo, estamos estudando PHP na Casa dos sites!';
     echo Check::Limitador($string, 5, '. <small>Continuer lendo</small>');
    */
   public static function Limitador($String, $Limite, $Pointer = null) {
      self::$Data = strip_tags(trim($String));
      self::$Format = (int) $Limite;

      $ArrWords = explode(' ', self::$Data);
      $NumWords = count($ArrWords);
      $NewWords = implode(' ', array_slice($ArrWords, 0, self::$Format));

      $Pointer = (empty($Pointer) ? '' : '' . $Pointer );
      $Result = (self::$Format < $NumWords ? $NewWords . $Pointer : self::$Data);
      return $Result;
   }

   /**
    * ****************************************
    * ****** LIMITADOR DE CARACTERES  ********
    * ****************************************
     COMO USAR:
    * *****************************************
     $string = 'Olá mundo, estamos estudando PHP na Casa dos sites!';
     echo Check::limitcaracter($string, 5,);
    */
   public static function limitcaracter($String, $Limite) {
      self::$Data = strip_tags($String);
      self::$Format = $Limite;
      if (strlen(self::$Data) <= self::$Format) {
         return self::$Data;
      } else {
         $subStr = strrpos(substr(self::$Data, 0, self::$Format), ' ');
         return substr(self::$Data, 0, $subStr) . '...';
      }
   }

   /**
    * ****************************************
    * ********** USUARIOS ONLINE  ************
    * ****************************************
     COMO USAR:
    * *****************************************
     echo Check::UserOnline();
    */
   public static function UserOnline() {
      $now = date('Y-m-d H:i:s');
      $deleUserOnline = new Delete;
      $deleUserOnline->ExeDelete('ws_siteviews_online', "WHERE online_endview < :now", "now={$now}");

      $readUserOnline = new Read;
      $readUserOnline->ExeRead('ws_siteviews_online');
      return $readUserOnline->getRowCount();
   }

   /**
    * ****************************************
    * ****** REDIMENCIONADO IMAGENS  *********
    * ****************************************
     COMO USAR:
    * *****************************************
     echo Check::Imagem('imagens_fixas/sem_imagem.jpg', 'Sem imagem', '200', '100', 'botao');
    */
   public static function Imagem($ImageUrl, $ImageDesc, $ImageW = null, $ImageH = null, $Class = null) {
      self::$Data = $ImageUrl;
      $pasta = 'imagens_site/';

      if (file_exists(self::$Data) && !is_dir(self::$Data)):
         $patch = HOME;
         $imagem = self::$Data;
         return "<img src=\"{$patch}{$pasta}tim.php?src={$patch}$imagem&w={$ImageW}&h={$ImageH}&zc=1&q=100\" alt=\"{$ImageDesc}\" title=\"{$ImageDesc}\" class=\"{$Class}\" />";
      else:
         return false;
      endif;
   }

   /**
    * ****************************************
    * ****** REDIMENCIONADO IMAGENS  *********
    * ****************************************
     COMO USAR:
    * *****************************************
     echo Check::Imagem('imagens_fixas/sem_imagem.jpg', 'Sem imagem', '200', '100', 'botao');
    */
   public static function Imagempegasus($ImageUrl, $ImageDesc, $ImageW = null, $ImageH = null, $Class = null) {
      self::$Data = $ImageUrl;
      $pasta = 'imagens_site/';

      if (file_exists(self::$Data) && !is_dir(self::$Data)):
         $patch = PEGASUS;
         $imagem = self::$Data;
         return "<img src=\"{$patch}{$pasta}tim.php?src={$patch}$imagem&w={$ImageW}&h={$ImageH}&zc=1&q=100\" alt=\"{$ImageDesc}\" title=\"{$ImageDesc}\" class=\"{$Class}\" />";
      else:
         return false;
      endif;
   }

   /**
    * ***********************************************
    * ****** CONTADOR DE VISITA EM PAGINAS  *********
    * **********************************************
     COMO USAR:
    * *****************************************
     echo Check::EstatPagina('1', 'pagina inicial');
    */
   public static function EstatPagina($id_pagina, $nome) {
      $read = new Read;
      $read->ExeRead('contador_pagina', 'WHERE id_atribuido = :email', "email=" . $id_pagina . "");
      if ($read->getRowCount() >= 1):
         foreach ($read->getResult() as $resultado)
            ;
         $resultado['id_contapagina'];
         $resultado['nome_pagina'];
         $resultado['visitas'];
         $resultado['id_atribuido'];

         $dados = array(
             "visitas" => $resultado['visitas'] + 1,
         );
         $updade = new Update;
         $updade->ExeUpdate('contador_pagina', $dados, "WHERE id_atribuido = :id", "id=" . $id_pagina . "");
      else:
         $datas = array(
             "id_contapagina" => '',
             "nome_pagina" => $nome,
             "visitas" => '1',
             "id_atribuido" => $id_pagina
         );
         $Cadastra = new Create;
         $Cadastra->ExeCreate('contador_pagina', $datas);
      endif;
   }

   /**
    * ****************************************
    * ******* CRIADOR DE SITEMAPS  **********
    * ****************************************
     COMO USAR:
    * *****************************************
     Check::Sitemap();
    */
   public static function Sitemap() {
      $xml = fopen("sitemap.xml", "w+");
      fwrite($xml, "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<?xml-stylesheet type=\"text/xsl\" href=\"sitemap.xsl\"?>\n<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n\n");

      $conteudo = '  <url>' . "\n";
      $conteudo .= '     <loc>' . HOME . '</loc>' . "\n";
      $conteudo .= '     <lastmod>' . date('Y-m-d') . '</lastmod>' . "\n";
      $conteudo .= '     <changefreq>daily</changefreq>' . "\n";
      $conteudo .= '     <priority>1.0</priority>' . "\n";
      $conteudo .= '  </url>' . "\n";

      fwrite($xml, $conteudo);

      $readSitemapGeral = new Read;
      $readSitemapGeral->ExeRead("ws_sitemaps", "WHERE mps_status = 1 ORDER BY mps_date DESC");

      if (!$readSitemapGeral->getResult()): else:
         foreach ($readSitemapGeral->getResult() as $geral):
            $conteudo = '  <url>' . "\n";
            $conteudo .= '     <loc>' . HOME . '/' . $geral['mps_link'] . '</loc>' . "\n";
            $conteudo .= '     <lastmod>' . date('Y-m-d', strtotime($geral['mps_date'])) . '</lastmod>' . "\n";
            $conteudo .= '     <changefreq>weekly</changefreq>' . "\n";
            $conteudo .= '     <priority>' . $geral['mps_priority'] . '</priority>' . "\n";
            $conteudo .= '  </url>' . "\n";
            fwrite($xml, $conteudo);
         endforeach;
      endif;


      $readSitemap = new Read;
      $readSitemap->ExeRead("ws_posts", "WHERE post_status = 1 ORDER BY post_date DESC");

      if (!$readSitemap->getResult()): else:
         foreach ($readSitemap->getResult() as $principal):
            $conteudo = '  <url>' . "\n";
            $conteudo .= '     <loc>' . HOME . '/artigo/' . $principal['post_name'] . '</loc>' . "\n";
            $conteudo .= '     <lastmod>' . date('Y-m-d', strtotime($principal['post_date'])) . '</lastmod>' . "\n";
            $conteudo .= '     <changefreq>weekly</changefreq>' . "\n";
            $conteudo .= '     <priority>0.8</priority>' . "\n";
            $conteudo .= '  </url>' . "\n";
            fwrite($xml, $conteudo);
         endforeach;
      endif;
      fwrite($xml, "\n</urlset>");
      fclose($xml);

      $empty = filter_input(INPUT_GET, 'empty', FILTER_VALIDATE_BOOLEAN);
      if ($empty):
         SitemapXml();
         unlink("sitemap.xml.gz");
      endif;
   }

   /**
    * isCpfValid
    *
    * Esta função testa se um cpf é valido ou não. 
    *
    * @author	Raoni Botelho Sporteman <raonibs@gmail.com>
    * @version	1.0 Debugada em 26/09/2011 no PHP 5.3.8
    * @param	string		$cpf			Guarda o cpf como ele foi digitado pelo cliente
    * @param	array		$num			Guarda apenas os números do cpf
    * @param	boolean		$isCpfValid		Guarda o retorno da função
    * @param	int			$multiplica 	Auxilia no Calculo dos Dígitos verificadores
    * @param	int			$soma			Auxilia no Calculo dos Dígitos verificadores
    * @param	int			$resto			Auxilia no Calculo dos Dígitos verificadores
    * @param	int			$dg				Dígito verificador
    * @return	boolean						"true" se o cpf é válido ou "false" caso o contrário
    *
    */
   public static function CPF($cpf) {
      //Etapa 1: Cria um array com apenas os digitos numéricos, isso permite receber o cpf em diferentes formatos como "000.000.000-00", "00000000000", "000 000 000 00" etc...
      $j = 0;
      for ($i = 0; $i < (strlen($cpf)); $i++) {
         if (is_numeric($cpf[$i])) {
            $num[$j] = $cpf[$i];
            $j++;
         }
      }
      //Etapa 2: Conta os dígitos, um cpf válido possui 11 dígitos numéricos.
      if (count($num) != 11) {
         $isCpfValid = false;
      }
      //Etapa 3: Combinações como 00000000000 e 22222222222 embora não sejam cpfs reais resultariam em cpfs válidos após o calculo dos dígitos verificares e por isso precisam ser filtradas nesta parte.
      else {
         for ($i = 0; $i < 10; $i++) {
            if ($num[0] == $i && $num[1] == $i && $num[2] == $i && $num[3] == $i && $num[4] == $i && $num[5] == $i && $num[6] == $i && $num[7] == $i && $num[8] == $i) {
               $isCpfValid = false;
               break;
            }
         }
      }
      //Etapa 4: Calcula e compara o primeiro dígito verificador.
      if (!isset($isCpfValid)) {
         $j = 10;
         for ($i = 0; $i < 9; $i++) {
            $multiplica[$i] = $num[$i] * $j;
            $j--;
         }
         $soma = array_sum($multiplica);
         $resto = $soma % 11;
         if ($resto < 2) {
            $dg = 0;
         } else {
            $dg = 11 - $resto;
         }
         if ($dg != $num[9]) {
            $isCpfValid = false;
         }
      }
      //Etapa 5: Calcula e compara o segundo dígito verificador.
      if (!isset($isCpfValid)) {
         $j = 11;
         for ($i = 0; $i < 10; $i++) {
            $multiplica[$i] = $num[$i] * $j;
            $j--;
         }
         $soma = array_sum($multiplica);
         $resto = $soma % 11;
         if ($resto < 2) {
            $dg = 0;
         } else {
            $dg = 11 - $resto;
         }
         if ($dg != $num[10]) {
            $isCpfValid = false;
         } else {
            $isCpfValid = true;
         }
      }
      //Trecho usado para depurar erros.
      /*
        if($isCpfValid==true)
        {
        echo "<font color="GREEN">Cpf é Válido</font>";
        }
        if($isCpfValid==false)
        {
        echo "<font color="RED">Cpf Inválido</font>";
        }
       */
      //Etapa 6: Retorna o Resultado em um valor booleano.
      return $isCpfValid;
   }

}
