<?php

/**
 *          @starstudio
 *          @author zengzhiyang
 */
 
if(!defined('IN_DISCUZ')||($_GET['mod'] != 'spacecp')) {
	exit('Access Denied');
}
if(!$_G['uid']) {
	showmessage('not_loggedin', NULL, array(), array('login' => 1));
}
if($_GET['pluginop'] == 'buy'){                                     //购买操作
	$id=intval($_GET['bid']);
	if($id == '' || $id == '0'){
		showmessage(lang('plugin/color_cname', 'error1'), '', 'error');
	}elseif($_GET['hash']!=FORMHASH){
		showmessage(lang('plugin/color_cname', 'error1'), '', 'error');
	}else{
		$cname = DB::fetch_first("SELECT * FROM ".DB::table('cnameshop')." WHERE id='".addslashes($id)."'");
		$cstyle = '<font color="'.$cname['color'].'" style="text-shadow:0 0 1px #fff, 0 0 2px #fff, 0 0 3px #fff, 0 0 4px '.$cname['light'].', 0 0 5px '.$cname['light'].';">';
		$uid = $_G['uid'];
		$date = strtotime(date("Y-m-d"));
		//检查水滴是否足够
		$extcreditss="extcredits".$_G['cache']['plugin']['color_cname']['cextcredit'];
		$getmoney="-".$cname['price'];
		$money=getuserprofile($extcreditss);
		if($money-$cname['price']<0){
			showmessage($_G['cache']['plugin']['color_cname']['nomoney'],"home.php?mod=spacecp&ac=plugin&id=color_cname:cname&pluginop=cshop");
		}else{
		//扣除水滴
		$check = DB::fetch_first("SELECT * FROM ".DB::table('cname')." WHERE uid='".intval($uid)."'");
		if(!$check){
			DB::query("INSERT INTO ".DB::table('cname')."(uid, username, date) VALUES ('$uid', '$cstyle', '$date')");
		}else{
			DB::query("update ".DB::table('cname')." set uid='$uid', username='$cstyle', date='$date' WHERE uid='$uid'");
		}
			updatemembercount($uid, array($extcreditss => $getmoney));
			showmessage(lang('plugin/color_cname', 'buyok'),"home.php?mod=spacecp&ac=plugin&id=color_cname:cname");
		}
	}
} elseif($_GET['pluginop'] == 'cshop'){                                //商店相关操作
	$cshoponoff = $_G['cache']['plugin']['color_cname']['onoff'];
	$cshopclose = $_G['cache']['plugin']['color_cname']['offinfo'];
	if($cshopclose==""):$cshopclose=lang('plugin/color_cname','shopclose');endif;
	if($cshoponoff=="0"){
		showmessage($cshopclose,'home.php?mod=spacecp&ac=plugin&id=color_cname:cname');
	}else{
	$opp='cshop';
	$tipcshop=lang('plugin/color_cname', 'tipbuy');
	$lee=lang('plugin/color_cname', 'cnamename');
	$lh=lang('plugin/color_cname', 'handle');
	$lp=lang('plugin/color_cname', 'price');
	$ld=lang('plugin/color_cname', 'cnametime');
	$ldd=lang('plugin/color_cname', 'cnametimed');
	$lbuy=lang('plugin/color_cname', 'lbuy');
	$lmoney = $_G['cache']['plugin']['color_cname']['cextcredit'];
	$lmoneyy=$_G['setting']['extcredits'][$lmoney]['title'];
	$ctime = $_G['cache']['plugin']['color_cname']['time'];
	$query = DB::query("SELECT * from ".DB::table('cnameshop')." ORDER BY id DESC");

	while ($result = DB::fetch($query)) {
		$tscnn .= "<tr><td><font color='".$result['color']."' style='text-shadow:0 0 1px #fff, 0 0 2px #fff, 0 0 3px #fff, 0 0 4px ".$result['light'].", 0 0 5px ".$result['light'].";'><b>".$_G['username']."</b></font></td><td>".$ctime." ".$ldd."</td><td>".$result['price']." ".$lmoneyy."</td><td><a href='home.php?mod=spacecp&ac=plugin&id=color_cname:cname&pluginop=buy&bid=".$result['id']."&hash=".FORMHASH."'>[".$lbuy."]</a></td></tr>";
	}
	}
}

$t_cshop=lang('plugin/color_cname', 'cshop');
$t_myusername=lang('plugin/color_cname', 'myusername');
$buydate=lang('plugin/color_cname', 'buydate');
$cshoponoff = $_G['cache']['plugin']['color_cname']['onoff'];
$cshopclose = $_G['cache']['plugin']['color_cname']['offinfo'];
if($cshoponoff=="0"):$tip=$cshopclose;elseif($cshoponoff=="1"):$tip=lang('plugin/color_cname', 'tipcshop');endif;
$show = DB::fetch_first("SELECT * FROM ".DB::table('cname')." WHERE uid='".$_G['uid']."'");
if(!$show){
	$username="<b>".$_G['username']."</b>";
	$tbuydate=lang('plugin/color_cname', 'nocname');
}else{
	$dd=$_G['cache']['plugin']['color_cname']['time']*3600*24;
	$tbuyd=$show['date']+$dd;
	if(strtotime(date("Y-m-d"))<$tbuyd){
		$username=$show['username']."<b>".$_G['username']."</b></font>";
		$tbuydate=date('Y-m-d',$tbuyd);
	}else{
		$username="<b>".$_G['username']."</b>";
		$tbuydate=lang('plugin/color_cname', 'yiguoqi');
	}
}


?>