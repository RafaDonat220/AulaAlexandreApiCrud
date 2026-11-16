let tabelaFornecedores = null;
let idExcluir = null;

$(document).ready(function() {
    // 1. Inicialização do DataTables
    tabelaFornecedores = $('#tabela_fornecedores').DataTable({
        destroy: true,
        processing: true,
        serverSide: true,
        pageLength: 10,
        ajax: {
            url: 'api/fornecedores.php?op=list',
            type: 'POST',
            dataSrc: 'data',
            error: function(xhr) {
                console.error('Erro ao carregar dados:', xhr.responseText);
            }
        },
        columns: [
            { data: 'id_fornecedor', visible: false },
            { data: 'nome_fornecedor' },
            { data: 'telefone_fornecedor', defaultContent: '<span class="text-muted">-</span>' },
            { data: 'endereco_fornecedor', defaultContent: '<span class="text-muted">-</span>' },
            { data: 'nome_cidade', defaultContent: '<span class="text-muted">-</span>' },
            {
                data: null,
                orderable: false,
                searchable: false,
                className: "text-center",
                render: function(data, type, row) {
                    return `
                        <button type="button" class="btn btn-sm btn-outline-primary me-1" title="Editar" onclick="abreeditar(${row.id_fornecedor})">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-danger" title="Excluir" onclick="confirma(${row.id_fornecedor}, '${row.nome_fornecedor}')">
                            <i class="far fa-trash-alt"></i>
                        </button>
                    `;
                }
            }
        ],
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.8/i18n/pt-BR.json'
        }
    });

    // Duplo clique na linha para editar
    $('#tabela_fornecedores tbody').on('dblclick', 'tr', function() {
        const dados = tabelaFornecedores.row(this).data();
        if (dados && dados.id_fornecedor) {
            abreeditar(dados.id_fornecedor);
        }
    });

    // 2. Gravação do Formulário (POST ou PUT)
    $('#formFornecedor').on('submit', function(e) {
        e.preventDefault();

        const id = $('#id_fornecedor').val();
        const url = id ? `api/fornecedores.php?id=${id}` : 'api/fornecedores.php';
        const method = id ? 'PUT' : 'POST';

        const btnSalvar = $('#btnSalvar');
        const textoOriginal = btnSalvar.html();
        btnSalvar.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i> Gravando...');

        $.ajax({
            url: url,
            method: method,
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                $('#modalEditar').modal('hide');
                tabelaFornecedores.ajax.reload(null, false);
            },
            error: function(xhr) {
                const erro = xhr.responseJSON ? xhr.responseJSON.error : xhr.responseText;
                alert('Erro ao gravar: ' + erro);
            },
            complete: function() {
                btnSalvar.prop('disabled', false).html(textoOriginal);
            }
        });
    });

    // 3. Ação do botão Excluir do modal de confirmação
    $('#botaoExcluir').off('click').on('click', function() {
        if (!idExcluir) return;

        const btn = $(this);
        const textoOriginal = btn.html();
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i> Excluindo...');

        $.ajax({
            url: `api/fornecedores.php?id=${idExcluir}`,
            method: 'DELETE',
            dataType: 'json',
            success: function(response) {
                $('#janelaExcluir').modal('hide');
                tabelaFornecedores.ajax.reload(null, false);
                idExcluir = null;
            },
            error: function(xhr) {
                const erro = xhr.responseJSON ? xhr.responseJSON.error : xhr.responseText;
                alert('Erro ao excluir: ' + erro);
            },
            complete: function() {
                btn.prop('disabled', false).html(textoOriginal);
            }
        });
    });
});


// Abrir modal de inclusão ou edição
function abreeditar(idEditar) {
    $('#formFornecedor')[0].reset();
    $('#id_fornecedor').val('');

    if (idEditar == 0) {
        $('#tituloModal').html('<i class="fas fa-plus-circle me-2"></i>Inclusão de Fornecedor');
        carregarCombo('id_cidade', 'cidades', 'id_cidade', 'nome_cidade', null);
        $('#modalEditar').modal('show');
        setTimeout(() => $('#nome_fornecedor').focus(), 400);
    } else {
        $('#tituloModal').html('<i class="fas fa-edit me-2"></i>Alteração de Fornecedor');
        $.getJSON(`api/fornecedores.php?id=${idEditar}`)
            .done(function(data) {
                $('#id_fornecedor').val(data.id);
                $('#nome_fornecedor').val(data.nome);
                $('#telefone_fornecedor').val(data.telefone);
                $('#endereco_fornecedor').val(data.endereco);

                carregarCombo('id_cidade', 'cidades', 'id_cidade', 'nome_cidade', data.id_cidade);

                $('#modalEditar').modal('show');
                setTimeout(() => $('#nome_fornecedor').focus(), 400);
            })
            .fail(function(xhr) {
                alert('Erro ao buscar dados do fornecedor: ' + (xhr.responseJSON?.error || xhr.responseText));
            });
    }
}


