CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id категории',
  `code` varchar(300) NOT NULL COMMENT 'Код категории (краткое наименование)',
  PRIMARY KEY (`id`),
  KEY `uk` (`code`(255))
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='Категории вопросов';
