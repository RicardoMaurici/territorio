-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Máquina: localhost
-- Data de Criação: 16-Abr-2014 às 13:44
-- Versão do servidor: 5.6.12-log
-- versão do PHP: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de Dados: `form_dados`
--
CREATE DATABASE IF NOT EXISTS `form_dados` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `form_dados`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `publicacao`
--

CREATE TABLE IF NOT EXISTS `publicacao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(120) NOT NULL,
  `imagem` varchar(120) NOT NULL,
  `email_aluno` varchar(120) NOT NULL,
  `descricao` varchar(120) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Extraindo dados da tabela `publicacao`
--

INSERT INTO `publicacao` (`id`, `nome`, `imagem`, `email_aluno`, `descricao`) VALUES
(1, 'asd', 'arquivos_upload/b0493bcd2649c3b3dd605ecf7cf3dea9.jpg', 'asdas', 'asdasd'),
(2, 'teste', 'arquivos_upload/b0493bcd2649c3b3dd605ecf7cf3dea9.jpg', 'teste', 'lalala'),
(3, 'teste', 'arquivos_upload/b0493bcd2649c3b3dd605ecf7cf3dea9.jpg', 'lala', 'hahah'),
(4, 'fulano', 'arquivos_upload/06d3bc740e8ba0c8f64427649f537269.jpg', 'lakajasd', 'Eu sou joÃ£o'),
(5, 'jaoa', 'arquivos_upload/87d07f90f10c40ed8075f45c042fe6f6.jpg', 'lalsdjasdkj', 'eu sou gay'),
(6, 'Leandro', 'arquivos_upload/ae45e7fa9f8a25117bdf723ff21a5181.jpg', 'leandro1992@gmail.com', 'Trabalho como web designer.'),
(7, 'fulano', 'arquivos_upload/53609006fd278a4e9e3847076ce1842c.jpg', 'lalla', 'batatas felizes'),
(8, 'hdasudh', 'arquivos_upload/b0493bcd2649c3b3dd605ecf7cf3dea9.jpg', 'suihdsauid', 'ajshdasud'),
(9, 'zuio', 'arquivos_upload/a49fe8914df0eada4d4b7d530d7fa5ba.jpg', 'dasda', 'fdsfs'),
(10, 'zuio', 'arquivos_upload/a49fe8914df0eada4d4b7d530d7fa5ba.jpg', 'dasda', 'fdsfs'),
(11, 'adadsd', 'arquivos_upload/b0493bcd2649c3b3dd605ecf7cf3dea9.jpg', 'asdasd', 'dasdasd'),
(12, 'teste', 'arquivos_upload/b0493bcd2649c3b3dd605ecf7cf3dea9.jpg', 'test', 'asuhidasi'),
(13, 'Leandro', 'arquivos_upload/ae45e7fa9f8a25117bdf723ff21a5181.jpg', 'leandro1992@gmail.com', 'Testando'),
(14, 'Joselito', 'arquivos_upload/bd6661231506e0fe52c15a3a77ecc1e7.jpg', 'leandro1992@gmail.com', 'Meu territÃ³rio Ã© o north!'),
(15, 'Leandro Marques', 'arquivos_upload/ae45e7fa9f8a25117bdf723ff21a5181.jpg', 'LAlalala', 'OlaauihsdsuaihduiashdasdhsaudihaudhasduadhssauihdauishdasuihdiaushduiashdiuashdiuashduisahduiashduiashdajsbfoigfaÃ§bnflk'),
(16, 'Leandro', 'arquivos_upload/718b153c98e717f406244cb5f984d7d4.png', 'Webdesign', 'Meu territÃ³rio Ã© minha casa.'),
(17, 'Leandro da Silva Marques', 'arquivos_upload/571e32a9497bc9ce85a05dda04543fd6.jpg', 'Webdesign no Nute', 'Meu territÃ³rio Ã© muito legalzinho, blabalbalbalbalbalba, balalalajjdjdhd,\r\naudhauidhausuisuidasuhasduihdaasd.saijfsoid');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
