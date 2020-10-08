$(window).ready(function () {

   //ESTABALECENDO ALTURA PARA A JANELA MODAS
   var modal = $(window).delay(2000).height();

});


var urlbase = $('link[rel="base"]').attr('href');

$(function () {

   var botao = $('.enviar');

   botao.attr("type", "submit");

   var forms = $('form');

   var urlphp = '' + urlbase + 'php/php.php';

   forms.submit(function () {
      return false;
   });
//===============================================================================================================================
// FUNÇÕES GENERICAS 
//===============================================================================================================================
   function carregando() {
      $('.modal').fadeIn(1000, function () {
         $('.modal_carregando').empty().html('<div style="padding: 5px;">Aguarde, enviando requisição!</div>');
      });
   }
   function erro(msg) {
      $('.modal').fadeIn(1000, function () {
         $('.msn-erro').empty().html(msg).fadeIn('slow');
         setTimeout(function () {
            $('.modal').fadeOut(1000);
            $('.msn-erro').empty();
         }, 3000);
      });
   }
   function sucesso(msg) {
      $('.modal').fadeIn(1000, function () {
         $('.msn-sucess').empty().html(msg).fadeIn();
         setTimeout(function () {
            $('.modal').fadeOut(1000);
            $('.msn-sucess').empty();
         }, 3000);
      });
   }
   function alerta(msg) {
      $('.modal').fadeIn(1000, function () {
         $('.msn-alert').empty().html(msg).fadeIn('slow');
         setTimeout(function () {
            $('.modal').fadeOut(1000);
            $('.msn-alert').empty();
         }, 3000);
      });
   }
   function erroines() {
      $('.modal').fadeIn(1000, function () {
         $('.msn-erro').empty().html('Erro inesperado, entre em contato com o administrador').fadeIn('slow');
         setTimeout(function () {
            $('.modal').fadeOut(1000);
            $('.msn-erro').empty();
         }, 3000);
      });
   }
   //------------ CONFIGURANDO BOX DA MODAL    --------------------------------------------------------------------
   $('.x_modal').click(function () {
      $('.msn-erro').empty().html('');
      $('.msn-sucess').empty().html('');
      $('.msn-alert').empty().html('');
      $('.msn-erro').empty().html('');
      $('.modal').fadeOut(600);
   });

   $('.transp').css({opacity: 0});
//===============================================================================================================================
// CONFIGURANDO AJAX 
//===============================================================================================================================	
   $.ajaxSetup({
      url: urlphp,
      type: 'POST',
      //beforeSend: carregando,
      error: erroines
   });
//===============================================================================================================================	
//=============================================================================================================================

   //MODAL
   $('.fecha_moldura').click(function () {
      $('.moldura').animate({top: '-180%'}), 1000;
      setTimeout(function () {
         $('.modal_janela_c').fadeOut();
      }, 300);
      return false;
   });

   $(".js-example-basic-single").select2();


   $('.selcionar select').change(function () {
      var estado = $(".selcionar select option:selected").attr('value');
      if (estado == '1') {
         $('.iniciar').fadeOut();
      } else {
         $('.iniciar').fadeIn();
      }
      return false;
   });



   $('.selecine').change(function () {
      var estado = $(".selecine option:selected").attr('value');
      if (estado == 'Outro') {
         $('.informaoutros').empty().html('<p class="texto_form">Informe o curso</p><input name="curso_inform" type="text" required placeholder="Informe o curso" value="" style=" width: 100%;" /><div class="limpar" style=" margin-bottom: 2%"></div>').fadeIn();
      } else {
         $('.informaoutros').empty().fadeOut();
      }
      return false;
   });

//===============================================================================================================================
// BUSCAR CEP
//===============================================================================================================================   

   $('body').on('focusout', '.cep_cad_parsa', function () {
      //$('.cep_cad_parsa').focusout(function () {
      $('.load2').empty().html('<img src="imagens_fixas/carregando.gif" width="20" height="20" />  Aguarde, enviando requisição!').fadeIn('fast');
      var delaid = $(this).val();
      var acao = "&acao=busca_cep&cep=" + delaid;
      var sender = acao;
      $.ajax({
         data: sender,
         beforeSend: function () {
            $('.load4').fadeIn(1000);
         },
         dataType: 'json',
         success: function (resposta) {
            //alert(resposta);
            if (resposta == 2) {
               erro('CEP, não encontrado');
               $('.load2').fadeOut(800);
            } else if (resposta == 9) {
               erro('Tokem de segurança não autenticado, atualize a pagina e tente novamente');
            } else {
               $('#logradourop').val(resposta.rua);
               $('#bairrop').val(resposta.bairro);
               $('#localidadep').val(resposta.cidade);
               $('#ufp').val(resposta.estado);
               $('.load2').fadeOut(800);
            }
         },
         complete: function () {
            //produto.find("input:text").val('');
            // produto.find(".textarea").val('');
         }
      });
   });


   var cadastrar_curriculo = $('form[name="cadastrar_curriculo"]');
   cadastrar_curriculo.submit(function () {
//     ! tinyMCE.triggerSave();
      $(this).ajaxSubmit({
         url: urlphp,
         type: 'post',
         data: {acao: "cadastrar_curriculo"},
         beforeSubmit: function () {
            $('.carregando2').fadeIn();
            $('.sumir_botao').fadeOut();
            $('.mensagem_capchat').fadeOut();
         },
         success: function (resposta) {
            //alert(resposta);
            if (resposta == 1) {
               sucesso('Cadastrado com sucesso!');
               setTimeout(function () {
                  location.href = "" + urlbase + "";
               }, 2000);
            } else if (resposta == 2) {
               $('.sumir_botao').fadeIn();
               $('.carregando2').fadeOut();
               erro('Erro ao enviar imagem, consultem um adminstrador');
            } else if (resposta == 3) {
               $('.sumir_botao').fadeIn();
               $('.carregando2').fadeOut();
               alerta('Erro ao enviar, existem campos em branco!');
            } else if (resposta == 4) {
               $('.sumir_botao').fadeIn();
               $('.carregando2').fadeOut();
               alerta('Cliente já cadastrado!');
            } else if (resposta == 14) {
               $('.mensagem_cpf').fadeIn();
               $('.carregando2').fadeOut();
               $('.sumir_botao').fadeIn();
               $('.mensagem_cpf').empty().html('CPF inválido!');
             // var deslocamento = $('.mensagem_cpf').offset().top;
               $('html, body').animate({scrollTop: 0}, 'slow');
            } else if (resposta == 13) {
               $('.mensagem_capchat').fadeIn();
               $('.carregando2').fadeOut();
               $('.sumir_botao').fadeIn();
               $('.mensagem_capchat').empty().html('CAPTCHA incorreto, tente novamente!');
            } else {
               $('.sumir_botao').fadeIn();
               $('.carregando2').fadeOut();
               erroines();
            }
         },
         complete: function () {
            //trocaimagem.find(".camp").val('');
         }
      });
      return false;
   });

   var buscar_curriculo = $('form[name="buscar_curriculo"]');
   buscar_curriculo.submit(function () {
//     ! tinyMCE.triggerSave();
      $(this).ajaxSubmit({
         url: urlphp,
         type: 'post',
         data: {acao: "buscar_curriculo"},
         beforeSubmit: function () {
            $('.carregando2').fadeIn();
            $('.sumir_botao').fadeOut();
            $('.resposta_busca').slideUp();
         },
         success: function (resposta) {
            //alert(resposta);
            if (resposta == 1) {
               sucesso('Cadastrado com sucesso!');
               setTimeout(function () {
                  location.href = "" + urlbase + "";
               }, 2000);
            } else if (resposta == 2) {
               $('.sumir_botao').fadeIn();
               $('.carregando2').fadeOut();
               erro('Erro ao enviar imagem, consultem um adminstrador');
            } else if (resposta == 3) {
               $('.sumir_botao').fadeIn();
               $('.carregando2').fadeOut();
               alerta('Erro ao enviar, existem campos em branco!');
            } else if (resposta == 4) {
               $('.sumir_botao').fadeIn();
               $('.carregando2').fadeOut();
               alerta('Cliente já cadastrado!');
            } else if (resposta == 5) {
               $('.sumir_botao').fadeIn();
               $('.carregando2').fadeOut();
               alerta('Livro já cadastrado, verifique o e-mail ou nome que já consta em nosso banco de dados!');
            } else if (resposta == 7) {
               $('.sumir_botao').fadeIn();
               $('.carregando2').fadeOut();
               alerta('Preço menor que R$10,00 reais por favor corrija!');
            } else {
               $('.sumir_botao').fadeIn();
               $('.carregando2').fadeOut();
               $('.resposta_busca').empty().html('' + resposta + '').slideDown();
            }
         },
         complete: function () {
            //trocaimagem.find(".camp").val('');
         }
      });
      return false;
   });

//===============================================================================================================================
// FUNÇÃO GERENRICA PARA O ENVIO DE FORMUÁRIOS
//===============================================================================================================================
   $('.enviando').submit(function () {
      tinyMCE.triggerSave();
      var formulario = $(this);
      //var dataInfo = $(this).serialize();
      var info = $(this).attr('id');
      //var data = "&acao=" + info;
      //var sender = dataInfo + data;

      if (info == 'enviandoform' || info == 'enviandoform2') {
         var carregador = $('.carregando2').fadeIn();
      } else {
         var carregador = carregando();
      }

      formulario.ajaxSubmit({
         url: urlphp,
         type: 'POST',
         data: {acao: '' + info + ''},
         dataType: 'json',
         beforeSend: function () {
            carregador;
         }, // fechando o beforeSend

         uploadProgress: function (evento, posicao, total, completo) {

         }, // fechando uploadProgress

         success: function (resposta) {
            console.clear();
            console.log(resposta);

            if (resposta.sucesso) {
               alert(resposta.sucesso);

            } else if (resposta.aviso) {

            } else if (resposta.erro) {
               alert(resposta.erro);
            }
         } // fechando o success
      }); // fechando o ajax
   }); // fecando o submit


});








