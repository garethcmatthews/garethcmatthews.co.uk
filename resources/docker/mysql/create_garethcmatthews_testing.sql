--
-- Database : `garethcmatthews_testing`
--
CREATE DATABASE IF NOT EXISTS `garethcmatthews_testing`
  DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;
USE garethcmatthews_testing;

GRANT USAGE ON *.* TO `mysqluser`@`%`;
GRANT ALL PRIVILEGES ON `garethcmatthews_testing`.* TO `mysqluser`@`%`;
