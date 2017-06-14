USE diplom;

CREATE TABLE `lnk_roles_actions` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id связи',
  `id_role` int(11) NOT NULL COMMENT 'id роли',
  `id_action` int(11) NOT NULL COMMENT 'id действия',
  PRIMARY KEY (`id`),
  KEY `uk` (`id_role`,`id_action`),
  KEY `lnk_roles_actions_fk_id_action` (`id_action`),
  CONSTRAINT `lnk_roles_actions_fk_id_action` FOREIGN KEY (`id_action`) REFERENCES `actions` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `lnk_roles_actions_fk_id_role` FOREIGN KEY (`id_role`) REFERENCES `roles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Связь ролей с действиями';


