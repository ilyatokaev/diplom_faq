USE diplom;

CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id роли',
  `code` varchar(20) NOT NULL COMMENT 'код роли',
  `description` varchar(1000) DEFAULT NULL COMMENT 'описание роли',
  PRIMARY KEY (`id`),
  UNIQUE KEY `code_uk` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Роли';


