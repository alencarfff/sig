<?php
require('../poo/app/Config.inc.php');
$sessao = new Session;
$dataHora = date('d/m/Y - H:i:s');
$data = date('d/m/Y');
$dataStamp2 = date('Y-m-d');
$dataStanp = date('Y/m/d');
$dataStanpHora = date('Y/m/d - H:i:s');
$hora = date('H:i:s');
/* * ******************************************************************************************************
  FUNÇÃO PARA VALIDAR E ENVIAR E-MAIL
 * ****************************************************************************************************** */

function sendMail($assunto, $mensagem, $remetente, $nomeRemetente, $destino, $nomeDestino, $reply = NULL, $replyNome = NULL, $anexo_pasta = NULL) {

   require_once('../poo/app/Library/PHPMailer/class.phpmailer.php'); //Include pasta/classe do PHPMailer

   $mail = new PHPMailer(); //INICIA A CLASSE
   $mail->IsSMTP(); //Habilita envio SMPT
   $mail->SMTPAuth = false; //Ativa email autenticado
   $mail->IsHTML(true);

   $mail->Host = '' . MAILHOST . ''; //Servidor de envio
   $mail->Port = '' . MAILPORT . ''; //Porta de envio
   $mail->Username = '' . MAILUSER . ''; //email para smtp autenticado
   $mail->Password = '' . MAILPASS . ''; //seleciona a porta de envio

   $mail->From = utf8_decode($remetente); //remtente
   $mail->FromName = utf8_decode($nomeRemetente); //remtetene nome

   if ($anexo_pasta != NULL) {
      $mail->AddAttachment($anexo_pasta); //Enviar anexo
   }

   if ($reply != NULL) {
      $mail->AddReplyTo(utf8_decode($reply), utf8_decode($replyNome));
   }

   $mail->Subject = utf8_decode($assunto); //assunto
   $mail->Body = utf8_decode($mensagem); //mensagem
   $mail->AddAddress(utf8_decode($destino), utf8_decode($nomeDestino)); //email e nome do destino

   if ($mail->Send()) {
      return true;
   } else {
      return false;
   }
}

