<?php
$moduloAtual = $_GET['modulo'] ?? 'home';
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4 rounded shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="index.php">
            <i class="fas fa-layer-group text-primary me-2"></i>CRUD API
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuPrincipal" aria-controls="menuPrincipal" aria-expanded="false" aria-label="Alternar navegação">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="menuPrincipal">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link <?= ($moduloAtual === 'home') ? 'active' : '' ?>" href="index.php">
                        <i class="fas fa-home me-1"></i> Início
                    </a>
                </li>

                <!-- Cadastros -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle <?= (in_array($moduloAtual, ['clientes', 'fornecedores', 'produtos', 'vendedores'])) ? 'active' : '' ?>" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-folder me-1"></i> Cadastros
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item <?= ($moduloAtual === 'fornecedores') ? 'active' : '' ?>" href="index.php?modulo=fornecedores">
                                <i class="fas fa-truck me-2 text-muted"></i> Fornecedores
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item <?= ($moduloAtual === 'clientes') ? 'active' : '' ?>" href="index.php?modulo=clientes">
                                <i class="fas fa-users me-2 text-muted"></i> Clientes
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item <?= ($moduloAtual === 'produtos') ? 'active' : '' ?>" href="index.php?modulo=produtos">
                                <i class="fas fa-box-open me-2 text-muted"></i> Produtos
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item <?= ($moduloAtual === 'vendedores') ? 'active' : '' ?>" href="index.php?modulo=vendedores">
                                <i class="fas fa-user-tie me-2 text-muted"></i> Vendedores
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Lançamentos -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle <?= (in_array($moduloAtual, ['vendas'])) ? 'active' : '' ?>" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-shopping-cart me-1"></i> Lançamentos
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="index.php?modulo=vendas"><i class="fas fa-cash-register me-2 text-muted"></i> Vendas</a></li>
                    </ul>
                </li>

                <!-- Relatórios -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle <?= (in_array($moduloAtual, ['relatorios'])) ? 'active' : '' ?>" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-chart-bar me-1"></i> Relatórios
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#"><i class="fas fa-file-invoice me-2 text-muted"></i> Vendas por Período</a></li>
                    </ul>
                </li>
            </ul>

            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="btn btn-outline-danger btn-sm" href="javascript:void(0)" onclick="alert('Funcionalidade de LogOut a ser implementada na aula de autenticação/sessão.')">
                        <i class="fas fa-sign-out-alt me-1"></i> Sair
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>