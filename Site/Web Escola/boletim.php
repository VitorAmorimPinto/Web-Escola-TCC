<?php 
   session_start();
   include "connection.php";
   
   if((!empty($_SESSION["chave"])) && 
   (isset($_SESSION["permissao"])) && 
   (@$_SESSION["permissao"]==0)){
    $cpf = $_SESSION["chave"];
    $permi = $_SESSION["permissao"];
    
    $sql1 = "select * from tb_aluno where tb_pessoa_cpf_pessoa = ".$cpf;
    $exe1 =  mysqli_query($con, $sql1);
    while($linha = mysqli_fetch_array($exe1)){
        $matricula = $linha["matricula_aluno"];
        $_SESSION["matricula"] = $linha["matricula_aluno"];
    
    }
    $nome =  $_SESSION["usuario"];
if($permi == 0){
        
        $sql1 = "select * from tb_aluno where tb_pessoa_cpf_pessoa = ".$cpf;
        $exe1 =  mysqli_query($con, $sql1);
        while($linha = mysqli_fetch_array($exe1)){
            $matricula = $linha["matricula_aluno"];
            $_SESSION["matricula"] = $linha["matricula_aluno"];
        
        }
        $matricula_aluno = $_SESSION["matricula"];
        $sql2 = "select * from aluno_turma where tb_aluno_matricula_aluno = ".$matricula_aluno;
        $exe2 =  mysqli_query($con, $sql2);
        
        
        while($linha = mysqli_fetch_array($exe2)){
            $id_turma = $linha["tb_turma_id_turma"];
            $_SESSION["id_turma"] = $linha["tb_turma_id_turma"];
        
        }
       @$turma_id = $_SESSION["id_turma"];
        $sql3 = "select * from tb_turma where id_turma = ".$turma_id;
        $exe3 =  mysqli_query($con, $sql3);
        
        while($linha = mysqli_fetch_array($exe3)){
           $nome_turma = $linha["nome_turma"]; 
           $turno = $linha["turno"]; 
           $ano = $linha["ano"]; 
        
        }
        @$ano_ce=substr($ano,0,1);
        @$ano_c=substr($ano,1,3);
        $ano_novo=$ano_ce."°".$ano_c; 
    } 
    
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="fontawesome/css/all.css">
    <link rel="stylesheet" type="text/css" href="css/Style.css">
    <title>Web Escola</title>
	
</head>
<body class="fundo">
		<nav class="navbar navbar-expand-sm navbar-dark bg-menu">
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
                    <a href="" class="nav-link active disabled">Boletim</a>                    
                </li>                
                <li class="nav-item dropdown">
                    <a href="sair.php" class="nav-link">Sair</a>                   
                </li>
            </ul>
          </div>
	</nav>
	<div class="container-fluid jumbotron-lancar-notas">
    <div class="row">
        <div class="col-md-2">
            <h1 class="font-carousel">Boletim</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-2">
            <p class="font-weight-bold">Ano: <?php echo $ano_novo ?> </p>
        </div>
        <div class="col-md-2">
            <p class="font-weight-bold">Turma: <?php echo $nome_turma?> </p>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-md-2">
            <p class="font-weight-bold">Período: <?php echo $turno?> </p>
        </div>
        <div class="col-md-2">
            <p class="font-weight-bold">Matricula: <?php echo $matricula_aluno?> </p>
        </div>
    </div>
</div>
    <div class="container-fluid jumbotron-sub-menu">
          <div class="row ">
              <div class="col-md-12 mx-auto">
                <div class="">
                <?php                
                                        //busco os registros dos usuários
                                        $select = "SELECT tp.nota1,tp.nota2,tp.nota3,td.nome_disciplina FROM `tb_pauta` as tp
                                                    JOIN tb_disciplina as td
                                                    on tp.tb_disciplina_id_disciplina = td.id_disciplina
                                                    WHERE tp.tb_aluno_matricula_aluno = $matricula                                                ";
                                             
                                        //executar o meu select, passo o status da conexão $con
                                        //e minha query de consulta
                                        $exe = mysqli_query($con, $select);
                                        
                                        //função que conta os registros do select realizado
                                        //e armazena na contaRegistros
                                        $contaRegistros = mysqli_num_rows($exe);
                                        
                                        //se não houver registros mostra a mensagem
                                        //senão, mostra os registros do banco.
                                        if($contaRegistros == 0){
                                            echo "<br><h4>Você ainda não possui notas</h4>";
                                        }else{                    
                                    ?>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped text-center jumbotron">
                                                <tr>
                                                    <th>Matéria</th>
                                                    <th>1°Trimestre</th>
                                                    <th>2°Trimestre</th>                                                                                          
                                                    <th>3°Trimestre</th>
                                                    <th>Total de Faltas</th>
                                                </tr>
                                                
                                                <?php                          
                                                
                                                $procurar = "SELECT tp.nota1,tp.nota2,tp.nota3,td.nome_disciplina,tp.faltas1,tp.faltas2,tp.faltas3 FROM `tb_pauta` as tp
                                                    JOIN tb_disciplina as td
                                                    on tp.tb_disciplina_id_disciplina = td.id_disciplina
                                                    WHERE tp.tb_aluno_matricula_aluno = $matricula";
                                                        
                                                                            
                                                    $res = mysqli_query($con, $procurar) or die(mysqli_error($con));    

                                                        while($linha = mysqli_fetch_array($res)){
                                                            $faltas_primeiro = $linha['faltas1'];
                                                            $faltas_segundo = $linha['faltas2'];
                                                            $faltas_terceiro = $linha['faltas3'];
                                                            $faltas_totais = $faltas_primeiro + $faltas_segundo + $faltas_terceiro;
                                                            

                                                            echo "<tr>
                                                            
                                                                <td>".$linha['nome_disciplina']."</td>                                    
                                                                <td>".$linha['nota1']."</td>
                                                                <td>".$linha['nota2']."</td>
                                                                <td>".$linha['nota3']."</td>
                                                                <td>".$faltas_totais."</td>
                                                                
                                                                
                                                            
                                                                
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