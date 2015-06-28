<?php

/**
 *          @starstudio
 *          @author zzy
 */

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
//根据接收到的操作值进行对应的控制
if($_GET['op'] == 'new') {
	$color=addslashes(trim($_POST['color']));
	$light=addslashes(trim($_POST['light']));
	$price=intval($_POST['price']);
	if(!eregi("^#[0-9a-fA-F]{3,6}$","$color") || !eregi("^#[0-9a-fA-F]{3,6}$","$light")):cpmsg(lang('plugin/color_cname', 'nocolor'),'','error');endif;
	if($price == ''):cpmsg(lang('plugin/color_cname', 'noprice'), '', 'error');else:DB::query("INSERT INTO ".DB::table('cnameshop')."(color, light, price) VALUES ('$color', '$light', '$price')");cpmsg(lang('plugin/color_cname', 'addok'), 'action=plugins&operation=config&do='.$pluginid.'&identifier=color_cname&pmod=cshop', 'succeed');endif;
} elseif($_GET['op'] == 'edit') {
	$id=intval($_GET['id']);
	if($id == '' || $id == '0'):cpmsg(lang('plugin/color_cname', 'error1'), '', 'error');else:$cname = DB::fetch_first("SELECT * FROM ".DB::table('cnameshop')." WHERE id='".$id."'");$lx=lang('plugin/color_cname', 'edit');$lc=lang('plugin/color_cname', 'color');$ll=lang('plugin/color_cname', 'light');$lp=lang('plugin/color_cname', 'price');$lh=lang('plugin/color_cname', 'handle');include template('color_cname:cname_edit');endif;
} elseif($_GET['op'] == 'editok'){
	$color=addslashes(trim($_POST['color']));
	$light=addslashes(trim($_POST['light']));
	$price=intval($_POST['price']);
	$id=intval($_GET['id']);
	if(!eregi("^#[0-9a-fA-F]{3,6}$","$color") || !eregi("^#[0-9a-fA-F]{3,6}$","$light")):cpmsg(lang('plugin/color_cname', 'nocolor'),'','error');endif;
	if($id == '' || $id == '0'):cpmsg(lang('plugin/color_cname', 'error1'), '', 'error');elseif($price == ''):cpmsg(lang('plugin/color_cname', 'noprice'), '', 'error');else:DB::query("update ".DB::table('cnameshop')." set color='$color', light='$light', price='$price' WHERE id='".$id."'");cpmsg(lang('plugin/color_cname', 'editok'), 'action=plugins&operation=config&do='.$pluginid.'&identifier=color_cname&pmod=cshop', 'succeed');endif;
} elseif($_GET['op'] == 'delete'){
	$id=intval($_GET['id']);
	if($id == '' || $id == '0'):cpmsg(lang('plugin/color_cname', 'error1'), '', 'error');else:DB::query("DELETE FROM ".DB::table('cnameshop')." WHERE id='".$id."'");cpmsg(lang('plugin/color_cname', 'delok'), 'action=plugins&operation=config&do='.$pluginid.'&identifier=color_cname&pmod=cshop', 'succeed');endif;
} else{
	$lc=lang('plugin/color_cname', 'color');
	$ll=lang('plugin/color_cname', 'light');
	$lp=lang('plugin/color_cname', 'price');
	$le=lang('plugin/color_cname', 'effect');
	$lh=lang('plugin/color_cname', 'handle');
	$lt=lang('plugin/color_cname', 'title');
	$lx=lang('plugin/color_cname', 'edit');
	$ls=lang('plugin/color_cname', 'delete');
	$btn=lang('plugin/color_cname', 'new');
	echo '<table class="tb tb2"><tbody><tr class="header"><th>id</th><th>'.$lc.'</th><th>'.$ll.'</th><th>'.$le.'</th><th>'.$lp.'</th><th>'.$lh.'</th></tr>';              
	$query = DB::query("SELECT * from ".DB::table('cnameshop')." ORDER BY id DESC");
	while ($result = DB::fetch($query)) {

		echo "<tr><td>".$result['id']."</td><td>".$result['color']."</td><td>".$result['light']."</td><td><font color='".$result['color']."' style='text-shadow:0 0 1px #fff, 0 0 2px #fff, 0 0 3px #fff, 0 0 4px ".$result['light'].", 0 0 5px ".$result['light'].";'><b>".$lt."</b></font></td><td>".$result['price']."</td><td><a href='admin.php?action=plugins&operation=config&do=".$pluginid."&identifier=color_cname&pmod=cshop&id=".$result['id']."&op=edit'>[".$lx."]</a><a href='admin.php?action=plugins&operation=config&do=".$pluginid."&identifier=color_cname&pmod=cshop&id=".$result['id']."&op=delete'>[".$ls."]</a></td></tr>";

	}
	include template('color_cname:cname_new');
	echo "</tbody></table>";
}

?>
