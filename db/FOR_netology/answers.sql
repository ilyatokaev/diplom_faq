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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='Ответы на вопросы';


