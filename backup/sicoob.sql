-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: 18-Set-2020 às 08:24
-- Versão do servidor: 5.7.26
-- versão do PHP: 7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sicoob`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `activities`
--

DROP TABLE IF EXISTS `activities`;
CREATE TABLE IF NOT EXISTS `activities` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descricao` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `id_usuario` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `activities_id_usuario_foreign` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `arquivos`
--

DROP TABLE IF EXISTS `arquivos`;
CREATE TABLE IF NOT EXISTS `arquivos` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tipo` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `endereco` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `cli_associados`
--

DROP TABLE IF EXISTS `cli_associados`;
CREATE TABLE IF NOT EXISTS `cli_associados` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_sisbr` int(11) NOT NULL,
  `nome` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `nome_fantasia` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `documento` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nivel_risco` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `renda` double NOT NULL,
  `bens` double NOT NULL,
  `nivel_crl` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data_crl` date NOT NULL,
  `cod_cnae` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data_nascimento` date NOT NULL,
  `atividade_economica` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sexo` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sigla` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `funcionario` tinyint(1) NOT NULL,
  `data_relacionamento` date NOT NULL,
  `data_atualizacao` date NOT NULL,
  `data_movimento` date NOT NULL,
  `PA` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cli_associados_id_sisbr_unique` (`id_sisbr`),
  UNIQUE KEY `cli_associados_documento_unique` (`documento`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `cli_associados`
--

INSERT INTO `cli_associados` (`id`, `id_sisbr`, `nome`, `nome_fantasia`, `documento`, `nivel_risco`, `renda`, `bens`, `nivel_crl`, `data_crl`, `cod_cnae`, `data_nascimento`, `atividade_economica`, `sexo`, `sigla`, `funcionario`, `data_relacionamento`, `data_atualizacao`, `data_movimento`, `PA`, `created_at`, `updated_at`) VALUES
(1, 99999, 'Administrador Master', 'Administrador do sistema', '12345678912', 'AA', 0, 0, 'R1', '2020-01-01', '-2', '2020-01-01', 'MANUTENCAO NO SISTEMA', 'M', 'PJ', 1, '2020-01-01', '2020-01-01', '2020-01-01', 'SEDE PIRAPORA', NULL, NULL),
(2, 99998, 'Pedro Henrique dos Santos Oliveira', 'Pedro Henrique dos Santos Oliveira', '12345678911', 'AA', 0, 0, 'R1', '2020-01-01', '-2', '2020-01-01', 'MANUTENCAO NO SISTEMA', 'M', 'PJ', 1, '2020-01-01', '2020-01-01', '2020-01-01', 'SEDE PIRAPORA', NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `cli_emails`
--

DROP TABLE IF EXISTS `cli_emails`;
CREATE TABLE IF NOT EXISTS `cli_emails` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tipo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `data_movimento` date NOT NULL,
  `cli_id_associado` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cli_emails_cli_id_associado_foreign` (`cli_id_associado`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `cli_emails`
--

INSERT INTO `cli_emails` (`id`, `tipo`, `email`, `data_movimento`, `cli_id_associado`, `created_at`, `updated_at`) VALUES
(58, 'principal', 'oliveira@sicoobsertaominas.com.br', '2020-09-14', 2, '2020-09-14 17:38:19', '2020-09-14 17:38:19'),
(59, 'outros', 'brenno_cmm@hotmail.com', '2020-09-14', 1, '2020-09-14 21:34:27', '2020-09-16 23:15:59'),
(60, 'outros', 'breno.miranda@sicoobsertaominas.com.br', '2020-09-15', 1, '2020-09-15 20:28:37', '2020-09-16 23:15:59'),
(61, 'outros', 'brenno_cmm@hotmail.com', '2020-09-16', 1, '2020-09-16 14:48:40', '2020-09-16 23:15:59'),
(62, 'outros', 'brenno_cmm@hotmail.com', '2020-09-16', 1, '2020-09-16 15:54:36', '2020-09-16 23:15:59'),
(63, 'outros', 'brenno_cmm@hotmail.com', '2020-09-16', 1, '2020-09-16 21:09:46', '2020-09-16 23:15:59'),
(64, 'principal', 'breno.miranda@sicoobsertaominas.com.br', '2020-09-16', 1, '2020-09-16 23:15:59', '2020-09-16 23:15:59');

-- --------------------------------------------------------

--
-- Estrutura da tabela `cli_enderecos`
--

DROP TABLE IF EXISTS `cli_enderecos`;
CREATE TABLE IF NOT EXISTS `cli_enderecos` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `rua` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `bairro` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `numero` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `complemento` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `cidade` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pais` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data_movimento` date NOT NULL,
  `cli_id_associado` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cli_enderecos_cli_id_associado_foreign` (`cli_id_associado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `cli_telefones`
--

DROP TABLE IF EXISTS `cli_telefones`;
CREATE TABLE IF NOT EXISTS `cli_telefones` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tipo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `numero` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data_movimento` date NOT NULL,
  `cli_id_associado` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cli_telefones_cli_id_associado_foreign` (`cli_id_associado`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `cli_telefones`
--

INSERT INTO `cli_telefones` (`id`, `tipo`, `numero`, `data_movimento`, `cli_id_associado`, `created_at`, `updated_at`) VALUES
(4, 'outros', '(38) 99168-0335', '2020-09-14', 1, '2020-09-14 14:10:45', '2020-09-16 23:15:59'),
(15, 'outros', '(38) 99114-6061', '2020-09-14', 2, '2020-09-14 15:01:37', '2020-09-14 17:38:19'),
(21, 'outros', '(38) 99168-0335', '2020-09-14', 1, '2020-09-14 15:45:41', '2020-09-16 23:15:59'),
(22, 'outros', '(38) 99114-6061', '2020-09-14', 2, '2020-09-14 17:32:57', '2020-09-14 17:38:19'),
(23, 'outros', '(38) 99114-6061', '2020-09-14', 2, '2020-09-14 17:33:22', '2020-09-14 17:38:19'),
(24, 'principal', '(38) 99114-6061', '2020-09-14', 2, '2020-09-14 17:38:19', '2020-09-14 17:38:19'),
(25, 'outros', '(38) 99168-0335', '2020-09-14', 1, '2020-09-14 21:34:27', '2020-09-16 23:15:59'),
(26, 'outros', '(38) 99168-0335', '2020-09-15', 1, '2020-09-15 20:28:37', '2020-09-16 23:15:59'),
(27, 'outros', '(38) 99168-0335', '2020-09-16', 1, '2020-09-16 14:48:40', '2020-09-16 23:15:59'),
(28, 'outros', '(38) 99168-0335', '2020-09-16', 1, '2020-09-16 15:54:36', '2020-09-16 23:15:59'),
(29, 'outros', '(38) 99168-0335', '2020-09-16', 1, '2020-09-16 21:09:46', '2020-09-16 23:15:59'),
(30, 'principal', '(38) 99168-0335', '2020-09-16', 1, '2020-09-16 23:15:59', '2020-09-16 23:15:59');

-- --------------------------------------------------------

--
-- Estrutura da tabela `cog_emails`
--

DROP TABLE IF EXISTS `cog_emails`;
CREATE TABLE IF NOT EXISTS `cog_emails` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `email_chamado` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_material` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_contrato` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `assunto_chamado` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abertura_chamado` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `fechamento_chamado` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `assunto_material` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abertura_solicitacao_material` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `fechamento_solicitacao_material` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `assunto_contrato` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abertura_solicitacao_contrato` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `fechamento_solicitacao_contrato` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `cog_emails`
--

INSERT INTO `cog_emails` (`id`, `email_chamado`, `email_material`, `email_contrato`, `assunto_chamado`, `abertura_chamado`, `fechamento_chamado`, `assunto_material`, `abertura_solicitacao_material`, `fechamento_solicitacao_material`, `assunto_contrato`, `abertura_solicitacao_contrato`, `fechamento_solicitacao_contrato`, `created_at`, `updated_at`) VALUES
(1, 'ti@sicoobsertaominas.com.br', 'ti@sicoobsertaominas.com.br', 'credito@sicoobsertaominas.com.br', 'Seu chamado foi aberto :)', 'Seu chamado foi aberto com sucesso!', 'Seu chamado foi finalizado com sucesso!', 'Recebemos sua solicitação =)', 'Sua solicitação foi recebida! Aguarde até que seja aprovada.', 'Sua solicitação foi aprovada!', 'Recebemos sua solicitação =)', 'Sua solicitação foi recebida! Aguarde até que seja aprovada.', 'Sua solicitação foi aprovada!', NULL, '2020-09-17 19:18:16');

-- --------------------------------------------------------

--
-- Estrutura da tabela `cre_armarios`
--

DROP TABLE IF EXISTS `cre_armarios`;
CREATE TABLE IF NOT EXISTS `cre_armarios` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `referencia` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `cre_armarios`
--

INSERT INTO `cre_armarios` (`id`, `nome`, `referencia`, `status`, `created_at`, `updated_at`) VALUES
(1, 'EMPRESTIMOS PIRAPORA (A-D)', 'AR01-GA01', 1, '2020-09-14 18:19:44', '2020-09-14 20:47:00'),
(2, 'EMPRESTIMOS PIRAPORA (E-I)', 'AR01-GA02', 1, '2020-09-14 18:21:41', '2020-09-14 20:47:12'),
(3, 'EMPRESTIMOS PIRAPORA (J-Q)', 'AR01-GA03', 1, '2020-09-14 20:47:23', '2020-09-14 20:47:23'),
(4, 'EMPRESTIMOS PIRAPORA (R-Z)', 'AR01-GA04', 1, '2020-09-14 20:47:33', '2020-09-14 20:47:33');

-- --------------------------------------------------------

--
-- Estrutura da tabela `cre_avalistas`
--

DROP TABLE IF EXISTS `cre_avalistas`;
CREATE TABLE IF NOT EXISTS `cre_avalistas` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `cli_id_associado` int(10) UNSIGNED NOT NULL,
  `cre_id_contrato` int(10) UNSIGNED NOT NULL,
  `data_movimento` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cre_avalistas_cli_id_associado_foreign` (`cli_id_associado`),
  KEY `cre_avalistas_cre_id_contrato_foreign` (`cre_id_contrato`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `cre_contratos`
--

DROP TABLE IF EXISTS `cre_contratos`;
CREATE TABLE IF NOT EXISTS `cre_contratos` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `num_contrato` int(11) NOT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `data_operacao` date NOT NULL,
  `data_vencimento` date NOT NULL,
  `valor_contrato` double NOT NULL,
  `renegociacao` tinyint(1) DEFAULT NULL,
  `renegociacao_contrato` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `observacoes` text COLLATE utf8mb4_unicode_ci,
  `cli_id_associado` int(10) UNSIGNED NOT NULL,
  `cre_id_modalidades` int(10) UNSIGNED NOT NULL,
  `cre_id_finalidades` int(10) UNSIGNED NOT NULL,
  `cre_id_produtos` int(10) UNSIGNED NOT NULL,
  `cre_id_armarios` int(10) UNSIGNED NOT NULL,
  `data_movimento` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `nivel_risco` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `taxa_operacao` double DEFAULT NULL,
  `taxa_mora` double DEFAULT NULL,
  `taxa_multa` double DEFAULT NULL,
  `valor_devido` double DEFAULT NULL,
  `qtd_parcelas` int(11) DEFAULT NULL,
  `qtd_parcelas_pagas` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cre_contratos_num_contrato_unique` (`num_contrato`),
  KEY `cre_contratos_cli_id_associado_foreign` (`cli_id_associado`),
  KEY `cre_contratos_cre_id_modalidades_foreign` (`cre_id_modalidades`),
  KEY `cre_contratos_cre_id_finalidades_foreign` (`cre_id_finalidades`),
  KEY `cre_contratos_cre_id_produtos_foreign` (`cre_id_produtos`),
  KEY `cre_contratos_cre_id_armarios_foreign` (`cre_id_armarios`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `cre_finalidades`
--

DROP TABLE IF EXISTS `cre_finalidades`;
CREATE TABLE IF NOT EXISTS `cre_finalidades` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `cre_finalidades`
--

INSERT INTO `cre_finalidades` (`id`, `nome`, `status`, `created_at`, `updated_at`) VALUES
(1, 'TESTE', 1, '2020-09-14 19:34:22', '2020-09-14 20:43:45');

-- --------------------------------------------------------

--
-- Estrutura da tabela `cre_garantias`
--

DROP TABLE IF EXISTS `cre_garantias`;
CREATE TABLE IF NOT EXISTS `cre_garantias` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tipo` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descricao` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `cre_id_contrato` int(10) UNSIGNED NOT NULL,
  `data_movimento` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cre_garantias_cre_id_contrato_foreign` (`cre_id_contrato`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `cre_modalidades`
--

DROP TABLE IF EXISTS `cre_modalidades`;
CREATE TABLE IF NOT EXISTS `cre_modalidades` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `codigo` int(11) NOT NULL,
  `sigla` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `cre_modalidades`
--

INSERT INTO `cre_modalidades` (`id`, `nome`, `codigo`, `sigla`, `status`, `created_at`, `updated_at`) VALUES
(1, 'CONSIGNADO CRÉDITO PESSOAL', 10, 'CCCP', 1, '2020-09-14 18:50:00', '2020-09-14 20:43:27');

-- --------------------------------------------------------

--
-- Estrutura da tabela `cre_produtos`
--

DROP TABLE IF EXISTS `cre_produtos`;
CREATE TABLE IF NOT EXISTS `cre_produtos` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `codigo` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `cre_produtos`
--

INSERT INTO `cre_produtos` (`id`, `nome`, `codigo`, `status`, `created_at`, `updated_at`) VALUES
(1, 'CONTA CORRENTE', 3, 1, '2020-09-14 20:38:31', '2020-09-14 20:38:31'),
(2, 'CRÉDITO RURAL', 6, 1, '2020-09-14 20:38:42', '2020-09-14 20:38:42'),
(3, 'EMPRÉSTIMO', 7, 1, '2020-09-14 20:38:56', '2020-09-14 20:38:56'),
(4, 'TITULOS DESCONTADOS', 8, 1, '2020-09-14 20:39:06', '2020-09-14 20:39:06'),
(5, 'PREJUÍZO', 52, 1, '2020-09-14 20:39:15', '2020-09-14 20:41:57');

-- --------------------------------------------------------

--
-- Estrutura da tabela `cre_solicitacoes`
--

DROP TABLE IF EXISTS `cre_solicitacoes`;
CREATE TABLE IF NOT EXISTS `cre_solicitacoes` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `observacoes` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('aberto','entregue','devolvido') COLLATE utf8mb4_unicode_ci NOT NULL,
  `usr_id_usuario` int(10) UNSIGNED NOT NULL,
  `cre_id_contratos` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cre_solicitacoes_usr_id_usuario_foreign` (`usr_id_usuario`),
  KEY `cre_solicitacoes_cre_id_contratos_foreign` (`cre_id_contratos`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `gti_ativos`
--

DROP TABLE IF EXISTS `gti_ativos`;
CREATE TABLE IF NOT EXISTS `gti_ativos` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `n_patrimonio` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `serialNumber` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nome` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `marca` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `modelo` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descricao` text COLLATE utf8mb4_unicode_ci,
  `id_setor` int(10) UNSIGNED NOT NULL,
  `id_imagem` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `gti_ativos_id_setor_foreign` (`id_setor`),
  KEY `gti_ativos_id_imagem_foreign` (`id_imagem`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `gti_ativos`
--

INSERT INTO `gti_ativos` (`id`, `n_patrimonio`, `serialNumber`, `nome`, `marca`, `modelo`, `descricao`, `id_setor`, `id_imagem`, `created_at`, `updated_at`) VALUES
(1, '01.0000043', 'EDFS5412', 'MONITOR LED 24´ WIDESCREEN CURVO', 'SAMSUNG', 'LC24F390FHLMZD', 'INFORME A DESCRIÇÃO - VIDE EXEMPLO: VOSTRO 14 - 5481; PROCESSADOR INTEL CORE I5-8265; 8GB DE MEMÓRIA RAM; SSD 256GB; FONTE/CARREGADOR 100~240V 19.5V-3.34A 65W; WINDOWS 10 PROFESSIONAL 64 BITS', 1, 12, '2020-06-23 14:44:39', '2020-06-23 18:19:11'),
(3, '01.00000042', '546A5S4D34', 'COMPUTADOR DESKTOP COMPLETO', 'SPACE', '25329', 'COMPUTADOR DESKTOP COMPLETO COM MONITOR 19.5\" INTEL CORE I5 8GB HD 3TB HDMI FULLHD CORPC SPACE', 1, 17, '2020-06-23 18:52:44', '2020-06-23 18:52:44');

-- --------------------------------------------------------

--
-- Estrutura da tabela `gti_ativos_has_imagens`
--

DROP TABLE IF EXISTS `gti_ativos_has_imagens`;
CREATE TABLE IF NOT EXISTS `gti_ativos_has_imagens` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_ativo` int(10) UNSIGNED NOT NULL,
  `id_imagem` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `gti_ativos_has_imagens_id_ativo_foreign` (`id_ativo`),
  KEY `gti_ativos_has_imagens_id_imagem_foreign` (`id_imagem`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `gti_ativos_has_imagens`
--

INSERT INTO `gti_ativos_has_imagens` (`id`, `id_ativo`, `id_imagem`, `created_at`, `updated_at`) VALUES
(39, 3, 15, '2020-06-23 19:12:04', '2020-06-23 19:12:04'),
(40, 3, 16, '2020-06-23 19:12:04', '2020-06-23 19:12:04'),
(41, 1, 2, '2020-06-23 19:12:44', '2020-06-23 19:12:44'),
(42, 1, 3, '2020-06-23 19:12:44', '2020-06-23 19:12:44'),
(43, 1, 4, '2020-06-23 19:12:44', '2020-06-23 19:12:44'),
(44, 1, 5, '2020-06-23 19:12:44', '2020-06-23 19:12:44'),
(45, 1, 6, '2020-06-23 19:12:44', '2020-06-23 19:12:44'),
(46, 1, 7, '2020-06-23 19:12:44', '2020-06-23 19:12:44');

-- --------------------------------------------------------

--
-- Estrutura da tabela `gti_ativos_has_usuarios`
--

DROP TABLE IF EXISTS `gti_ativos_has_usuarios`;
CREATE TABLE IF NOT EXISTS `gti_ativos_has_usuarios` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `dataDevolucao` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dataRecebimento` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gti_id_ativos` int(10) UNSIGNED NOT NULL,
  `usr_id_usuarios` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `gti_ativos_has_usuarios_gti_id_ativos_foreign` (`gti_id_ativos`),
  KEY `gti_ativos_has_usuarios_usr_id_usuarios_foreign` (`usr_id_usuarios`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `gti_ativos_has_usuarios`
--

INSERT INTO `gti_ativos_has_usuarios` (`id`, `dataDevolucao`, `dataRecebimento`, `gti_id_ativos`, `usr_id_usuarios`, `created_at`, `updated_at`) VALUES
(1, '2020-06-23 16:12:44', '2020-06-23 11:44:39', 1, 1, '2020-06-23 14:44:39', '2020-06-23 19:12:44'),
(4, '2020-06-23 16:12:04', '2020-06-23 15:56:58', 3, 2, '2020-06-23 18:56:58', '2020-06-23 19:12:04'),
(6, NULL, '2020-06-23 16:12:44', 1, 2, '2020-06-23 19:12:44', '2020-06-23 19:12:44');

-- --------------------------------------------------------

--
-- Estrutura da tabela `gti_chamados`
--

DROP TABLE IF EXISTS `gti_chamados`;
CREATE TABLE IF NOT EXISTS `gti_chamados` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `assunto` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descricao` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `prioridade` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avaliacao` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gti_id_tipos` int(10) UNSIGNED NOT NULL,
  `gti_id_fontes` int(10) UNSIGNED NOT NULL,
  `usr_id_usuarios` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `gti_chamados_gti_id_tipos_foreign` (`gti_id_tipos`),
  KEY `gti_chamados_gti_id_fontes_foreign` (`gti_id_fontes`),
  KEY `gti_chamados_usr_id_usuarios_foreign` (`usr_id_usuarios`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `gti_chamados`
--

INSERT INTO `gti_chamados` (`id`, `assunto`, `descricao`, `prioridade`, `avaliacao`, `gti_id_tipos`, `gti_id_fontes`, `usr_id_usuarios`, `created_at`, `updated_at`) VALUES
(1, 'Apenas teste', 'APENAS TESTE', NULL, NULL, 1, 1, 2, '2020-06-23 20:17:54', '2020-06-23 20:17:54'),
(2, 'Apenas teste', 'APENAS TESTE', NULL, NULL, 1, 1, 2, '2020-06-24 20:17:54', '2020-06-24 20:17:54'),
(3, 'asd', 'ASDASD', NULL, NULL, 4, 3, 2, '2020-08-03 18:02:41', '2020-08-03 18:02:41'),
(4, 'Teste1409', 'TESTE 1409', NULL, NULL, 1, 1, 2, '2020-09-14 19:45:22', '2020-09-14 19:45:22');

-- --------------------------------------------------------

--
-- Estrutura da tabela `gti_chamados_has_arquivos`
--

DROP TABLE IF EXISTS `gti_chamados_has_arquivos`;
CREATE TABLE IF NOT EXISTS `gti_chamados_has_arquivos` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `gti_id_chamados` int(10) UNSIGNED NOT NULL,
  `id_arquivo` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `gti_chamados_has_arquivos_gti_id_chamados_foreign` (`gti_id_chamados`),
  KEY `gti_chamados_has_arquivos_id_arquivo_foreign` (`id_arquivo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `gti_chamados_has_imagens`
--

DROP TABLE IF EXISTS `gti_chamados_has_imagens`;
CREATE TABLE IF NOT EXISTS `gti_chamados_has_imagens` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `gti_id_chamados` int(10) UNSIGNED NOT NULL,
  `id_imagem` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `gti_chamados_has_imagens_gti_id_chamados_foreign` (`gti_id_chamados`),
  KEY `gti_chamados_has_imagens_id_imagem_foreign` (`id_imagem`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `gti_chamados_has_imagens`
--

INSERT INTO `gti_chamados_has_imagens` (`id`, `gti_id_chamados`, `id_imagem`, `created_at`, `updated_at`) VALUES
(1, 1, 20, '2020-06-23 20:17:54', '2020-06-23 20:17:54'),
(2, 1, 21, '2020-06-23 20:17:54', '2020-06-23 20:17:54'),
(3, 1, 22, '2020-06-23 20:17:54', '2020-06-23 20:17:54'),
(4, 1, 23, '2020-06-23 20:17:54', '2020-06-23 20:17:54'),
(5, 1, 24, '2020-06-23 20:17:54', '2020-06-23 20:17:54'),
(6, 1, 25, '2020-06-23 20:17:54', '2020-06-23 20:17:54'),
(7, 1, 26, '2020-06-23 20:17:54', '2020-06-23 20:17:54'),
(8, 1, 27, '2020-06-23 20:17:54', '2020-06-23 20:17:54'),
(9, 1, 28, '2020-06-23 20:17:54', '2020-06-23 20:17:54'),
(10, 1, 29, '2020-06-23 20:17:54', '2020-06-23 20:17:54'),
(11, 1, 30, '2020-06-23 20:17:54', '2020-06-23 20:17:54'),
(12, 1, 31, '2020-06-23 20:17:54', '2020-06-23 20:17:54'),
(13, 1, 32, '2020-06-23 20:17:54', '2020-06-23 20:17:54'),
(14, 1, 33, '2020-06-23 20:17:54', '2020-06-23 20:17:54'),
(15, 1, 34, '2020-06-23 20:17:54', '2020-06-23 20:17:54'),
(16, 1, 35, '2020-06-23 20:17:54', '2020-06-23 20:17:54'),
(17, 1, 36, '2020-06-23 20:17:54', '2020-06-23 20:17:54');

-- --------------------------------------------------------

--
-- Estrutura da tabela `gti_fontes`
--

DROP TABLE IF EXISTS `gti_fontes`;
CREATE TABLE IF NOT EXISTS `gti_fontes` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descricao` text COLLATE utf8mb4_unicode_ci,
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `gti_fontes`
--

INSERT INTO `gti_fontes` (`id`, `nome`, `descricao`, `status`, `created_at`, `updated_at`) VALUES
(1, 'SISBR 2.0', 'PRINCIPAL PLATAFORMA DE PROCESSOS DA REDE SICOOB.', 1, '2020-06-23 20:17:10', '2020-09-10 15:50:48'),
(2, 'SISBR 3.0', 'PLATAFORMA COMPLEMENTAR AO SISBR 2.0, ONDE SE TEM ACESSO ATRAVÉS DOS NAVEGADORES DO COMPUTADOR.', 1, '2020-06-24 14:47:02', '2020-09-10 15:51:23'),
(3, 'CITRIX', 'PLATAFORMA DE ANTIGA UTILIZADA NA EXECUÇÃO DE PROCESSOS INTERNOS DO SICOOB', 1, '2020-06-24 14:48:08', '2020-09-10 15:52:56'),
(4, 'SICOOB SERVIÇOS', 'PLATAFORMA DESENVOLVIDA PARA AUXILIAR NOS PROCESSOS INTERNOS DO SICOOB SERTÃO MINAS.', 1, '2020-06-24 14:48:20', '2020-09-10 15:50:19'),
(5, 'HARDWARE', 'É A PARTE FÍSICA DO COMPUTADOR, OU SEJA, PEÇAS E EQUIPAMENTOS QUE FAZEM O COMPUTADOR FUNCIONAR', 1, '2020-06-24 14:48:30', '2020-09-10 15:49:07'),
(6, 'PACOTE OFFICE', 'APLICAÇÕES DA MICROSOFT UTILIZADA PARA ESCRITÓRIO, COMO EXCEL, WORD, POWER BI E ENTRE OUTROS', 1, '2020-06-24 14:48:40', '2020-09-10 15:49:47');

-- --------------------------------------------------------

--
-- Estrutura da tabela `gti_homepage`
--

DROP TABLE IF EXISTS `gti_homepage`;
CREATE TABLE IF NOT EXISTS `gti_homepage` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `titulo` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subtitulo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `endereco` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_imagem` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `gti_homepage_id_imagem_foreign` (`id_imagem`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `gti_homepage`
--

INSERT INTO `gti_homepage` (`id`, `titulo`, `subtitulo`, `endereco`, `id_imagem`, `created_at`, `updated_at`) VALUES
(1, 'SICOOB SERTÃO MINAS', 'WEBSITE', 'www.sicoobsertaominas.com.br', 19, '2020-06-23 19:42:27', '2020-06-24 14:03:34'),
(2, 'CITRIX', 'WEB SITE', '172.16.2.188', 37, '2020-06-24 14:18:00', '2020-06-24 14:18:00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `gti_status`
--

DROP TABLE IF EXISTS `gti_status`;
CREATE TABLE IF NOT EXISTS `gti_status` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tempo` time NOT NULL,
  `color` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `open` tinyint(1) NOT NULL,
  `finish` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `gti_status`
--

INSERT INTO `gti_status` (`id`, `nome`, `tempo`, `color`, `status`, `open`, `finish`, `created_at`, `updated_at`) VALUES
(1, 'Em aberto', '01:00:00', '#33da11', 1, 1, 0, '2020-06-23 20:14:22', '2020-06-23 20:14:22'),
(2, 'Em andamento', '01:00:00', '#f79a0e', 1, 0, 0, '2020-06-23 20:16:14', '2020-06-23 20:16:14'),
(3, 'Finalizado', '00:00:00', '#f80a06', 1, 0, 1, '2020-06-23 20:16:32', '2020-06-23 20:16:32');

-- --------------------------------------------------------

--
-- Estrutura da tabela `gti_status_has_chamados`
--

DROP TABLE IF EXISTS `gti_status_has_chamados`;
CREATE TABLE IF NOT EXISTS `gti_status_has_chamados` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `descricao` text COLLATE utf8mb4_unicode_ci,
  `gti_id_chamados` int(10) UNSIGNED NOT NULL,
  `gti_id_status` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `gti_status_has_chamados_gti_id_chamados_foreign` (`gti_id_chamados`),
  KEY `gti_status_has_chamados_gti_id_status_foreign` (`gti_id_status`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `gti_status_has_chamados`
--

INSERT INTO `gti_status_has_chamados` (`id`, `descricao`, `gti_id_chamados`, `gti_id_status`, `created_at`, `updated_at`) VALUES
(1, 'Abertura do chamado registrado junto a equipe de TI. Aguarde alguns instantes que logo estaremos analisando sua solicitação.', 1, 1, '2020-06-23 20:17:54', '2020-06-23 20:17:54'),
(2, 'Abertura do chamado registrado junto a equipe de TI. Aguarde alguns instantes que logo estaremos analisando sua solicitação.', 2, 1, '2020-06-23 20:17:54', '2020-06-23 20:17:54'),
(3, 'teste', 1, 2, '2020-06-24 03:00:00', '2020-06-24 03:00:00'),
(4, 'Abertura do chamado registrado junto a equipe de TI. Aguarde alguns instantes que logo estaremos analisando sua solicitação.', 3, 1, '2020-08-03 18:02:41', '2020-08-03 18:02:41'),
(5, 'Estado do chamado alterado por Pedro Henrique dos Santos Oliveira.', 1, 3, '2020-09-14 17:44:26', '2020-09-14 17:44:26'),
(6, 'Abertura do chamado registrado junto a equipe de TI. Aguarde alguns instantes que logo estaremos analisando sua solicitação.', 4, 1, '2020-09-14 19:45:22', '2020-09-14 19:45:22'),
(7, 'Estou verificando o problema', 4, 2, '2020-09-14 19:56:25', '2020-09-14 19:56:25'),
(8, 'o sistema normalizou', 4, 3, '2020-09-14 19:57:49', '2020-09-14 19:57:49');

-- --------------------------------------------------------

--
-- Estrutura da tabela `gti_tipos`
--

DROP TABLE IF EXISTS `gti_tipos`;
CREATE TABLE IF NOT EXISTS `gti_tipos` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descricao` text COLLATE utf8mb4_unicode_ci,
  `status` tinyint(1) NOT NULL,
  `gti_id_fontes` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `gti_tipos_gti_id_fontes_foreign` (`gti_id_fontes`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `gti_tipos`
--

INSERT INTO `gti_tipos` (`id`, `nome`, `descricao`, `status`, `gti_id_fontes`, `created_at`, `updated_at`) VALUES
(1, 'Plataforma de Crédito', NULL, 1, 1, '2020-06-23 20:17:26', '2020-06-23 20:17:26'),
(2, 'Plataforma de Atendimento', NULL, 1, 1, '2020-06-23 20:17:26', '2020-06-23 20:17:26'),
(3, 'Plataforma de Conta Corrente', NULL, 1, 1, '2020-06-23 20:17:26', '2020-06-23 20:17:26'),
(4, 'Produtos Bancoob', NULL, 1, 3, '2020-06-23 20:17:26', '2020-06-23 20:17:26'),
(5, 'Emprestimos', NULL, 1, 3, '2020-06-23 20:17:26', '2020-06-23 20:17:26');

-- --------------------------------------------------------

--
-- Estrutura da tabela `imagens`
--

DROP TABLE IF EXISTS `imagens`;
CREATE TABLE IF NOT EXISTS `imagens` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tipo` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `endereco` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `imagens`
--

INSERT INTO `imagens` (`id`, `tipo`, `endereco`, `created_at`, `updated_at`) VALUES
(1, 'perfil', '1.jpg', NULL, NULL),
(2, 'ativos', 'ativos/114431202006235ef2154f3c1fe.png', '2020-06-23 14:44:31', '2020-06-23 14:44:31'),
(3, 'ativos', 'ativos/114431202006235ef2154f533d7.png', '2020-06-23 14:44:31', '2020-06-23 14:44:31'),
(4, 'ativos', 'ativos/114431202006235ef2154f5672d.png', '2020-06-23 14:44:31', '2020-06-23 14:44:31'),
(5, 'ativos', 'ativos/114431202006235ef2154f59598.png', '2020-06-23 14:44:31', '2020-06-23 14:44:31'),
(6, 'ativos', 'ativos/114431202006235ef2154f5c3d3.png', '2020-06-23 14:44:31', '2020-06-23 14:44:31'),
(7, 'ativos', 'ativos/114431202006235ef2154f5f388.png', '2020-06-23 14:44:31', '2020-06-23 14:44:31'),
(8, 'ativos', 'ativos/114431202006235ef2154f61f2b.png', '2020-06-23 14:44:31', '2020-06-23 14:44:31'),
(9, 'ativos', 'ativos/114431202006235ef2154f64487.png', '2020-06-23 14:44:31', '2020-06-23 14:44:31'),
(10, 'ativos_principal', 'ativos/114439202006235ef215573f307.jpeg', '2020-06-23 14:44:39', '2020-06-23 14:44:39'),
(11, 'ativos_principal', 'ativos/114805202006235ef2162530b9d.jpeg', '2020-06-23 14:48:05', '2020-06-23 14:48:05'),
(12, 'ativos_principal', 'ativos/114827202006235ef2163be4eb5.jpeg', '2020-06-23 14:48:27', '2020-06-23 14:48:27'),
(13, 'ativos_principal', 'ativos/114925202006235ef21675d8fe1.jpeg', '2020-06-23 14:49:25', '2020-06-23 14:49:25'),
(14, 'perfil', 'usuarios/141919202006235ef239978d543.png', '2020-06-23 17:19:19', '2020-06-23 17:19:19'),
(15, 'ativos', 'ativos/155241202006235ef24f791020a.jpeg', '2020-06-23 18:52:41', '2020-06-23 18:52:41'),
(16, 'ativos', 'ativos/155241202006235ef24f79173c0.webp', '2020-06-23 18:52:41', '2020-06-23 18:52:41'),
(17, 'ativos_principal', 'ativos/155244202006235ef24f7c5b6a9.webp', '2020-06-23 18:52:44', '2020-06-23 18:52:44'),
(18, 'usuarios', 'usuarios/155559202006235ef2503f6348a.png', '2020-06-23 18:55:59', '2020-06-23 18:55:59'),
(19, 'homepage', 'homepage/164227202006235ef25b23ce8c9.png', '2020-06-23 19:42:27', '2020-06-23 19:42:27'),
(20, 'chamados', 'chamados/171751202006235ef2636f7b8ee.png', '2020-06-23 20:17:51', '2020-06-23 20:17:51'),
(21, 'chamados', 'chamados/171751202006235ef2636f80e63.png', '2020-06-23 20:17:51', '2020-06-23 20:17:51'),
(22, 'chamados', 'chamados/171751202006235ef2636f83b2c.png', '2020-06-23 20:17:51', '2020-06-23 20:17:51'),
(23, 'chamados', 'chamados/171751202006235ef2636f87347.png', '2020-06-23 20:17:51', '2020-06-23 20:17:51'),
(24, 'chamados', 'chamados/171751202006235ef2636f8a5d2.png', '2020-06-23 20:17:51', '2020-06-23 20:17:51'),
(25, 'chamados', 'chamados/171751202006235ef2636f8d727.png', '2020-06-23 20:17:51', '2020-06-23 20:17:51'),
(26, 'chamados', 'chamados/171751202006235ef2636f8fbac.png', '2020-06-23 20:17:51', '2020-06-23 20:17:51'),
(27, 'chamados', 'chamados/171751202006235ef2636f925ed.png', '2020-06-23 20:17:51', '2020-06-23 20:17:51'),
(28, 'chamados', 'chamados/171751202006235ef2636f952e5.png', '2020-06-23 20:17:51', '2020-06-23 20:17:51'),
(29, 'chamados', 'chamados/171751202006235ef2636f976de.png', '2020-06-23 20:17:51', '2020-06-23 20:17:51'),
(30, 'chamados', 'chamados/171751202006235ef2636f9b924.png', '2020-06-23 20:17:51', '2020-06-23 20:17:51'),
(31, 'chamados', 'chamados/171751202006235ef2636f9e760.png', '2020-06-23 20:17:51', '2020-06-23 20:17:51'),
(32, 'chamados', 'chamados/171751202006235ef2636fa1099.png', '2020-06-23 20:17:51', '2020-06-23 20:17:51'),
(33, 'chamados', 'chamados/171751202006235ef2636fa3a6e.png', '2020-06-23 20:17:51', '2020-06-23 20:17:51'),
(34, 'chamados', 'chamados/171751202006235ef2636fa70aa.png', '2020-06-23 20:17:51', '2020-06-23 20:17:51'),
(35, 'chamados', 'chamados/171751202006235ef2636faa316.png', '2020-06-23 20:17:51', '2020-06-23 20:17:51'),
(36, 'chamados', 'chamados/171751202006235ef2636fad224.png', '2020-06-23 20:17:51', '2020-06-23 20:17:51'),
(37, 'homepage', 'homepage/111800202006245ef36098342eb.jpeg', '2020-06-24 14:18:00', '2020-06-24 14:18:00'),
(38, 'perfil', 'usuarios/170444202009115f5bd85cd89c2.png', '2020-09-11 20:04:45', '2020-09-11 20:04:45'),
(39, 'perfil', 'usuarios/170742202009115f5bd90e30029.png', '2020-09-11 20:07:42', '2020-09-11 20:07:42'),
(40, 'perfil', 'usuarios/105612202009145f5f767c890e2.jpeg', '2020-09-14 13:56:12', '2020-09-14 13:56:12'),
(41, 'perfil', 'usuarios/125435202009165f62353bef9b2.png', '2020-09-16 15:54:36', '2020-09-16 15:54:36'),
(42, 'perfil', 'usuarios/180945202009165f6254e9ea2df.png', '2020-09-16 21:09:46', '2020-09-16 21:09:46');

-- --------------------------------------------------------

--
-- Estrutura da tabela `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=137 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(97, '2020_05_26_173658_create_imagens', 1),
(98, '2020_05_26_173721_create_arquivos', 1),
(99, '2020_05_26_182240_create_cli_associados', 1),
(100, '2020_05_26_182302_create_cli_enderecos', 1),
(101, '2020_05_26_182328_create_cli_telefones', 1),
(102, '2020_05_26_182348_create_cli_emails', 1),
(103, '2020_05_26_184034_create_usr_funcoes', 1),
(104, '2020_05_26_184051_create_usr_instituicoes', 1),
(105, '2020_05_26_184059_create_usr_setores', 1),
(106, '2020_05_26_184118_create_usr_unidades', 1),
(107, '2020_05_26_184219_create_usr_usuarios', 1),
(108, '2020_05_29_194120_create_gti_homepage', 1),
(109, '2020_05_29_194217_create_gti_ativos', 1),
(110, '2020_05_29_194310_create_gti_ativos_has_imagens', 1),
(111, '2020_05_29_194456_create_gti_ativos_has_usuarios', 1),
(112, '2020_05_29_194626_create_gti_fontes', 1),
(113, '2020_05_29_194654_create_gti_tipos', 1),
(114, '2020_05_29_194925_create_gti_chamados', 1),
(115, '2020_05_29_195007_create_gti_chamados_has_arquivos', 1),
(116, '2020_05_29_195008_create_gti_chamados_has_imagens', 1),
(117, '2020_05_29_195035_create_gti_status', 1),
(118, '2020_05_29_195059_create_gti_status_has_chamados', 1),
(119, '2020_05_29_195930_create_sup_base', 1),
(120, '2020_05_29_195947_create_sup_base_has_imagens', 1),
(121, '2020_06_25_102905_create_sup_materiais_categorias', 2),
(122, '2020_06_25_102910_create_sup_materiais', 2),
(123, '2020_06_25_103020_create_sup_materiais_historico', 3),
(124, '2020_06_25_103022_create_activities', 4),
(125, '2020_06_25_103026_create_cre_armarios', 5),
(126, '2020_06_25_103029_create_cre_modalidades', 6),
(127, '2020_06_25_103030_create_cre_finalidades', 6),
(128, '2020_06_25_103031_create_cre_produtos', 6),
(129, '2020_06_25_103032_create_cre_contratos', 6),
(130, '2020_06_25_103033_create_cre_avalistas', 6),
(131, '2020_06_25_103034_create_cre_garantias', 6),
(132, '2020_06_25_103035_create_cre_solicitacoes', 6),
(136, '2020_09_15_120506_create_cog_emails', 7);

-- --------------------------------------------------------

--
-- Estrutura da tabela `sup_base`
--

DROP TABLE IF EXISTS `sup_base`;
CREATE TABLE IF NOT EXISTS `sup_base` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `titulo` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subtitulo` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descricao` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `gti_id_fontes` int(10) UNSIGNED NOT NULL,
  `gti_id_tipos` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sup_base_gti_id_fontes_foreign` (`gti_id_fontes`),
  KEY `sup_base_gti_id_tipos_foreign` (`gti_id_tipos`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `sup_base`
--

INSERT INTO `sup_base` (`id`, `titulo`, `subtitulo`, `descricao`, `gti_id_fontes`, `gti_id_tipos`, `created_at`, `updated_at`) VALUES
(1, 'Plataforma com problemas ao tentar abrir', 'Para que serve?', 'Lorem Ipsum é simplesmente uma simulação de texto da indústria tipográfica e de impressos, e vem sendo utilizado desde o século XVI, quando um impressor desconhecido pegou uma bandeja de tipos e os embaralhou para fazer um livro de modelos de tipos. Lorem Ipsum sobreviveu não só a cinco séculos, como também ao salto para a editoração eletrônica, permanecendo essencialmente inalterado. Se popularizou na década de 60, quando a Letraset lançou decalques contendo passagens de Lorem Ipsum, e mais recentemente quando passou a ser integrado a softwares de editoração eletrônica como Aldus PageMaker.', 1, 1, '2020-06-24 03:00:00', '2020-06-24 03:00:00'),
(2, 'Plataforma dando erros ao tentar fazer lançamentos', 'Porque nós o usamos?', 'É um fato conhecido de todos que um leitor se distrairá com o conteúdo de texto legível de uma página quando estiver examinando sua diagramação. A vantagem de usar Lorem Ipsum é que ele tem uma distribuição normal de letras, ao contrário de \"Conteúdo aqui, conteúdo aqui\", fazendo com que ele tenha uma aparência similar a de um texto legível. Muitos softwares de publicação e editores de páginas na internet agora usam Lorem Ipsum como texto-modelo padrão, e uma rápida busca por \'lorem ipsum\' mostra vários websites ainda em sua fase de construção. Várias versões novas surgiram ao longo dos anos, eventualmente por acidente, e às vezes de propósito (injetando humor, e coisas do gênero).', 1, 1, '2020-06-24 03:00:00', '2020-06-24 03:00:00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `sup_materiais`
--

DROP TABLE IF EXISTS `sup_materiais`;
CREATE TABLE IF NOT EXISTS `sup_materiais` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descricao` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quantidade` int(11) NOT NULL,
  `quantidade_min` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `id_categoria` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sup_materiais_id_categoria_foreign` (`id_categoria`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `sup_materiais`
--

INSERT INTO `sup_materiais` (`id`, `nome`, `descricao`, `quantidade`, `quantidade_min`, `status`, `id_categoria`, `created_at`, `updated_at`) VALUES
(7, 'CANETA AZUL', NULL, 37, 3, 1, 1, NULL, '2020-09-15 15:01:07'),
(8, 'CANETA PRETA', NULL, 7, 5, 1, 1, NULL, '2020-09-11 20:24:25'),
(9, 'CANETA VERMELHA', NULL, 5, 5, 1, 1, NULL, '2020-09-15 14:52:55'),
(10, 'PACOTE DE PAPEL A4', NULL, 7, 3, 1, 2, '2020-06-25 20:07:14', '2020-09-15 14:57:07');

-- --------------------------------------------------------

--
-- Estrutura da tabela `sup_materiais_categorias`
--

DROP TABLE IF EXISTS `sup_materiais_categorias`;
CREATE TABLE IF NOT EXISTS `sup_materiais_categorias` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `sup_materiais_categorias`
--

INSERT INTO `sup_materiais_categorias` (`id`, `nome`, `status`, `created_at`, `updated_at`) VALUES
(1, 'CANETAS', 1, NULL, '2020-09-14 21:25:32'),
(2, 'PAPEL', 1, NULL, '2020-09-14 21:25:38'),
(3, 'BORRACHA', 1, NULL, '2020-09-14 21:25:44'),
(4, 'COLA', 1, NULL, '2020-09-14 21:25:49'),
(5, 'PILHAS', 1, '2020-09-14 21:25:25', '2020-09-14 21:25:25');

-- --------------------------------------------------------

--
-- Estrutura da tabela `sup_materiais_historico`
--

DROP TABLE IF EXISTS `sup_materiais_historico`;
CREATE TABLE IF NOT EXISTS `sup_materiais_historico` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `quantidade` int(11) NOT NULL,
  `tipo` enum('s','e') COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_material` bigint(20) UNSIGNED NOT NULL,
  `id_usuario` int(10) UNSIGNED NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sup_materiais_requisicoes_id_material_foreign` (`id_material`),
  KEY `sup_materiais_requisicoes_id_usuario_foreign` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `sup_materiais_historico`
--

INSERT INTO `sup_materiais_historico` (`id`, `quantidade`, `tipo`, `id_material`, `id_usuario`, `status`, `created_at`, `updated_at`) VALUES
(64, 2, 's', 7, 1, 0, '2020-09-17 19:16:36', '2020-09-17 19:16:36'),
(65, 2, 's', 10, 1, 0, '2020-09-17 19:18:31', '2020-09-17 19:18:31');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usr_funcoes`
--

DROP TABLE IF EXISTS `usr_funcoes`;
CREATE TABLE IF NOT EXISTS `usr_funcoes` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `ver_administrativo` tinyint(1) NOT NULL,
  `gerenciar_administrativo` tinyint(1) NOT NULL,
  `ver_credito` tinyint(1) NOT NULL,
  `gerenciar_credito` tinyint(1) NOT NULL,
  `ver_gti` tinyint(1) NOT NULL,
  `gerenciar_gti` tinyint(1) NOT NULL,
  `ver_configuracoes` tinyint(1) NOT NULL,
  `gerenciar_configuracoes` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `usr_funcoes`
--

INSERT INTO `usr_funcoes` (`id`, `nome`, `status`, `ver_administrativo`, `gerenciar_administrativo`, `ver_credito`, `gerenciar_credito`, `ver_gti`, `gerenciar_gti`, `ver_configuracoes`, `gerenciar_configuracoes`, `created_at`, `updated_at`) VALUES
(1, 'Administrador', 1, 1, 1, 1, 1, 1, 1, 1, 1, NULL, '2020-09-15 13:01:40'),
(2, 'Colaboradores', 1, 0, 0, 1, 1, 0, 0, 0, 0, '2020-06-25 16:37:50', '2020-06-26 14:40:11'),
(3, 'Tecnologia', 1, 0, 0, 0, 0, 1, 1, 1, 1, '2020-06-25 16:43:43', '2020-06-25 18:54:29');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usr_instituicoes`
--

DROP TABLE IF EXISTS `usr_instituicoes`;
CREATE TABLE IF NOT EXISTS `usr_instituicoes` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descricao` text COLLATE utf8mb4_unicode_ci,
  `telefone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `usr_instituicoes`
--

INSERT INTO `usr_instituicoes` (`id`, `nome`, `descricao`, `telefone`, `email`, `status`, `created_at`, `updated_at`) VALUES
(1, 'SICOOB SERTÃO MINAS', 'Cooperativa de Crédito de Livre Admissão do Sertão de Minas Gerais Ltda - Sicoob Sertão Minas', '(38) 3742-6250', 'administrativo@sicoobsertaominas.com.br', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usr_setores`
--

DROP TABLE IF EXISTS `usr_setores`;
CREATE TABLE IF NOT EXISTS `usr_setores` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `usr_setores`
--

INSERT INTO `usr_setores` (`id`, `nome`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Business Inteligence', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usr_unidades`
--

DROP TABLE IF EXISTS `usr_unidades`;
CREATE TABLE IF NOT EXISTS `usr_unidades` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `referencia` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `usr_id_instituicao` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `usr_unidades_usr_id_instituicao_foreign` (`usr_id_instituicao`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `usr_unidades`
--

INSERT INTO `usr_unidades` (`id`, `nome`, `referencia`, `status`, `usr_id_instituicao`, `created_at`, `updated_at`) VALUES
(1, 'SEDE PIRAPORA', '4133-00', 1, 1, NULL, NULL),
(2, 'PA VARZEA DA PALMA', '4133-01', 1, 1, NULL, NULL),
(3, 'PA BURITIZEIRO', '4133-02', 1, 1, NULL, NULL),
(4, 'PA FRANCISCO DUMONT', '4133-03', 1, 1, NULL, NULL),
(5, 'PA ENGENHEIRO NAVARRO', '4133-05', 1, 1, NULL, NULL),
(6, 'PA ATENDIMENTO DIGITAL', '4133-097', 1, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usr_usuarios`
--

DROP TABLE IF EXISTS `usr_usuarios`;
CREATE TABLE IF NOT EXISTS `usr_usuarios` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `login` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `retaguarda` tinyint(1) NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('Ativo','Desativado','Bloqueado') COLLATE utf8mb4_unicode_ci NOT NULL,
  `usr_id_setor` int(10) UNSIGNED NOT NULL,
  `usr_id_funcao` int(10) UNSIGNED NOT NULL,
  `usr_id_instituicao` int(10) UNSIGNED NOT NULL,
  `usr_id_unidade` int(10) UNSIGNED NOT NULL,
  `cli_id_associado` int(10) UNSIGNED NOT NULL,
  `id_imagem` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `usr_usuarios_usr_id_setor_foreign` (`usr_id_setor`),
  KEY `usr_usuarios_usr_id_funcao_foreign` (`usr_id_funcao`),
  KEY `usr_usuarios_usr_id_instituicao_foreign` (`usr_id_instituicao`),
  KEY `usr_usuarios_usr_id_unidade_foreign` (`usr_id_unidade`),
  KEY `usr_usuarios_cli_id_associado_foreign` (`cli_id_associado`),
  KEY `usr_usuarios_id_imagem_foreign` (`id_imagem`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `usr_usuarios`
--

INSERT INTO `usr_usuarios` (`id`, `login`, `password`, `retaguarda`, `remember_token`, `status`, `usr_id_setor`, `usr_id_funcao`, `usr_id_instituicao`, `usr_id_unidade`, `cli_id_associado`, `id_imagem`, `created_at`, `updated_at`) VALUES
(1, 'administrador', '$2y$10$no4uR5sc1UO8QEt9Jp9HT.DvWnYbAUglsaHdvuJyceszUzZIcHNZy', 1, NULL, 'Ativo', 1, 1, 1, 1, 1, 42, NULL, '2020-09-16 21:09:46'),
(2, 'pedroh4133_00', '$2y$10$6hxeew9nHI8Dlpb9qC6HS.TDkQKXtQv.mbGMspZTntWtG70dTxtGi', 0, NULL, 'Ativo', 1, 3, 1, 1, 2, 40, '2020-06-23 18:55:59', '2020-09-14 17:42:09');

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `activities`
--
ALTER TABLE `activities`
  ADD CONSTRAINT `activities_id_usuario_foreign` FOREIGN KEY (`id_usuario`) REFERENCES `usr_usuarios` (`id`);

--
-- Limitadores para a tabela `cli_emails`
--
ALTER TABLE `cli_emails`
  ADD CONSTRAINT `cli_emails_cli_id_associado_foreign` FOREIGN KEY (`cli_id_associado`) REFERENCES `cli_associados` (`id`);

--
-- Limitadores para a tabela `cli_enderecos`
--
ALTER TABLE `cli_enderecos`
  ADD CONSTRAINT `cli_enderecos_cli_id_associado_foreign` FOREIGN KEY (`cli_id_associado`) REFERENCES `cli_associados` (`id`);

--
-- Limitadores para a tabela `cli_telefones`
--
ALTER TABLE `cli_telefones`
  ADD CONSTRAINT `cli_telefones_cli_id_associado_foreign` FOREIGN KEY (`cli_id_associado`) REFERENCES `cli_associados` (`id`);

--
-- Limitadores para a tabela `cre_avalistas`
--
ALTER TABLE `cre_avalistas`
  ADD CONSTRAINT `cre_avalistas_cli_id_associado_foreign` FOREIGN KEY (`cli_id_associado`) REFERENCES `cli_associados` (`id`),
  ADD CONSTRAINT `cre_avalistas_cre_id_contrato_foreign` FOREIGN KEY (`cre_id_contrato`) REFERENCES `cre_contratos` (`id`);

--
-- Limitadores para a tabela `cre_contratos`
--
ALTER TABLE `cre_contratos`
  ADD CONSTRAINT `cre_contratos_cli_id_associado_foreign` FOREIGN KEY (`cli_id_associado`) REFERENCES `cli_associados` (`id`),
  ADD CONSTRAINT `cre_contratos_cre_id_armarios_foreign` FOREIGN KEY (`cre_id_armarios`) REFERENCES `cre_armarios` (`id`),
  ADD CONSTRAINT `cre_contratos_cre_id_finalidades_foreign` FOREIGN KEY (`cre_id_finalidades`) REFERENCES `cre_finalidades` (`id`),
  ADD CONSTRAINT `cre_contratos_cre_id_modalidades_foreign` FOREIGN KEY (`cre_id_modalidades`) REFERENCES `cre_modalidades` (`id`),
  ADD CONSTRAINT `cre_contratos_cre_id_produtos_foreign` FOREIGN KEY (`cre_id_produtos`) REFERENCES `cre_produtos` (`id`);

--
-- Limitadores para a tabela `cre_garantias`
--
ALTER TABLE `cre_garantias`
  ADD CONSTRAINT `cre_garantias_cre_id_contrato_foreign` FOREIGN KEY (`cre_id_contrato`) REFERENCES `cre_contratos` (`id`);

--
-- Limitadores para a tabela `cre_solicitacoes`
--
ALTER TABLE `cre_solicitacoes`
  ADD CONSTRAINT `cre_solicitacoes_cre_id_contratos_foreign` FOREIGN KEY (`cre_id_contratos`) REFERENCES `cre_contratos` (`id`),
  ADD CONSTRAINT `cre_solicitacoes_usr_id_usuario_foreign` FOREIGN KEY (`usr_id_usuario`) REFERENCES `usr_usuarios` (`id`);

--
-- Limitadores para a tabela `gti_ativos`
--
ALTER TABLE `gti_ativos`
  ADD CONSTRAINT `gti_ativos_id_imagem_foreign` FOREIGN KEY (`id_imagem`) REFERENCES `imagens` (`id`),
  ADD CONSTRAINT `gti_ativos_id_setor_foreign` FOREIGN KEY (`id_setor`) REFERENCES `usr_setores` (`id`);

--
-- Limitadores para a tabela `gti_ativos_has_imagens`
--
ALTER TABLE `gti_ativos_has_imagens`
  ADD CONSTRAINT `gti_ativos_has_imagens_id_ativo_foreign` FOREIGN KEY (`id_ativo`) REFERENCES `gti_ativos` (`id`),
  ADD CONSTRAINT `gti_ativos_has_imagens_id_imagem_foreign` FOREIGN KEY (`id_imagem`) REFERENCES `imagens` (`id`);

--
-- Limitadores para a tabela `gti_ativos_has_usuarios`
--
ALTER TABLE `gti_ativos_has_usuarios`
  ADD CONSTRAINT `gti_ativos_has_usuarios_gti_id_ativos_foreign` FOREIGN KEY (`gti_id_ativos`) REFERENCES `gti_ativos` (`id`),
  ADD CONSTRAINT `gti_ativos_has_usuarios_usr_id_usuarios_foreign` FOREIGN KEY (`usr_id_usuarios`) REFERENCES `usr_usuarios` (`id`);

--
-- Limitadores para a tabela `gti_chamados`
--
ALTER TABLE `gti_chamados`
  ADD CONSTRAINT `gti_chamados_gti_id_fontes_foreign` FOREIGN KEY (`gti_id_fontes`) REFERENCES `gti_fontes` (`id`),
  ADD CONSTRAINT `gti_chamados_gti_id_tipos_foreign` FOREIGN KEY (`gti_id_tipos`) REFERENCES `gti_tipos` (`id`),
  ADD CONSTRAINT `gti_chamados_usr_id_usuarios_foreign` FOREIGN KEY (`usr_id_usuarios`) REFERENCES `usr_usuarios` (`id`);

--
-- Limitadores para a tabela `gti_chamados_has_arquivos`
--
ALTER TABLE `gti_chamados_has_arquivos`
  ADD CONSTRAINT `gti_chamados_has_arquivos_gti_id_chamados_foreign` FOREIGN KEY (`gti_id_chamados`) REFERENCES `gti_chamados` (`id`),
  ADD CONSTRAINT `gti_chamados_has_arquivos_id_arquivo_foreign` FOREIGN KEY (`id_arquivo`) REFERENCES `arquivos` (`id`);

--
-- Limitadores para a tabela `gti_chamados_has_imagens`
--
ALTER TABLE `gti_chamados_has_imagens`
  ADD CONSTRAINT `gti_chamados_has_imagens_gti_id_chamados_foreign` FOREIGN KEY (`gti_id_chamados`) REFERENCES `gti_chamados` (`id`),
  ADD CONSTRAINT `gti_chamados_has_imagens_id_imagem_foreign` FOREIGN KEY (`id_imagem`) REFERENCES `imagens` (`id`);

--
-- Limitadores para a tabela `gti_homepage`
--
ALTER TABLE `gti_homepage`
  ADD CONSTRAINT `gti_homepage_id_imagem_foreign` FOREIGN KEY (`id_imagem`) REFERENCES `imagens` (`id`);

--
-- Limitadores para a tabela `gti_status_has_chamados`
--
ALTER TABLE `gti_status_has_chamados`
  ADD CONSTRAINT `gti_status_has_chamados_gti_id_chamados_foreign` FOREIGN KEY (`gti_id_chamados`) REFERENCES `gti_chamados` (`id`),
  ADD CONSTRAINT `gti_status_has_chamados_gti_id_status_foreign` FOREIGN KEY (`gti_id_status`) REFERENCES `gti_status` (`id`);

--
-- Limitadores para a tabela `gti_tipos`
--
ALTER TABLE `gti_tipos`
  ADD CONSTRAINT `gti_tipos_gti_id_fontes_foreign` FOREIGN KEY (`gti_id_fontes`) REFERENCES `gti_fontes` (`id`);

--
-- Limitadores para a tabela `sup_base`
--
ALTER TABLE `sup_base`
  ADD CONSTRAINT `sup_base_gti_id_fontes_foreign` FOREIGN KEY (`gti_id_fontes`) REFERENCES `gti_fontes` (`id`),
  ADD CONSTRAINT `sup_base_gti_id_tipos_foreign` FOREIGN KEY (`gti_id_tipos`) REFERENCES `gti_tipos` (`id`);

--
-- Limitadores para a tabela `sup_materiais`
--
ALTER TABLE `sup_materiais`
  ADD CONSTRAINT `sup_materiais_id_categoria_foreign` FOREIGN KEY (`id_categoria`) REFERENCES `sup_materiais_categorias` (`id`);

--
-- Limitadores para a tabela `sup_materiais_historico`
--
ALTER TABLE `sup_materiais_historico`
  ADD CONSTRAINT `sup_materiais_requisicoes_id_material_foreign` FOREIGN KEY (`id_material`) REFERENCES `sup_materiais` (`id`),
  ADD CONSTRAINT `sup_materiais_requisicoes_id_usuario_foreign` FOREIGN KEY (`id_usuario`) REFERENCES `usr_usuarios` (`id`);

--
-- Limitadores para a tabela `usr_unidades`
--
ALTER TABLE `usr_unidades`
  ADD CONSTRAINT `usr_unidades_usr_id_instituicao_foreign` FOREIGN KEY (`usr_id_instituicao`) REFERENCES `usr_instituicoes` (`id`);

--
-- Limitadores para a tabela `usr_usuarios`
--
ALTER TABLE `usr_usuarios`
  ADD CONSTRAINT `usr_usuarios_cli_id_associado_foreign` FOREIGN KEY (`cli_id_associado`) REFERENCES `cli_associados` (`id`),
  ADD CONSTRAINT `usr_usuarios_id_imagem_foreign` FOREIGN KEY (`id_imagem`) REFERENCES `imagens` (`id`),
  ADD CONSTRAINT `usr_usuarios_usr_id_funcao_foreign` FOREIGN KEY (`usr_id_funcao`) REFERENCES `usr_funcoes` (`id`),
  ADD CONSTRAINT `usr_usuarios_usr_id_instituicao_foreign` FOREIGN KEY (`usr_id_instituicao`) REFERENCES `usr_instituicoes` (`id`),
  ADD CONSTRAINT `usr_usuarios_usr_id_setor_foreign` FOREIGN KEY (`usr_id_setor`) REFERENCES `usr_setores` (`id`),
  ADD CONSTRAINT `usr_usuarios_usr_id_unidade_foreign` FOREIGN KEY (`usr_id_unidade`) REFERENCES `usr_unidades` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
