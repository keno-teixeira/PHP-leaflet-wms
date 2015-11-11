<?php require_once '../config/autoload.php'; ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
	<title>SITURB |  RECUPERAR SENHA</title>
	<link rel="shortcut icon" href="../assets/ico/favicon2.ico">
	<link type="text/css" rel="stylesheet" href="../assets/css/bootstrap/bootstrap.min.css" />
	<link type="text/css" rel="stylesheet" href="../assets/css/bootstrap/bootstrap-themes.css" />
	<link type="text/css" rel="stylesheet" href="../assets/css/style.css" />
	<link type="text/css" rel="stylesheet" href="../assets/css/modstyle.css" />
</head>
<body class="full-lg">
	<div id="wrapper">
		<div id="loading-top">
			<div id="canvas_loading"></div>
			<span>Verificando...</span>
		</div>

		<div id="main">
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
						<div class="account-wall">
							<section class="align-lg-center">
								<div class="site-logo"></div>
								<h1 class="login-title"><span>Recuperar</span> Senha<small> Sistema de Informação territorial Urbano</small></h1>
							</section>
							<form id="form-signin" class="form-signin">
								<section>
									<div class="input-group input-recuperar-senha">
										<div class="input-group-addon"><i class="fa fa-envelope"></i></div>
										<input  type="text" class="form-control" name="email" placeholder="E-mail">
									</div>
									<button class="btn btn-lg btn-theme-inverse btn-block" type="submit" id="sign-in">Enviar</button>
								</section>
							</form>
							<a href="#" class="footer-link">&copy; 2014 UNTEC/SEDHAB &trade;</a>
						</div>	
					</div>
				</div>
			</div>
		</div>
	</div>

<!--
////////////////////////////////////////////////////////////////////////
//////////     JAVASCRIPT  LIBRARY     ////////////////////////////////
//////////////////////////////////////////////////////////////////////
-->

<!-- Jquery Library -->
<?php require_once '../includes/core.php'; ?>
<script type="text/javascript">
	$(function() {
		   //Login animation to center 
		   function toCenter(){
		   	var mainH=$("#main").outerHeight();
		   	var accountH=$(".account-wall").outerHeight();
		   	var marginT=(mainH-accountH)/2;
		   	
		   	if(marginT>30){
		   		$(".account-wall").css("margin-top",marginT-15);
		   	}else{
		   		$(".account-wall").css("margin-top",30);
		   	}
		   }

		   toCenter();
		   
		   var toResize;
		   $(window).resize(function(e) {
		   	clearTimeout(toResize);
		   	toResize = setTimeout(toCenter(), 500);
		   });

		//Canvas Loading
		var throbber = new Throbber({  size: 32, padding: 17,  strokewidth: 2.8,  lines: 12, rotationspeed: 0, fps: 15 });
		throbber.appendTo(document.getElementById('canvas_loading'));
		throbber.start();

		//Set note alert
		setTimeout(function(){ 
			$.notific8('Olá, para recuperar sua senha digite seu <strong>E-mail</strong> e clique em <strong>Enviar</strong>.',{ sticky:true, horizontalEdge:"top", theme:"inverse" ,heading:"RECUPERAR SENHA"}) 
		}, 1000);

		$("#form-signin").submit(function(event){
			event.preventDefault();
			var main=$("#main");

			//scroll to top
			main.animate({scrollTop: 0}, 500);
			main.addClass("slideDown");		

			// send username and password to php check login
			$.ajax({
				url: "../data/home/checkemail.php", data: $(this).serialize(), type: "POST", dataType: 'json',
				success: function (e) {
					setTimeout(function () { main.removeClass("slideDown") }, ! e.status ? 500:3000);

					if (!e.status) {
						$.notific8(e.msg,{ life:5000,horizontalEdge:"bottom", theme:"danger" ,heading:" ERRO :); "});
						return false;
					}

					setTimeout(function () { $("#loading-top span").text("Usuário encontrado...") }, 500);
					setTimeout(function () { $("#loading-top span").text("Acesse seu e-mail, uma mensagem foi enviada...")  }, 1500);
				}, 
				error : function(){
					$.notific8('Ocorreu um erro no servidor, tente novamente mais tarde',{ life:30000,horizontalEdge:"bottom", theme:"danger" ,heading:" ERRO :); "});
				}
			});

		});
});
</script>
</body>
</html>