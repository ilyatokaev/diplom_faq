USE diplom;

CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id категории',
  `code` varchar(300) NOT NULL COMMENT 'Код категории (краткое наименование)',
  PRIMARY KEY (`id`),
  KEY `uk` (`code`(255))
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='Категории вопросов';


insert into `diplom`.`categories`(`id`,`code`) values (7,'wwwwwwwwwwwww');
insert into `diplom`.`categories`(`id`,`code`) values (8,'eeeeeeeeeeeeee');
insert into `diplom`.`categories`(`id`,`code`) values (9,'555555555566666ghgggggggggggg');