//===============================================================================================================================
// SLIDER 100% DA TELA
//===============================================================================================================================
//******************* slider 100% da tela **************************************
$(window).load(function () {
   $('.slidequery li').each(function () {
      var img = $(this).find('img').attr("src");
      var pix = $(window).width();
      if (pix > '506') {
         $(this).find('img').attr("src", '' + urlbase + 'pegasus/imagens_site/tim.php?src=' + img + '&w=' + pix + '&h=500');
      } else {
         $(this).find('img').attr("src", '' + urlbase + 'pegasus/imagens_site/tim.php?src=' + img + '&w=' + pix + '&h=200');
      }

   });
});

$('.slidequery img').hide();
$('.slidequery').cycle({
   fx: 'fade',
   speed: 1500,
   timeout: 6000,
   //next:   '#next2', 
   //prev:   '#prev2' 
   pager: '.slidequerynav'
           //efeitos em fx: blindX, blindY, blindZ, cover, curtainX, curtainY, fade, fadeZoom, growX, growY
           //, none, scrollUp, scrollDown, scrollLeft, scrollRight, scrollHorz, scrollVert, shuffle, slideX, 
           //slideY, toss, turnUp, turnDown, turnLeft, turnRight, uncover, wipe, zoom
});

//===============================================================================================================================
// EFEITO DE PAGINAÇÃO
//===============================================================================================================================
$(function () {
   var pagina_tamanho = $(window).width();
//alert(pagina_tamanho);

   $("div.holder").jPages({
      containerID: "paginacao",
      perPage: 1, //quantidade por pagina
      startPage: 1, //inicial em qual pagina
      startRange: 1,
      midRange: 10,
      endRange: 1,
      animation: "fadeInUp",
      ////flash,shake,fadeInDown,bounce,tada,swing,wobble,pulse,
      //flip,flipInX,flipOutX,flipInY,flipOutY,fadeIn,fadeInUp,fadeInLeft,fadeInRight,
      //fadeInUpBig,fadeInDownBig,fadeInLeftBig,fadeInRightBig,fadeOut,fadeOutDown,fadeOutLeft,
      //fadeOutRight,fadeOutUpBig,fadeOutDownBig,fadeOutLeftBig,bounceIn,bounceInUp,bounceInDown,
      //bounceInLeft,bounceInRight,bounceOut,bounceOutUp,bounceOutDown,bounceOutLeft,bounceOutRight,
      //rotateIn,rotateInUpLeft,hinge,rollIn,rollOut,
      pause: 6000  //efeito automatico em segundos 
   });


   $("div.apoior").jPages({
      containerID: "apoio",
      perPage: 1, //quantidade por pagina
      startPage: 1, //inicial em qual pagina
      startRange: 1,
      midRange: 10,
      endRange: 1,
      animation: "fadeInUp",
      ////flash,shake,fadeInDown,bounce,tada,swing,wobble,pulse,
      //flip,flipInX,flipOutX,flipInY,flipOutY,fadeIn,fadeInUp,fadeInLeft,fadeInRight,
      //fadeInUpBig,fadeInDownBig,fadeInLeftBig,fadeInRightBig,fadeOut,fadeOutDown,fadeOutLeft,
      //fadeOutRight,fadeOutUpBig,fadeOutDownBig,fadeOutLeftBig,bounceIn,bounceInUp,bounceInDown,
      //bounceInLeft,bounceInRight,bounceOut,bounceOutUp,bounceOutDown,bounceOutLeft,bounceOutRight,
      //rotateIn,rotateInUpLeft,hinge,rollIn,rollOut,
      pause: 6000  //efeito automatico em segundos 
   });



   if (pagina_tamanho >= '500') {

      $("div.palestra").jPages({
         containerID: "evento",
         perPage: 5, //quantidade por pagina
         startPage: 1, //inicial em qual pagina
         startRange: 1,
         midRange: 10,
         endRange: 1,
         animation: "fadeInLeft",
         ////flash,shake,fadeInDown,bounce,tada,swing,wobble,pulse,
         //flip,flipInX,flipOutX,flipInY,flipOutY,fadeIn,fadeInUp,fadeInLeft,fadeInRight,
         //fadeInUpBig,fadeInDownBig,fadeInLeftBig,fadeInRightBig,fadeOut,fadeOutDown,fadeOutLeft,
         //fadeOutRight,fadeOutUpBig,fadeOutDownBig,fadeOutLeftBig,bounceIn,bounceInUp,bounceInDown,
         //bounceInLeft,bounceInRight,bounceOut,bounceOutUp,bounceOutDown,bounceOutLeft,bounceOutRight,
         //rotateIn,rotateInUpLeft,hinge,rollIn,rollOut,
         pause: 7000  //efeito automatico em segundos 
      });

      $("div.blogsss").jPages({
         containerID: "blogss",
         perPage: 5, //quantidade por pagina
         startPage: 1, //inicial em qual pagina
         startRange: 1,
         midRange: 10,
         endRange: 1,
         animation: "fadeInLeft",
         ////flash,shake,fadeInDown,bounce,tada,swing,wobble,pulse,
         //flip,flipInX,flipOutX,flipInY,flipOutY,fadeIn,fadeInUp,fadeInLeft,fadeInRight,
         //fadeInUpBig,fadeInDownBig,fadeInLeftBig,fadeInRightBig,fadeOut,fadeOutDown,fadeOutLeft,
         //fadeOutRight,fadeOutUpBig,fadeOutDownBig,fadeOutLeftBig,bounceIn,bounceInUp,bounceInDown,
         //bounceInLeft,bounceInRight,bounceOut,bounceOutUp,bounceOutDown,bounceOutLeft,bounceOutRight,
         //rotateIn,rotateInUpLeft,hinge,rollIn,rollOut,
         pause: false  //efeito automatico em segundos 
      });
   } else {

      $("div.palestra").jPages({
         containerID: "evento",
         perPage: 1, //quantidade por pagina
         startPage: 1, //inicial em qual pagina
         startRange: 1,
         midRange: 10,
         endRange: 1,
         animation: "fadeInLeft",
         ////flash,shake,fadeInDown,bounce,tada,swing,wobble,pulse,
         //flip,flipInX,flipOutX,flipInY,flipOutY,fadeIn,fadeInUp,fadeInLeft,fadeInRight,
         //fadeInUpBig,fadeInDownBig,fadeInLeftBig,fadeInRightBig,fadeOut,fadeOutDown,fadeOutLeft,
         //fadeOutRight,fadeOutUpBig,fadeOutDownBig,fadeOutLeftBig,bounceIn,bounceInUp,bounceInDown,
         //bounceInLeft,bounceInRight,bounceOut,bounceOutUp,bounceOutDown,bounceOutLeft,bounceOutRight,
         //rotateIn,rotateInUpLeft,hinge,rollIn,rollOut,
         pause: 7000  //efeito automatico em segundos 
      });

      $("div.blogsss").jPages({
         containerID: "blogss",
         perPage: 1, //quantidade por pagina
         startPage: 1, //inicial em qual pagina
         startRange: 1,
         midRange: 10,
         endRange: 1,
         animation: "fadeInLeft",
         ////flash,shake,fadeInDown,bounce,tada,swing,wobble,pulse,
         //flip,flipInX,flipOutX,flipInY,flipOutY,fadeIn,fadeInUp,fadeInLeft,fadeInRight,
         //fadeInUpBig,fadeInDownBig,fadeInLeftBig,fadeInRightBig,fadeOut,fadeOutDown,fadeOutLeft,
         //fadeOutRight,fadeOutUpBig,fadeOutDownBig,fadeOutLeftBig,bounceIn,bounceInUp,bounceInDown,
         //bounceInLeft,bounceInRight,bounceOut,bounceOutUp,bounceOutDown,bounceOutLeft,bounceOutRight,
         //rotateIn,rotateInUpLeft,hinge,rollIn,rollOut,
         pause: false  //efeito automatico em segundos 
      });

   }

});

