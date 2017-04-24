USE diplom;

CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id категории',
  `code` varchar(300) NOT NULL COMMENT 'Код категории (краткое наименование)',
  `description` varchar(2000) DEFAULT NULL COMMENT 'Описание категории (необязательное)',
  PRIMARY KEY (`id`),
  KEY `uk` (`code`(255))
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Категории вопросов';


