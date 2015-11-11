<?php 
require_once '../config/autoload.php'; 
$autentica = new Autentica();
$autentica->verificaSessao();
?>
<!DOCTYPE html>
<html lang="pt_BR">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
	<title>SITURB</title>
	<link rel="shortcut icon" href="<?php echo URL_ROOT; ?>assets/ico/favicon.ico">
	<link type="text/css" rel="stylesheet" href="<?php echo URL_ROOT; ?>assets/css/bootstrap/bootstrap.min.css" />
	<link type="text/css" rel="stylesheet" href="<?php echo URL_ROOT; ?>assets/css/bootstrap/bootstrap-themes.css" />
	<link type="text/css" rel="stylesheet" href="<?php echo URL_ROOT; ?>assets/css/style.css" />
	<link type="text/css" rel="stylesheet" href="<?php echo URL_ROOT; ?>assets/css/modstyle.css" />

	<link rel="stylesheet" href="../lib/mapbb/leaflet.css" />
	<link rel="stylesheet" href="../lib/mapbb/leaflet.draw.css" />
	<script src="<?php echo URL_ROOT; ?>lib/mapbb/leaflet.js"></script>
	<script src="<?php echo URL_ROOT; ?>lib/mapbb/leaflet.draw.js"></script>
	<script src="<?php echo URL_ROOT; ?>lib/mapbb/mapbbcode.js"></script>
	<script src="<?php echo URL_ROOT; ?>lib/mapbb/Handler.Simplify.js"></script>
	<script src="<?php echo URL_ROOT; ?>ib/mapbb/Handler.Length.js"></script>
</head>
<body class="leftMenu nav-collapse">
	<div id="wrapper">
		<div id="header">
			<div class="logo-area clearfix">
				<a href="#" class="logo"></a>
			</div>
			<div class="tools-bar">
				<ul class="nav navbar-nav nav-main-xs">
					<li><a href="#" class="icon-toolsbar nav-mini"><i class="fa fa-bars"></i></a></li>
				</ul>
				<ul class="nav navbar-nav nav-top-xs hidden-xs tooltip-area">
					<li class="h-seperate"></li>
				</ul>
				<ul class="nav navbar-nav navbar-right tooltip-area">
					<li>
						<a href="#" class="avatar-header">
							<img alt="" src="../assets/img/avatar.png"  class="circle">
						</a>
					</li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown">
							<em><strong>Olá</strong>, <?php echo $_SESSION["nome"]; ?> </em> <i class="dropdown-icon fa fa-angle-down"></i>
						</a>
						<ul class="dropdown-menu pull-right icon-right arrow">
							<li><a href="../usuario/perfil.php"><i class="fa fa-user"></i> Perfil </a></li>
							<li class="divider"></li>
							<li><a href="../home/logout.php"><i class="fa fa-sign-out"></i> Sair </a></li>
						</ul>
					</li>
					<li class="visible-lg">
						<a href="#" class="h-seperate fullscreen" data-toggle="tooltip" title="Tela inteira" data-container="body"  data-placement="left">
							<i class="fa fa-expand"></i>
						</a>
					</li>
				</ul>
			</div>
		</div>