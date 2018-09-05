CREATE TABLE IF NOT EXISTS `civicrm_entity_templates` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Primary ID',
  `entity_table` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'physical tablename for entity being joined to file, e.g. civicrm_contact',
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Entity Title',
  `form_values` text COLLATE utf8_unicode_ci COMMENT 'Submitted form values',
  PRIMARY KEY (`id`),
  UNIQUE KEY `UI_entity_table_title` (`entity_table`,`title`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
