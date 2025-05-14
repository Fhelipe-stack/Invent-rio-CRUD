<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Inventário - Minecraft</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    
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
            background-image: url('https://i.ytimg.com/vi/DMuNsF578YE/maxresdefault.jpg');
            background-size: cover; 
            background-position: center; 
            background-repeat: no-repeat; 
            height: 100vh;
        }

        .container {
            position: relative;
            z-index: 2;
            padding: 20px;
        }

        .divlogin {
            background-color: rgba(0, 0, 0, 0.6); 
            color: white;
            text-align: center;
            z-index: 3;
            padding: 20px;
            border-radius: 8px;
            width: 100%;
            max-width: 600px; 
            margin: 20px auto;
            position: relative;
        }

        .inventory-item {
            display: flex;
            align-items: center;
            padding: 5px;
            background-color: white;
            border-radius: 5px;
            margin-bottom: 5px;
        }

        .inventory-item img {
            width: 40px;
            height: 40px;
            margin-right: 10px;
        }

        .quantity {
            margin-left: auto;
            font-weight: bold;
            color: black;
        }

        li {
            width: 50px;
            height: 50px;
            margin-right: 10px;
            display: flex;
            padding: 5px;
            border-radius: 5px;
            margin-bottom: 5px;
        }
         

        ul {
            list-style-type: none; 
            padding: 10px;
            display: flex;
            justify-content: space-between;
        }

        .edit{
            background-color: rgba(0, 0, 0, 0.6); 
            color: white;
            text-align: center;
            z-index: 3;
            padding: 20px;
            border-radius: 8px;
            max-width: 600px; 
            margin: 20px auto;
            position: relative;
        }
    </style>
</head>
<body>
<?php
    session_start();

    if (!isset($_SESSION['usuario'])) {
        header('Location: index.php');
        exit();
    }

    $itens = [];

    if (file_exists('inventario.txt')) {
        $file = fopen('inventario.txt', 'r');
        while (($line = fgets($file)) !== false) {
            $itens[] = trim($line);
        }
        fclose($file);
    } else {
        echo 'Nenhum item cadastrado ainda';
    }
?>

<div class="header">
    <div class="navbar navbar-expand-lg navbar-light bg-transparent">
        <div class="container-fluid">
            <img style="width: 300px; height: 100px" src="https://www.pngall.com/wp-content/uploads/2016/03/Minecraft-Logo-PNG.png" alt="">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link text-white" style="justify-content: center;" href="cadastroitem.php">Cadastrar Item</a>
                </li>
            </ul>
        </div>
    </div>
</div>

<div class="container">
    <div class="divlogin">
        <h1>Inventário</h1>
        <ul>
            <?php foreach ($itens as $item): ?>
                <?php
                    preg_match('/Item: (.*), Quantidade: (\d+), Imagem: (.*)/', $item, $matches);
                    if (count($matches) === 4):
                        $nomeItem = $matches[1];
                        $quantidade = $matches[2];
                        $imagem = $matches[3];
                ?>
                    <li class="list-group-item inventory-item">
                        <img src="<?php echo $imagem; ?>" alt="<?php echo $nomeItem; ?>">
                        <span class="quantity" style="color: white;">x<?php echo $quantidade; ?></span>
                    </li>
                    
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
<div class="edit">
        <a class="nav-link text-white" href="editar_deletar.php">Editar / Deletar</a>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>
