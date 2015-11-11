		<?php require_once '../config/autoload.php'; ?>
		<nav id="menu">
			<ul>
				<li>
					<a href="<?php echo URL_ROOT; ?>home/index.php"><i class="active icon  fa fa-home"></i> Início</a>
				</li>
				<li>
					<span>
						<i class="icon  fa fa-map-marker"></i> Mapas
					</span>
					<ul>
						<li><a href="<?php echo URL_ROOT; ?>maps/index.php"><i class="icon fa fa-map-marker"></i> Tools </a></li>
						<li><a href="<?php echo URL_ROOT; ?>maps/drag.php"><i class="icon fa fa-map-marker"></i> Layers </a></li>
					</ul>
				</li>
				<li>
					<span>
						<i class="icon  fa fa-user"></i> Usuários
					</span>
					<ul>
						<li><a href="<?php echo URL_ROOT; ?>usuario/index.php"><i class="icon fa fa-list"></i> Listar </a></li>
						<?php if($_SESSION['tipo_id'] == 1 || $_SESSION['tipo_id'] == 2): ?>
							<li><a href="<?php echo URL_ROOT; ?>usuario/novo.php"><i class="icon fa fa-save"></i> Novo </a></li>
						<?php endif; ?>
					</ul>
				</li>
				<li>
					<span>
						<i class="icon  fa fa-users"></i> Grupo
					</span>
					<ul>
						<li><a href="<?php echo URL_ROOT; ?>grupo/index.php"><i class="icon fa fa-list"></i> Listar </a></li>
						<?php if($_SESSION['tipo_id'] == 1): ?>
							<li><a href="<?php echo URL_ROOT; ?>grupo/novo.php"><i class="icon fa fa-save"></i> Novo </a></li>
						<?php endif; ?>
					</ul>
				</li>
			</ul>
		</nav>