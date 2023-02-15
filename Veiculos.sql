-- --------------------------------------------------------
-- Servidor:                     127.0.0.1
-- Versão do servidor:           10.4.27-MariaDB - mariadb.org binary distribution
-- OS do Servidor:               Win64
-- HeidiSQL Versão:              12.3.0.6589
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Copiando estrutura do banco de dados para carros
CREATE DATABASE IF NOT EXISTS `carros` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `carros`;

-- Copiando estrutura para tabela carros.veiculos
CREATE TABLE IF NOT EXISTS `veiculos` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `veiculo` varchar(25) NOT NULL,
  `marca` varchar(10) NOT NULL,
  `ano` int(4) NOT NULL,
  `descricao` text NOT NULL,
  `vendido` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela carros.veiculos: ~6 rows (aproximadamente)
INSERT INTO `veiculos` (`id`, `veiculo`, `marca`, `ano`, `descricao`, `vendido`) VALUES
	(2, 'GOL 1.0 MI 8V FLEX 4P MAN', 'VOLKSWAGEM', 2013, 'O Volkswagen Gol 1.0 MI 8V FLEX 4P MANUAL é um carro compacto da marca alemã Volkswagen, que foi projetado para oferecer praticidade e economia aos seus proprietários. Este modelo possui motor 1.0 de 8 válvulas flex, o que significa que pode funcionar tanto com gasolina quanto com etanol. Além disso, ele é equipado com transmissão manual de 4 marchas, oferecendo ao motorista uma experiência de condução mais envolvente e suave.', 1),
	(3, 'Mobi Drive 1.0', 'FIAT', 2018, 'O Fiat Mobi Drive 1.0 é um veículo compacto e econômico da marca italiana Fiat. Este modelo foi projetado para atender às necessidades dos consumidores que procuram um carro confortável e prático para o dia a dia.', 1),
	(4, 'UP Move 1.0 TSI', 'VOLKSWAGEM', 2018, 'O Volkswagen Up Move 1.0 TSI é um carro compacto da marca alemã Volkswagen, projetado para oferecer praticidade, economia e conforto aos seus proprietários. Este modelo possui um motor 1.0 TSI turbocharged, o que significa que oferece uma boa potência e economia de combustível. A transmissão manual de 5 velocidades permite uma condução envolvente e suave.', 1),
	(5, 'Fiesta Hatch S Rocam 1.0 ', 'FORD', 2014, 'O Ford Fiesta Hatch S Rocam 1.0 (Flex) é um carro compacto da marca americana Ford, projetado para oferecer praticidade, economia e conforto aos seus proprietários. Este modelo possui um motor 1.0 de 4 cilindros flex, o que significa que pode funcionar tanto com gasolina quanto com etanol, oferecendo uma boa potência e economia de combustível. A transmissão manual de 5 velocidades permite uma condução envolvente e suave.', 1),
	(6, 'Corsa Hatch Max', 'CHEVROLET', 2012, 'O Chevrolet Corsa Hatch Maxx 1.4 (Flex) é um carro compacto da marca americana Chevrolet, projetado para oferecer praticidade, economia e conforto aos seus proprietários. Este modelo possui um motor 1.4 de 4 cilindros flex, o que significa que pode funcionar tanto com gasolina quanto com etanol, oferecendo uma boa potência e economia de combustível. A transmissão manual de 5 velocidades permite uma condução envolvente e suave.', 1),
	(7, 'Civic LXS 1.8 AT', 'HONDA', 2008, 'O Honda Civic LXS 1.8 AT de 2008 é um carro sedã da marca japonesa Honda, conhecido por sua combinação de performance, economia de combustível e conforto. Este modelo possui um motor 1.8 litros de 4 cilindros, que oferece uma boa potência e eficiência de combustível. A transmissão automática de 5 velocidades permite uma condução suave e sem esforço.', 1);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