//===============================================================================================================================
// MODAL DO SHADOWBOX
//===============================================================================================================================
//Shadowbox.init({
//   language: 'pt',
//   player: ['img', 'html', 'swf']
//});


//===============================================================================================================================
// MASCARA PARA DATAS
//===============================================================================================================================
jQuery(function ($) {
   $("#mascara_data").mask("99/99/9999"); //Aqui montamos a máscara que queremos
   $("#mascara_celular").mask("(99)999999999");
   $("#mascara_cnpj").mask("99.999.999/9999-99");
   $("#mascara_telefone").mask("(99)99999-9999");
   $("#mascara_cpf").mask("999.999.999-99");
   $("#mascara_celular2").mask("(99)9999-99999");
   $("#mascara_telefone2").mask("(99)9999-9999");
   $("#mascara_cep").mask("99999-999"); //usando

   $("#mascara_data_usuario").mask("99/99/9999");
   $("#mascara_celular_usuario").mask("(99) 99999-9999");
   $("#mascara_telefone_usuario").mask("(99) 99999-9999");

   $("#mascara_telefone_denuncia").mask("(99) 999999999");

   $("#mascara_data_perfil").mask("99/99/9999");
   $("#mascara_celular_perfil").mask("(99) 99999-9999");
   $("#mascara_telefone_perfil").mask("(99) 99999-9999");

   $("#cad_parceiro").mask("(99) 99999-9999");
   $("#ano").mask("9999");
   $("#ano_c").mask("9999");
   $("#coe").mask("9.9");
});

