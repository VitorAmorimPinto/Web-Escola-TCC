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
    $id= $_GET["id"];
    $mat= $_GET["mat"];
    
    
   $sql = "select * from tb_pessoa where cpf_pessoa = ".$id;
   $exe = mysqli_query($con, $sql);

   while($linha = mysqli_fetch_array($exe)){
    $nome_aluno = $linha["nome"];
    $cpf_professor = $linha["cpf_pessoa"];    
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
                       <h4>Dados do Professor</h4>
                    </div>
                </div>    
                    <form action="funcoes.php?acao=cadProfessorTurma" method="post">
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
                                    <input type="text" class="form-control" id="cpf" name="cpf_professor" value="<?php echo $cpf_professor;?>" readonly>
                                </div>
                            </div>                        
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <h4>Turmas do Professor</h4>
                            </div>
                        </div>
                        <div class="row">                            
                            <div class="col-md-4">
                            <?php                
                                        //busco os registros dos usuários
                                        $select = "SELECT u.nome_turma,p.tb_professor_matricula_professor FROM tb_turma as u
                                                    JOIN professor_turma as p
                                                    on u.id_turma = p.tb_turma_id_turma
                                                    WHERE tb_professor_matricula_professor = $mat";

                                        //executar o meu select, passo o status da conexão $con
                                        //e minha query de consulta
                                        $exe = mysqli_query($con, $select);
                                        
                                        //função que conta os registros do select realizado
                                        //e armazena na contaRegistros
                                        $contaRegistros = mysqli_num_rows($exe);
                                        
                                        //se não houver registros mostra a mensagem
                                        //senão, mostra os registros do banco.
                                        if($contaRegistros == 0){
                                            echo "<br><h4>Esse professor não possui turmas</h4>";
                                        }else{                    
                                    ?>
                                    <table class="table table-striped table-bordered text-center jumbotron">
                                            <tr>
                                                <th>Turmas</th>
                                                <th>Remover</th>                                                                                                        

                                            </tr>

                                            <?php                          
                                               
                                            $procurar = "SELECT u.nome_turma,p.tb_professor_matricula_professor,u.id_turma FROM tb_turma as u
                                            JOIN professor_turma as p
                                            on u.id_turma = p.tb_turma_id_turma
                                            WHERE tb_professor_matricula_professor =$mat";
                                                    
                                                                        
                                                $res = mysqli_query($con, $procurar) or die(mysqli_error($con));    

                                                    while($linha = mysqli_fetch_array($res)){
                                                
                                                        echo "<tr>
                                                            <td>".$linha['nome_turma']."</td>                                    
                                                            <td><a href='funcoes.php?acao=excluirDiscdoProf&id=" . $linha['id_turma'] . "&mat=".$linha['tb_professor_matricula_professor']."' onclick=\"return confirm('Tem certeza que deseja retirar o professor dessa turma?');\"><i class='fas fa-trash-alt text-info'></i></a></td>
                                                            
                                                            
                                                        </tr>
                                                        ";
                                                    }
                                            ?>
                                        </table>
                                    <?php
                                        }//fim do else que valida a quantidade de usuaários.
                                    ?>
                            </div>                     
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="turma">Nova turma</label>
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
                        <input type="submit" name="substituir" value="Adicionar Substituto" class="btn btn-primary">
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