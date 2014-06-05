<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7 ie6"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8 ie7"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9 ie8"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
  <head>
    <title><?php echo $data['blog_title']?></title>

    <meta charset="<?php echo $data['charset']?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width">
    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <!-- favicons -->
    <link rel="shortcut icon" href="<?php echo THEMEURL?>favicon.ico" />
    <!-- For third-generation iPad with high-resolution Retina display: -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo THEMEURL?>apple-touch-icon-144x144-precomposed.png">
    <!-- For iPhone with high-resolution Retina display: -->
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo THEMEURL?>apple-touch-icon-114x114-precomposed.png">
    <!-- For first- and second-generation iPad: -->
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo THEMEURL?>apple-touch-icon-72x72-precomposed.png">
    <!-- For non-Retina iPhone, iPod Touch, and Android 2.1+ devices: -->
    <link rel="apple-touch-icon-precomposed" href="<?php echo THEMEURL?>apple-touch-icon-precomposed.png">
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
    <?php wp_head(); ?>