<?php
require_once '../config/autoload.php';
require_once '../includes/head.php';
require_once '../includes/left-nav-menu.php';

$usuarios = new Usuarios();
$selectUsuarios = $usuarios->buscaConcatGrupo();
?>
<div id="main">
	<div id="content">
		<div class="row">
			<div class="col-lg-12">
				<section class="panel">
					<header class="panel-heading sm" data-color="theme-inverse">
						<h2><strong>Listar</strong> Usuário</h2>
					</header>
					<div class="panel-body">
						<div class="table-responsive">
							<table class="table">
								<thead>
									<tr>
										<th>Nome</th>
										<th>E-mail</th>
										<th>Orgão</th>
										<th>Tipo</th>
										<th>Grupo</th>
										<th>Ativo</th>
										<?php if($_SESSION['tipo_id'] == 1 || $_SESSION['tipo_id'] == 2): ?>
											<th class="acao" width="30%">Ação</th>
										<?php endif; ?>
									</tr>
								</thead>
								<tbody align="center">
									<?php foreach($selectUsuarios as $selectUsuario): ?>
										<tr>
											<td><?php echo $selectUsuario['nome']; ?></td>
											<td><?php echo $selectUsuario['email']; ?></td>
											<td><?php echo $selectUsuario['orgao']; ?></td>
											<td><?php echo $selectUsuario['tipo']; ?></td>
											<td><?php echo $selectUsuario['grupo']; ?></td>
											<td><?php echo $selectUsuario['ativo']; ?></td>
											<?php if($_SESSION['tipo_id'] == 1 || $_SESSION['tipo_id'] == 2): ?>
												<td class="acao">
													<span class="tooltip-area">
														<a href="editar.php?id=<?php echo $selectUsuario['usuario_id']; ?>" class="btn btn-default btn-sm btn-editar" title="Editar" data-original-title="Editar"><i class="fa fa-pencil"></i></a>
														<a href="excluir.php?id=<?php echo $selectUsuario['usuario_id']; ?>" class="btn btn-default btn-sm btn-excluir" title="Excluir" data-original-title="Excluir"><i class="fa fa-trash-o"></i></a>
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