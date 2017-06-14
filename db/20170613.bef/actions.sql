USE diplom;

CREATE TABLE `actions` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id операции',
  `code` varchar(20) NOT NULL COMMENT 'код операции',
  `description` varchar(1000) DEFAULT NULL COMMENT 'описание операции',
  PRIMARY KEY (`id`),
  UNIQUE KEY `code_uk` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Действия';


