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
						<h2><strong>Editar</strong> Usuário</h2>
					</header>
					<div class="panel-body">
						<?php 
						if(isset($_GET['id'])):
							$usuarios = new Usuarios();
							$selectUsuarios = $usuarios->buscaPorId($_GET['id']);

							$tpUsuario = new TipoUsuario();
							$selectTpUsuarios = $tpUsuario->busca();

							if($_SESSION['tipo_id'] == 1):
								$grupos = new Grupos();
							$selectGrupos = $grupos->buscaLayersBasemaps();
							else:
								$selectGrupos = $usuarios->buscaPorId($_SESSION['id']);
							endif;
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
											<input type="text" class="form-control" name="nome" id="nome" placeholder="Nome" value="<?php echo $selectUsuarios[0]['nome']; ?>">
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-md-3" style="text-align: left;">E-mail</label>
										<div class="col-md-9">
											<input type="text" class="form-control" name="email" id="email" placeholder="E-mail" value="<?php echo $selectUsuarios[0]['email']; ?>">
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-md-3" style="text-align: left;">Orgão</label>
										<div class="col-md-9">
											<?php if($_SESSION['tipo_id'] == 1): ?>
												<input type="text" class="form-control" name="orgao" id="orgao" placeholder="Orgão" value="<?php echo $selectUsuarios[0]['orgao']; ?>">
											<?php else: ?>
												<?php echo $selectUsuarios[0]['orgao']; ?>
											<?php endif; ?>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-md-3" style="text-align: left;">Tipo</label>
										<div class="col-md-9">
											<?php if($_SESSION['tipo_id'] == 1): ?>
												<select class="form-control"  name="tipo" id="tipo">
													<?php foreach($selectTpUsuarios as $selectTpUsuario): ?>
														<option <?php echo $selectUsuarios[0]['tipo_usuario_id'] ===  $selectTpUsuario['id'] ? 'selected' : ''; ?> value="<?php echo $selectTpUsuario['id']; ?>"><?php echo $selectTpUsuario['nome']; ?></option>
													<?php endforeach; ?>
												</select>
											<?php else: ?>
												<?php echo $selectUsuarios[0]['tipo']; ?>
											<?php endif; ?>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-md-3" style="text-align: left;">Grupo</label>
										<div class="col-md-9">
											<?php foreach($selectGrupos as $selectGrupo): ?>
												<div class="col-md-4">
													<label class="checkbox-inline"><input <?php foreach($selectUsuarios as $selectUsuario): echo $selectUsuario['grupos_id'] ===  $selectGrupo['grupos_id'] ? 'checked' : ''; endforeach; ?> type="checkbox" id="grupo-id-<?php echo $selectGrupo['grupos_id']; ?>" name="grupo-<?php echo $selectGrupo['grupos_id']; ?>" value="<?php echo $selectGrupo['grupos_id']; ?>"><?php echo $selectGrupo['grupo']; ?></label>
												</div>
											<?php endforeach; ?>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-md-3" style="text-align: left;">Ativo</label>
										<div class="col-md-9">
											<div class="col-md-4">
												<label class="radio-inline"><input <?php echo $selectUsuarios[0]['ativo_num'] ===  '1' ? 'checked' : ''; ?> type="radio" id="ativo" name="ativo" value="1">Sim</label>
											</div>
											<div class="col-md-4">
												<label class="radio-inline"><input <?php echo $selectUsuarios[0]['ativo_num'] ===  '0' ? 'checked' : ''; ?> type="radio" id="ativo" name="ativo" value="0">Não</label>
											</div>
										</div>
									</div>
									<div class="form-group offset">
										<div class="col-md-offset-3 col-md-9">
											<button type="submit" id="enviar" class="btn btn-theme">Editar</button>
											<button type="reset" id="limpar" class="btn">Limpar</button>
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
		$('form').enviaFormulario('../data/usuario/editar.php');
	});

	$('#modal-msg').on('hidden.bs.modal', function() {
		location.hrsef = 'index.php';
	});
</script>