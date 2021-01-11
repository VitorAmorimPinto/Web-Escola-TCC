<?php
   session_start();
   if (!isset($_SESSION["chave"])){
   header("Location:index.php");       
   }
    
    $cpf = $_SESSION["chave"];
    $permi = $_SESSION["permissao"];
    include "connection.php";
    
   $sql = "select * from tb_pessoa where cpf_pessoa = ".$cpf;
   $exe = mysqli_query($con, $sql);

   while($linha = mysqli_fetch_array($exe)){
    $nome = $linha["nome"];
    $_SESSION["usuario"] = $linha["nome"];
    
}

if($permi == 5){

$sql1 = "select * from tb_professor where tb_pessoa_cpf_pessoa = ".$cpf;
$exe1 =  mysqli_query($con, $sql1);

while($linha = mysqli_fetch_array($exe1)){

$matricula = $linha["matricula_professor"];
$_SESSION["matricula"] = $linha["matricula_professor"];

}

    
    $matricula_professor = $_SESSION["matricula"];

}else if($permi == 10){

    $sql2 = "SELECT * FROM `tb_aluno`";
    $exe2 =  mysqli_query($con, $sql2);
    $cont_alunos = mysqli_num_rows($exe2);
    
    $sql3 = "SELECT * FROM tb_professor";
    $exe3 =  mysqli_query($con, $sql3);
    $cont_professores = mysqli_num_rows($exe3);

    $sql4 = "SELECT * FROM `tb_turma`";
    $exe4 =  mysqli_query($con, $sql4);
    $cont_turmas = mysqli_num_rows($exe4);

    $sql5 = "SELECT * FROM `tb_disciplina`";
    $exe5 =  mysqli_query($con, $sql5);
    $cont_disciplina = mysqli_num_rows($exe5);
    
}else if ($permi == 0) {
    $sql1 = "select * from tb_aluno where tb_pessoa_cpf_pessoa = ".$cpf;
    $exe1 =  mysqli_query($con, $sql1);
    while($linha = mysqli_fetch_array($exe1)){
        $matricula = $linha["matricula_aluno"];
    
    }
    $sql2 = "select * from aluno_turma where tb_aluno_matricula_aluno = ".$matricula;
    $exe2 =  mysqli_query($con, $sql2);
    
    
    while($linha = mysqli_fetch_array($exe2)){
        $id_turma = $linha["tb_turma_id_turma"];
    
    }
    @$sql3 = "select * from tb_turma where id_turma = ".$id_turma;
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
    <meta charset="utf-8">
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
                <?php
                    if($permi == 0 ){
                ?>
                <li class="nav-item dropdown">
                    <a href="boletim.php" class="nav-link">Boletim</a>
                    
                </li>
                <?php }else if($permi == 5){?>
                    <li class="nav-item dropdown">
                    <a href="" class="nav-link dropdown-toggle" data-toggle="dropdown">Lançar Notas</a>            
                    <div class="dropdown-menu">      
                    
                    <?php
                     $cons="SELECT u.nome_turma,p.tb_professor_matricula_professor,u.id_turma FROM tb_turma as u
                     JOIN professor_turma as p
                     on u.id_turma = p.tb_turma_id_turma
                     WHERE tb_professor_matricula_professor = $matricula";
                    $exec= mysqli_query($con,$cons);
                    $cont = mysqli_num_rows($exec);
                    
                    if ($cont > 0) {
                        $sql="SELECT u.nome_turma,p.tb_professor_matricula_professor,u.id_turma FROM tb_turma as u
                        JOIN professor_turma as p
                        on u.id_turma = p.tb_turma_id_turma
                        WHERE tb_professor_matricula_professor = $matricula";

                        $res= mysqli_query($con,$sql);
                        while ($linha = mysqli_fetch_assoc($res)){
                            echo "

                            
                             <a class='dropdown-item' href='funcoes.php?acao=formarPauta&idTurma=".$linha['id_turma']."'>".$linha['nome_turma']."</a>
                                
                             ";                  
                            
                        }

                    }else{
                        echo "<p>Você ainda não possui turmas</p>";     
                    }       
                    ?> 
                    </div>
                    </li>
                    
                <?php }else if($permi == 10){ ?>
                <li class="nav-item dropdown">
                    <a href="" class="nav-link dropdown-toggle" data-toggle="dropdown">Cadastro</a>
                    <div class="dropdown-menu">
                    	<a href="cadastrar_pessoa.php" class="dropdown-item">Cadastrar Pessoa</a>                    	
                    	<a href="cadastrar_turma.php" class="dropdown-item">Cadastrar Turma</a>
                        <a href="cadastrar_disciplina.php" class="dropdown-item">Cadastrar Disciplina</a>
                    	<a href="formar_turma.php" class="dropdown-item">Formar Turma</a>               
                    	<a href="professores.php" class="dropdown-item">Professores</a>               
                        <a href="funcoes.php?acao=inicAno" class="dropdown-item" OnClick="return confirm('Deseja iniciar o ano letivo');">Ano Letivo</a>               

                    </div>
                </li>
                <?php } ?>                
                <li class="nav-item dropdown">
                    <a href="sair.php" class="nav-link">Sair</a>                    
                </li>
            </ul>
        </div>
	</nav>
        <?php if($permi == 10){ ?>
<div class="container-fluid jumbotron-tela-inicial">
    <div class="row">    
        <div class="col-md-12 mx-auto"><!--col-sm8 -->
            <div id="ControleCarousel" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner text-center">
                    <div class="carousel-item active">
                      <h1 class="text-center display-5 font-carousel">CADASTRAR DISCIPLINA</h1>
                      <a href="cadastrar_disciplina.php" class="btn btn-lg btn-primary rounded-pill">                     
                    <i class="fas fa-file-signature"></i> Cadastrar
                  </a>  
                    </div>
                    <div class="carousel-item">
                    <h1 class="text-center display-5 font-carousel">CADASTRAR PESSOA</h1>
                      <a href="cadastrar_pessoa.php" class="btn btn-lg btn-primary rounded-pill">                     
                      <i class="fas fa-user-plus"></i> Cadastrar
                  </a>               
                    </div>
                    <div class="carousel-item">
                      <h1 class="text-center display-5 font-carousel">CADASTRAR TURMA</h1>
                      <a href="cadastrar_turma.php" class="btn btn-lg btn-primary rounded-pill">                     
                      <i class="fas fa-book-reader"></i> Cadastrar
                        </a>
                    </div>
                    <div class="carousel-item">
                      <h1 class="text-center display-5 font-carousel">PROFESSORES</h1>
                      <a href="professores.php" class="btn btn-lg btn-primary rounded-pill">                     
                      <i class="fas fa-chalkboard-teacher"></i> Visitar
                        </a>
                    </div>
                    
                    </div>
                    <a class="carousel-control-prev" href="#ControleCarousel" role="button" data-slide="prev">
                    <span class="fas fa-angle-left fa-3x text-dark" aria-hidden="true"></span> 
                    <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#ControleCarousel" role="button" data-slide="next">
                    <span class="fas fa-angle-right fa-3x text-dark" aria-hidden="true"></span>                   
                    <span class="sr-only">Next</span>
                    </a>
                </div>
            </div><!--/col-sm8 -->
        </div>
</div>
<div class="container-fluid jumbotron-sub-menu mb-5">
        <div class="row">
            <div class="col-md-4 bg-sub-menu rounded"> 
                <h1 class="font-carousel">Informações</h1>
                <hr>
                <ul class="list-group list-group-flush mb-4">
                    <li class="list-group-item rounded bg-list text-light">ALUNOS CADASTRADOS: <?php echo $cont_alunos?></li>
                    <li class="list-group-item rounded bg-list text-light">PROFESSORES CADASTRADOS: <?php echo $cont_professores?></li>
                    <li class="list-group-item rounded bg-list text-light">TURMAS CADASTRADAS: <?php echo $cont_turmas?></li>
                    <li class="list-group-item rounded bg-list text-light">DISCIPLINAS CADASTRADAS: <?php echo $cont_disciplina?></li>
                </ul>
            </div>
        </div>
</div>        
<?php }else if($permi == 5){?>
<div class="container-fluid jumbotron-tela-inicial">
            <div class="row">    
                <div class="col-md-12 mx-auto"><!--col-sm8 -->
                    <div id="ControleCarousel" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner text-center">
                            <div class="carousel-item active">
                                    <h1 class="text-center display-5 font-carousel">WEB ESCOLA</h1>
                                    <P>Sua vida mais prática</P>               
                            </div>     
                            <div class="carousel-item">
                                <h1 class="text-center display-5 font-carousel">EDITAR DADOS</h1>
                                <a href="perfil.php" class="btn btn-lg btn-primary rounded-pill">                     
                                <i class="fas fa-edit"></i> Editar
                                </a>  
                            </div>
                </div>
                <a class="carousel-control-prev" href="#ControleCarousel" role="button" data-slide="prev">
                    <span class="fas fa-angle-left fa-3x text-dark" aria-hidden="true"></span> 
                    <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#ControleCarousel" role="button" data-slide="next">
                    <span class="fas fa-angle-right fa-3x text-dark" aria-hidden="true"></span>                   
                    <span class="sr-only">Next</span>
                    </a>
                </div>
            </div><!--/col-sm8 -->
        </div>
</div>
<div class="container-fluid jumbotron-sub-menu">    
        <div class="row ">            
            <div class="col-md-4 bg-sub-menu rounded ">
            <h3 class="text-center font-carousel">Suas Turmas</h3> 
                <ul class="nav nav-pills flex-column text-center mb-3">
                    <?php
                     $cons="SELECT u.nome_turma,p.tb_professor_matricula_professor,u.id_turma FROM tb_turma as u
                     JOIN professor_turma as p
                     on u.id_turma = p.tb_turma_id_turma
                     WHERE tb_professor_matricula_professor = $matricula";
                    $exec= mysqli_query($con,$cons);
                    $cont = mysqli_num_rows($exec);
                    
                    if ($cont > 0) {
                        $sql="SELECT u.nome_turma,p.tb_professor_matricula_professor,u.id_turma FROM tb_turma as u
                        JOIN professor_turma as p
                        on u.id_turma = p.tb_turma_id_turma
                        WHERE tb_professor_matricula_professor = $matricula";

                        $res= mysqli_query($con,$sql);
                        while ($linha = mysqli_fetch_assoc($res)){
                            echo "<ul class='list-group list-group-flush'>
                                    <li class='list-group-item rounded bg-list text-light nav-link-turmas'>                            
                                        <a class='nav-link text-light '
                                        href='funcoes.php?acao=formarPauta&idTurma=".$linha['id_turma']."'>".$linha['nome_turma']."</a>
                                    </li>
                                 </ul>";                  
                            
                        }

                    }else{
                        echo "<p>Você ainda não possui turmas</p>";     
                    }       
                    ?>       
                </ul>
            </div>      
        </div>
</div>
        <?php }else if($permi == 0){?>
<div class="container-fluid jumbotron-tela-inicial">
            <div class="row">    
                <div class="col-md-12 mx-auto"><!--col-sm8 -->
                    <div id="ControleCarousel" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner text-center">
                            <div class="carousel-item active">
                                    <h1 class="text-center display-5 font-carousel">WEB ESCOLA</h1>
                                    <P>Uma escola sem barreiras</P>               
                            </div>        
                            <div class="carousel-item">
                                <h1 class="text-center display-5 font-carousel">EDITAR DADOS</h1>
                                <a href="perfil.php" class="btn btn-lg btn-primary rounded-pill">                     
                                <i class="fas fa-edit"></i> Editar
                                </a>  
                            </div>
                                    <div class="carousel-item">
                                    <h1 class="text-center display-5 font-carousel">BOLETIM</h1>
                                    <a href="boletim.php" class="btn btn-lg btn-primary rounded-pill">                     
                                    <i class="far fa-address-card"></i> Acessar
                                </a>               
                    </div>     
                    
                </div>
                <a class="carousel-control-prev" href="#ControleCarousel" role="button" data-slide="prev">
                    <span class="fas fa-angle-left fa-3x text-dark" aria-hidden="true"></span> 
                    <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#ControleCarousel" role="button" data-slide="next">
                    <span class="fas fa-angle-right fa-3x text-dark" aria-hidden="true"></span>                   
                    <span class="sr-only">Next</span>
                    </a>
                </div>
            </div><!--/col-sm8 -->
        </div>        
    </div>
</div>
<div class="container-fluid jumbotron-sub-menu mb-5">
        <div class="row">
            <div class="col-md-4 bg-sub-menu rounded"> 
                <h1 class="font-carousel">Informações</h1>
                <hr>
                <ul class="list-group list-group-flush mb-4">
                    <li class="list-group-item rounded bg-list text-light">TURMA: <?php echo $nome_turma?></li>
                    <li class="list-group-item rounded bg-list text-light">ANO: <?php echo $ano_novo?></li>
                    <li class="list-group-item rounded bg-list text-light">MATRÍCULA: <?php echo $matricula?></li>
                    <li class="list-group-item rounded bg-list text-light">PERÍODO: <?php echo $turno?></li>
                </ul>
            </div>
        </div>
</div>
<?php } ?>

<script src="js/jquery-3.3.1.slim.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>

</html>