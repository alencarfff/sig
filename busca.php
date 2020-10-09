<?php include('menu.php') ?>

<h1 style=" margin: 0 auto; margin-top: 7%">Sistema de Informação Gerencial</h1>
<article class="janela b-shadow">
   <form method="post" name="buscar_curriculo" class="form" style="">
      <div class="box box25">
         <p class="texto_form">Nome completo</p>
         <input name="nome"  type="text" placeholder="Nome completo (obrigatório)" style="width: 100%"/>
      </div>
      <div class="box box25">
         <p class="texto_form">Curso</p>
         <select name="curso"  style="width: 100%; background: #fff;" class="js-example-basic-single">
            <option value="">Selecione</option>
            <option value="Biomedicina">Biomedicina</option>
            <option value="Biotecnologia">Biotecnologia</option>
            <option value="Ciências Biológicas">Ciências Biológicas</option>
            <option value="Ciências Biológicas – Licenciatura">Ciências Biológicas – Licenciatura</option>
            <option value="Ciências Sociais">Ciências Sociais</option>
            <option value="Educação Física">Educação Física</option>
            <option value="Enfermagem">Enfermagem</option>
            <option value="Engenharia de Bioprocessos">Engenharia de Bioprocessos</option>
            <option value="Engenharia da Computação">Engenharia da Computação</option>
            <option value="Sistemas da Informação">Sistemas da Informação</option>
            <option value="Ciência da Computação">Ciência da Computação</option>
            <option value="Estatística">Estatística</option>
            <option value="Farmácia">Farmácia</option>
            <option value="Fisioterapia">Fisioterapia</option>
            <option value="Geografia">Geografia</option>
            <option value="História">História</option>
            <option value="Medicina">Medicina</option>
            <option value="Nutrição">Nutrição</option>
            <option value="Odontologia">Odontologia</option>
            <option value="Psicologia">Psicologia</option>
            <option value="Química">Química</option>
            <option value="Terapia Ocupacional">Terapia Ocupacional</option>
            <option value="Outro">Outro</option>
         </select>
      </div>
      <div class="box box25">
         <p class="texto_form">Instituição</p>
         <select name="instituicao" style="width: 100%; background: #fff;" class="js-example-basic-single">
            <option value="">Selecione</option>
            <option value="1">Centro Universitário Claretiano (CEUCLAR)</option>
            <option value="2">Centro Universitário de Ensino Superior do Amazonas (CIESA)</option>
            <option value="3">Centro Universitário do Norte (UniNorte)</option>
            <option value="4">Centro Universitário FAMETRO</option>
            <option value="5">Centro Universitário Luterano de Manaus (CEULM/ ULBRA)</option>
            <option value="6">Centro Universitário Maurício de Nassau (UNINASSAU)</option>
            <option value="7">Escola Superior Batista do Amazonas (ESBAM)</option>
            <option value="8">Faculdade Estácio de Manaus (Estácio)</option>
            <option value="9">Faculdade La Salle</option>
            <option value="10">Faculdade Martha Falcão Wyden (FMF WYDEN)</option>
            <option value="11">FUCAPI</option>
            <option value="12">Instituto Federal do Amazonas (IFAM)</option>
            <option value="13">SENAC Amazonas (SENAC)</option>
            <option value="14">Universidade do Estado do Amazonas - UEA</option>
            <option value="15">Universidade Federal do Amazonas – UFAM</option>
            <option value="16">Universidade Nilton Lins (UniNiltonLins)</option>
            <option value="17">Universidade Paulista (UNIP)</option>
            <option value="18">Outro</option>
         </select>
      </div>
      <div class="box box25 no-margim">
         <p class="texto_form">Ano de Ingresso</p>
         <input name="ano" type="text" id="ano" placeholder="Ano de ingresso (obrigatório)" value="" style=" width: 100%;" />
      </div>
      <div class="limpar" style=" margin-bottom: 2%"></div>
      <div class="box box33">
         <p class="texto_form">Ano Provável de Conclusão</p>
         <input name="ano_c" type="text" id="ano_c" placeholder="Ano provável de conclusão (obrigatório)" value="" style=" width: 100%;" />
      </div>
      <div class="box box33">
         <p class="texto_form">Coeficiente de Rendimento Acumulado (CRA)</p>
         <select name="coeficiente"  style="width: 100%; background: #fff;" class="js-example-basic-single">
            <option value="">Selecione</option>
            <option value="1">Menor 5.0</option>
            <option value="2">Entre 5.1 e 7.0</option>
            <option value="3">Entre 7.1 e 8.0</option>
            <option value="4">Entre 8.1 e 9.0</option>
            <option value="5">Maior que 9.1</option>
         </select>
      </div>
      <div class="box box33 no-margim">
         <p class="texto_form">Áreas de Interesse</p>
         <select name="area"  style="width: 100%; background: #fff;" class="js-example-basic-single">
            <option value="">Selecione</option>
            <?php
            $even = new Read;
            $even->FullRead("SELECT nome, id FROM atuacao WHERE nome <> '' GROUP BY nome");
            //$even->ExeRead('carro', 'WHERE marca <> "" and status = 1 GROUP BY marca');
            foreach ($even->getResult() as $marca):
               ?>                
               <option value="<?= $marca['nome']; ?>"><?= $marca['nome']; ?></option>                
            <?php endforeach; ?>  
         </select>
      </div>
      <div class="limpar" style=" margin-bottom: 2%"></div>

 <!--<p class="texto_form">Áreas de interesse (Pelo menos 1, Máximo 4)</p>

 <input name="areas[]" class='limited' value="Bacteriologia" checked type='checkbox'/> Bacteriologia <br>
    <input name="areas[]" class='limited' value="Biotecnologia" type='checkbox'/> Biotecnologia <br>
    <input name="areas[]" class='limited' value="Educação em Saúde" type='checkbox'/> Educação em Saúde <br>
    <input name="areas[]" class='limited' value="Epidemiologia" type='checkbox'/> Epidemiologia <br>
    <input name="areas[]" class='limited' value="Entomologia" type='checkbox'/> Entomologia <br>


    <input name="areas[]" class='limited' value="Genética e Biologia Molecular" type='checkbox'/> Genética e Biologia Molecular <br>
    <input name="areas[]" class='limited' value="Imunologia" type='checkbox'/> Imunologia <br>
    <input name="areas[]" class='limited' value="Microbiologia" type='checkbox'/> Microbiologia <br>
    <input name="areas[]" class='limited' value="Parasitologia" type='checkbox'/> Parasitologia <br>
    <input name="areas[]" class='limited' value="Pesquisa Clínica" type='checkbox'/> Pesquisa Clínica <br>


    <input name="areas[]" class='limited' value="Políticas Públicas em Saúde" type='checkbox'/> Políticas Públicas em Saúde <br>
    <input name="areas[]" class='limited' value="Saúde e Ambiente" type='checkbox'/> Saúde e Ambiente <br>
    <input name="areas[]" class='limited' value="Virologia" type='checkbox'/> Virologia <br>
    <input name="areas[]" class='limited' value="Outro" type='checkbox'/> Outro <br>-->

      <div class="limpar" style=" margin-bottom: 2%"></div>
      <button class="btn btn-green-up sumir_botao">Buscar Currículo</button>
      <span class="carregando2 ds-none"><img src="<?= HOME; ?>imagens_fixas/carregando2.gif"/></span> 
   </form>
   <div class="limpar" style=" margin-bottom: 2%"></div>
   <p>Quantidade de itens carregados: 
      <span id="qntd_items"></span>
   </p>
   <div class="resposta_busca">

   </div>
</article>
<div class="limpar" style=" margin-bottom: 2%"></div>
