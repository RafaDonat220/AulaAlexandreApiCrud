<!-- Modal de Confirmação de Exclusão -->
<div class="modal fade" id="janelaExcluir" tabindex="-1" aria-labelledby="tituloExcluir" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="tituloExcluir">
                    <i class="fas fa-exclamation-triangle me-2"></i>Confirmação de Exclusão
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body text-center p-4">
                <i class="fas fa-trash-alt fa-3x text-danger mb-3"></i>
                <p id="oQueExcluir" class="fs-5 mb-1">Deseja realmente excluir este registro?</p>
                <p id="quemExcluir" class="fw-bold fs-5 text-dark"></p>
                <small class="text-muted">Esta ação não poderá ser desfeita.</small>
            </div>
            <div class="modal-footer bg-light justify-content-center">
                <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal" id="botaoFechar">
                    <i class="fas fa-times me-1"></i> Cancelar
                </button>
                <button type="button" class="btn btn-danger px-4" id="botaoExcluir">
                    <i class="fas fa-trash me-1"></i> Sim, Excluir
                </button>
            </div>
        </div>
    </div>
</div>