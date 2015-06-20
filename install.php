<?php

/**
 *          @starstudio
 *          @author zengzhiyang
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$sql = <<<EOF
CREATE TABLE cdb_cname (
  `uid` mediumint(8) unsigned NOT NULL,
  `username` varchar(255) NOT NULL DEFAULT '',
  `date` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`),
  KEY `uid` (`uid`)
) TYPE=MyISAM;

CREATE TABLE cdb_cnameshop (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `color` varchar(10) NOT NULL DEFAULT '',
  `light` varchar(10) NOT NULL DEFAULT '',
  `price` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) TYPE=MyISAM;

EOF;

runquery($sql);

$finish = TRUE;

?>