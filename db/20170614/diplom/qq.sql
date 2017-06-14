USE diplom;

CREATE TABLE `qq` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id вопроса',
  `id_category` int(11) NOT NULL,
  `create_date` datetime NOT NULL,
  `q_text` varchar(2000) NOT NULL COMMENT 'Текст вопроса',
  `author` varchar(100) NOT NULL COMMENT 'Автор вопроса',
  `email` varchar(200) NOT NULL,
  `id_status` int(11) NOT NULL DEFAULT '2',
  PRIMARY KEY (`id`),
  KEY `qq_fk_id_status` (`id_status`),
  KEY `qq_fk_id_category` (`id_category`),
  CONSTRAINT `qq_fk_id_status` FOREIGN KEY (`id_status`) REFERENCES `qq_statuses` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `qq_fk_id_category` FOREIGN KEY (`id_category`) REFERENCES `categories` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='Вопросы';


insert into `diplom`.`qq`(`id`,`id_category`,`create_date`,`q_text`,`author`,`email`,`id_status`) values (1,7,'2017-06-13 23:30:12','eeeeeeeeeeee','eeeeeeeee','eeeeeeeeee@ddddddd',2);
insert into `diplom`.`qq`(`id`,`id_category`,`create_date`,`q_text`,`author`,`email`,`id_status`) values (2,7,'2017-06-13 23:33:53','cccccccccccc','fffffffff','ffffff@ccccccc',2);
