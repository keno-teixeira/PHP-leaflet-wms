<?php
require_once '../config/autoload.php';
require_once '../includes/head.php';
require_once '../includes/left-nav-menu.php';

$usuarios = new Usuarios();
$selectUsuarios = $usuarios->buscaPorId($_SESSION['id']);
?>

<div id="main">
	<div id="content">
		<div class="row">
			<div class="col-lg-12">
				<section class="panel">
					<header class="panel-heading sm" data-color="theme-inverse">
						<h2><strong>Meu</strong> Perfil</h2>
					</header>
					<div class="panel-body">
						<div class="table-responsive">
							<table class="table">
								<tbody align="center">
									<tr>
										<th class="coluna-perfil-top">Nome Completo</th>
										<td class="coluna-perfil-top"><?php echo $selectUsuarios[0]['nome']; ?></td>
									</tr>
									<tr>
										<th>Email</th>
										<td><?php echo $selectUsuarios[0]['email']; ?></td>
									</tr>
									<tr>
										<th>Orgão</th>
										<td><?php echo $selectUsuarios[0]['orgao']; ?></td>
									</tr>
									<tr>
										<th>Tipo</th>
										<td><?php echo $selectUsuarios[0]['tipo']; ?></td>
									</tr>
									<tr>
										<th>Grupo(s)</th>
										<td><?php foreach($selectUsuarios as $selectUsuario): echo $selectUsuario['grupo'] . '<br/>'; endforeach; ?></td>
									</tr>
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