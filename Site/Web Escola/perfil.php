<?php
    include "connection.php";    
    session_start();
    if (!isset($_SESSION["chave"])){
    header("Location:index.php");       
    }

    $cpf = $_SESSION["chave"];
    $permi = $_SESSION["permissao"];
    $parte1 = substr($cpf,0,3);
    $parte2 = substr($cpf,3,3);
    $parte3 = substr($cpf,6,3);
    $parte4 = substr($cpf,9,2);
    $cpftudo=$parte1.'.'.$parte2.'.'.$parte3.'-'.$parte4;

   $sql = "select * from tb_pessoa where cpf_pessoa = ".$cpf;
   $exe = mysqli_query($con, $sql);    
   while($linha = mysqli_fetch_array($exe)){
    $nome = $linha["nome"];
    $data = $linha["data_nasc"];
    $cpf_p = $linha["cpf_pessoa"];
    $email = $linha["email"];
    $tel = $linha["telefone"];
    $rua = $linha["rua"];
    $numero = $linha["numero"];
    $bairro = $linha["bairro"];
    $cep = $linha["cep"];    
}
if($permi ==0 ){
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
}else if($permi == 5){
    $sql4 = "select * from tb_professor where tb_pessoa_cpf_pessoa = ".$cpf;
    $exe4 =  mysqli_query($con, $sql4);
    while($linha = mysqli_fetch_array($exe4)){
        $matricula_prof = $linha["matricula_professor"];
        $_SESSION["matricula_professor"] = $linha["matricula_professor"];
    
    }
    $matricula_professor = $_SESSION["matricula_professor"];
    $sql5 = "select * from professor_disciplina where tb_professor_matricula_professor = ".$matricula_professor;
    $exe5 =  mysqli_query($con, $sql5);
    while($linha = mysqli_fetch_array($exe5)){
        $id_disciplina = $linha["tb_disciplina_id_disciplina"];
        $_SESSION["id_disciplina"] = $linha["tb_disciplina_id_disciplina"];
        
    }
    $disciplina_id = $_SESSION["id_disciplina"];
    $sql6 = "select * from tb_disciplina where id_disciplina = ".$disciplina_id;
    $exe6 =  mysqli_query($con, $sql6);
    while($linha = mysqli_fetch_array($exe6)){
        $nome_disciplina = $linha["nome_disciplina"];
        
    }


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
                <a href="" class="nav-link dropdown-toggle active" data-toggle="dropdown"><img src="img/do-utilizador.png" class="mr-2"><?php echo $nome; ?></a>
                <div class="dropdown-menu">
                    <a href="perfil.php" class="dropdown-item disabled">Perfil</a>
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
                 WHERE tb_professor_matricula_professor = $matricula_prof";
                $exec= mysqli_query($con,$cons);
                $cont = mysqli_num_rows($exec);
                
                if ($cont > 0) {
                    $sql="SELECT u.nome_turma,p.tb_professor_matricula_professor,u.id_turma FROM tb_turma as u
                    JOIN professor_turma as p
                    on u.id_turma = p.tb_turma_id_turma
                    WHERE tb_professor_matricula_professor = $matricula_prof";

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
    <?php
        if($permi == 0){
    ?>
	<div class="container-fluid jumbotron-sub-menu">
		<div class="row">
			<div class="col-md-12">
				<div class="">
                  <div class="row">
                        <div class="col-md-9">  
                            <div class="form-group">
                                <label for="nome">Nome</label>
                                <input class="form-control" type="text"  id="nome" value="<?php echo $nome; ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">    
                            <div class="form-group">
                                <label for="data">Data de Nascimento</label>
                                <input class="form-control" type="text"  id="data" value="<?php echo $data; ?>" readonly>
                            </div>
                        </div>    
                    </div>                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="serie">Ano/Série</label>
                                <input class="form-control" type="text" value="<?php echo $ano_novo; ?>" id="serie" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="numero_m">Número da Matrícula</label>
                                <input class="form-control" type="text" value="<?php echo $matricula; ?>" id="numero_m" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="turma">Turma</label>
                                <input class="form-control" type="text" value="<?php echo $nome_turma; ?>"  id="turma" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                        <div class="form-group">
                            <label for="turno">Turno</label>
                            <input class="form-control" type="text" value="<?php echo $turno; ?>" id="turno" readonly>
                        </div>
                        </div>                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="cpf">CPF</label>
                                <input class="form-control" type="text"  id="cpf" value="<?php echo $cpftudo; ?>" readonly>
                            </div>
                        </div>
                    </div>
                    <form action="funcoes.php?acao=atu" method="post"><!--Aqui será o form -->
                        <div class="row">
                        	<div class="col-md-6">
                        		<label for="email">E-mail</label>
                                <input class="form-control" type="email" name="email" value="<?php echo $email; ?>" id="email">
                        	</div>
                        	<div class="col-md-6">
                        		<label for="telefone">telefone</label>
                                <input class="form-control" type="tel" name="telefone" value="<?php echo $tel; ?>" id="telefone" required>
                        	</div>
                        </div>                         
                        <div class="row">
                             <div class="col-md-6">
                                <label for="rua">Rua</label>
                                <input class="form-control" type="text" name="rua" value="<?php echo $rua; ?>" id="rua" required>
                             </div>
                             <div class="col-md-2">
                                <label for="numero">Número</label>
                                <input class="form-control" type="number" name="numero" value="<?php echo $numero; ?>" id="numero" required>
                             </div>
                             <div class="col-md-4">
                                <label for="bairro">Bairro</label>
                                <input class="form-control" type="text" name="bairro" value="<?php echo $bairro; ?>" id="bairro" required>
                             </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="cep">CEP</label>
                                <input class="form-control" type="text" name="cep" value="<?php echo $cep; ?>" id="cep" required>                    
                            </div>
                        </div>
                        
                    	<div class="mt-3">                	
    	                	<a href="tela_inicial.php" class="btn btn-primary">Fechar</a>
                            <input type="button" class="btn btn-primary" name="editar"  onclick="habilitar()" value="Editar">                            
                            <input type="submit" name="salvar" value="salvar" id="salvar" class="btn btn-primary">
                       	</div>
                    </form>
                </div>                
			</div>			
		</div>
		
    </div>
    <?php }else if($permi == 5){?>
        <div class="container-fluid jumbotron-sub-menu">
		<div class="row">
			<div class="col-md-12">
				<div class="">
                  <div class="row">
                        <div class="col-md-9">  
                            <div class="form-group">
                                <label for="nome">Nome</label>
                                <input class="form-control" type="text"  id="nome" value="<?php echo $nome; ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">    
                            <div class="form-group">
                                <label for="data">Data de Nascimento</label>
                                <input class="form-control" type="text"  id="data" value="<?php echo $data; ?>" readonly>
                            </div>
                        </div>    
                    </div>                   
                    <div class="row">                                               
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="cpf">CPF</label>
                                <input class="form-control" type="text"  id="cpf" value="<?php echo $cpftudo; ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="disciplina">Disciplina</label>
                                <input class="form-control" type="text"  id="disciplina" value="<?php echo $nome_disciplina; ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="numero_mp">Número da Matrícula</label>
                                <input class="form-control" type="text" value="<?php echo $matricula_prof; ?>" id="numero_mp" readonly>
                            </div>
                        </div>
                    </div>
                    <form action="funcoes.php?acao=atu" method="post"><!--Aqui será o form -->                    
                        <div class="row">
                        	<div class="col-md-6">
                        		<label for="email">E-mail</label>
                                <input class="form-control" type="email" name="email" value="<?php echo $email; ?>" id="email">
                        	</div>
                        	<div class="col-md-6">
                        		<label for="telefone">telefone</label>
                                <input class="form-control" type="tel" name="telefone" value="<?php echo $tel; ?>" id="telefone" required>
                        	</div>
                        </div>                         
                        <div class="row">
                             <div class="col-md-6">
                                <label for="rua">Rua</label>
                                <input class="form-control" type="text" name="rua" value="<?php echo $rua; ?>" id="rua" required>
                             </div>
                             <div class="col-md-2">
                                <label for="numero">Número</label>
                                <input class="form-control" type="number" name="numero" value="<?php echo $numero; ?>" id="numero" required>
                             </div>
                             <div class="col-md-4">
                                <label for="bairro">Bairro</label>
                                <input class="form-control" type="text" name="bairro" value="<?php echo $bairro; ?>" id="bairro" required>
                             </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="cep">CEP</label>
                                <input class="form-control" type="text" name="cep" value="<?php echo $cep; ?>" id="cep" required>                    
                            </div>
                        </div>
                        
                    	<div class="mt-3">                	
    	                	<a href="tela_inicial.php" class="btn btn-primary">Fechar</a>
                            <input type="button" class="btn btn-primary" name="editar"  onclick="habilitar()" value="Editar">                            
                            <input type="submit" name="salvar" value="salvar" id="salvar" class="btn btn-primary">
                       	</div>
                    </form>
                </div>                
			</div>			
		</div>
		
    </div>
    <?php
        }else if($permi == 10){
    ?>
	<div class="container-fluid jumbotron-sub-menu">
		<div class="row">
			<div class="col-md-12">
				<div class="">
                  <div class="row">
                        <div class="col-md-6">  
                            <div class="form-group">
                                <label for="nome">Nome</label>
                                <input class="form-control" type="text"  id="nome" value="<?php echo $nome; ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="cpf">CPF</label>
                                <input class="form-control" type="text"  id="cpf" value="<?php echo $cpftudo; ?>" readonly>
                            </div>
                        </div>                            
                    </div>
                    <form action="funcoes.php?acao=atu" method="post"><!--Aqui será o form -->
                        <div class="row">
                        	<div class="col-md-6">
                        		<label for="email">E-mail</label>
                                <input class="form-control" type="email" name="email" value="<?php echo $email; ?>" id="email" >
                        	</div>
                        	<div class="col-md-6">
                        		<label for="telefone">telefone</label>
                                <input class="form-control" type="tel" name="telefone" value="<?php echo $tel; ?>" id="telefone" required>
                        	</div>
                        </div>                         
                        <div class="row">
                             <div class="col-md-6">
                                <label for="rua">Rua</label>
                                <input class="form-control" type="text" name="rua" value="<?php echo $rua; ?>" id="rua" required>
                             </div>
                             <div class="col-md-2">
                                <label for="numero">Número</label>
                                <input class="form-control" type="number" name="numero" value="<?php echo $numero; ?>" id="numero" required>
                             </div>
                             <div class="col-md-4">
                                <label for="bairro">Bairro</label>
                                <input class="form-control" type="text" name="bairro" value="<?php echo $bairro; ?>" id="bairro" required>
                             </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="cep">CEP</label>
                                <input class="form-control" type="text" name="cep" value="<?php echo $cep; ?>" id="cep" required>                    
                            </div>
                        </div>
                        
                    	<div class="mt-3">                	
    	                	<a href="tela_inicial.php" class="btn btn-primary">Fechar</a>
                            <input type="button" class="btn btn-primary" name="editar"  onclick="habilitar()" value="Editar">                            
                            <input type="submit" name="salvar" value="salvar" id="salvar" class="btn btn-primary">
                       	</div>
                    </form>
                </div>                
			</div>			
		</div>
		
    </div>
    <?php } ?>
<script src="js/jquery-3.3.1.slim.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<scrip  src="js/jquery-1.2.6.pack.js"></script>
<script src="js/jquery.maskedinput-1.1.4.pack.js"></script>
    <script>
           
           
           
            var em = document.getElementById('email');
            var tel = document.getElementById('telefone');
            var rua = document.getElementById('rua');
            var num = document.getElementById('numero');
            var bai = document.getElementById('bairro');
            var cep = document.getElementById('cep');
            var salvar = document.getElementById('salvar');
                      
                em.setAttribute("disabled","disabled");
                tel.setAttribute("disabled","disabled");
                rua.setAttribute("disabled","disabled");
                num.setAttribute("disabled","disabled");
                bai.setAttribute("disabled","disabled");
                cep.setAttribute("disabled","disabled"); 
                salvar.setAttribute("disabled","disabled"); 



               
            function habilitar(){               
                em.removeAttribute("disabled","disabled");
                tel.removeAttribute("disabled","disabled"); 
                rua.removeAttribute("disabled","disabled"); 
                num.removeAttribute("disabled","disabled"); 
                bai.removeAttribute("disabled","disabled"); 
                cep.removeAttribute("disabled","disabled"); 
                salvar.removeAttribute("disabled","disabled"); 
                

            }
    $(document).ready(function(){
		$("#telefone").mask("(99) 9999-99999");
	});
    $(document).ready(function(){
		$("#cep").mask("99999-999");
	});	
        
        </script>
</body>

</html>