-- Tabela Pessoa
INSERT INTO `tb_pessoa` (`cpf_pessoa`, `nome`, `rua`, `bairro`, `numero`, `cep`, `email`, `telefone`, `data_nasc`) 
VALUES ('12345678910', 'Vitor Adm', 'asagsg', 'gasg', '36', '451591', 'asdsaf@gmail.com', '999999999999', '2001-06-26');
-- Tabela Usuário
INSERT INTO `tb_usuario` (`id_usuario`, `login`, `senha`, `permissao`, `tb_pessoa_cpf_pessoa`) VALUES (NULL, '12345678910', 'e10adc3949ba59abbe56e057f20f883e', '10', '12345678910');
-- Tabela Disciplina
INSERT INTO `tb_disciplina` (`id_disciplina`, `nome_disciplina`) VALUES
(1, 'LÃ­ngua Portuguesa'),
(2, 'EducaÃ§Ã£o FÃ­sica'),
(3, 'Arte'),
(4, 'Biologia'),
(5, 'FÃ­sica'),
(6, 'QuÃ­mica'),
(7, 'MatemÃ¡tica'),
(8, 'Filosofia'),
(9, 'Geografia'),
(10, 'HistÃ³ria'),
(11, 'Sociologia'),
(12, 'LÃ­ngua Inglesa'),
(13, 'LÃ­ngua Espanhola');