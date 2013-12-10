SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE IF NOT EXISTS `ystavakyla_ecards__ecards` (
  `id` int(55) NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `uploader_name` varchar(255) DEFAULT NULL,
  `uploader_email` varchar(255) DEFAULT NULL,
  `message_title` varchar(255) DEFAULT NULL,
  `message_content` text,
  `receiver_name` varchar(255) DEFAULT NULL,
  `receiver_email` varchar(255) DEFAULT NULL,
  `email_sent` set('yes','no') NOT NULL DEFAULT 'no',
  `email_error` text,
  `email_sent_at` timestamp NULL DEFAULT NULL,
  `private` set('yes','no') NOT NULL DEFAULT 'no',
  `base_card` varchar(255) DEFAULT NULL,
  `sizeof_message_title_w` int(3) DEFAULT NULL,
  `sizeof_message_title_h` int(3) DEFAULT NULL,
  `sizeof_message_text_w` int(3) DEFAULT NULL,
  `sizeof_message_text_h` int(3) DEFAULT NULL,
  `placeof_message_title_y` int(3) DEFAULT NULL,
  `placeof_message_title_x` int(3) DEFAULT NULL,
  `placeof_message_text_y` int(3) DEFAULT NULL,
  `placeof_message_text_x` int(3) DEFAULT NULL,
  `participate` set('yes','no') NOT NULL DEFAULT 'yes',
  `hash` varchar(32) DEFAULT NULL,
  `card_status` set('queue','public','private','hidden') NOT NULL DEFAULT 'queue',
  PRIMARY KEY (`id`),
  UNIQUE KEY `hash` (`hash`),
  KEY `email_sent` (`email_sent`,`private`),
  KEY `card_status` (`card_status`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ystavakyla_ecards__users` (
  `id` int(55) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `password` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
  `firstname` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `lastname` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `can_approve` set('yes','no') CHARACTER SET utf8 NOT NULL DEFAULT 'no',
  `can_seeusers` set('yes','no') CHARACTER SET utf8 NOT NULL DEFAULT 'no',
  `can_modusers` set('yes','no') CHARACTER SET utf8 NOT NULL DEFAULT 'no',
  `last_login` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ystavakyla_ecards__templates` (
  `id` int(22) NOT NULL AUTO_INCREMENT,
  `card_filename` varchar(255) DEFAULT NULL COMMENT 'cardname.jpg',
  `card_author` varchar(255) DEFAULT NULL COMMENT 'Copyright notice',
  `card_alt` varchar(255) DEFAULT NULL COMMENT 'Alternative for img tag',
  `card_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Is the card active',
  `created_by` int(55) DEFAULT NULL COMMENT 'User id who uploaded',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `card_filename` (`card_filename`),
  KEY `card_status` (`card_status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;