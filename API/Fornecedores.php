
<?php

header("Content-Type: application/json; charset=UTF-8");

require_once '../conecta.php';

$method = $_SERVER['REQUEST_METHOD'];

$id = $_GET['id'] ?? null;

if (($method === 'GET' && isset($_GET['op']) && $_GET['op'] === 'list') || ($method === 'POST' && isset($_GET['op']) && $_GET['op'] === 'list')) {
    try {
        $start = isset($_REQUEST['start']) ? (int)$_REQUEST['start'] : 0;
        $length = isset($_REQUEST['length']) ? (int)$_REQUEST['length'] : 10;
        $pesquisa = isset($_REQUEST['search']['value']) ? trim($_REQUEST['search']['value']) : '';
        $termo = '%' . $pesquisa . '%';

        $colunas = [
            0 => "f.id_fornecedor",
            1 => "f.nome_fornecedor",
            2 => "f.telefone_fornecedor",
            3 => "f.endereco_fornecedor",
            4 => "c.nome_cidade"
        ];

        $colunaIndex = isset($_REQUEST['order'][0]['column']) ? (int)$_REQUEST['order'][0]['column'] : 1;
        $orderColumn = $colunas[$colunaIndex] ?? 'f.nome_fornecedor';
        $orderDir = isset($_REQUEST['order'][0]['dir']) && strtolower($_REQUEST['order'][0]['dir']) === 'desc' ? 'DESC' : 'ASC';

        $totalGeral = (int)$con->query("SELECT COUNT(*) FROM fornecedores")->fetchColumn();

        $sql = "
            SELECT
                f.id_fornecedor,
                f.nome_fornecedor,
                f.telefone_fornecedor,
                f.endereco_fornecedor,
                f.id_cidade,
                c.nome_cidade
            FROM fornecedores f
            INNER JOIN cidades c ON f.id_cidade = c.id_cidade
            WHERE (
                f.nome_fornecedor LIKE ?
                OR f.telefone_fornecedor LIKE ?
                OR f.endereco_fornecedor LIKE ?
                OR c.nome_cidade LIKE ?
            )
            ORDER BY {$orderColumn} {$orderDir}
            LIMIT ? OFFSET ?
        ";

        $stmt = $con->prepare($sql);
        $stmt->bindValue(1, $termo, PDO::PARAM_STR);
        $stmt->bindValue(2, $termo, PDO::PARAM_STR);
        $stmt->bindValue(3, $termo, PDO::PARAM_STR);
        $stmt->bindValue(4, $termo, PDO::PARAM_STR);
        $stmt->bindValue(5, $length, PDO::PARAM_INT);
        $stmt->bindValue(6, $start, PDO::PARAM_INT);
        $stmt->execute();

        $registros = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $sqlcount = "
            SELECT COUNT(*)
            FROM fornecedores f
            INNER JOIN cidades c ON f.id_cidade = c.id_cidade
            WHERE (
                f.nome_fornecedor LIKE ?
                OR f.telefone_fornecedor LIKE ?
                OR f.endereco_fornecedor LIKE ?
                OR c.nome_cidade LIKE ?
            )
        ";

        $stmtCount = $con->prepare($sqlcount);
        $stmtCount->bindValue(1, $termo, PDO::PARAM_STR);
        $stmtCount->bindValue(2, $termo, PDO::PARAM_STR);
        $stmtCount->bindValue(3, $termo, PDO::PARAM_STR);
        $stmtCount->bindValue(4, $termo, PDO::PARAM_STR);
        $stmtCount->execute();

        $totalfiltrado = (int)$stmtCount->fetchColumn();

        echo json_encode([
            "draw"            => isset($_REQUEST['draw']) ? (int)$_REQUEST['draw'] : 1,
            "recordsTotal"    => $totalGeral,
            "recordsFiltered" => $totalfiltrado,
            "data"            => $registros
        ]);

    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode([
            "error" => "Erro ao listar fornecedores!",
            "details" => $e->getMessage()
        ]);
    }

    exit;
}

