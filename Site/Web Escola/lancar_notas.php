
<?php 
    include "connection.php";
    session_start();
    if((!empty($_SESSION["chave"])) && 
    (isset($_SESSION["permissao"])) && 
    (@$_SESSION["permissao"]==5)){
    $cpf = $_SESSION["chave"];
    $permi = $_SESSION["permissao"];
    
   $sql = "select * from tb_pessoa where cpf_pessoa = ".$cpf;
   $exe = mysqli_query($con, $sql);

   while($linha = mysqli_fetch_array($exe)){
    $nome = $linha["nome"];
    $_SESSION["usuario"] = $linha["nome"];
    
}

$sql1 = "select * from tb_professor where tb_pessoa_cpf_pessoa = ".$cpf;
$exe1 =  mysqli_query($con, $sql1);

while($linha = mysqli_fetch_array($exe1)){

$matricula_professor = $linha["matricula_professor"];

}
$id_turma= $_GET["idTurma"];

$sql3 = "select * from tb_turma where id_turma = ".$id_turma;
$exe3 = mysqli_query($con, $sql3);

while($linha = mysqli_fetch_array($exe3)){
 $nome_turma = $linha["nome_turma"];
 $turno = $linha["turno"];
 $ano = $linha["ano"];
  
}
$ano_ce=substr($ano,0,1);
$ano_c=substr($ano,1,3);
$ano_novo=$ano_ce."°".$ano_c;
$ano_letivo = date("Y");
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
            <a href="" class="nav-link dropdown-toggle active" data-toggle="dropdown">Lançar Notas</a>            
            <div class="dropdown-menu">      
            
            <?php
             $cons="SELECT u.nome_turma,p.tb_professor_matricula_professor,u.id_turma FROM tb_turma as u
             JOIN professor_turma as p
             on u.id_turma = p.tb_turma_id_turma
             WHERE tb_professor_matricula_professor = $matricula_professor";
            $exec= mysqli_query($con,$cons);
            $cont = mysqli_num_rows($exec);
            
            if ($cont > 0) {
                $sql="SELECT u.nome_turma,p.tb_professor_matricula_professor,u.id_turma FROM tb_turma as u
                JOIN professor_turma as p
                on u.id_turma = p.tb_turma_id_turma
                WHERE tb_professor_matricula_professor = $matricula_professor";

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
<div class="container-fluid jumbotron-lancar-notas">
    <div class="row">
        <div class="col-md-2">
            <h1 class="font-carousel">Informações</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-2">
            <p class="font-weight-bold">Ano: <?php echo $ano_novo?> </p>
        </div>
        <div class="col-md-2">
            <p class="font-weight-bold">Turma: <?php echo $nome_turma?> </p>
        </div>
        <div class="col-md-2">
            <p class="font-weight-bold">Disciplina: <?php echo $ano_novo?> </p>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-md-2">
            <p class="font-weight-bold">Período: <?php echo $turno?> </p>
        </div>
        <div class="col-md-2">
            <p class="font-weight-bold">Ano Letivo: <?php echo $ano_letivo?> </p>
        </div>
    </div>
</div>
<div class="container-fluid jumbotron-sub-menu">
    <div class="row">
         <div class="col-md-12 mx-auto">
            <div class="">
                <form method="post" action="funcoes.php?acao=lancarNotas">
                <?php                
                                        //busco os registros dos usuários
                                        $select = "SELECT tp.nota1,tp.nota2,tp.nota3,tp.faltas1,tp.faltas2,tp.faltas3,ta.matricula_aluno,p.nome FROM tb_pauta as tp
                                        JOIN tb_aluno as ta 
                                        on tp.tb_aluno_matricula_aluno = ta.matricula_aluno 
                                        JOIN tb_pessoa as p
                                        on p.cpf_pessoa = ta.tb_pessoa_cpf_pessoa
                                        WHERE tp.tb_turmas_id_turma = $id_turma and tb_professor_matricula_professor = $matricula_professor ";
                                             
                                        //executar o meu select, passo o status da conexão $con
                                        //e minha query de consulta
                                        $exe = mysqli_query($con, $select);
                                        
                                        //função que conta os registros do select realizado
                                        //e armazena na contaRegistros
                                        $contaRegistros = mysqli_num_rows($exe);
                                        
                                        //se não houver registros mostra a mensagem
                                        //senão, mostra os registros do banco.
                                        if($contaRegistros == 0){
                                            echo "<br><h4>Essa turma não possui alunos</h4>";
                                        }else{                    
                                    ?>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped text-center jumbotron">
                                                <tr>
                                                    <th>Aluno</th>
                                                    <th>1°Trimestre</th>
                                                    <th>2°Trimestre</th>                                                                                          
                                                    <th>3°Trimestre</th>
                                                    <th>Faltas 1°</th>
                                                    <th>Faltas 2°</th>                                                                                                        
                                                    <th>Faltas 3°</th>
                                                </tr>
                                                
                                                <?php                          
                                                
                                                $procurar = "SELECT tp.tb_professor_matricula_professor,tp.tb_turmas_id_turma,tp.nota1,tp.nota2,tp.nota3,tp.faltas1,tp.faltas2,tp.faltas3,ta.matricula_aluno,p.nome FROM tb_pauta as tp
                                                JOIN tb_aluno as ta 
                                                on tp.tb_aluno_matricula_aluno = ta.matricula_aluno 
                                                JOIN tb_pessoa as p
                                                on p.cpf_pessoa = ta.tb_pessoa_cpf_pessoa
                                                WHERE tp.tb_turmas_id_turma = $id_turma and tb_professor_matricula_professor = $matricula_professor ";
                                                        
                                                                            
                                                    $res = mysqli_query($con, $procurar) or die(mysqli_error($con));    

                                                        while($linha = mysqli_fetch_array($res)){
                                                    
                                                            echo "<tr>
                                                            
                                                                <td>".$linha['nome']."</td>                                    
                                                                <td><input class='form-control' name='nota1[]' id='input' step='0.010' min='0' max='30' value=".$linha['nota1']." type='number'></td>
                                                                <td><input class='form-control' name='nota2[]' id='input2' step='0.010' min='0' max='30' value=".$linha['nota2']." type='number'></td>
                                                                <td><input class='form-control' name='nota3[]' id='input3' step='0.010' min='0' max='40' value=".$linha['nota3']." type='number'></td>
                                                                <td><input class='form-control' name='faltas1[]' min='0' max='100' value=".$linha['faltas1']." type='number'></td>
                                                                <td><input class='form-control' name='faltas2[]' min='0' max='100' value=".$linha['faltas2']." type='number'></td>
                                                                <td><input class='form-control' name='faltas3[]' min='0' max='100' value=".$linha['faltas3']." type='number'></td>
                                                                <td hidden><input class='form-control' name='alunos[]' value=".$linha['matricula_aluno']." type='hidden'></td>
                                                                <td hidden><input class='form-control' name='matprof' value=".$linha['tb_professor_matricula_professor']." type='hidden'></td>
                                                                <td hidden><input class='form-control' name='idturma' value=".$linha['tb_turmas_id_turma']." type='hidden'></td>
                                                                
                                                            
                                                                
                                                            </tr>
                                                            ";
                                                        }
                                                ?>
                                            </table>          
                                    </div>
                                    <?php
                                        }//fim do else que valida a quantidade de usuaários.
                                    ?>
                        <div class="">            	
    	                
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
<script>
    document.getElementById("input").addEventListener("change", function(){
   this.value = parseFloat(this.value).toFixed(2);
});
document.getElementById("input").addEventListener("change", function(){
   this.value = parseFloat(this.value).toFixed(2);
});
document.getElementById("input2").addEventListener("change", function(){
   this.value = parseFloat(this.value).toFixed(2);
});
document.getElementById("input2").addEventListener("change", function(){
   this.value = parseFloat(this.value).toFixed(2);
});
document.getElementById("input3").addEventListener("change", function(){
   this.value = parseFloat(this.value).toFixed(2);
});
document.getElementById("input3").addEventListener("change", function(){
   this.value = parseFloat(this.value).toFixed(2);
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