//===============================================================================================================================
// MASCARA PARA VALIDAR O CNPJ OU CPF NO MESMO FORMULARIO
//===============================================================================================================================
function mascaraMutuario(o, f) {
   v_obj = o,
           v_fun = f,
           setTimeout('execmascara()', 1);
}

function execmascara() {
   v_obj.value = v_fun(v_obj.value);
}

function cpfCnpj(v) {
   //Remove tudo o que não é dígito
   v = v.replace(/\D/g, "");
   if (v.length < 14) { //CPF
      //Coloca um ponto entre o terceiro e o quarto dígitos
      v = v.replace(/(\d{3})(\d)/, "$1.$2");
      //Coloca um ponto entre o terceiro e o quarto dígitos
      //de novo (para o segundo bloco de números)
      v = v.replace(/(\d{3})(\d)/, "$1.$2");
      //Coloca um hífen entre o terceiro e o quarto dígitos
      v = v.replace(/(\d{3})(\d{1,2})$/, "$1-$2");
   } else { //CNPJ
      //Coloca ponto entre o segundo e o terceiro dígitos
      v = v.replace(/^(\d{2})(\d)/, "$1.$2");
      //Coloca ponto entre o quinto e o sexto dígitos
      v = v.replace(/^(\d{2})\.(\d{3})(\d)/, "$1.$2.$3");
      //Coloca uma barra entre o oitavo e o nono dígitos
      v = v.replace(/\.(\d{3})(\d)/, ".$1/$2");
      //Coloca um hífen depois do bloco de quatro dígitos
      v = v.replace(/(\d{4})(\d)/, "$1-$2");
   }
   return v;
}

//===============================================================================================================================
// CODIGO DE ACOMPANHAMENTO DO GOOGLE ANALYTICS
//===============================================================================================================================
