USE diplom;

CREATE TABLE `lnk_users_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id связи',
  `id_user` int(11) NOT NULL COMMENT 'id пользователя',
  `id_role` int(11) NOT NULL COMMENT 'id роли',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk` (`id_user`,`id_role`),
  KEY `lnk_users_roles_fk_id_role` (`id_role`),
  CONSTRAINT `lnk_users_roles_fk_id_role` FOREIGN KEY (`id_role`) REFERENCES `roles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `lnk_users_roles_fk_id_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='Связь пользователей с ролями';


insert into `diplom`.`lnk_users_roles`(`id`,`id_user`,`id_role`) values (1,1,1);
insert into `diplom`.`lnk_users_roles`(`id`,`id_user`,`id_role`) values (6,31,1);
