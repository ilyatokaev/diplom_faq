USE diplom;

CREATE TABLE `answers` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id ответа',
  `id_q` int(11) NOT NULL COMMENT 'id вопроса',
  `create_date` datetime NOT NULL COMMENT 'Дата и время ответа',
  `a_text` varchar(2000) DEFAULT NULL COMMENT 'текст ответа',
  `id_status` int(11) NOT NULL COMMENT 'статус ответа',
  PRIMARY KEY (`id`),
  KEY `answers_fk_id_status` (`id_status`),
  CONSTRAINT `answers_fk_id_status` FOREIGN KEY (`id_status`) REFERENCES `answers_statuses` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Ответы на вопросы';


