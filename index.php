<?php
require './bdconnect.php';

$msg = false;
if(isset($_FILES['arquivo'])){
    $arquivo = $_FILES['arquivo']['name'];
    $extensao = strtolower(pathinfo($arquivo, PATHINFO_EXTENSION));
    
    $novo_nome = md5(time()).".".$extensao;
    
    $diretorio = "upload/";
    
    move_uploaded_file($_FILES['arquivo']['tmp_name'], $diretorio . $novo_nome);
    
    $sql_code = "INSERT INTO arquivo(id, arquivo, data) VALUES('','$novo_nome', NOW())";
    
    if(mysqli_query($conn, $sql_code))
        $msg = "Arquivo enviado com sucesso!";
    else
        $msg = "Falha ao enviar arquivo!";
}
$sql_busca = "SELECT * FROM arquivo";
$mostrar = mysqli_query($conn, $sql_busca);
$qtd_arquivos = mysqli_num_rows($mostrar);
$msg_sem = ($qtd_arquivos<=0)?"NÃO HÁ ARQUIVOS NO SISTEMA!" : "";
?>
<html>
    <head lang="pt-br">
        <title>WEB VÍDEO AULAS : Upload de Imagens com PHP + MySQL</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <script src="js/bootstrap.min.js"></script>
    </head>
    <body>
        <h1>WEB VÍDEO AULAS</h1>
        <h3>Upload de Imagens com PHP e MySQL</h3>
        <br />
        <h6>Imagens:</h6>
        <p><?=$msg_sem?></p>
        
        <div class="col-md-12">
            <?php
            while($dados = mysqli_fetch_array($mostrar)){
               $arquivo = $dados['arquivo']; 
            ?>
            <img class="img-fluid col-md-2 img-thumbnail" src="upload/<?=$arquivo?>" />
            <?php }?>
        </div>
        
        <?php 
        if(isset($msg) && $msg != false){
            echo "<p>$msg</p>";
        }
        ?>
        <br />
        <form action="index.php" method="post" enctype="multipart/form-data">
            Selecione o arquivo: <input type="file" name="arquivo"/>
            <input type="submit" value="Enviar"/>
        </form>

    </body>
</html>