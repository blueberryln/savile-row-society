<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="en"> <!--<![endif]-->
    <head>

        <!-- Basic Page Needs
  ================================================== -->
        <?php echo $this->Html->charset(); ?>
        <title>Savile Row Society <?php echo $title_for_layout; ?></title>
        <meta name="description" content="Savile Row Society">
        <meta name="author" content="30 Hills">
        <meta name="google-site-verification" content="Mexh7IdYEzy4A8dWzHtFHjmhf0UMxyWez8SJn1HU6T0" />

        <!-- Mobile Specific Metas
  ================================================== -->
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

        <!-- CSS
  ================================================== -->
        <?php
        echo $this->Html->css('base');
        echo $this->Html->css('skeleton');
        echo $this->Html->css('layout');
        echo $this->Html->css('admin');
        echo $this->fetch('css');
        ?>
        <link href='http://fonts.googleapis.com/css?family=Droid+Serif:400,700' rel='stylesheet' type='text/css'>

        <!-- Favicons
        ================================================== -->
        <link rel="shortcut icon" href="<?php echo $this->request->webroot; ?>img/favicon.ico">
        <link rel="apple-touch-icon" href="<?php echo $this->request->webroot; ?>img/apple-touch-icon.png">
        <link rel="apple-touch-icon" sizes="72x72" href="<?php echo $this->request->webroot; ?>img/apple-touch-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="114x114" href="<?php echo $this->request->webroot; ?>img/apple-touch-icon-114x114.png">

    </head>
    <body>
        <!-- Header
        ================================================== -->
        <?php echo $this->element('admin_header'); ?>

        <!-- Primary Page Layout
        ================================================== -->
        <?php echo $this->Session->flash(); ?>
        <?php echo $this->fetch('content'); ?>

        <div class="container content">
            <!-- footer -->
            <div class="sixteen columns footer">
                &copy <?php echo date('Y'); ?> Savile Row Society, inc. All Rights reserved.
            </div>
        </div><!-- container -->


        <!-- End Document
        ================================================== -->

        <!--[if lt IE 9]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js" type="text/javascript"></script>
        <script src="<?php echo $this->request->webroot; ?>js/block.ui.js" type="text/javascript"></script>

        <script type="text/javascript">
            $(document).ready(function() {
                if($('#flash-box').length){
                    $.blockUI({message: $('#flash-box'), timeout: 4000});
                }
                $('.blockOverlay, .notification-close').on('click', function(e){
                    e.preventDefault();
                    $.unblockUI();
                });
                if ($(".alert").length > 0) {
                    $(".alert").delay(1000).fadeOut();
                    $("#overlay").delay(1000).fadeOut();
                }

            });
            $(document).mouseup(function(e) {
                var alert_container = $(".alert");
                if (alert_container.has(e.target).length === 0) {
                    alert_container.fadeOut();
                    $("#overlay").fadeOut();
                }
            });
        </script>

        <?php echo $this->fetch('script'); ?>

        <?php echo $this->element('sql_dump'); ?>

    </body>
</html>