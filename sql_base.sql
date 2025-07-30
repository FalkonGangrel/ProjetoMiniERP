-- --------------------------------------------------------
-- Servidor:                     127.0.0.1
-- Versão do servidor:           10.4.24-MariaDB - mariadb.org binary distribution
-- OS do Servidor:               Win64
-- HeidiSQL Versão:              12.11.0.7065
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Copiando estrutura do banco de dados para db_mini_erp
DROP DATABASE IF EXISTS `db_mini_erp`;
CREATE DATABASE IF NOT EXISTS `db_mini_erp` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `db_mini_erp`;

-- Copiando estrutura para tabela db_mini_erp.cupons
DROP TABLE IF EXISTS `cupons`;
CREATE TABLE IF NOT EXISTS `cupons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(50) NOT NULL,
  `desconto` decimal(10,2) DEFAULT NULL,
  `validade` date DEFAULT NULL,
  `valor_minimo` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `codigo` (`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela db_mini_erp.estoques
DROP TABLE IF EXISTS `estoques`;
CREATE TABLE IF NOT EXISTS `estoques` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `produto_id` int(11) NOT NULL,
  `variacao` varchar(100) DEFAULT NULL,
  `preco` decimal(10,2) NOT NULL DEFAULT 0.00,
  `quantidade` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `estoques_produtos` (`produto_id`),
  CONSTRAINT `estoques_produtos` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela db_mini_erp.pedidos
DROP TABLE IF EXISTS `pedidos`;
CREATE TABLE IF NOT EXISTS `pedidos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cliente_nome` varchar(255) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `frete` decimal(10,2) DEFAULT NULL,
  `cep` varchar(9) DEFAULT NULL,
  `endereco` text DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `data` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela db_mini_erp.pedido_itens
DROP TABLE IF EXISTS `pedido_itens`;
CREATE TABLE IF NOT EXISTS `pedido_itens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pedido_id` int(11) NOT NULL,
  `produto_id` int(11) NOT NULL,
  `variacao` int(11) DEFAULT NULL,
  `quantidade` int(11) NOT NULL DEFAULT 1,
  `preco_unitario` decimal(10,2) NOT NULL DEFAULT 0.00,
  PRIMARY KEY (`id`),
  KEY `pedidoItens_pedidos` (`pedido_id`),
  KEY `pedidoItens_produtos` (`produto_id`),
  KEY `pedidoItens_variacao` (`variacao`),
  CONSTRAINT `pedidoItens_pedidos` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`),
  CONSTRAINT `pedidoItens_produtos` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`),
  CONSTRAINT `pedidoItens_variacao` FOREIGN KEY (`variacao`) REFERENCES `estoques` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Exportação de dados foi desmarcado.

-- Copiando estrutura para tabela db_mini_erp.produtos
DROP TABLE IF EXISTS `produtos`;
CREATE TABLE IF NOT EXISTS `produtos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `descricao` mediumtext NOT NULL,
  `categoria` varchar(255) NOT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Exportação de dados foi desmarcado.

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
