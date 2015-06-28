<?php

/**
 *          @starstudio
 *          @author zzy
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$sql = <<<EOF

DROP TABLE cdb_cname;
DROP TABLE cdb_cnameshop;

EOF;

runquery($sql);

$finish = TRUE;
