<?php
require_once '../config/autoload.php';
require_once '../includes/head.php';
require_once '../includes/left-nav-menu.php';
require_once '../layers/reload.php';

$layers = new Layers();
$selectLayers= $layers->busca();

$basemaps = new Basemaps();
$selectBasemaps = $basemaps->busca();
?>
<div id="main">
	<div id="content">
		<div class="row">
			<div class="col-lg-12">
				<section class="panel">
					<header class="panel-heading sm" data-color="theme-inverse">
						<h2><strong>Criar</strong> Grupo</h2>
					</header>
					<div class="panel-body">

						<?php if($_SESSION['tipo_id'] == 1): ?>
							<div id="msg-error" class="alert bg-danger">
								<strong></strong>
							</div>

							<form method="post" class="form-horizontal" data-collabel="3" data-alignlabel="left">
								<div class="form-group">
									<label class="control-label col-md-3" style="text-align: left;">Nome</label>
									<div class="col-md-9">
										<input type="text" class="form-control" id="nome" name="nome" placeholder="Nome">
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-3" style="text-align: left;">Base maps</label>
									<div class="col-md-9">
										<?php foreach($selectBasemaps as $selectBasemap): ?>
											<div class="col-md-4">
												<label class="checkbox-inline"><input type="checkbox" id="basemap-id-<?php echo $selectBasemap['id']; ?>" name="basemap-<?php echo $selectBasemap['id']; ?>" value="<?php echo $selectBasemap['id']; ?>"><?php echo $selectBasemap['nome']; ?></label>
											</div>
										<?php endforeach; ?>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-3" style="text-align: left;">Layers</label>
									<div class="col-md-9">
										<?php foreach($selectLayers as $selectLayer): ?>
											<div class="col-md-4">
												<label class="checkbox-inline"><input type="checkbox" id="layer-id-<?php echo $selectLayer['id']; ?>" name="layer-<?php echo $selectLayer['id']; ?>" value="<?php echo $selectLayer['id']; ?>"><?php echo $selectLayer['nome']; ?></label>
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
		$('form').enviaFormulario('../data/grupo/inserir.php');
	});

	$('#modal-msg').on('hidden.bs.modal', function() {
		location.href = 'index.php';
	});
</script>