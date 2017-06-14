USE diplom;

CREATE TABLE `answers_statuses` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id статуса',
  `code` varchar(20) NOT NULL COMMENT 'код статуса',
  `description` varchar(1000) DEFAULT NULL COMMENT 'описание статуса',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Статусы ответов';


