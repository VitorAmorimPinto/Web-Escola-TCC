<?php
  include "connection.php"; 
  session_start();
  $cpf = $_SESSION["chave"];
  $permi = $_SESSION["permissao"];
  $matricula_professor = $_SESSION["matricula"]; //essa variavel foi para sessão para ser usada usar em formarPauta  


if($_GET["acao"] == "logar"){
    //recebendo os dados de login.
    $login = mysqli_real_escape_string($con,$_POST["usuario"]);
    $senha = md5($_POST["senha"]);

    $sql = "select * from tb_usuario where login = '$login' and senha = '$senha'";
    $exe = mysqli_query($con, $sql);
    
    $cont = mysqli_num_rows($exe);
    if($cont != 0){
        while($linha = mysqli_fetch_array($exe)){
            $_SESSION["chave"] = $linha["tb_pessoa_cpf_pessoa"];
            $_SESSION["permissao"]  = $linha["permissao"];
            
        if($_SESSION["permissao"] == 0){
                header("Location:tela_inicial.php");
            }else if($_SESSION["permissao"] == 5){
                header("Location:tela_inicial.php");
            }else if($_SESSION["permissao"] == 10){
                header("Location:tela_inicial.php");
            }
        }
    }else{
        echo "<script>
                alert('Usuário não encontrado.')                
                window.location='index.php'
             </script>";
    }

    
}else if($_GET["acao"] == "atu"){
    $email = $_POST["email"] ;
    $tel =  $_POST["telefone"];
    $rua =  $_POST["rua"];
    $numero =  $_POST["numero"];
    $bairro =  $_POST["bairro"];
    $cep =  $_POST["cep"];

    $upd = "UPDATE tb_pessoa SET email='".$email."',telefone='".$tel."',rua='".$rua."',numero='".$numero."',bairro='".$bairro."',cep='".$cep."' WHERE cpf_pessoa =".$cpf;
    $result = mysqli_query($con, $upd)or die(mysqli_error($con));
    echo "<script>
        alert('Dados Atualizados com Sucesso')
        window.location='perfil.php'
        </script>";
    
    
}else if($_GET["acao"] == "cadPes"){
    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $data_nasc = $_POST["data_nasc"] ;
    $tipo = $_POST["tipo"];//Nivel de Permissão do Banco    
    $telefone = $_POST["telefone"] ;
    $cpf = $_POST["cpf"] ;
    $rua = $_POST["rua"] ;
    $numero = $_POST["numero"] ;
    $bairro = $_POST["bairro"] ;
    $cep = $_POST["cep"] ;
    $disciplina = $_POST["disciplina"];
    $p_metade= substr($cpf,0,3); //Quebra o cpf.
    $s_metade= substr($cpf,4,3); //Quebra o cpf.
    $t_metade= substr($cpf,8,3); //Quebra o cpf.
    $q_metade= substr($cpf,12,2); //Quebra o cpf.
    $cpf_completo= $p_metade.$s_metade.$t_metade.$q_metade; //Junta o cpf quebrado sem os pontos e traços.
    $cpf_pass = substr($cpf_completo,0,6); //Senha gerada com os seis primeiros dígitos
    $cpf_gerar = substr($cpf_completo,0,3); // Ultilizado para gerar matricula
    $cpf_pass_b = md5 ($cpf_pass); 
    
    if ($tipo == 5 && $disciplina == null) {
        echo "<script>
        alert('Você não selecionou nenhuma disciplina para esse professor!')
        window.location='cadastrar_pessoa.php'
        </script>";
    }else{
    $sql="select * from tb_pessoa WHERE cpf_pessoa ='$cpf_completo'";
    $exec= mysqli_query($con,$sql);
    $cont = mysqli_num_rows($exec);
    if ($cont > 0) {
        echo "<script>
            alert('Esse CPF já está cadastrado!')
            window.location='cadastrar_pessoa.php'
            </script>";
    }else{
        $inserir1 = "INSERT INTO tb_pessoa(cpf_pessoa,nome,rua,bairro,numero,cep,email,telefone,data_nasc) VALUES('$cpf_completo','$nome','$rua','$bairro','$numero','$cep','$email','$telefone','$data_nasc')";
        $inserir2 = "INSERT INTO tb_usuario(id_usuario, login,senha,permissao,tb_pessoa_cpf_pessoa) VALUES (null,'$cpf_completo','$cpf_pass_b','$tipo','$cpf_completo')";
        $res1 = mysqli_query($con, $inserir1) or die(mysqli_error($con));
        $res2 = mysqli_query($con, $inserir2) or die(mysqli_error($con));    
        
    if ($tipo == 0 || $tipo == 5) {
        $inserir3 ="INSERT INTO tb_gerar(id_gerar,tb_pessoa_cpf_pessoa) VALUES (null,'$cpf_completo')";    
        $res3 = mysqli_query($con, $inserir3) or die(mysqli_error($con));
    
        $sql = "select * from tb_gerar where tb_pessoa_cpf_pessoa = ".$cpf_completo;
        $exe = mysqli_query($con, $sql);
     
        while($linha = mysqli_fetch_array($exe)){
         $id_gerar = $linha["id_gerar"];
         $_SESSION["gerar"] = $linha["id_gerar"];          
     }
     $id_gerar1 = $_SESSION["gerar"];  
     $matricula = $id_gerar1.$tipo.$cpf_gerar;
        if ($tipo == 0) {
        $inserir4 ="INSERT INTO tb_aluno(matricula_aluno,tb_pessoa_cpf_pessoa) VALUES ($matricula,'$cpf_completo')";    
        $res4 = mysqli_query($con, $inserir4) or die(mysqli_error($con));
        
        }else if ($tipo == 5) {
        $inserir5 ="INSERT INTO tb_professor(matricula_professor,tb_pessoa_cpf_pessoa) VALUES ($matricula,'$cpf_completo')";    
        $res5 = mysqli_query($con, $inserir5) or die(mysqli_error($con));        
        $inserir6="INSERT INTO professor_disciplina(tb_professor_matricula_professor,tb_disciplina_id_disciplina,id_professor_disciplina) VALUES ($matricula,$disciplina,null)";
        $res6 = mysqli_query($con, $inserir6) or die(mysqli_error($con));
        
        }
    }
    if($res1 == 1){
        echo "<script>
    alert('Usuário cadastrado com sucesso')
    window.location='cadastrar_pessoa.php'
    </script>";
    }else{
    echo "<script>
        alert('Erro ao cadastrar, tente novamente.');
        window.location='cadastrar_pessoa.php';
    </script>";
    
    }
    }
    
}
    
}else if ($_GET["acao"] == "atuSenha"){
    $nova_senha = md5($_POST["nova_senha"]);
    $conf_senha = md5($_POST["conf_senha"]);
    if($nova_senha == $conf_senha){
        $upd_senha = "UPDATE tb_usuario SET senha= '".$nova_senha."' WHERE login =".$cpf;
        $result = mysqli_query($con, $upd_senha)or die(mysqli_error($con));
        if($result == 1){
            session_destroy();
            echo "<script>
                alert('Senha atualizada com sucesso.');
                window.location='index.php';
            </script>";
        }else{
            echo "<script>
                alert('Erro ao alterar senha, tente novamente.');
                window.location='alterar_dados.php';
            </script>";

        }
    
    }else{
        echo "<script>
        alert('Os campos Nova senha e Confirmar Nova Senha são diferentes.');
        window.location='alterar_dados.php';
    </script>";
    }
}
//Função pode ser disparada por todo o site 
else if($_GET["acao"] == "solicitarTroca"){

    $sql = "select * from tb_pessoa where cpf_pessoa = ".$cpf;
    $exe = mysqli_query($con, $sql);    
    while($linha = mysqli_fetch_array($exe)){
     $email = $linha["email"];
     $_SESSION["email"] = $linha["email"];     
 }

 $email_envi = $_SESSION["email"];
 $data = date("d/m/Y");
 $minuto = date('H');
 $tudo =$cpf.$data.$minuto;
 $creep = md5($tudo);
 $subject = "Trocar Senha";
 $message ="https://tccteste01.000webhostapp.com/alterar_dados.php?creep=$creep";
 $link= $message;
 $headers = 'From: webescola@gmail.com' . "\r\n" .
     'Reply-To: vitor232596@gmail.com' . "\r\n" .
     'X-Mailer: PHP/' . phpversion();
 
 $send = mail($email_envi, $subject, $link, $headers);
 
 
 if($send == 1){
    echo "<script>
    alert('Foi enviado para seu email um link para trocar sua sennha.');
    window.location='tela_inicial.php';
    </script>";
 }else{
    echo "<script>
    alert('Erro ao tentar trocar a senha, tente novamente mais tarde.');
    window.location='tela_inicial.php';
    </script>";
 }



 }
 //Função disparada na tela index.php
 else if($_GET["acao"] == "esqueciSenha"){
        $login = $_POST["login"];
        $email_verif = $_POST["email"];

        $sql = "select * from tb_pessoa where cpf_pessoa = ".$login;
        $exe = mysqli_query($con, $sql);
        //A SQl tem o intuito de buscar o email vinculado a esse login
        while($linha = mysqli_fetch_array($exe)){
            $email = $linha["email"];
            $_SESSION["email"] = $linha["email"];              
     }
     $email_envi = $_SESSION["email"];
     
     if ($email_verif == $email_envi) { //verifica se o E-mail passado é compatível com o passado no Formulario
        $senha_gerada = rand();
        $senha_trocada = substr($senha_gerada,0,6);
        $creep_senha= md5($senha_trocada);//criptografa senha para mandar para o banco.
        $upd_senha = "UPDATE tb_usuario SET senha= '".$creep_senha."' WHERE login=".$login;
        $result = mysqli_query($con, $upd_senha)or die(mysqli_error($con));
        //envia E-mail com nova senha para o usuario   
        
        $subject = "Sua nova senha";
        $message ="$senha_trocada";
        $link= $message;
        $headers = 'From: webescola@gmail.com' . "\r\n" .
            'Reply-To: vitor232596@gmail.com' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();
        
        $send = mail($email_envi, $subject, $link, $headers);
        
        
        if($send == 1){
            session_destroy();
           echo "<script>
           alert('Foi enviado para seu email sua nova senha, ao logar favor troque sua senha.');
           window.location='index.php';
           </script>";           
        }else{        
            echo "<script>
                alert('Erro , favor tente novamente mais tarde.');
                window.location='index.php';
                </script>";
        }
     }else{
        echo "<script>
           alert('Seu E-mail ou Login não é compatível com o informado no Formulario. Favor preencha os dados corretamente');
           window.location='index.php';
           </script>";
     }

    }
    //Função disparada na tela tela_inicial.php
    else if($_GET["acao"] =="cadDis"){
    $disciplina = $_POST["disciplina"] ;
    
    $inserir="INSERT INTO tb_disciplina(id_disciplina, nome_disciplina) VALUES (NULL, '$disciplina')";
    $res = mysqli_query($con, $inserir) or die(mysqli_error($con));
    if($res == 1){        
        echo "<script>
            alert('Disciplina Cadastrada com Sucesso.');
            window.location='cadastrar_disciplina.php';
            </script>";
    }else{        
        echo "<script>
            alert('Erro , favor tente novamente mais tarde.');
            window.location='cadastrar_disciplina.php';
            </script>";
    }


    }
    //Função disparada na tela cadastrar_turma 
    else if($_GET["acao"] == "cadTurm"){
        $btn_cad = $_POST["cadastrar"];
        $nome_turma = $_POST["nomeTurma"];
        $turno = $_POST["turno"];
        $ano = $_POST["ano"];
        $turma_id = $_POST["id_turma"];
        
        if (isset($_POST['cadastrar'])){

        $sql2 = "select * from tb_turma where turno = '".$turno."' and nome_turma ='".$nome_turma."' and ano ='".$ano."'";
        $exe2 =  mysqli_query($con, $sql2) or die(mysqli_error($con));
        $cont2 = mysqli_num_rows($exe2);
        // A SQL acima verifica se já existe uma turma cadastrada com as caracteristicas enviadas para cá
       if ($cont2 > 0) {
        echo "
        <script>
             alert('Esse nome de turma já está cadastrado')
            window.location='cadastrar_turma.php'
        </script>";

       }else{
        
        $inserir = "INSERT INTO `tb_turma`(`id_turma`, `nome_turma`, `turno`, `ano`) VALUES (null,'$nome_turma','$turno','$ano')";
        $res = mysqli_query($con, $inserir) or die(mysqli_error($con));
        
        if($res == 1){
            echo "<script>
        alert('Turma cadastrada com Sucesso')
        window.location='cadastrar_turma.php'        
        </script>";
        
        }else{
        echo "<script>
            alert('Erro ao cadastrar, tente novamente.');
            window.location='cadastrar_turma.php';
        </script>";
        
        }
    }
}else{
        $upd_turma = "UPDATE `tb_turma` SET `nome_turma`='$nome_turma',`turno`='$turno',`ano`='$ano' WHERE id_turma = '$turma_id'";
        $result = mysqli_query($con, $upd_turma)or die(mysqli_error($con));
        if($result == 1){
            echo "<script>
        alert('Turma atualizada com Sucesso')
        window.location='cadastrar_turma.php'        
        </script>";
        
        }else{
        echo "<script>
            alert('Erro ao atualizar, tente novamente.');
            window.location='cadastrar_turma.php';
        </script>";
        
        }
    }


    }
    //Função disparada na tela aluno_turma.php
    // Vincula o aluno a uma turma
    else if($_GET["acao"] =="cadAlunoTurma"){
    $id_turma = $_POST["turma"];
    $cpf_aluno = $_POST["cpf_aluno"];    
    
    $sql1 = "select * from tb_aluno where tb_pessoa_cpf_pessoa = ".$cpf_aluno;
    $exe1 =  mysqli_query($con, $sql1);

    while($linha = mysqli_fetch_array($exe1)){
        $matricula = $linha["matricula_aluno"];

    }

        $inserir = "INSERT INTO `aluno_turma`(`idaluno_turma`, `tb_aluno_matricula_aluno`, `tb_turma_id_turma`) VALUES (null,'$matricula','$id_turma')";
        $res = mysqli_query($con, $inserir) or die(mysqli_error($con));

        $sql_ano = "SELECT * FROM `ano_letivo` WHERE inicio_ano = 1";
                $exec =  mysqli_query($con, $sql_ano);
                $cont = mysqli_num_rows($exec);
                
                if ($cont > 0) {
                  $buscar_registro = "SELECT idaluno_turma FROM aluno_turma where tb_aluno_matricula_aluno = $matricula";
                  $exect =  mysqli_query($con, $buscar_registro);
                 
                  while($linha = mysqli_fetch_array($exect)){
                    $id_registro = $linha["idaluno_turma"];
            
                }
                $inserir2 = "INSERT INTO aluno_novo(idaluno_novo, aluno_turma_idaluno_turma) VALUES (null,'$id_registro')";
                $rest = mysqli_query($con, $inserir2) or die(mysqli_error($con));
                }


        if($res == 1){           
            echo "<script>
        alert('Aluno alocado a turma com sucesso!')
        window.location='formar_turma.php'
        </script>";
        }else{
        echo "<script>
            alert('Erro, tente novamente mais tarde.');
            window.location='formar_turma.php';
        </script>";
        
        }       
    
    }
    //Função disparada na tela formar_turma.php
    // Tem o objetivo de verificar se o aluno já possui uma turma
    else if($_GET["acao"] =="verificar"){
        $id= $_GET["id"];

    $sql1 = "select * from tb_aluno where tb_pessoa_cpf_pessoa = ".$id;
    $exe1 =  mysqli_query($con, $sql1);

while($linha = mysqli_fetch_array($exe1)){
    $matricula = $linha["matricula_aluno"];
    $_SESSION["matricula"] = $linha["matricula_aluno"];

}
    $matricula_aluno = $_SESSION["matricula"];

    $sql2 = "SELECT * FROM aluno_turma WHERE tb_aluno_matricula_aluno =".$matricula_aluno;
    $exe2 =  mysqli_query($con, $sql2);
    $cont = mysqli_num_rows($exe2);
    if ($cont > 0) {        
        echo "<script>
        alert('Esse aluno já possui uma turma')
        window.location='formar_turma.php'
        </script>";     
    }else{        
        header("Location:aluno_turma.php?id=$id");

    }

    }



    //Função que vincula o professor a uma turma
    else if($_GET["acao"] == "cadProfessorTurma"){

        $id_turma = $_POST["turma"];
        $cpf_professor = $_POST["cpf_professor"];
        
        if (isset($_POST['cadastrar'])){
        $sql1 = "select * from tb_professor where tb_pessoa_cpf_pessoa = ".$cpf_professor;
        $exe1 =  mysqli_query($con, $sql1);
    
        while($linha = mysqli_fetch_array($exe1)){
            $matricula = $linha["matricula_professor"];
            
            }      

        $busca_materia ="SELECT td.id_disciplina from tb_professor as tp
        join professor_disciplina as pd
        on tp.matricula_professor = pd.tb_professor_matricula_professor
        JOIN tb_disciplina as td 
        on pd.tb_disciplina_id_disciplina = td.id_disciplina
        where tp.matricula_professor = $matricula";   
        $exect =  mysqli_query($con, $busca_materia);

        while($linha = mysqli_fetch_array($exect)){
        $id_disciplina = $linha["id_disciplina"];

        }

        $verificacao ="SELECT * from professor_turma as pt
         join tb_professor as tp 
         on pt.tb_professor_matricula_professor = tp.matricula_professor
          join professor_disciplina as pd 
          on tp.matricula_professor = pd.tb_professor_matricula_professor
           JOIN tb_disciplina as td
            on pd.tb_disciplina_id_disciplina = td.id_disciplina
             WHERE tp.matricula_professor != $matricula and pd.tb_disciplina_id_disciplina = $id_disciplina and pt.tb_turma_id_turma = $id_turma";   
        $exec_verif =  mysqli_query($con, $verificacao);
        $cont_verif = mysqli_num_rows($exec_verif);
        
        if ($cont_verif > 0) {
            echo "<script>
                alert('Um professor com essa matéria já dá aula nessa turma!')
                window.location='professores.php'
            </script>";
        }else{
            $sql2 = "SELECT * FROM `professor_turma` WHERE tb_professor_matricula_professor = '$matricula' and tb_turma_id_turma ='$id_turma'";
            $exe2 =  mysqli_query($con, $sql2);
            $cont = mysqli_num_rows($exe2);
            // A SQL  acima serve para indentificar se existe algum resgistro na tabela professor_turma
            // que tenham $matricula_professor e $id_turma, se ouver significa que o professor já dá aula nessa turma
            if ($cont > 0) {        
                echo "<script>
                alert('Esse professor já dá aula nessa turma')            
                window.location.href='professor_turma.php?id=$cpf_professor&mat=$matricula_professor';
                </script>";
                     
            }else{      
                $inserir = "INSERT INTO `professor_turma`(`idprofessor_turma`, `tb_turma_id_turma`, `tb_professor_matricula_professor`) VALUES (null,'$id_turma','$matricula_professor')";
                $res = mysqli_query($con, $inserir) or die(mysqli_error($con));
            
                if($res == 1){
                    echo "<script>
                alert('Professor alocado a turma com sucesso!')
                window.location='professores.php'
                </script>";
                }else{
                echo "<script>
                    alert('Erro, tente novamente mais tarde.');
                    window.location='professores.php';
                </script>";
                
                }   
    
            }
           
        }

        }else{ //Se a pessoa clicar em adicionar professor substituto            
            $sql1 = "select * from tb_professor where tb_pessoa_cpf_pessoa = ".$cpf_professor;
            $exe1 =  mysqli_query($con, $sql1);
    
            while($linha = mysqli_fetch_array($exe1)){
            $matricula = $linha["matricula_professor"];
            
            }
            $sql2 = "SELECT * FROM `professor_turma` WHERE tb_professor_matricula_professor = '$matricula' and tb_turma_id_turma ='$id_turma'";
            $exe2 =  mysqli_query($con, $sql2);
            $cont = mysqli_num_rows($exe2);
            // A SQL  acima serve para indentificar se existe algum resgistro na tabela professor_turma
            // que tenham $matricula_professor e $id_turma, se ouver significa que o professor já dá aula nessa turma
            if ($cont > 0) {        
                echo "<script>
                alert('Esse professor já dá aula nessa turma')            
                window.location.href='professor_turma.php?id=$cpf_professor&mat=$matricula_professor';
                </script>";
            }else{
                $busca_materia ="SELECT td.id_disciplina from tb_professor as tp
                join professor_disciplina as pd
                on tp.matricula_professor = pd.tb_professor_matricula_professor
                JOIN tb_disciplina as td 
                on pd.tb_disciplina_id_disciplina = td.id_disciplina
                where tp.matricula_professor = $matricula";   
                $exect =  mysqli_query($con, $busca_materia);
        
                while($linha = mysqli_fetch_array($exect)){
                $id_disciplina = $linha["id_disciplina"];
        
                }
        
                $verificacao ="SELECT * from professor_turma as pt
                 join tb_professor as tp 
                 on pt.tb_professor_matricula_professor = tp.matricula_professor
                  join professor_disciplina as pd 
                  on tp.matricula_professor = pd.tb_professor_matricula_professor
                   JOIN tb_disciplina as td
                    on pd.tb_disciplina_id_disciplina = td.id_disciplina
                     WHERE tp.matricula_professor != $matricula and pd.tb_disciplina_id_disciplina = $id_disciplina and pt.tb_turma_id_turma = $id_turma";   
                $exec_verif =  mysqli_query($con, $verificacao);
                $cont_verif = mysqli_num_rows($exec_verif);
                
                if ($cont_verif > 0) {
                    echo "<script>
                        alert('Um professor ainda está vinculado a essa turma!')
                        window.location='professores.php'
                    </script>";
                }else{
                    $upd_pauta ="UPDATE `tb_pauta` SET tb_professor_matricula_professor = '$matricula' WHERE tb_turmas_id_turma = '$id_turma' and tb_disciplina_id_disciplina = '$id_disciplina'";
                    $res = mysqli_query($con, $upd_pauta)or die(mysqli_error($con)); 
                    
                    $inserir = "INSERT INTO `professor_turma`(`idprofessor_turma`, `tb_turma_id_turma`, `tb_professor_matricula_professor`) VALUES (null,'$id_turma','$matricula_professor')";
                    $res = mysqli_query($con, $inserir) or die(mysqli_error($con));
    
                    if($res == 1){
                        echo "<script>
                        alert('Professor substituto adicionado com sucesso!');
                        window.location='professores.php';
                    </script>";             
                    }
                }  
            }

            
        }

        }


        //Função da tela professores.php que tem o objetivo de pegar a matricula do professor
        // e mandar para tela professor_turma.php afim de saber as turmas que esse professor dá aula
        else if($_GET["acao"] =="pegarMat"){
            $id= $_GET["id"];
    
        $sql1 = "select * from tb_professor where tb_pessoa_cpf_pessoa = ".$id;
        $exe1 =  mysqli_query($con, $sql1);
    
    while($linha = mysqli_fetch_array($exe1)){
       
        $matricula = $linha["matricula_professor"];
        $_SESSION["matricula"] = $linha["matricula_professor"];
    
    }
        $matricula_professor = $_SESSION["matricula"];
    
                   
            header("Location:professor_turma.php?Turma&id=$id&mat=$matricula_professor");
    
        
    
        }


        //Função ainda incompleta, ela vai Lançar as notas
        else if($_GET["acao"] =="lancarNotas"){
        $matricula_professor = $_POST["matprof"];
        $id_turma = $_POST["idturma"];
        
            $arr_nota1 = array();
            $arr_nota2 = array();
            $arr_nota3 = array();
            $arr_faltas1 = array();
            $arr_faltas2 = array();            
            $arr_faltas3 = array(); 
            $arr_matricula = array();
       
        
        foreach($_POST["alunos"] as $matricula) {
            
            $arr_matricula[] = $matricula;
            
 
         }
        
        
        
        foreach($_POST["nota1"] as $nota1) {
            
             $arr_nota1[] = $nota1;
            
 
         }
        
         
         foreach($_POST["nota2"] as $nota2) {
            
             $arr_nota2[] = $nota2;
            
 
         }
        
         
         foreach($_POST["nota3"] as $nota3) {
            
             $arr_nota3[] = $nota3;
            
 
         }
         foreach($_POST["faltas1"] as $faltas1) {
            
             $arr_faltas1[] = $faltas1;
            
 
         }
         foreach($_POST["faltas2"] as $faltas2) {
            
             $arr_faltas2[] = $faltas2;
            
 
         }
         foreach($_POST["faltas3"] as $faltas3) {
            
             $arr_faltas3[] = $faltas3;
            
 
         }
        
         
        $procurar = "SELECT tp.nota1,tp.nota2,tp.nota3,tp.faltas1,tp.faltas2,tp.faltas3,ta.matricula_aluno,p.nome FROM tb_pauta as tp
        JOIN tb_aluno as ta 
        on tp.tb_aluno_matricula_aluno = ta.matricula_aluno 
        JOIN tb_pessoa as p
        on p.cpf_pessoa = ta.tb_pessoa_cpf_pessoa
        WHERE tp.tb_turmas_id_turma = $id_turma and tb_professor_matricula_professor = $matricula_professor ";
        $res = mysqli_query($con, $procurar);        
        $cont = mysqli_num_rows($res);                            
           
        for ($i=0; $i < $cont ; $i++) { 
            $nota1_upd = $arr_nota1[$i];
            $nota2_upd = $arr_nota2[$i];
            $nota3_upd = $arr_nota3[$i];
            $faltas1_upd = $arr_faltas1[$i];
            $faltas2_upd = $arr_faltas2[$i];
            $faltas3_upd = $arr_faltas3[$i];           
            $matricula_upd = $arr_matricula[$i];

            $upd ="UPDATE `tb_pauta` SET `nota1`='$nota1_upd',`nota2`='$nota2_upd',`nota3`='$nota3_upd',`faltas1`='$faltas1_upd',`faltas2`='$faltas2_upd',`faltas3`='$faltas3_upd' WHERE tb_aluno_matricula_aluno = '$matricula_upd' and tb_professor_matricula_professor = '$matricula_professor'";
            $result = mysqli_query($con, $upd)or die(mysqli_error($con));
            
           
            
        }
        
        if($i == $cont){

            echo "<script>
            alert('Pauta lançada com sucesso!')
            window.location='lancar_notas.php?idTurma=$id_turma'
            </script>";
            
            
            }
                
        }



        // Função que cria a pauta dos alunos da turma com todas as notas e faltas zeradas
        // e depois joga para tela de lançar notas
        else if($_GET["acao"] =="formarPauta"){
        
            $sql1 = "SELECT * FROM `ano_letivo` WHERE inicio_ano = 1";
            $exe1 =  mysqli_query($con, $sql1);
            $cont = mysqli_num_rows($exe1);
            
            if ($cont > 0) {
                $id_turma= $_GET["idTurma"];

                $sql = "SELECT * FROM professor_disciplina WHERE tb_professor_matricula_professor =".$matricula_professor; //Select para conseguir o id da disciplina
                $exe =  mysqli_query($con, $sql);   
                
                while($linha = mysqli_fetch_array($exe)){
                    $id_disciplina = $linha["tb_disciplina_id_disciplina"];
                
                }
        
                $sql2 = "SELECT * FROM `tb_pauta` WHERE tb_turmas_id_turma = '$id_turma' and tb_disciplina_id_disciplina ='$id_disciplina'";
                $exe2 =  mysqli_query($con, $sql2);
                $cont = mysqli_num_rows($exe2);
                //Acima podemos ver um SELECT para saber se a pauta já foi criada
                //Se o $cont for maior que 0 significa que existem regristro na tabela
                //logo a pauta já foi criada
                if ($cont > 0) {        
                   $verif_alunos_novos ="SELECT * from tb_turma as tt
                   join aluno_turma as atu 
                   on tt.id_turma = atu.tb_turma_id_turma
                   JOIN aluno_novo as an 
                   on atu.idaluno_turma = an.aluno_turma_idaluno_turma where tt.id_turma = $id_turma";//saber se foi inserido algum aluno novo nessa turma
                   $exect =  mysqli_query($con,$verif_alunos_novos);   
                   $numero_alunos = mysqli_num_rows($exect);
                   
                   while($linha = mysqli_fetch_array($exect)){
                    $mat_aluno_novo = $linha["tb_aluno_matricula_aluno"];
                    $arr_alunos[] = $mat_aluno_novo; //Aqui guarda a $matricula_aluno no array enquanto tiver registros
                }
                   if ($numero_alunos > 0) {
                    
                    foreach($arr_alunos as $aluno) { // essa função percorre o array fazendo com que cada vez
                            // que o foreach rodar a variável $aluno mude seu valor
                        $existe_pauta = "SELECT * from tb_pauta where tb_aluno_matricula_aluno = $aluno and  tb_professor_matricula_professor = $matricula_professor";
                        $execte =  mysqli_query($con,$existe_pauta);   
                        $verif_pauta = mysqli_num_rows($execte);

                        if ($verif_pauta == 0) {
                            $inserir = "INSERT INTO `tb_pauta`(`nota1`, `nota2`, `nota3`, `tb_professor_matricula_professor`, `tb_turmas_id_turma`, `tb_disciplina_id_disciplina`, `id_pauta`, `tb_aluno_matricula_aluno`, `faltas1`, `faltas2`, `faltas3`)
                            VALUES (0,0,0,'$matricula_professor','$id_turma','$id_disciplina',null,'$aluno',0,0,0)";
                            $res = mysqli_query($con, $inserir) or die(mysqli_error($con));
                        }
                         

                        } 
                    header("Location:lancar_notas.php?idTurma=$id_turma");                    
                   }else{
                    header("Location:lancar_notas.php?idTurma=$id_turma");
                   } 
                }else{
        
                    $sql2 ="SELECT tba.matricula_aluno from aluno_turma as alt
                    JOIN tb_aluno as tba
                     on alt.tb_aluno_matricula_aluno = tba.matricula_aluno
                      JOIN tb_pessoa as tp
                       ON tp.cpf_pessoa = tba.tb_pessoa_cpf_pessoa
                        WHERE alt.tb_turma_id_turma = '$id_turma'";
                    //Acima vemos um SELECT que junta 3 tabelas com intuito de pegar a do aluno
                    //Que está em uma determinada turma    
                    $exe2 =  mysqli_query($con, $sql2);   
                    $arr_alunos = array(); // Esse array é para guardar a matricula de cada aluno
                    
                    while($linha = mysqli_fetch_array($exe2)){
                        $mat_alunos = $linha["matricula_aluno"];                
                        
                        $arr_alunos[] = $mat_alunos; //Aqui guarda a $matricula_aluno no array enquanto tiver registros
            
                        
                    }
            
                    foreach($arr_alunos as $aluno) { // essa função percorre o array fazendo com que cada vez
                                                    // que o foreach rodar a variável $aluno mude seu valor
                     $inserir = "INSERT INTO `tb_pauta`(`nota1`, `nota2`, `nota3`, `tb_professor_matricula_professor`, `tb_turmas_id_turma`, `tb_disciplina_id_disciplina`, `id_pauta`, `tb_aluno_matricula_aluno`, `faltas1`, `faltas2`, `faltas3`)
                                 VALUES (0,0,0,'$matricula_professor','$id_turma','$id_disciplina',null,'$aluno',0,0,0)";
                     $res = mysqli_query($con, $inserir) or die(mysqli_error($con)); 
                       
                     }
                     if($res == 1){
                        header("Location:lancar_notas.php?idTurma=$id_turma");            
                    }else{
                    echo "<script>
                        alert('Essa turma não possui alunos');
                        window.location='tela_inicial.php';
                    </script>";
                    
                    }
        
                }                
            }else{
                echo "<script>
                        alert('O ano letivo ainda não foi iniciado');
                        window.location='tela_inicial.php';
                    </script>";
            }
        

              
        
        }
        else if($_GET["acao"] =="excluirTurma"){
            $id_turma = $_GET["id"];  
            
            $excluir ="DELETE FROM `tb_turma` WHERE id_turma = '$id_turma'";
            $exe =  mysqli_query($con, $excluir);

            if ($exe == 1) {
                echo "<script>
                alert('Turma excluída com sucesso.');
                window.location='cadastrar_turma.php';
            </script>";
            }else{
                echo "<script>
                alert('Erro, pois essa turma pode ter alunos e professores associados   .');
                window.location='cadastrar_turma.php';
                
            </script>";
            }
        }

        else if($_GET["acao"] =="excluirDisc"){
            $id_disciplina = $_GET["id"];  
            
            $excluir ="DELETE FROM `tb_disciplina` WHERE  id_disciplina = '$id_disciplina'";
            $exe =  mysqli_query($con, $excluir);

            if ($exe == 1) {
                echo "<script>
                alert('Disciplina excluída com sucesso.');
                window.location='cadastrar_disciplina.php';
            </script>";
            }else{
                echo "<script>
                alert('Erro, pois essa disciplina pode ter professores associados.');
                window.location='cadastrar_disciplina.php';
                
            </script>";
            }
        }
        
        else if($_GET["acao"] =="excluirDiscdoProf"){
            $id_turma = $_GET["id"];  
            $mat_prof = $_GET["mat"];
            $excluir = "DELETE FROM `professor_turma` WHERE tb_turma_id_turma = '$id_turma' and tb_professor_matricula_professor = '$mat_prof'";
            $exe =  mysqli_query($con, $excluir);

            if ($exe == 1) {
                echo "<script>
                alert('Turma removida do professor com sucesso.');
                window.location='professores.php';
            </script>";
            }else{
                echo "<script>
                alert('Erro, tente novamente mais tarde.');
                window.location='professores.php';
            </script>";
            }
        }

        else if ($_GET["acao"] == "updAlunoTurma"){
            $cpf_aluno = $_POST["cpf_aluno"];
            $nova_turma = $_POST["novaTurma"];
            
            $sql1 = "select * from tb_aluno where tb_pessoa_cpf_pessoa = ".$cpf_aluno;
            $exe1 =  mysqli_query($con, $sql1);
            while($linha = mysqli_fetch_array($exe1)){
                $matricula = $linha["matricula_aluno"];

            }
            $upd_pauta ="UPDATE `tb_pauta` SET tb_turmas_id_turma = '$nova_turma' WHERE tb_aluno_matricula_aluno = '$matricula'";
            $res = mysqli_query($con, $upd_pauta)or die(mysqli_error($con));
            $upd_turma = "UPDATE `aluno_turma` SET `tb_turma_id_turma`='$nova_turma' WHERE tb_aluno_matricula_aluno = '$matricula'";
            $result = mysqli_query($con, $upd_turma)or die(mysqli_error($con));

        if($result == 1){
            echo "<script>
                    alert('Turma do aluno atualizada com Sucesso')
                    window.location='formar_turma.php'        
                </script>";
        
        }else{
        echo "<script>
                alert('Erro ao atualizar, tente novamente.');
                window.location='formar_turma.php';
            </script>";
        
        }
        }

        else if ($_GET["acao"] == "inicAno"){
            
            
                
                $sql1 = "SELECT * FROM `ano_letivo` WHERE inicio_ano = 1";
                $exe1 =  mysqli_query($con, $sql1);
                $cont = mysqli_num_rows($exe1);
                
                if ($cont > 0) {
                    echo "<script>
                        alert('O ano letivo já foi iniciado.');
                        window.location='tela_inicial.php';
                    </script>";
                }else{
                    $inserir = "INSERT INTO `ano_letivo`(`idano_letivo`, `inicio_ano`) VALUES (null,1)";
                    $res = mysqli_query($con, $inserir) or die(mysqli_error($con));
                
                echo "<script>
                    alert('Você iniciou o ano letivo.');
                    window.location='tela_inicial.php';
                </script>";
                
                }
                
             

        }
?>