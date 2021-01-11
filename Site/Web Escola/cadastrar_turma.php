<?php
include "connection.php";
session_start();
if((!empty($_SESSION["chave"])) && 
(isset($_SESSION["permissao"])) && 
(@$_SESSION["permissao"]==10)){
$cpf = $_SESSION["chave"];
$permi = $_SESSION["permissao"];
$sumir = 1;
    
   $sql = "select * from tb_pessoa where cpf_pessoa = ".$cpf;
   $exe = mysqli_query($con, $sql);

   while($linha = mysqli_fetch_array($exe)){
    $nome = $linha["nome"];
    $_SESSION["usuario"] = $linha["nome"];
    
}
    
@$id_turma = $_GET["idTurma"];
if (!empty($id_turma)) {
    $sql2 = "select * from tb_turma where id_turma = ".$id_turma;
    $exe2 = mysqli_query($con, $sql2);
 
    while($linha = mysqli_fetch_array($exe2)){
     $nome_turma= $linha['nome_turma'];
     $turno= $linha['turno'];
     $ano_aluno= $linha['ano'];
 }
 @$pt=substr($ano_aluno,0,1);
 @$pt2=substr($ano_aluno,1,3);
 $tudo_ano=$pt.'°'.$pt2;
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
                    <a href="" class="dropdown-item active disabled">Cadastrar Turma</a>
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
         <div class="col-md-7 mx-auto">
           <div class="">
                <form method="post" action="funcoes.php?acao=cadTurm">
                    <div class="row">
                        <div class="col-md-6">
                            <h4>Cadastrar Turma</h4>
                        </div>
                    </div>
                    <?php if ($id_turma == null){?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nome_turma">Nome da Turma</label>
                                <input type="text" name="nomeTurma" id="nome_turma" class="form-control" required>
                            </div>    
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                            <label for="turno">Turno</label>
                                <select class="form-control" id="turno" name="turno" required >
                                    <option  value="">Selecione o Turno</option>        
                                    <option  value="Matutino">Matutino</option>
                                    <option  value="Vespertino">Vespertino</option>
                                    <option  value="Noturno">Noturno</option>                       
                                </select>
                            </div>    
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="ano">Ano</label>
                                <select class="form-control" id="ano" name="ano" required >
                                    <option  value="">Selecione o Ano</option>
                                    <option  value="1ano">1°ano</option>
                                    <option  value="2ano">2°ano</option>
                                    <option  value="3ano">3°ano</option>                       
                                </select>
                            </div>    
                        </div>
                    </div>
                    <div class="mt-4 mb-3">    	                                                           
                        <input type="submit" name="cadastrar" value="Cadastrar" class="btn btn-primary">
                    </div>
                
                    <?php }else{?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nome_turma">Nome da Turma</label>
                                <input type="text" name="nomeTurma" id="nome_turma" class="form-control" value="<?php echo $nome_turma; ?>" required>
                            </div>    
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                            <label for="turno">Turno</label>
                                <select class="form-control" id="turno" name="turno" required >
                                    <?php if ($turno == 'Matutino') {?>
                                        <option  value="<?php echo $turno?>"><?php echo $turno?></option>        
                                        <option  value="Vespertino">Vespertino</option>
                                        <option  value="Noturno">Noturno</option>
                                    <?php }else if ($turno == 'Vespertino'){?>
                                        <option  value="<?php echo $turno?>"><?php echo $turno?></option>        
                                        <option  value="Matutino">Matutino</option>
                                        <option  value="Noturno">Noturno</option>
                                    <?php }else if ($turno == 'Noturno'){ ?>
                                        <option  value="<?php echo $turno?>"><?php echo $turno?></option>        
                                        <option  value="Matutino">Matutino</option>
                                        <option  value="Vespertino">Vespertino</option>
                                    <?php } ?>
                                </select>
                            </div>    
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="ano">Ano</label>
                                <select class="form-control" id="ano" name="ano" required >
                                    <?php if ($ano_aluno == '1ano') {?>
                                    <option  value="<?php echo $ano_aluno?>"><?php echo $tudo_ano?></option>
                                    <option  value="2ano">2°ano</option>
                                    <option  value="3ano">3°ano</option>
                                    <?php }else if ($ano_aluno == '2ano'){?>
                                    <option  value="<?php echo $ano_aluno?>"><?php echo $tudo_ano?></option>
                                    <option  value="1ano">1°ano</option>
                                    <option  value="3ano">3°ano</option>
                                    <?php }else if ($ano_aluno == '3ano'){?>
                                    <option  value="<?php echo $ano_aluno?>"><?php echo $tudo_ano?></option>
                                    <option  value="1ano">1°ano</option>
                                    <option  value="2ano">2°ano</option>
                                    <?php } ?>
                                </select>
                            </div>
                            <input type="hidden" name="id_turma" value="<?php echo $id_turma?>" >    
                        </div>
                    </div>
                    <div class="mt-4">    	                                                           
                        <input type="submit" name="cadastrar" value="Cadastrar" class="btn btn-primary">
                        <input type="submit" name="atualizar" value="atualizar" class="btn btn-primary">
                    </div>
            </form>
              <div class="row mt-4">
                <div class="col-md-12">
                    <?php }?>
                <?php
                    //incluindo a conexão com BD.
                    include ("connection.php");
                
                    //busco os registros dos usuários
                    $select = "SELECT * FROM tb_turma";
                
                    //executar o meu select, passo o status da conexão $con
                    //e minha query de consulta
                    $exe = mysqli_query($con, $select);
                    
                    //função que conta os registros do select realizado
                    //e armazena na contaRegistros
                    $contaRegistros = mysqli_num_rows($exe);
                    
                    //se não houver registros mostra a mensagem
                    //senão, mostra os registros do banco.
                    if($contaRegistros == 0){
                        echo "<br><h4>Não há turmas cadastradas.</h4>";
                    }else{                    
                ?>
                <div class="table-responsive">
                  <table class="table table-striped table-bordered text-center jumbotron">
                        <tr>
                            <th>Turma</th>
                            <th>Turno</th>
                            <th>Ano</th>
                            <th>Editar</th>                                                        
                            <th>Excluir</th>                                                        

                        </tr>

                        <?php                          
                            $sql="select * from tb_turma";
                            $res = mysqli_query($con, $sql);    

                                while($linha = mysqli_fetch_array($res)){
                                        $ano= $linha['ano'];
                                        $pt=substr($ano,0,1);
                                        $pt2=substr($ano,1,3);
                                        $tudo=$pt.'°'.$pt2;
                                    echo "<tr>
                                        <td>".$linha['nome_turma']."</td>
                                        <td>".$linha['turno']."</td>
                                        <td>".$tudo."</td>
                                        <td><a href='cadastrar_turma.php?idTurma=".$linha['id_turma']."'><i class='fas fa-edit text-info'></i></a></td>
                                        <td><a href='funcoes.php?acao=excluirTurma&id=" . $linha['id_turma'] . "' onclick=\"return confirm('Tem certeza que deseja deletar essa turma?');\"><i class='fas fa-trash-alt text-info'></i></a></td>
                                    </tr>
                                    ";
                                }
                        ?>
                    </table>
                </div>
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