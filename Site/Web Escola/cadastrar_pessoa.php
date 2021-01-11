

<?php 
    include "connection.php";
    session_start();
    $cpf = $_SESSION["chave"];
    $permi = $_SESSION["permissao"];
    if((!empty($_SESSION["chave"])) && 
    (isset($_SESSION["permissao"])) && 
    (@$_SESSION["permissao"]==10)){

    
    
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
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/Style.css">
    
    <title>Web Escola</title>
</head>
<body class="fundo">    
<nav class="navbar navbar-expand-sm navbar-dark bg-menu sticky-top">
<!-- Logo -->
    <a href="tela_inicial.php" class="navbar-brand titulo-logo">WEB ESCOLA</a>
<!--Menu Hamburguer-->
    <button class="navbar-toggler" data-toggle="collapse" 
    data-target="#navegacao">
        <span class="navbar-toggler-icon"></span>
    </button>

       <div class="collapse navbar-collapse" id="navegacao">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a href="" class="nav-link dropdown-toggle" data-toggle="dropdown"><img src="img/do-utilizador.png" class="mr-2"><?php echo $nome; ?></a>
                <div class="dropdown-menu">
                    <a href="perfil.php" class="dropdown-item">Perfil</a>
                    <!-- <form action="funcoes.php?acao=solicitarTroca" method="post">
                        <input type="submit" class="dropdown-item" Value="Trocar de Senha via E-mail">   
                    </form>    -->
   
                </div>
            </li>
            <li class="nav-item dropdown">
                <a href="" class="nav-link dropdown-toggle active" data-toggle="dropdown">Cadastro</a>
                <div class="dropdown-menu">                   
                    <a href="" class="dropdown-item active disabled">Cadastrar Pessoa</a>
                    <a href="cadastrar_turma.php" class="dropdown-item">Cadastrar Turma</a>
                    <a href="cadastrar_disciplina.php" class="dropdown-item">Cadastrar Disciplina</a>
                    <a href="formar_turma.php" class="dropdown-item">Formar Turma</a>
                    <a href="professores.php" class="dropdown-item">Professores</a>               
                    <a href="funcoes.php?acao=inicAno" class="dropdown-item" OnClick="return confirm('Deseja iniciar o ano letivo');">Ano Letivo</a>               
               

                </div>
            </li>
            <li class="nav-item">
                <a href="sair.php" class="nav-link">Sair</a>                
            </li>
        </ul>
    </div>
</nav>
<div class="container-fluid jumbotron-sub-menu">
    <div class="row">
         <div class="col-md-12">
           <div class="">
                <form method="post" action="funcoes.php?acao=cadPes">
                    <div class="row">
                        <div class="col-md-4">
                        <h4>Dados gerais</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="nome">Nome</label>
                                <input class="form-control" type="text" name="nome" id="nome" required>
                            </div>
                        </div>              
                        <div class="col-md-4">
                            <label for="email">Email</label>
                            <input class="form-control" type="email" name="email" id="email" required>
                        </div>
                        <div class="col-md-4">
                            <label for="data_nasc">Data de Nascimento</label>
                            <input class="form-control" type="date" name="data_nasc" id="data_nasc">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="ocupacao">Ocupação</label>
                                <select class="form-control" id="ocupacao" name= "tipo" >
                                    <option  value="0">Aluno</option>
                                    <option  value="5">Professor</option>
                                    <option  value="10">Administrador</option>                       
                                </select>
                             </div>              
                        </div>               
                        <div class="col-md-5">
                            <label for="telefone">telefone</label>
                            <input class="form-control" type="tel" name="telefone" id="telefone">    
                        </div>
                        <div class="col-md-4">
                            <label for="cpf">CPF</label>
                            <input class="form-control" type="text" name="cpf" id="cpf" required>    
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                        <h4>Endereço</h4>
                        </div>
                    </div>
                    <div class="row">                    
                        <div class="col-md-6">
                            <label for="rua">Rua</label>
                            <input class="form-control" type="text" name="rua" id="rua">
                        </div>
                        <div class="col-md-2">
                            <label for="numero">Número</label>
                            <input class="form-control" type="number" name="numero" id="numero">
                        </div>
                        <div class="col-md-4">
                            <label for="bairro">Bairro</label>
                            <input class="form-control" type="text" name="bairro" id="bairro">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="cep">CEP</label>
                            <input class="form-control" type="text" name="cep" id="cep">                    
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-4">
                            <h4>Professores</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label for="disciplina">Disciplina</label>
                                <select class="form-control" id="disciplina" name= "disciplina">
                                    <option  value="">Matéria do Professor</option>
                            <?php
                                $sql="select * from tb_disciplina";
                                $res= mysqli_query($con,$sql);
                                while ($linha = mysqli_fetch_assoc($res)){
                                echo '<option value="'.$linha['id_disciplina'].'">'.$linha['nome_disciplina'].'</option>';
                                }
                            ?>                        
                                </select>
                        </div>
                    </div>                    

                    <div class="mt-5">                	
        	            <a href="tela_inicial.php" class="btn btn-primary">Fechar</a>                                               
                        <input type="submit" name="cadastrar" value="Cadastrar" class="btn btn-primary">
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
<scrip  src="js/jquery-1.2.6.pack.js"></script>
<script src="js/jquery.maskedinput-1.1.4.pack.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$("#cpf").mask("999.999.999-99");
	});
    $(document).ready(function(){
		$("#telefone").mask("(99) 9999-99999");
	});
    $(document).ready(function(){
		$("#cep").mask("99999-999");
	});
</script>
</html>
<?php
}else{
    echo "<script>
              alert('Você precisa efetuar login para acessar essa área.')
              window.location='index.php'
          </script>
         ";
         session_destroy();
         
}

?>