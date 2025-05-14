<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit();
}


$servername = "localhost";
$database = "inventario";
$username = "root";
$password = "";

$conn = mysqli_connect($servername, $username, $password, $database);

    if (!$conn) {
        die ("Conection failed!: " . mysqli_connect_error());
    } else {
        echo "Conected!: <br>";
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $item = trim($_POST['item']);
        $quantidade = trim($_POST['quantidade']);
        $img = trim($_POST['img']);

    $sql = "INSERT INTO itens (id, nome_item, qtd_item, img_item) VALUES (NULL, '$item', '$quantidade', '$img')";

    if (mysqli_query($conn, $sql)) {
        echo "Novo registro armazenado!";
    } else {
        echo "Erro: <br> ". $sql . mysqli_error($conn);
        }
    mysqli_close($conn);

    

    if (!empty($item) && !empty($quantidade) && !empty($img)) {
        $inventario = file('inventario.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $itemExistente = false;
        $novoInventario = [];

        foreach ($inventario as $linha) {
            list($itemExistenteNome, $itemExistenteQtd, $itemExistenteImg) = explode(', ', $linha);
            $itemExistenteNome = str_replace('Item: ', '', $itemExistenteNome);
            $itemExistenteQtd = str_replace('Quantidade: ', '', $itemExistenteQtd);
            $itemExistenteImg = str_replace('Imagem: ', '', $itemExistenteImg);
        
            if ($itemExistenteNome == $item) {
                $itemExistenteQtd = (int)$itemExistenteQtd + (int)$quantidade;
                $itemExistenteImg = $img; 
                $itemExistente = true;
                $novoInventario[] = "Item: $itemExistenteNome, Quantidade: $itemExistenteQtd, Imagem: $itemExistenteImg";
            } else {
                $novoInventario[] = $linha;
            }
        }

        if (!$itemExistente) {
            $novoInventario[] = "Item: $item, Quantidade: $quantidade, Imagem: $img";
        }

        file_put_contents('inventario.txt', implode(PHP_EOL, $novoInventario) . PHP_EOL);

        header('Location: inventario.php');
        exit();
    }
}
?>
<?php
    

?>

    
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Item - Minecraft</title>
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

        .divprinc {
            background-color: rgba(0, 0, 0, 0.6); 
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%); 
            color: white;
            text-align: left;
            z-index: 3;
            padding: 20px;
            border-radius: 8px;
            width: 100%;
            max-width: 600px; 
        }

        body {
            background-image: url('https://i.ytimg.com/vi/DMuNsF578YE/maxresdefault.jpg');
            background-size: cover; 
            background-position: center; 
            background-repeat: no-repeat; 
            height: 100vh;
        }

        label {
            font-weight: bold;
        }

        input[type="text"], input[type="number"], input[type="url"] {
            width: 100%; 
            padding: 8px;
            margin-bottom: 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }

        button:hover {
            background-color: #45a049; 
        }
    </style>
</head>
<body>

<div class="divprinc">
    <form action="cadastroitem.php" method="POST">
        <div class="form-group">
            <label for="item">Nome do Item:</label>
            <input type="text" name="item" id="item" required><br>
        </div>
        <div class="form-group">
            <label for="quantidade">Quantidade:</label>
            <input type="number" name="quantidade" id="quantidade" required><br>
        </div>
        <div class="form-group">
            <label for="img">URL da Imagem do Item:</label>
            <input type="url" name="img" id="img" placeholder="Insira a URL da imagem" required><br>
        </div>
        <button type="submit" name="salvar">Salvar</button>
    </form>
</div>


<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>