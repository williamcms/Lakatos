-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 19, 2020 at 02:27 AM
-- Server version: 8.0.21
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `siteconfigs`
--

-- --------------------------------------------------------

--
-- Table structure for table `website_configs`
--

DROP TABLE IF EXISTS `website_configs`;
CREATE TABLE IF NOT EXISTS `website_configs` (
  `config_id` int NOT NULL AUTO_INCREMENT,
  `config_name` varchar(555) NOT NULL,
  `config_value` varchar(1665) NOT NULL,
  `config_description` varchar(1665) NOT NULL,
  `config_active` int NOT NULL COMMENT '0 or 1',
  `config_help` varchar(1200) NOT NULL,
  `config_customplaceholder` varchar(555) NOT NULL,
  PRIMARY KEY (`config_id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `website_configs`
--

INSERT INTO `website_configs` (`config_id`, `config_name`, `config_value`, `config_description`, `config_active`, `config_help`, `config_customplaceholder`) VALUES
(1, 'website_title', '', 'Título do Website', 0, '', ''),
(2, 'website_image', '', 'Imagem do Website', 0, '', ''),
(3, 'website_description', '', 'Descrição do Website', 0, '', ''),
(4, 'website_keywords', '', 'Palavras-chave do Website', 0, '', ''),
(5, 'website_author', 'William Di Biasi Bogik', 'Autor do Website', 0, '', ''),
(6, 'email_name', '', 'Nome no e-mail', 0, '', ''),
(7, 'email_replyTo', '', 'E-mail exibido no ReplyTo', 0, '', ''),
(8, 'email_address', '', 'E-mail que receberá as mensagens', 0, '', ''),
(9, 'social_facebook', '', 'Página do Facebook', 0, '', ''),
(10, 'social_twitter', '', 'Página do Twitter', 0, '', ''),
(11, 'social_linkedin', '', 'Página do Linkedin', 0, '', ''),
(12, 'social_instagram', '', 'Página do Instagram', 0, '', ''),
(13, 'mkt_gAnalytics', '', 'Código do Google Analytics', 0, '', '<!-- Global site tag (gtag.js) - Google Analytics -->\r\n	<script async src=\'https://www.googletagmanager.com/gtag/js?id=YOUR_CODE\'></script>\r\n	<script>\r\n	  window.dataLayer = window.dataLayer || [];\r\n	  function gtag(){dataLayer.push(arguments);}\r\n	  gtag(\'js\', new Date());\r\n\r\n	  gtag(\'config\', \'YOUR_CODE\');\r\n	</script>'),
(14, 'mkt_gAds', '', 'Código do Google Ads', 0, '', ''),
(15, 'mkt_fPixel', '', 'Código do Facebook Pixel', 0, '', ''),
(16, 'mkt_gSearchConsole', '', 'Código do Google Search Console', 0, 'Há duas opções para habilitar o Google Search Console neste website:<br/>\r\n&bull; Utilizar a \"verificação de domínio\".<br/>\r\n&bull; Utilizar a \"verificação de prefixo de URL\".\r\n<br/><br/>\r\nEste painel de controle apenas suporta o último tipo de verificação, prefixo de URL.\r\n<br/>\r\nPara saber mais sobre como realizar a verificação de domínio, <a href=\"https://support.google.com/webmasters/answer/34592\">clique aqui</a>. \r\n<br/>\r\nPara realizar a verificação de prefixo de URL, por aqui, selecione a opção <strong>Tag HTML</strong> na caixa de verificação de propriedade e cole abaixo o código (no campo valor).', '<meta name=\'google-site-verification\' content=\'YOUR_CODE\' />'),
(17, 'mkt_bWebmaster', '', 'Código do Bing Webmaster', 0, 'Há duas opções para habilitar o Bing Webmaster Tool neste website:<br/> &bull; Importar os sites verificados do Google Search Console.<br/> &bull; Utilizar a \"verificação manual\". <br/><br/> Este painel de controle apenas suporta o tipo de verificação manual. <br/> Para saber mais sobre a importação de configurações do Google Search Console, <a href=\"https://www.bing.com/webmaster/help/how-to-verify-ownership-of-your-site-afcfefc6#:~:text=Import%20from%20Google%20Search%20Console&text=You%20can%20see%20the%20option,from%20your%20Search%20Console%20account.\">clique aqui</a>.  <br/> Para realizar a verificação manual, por aqui, selecione a opção <strong>HTML Meta Tag</strong> quando perguntar o método de verificação escolhido e cole abaixo o código (no campo valor).', '<meta name=\'msvalidate.01\' content=\'YOUR_CODE\' />'),
(18, 'fb_page', '', 'Código da sua página do Facebook', 0, '', ''),
(19, 'fb_app', '', 'Código do seu app do Facebook', 0, '', ''),
(20, 'location_stAddress', '', 'Localização: Rua', 0, '', ''),
(21, 'location_locality', '', 'Localização: Cidade', 0, '', ''),
(22, 'location_region', '', 'Localização: Estado', 0, '', ''),
(23, 'location_postalCode', '', 'Localização: Código Postal', 0, '', ''),
(24, 'location_country', '', 'Localização: País', 0, '', ''),
(25, 'location_phoneNumber', '', 'Localização: Número de telefone para contato', 0, '', '');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