if ($method === 'DELETE' && $id) {
    try {
        $stmt = $con->prepare("DELETE FROM fornecedores WHERE id_fornecedor = ?");
        $stmt->execute([$id]);

        if ($stmt->rowCount() > 0) {
            http_response_code(200);
            echo json_encode([
                "success" => true,
                "message" => "Fornecedor excluído com sucesso!"
            ]);
        } else {
            http_response_code(404);
            echo json_encode([
                "error" => "Fornecedor não encontrado!"
            ]);
        }

    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode([
            "error" => "Não foi possível excluir o fornecedor",
            "details" => $e->getMessage()
        ]);
    }

    exit;
}

if ($method === 'GET' && $id) {
    try {
        $stmt = $con->prepare("
            SELECT * FROM fornecedores WHERE id_fornecedor = ?
        ");

        $stmt->execute([$id]);
        $fornecedor = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($fornecedor) {
            http_response_code(200);
            echo json_encode([
                "id"        => (int)$fornecedor['id_fornecedor'],
                "nome"      => $fornecedor['nome_fornecedor'],
                "telefone"  => $fornecedor['telefone_fornecedor'],
                "endereco"  => $fornecedor['endereco_fornecedor'],
                "id_cidade" => $fornecedor['id_cidade'] ? (int)$fornecedor['id_cidade'] : null
            ]);

        } else {
            http_response_code(404);
            echo json_encode(["error" => "Fornecedor não encontrado"]);
        }

    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode([
            "error" => "Erro no banco de dados!",
            "details" => $e->getMessage()
        ]);
    }

    exit;
}

if ($method === 'POST' && !$id) {
    try {
        $dados = json_decode(file_get_contents("php://input"), true);

        $nome = trim($dados['nome_fornecedor'] ?? '');
        $telefone = trim($dados['telefone_fornecedor'] ?? '');
        $endereco = trim($dados['endereco_fornecedor'] ?? '');
        $idCidade = !empty($dados['id_cidade']) ? (int)$dados['id_cidade'] : null;

        $stmt = $con->prepare("
            INSERT INTO fornecedores
            (nome_fornecedor, telefone_fornecedor, endereco_fornecedor, id_cidade)
            VALUES (?, ?, ?, ?)
        ");

        $stmt->execute([$nome, $telefone, $endereco, $idCidade]);

        http_response_code(201);
        echo json_encode([
            "success" => true,
            "message" => "Fornecedor cadastrado com sucesso!"
        ]);

    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode([
            "error" => "Erro ao cadastrar fornecedor!",
            "details" => $e->getMessage()
        ]);
    }

    exit;
}

if ($method === 'PUT' && $id) {
    $rawInput = file_get_contents("php://input");
    $dados = json_decode($rawInput, true);

    if (!is_array($dados)) {
        parse_str($rawInput, $dados);
    }

    $nome = trim($dados['nome_fornecedor'] ?? '');
    $telefone = trim($dados['telefone_fornecedor'] ?? '');
    $endereco = trim($dados['endereco_fornecedor'] ?? '');
    $idCidade = !empty($dados['id_cidade']) ? (int)$dados['id_cidade'] : null;

    try {
        $stmt = $con->prepare("
            UPDATE fornecedores SET
            nome_fornecedor = ?,
            telefone_fornecedor = ?,
            endereco_fornecedor = ?,
            id_cidade = ?
            WHERE id_fornecedor = ?
        ");

        $stmt->execute([$nome, $telefone, $endereco, $idCidade, $id]);

        http_response_code(200);
        echo json_encode([
            "success" => true,
            "message" => "Fornecedor atualizado com sucesso!"
        ]);

    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode([
            "error" => "Erro ao atualizar fornecedor!",
            "details" => $e->getMessage()
        ]);
    }

    exit;
}

?>
