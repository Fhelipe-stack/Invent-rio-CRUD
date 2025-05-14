<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit();
}

$itens = file('inventario.txt', FILE_IGNORE_NEW_LINES);
$mensagem = "";

if (isset($_GET['deletar'])) {
    $id = $_GET['deletar'];
    unset($itens[$id]);
    file_put_contents('inventario.txt', implode(PHP_EOL, $itens));
    header('Location: editar_deletar.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['salvar'])) {
    $id = $_POST['id'];
    $novoTexto = "Item: {$_POST['nome']}, Quantidade: {$_POST['quantidade']}, Imagem: {$_POST['imagem']}";
    $itens[$id] = $novoTexto;
    file_put_contents('inventario.txt', implode(PHP_EOL, $itens));
    header('Location: editar_deletar.php');
    exit();
}

$modoEdicao = false;
$itemEdit = null;
if (isset($_GET['editar'])) {
    $modoEdicao = true;
    $id = $_GET['editar'];
    preg_match('/Item: (.*), Quantidade: (\d+), Imagem: (.*)/', $itens[$id], $matches);
    $itemEdit = [
        'id' => $id,
        'nome' => $matches[1],
        'quantidade' => $matches[2],
        'imagem' => $matches[3]
    ];
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar/Deletar - Inventário</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
</head>
<style>
    @font-face {
        font-family: Minecraft;
        src: url(fonte/Minecraft.ttf);
    }

    html, body {
        font-family: 'Minecraft', sans-serif;
        height: 100%;
        margin: 0;
        padding: 0;
    }

    body {
        background-image: url('https://wallpapercave.com/wp/wp2586787.jpg');
        background-size: cover; 
        background-position: center; 
        background-repeat: no-repeat; 
        height: 100vh;
    }

</style>
<body>
<div class="container mt-5">
    <h1 class="mb-4">Editar / Deletar Itens</h1>

    <?php if ($modoEdicao): ?>
        <div class="card p-3 mb-4">
            <h4>Editando: <?= htmlspecialchars($itemEdit['nome']) ?></h4>
            <form method="POST">
                <input type="hidden" name="id" value="<?= $itemEdit['id'] ?>">
                <div class="form-group">
                    <label>Nome do item:</label>
                    <input type="text" name="nome" class="form-control" value="<?= $itemEdit['nome'] ?>" required>
                </div>
                <div class="form-group">
                    <label>Quantidade:</label>
                    <input type="number" name="quantidade" class="form-control" value="<?= $itemEdit['quantidade'] ?>" required>
                </div>
                <div class="form-group">
                    <label>Imagem (URL):</label>
                    <input type="text" name="imagem" class="form-control" value="<?= $itemEdit['imagem'] ?>" required>
                </div>
                <button type="submit" name="salvar" class="btn btn-success">Salvar Alterações</button>
                <a href="editar_deletar.php" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    <?php endif; ?>

    <ul class="list-group">
        <?php foreach ($itens as $index => $item): ?>
            <?php
                preg_match('/Item: (.*), Quantidade: (\d+), Imagem: (.*)/', $item, $matches);
                if (count($matches) !== 4) continue;
                $nome = $matches[1];
                $qtd = $matches[2];
                $img = $matches[3];
            ?>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <div>
                    <img src="<?= $img ?>" style="width:40px; height:40px; margin-right:10px;">
                    <strong><?= htmlspecialchars($nome) ?></strong> (x<?= $qtd ?>)
                </div>
                <div>
                    <a href="?editar=<?= $index ?>" class="btn btn-warning btn-sm">Editar</a>
                    <a href="?deletar=<?= $index ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir este item?')">Deletar</a>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>

    <a href="inventario.php" class="btn btn-primary mt-4">Voltar para Inventário</a>
</div>
</body>
</html>
