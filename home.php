<h1 style=" margin: 0 auto; margin-top: 3%">Cadastro de Currículos para Iniciação Científica - ILMD</h1>

<article class="janela b-shadow">
   <form method="post" name="cadastrar_curriculo" class="form" style="">
      <div class="box box50">
         <p class="texto_form">Nome completo</p>
         <input name="nome"  type="text" required placeholder="Nome completo (obrigatório)" style="width: 100%"/>
      </div>
      <div class="box box50 no-margim">
         <p class="texto_form">E-mail</p>
         <input name="email"  type="email" required placeholder="E-mail (obrigatório)" style="width: 100%"/>
      </div>
      <div class="limpar"></div>

      <div class="box box25">
         <p class="texto_form">CPF</p>
         <input name="cnpj_cpf" min="11" max="11"  type="text" required placeholder="CPF (obrigatório)" id="mascara_cpf" style="width: 100%"/>
         <div style=" text-align: left; color: red; font-size: 0.9em; font-weight: 600; border: 1px solid red; padding: 2%" class="mensagem_cpf ds-none"></div>
      </div>
      <div class="box box25">
         <p class="texto_form">RG</p>
         <input name="rg"  type="text" required placeholder="RG (obrigatório)" style="width: 100%"/>
      </div>
      <div class="box box25 no-margim">
         <p class="texto_form">Telefone ou celular</p>
         <input name="tel" type="text" required placeholder="Telefone" id="mascara_celular" style=" width: 100%;"/>
      </div>

      <!-- <div class="box box25 no-margim" style="margin-left: 10px">
         <p class="texto_form">Sexo</p>
         <select name="sexo" style="background: #fff">
            <option value="F">F</option>
            <option value="M">M</option>
         </select>
      </div> -->

      <div class="limpar"></div>

      <p class="legenda_form">Endereço completo</p>
      <div class="box box-completa">
         <input name="cep" class="cep_cad_parsa" type="text" placeholder="Seu CEP (obrigatório)" value="" id="csp mascara_cep" style=" width: 99%;" />
         <div class="load2" style=" display: none"></div>
      </div>
      <div class="box box70">
         <input name="rua" type="text"  placeholder="Rua, Avenida" value="" id="logradourop" style=" width: 100%;"  />
      </div>
      <div class="box box30 no-margim">
         <input name="numero" type="text"  placeholder="Nº" value="" style=" width: 100%;" />
      </div>
      <div class="limpar"></div>

      <div class="box box-completa">
         <input name="complemento" type="text" placeholder="Complemento" value="" style=" width: 99%;" />
      </div>
      <div class="limpar"></div>

      <div class="box box35">
         <input name="bairro" type="text" placeholder="Bairro"  value="" id="bairrop" style=" width: 100%;" />
      </div>
      <div class="box box35">
         <input name="cidade" type="text"  placeholder="Cidade" value="" id="localidadep" style=" width: 100%;" /> 
      </div>

      <div class="box box30 no-margim">
         <input name="estado" type="text"  placeholder="Estado" value="" id="ufp" style=" width: 100%;" />
      </div>
      <div class="limpar"></div>
      <div class="box box50">
         <p class="texto_form">Curso</p>
         <select name="curso" required style="width: 100%; background: #fff;" class="js-example-basic-single selecine">
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
      <div class="box box50 no-margim">
         <p class="texto_form">Instituição</p>
         <select name="instituicao" required style="width: 100%; background: #fff;" class="js-example-basic-single">
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
      <div class="limpar" style=" margin-bottom: 2%"></div>
      <div class="informaoutros box box100 no-margim ds-none" style=" width: 100%"></div>
      <div class="box box33">
         <p class="texto_form">Ano de Ingresso</p>
         <input name="ano" type="text" required id="ano" placeholder="Ano de ingresso (obrigatório)" value="" style=" width: 100%;" />
      </div>
      <div class="box box33">
         <p class="texto_form">Ano Provável de Conclusão</p>
         <input name="ano_c" type="text" id="ano_c" required  placeholder="Ano provável de conclusão (obrigatório)" value="" style=" width: 100%;" />
      </div>
      <div class="box box33 no-margim">
         <p class="texto_form">Coeficiente de Rendimento Acumulado (CRA)</p>
         <input name="coeficiente" id="coe" type="text" required  placeholder="Coeficiente de rendimento acumulado (CRA) (obrigatório)" value="" style=" width: 100%;" />
      </div>
      <div class="limpar"></div>

      <div class="box box50">
         <p class="texto_form">Link CV Lattes</p>
         <input name="link" type="text" required  placeholder="Link CV Lattes (obrigatório)" value="" style=" width: 100%;" />
      </div>
      <div class="box box50 no-margim selcionar">
         <p class="texto_form">Já fez Iniciação Científica?</p>
         <select name="iniciacao" required style="width: 100%; background: #fff;" class="js-example-basic-single">
            <option value="1">Não</option>
            <option value="2">Sim</option>
         </select>
         <input class="iniciar ds-none" name="orientador" type="text"  placeholder="Nome do último orientador" value="" style=" width: 100%;" />
      </div>
      <div class="limpar" style=" margin-bottom: 2%"></div>
      <script>
         $(function () {
            var MAX_SELECT = 4; // Máximo de 'input' selecionados

            $('input.limited').on('change', function () {
               if ($(this).siblings(':checked').length >= MAX_SELECT) {
                  this.checked = false;
               }
            });
         });
      </script>
      <p class="texto_form">Áreas de interesse (Pelo menos 1, Máximo 4)</p>

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
      <input name="areas[]" class='limited' value="Outro" type='checkbox'/> Outro <br>
      
       <div class="limpar" style=" margin-bottom: 2%"></div>
     <!-- <div class="box box30">
         <img style="float: left" src="<?//=HOME?>captcha.php?l=150&a=50&tf=20&ql=5">
         <input style="float: left; width: 48%; padding: 3.1% 11%; margin-left: 2%; font-size: 1.5em;" required type="text" name="palavra"  />
      </div> -->
       <div class="limpar" style=""></div>
       <div style=" text-align: left; color: red; font-size: 1.3em; font-weight: 600;" class="mensagem_capchat ds-none"></div>
      

      <div class="limpar" style=" margin-bottom: 2%"></div>
      <button class="btn btn-green-up sumir_botao">Cadastrar Currículo</button>
      <span class="carregando2 ds-none"><img src="<?= HOME; ?>imagens_fixas/carregando2.gif"/></span> 
   </form>
</article>
<div class="limpar" style=" margin-bottom: 5%"></div>