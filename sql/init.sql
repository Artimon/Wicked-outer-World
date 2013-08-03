
CREATE USER 'battleronAlpha'@'%' IDENTIFIED BY '***';

GRANT USAGE ON * . * TO 'battleronAlpha'@'%' IDENTIFIED BY '***' WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0 ;

GRANT ALL PRIVILEGES ON `battleronalpha` . * TO 'battleronAlpha'@'%';

REVOKE ALL PRIVILEGES ON `battleronalpha` . * FROM 'battleronAlpha'@'%';

GRANT ALL PRIVILEGES ON `battleronalpha` . * TO 'battleronAlpha'@'%' WITH GRANT OPTION ;


CREATE TABLE `accounts` (
`id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`starshipId` INT UNSIGNED NOT NULL DEFAULT '0',
`itemsWeaponry` TEXT NOT NULL DEFAULT '',
`itemsAmmunition` TEXT NOT NULL DEFAULT '',
`itemsEquipment` TEXT NOT NULL DEFAULT '',
`itemsCargo` TEXT NOT NULL DEFAULT '',
`itemsEngine` TEXT NOT NULL DEFAULT '',
`itemsStock` TEXT NOT NULL DEFAULT ''
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci;

ALTER TABLE `accounts` ADD `name` VARCHAR( 20 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `id` ;

ALTER TABLE `accounts` ADD `targetId` TINYINT NOT NULL DEFAULT '0' AFTER `starshipId` ;

ALTER TABLE `accounts` ADD `inflictedDamage` INT UNSIGNED NOT NULL DEFAULT '0' ;


CREATE TABLE `crafting` (
`id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`accountId` INT UNSIGNED NOT NULL ,
`recipes` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
INDEX ( `accountId` )
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci;


ALTER TABLE `accounts` CHANGE `id` `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT ,
CHANGE `starshipId` `starshipId` BIGINT UNSIGNED NOT NULL DEFAULT '0',
CHANGE `targetId` `targetId` BIGINT NOT NULL DEFAULT '0',
CHANGE `inflictedDamage` `inflictedDamage` BIGINT UNSIGNED NOT NULL DEFAULT '0' ;

ALTER TABLE `crafting` CHANGE `id` `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT ,
CHANGE `accountId` `accountId` BIGINT UNSIGNED NOT NULL ;


ALTER TABLE `accounts` ADD `sectorId` BIGINT UNSIGNED NOT NULL DEFAULT '0' AFTER `name` ,
ADD INDEX ( `sectorId` ) ;


CREATE TABLE `entities` (
`id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`type` BIGINT NOT NULL DEFAULT '0',
`sectorId` BIGINT UNSIGNED NOT NULL DEFAULT '0',
`accountId` BIGINT UNSIGNED NOT NULL DEFAULT '0',
`moveFromX` BIGINT NOT NULL DEFAULT '0',
`moveFromY` BIGINT NOT NULL DEFAULT '0',
`commandCreated` BIGINT NOT NULL DEFAULT '0',
`moveToX` BIGINT NOT NULL DEFAULT '0',
`moveToY` BIGINT NOT NULL DEFAULT '0',
INDEX ( `sectorId` , `accountId` , `moveFromX` , `moveFromY` , `moveToX` , `moveToY` )
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci;

ALTER TABLE `entities` CHANGE `moveFromX` `positionX` BIGINT( 20 ) NOT NULL DEFAULT '0',
CHANGE `moveFromY` `positionY` BIGINT( 20 ) NOT NULL DEFAULT '0',
CHANGE `moveToX` `targetX` BIGINT( 20 ) NOT NULL DEFAULT '0',
CHANGE `moveToY` `targetY` BIGINT( 20 ) NOT NULL DEFAULT '0';

ALTER TABLE `accounts` ADD `endurance` INT UNSIGNED NOT NULL DEFAULT '0' AFTER `targetId` ,
ADD `actionPoints` INT UNSIGNED NOT NULL DEFAULT '0' AFTER `endurance` ;

ALTER TABLE `accounts` ADD `lastUpdate` INT UNSIGNED NOT NULL AFTER `maxActionPoints` ;

ALTER TABLE `accounts` ADD `money` INT NOT NULL DEFAULT '0' AFTER `targetId` ,
ADD `experience` INT NOT NULL DEFAULT '0' AFTER `money` ;

ALTER TABLE `accounts` ADD `level` INT UNSIGNED NOT NULL DEFAULT '0' AFTER `targetId` ;
ALTER TABLE `accounts` ADD `lastHealthCare` INT UNSIGNED NOT NULL DEFAULT '0' AFTER `lastUpdate` ;
ALTER TABLE `accounts` ADD `password` CHAR( 32 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ;
ALTER TABLE `accounts` ADD UNIQUE (`name`);

ALTER TABLE `accounts` ADD `academyCourseLevel` INT UNSIGNED NOT NULL DEFAULT '0' AFTER `actionPoints` ,
ADD `academyCourseTime` INT UNSIGNED NOT NULL DEFAULT '0' AFTER `academyCourseLevel` ;

ALTER TABLE `accounts` DROP `level` ;
ALTER TABLE `accounts` ADD `level` INT UNSIGNED NOT NULL DEFAULT '0' AFTER `money` ;
ALTER TABLE `accounts` CHANGE `experience` `experience` INT( 10 ) UNSIGNED NOT NULL DEFAULT '0' ;

ALTER TABLE `accounts` ADD `tacticsLevel` INT UNSIGNED NOT NULL DEFAULT '0' AFTER `experience` ,
ADD `tacticsExperience` INT UNSIGNED NOT NULL DEFAULT '0' AFTER `tacticsLevel` ,
ADD `astronauticsLevel` INT UNSIGNED NOT NULL DEFAULT '0' AFTER `tacticsExperience` ,
ADD `astronauticsExperience` INT UNSIGNED NOT NULL DEFAULT '0' AFTER `astronauticsLevel` ,
ADD `craftingLevel` INT UNSIGNED NOT NULL DEFAULT '0' AFTER `astronauticsExperience` ,
ADD `craftingExperience` INT UNSIGNED NOT NULL DEFAULT '0' AFTER `craftingLevel` ;

ALTER TABLE `accounts` CHANGE `astronauticsLevel` `defenseLevel` INT( 10 ) UNSIGNED NOT NULL DEFAULT '0',
CHANGE `astronauticsExperience` `defenseExperience` INT( 10 ) UNSIGNED NOT NULL DEFAULT '0' ;

ALTER TABLE  `entities` CHANGE  `commandCreated`  `timeout` BIGINT( 20 ) NOT NULL DEFAULT  '0' ;

ALTER TABLE  `accounts` ADD  `trainings` BIGINT UNSIGNED NOT NULL DEFAULT  '0' AFTER  `misses` ;

ALTER TABLE  `accounts` ADD  `energySetup` TINYINT UNSIGNED NOT NULL DEFAULT  '0' AFTER  `repair` ;