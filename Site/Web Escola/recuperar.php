
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta charset="utf-8">
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="css/Style.css">
<title>Web Escola</title>
</head>
<body class="fundo">
<nav class="navbar navbar-expand-sm navbar-dark bg-menu">
	<!-- Logo -->
		<a href="index.php" class="navbar-brand titulo-logo">WEB ESCOLA</a>
	<!--Menu Hamburguer-->
</nav>            
    <div class="container-fluid jumbotron-tela-inicial">
        <div class="row">
            <div class="col-md-6 mx-auto">
                <div class="">
                    <form action="funcoes.php?acao=esqueciSenha" method="post">
                        <div class="row">
                            <div class="col-md-12">
                                <h4>Recuperar Senha</h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="login">Login</label>
                                    <input type="text" class="form-control" name="login" id="login" required>                                    
                                </div>                                        
                            </div>
                        </div>    
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="login">E-mail</label>
                                    <input type="email" class="form-control" name="email" id="email" required>
                                </div>    
                            </div>
                        </div>
                        <div>
                            <input type="submit" value="Enviar" class="btn btn-primary">
                        </div>                        
                   </form>
                </div>                
            </div>    
        </div>
    </div>
    
</body>
<script src="js/jquery-3.3.1.slim.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</html>