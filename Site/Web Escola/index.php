<?php
// date_default_timezone_set('America/Sao_Paulo');//Coloca Fuso certo.
// echo date("d/m/Y");
// $dia = date("d");
// echo "<br>";
// echo $dia;
// echo "<br>";

// echo date('H:i:s');

?>
<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <!-- Meta tags Obrigatórias -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/Style.css">
    <title>Web Escola</title>
  </head>
  <body class="fundo">
  <h1 class="text-center mt-5 jb-style1 text-dark display-3 titulo-logo">WEB ESCOLA</h1>    
    <section class="login jb-style">      
        <div class="container">
          <div class="row">
            <div class="col-md-12">
                    <div class="align-center">
                      <form action="funcoes.php?acao=logar" method="post">
                          <div class="form-group">
                            <input type="text" class="form-control" name="usuario" placeholder="Digite seu usuário">
                          </div>
                          <div class="form-group">
                            <input type="password" class="form-control" name="senha" placeholder="Digite sua Senha">
                          </div>
                          <div class="row">
                            <div class="col-md-4">
                              <input type="submit" name="" value="logar" class="btn btn-info">
                            </div>                            
                            <div class="col-md-8">                     
                               <!-- <a href="recuperar.php" class="text-light">Esqueceu sua senha?</a> -->
                            </div>
                          </div>
                       </form>                                
                    </div>
              </div>
            </div>       
         </div>
    </section>

    <!-- JavaScript (Opcional) -->
    <!-- jQuery primeiro, depois Popper.js, depois Bootstrap JS -->
<script src="js/jquery-3.3.1.slim.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
  </body>
</html>