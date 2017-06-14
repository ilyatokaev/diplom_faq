USE diplom;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id пользователя',
  `login` varchar(20) NOT NULL COMMENT 'Логин пользователя',
  `description` varchar(1000) DEFAULT NULL COMMENT 'Описание пользователя (например, ФИО)',
  `password_hash` varchar(2048) DEFAULT NULL COMMENT 'Hash пароля ',
  PRIMARY KEY (`id`),
  UNIQUE KEY `login_uk` (`login`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8 COMMENT='Пользователи';


insert into `diplom`.`users`(`id`,`login`,`description`,`password_hash`) values (1,'admin','Админ поумолчанию','425fa8c5ebf337dbf5bea7cec5b12932');
insert into `diplom`.`users`(`id`,`login`,`description`,`password_hash`) values (31,'NewAdmin','Новый админ','e344dcdc38e3b3007a80ff2a71218d31');
