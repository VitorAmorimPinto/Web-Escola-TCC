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
    $id= $_GET["id"];
    @$upd_turma= $_GET["updTurma"];
if ($upd_turma != 0) {
    $sql2 = " SELECT tt.nome_turma from tb_turma as tt
    join aluno_turma atu
    on tt.id_turma = atu.tb_turma_id_turma
    join tb_aluno as ta 
    on ta.matricula_aluno = atu.tb_aluno_matricula_aluno
    JOIN tb_pessoa as tp 
    on ta.tb_pessoa_cpf_pessoa = tp.cpf_pessoa
    WHERE tp.cpf_pessoa = ".$id;
    $exe2 = mysqli_query($con, $sql2);

   while($linha = mysqli_fetch_array($exe2)){
    $turma_atual = $linha["nome_turma"];
       
}
    }
   $sql = "select * from tb_pessoa where cpf_pessoa = ".$id;
   $exe = mysqli_query($con, $sql);

   while($linha = mysqli_fetch_array($exe)){
    $nome_aluno = $linha["nome"];
    $cpf_aluno = $linha["cpf_pessoa"];    
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
                    <a href="" class="dropdown-item active disabled">Formar Turma</a>
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
         <div class="col-md-10 mx-auto">
           <div class="">                
                <div class="row">
                    <div class="col-md-6">
                       <h4>Dados do Aluno</h4>
                    </div>
                </div>  
                    <?php if ($upd_turma !=0) {?>
                        <form action="funcoes.php?acao=updAlunoTurma" method="post">
                            <div class="row"> 
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="nome">Nome</label>
                                        <input type="text" class="form-control" id="nome" value="<?php echo $nome_aluno;?>" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="cpf">CPF</label>
                                        <input type="text" class="form-control" id="cpf" name="cpf_aluno" value="<?php echo $cpf_aluno;?>" readonly>
                                    </div>
                                </div>                        
                            </div>
                            <div class="row"> 
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="nome">Turma atual</label>
                                        <input type="text" class="form-control" id="nome" value="<?php echo $turma_atual;?>" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                    <label for="turma">Turma</label>
                                        <select class="form-control" id="turma" name= "novaTurma" required>
                                            <option  value="">Selecione a nova turma</option>
                                    <?php
                                        $sql="select * from tb_turma";
                                        $res= mysqli_query($con,$sql);
                                        while ($linha = mysqli_fetch_assoc($res)){
                                        echo '<option value="'.$linha['id_turma'].'">'.$linha['nome_turma'].'</option>';
                                        }
                                    ?>                        
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-2">                	
                                <input type="submit" value="Atualizar" class="btn btn-primary">
                            </div>
                        </form>
                    <?php }else{ ?>
                        <form action="funcoes.php?acao=cadAlunoTurma" method="post">
                            <div class="row"> 
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="nome">Nome</label>
                                        <input type="text" class="form-control" id="nome" value="<?php echo $nome_aluno;?>" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="cpf">CPF</label>
                                        <input type="text" class="form-control" id="cpf" name="cpf_aluno" value="<?php echo $cpf_aluno;?>" readonly>
                                    </div>
                                </div>                        
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                    <label for="turma">Turma</label>
                                        <select class="form-control" id="turma" name= "turma" required>
                                            <option  value="">Selecione a Turma</option>
                                    <?php
                                        $sql="select * from tb_turma";
                                        $res= mysqli_query($con,$sql);
                                        while ($linha = mysqli_fetch_assoc($res)){
                                        echo '<option value="'.$linha['id_turma'].'">'.$linha['nome_turma'].'</option>';
                                        }
                                    ?>                        
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-2">                	
                                <input type="submit" name="cadastrar" value="Cadastrar" class="btn btn-primary">
                            </div>
                        </form>
                    <?php } ?>
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