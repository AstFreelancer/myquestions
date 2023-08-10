CREATE TABLE IF NOT EXISTS `#__myquestions`(`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,`name` VARCHAR( 255 ) NOT NULL ,`date` DATETIME NOT NULL ,`question` TEXT NOT NULL ,`city` VARCHAR( 50 ) NULL ,`email` VARCHAR( 50 ) NOT NULL ,`IP` VARCHAR( 15 ) NOT NULL ,`id_cat` INT NOT NULL,`published` TINYINT( 1 ) NULL DEFAULT '1',`checked_out_time` DATETIME NULL DEFAULT '0000-00-00 00:00:00',`senttoexpert` TINYINT( 1 ) NULL DEFAULT '0',`answer` TEXT NULL DEFAULT '',`senttoauthor` TINYINT( 1 ) NULL DEFAULT '0');CREATE TABLE IF NOT EXISTS `#__myquestions_categories`(`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,`name` VARCHAR( 255 ) NOT NULL,`desc` TEXT NOT NULL DEFAULT '');INSERT INTO `#__myquestions_categories`(`name`, `desc`) VALUES('Без категории','');