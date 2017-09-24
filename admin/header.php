<?php header ('Content-type: text/html; charset=UTF-8');?>
<!DOCTYPE html>
<html>
    <head>
        
        <!-- Title -->
        <title>Administra&ccedil;&atilde;o | Encontro de Saberes  <?= date('Y');?> - Universidade Federal de Ouro Preto</title>
        
        <meta content="width=device-width, initial-scale=1" name="viewport"/>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
        <meta name="description" content="O Encontro de Saberes visa integrar ensino, pesquisa e extensão,
         pilares do Ensino Superior, com objetivo de ampliar e aprofundar o diálogo entre a Universidade 
         Federal de Ouro Preto e a comunidade." />
        <meta name="robots" content="noindex, nofollow"> 
        <meta name="keywords" content="encontro de saberes, ufop, artigos" />
        <meta name="author" content="Hugo Leonardo Siqueira" />
        
        <!-- Styles -->
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600' rel='stylesheet' type='text/css'>
        <link href="assets/plugins/pace-master/themes/blue/pace-theme-flash.css" rel="stylesheet"/>
        <link href="assets/plugins/uniform/css/uniform.default.min.css" rel="stylesheet"/>
        <link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="assets/plugins/fontawesome/css/font-awesome.css" rel="stylesheet" type="text/css"/>
        <link href="assets/plugins/line-icons/simple-line-icons.css" rel="stylesheet" type="text/css"/>	
        <link href="assets/plugins/offcanvasmenueffects/css/menu_cornerbox.css" rel="stylesheet" type="text/css"/>	
        <link href="assets/plugins/waves/waves.min.css" rel="stylesheet" type="text/css"/>	
        <link href="assets/plugins/switchery/switchery.min.css" rel="stylesheet" type="text/css"/>
        <link href="assets/plugins/3d-bold-navigation/css/style.css" rel="stylesheet" type="text/css"/>	
        <link href="assets/plugins/slidepushmenus/css/component.css" rel="stylesheet" type="text/css"/>
        <link href="assets/plugins/datatables/css/jquery.datatables.min.css" rel="stylesheet" type="text/css"/> 
        <link href="assets/plugins/datatables/css/jquery.datatables_themeroller.css" rel="stylesheet" type="text/css"/> 
        <link href="assets/plugins/toastr/toastr.min.css" rel="stylesheet" type="text/css"/>    
        
        <!-- Theme Styles -->
        <link href="assets/css/modern.min.css" rel="stylesheet" type="text/css"/>
        <link href="assets/css/themes/red.css" class="theme-color" rel="stylesheet" type="text/css"/>
        <link href="assets/css/custom.css" rel="stylesheet" type="text/css"/>
        
        <script src="assets/plugins/3d-bold-navigation/js/modernizr.js"></script>
        <script src="assets/plugins/offcanvasmenueffects/js/snap.svg-min.js"></script>
        
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        
    </head>
    <body class="page-header-fixed page-horizontal-bar compact-menu">
        <div class="overlay"></div>
        <main class="page-content content-wrap container">
            <div class="navbar">
                <div class="navbar-inner">
                    <div class="sidebar-pusher">
                        <a href="javascript:void(0);" class="waves-effect waves-button waves-classic push-sidebar">
                            <i class="fa fa-bars"></i>
                        </a>
                    </div>
                    <div class="logo-box">
                        <a href="index.php" class="logo-text"><img src="assets/images/es_icon.png" alt="Logo encontro de saberes" class="img-responsive"/></a>
                    </div><!-- Logo Box -->
                    <div class="search-button">
                        <a href="javascript:void(0);" class="waves-effect waves-button waves-classic show-search"><i class="fa fa-search"></i></a>
                    </div>
                    <div class="topmenu-outer">
                        <div class="top-menu">
                            <ul class="nav navbar-nav navbar-right">                              
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle waves-effect waves-button waves-classic" data-toggle="dropdown">
                                        <span class="user-name"><?= NOME_USUARIO; ?><i class="fa fa-angle-down"></i></span>
                                        <img class="img-circle avatar" src="assets/images/perfil.png" width="40" height="40" alt="">
                                    </a>
                                    <?php if(CONTA_ATIVADA){ ?>
                                    <ul class="dropdown-menu dropdown-list" role="menu">
                                        <li role="presentation"><a href="perfil.php"><i class="fa fa-user"></i>Dados Pessoais</a></li>
                                        <li role="presentation" class="divider"></li>
                                        <li role="presentation"><a href="../login/logout.php"><i class="fa fa-sign-out m-r-xs"></i>Sair do Sistema</a></li>
                                    </ul>
                                    <?php } ?>
                                </li>
                                <li>
                                    <a href="../login/logout.php" class="log-out waves-effect waves-button waves-classic">
                                        <span><i class="fa fa-sign-out m-r-xs"></i>Sair do sistema</span>
                                    </a>
                                </li>
                            </ul><!-- Nav -->
                        </div><!-- Top Menu -->
                    </div>
                </div>
            </div><!-- Navbar -->