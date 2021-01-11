<?php
    include "connection.php";
    session_start();   
    $cpf = $_SESSION["chave"];
    $permi = $_SESSION["permissao"];    
    // Verificação
    $verif = $_GET["creep"];
    $data = date("d/m/Y");
    $minuto = date('H');
    $tudo = $cpf.$data.$minuto;   
    $verif_1 = md5($tudo);    
    if($verif != $verif_1){
        session_destroy();
        header("Location:index.php");                
    }else if (!isset($_SESSION["chave"])){
    header("Location:index.php");       
    }  
    
   $sql = "select * from tb_pessoa where cpf_pessoa = ".$cpf;
   $exe = mysqli_query($con, $sql);

   while($linha = mysqli_fetch_array($exe)){
    $nome = $linha["nome"];
    $_SESSION["usuario"] = $linha["nome"];

    
}

?>
<!DOCTYPE html>
<html>
<head>

	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/Style.css">    
    <title>Web Escola</title>	
</head>
<body class="fundo">	
	<nav class="navbar navbar-expand-sm navbar-dark bg-dark barra">
	<!-- Logo -->
		<a href="" class="navbar-brand">Web Escola</a>
	<!--Menu Hamburguer-->
		<button class="navbar-toggler" data-toggle="collapse" 
        data-target="#navegacao">
            <span class="navbar-toggler-icon"></span>
        </button>

       	<div class="collapse navbar-collapse" id="navegacao">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a href="" class="nav-link dropdown-toggle disabled" data-toggle="dropdown"><img src="img/do-utilizador.png" class="mr-2"><?php echo $nome; ?></a>
                    <div class="dropdown-menu">
                        <a href="perfil.php" class="dropdown-item">Perfil</a>
                        <a href="" class="dropdown-item disabled">Alterar Dados de Usuário</a>
					</div>
                </li>
                <?php
                    if($permi == 0 ){
                ?>
                <li class="nav-item dropdown">
                    <a href="boletim.php" class="nav-link disabled">Boletim</a>
                    
                </li>
                <?php }else if($permi == 5){?>
                    <li class="nav-item dropdown">
                    <a href="" class="nav-link disabled">Lançar Notas</a>                    
                </li>
                <?php }else if($permi == 10){ ?>
                <li class="nav-item dropdown">
                    <a href="" class="nav-link dropdown-toggle disabled" data-toggle="dropdown">Cadastro</a>
                    <div class="dropdown-menu">
                    	<a href="cadastrar_pessoa.php" class="dropdown-item">Cadastrar Pessoa</a>                    	
                        <a href="" class="dropdown-item">Cadastrar Disciplina</a>
                    	<a href="" class="dropdown-item">Cadastrar Turma</a>
                                       
                    </div>
                </li>
                <?php } ?>                
                <li>
                <a href="sair.php" class="nav-link">Fechar</a>             
                </li>
            </ul>
        </div>
	</nav>

	<div class="container">
		<div class="row">
			<div class="col-md-6 mx-auto">
				<div class="jumbotron">
                    <form action="funcoes.php?acao=atuSenha"  method="post">	
                        <div class="row">
                            <div class="col-md-6">
                                <h2>Alterar Senha</h2>  
                            </div>	                  		
                        </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nova_senha">Nova Senha</label>
                                        <input class="form-control" type="password" name="nova_senha"  id="senha" required>                   
                                    </div>	
                                </div>
                            </div>
                        <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="conf_senha">Confirmar Nova Senha</label>
                                        <input class="form-control" type="password" name="conf_senha"  id="conf_senha" required>                   
                                    </div>	
                                </div>
                            </div>                        
                            <div class="mt-3">                	
                                <input type="submit" name="salvar" value="salvar" class="btn btn-primary">
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