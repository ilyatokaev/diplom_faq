CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id пользователя',
  `login` varchar(20) NOT NULL COMMENT 'Логин пользователя',
  `description` varchar(1000) DEFAULT NULL COMMENT 'Описание пользователя (например, ФИО)',
  `password_hash` varchar(2048) DEFAULT NULL COMMENT 'Hash пароля ',
  PRIMARY KEY (`id`),
  UNIQUE KEY `login_uk` (`login`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8 COMMENT='Пользователи';


CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id роли',
  `code` varchar(20) NOT NULL COMMENT 'код роли',
  `description` varchar(1000) DEFAULT NULL COMMENT 'описание роли',
  PRIMARY KEY (`id`),
  UNIQUE KEY `code_uk` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='Роли';


insert into `roles`(`id`,`code`,`description`) values (1,'Admin','Администратор');


CREATE TABLE `lnk_users_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id связи',
  `id_user` int(11) NOT NULL COMMENT 'id пользователя',
  `id_role` int(11) NOT NULL COMMENT 'id роли',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk` (`id_user`,`id_role`),
  KEY `lnk_users_roles_fk_id_role` (`id_role`),
  CONSTRAINT `lnk_users_roles_fk_id_role` FOREIGN KEY (`id_role`) REFERENCES `roles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `lnk_users_roles_fk_id_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COMMENT='Связь пользователей с ролями';


CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id категории',
  `code` varchar(300) NOT NULL COMMENT 'Код категории (краткое наименование)',
  PRIMARY KEY (`id`),
  KEY `uk` (`code`(255))
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COMMENT='Категории вопросов';


CREATE TABLE `qq_statuses` (
  `id` int(11) NOT NULL COMMENT 'id статуса',
  `code` varchar(20) NOT NULL COMMENT 'код статуса',
  `description` varchar(1000) DEFAULT NULL COMMENT 'описание статуса',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Статусы вопросов';


insert into `qq_statuses`(`id`,`code`,`description`) values (2,'PUBLIC','Разрешена публикация');
insert into `qq_statuses`(`id`,`code`,`description`) values (3,'HIDDEN','Вопрос скрыт');


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
  CONSTRAINT `qq_fk_id_category` FOREIGN KEY (`id_category`) REFERENCES `categories` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `qq_fk_id_status` FOREIGN KEY (`id_status`) REFERENCES `qq_statuses` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COMMENT='Вопросы';


CREATE TABLE `answers` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id ответа',
  `id_q` int(11) NOT NULL COMMENT 'id вопроса',
  `create_date` datetime NOT NULL COMMENT 'Дата и время ответа',
  `a_text` varchar(2000) DEFAULT NULL COMMENT 'текст ответа',
  `id_author` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `answers_fk_id_author` (`id_author`),
  KEY `answer_fk_id_q` (`id_q`),
  CONSTRAINT `answers_fk_id_author` FOREIGN KEY (`id_author`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `answer_fk_id_q` FOREIGN KEY (`id_q`) REFERENCES `qq` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COMMENT='Ответы на вопросы';


