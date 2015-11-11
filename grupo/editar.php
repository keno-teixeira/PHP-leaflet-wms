<?php
require_once '../config/autoload.php';
require_once '../includes/head.php';
require_once '../includes/left-nav-menu.php';
require_once '../layers/reload.php';
?>

<div id="main">
	<div id="content">
		<div class="row">
			<div class="col-lg-12">
				<section class="panel">
					<header class="panel-heading sm" data-color="theme-inverse">
						<h2><strong>Editar</strong> Grupo</h2>
					</header>
					<div class="panel-body">
						<?php 
						if(isset($_GET['id'])):
							$grupo = new Grupos();
							$selectGrupos = $grupo->buscaPorId($_GET['id']);

							$layers = new Layers();
							$selectLayers= $layers->busca();

							$basemaps = new Basemaps();
							$selectBasemaps = $basemaps->busca();
						?>
						<?php if(!empty($selectGrupos)): ?>
							<?php if($_SESSION['tipo_id'] == 1): ?>
								<div id="msg-error" class="alert bg-danger">
									<strong></strong>
								</div>

								<form class="form-horizontal" data-collabel="3" data-alignlabel="left">
									<input type="hidden" class="form-control" id="id" name="id" value="<?php echo $selectGrupos[0]['id']; ?>">
									<div class="form-group">
										<label class="control-label col-md-3" style="text-align: left;">Nome</label>
										<div class="col-md-9">
											<input type="text" class="form-control" id="nome" name="nome" placeholder="Nome" value="<?php echo $selectGrupos[0]['nome']; ?>">
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-md-3" style="text-align: left;">Base maps</label>
										<div class="col-md-9">
											<?php foreach($selectBasemaps as $selectBasemap): ?>
												<div class="col-md-4">
													<label class="checkbox-inline"><input <?php foreach($selectGrupos as $selectGrupo): if($selectGrupo['basemap_id'] ===  $selectBasemap['id']): echo 'checked'; break; else: echo ''; endif; endforeach; ?> type="checkbox" id="basemap-id-<?php echo $selectBasemap['id']; ?>" name="basemap-<?php echo $selectBasemap['id']; ?>" value="<?php echo $selectBasemap['id']; ?>"><?php echo $selectBasemap['nome']; ?></label>
												</div>
											<?php endforeach; ?>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-md-3" style="text-align: left;">Layers</label>
										<div class="col-md-9">
											<?php foreach($selectLayers as $selectLayer): ?>
												<div class="col-md-4">
													<label class="checkbox-inline"><input <?php foreach($selectGrupos as $selectGrupo): if($selectGrupo['layer_id'] ===  $selectLayer['id']): echo 'checked'; break; else: echo ''; endif; endforeach; ?> type="checkbox" id="layer-id-<?php echo $selectLayer['id']; ?>" name="layer-<?php echo $selectLayer['id']; ?>" value="<?php echo $selectLayer['id']; ?>"><?php echo $selectLayer['nome']; ?></label>
												</div>
											<?php endforeach; ?>
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
							<p>Grupo não encontrado.</p>
						<?php endif; ?>
					<?php else: ?>
						<p>Grupo não selecionado.</p>
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
		$('form').enviaFormulario('../data/grupo/editar.php');
	});

	$('#modal-msg').on('hidden.bs.modal', function() {
		location.href = 'index.php';
	});
</script>