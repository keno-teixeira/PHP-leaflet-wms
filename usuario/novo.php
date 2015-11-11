<?php
require_once '../config/autoload.php';
require_once '../includes/head.php';
require_once '../includes/left-nav-menu.php';

$tpUsuario = new TipoUsuario();
$selectTpUsuarios = $tpUsuario->busca();

if($_SESSION['tipo_id'] == 1):
	$grupos = new Grupos();
$selectGrupos = $grupos->buscaLayersBasemaps();
else:
	$usuarios = new Usuarios();
$selectGrupos = $usuarios->buscaPorId($_SESSION['id']);
endif;
?>

<div id="main">
	<div id="content">
		<div class="row">
			<div class="col-lg-12">
				<section class="panel">
					<header class="panel-heading sm" data-color="theme-inverse">
						<h2><strong>Criar</strong> Usuário</h2>
					</header>
					<div class="panel-body">

						<?php if($_SESSION['tipo_id'] == 1 || $_SESSION['tipo_id'] == 2): ?>
							<div id="msg-error" class="alert bg-danger">
								<strong></strong>
							</div>
							<form class="form-horizontal" data-collabel="3" data-alignlabel="left">
								<div class="form-group">
									<label class="control-label col-md-3" style="text-align: left;">Nome Completo</label>
									<div class="col-md-9">
										<input type="text" class="form-control" name="nome" id="nome" placeholder="Nome">
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-3" style="text-align: left;">E-mail</label>
									<div class="col-md-9">
										<input type="text" class="form-control" name="email" id="email" placeholder="E-mail">
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-3" style="text-align: left;">Orgão</label>
									<div class="col-md-9">
										<?php if($_SESSION['tipo_id'] == 1): ?>
											<input type="text" class="form-control" name="orgao" id="orgao" placeholder="Orgão">
										<?php else: ?>
											<?php echo $_SESSION['orgao']; ?>
										<?php endif; ?>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-3" style="text-align: left;">Login</label>
									<div class="col-md-9">
										<input type="text" class="form-control" name="login" id="login" placeholder="Login">
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-3" style="text-align: left;">Senha</label>
									<div class="col-md-9">
										<input type="password" class="form-control" name="senha" id="senha" placeholder="Senha">
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-3" style="text-align: left;">Repita a Senha</label>
									<div class="col-md-9">
										<input type="password" class="form-control" name="senha-repetida" id="senha-repetida" placeholder="Repita a senha">
									</div>
								</div>
								
								<div class="form-group">
									<label class="control-label col-md-3" style="text-align: left;">Tipo</label>
									<div class="col-md-9">
										<?php if($_SESSION['tipo_id'] == 1): ?>
											<select class="form-control"  name="tipo" id="tipo">
												<?php foreach($selectTpUsuarios as $selectTpUsuario): ?>
													<option value="<?php echo $selectTpUsuario['id']; ?>"><?php echo $selectTpUsuario['nome']; ?></option>
												<?php endforeach; ?>
											</select>
										<?php else: ?>
												Usuário
										<?php endif; ?>
									</div>
								</div>
								
								<div class="form-group">
									<label class="control-label col-md-3" style="text-align: left;">Grupo</label>
									<div class="col-md-9">
										<?php foreach($selectGrupos as $selectGrupo): ?>
											<div class="col-md-4">
												<label class="checkbox-inline"><input type="checkbox" id="grupo-id-<?php echo $selectGrupo['grupos_id']; ?>" name="grupo-<?php echo $selectGrupo['grupos_id']; ?>" value="<?php echo $selectGrupo['grupos_id']; ?>"><?php echo $selectGrupo['grupo']; ?></label>
											</div>
										<?php endforeach; ?>
									</div>
								</div>
								<div class="form-group offset">
									<div class="col-md-offset-3 col-md-9">
										<button type="submit" id="enviar" class="btn btn-theme">Salvar</button>
										<button type="reset" id="limpar" class="btn">Limpar</button>
									</div>
								</div>
							</form>
						<?php else: ?>
							<p>Permissão negada.</p>
						<?php endif; ?>

					</div>
				</section>
			</div>
		</div>
	</div>
</div>

<?php
require_once '../includes/modal-info.php';
require_once '../includes/footer.php';
require_once '../includes/core.php';
?>
<script type="text/javascript">
	$('#enviar').click(function(evento) {
		evento.preventDefault();
		$('form').enviaFormulario('../data/usuario/inserir.php');
	});

	$('#modal-msg').on('hidden.bs.modal', function() {
		location.href = 'index.php';
	});
</script>