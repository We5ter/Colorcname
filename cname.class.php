<?php 

/**
 *          @starstudio
 *          @author zzy
 */
 
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
class plugin_color_cname{                                        //显示插件的效果

		function viewthread_sidetop_output(){                      //在帖子里显示
				global $_G,$postlist;
				$return[]='';
				$dd=$_G['cache']['plugin']['color_cname']['time']*3600*24;
				$date=strtotime(date("Y-m-d"))-$dd;
				$uids="";
				foreach($postlist as $v) {
				$uids.=intval($v['uid']).",";
				}
				$allcname = DB::fetch_all("SELECT * FROM ".DB::table('cname')." WHERE uid in (".trim($uids,',').")");
				
				$cname = array();
				foreach($allcname as $v){
				$cname[$v['uid']] = $v;
				}
				
				foreach($postlist as $k=>$v) {
				$postlist[$k]['author'] = $date<$cname[$v['uid']]['date'] ? $cname[$v['uid']]['username'].$v[author]."</font>" : $v['author'];
				}

		return (array)$return;
		
		}
		
}	

class plugin_color_cname_forum extends plugin_color_cname{
}
 
 
 
?>
