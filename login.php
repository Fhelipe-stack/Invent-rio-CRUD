<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
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

        .container {
            position: relative;
        }

        .divlogin {
            background-color: rgba(0, 0, 0, 0.6); 
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%); 
            color: white;
            text-align: center;
            z-index: 2;
            padding: 20px;
            border-radius: 8px;
            width: 100%;
            max-width: 400px; 
        }

        video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover; 
            z-index: 1; 
        }

    </style>
</head>
<body>

    <div class="container"></div>
    <video autoplay muted loop>
        <source src="fonte/nature-in-minecraft.1920x1080.mp4" type="video/mp4">
    </video>

    <form action="login.php" method="POST">
    <div class="divlogin">
            <img src="https://www.pngall.com/wp-content/uploads/2016/03/Minecraft-Logo-PNG.png" style="height: 100px; width: 300px;">
            <div class="form-group">
                <label for="">Usuário</label>
                <input type="text" class="form-control" name="usuario" id="" aria-describedby="" placeholder="Seu user">
                <small id="" class="form-text text-muted"></small>
            </div>
            
            <div class="form-group">
                <label for="exampleInputPassword1">Senha</label>
                <input type="password" class="form-control" name="senha" id="exampleInputPassword1" placeholder="Senha">
            </div>
            
            <?php
            session_start();
            if ($_SERVER ['REQUEST_METHOD'] == 'POST'){
                define("USUARIO", "admin");
                define("SENHA", "123");
            

                $usuario = $_POST['usuario'];
                $senha = $_POST['senha'];

                
                    if ($usuario == USUARIO && $senha == SENHA) {
                        $_SESSION['usuario'] = $usuario;  
                        echo 'Bem sucedido!';
                        header("Location: inventario.php");
                        exit;  

                    } else {
                        echo '<p style = "color:red">Usuário ou senha inválidos!<br></p>'; 
                    }
                }
            ?>
            <button type="submit" class="btn btn-primary">Enviar</button>

        </div>
    </form>
    
    
        

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>
