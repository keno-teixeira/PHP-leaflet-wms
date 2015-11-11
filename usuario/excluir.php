<?php
require_once '../config/autoload.php';
require_once '../includes/head.php';
require_once '../includes/left-nav-menu.php';
?>

<div id="main">
	<div id="content">
		<div class="row">
			<div class="col-lg-12">
				<section class="panel">
					<header class="panel-heading sm" data-color="theme-inverse">
						<h2><strong>Excluir</strong> Usuário</h2>
					</header>
					<div class="panel-body">
						<?php 
						if(isset($_GET['id'])):
							$usuarios = new Usuarios();
							$selectUsuarios = $usuarios->buscaPorId($_GET['id']);
						?>
						<?php if(!empty($selectUsuarios)): ?>
							<?php if( ( ($_SESSION['tipo_id'] == 1) || ( ($_SESSION['tipo_id'] == 2) && ($selectUsuarios[0]['orgao'] == $_SESSION['orgao']) && ($selectUsuarios[0]['tipo_usuario_id'] != 1) ) ) && ($_SESSION['id'] != $selectUsuarios[0]['id']) ): ?>
								<div id="msg-error" class="alert bg-danger">
									<strong></strong>
								</div>
								<form class="form-horizontal" data-collabel="3" data-alignlabel="left">
									<input type="hidden" class="form-control" name="id" id="id" value="<?php echo $selectUsuarios[0]['id']; ?>">
									<div class="form-group">
										<label class="control-label col-md-3" style="text-align: left;">Nome Completo</label>
										<div class="col-md-9">
											<?php echo $selectUsuarios[0]['nome']; ?>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-md-3" style="text-align: left;">E-mail</label>
										<div class="col-md-9">
											<?php echo $selectUsuarios[0]['email']; ?>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-md-3" style="text-align: left;">Orgão</label>
										<div class="col-md-9">
											<?php echo $selectUsuarios[0]['orgao']; ?>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-md-3" style="text-align: left;">Tipo</label>
										<div class="col-md-9">
											<?php echo $selectUsuarios[0]['tipo']; ?>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-md-3" style="text-align: left;">Grupo</label>
										<?php foreach($selectUsuarios as $selectUsuario): ?>
											<div class="col-md-9">
												<?php echo $selectUsuario['grupo']; ?>
											</div>
										<?php endforeach; ?>
									</div>
									<div class="form-group offset">
										<div class="col-md-offset-3 col-md-9">
											<button type="submit" id="enviar" class="btn btn-theme">Excluir</button>
											<button class="btn" onclick="location.href='index.php'">Cancelar</button>
										</div>
									</div>
								</form>
							<?php else: ?>
								<p>Permissão negada.</p>
							<?php endif; ?>
						<?php else: ?>
							<p>Usuário não encontrado.</p>
						<?php endif; ?>
					<?php else: ?>
						<p>Usuário não selecionado.</p>
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
		$('form').enviaFormulario('../data/usuario/excluir.php');
	});

	$('#modal-msg').on('hidden.bs.modal', function() {
		location.href = 'index.php';
	});
</script>