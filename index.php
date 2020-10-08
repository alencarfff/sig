<?php
require("./poo/app/Config.inc.php");
$sessao = new Session;
?>
<!DOCTYPE html>
<html lang="pt-br" itemscope itemtype="https://schema.org/WebPage">
    <head>
        <!--METAS DA PAGINA-->
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <title><?= $pg_titulo ?></title>
        <meta name="description" content="<?= strip_tags($pg_descricao); ?>" />
        <meta name="robots" content="index, follow" />
        <meta name="author" content="<?= SITENOME; ?>" />
        <link rel="canonical" href="<?= $pg_url; ?>" />
        <link rel="base" href="<?= HOME; ?>"/> 

        <!--[if lt IE 9]>
          <script src="<?= HOME; ?>js/html5shiv.js"></script>
        <![endif]-->

        <!--AUTORAÇÃO DA PAGINA-->
        <link rel="author" href="<?= $pg_autor; ?>"/>
        <link rel="publisher" href="<?= $pg_empresa; ?>"/>

        <!--SEO GENERICO PARA TODAS AS MIDIAS CONFIGURADO PARA O MICROFORMATO-->
        <meta itemprop="name" content="<?= $pg_titulo; ?>" />
        <meta itemprop="description" content="<?= strip_tags($pg_descricao); ?>" />
        <meta itemprop="image" content="<?= $pg_imagem; ?>" />
        <meta itemprop="url" content="<?= $pg_url; ?>" />

        <!--SEO OG PARA FACEBOOK-->
        <meta property="og:type" content="Article" />
        <meta property="og:title" content="<?= $pg_titulo; ?>" />
        <meta property="og:description" content="<?= strip_tags($pg_descricao); ?>" />
        <meta property="og:image" content="<?= $pg_imagem; ?>" />

        <meta property="og:image:secure_url" content="<?= $pg_imagem; ?>" />
        <meta property="og:image:type" content="image/jpeg" />
        <meta property="og:image:width" content="800" />
        <meta property="og:image:height" content="418" />

        <meta property="og:url" content="<?= $pg_url; ?>" />
        <meta property="og:site_name" content="<?= $pg_titulo; ?>" />
        <meta property="og:locale" content="pt_BR" />

        <!--SEO card PARA twitter-->
        <meta name="twitter:card" content="summary_large_image"/>
        <meta name="twitter:site" content="@dreamkid_studio"/>
        <meta name="twitter:title" content="<?= SITENOME; ?>"/>
        <meta name="twitter:description" content="<?= strip_tags($pg_descricao); ?>"/>
        <meta name="twitter:image" content="<?= $pg_imagem; ?>"/>

        <!--IDENTIFICADORES-->
        <meta property="article:author" content="<?= SITENOME; ?>" />
        <meta property="article:publisher" content="<?= SITENOME; ?>" />

        <link rel="shortcut icon" href="<?= HOME; ?>imagens_fixas/favicon.png"/>
        <link rel="alternate" type="application/rss+xml" title="<?= SITENOME; ?> RSS/Feed" href="<?= HOME; ?>rss.xml" />
        <link rel="stylesheet" href="<?= HOME; ?>poo/css/reset.css"/>

        <?php include('poo/css.php'); ?>
        <?php include('poo/js.php'); ?>
        <script type="text/javascript" src="<?= HOME; ?>poo/js_code.js"></script>
        <title><?= SITENOME; ?></title>
    </head>
    <body>
        <?php include('modais.php'); ?>
        <!--
        ===========================================================================================================================================
            TITULO DA PAGINA: INDEX.PHP(PAGINA INICIAL)
            CRIADA EM: ABRIL 2019
            DESENVOLVIDA POR: JOÃO OLIVEIRA            
        ===========================================================================================================================================
        -->

        <?php
        require("{$pagina}.php"); //para outras páginas apenas recuperar por  $atual[1], $atual[2]
        ?>

    </body>
</html>