<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h3 class="mb-0"><i class="fas fa-truck text-primary me-2"></i>Cadastro de Fornecedores</h3>
        <small class="text-muted">Gerencie os fornecedores cadastrados no sistema</small>
    </div>
    <button type="button" class="btn btn-success fw-bold" onclick="abreeditar(0)">
        <i class="fas fa-plus-circle me-1"></i> Novo Fornecedor
    </button>
</div>

<!-- TABELA DE FORNECEDORES -->
<div class="card shadow-sm border-0 mb-4">
    <div class="card-body">
        <table id="tabela_fornecedores" class="table table-hover table-striped table-bordered w-100">
            <thead class="table-dark">
                <tr>
                    <th>Código</th>
                    <th>Nome</th>
                    <th>Telefone</th>
                    <th>Endereço</th>
                    <th>Cidade</th>
                    <th class="text-center" style="width: 100px;">Ações</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

<!-- MODAL DE INCLUSÃO / EDIÇÃO -->
<div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="tituloModal" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="tituloModal">Fornecedor</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <form id="formFornecedor">
                <div class="modal-body p-4">
                    <input type="hidden" name="id_fornecedor" id="id_fornecedor">

                    <div class="row g-3">
                        <div class="col-12">
                            <label for="nome_fornecedor" class="form-label fw-bold">Nome do Fornecedor <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nome_fornecedor" id="nome_fornecedor" placeholder="Ex: Distribuidora Alvorada Ltda" required>
                        </div>

                        <div class="col-md-6">
                            <label for="telefone_fornecedor" class="form-label fw-bold">Telefone</label>
                            <input type="text" class="form-control" name="telefone_fornecedor" id="telefone_fornecedor" placeholder="(00) 0000-0000">
                        </div>

                        <div class="col-md-6">
                            <label for="id_cidade" class="form-label fw-bold">Cidade</label>
                            <select class="form-select" name="id_cidade" id="id_cidade">
                                <option value="">Carregando cidades...</option>
                            </select>
                        </div>

                        <div class="col-12">
                            <label for="endereco_fornecedor" class="form-label fw-bold">Endereço</label>
                            <input type="text" class="form-control" name="endereco_fornecedor" id="endereco_fornecedor" placeholder="Rua, número, bairro">
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary" id="btnSalvar">
                        <i class="fas fa-save me-1"></i> Gravar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
