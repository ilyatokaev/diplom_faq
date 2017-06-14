CREATE TABLE `qq_statuses` (
  `id` int(11) NOT NULL COMMENT 'id статуса',
  `code` varchar(20) NOT NULL COMMENT 'код статуса',
  `description` varchar(1000) DEFAULT NULL COMMENT 'описание статуса',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Статусы вопросов';


insert into `qq_statuses`(`id`,`code`,`description`) values (2,'PUBLIC','Разрешена публикация');
insert into `qq_statuses`(`id`,`code`,`description`) values (3,'HIDDEN','Вопрос скрыт');
