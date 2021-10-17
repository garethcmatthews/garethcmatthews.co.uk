--
-- Database : `garethcmatthews`
--
CREATE DATABASE IF NOT EXISTS `garethcmatthews`
  DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;
USE garethcmatthews;

GRANT USAGE ON *.* TO `mysqluser`@`%`;
GRANT ALL PRIVILEGES ON `garethcmatthews`.* TO `mysqluser`@`%`;