switch ($_POST['acao']) {
//===============================================================================================================================
// BUSCAR CEP
//=============================================================================================================================== 
   case 'busca_cep':
      $cep = $_POST['cep'];

      $reg = simplexml_load_file("http://cep.republicavirtual.com.br/web_cep.php?formato=xml&cep=" . $cep);
      $dados['sucesso'] = (string) $reg->resultado;
      $dados['rua'] = (string) $reg->tipo_logradouro . ' ' . $reg->logradouro;
      $dados['bairro'] = (string) $reg->bairro;
      $dados['cidade'] = (string) $reg->cidade;
      $dados['estado'] = (string) $reg->uf;

      if ($dados['sucesso'] == '1'):
         echo json_encode($dados);
      else:
         echo '2';
      endif;
      break;

   case 'cadastrar_curriculo':

      if ($_POST['palavra'] == $_SESSION["palavra"]):

         if (Check::CPF($_POST['cnpj_cpf'])):

            $nome = $_POST['nome'];
            $email = $_POST['email'];
            $cnpj_cpf = $_POST['cnpj_cpf'];
            $rg = $_POST['rg'];
            $tel = $_POST['tel'];
            $cep = $_POST['cep'];
            $rua = $_POST['rua'];
            $numero = $_POST['numero'];
            $complemento = $_POST['complemento'];
            $bairro = $_POST['bairro'];
            $cidade = $_POST['cidade'];
            $estado = $_POST['estado'];
            $curso = $_POST['curso'];
            $instituicao = $_POST['instituicao'];
            $ano = $_POST['ano'];
            $ano_c = $_POST['ano_c'];
            $coeficiente = $_POST['coeficiente'];
            $link = $_POST['link'];
            $iniciacao = $_POST['iniciacao'];
            $orientador = $_POST['orientador'];

            if (isset($_POST['curso_inform'])):
               $curso = $_POST['curso_inform'];
            endif;


            $Dados = [
                'nome' => $nome,
                'email' => $email,
                'cnpj_cpf' => $cnpj_cpf,
                'rg' => $rg,
                'tel' => $tel,
                'cep' => $cep,
                'rua' => $rua,
                'numero' => $numero,
                'complemento' => $complemento,
                'bairro' => $bairro,
                'cidade' => $cidade,
                'estado' => $estado,
                'curso' => $curso,
                'instituicao' => $instituicao,
                'ano' => $ano,
                'ano_c' => $ano_c,
                'coeficiente' => $coeficiente,
                'link' => $link,
                'iniciacao' => $iniciacao,
                'orientador' => $orientador,
                'data' => $dataStamp2,
                'hora' => $hora,
                'status' => '1',
            ];
            $Cadastra = new Create;
            $Cadastra->ExeCreate('curriculo', $Dados);
            if ($Cadastra->getResult()):

               $id_curriculo = $Cadastra->getResult();

               $_checkbox = $_POST['areas'];
               $Cadastra2 = new Create;
               foreach ($_checkbox as $_valor) {
                  $Dados2 = [
                      'id_curriculo' => $id_curriculo,
                      'nome' => $_valor,
                  ];
                  $Cadastra2->ExeCreate('atuacao', $Dados2);
               }
               echo '1';
            else:
               echo '2';
            endif;
         else:
            echo '14';
         endif;
      else:
         echo '13';
      endif;
      break;

   case 'buscar_curriculo':
      $nome = $_POST['nome'];
      $curso = $_POST['curso'];
      $instituicao = $_POST['instituicao'];
      $ano = $_POST['ano'];
      $ano_c = $_POST['ano_c'];
      $coeficiente = $_POST['coeficiente'];
      $area = $_POST['area'];

      if ($nome == ''):
         $nome = '';
      else:
         $nome = "curriculo.nome like '%" . Check::Limitador($nome, '1') . "%' or  '%" . $nome . "%'  and";
      endif;

      if ($curso == ''):
         $curso = '';
      else:
         $curso = "curriculo.curso = '" . $curso . "'   and";
      endif;

      if ($instituicao == ''):
         $instituicao = '';
      else:
         $instituicao = "curriculo.instituicao = '" . $instituicao . "'   and";
      endif;

      if ($ano == ''):
         $ano = '';
      else:
         $ano = "curriculo.ano = '" . $ano . "'   and";
      endif;

      if ($ano_c == ''):
         $ano_c = '';
      else:
         $ano_c = "curriculo.ano_c = '" . $ano_c . "'   and";
      endif;

      
      if ($coeficiente == ''):
          $coeficiente = '';
      elseif($coeficiente == '1'):
         $coeficiente = "curriculo.coeficiente BETWEEN 0 and 5.0 and";
      elseif($coeficiente == '2'):
         $coeficiente = "curriculo.coeficiente BETWEEN 5.1 and 7.0 and";
      elseif($coeficiente == '3'):
         $coeficiente = "curriculo.coeficiente BETWEEN 7.1 and 8.0 and";
      elseif($coeficiente == '4'):
         $coeficiente = "curriculo.coeficiente BETWEEN 8.1 and 9.0 and";
      elseif($coeficiente == '5'):
         $coeficiente = "curriculo.coeficiente BETWEEN 9.1 and 9.9 and";
      endif;
      
      if ($area == ''):
          $area = '';
      else:
         $area = "atuacao.nome = '" . $area . "'   and";
      endif;
      
     
      $read = new Read;
      $read->FullRead("
         select *, curriculo.id as id, curriculo.nome as nome  from 
         curriculo 
         inner join atuacao on curriculo.id = atuacao.id_curriculo
         WHERE 
             " . $nome . " 
             " . $curso . " 
             " . $instituicao . " 
             " . $ano . " 
             " . $ano_c . " 
             " . $coeficiente . " 
             " . $area . " 
             curriculo.status = '1' GROUP BY curriculo.id"
      );

      //echo '<pre>';
     //print_r($read);
      //echo '</pre>';
      if ($read->getRowCount() >= 1):
         foreach ($read->getResult() as $listagem_):
            ?>
            <div style=" background: #fff; padding: 2%; font-size: 1em; margin-bottom: 1.5%">
               <p style="float: left; margin-right: 1%"><span style="font-weight: 600;">Nome:</span> <span><?= $listagem_['nome']; ?></span></p>
               <p style="float: left; margin-right: 2%"><span style="font-weight: 600;">CPF:</span> <span><?= $listagem_['cnpj_cpf']; ?></span></p>
               <p style="float: left; margin-right: 2%"><span style="font-weight: 600;">RG:</span> <span><?= $listagem_['rg']; ?></span></p>
               <p style="float: left; margin-right: 2%"><span style="font-weight: 600;">E-mail:</span> <span><?= $listagem_['email']; ?></span></p>
               <p style="float: left; margin-right: 2%"><span style="font-weight: 600;">Tel/Cel:</span> <span><?= $listagem_['tel']; ?></span></p>
               <div class="limpar"></div>
               <p style="float: left; margin-right: 2%"><span style="font-weight: 600;">Endereço:</span> <span><?= $listagem_['rua']; ?></span></p>
               <p style="float: left; margin-right: 2%"><span style="font-weight: 600;">N:</span> <span><?= $listagem_['numero']; ?></span></p>
               <p style="float: left; margin-right: 2%"><span style="font-weight: 600;">Bairro:</span> <span><?= $listagem_['bairro']; ?></span></p>
               <p style="float: left; margin-right: 2%"><span style="font-weight: 600;">Cidade:</span> <span><?= $listagem_['cidade']; ?></span></p>
               <p style="float: left; margin-right: 2%"><span style="font-weight: 600;">Estado:</span> <span><?= $listagem_['estado']; ?></span></p>
               <p style="float: left; margin-right: 2%"><span style="font-weight: 600;">CEP:</span> <span><?= $listagem_['cep']; ?></p>
               <div class="limpar"></div>
               <p style="float: left; margin-right: 2%"><span style="font-weight: 600;">Curso:</span> 
                  <span><?=$listagem_['curso'];?></span>
               </p>
               <p style="float: left; margin-right: 2%"><span style="font-weight: 600;">Instituição:</span> 
                  <span><?php
                     if ($listagem_['instituicao'] == '1'):
                        echo 'Centro Universitário Claretiano (CEUCLAR)';
                     elseif ($listagem_['instituicao'] == '2'):
                        echo 'Centro Universitário de Ensino Superior do Amazonas (CIESA)';
                     elseif ($listagem_['instituicao'] == '3'):
                        echo 'Centro Universitário do Norte (UniNorte)';
                     elseif ($listagem_['instituicao'] == '4'):
                        echo 'Centro Universitário FAMETRO';
                     elseif ($listagem_['instituicao'] == '5'):
                        echo 'Centro Universitário Luterano de Manaus (CEULM/ ULBRA)';
                     elseif ($listagem_['instituicao'] == '6'):
                        echo 'Centro Universitário Maurício de Nassau (UNINASSAU)';
                     elseif ($listagem_['instituicao'] == '7'):
                        echo 'Escola Superior Batista do Amazonas (ESBAM)';
                     elseif ($listagem_['instituicao'] == '8'):
                        echo 'Faculdade Estácio de Manaus (Estácio)';
                     elseif ($listagem_['instituicao'] == '9'):
                        echo 'Faculdade La Salle';
                     elseif ($listagem_['instituicao'] == '10'):
                        echo 'Faculdade Martha Falcão Wyden (FMF WYDEN)';
                     elseif ($listagem_['instituicao'] == '11'):
                        echo 'FUCAPI';
                     elseif ($listagem_['instituicao'] == '12'):
                        echo 'Instituto Federal do Amazonas (IFAM)';
                     elseif ($listagem_['instituicao'] == '13'):
                        echo 'SENAC Amazonas (SENAC)';
                     elseif ($listagem_['instituicao'] == '14'):
                        echo 'Universidade do Estado do Amazonas - UEA';
                     elseif ($listagem_['instituicao'] == '15'):
                        echo 'Universidade Federal do Amazonas – UFAM';
                     elseif ($listagem_['instituicao'] == '16'):
                        echo 'Universidade Nilton Lins (UniNiltonLins)';
                     elseif ($listagem_['instituicao'] == '17'):
                        echo 'Universidade Paulista (UNIP)';
                     elseif ($listagem_['instituicao'] == '18'):
                        echo 'Outro';
                     endif;
                     ?></span>
               </p>
               <p style="float: left; margin-right: 2%"><span style="font-weight: 600;">Ano de ingresso:</span> <span><?= $listagem_['ano']; ?></span></p>
               <p style="float: left; margin-right: 2%"><span style="font-weight: 600;">Ano provável de conclusão:</span> <span><?= $listagem_['ano_c']; ?></span></p>
               <div class="limpar"></div>
               <p style="float: left; margin-right: 2%"><span style="font-weight: 600;">Coeficiente de rendimento acumulado (CRA):</span> <span><?= $listagem_['coeficiente']; ?></span></p>
               <p style="float: left; margin-right: 2%"><span style="font-weight: 600;">Link CV Lattes:</span> <span><?= $listagem_['link']; ?></span></p>
               <p style="float: left; margin-right: 2%"><span style="font-weight: 600;">Já fez Iniciação Científica?</span>  
                  <span><?php
                     if ($listagem_['iniciacao'] == '1'):
                        echo 'Não';
                     else:
                        echo 'Sim ' . $listagem_['orientador'] . '';
                     endif;
                     ?></span>
               </p>
               <div class="limpar"></div>
               <p style="float: left; margin-right: 2%"><span style="font-weight: 600;">Áreas de interesse:</span></p>
               <div class="limpar"></div>
               <?php
               $read->ExeRead('atuacao', "WHERE id_curriculo = :id", 'id=' . $listagem_['id'] . '');
               foreach ($read->getResult() as $area):
                  ?>
                  <p style="float: left; margin-right: 2%"><span style=""><?= $area['nome']; ?></span></p>
                  <?php
               endforeach;
               ?>
               <div class="limpar"></div>
            </div>
            <div class="limpar"></div>
            <?php
         endforeach;
      else:
         echo '<center><p>Desculpe, não encontrei nenhum resultado!</p></center>';
      endif;


      break;
}//FINALIZANDO SWITCH ACAO