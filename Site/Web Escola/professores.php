<?php
include "connection.php";
session_start();
if((!empty($_SESSION["chave"])) && 
(isset($_SESSION["permissao"])) && 
(@$_SESSION["permissao"]==10)){
    
$cpf = $_SESSION["chave"];
$permi = $_SESSION["permissao"];

    
   $sql = "select * from tb_pessoa where cpf_pessoa = ".$cpf;
   $exe = mysqli_query($con, $sql);

   while($linha = mysqli_fetch_array($exe)){
    $nome = $linha["nome"];
    $_SESSION["usuario"] = $linha["nome"];
    
}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/Style.css">
    <link rel="stylesheet" type="text/css" href="fontawesome/css/all.css">


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
                    <a href="cadastrar_pessoa.php" class="dropdown-item">Cadastrar Pessoa</a>
                    <a href="cadastrar_turma.php" class="dropdown-item">Cadastrar Turma</a>
                    <a href="cadastrar_disciplina.php" class="dropdown-item">Cadastrar Disciplina</a>
                    <a href="formar_turma.php" class="dropdown-item">Formar Turma</a>
                    <a href="professores.php" class="dropdown-item active disabled">Professores</a>               
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
         <div class="col-md-7 mx-auto">
           <div class="">                
                    <div class="row mb-2">
                        <div class="col-md-6">
                            <h4>Professores</h4>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-7">
                            <form method="post" action="">
                                <div class="input-group">
                                    <input type="search" name="buscar" placeholder="Buscar Professor por nome" class="form-control">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-info"><i class="fas fa-search"></i></button>
                                        </div>  
                                </div>                                     
                            </form>
                        </div>
                    </div>  
              
              <div class="row mt-4">
                <div class="col-md-12">
                <?php                
                    //busco os registros dos usuários
                    $select = "SELECT * FROM tb_usuario where permissao = 5";

                    //executar o meu select, passo o status da conexão $con
                    //e minha query de consulta
                    $exe = mysqli_query($con, $select);
                    
                    //função que conta os registros do select realizado
                    //e armazena na contaRegistros
                    $contaRegistros = mysqli_num_rows($exe);
                    
                    //se não houver registros mostra a mensagem
                    //senão, mostra os registros do banco.
                    if($contaRegistros == 0){
                        echo "<br><h4>Não há Professores cadastradas.</h4>";
                    }else{                    
                ?>
                  <table class="table table-striped table-bordered text-center jumbotron">
                        <tr>
                            <th>Professores</th>
                            <th>CPF</th>
                            <th>Turmas</th>                                                        
                        </tr>

                        <?php                          
                            @$nome = $_POST["buscar"];        

                           
                                if(empty($nome)){
                                    $procurar = "SELECT u.tb_pessoa_cpf_pessoa,p.nome FROM tb_usuario as u
                                    JOIN tb_pessoa as p
                                    on u.tb_pessoa_cpf_pessoa = p.cpf_pessoa
                                    WHERE permissao=5 limit 8";
                                }else{
                                    $procurar = "SELECT u.tb_pessoa_cpf_pessoa,p.nome FROM tb_usuario as u
                                    JOIN tb_pessoa as p
                                    on u.tb_pessoa_cpf_pessoa = p.cpf_pessoa
                                    WHERE permissao=5 AND nome LIKE '%".$nome."%' limit 8";
                                }
                                                    
                            $res = mysqli_query($con, $procurar) or die(mysqli_error($con));    

                                while($linha = mysqli_fetch_array($res)){
                                    $cpf=$linha['tb_pessoa_cpf_pessoa'];
                                    $parte1 = substr($cpf,0,3);
                                    $parte2 = substr($cpf,3,3);
                                    $parte3 = substr($cpf,6,3);
                                    $parte4 = substr($cpf,9,2);
                                    $cpftudo=$parte1.'.'.$parte2.'.'.$parte3.'-'.$parte4;
                                    echo "<tr>
                                        <td>".$linha['nome']."</td>
                                        <td>".$cpftudo."</td>
                                        <td><a href='funcoes.php?acao=pegarMat&id=".$linha['tb_pessoa_cpf_pessoa']."'><i class='fas fa-eye text-info'></i></a></td>
                                        
                                    </tr>
                                    ";
                                }
                        ?>
                    </table>
                <?php
                    }//fim do else que valida a quantidade de usuaários.
                ?>
                </div>
              </div>  
            </div>
        </div>
    </div>    
</div>
    
</body>
<script src="js/jquery-3.3.1.slim.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
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