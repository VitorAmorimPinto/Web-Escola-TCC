-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema db_web_escola
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema db_web_escola
-- -----------------------------------------------------
create database db_web_escola;

-- -----------------------------------------------------
-- Table `db_web_escola`.`tb_pessoa`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_web_escola`.`tb_pessoa` (
  `cpf_pessoa` VARCHAR(11) NOT NULL,
  `nome` VARCHAR(45) NOT NULL,
  `rua` VARCHAR(45) NULL,
  `bairro` VARCHAR(45) NULL,
  `numero` VARCHAR(45) NULL,
  `cep` VARCHAR(45) NULL,
  `email` VARCHAR(45) NULL,
  `telefone` VARCHAR(45) NULL,
  `data_nasc` VARCHAR(45) NULL,
  PRIMARY KEY (`cpf_pessoa`),
  UNIQUE INDEX `cpf_pessoa_UNIQUE` (`cpf_pessoa` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_web_escola`.`tb_professor`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_web_escola`.`tb_professor` (
  `matricula_professor` INT(10) NOT NULL,
  `tb_pessoa_cpf_pessoa` VARCHAR(11) NOT NULL,
  PRIMARY KEY (`matricula_professor`),
  INDEX `fk_tb_professor_tb_pessoa1_idx` (`tb_pessoa_cpf_pessoa` ASC),
  CONSTRAINT `fk_tb_professor_tb_pessoa1`
    FOREIGN KEY (`tb_pessoa_cpf_pessoa`)
    REFERENCES `db_web_escola`.`tb_pessoa` (`cpf_pessoa`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_web_escola`.`tb_disciplina`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_web_escola`.`tb_disciplina` (
  `id_disciplina` INT(10) NOT NULL AUTO_INCREMENT,
  `nome_disciplina` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id_disciplina`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_web_escola`.`tb_turma`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_web_escola`.`tb_turma` (
  `id_turma` INT(10) NOT NULL AUTO_INCREMENT,
  `nome_turma` VARCHAR(45) NOT NULL,
  `turno` VARCHAR(45) NOT NULL,
  `ano` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id_turma`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_web_escola`.`tb_usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_web_escola`.`tb_usuario` (
  `id_usuario` INT(10) NOT NULL AUTO_INCREMENT,
  `login` VARCHAR(45) NOT NULL,
  `senha` VARCHAR(45) NOT NULL,
  `permissao` INT(10) NOT NULL,
  `tb_pessoa_cpf_pessoa` VARCHAR(11) NOT NULL,
  PRIMARY KEY (`id_usuario`),
  INDEX `fk_tb_usuario_tb_pessoa1_idx` (`tb_pessoa_cpf_pessoa` ASC),
  CONSTRAINT `fk_tb_usuario_tb_pessoa1`
    FOREIGN KEY (`tb_pessoa_cpf_pessoa`)
    REFERENCES `db_web_escola`.`tb_pessoa` (`cpf_pessoa`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_web_escola`.`professor_disciplina`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_web_escola`.`professor_disciplina` (
  `tb_professor_matricula_professor` INT NOT NULL,
  `tb_disciplina_id_disciplina` INT NOT NULL,
  `id_professor_disciplina` INT NOT NULL AUTO_INCREMENT,
  INDEX `fk_professor_disciplina_tb_professor1_idx` (`tb_professor_matricula_professor` ASC),
  INDEX `fk_professor_disciplina_tb_disciplina1_idx` (`tb_disciplina_id_disciplina` ASC),
  PRIMARY KEY (`id_professor_disciplina`),
  CONSTRAINT `fk_professor_disciplina_tb_professor1`
    FOREIGN KEY (`tb_professor_matricula_professor`)
    REFERENCES `db_web_escola`.`tb_professor` (`matricula_professor`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_professor_disciplina_tb_disciplina1`
    FOREIGN KEY (`tb_disciplina_id_disciplina`)
    REFERENCES `db_web_escola`.`tb_disciplina` (`id_disciplina`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_web_escola`.`tb_aluno`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_web_escola`.`tb_aluno` (
  `matricula_aluno` INT(10) NOT NULL,
  `tb_pessoa_cpf_pessoa` VARCHAR(11) NOT NULL,
  PRIMARY KEY (`matricula_aluno`),
  INDEX `fk_tb_aluno_tb_pessoa1_idx` (`tb_pessoa_cpf_pessoa` ASC),
  CONSTRAINT `fk_tb_aluno_tb_pessoa1`
    FOREIGN KEY (`tb_pessoa_cpf_pessoa`)
    REFERENCES `db_web_escola`.`tb_pessoa` (`cpf_pessoa`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_web_escola`.`tb_pauta`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_web_escola`.`tb_pauta` (
  `nota1` FLOAT(3) NOT NULL,
  `nota2` FLOAT(3) NOT NULL,
  `nota3` FLOAT(3) NOT NULL,
  `tb_professor_matricula_professor` INT NOT NULL,
  `tb_turmas_id_turma` INT NOT NULL,
  `tb_disciplina_id_disciplina` INT NOT NULL,
  `id_pauta` INT(10) NOT NULL AUTO_INCREMENT,
  `tb_aluno_matricula_aluno` INT(10) NOT NULL,  
  `faltas1` INT(4) NOT NULL,
  `faltas2` INT(3) NOT NULL,
  `faltas3` INT(3) NOT NULL,
  INDEX `fk_tb_tudo_tb_professor1_idx` (`tb_professor_matricula_professor` ASC),
  INDEX `fk_tb_tudo_tb_turmas1_idx` (`tb_turmas_id_turma` ASC),
  INDEX `fk_tb_tudo_tb_disciplina1_idx` (`tb_disciplina_id_disciplina` ASC),
  PRIMARY KEY (`id_pauta`),
  INDEX `fk_tb_pauta_tb_aluno1_idx` (`tb_aluno_matricula_aluno` ASC),
  CONSTRAINT `fk_tb_tudo_tb_professor1`
    FOREIGN KEY (`tb_professor_matricula_professor`)
    REFERENCES `db_web_escola`.`tb_professor` (`matricula_professor`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tb_tudo_tb_turmas1`
    FOREIGN KEY (`tb_turmas_id_turma`)
    REFERENCES `db_web_escola`.`tb_turma` (`id_turma`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tb_tudo_tb_disciplina1`
    FOREIGN KEY (`tb_disciplina_id_disciplina`)
    REFERENCES `db_web_escola`.`tb_disciplina` (`id_disciplina`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tb_pauta_tb_aluno1`
    FOREIGN KEY (`tb_aluno_matricula_aluno`)
    REFERENCES `db_web_escola`.`tb_aluno` (`matricula_aluno`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_web_escola`.`tb_gerar`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_web_escola`.`tb_gerar` (
  `id_gerar` INT NOT NULL AUTO_INCREMENT,
  `tb_pessoa_cpf_pessoa` VARCHAR(11) NOT NULL,
  PRIMARY KEY (`id_gerar`),
  INDEX `fk_tb_gerar_tb_pessoa1_idx` (`tb_pessoa_cpf_pessoa` ASC),
  CONSTRAINT `fk_tb_gerar_tb_pessoa1`
    FOREIGN KEY (`tb_pessoa_cpf_pessoa`)
    REFERENCES `db_web_escola`.`tb_pessoa` (`cpf_pessoa`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;
-- -----------------------------------------------------
-- Table `db_web_escola`.`aluno_turma`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_web_escola`.`aluno_turma` ( 
  `idaluno_turma` INT NOT NULL AUTO_INCREMENT,
  `tb_aluno_matricula_aluno` INT(10) NOT NULL,
  `tb_turma_id_turma` INT(10) NOT NULL, PRIMARY KEY (`idaluno_turma`),
   INDEX `fk_aluno_turma_tb_aluno1_idx` (`tb_aluno_matricula_aluno` ASC),
   INDEX `fk_aluno_turma_tb_turma1_idx` (`tb_turma_id_turma` ASC),
   CONSTRAINT `fk_aluno_turma_tb_aluno1`
    FOREIGN KEY (`tb_aluno_matricula_aluno`)
    REFERENCES `db_web_escola`.`tb_aluno` (`matricula_aluno`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
   CONSTRAINT `fk_aluno_turma_tb_turma1`
    FOREIGN KEY (`tb_turma_id_turma`) 
    REFERENCES `db_web_escola`.`tb_turma` (`id_turma`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
   ENGINE = InnoDB;
-- -----------------------------------------------------
-- Table `db_web_escola`.`professor_turma`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_web_escola`.`professor_turma` (
  `idprofessor_turma` INT NOT NULL AUTO_INCREMENT,
  `tb_turma_id_turma` INT(10) NOT NULL,
  `tb_professor_matricula_professor` INT(10) NOT NULL,
  PRIMARY KEY (`idprofessor_turma`),
  INDEX `fk_professor_turma_tb_turma1_idx` (`tb_turma_id_turma` ASC),
  INDEX `fk_professor_turma_tb_professor1_idx` (`tb_professor_matricula_professor` ASC),
  CONSTRAINT `fk_professor_turma_tb_turma1`
    FOREIGN KEY (`tb_turma_id_turma`)
    REFERENCES `db_web_escola`.`tb_turma` (`id_turma`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_professor_turma_tb_professor1`
    FOREIGN KEY (`tb_professor_matricula_professor`)
    REFERENCES `db_web_escola`.`tb_professor` (`matricula_professor`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;
-- -----------------------------------------------------
-- Table `db_web_escola`.`ano_letivo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_web_escola`.`ano_letivo` (
  `idano_letivo` INT NOT NULL AUTO_INCREMENT,
  `inicio_ano` INT(1) NOT NULL,
  PRIMARY KEY (`idano_letivo`))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `db_web_escola`.`aluno_novo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_web_escola`.`aluno_novo` (
  `idaluno_novo` INT NOT NULL AUTO_INCREMENT,
  `aluno_turma_idaluno_turma` INT NOT NULL,
  PRIMARY KEY (`idaluno_novo`),
  INDEX `fk_aluno_novo_aluno_turma1_idx` (`aluno_turma_idaluno_turma` ASC),
  CONSTRAINT `fk_aluno_novo_aluno_turma1`
    FOREIGN KEY (`aluno_turma_idaluno_turma`)
    REFERENCES `db_web_escola`.`aluno_turma` (`idaluno_turma`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
