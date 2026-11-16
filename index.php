
<?php

    // Modulo Padrão
    $modulo = $_GET['modulo'] ?? 'home';

    // caminho dos arquivos do modulo
    $pastaModulo = 'modulos/' . $modulo;
    $viewModulo = $pastaModulo . '/view.php';
    $jsModulo = $pastaModulo . '/script.js';

    // Se arquivo não existir
    if (!file_exists($viewModulo)) {
        $modulo = 'home';
        $pastaModulo = 'modulos/home';
        $viewModulo = $pastaModulo . '/view.php';
        $jsModulo = $pastaModulo . '/script.js';
    }

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- DataTables Bootstrap 5 CSS -->
    <link href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css" rel="stylesheet">

    <!-- FontAwesome CSS Local -->
    <link href="css/fontawesome.css" rel="stylesheet">
</head>

<body class="d-flex flex-column min-vh-100">

    <div class="container py-3 flex-grow-1">
        <?php include 'menu.php'; ?>

        <main>
            <?php include $viewModulo; ?>
        </main>
    </div>

    <?php
    include 'janelaexcluir.php'
     ?>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- Bootstrap 5 Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>

    <?php
        if (file_exists($jsModulo)) {
            echo '<script src="' . htmlspecialchars($jsModulo, ENT_QUOTES, 'UTF-8') . '"></script>';
        }
    ?>

    <script>

    function confirma(id, nome, tipo){
        idExluir = id;
        var rotulo = tipo ? tipo :'registri';
        $('#oQueExluir').text('confirmaaexlusao do ' + rotulo + ':');
        $('#aquemExluir').text(nome);
        $('#janelaExcluir').modal('show');

    }



    </script>

</body>
</html>
