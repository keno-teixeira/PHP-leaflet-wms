<?php
require_once '../config/autoload.php';
require_once '../includes/head.php';
require_once '../includes/left-nav-menu.php';

$grupo = new Grupos();
$selectGrupos = $grupo->buscaLayersBasemaps();
?>
<div id="main">
	<div id="content">
		<div class="row">
			<div class="col-lg-12">
				<section class="panel">
					<header class="panel-heading sm" data-color="theme-inverse">
						<h2><strong>Listar</strong> Grupo</h2>
					</header>
					<div class="panel-body">
						<div class="table-responsive">
							<table class="table">
								<thead>
									<tr>
										<th>Nome</th>
										<th>Basemaps</th>
										<th>Layers</th>
										<?php if($_SESSION['tipo_id'] == 1): ?>
											<th class="acao" width="30%">Ação</th>
										<?php endif; ?>
									</tr>
								</thead>
								<tbody align="center">
									<?php foreach($selectGrupos as $selectGrupo): ?>
										<tr>
											<td><?php echo $selectGrupo['grupo']; ?></td>
											<td><?php echo $selectGrupo['basemaps']; ?></td>
											<td><?php echo $selectGrupo['layers']; ?></td>
											<?php if($_SESSION['tipo_id'] == 1): ?>
												<td class="acao">
													<span class="tooltip-area">
														<a href="editar.php?id=<?php echo $selectGrupo['id']; ?>" class="btn btn-default btn-sm" title="Editar" data-original-title="Editar"><i class="fa fa-pencil"></i></a>
													</span>
												</td>
											<?php endif; ?>
										</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
						</div>
					</div>
				</section>
			</div>
		</div>
	</div>
</div>

<?php
require_once '../includes/footer.php';
require_once '../includes/core.php';
?>