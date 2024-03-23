<?php
/**
*Plugin Name: BCMV For VTUPRESS
*Plugin URI: https://summusuniversity.com.ng
*Description: This Add-on adds Bill Payment and Cable TV Subscription to your VTUPRESS plug-in.
*Version: 1.2.9
*Author: Akor Victor
*Author URI: https://facebook.com/bikendi-tech-solutions
*/
if(!defined('ABSPATH')){
    $pagePath = explode('/wp-content/', dirname(__FILE__));
    include_once(str_replace('wp-content/' , '', $pagePath[0] . '/wp-load.php'));
};
if(WP_DEBUG == false){
error_reporting(0);	
}
include_once(ABSPATH."wp-load.php");
include_once(ABSPATH.'wp-admin/includes/plugin.php');
$path = WP_PLUGIN_DIR.'/vtupress/functions.php';
if(file_exists($path) && in_array('vtupress/vtupress.php', apply_filters('active_plugins', get_option('active_plugins')))){
include_once(ABSPATH .'wp-content/plugins/vtupress/functions.php');
}
else{
	if(!function_exists("vp_updateuser")){
function vp_updateuser(){
	
}

function vp_getuser(){
	
}

function vp_adduser(){
	
}

function vp_updateoption(){
	
}

function vp_getoption(){
	
}

function vp_option_array(){
	
}

function vp_user_array(){
	
}

function vp_deleteuser(){
	
}

function vp_addoption(){
	
}

	}
}



function sbill(){
global $wpdb;
$sbill = $wpdb->prefix.'sbill';
$charset_collate = $wpdb->get_charset_collate();
$sql = "CREATE TABLE IF NOT EXISTS $sbill(
id int NOT NULL AUTO_INCREMENT,
name text ,
email varchar(255) ,
meterno text ,
product_id text ,
phone text ,
type text ,
meter_token text,
bal_bf text,
bal_nw text,
amount text ,
resp_log text ,
user_id int ,
status text ,
time text ,
request_id text ,
via text ,
browser text ,
charge text,
time_taken text ,
trans_type text ,
trans_method text ,
response_id text,
run_code text,
queried text ,
PRIMARY KEY  (id))$charset_collate;";
require_once(ABSPATH.'wp-admin/includes/upgrade.php');
dbDelta($sql);
}


function sbilldata(){
global $wpdb;
$sbilldata = $wpdb->prefix.'sbill';
$data = array(
'name' => 'Akor Victor',
'email' => 'summusuniversity@gmail.com',
'meterno' => '333333333333',
'product_id' => 'abuja-electric',
'phone' => '07049626922',
'bal_bf' => '10',
'bal_nw' => '10',
'type' => 'AEDC',
'meter_token' => '0000000000',
'amount' => '1',
'resp_log' => 'sample of successful bill log',
'user_id' => '1',
'status' => 'Successful',
'request_id' => '2022',
'time_taken' => '0s',
'browser' => 'CHROME',
'via' => 'site',
'trans_type' => 'prepaid',
'trans_method' => 'none',
'queried' => '0',
'time' => current_time('mysql',1));

$wpdb->insert($sbilldata,$data);
}


//for cable
function scable(){

global $wpdb;
$scable = $wpdb->prefix.'scable';
$charset_collate = $wpdb->get_charset_collate();
$sql = "CREATE TABLE IF NOT EXISTS $scable(
id int  NOT NULL  AUTO_INCREMENT,
name text ,
email varchar(255) ,
iucno text ,
product_id text ,
phone text,
type text ,
bal_bf text,
bal_nw text,
amount text ,
resp_log text ,
user_id int ,
status text ,
time text ,
request_id text ,
response_id text,
run_code text,
via text ,
browser text ,
time_taken text ,
trans_type text ,
trans_method text ,
queried text ,
PRIMARY KEY  (id))$charset_collate;";
require_once(ABSPATH.'wp-admin/includes/upgrade.php');
dbDelta($sql);
}

function scabledata(){
global $wpdb;
$scabledata = $wpdb->prefix.'scable';
$data = array(
'name' => 'Akor Victor',
'email' => 'summusuniversity@gmail.com',
'iucno' => '36528715288',
'product_id' => 'gotv-max',
'phone' => '07049626922',
'bal_bf' => '10',
'bal_nw' => '10',
'type' => 'GOTV',
'amount' => '1',
'resp_log' => 'sample of successful cable log',
'user_id' => '1',
'status' => 'Successful',
'request_id' => '2022',
'time_taken' => '0s',
'browser' => 'CHROME',
'via' => 'site',
'trans_type' => 'gotv',
'trans_method' => 'none',
'queried' => '0',
'time' => current_time('mysql',1));

$wpdb->insert($scabledata,$data);
}




add_action("vtupress_history_condition","addbcmvservices");
function addbcmvservices(){
  $bill = false;
  if($bill){

  }
  elseif($_GET["subpage"] == "cable" && $_GET["type"] == "successful"){
    include_once(ABSPATH .'wp-content/plugins/bcmv/pages/scable.php');
  }
  elseif($_GET["subpage"] == "cable" && $_GET["type"] == "unsuccessful"){
    include_once(ABSPATH .'wp-content/plugins/bcmv/pages/fcable.php');
  }
  elseif($_GET["subpage"] == "cable" && $_GET["type"] == "failed"){
    include_once(ABSPATH .'wp-content/plugins/bcmv/pages/opcable.php');
  }
  elseif($_GET["subpage"] == "bill" && $_GET["type"] == "successful"){
    include_once(ABSPATH .'wp-content/plugins/bcmv/pages/sbill.php');
  }
  elseif($_GET["subpage"] == "bill" && $_GET["type"] == "unsuccessful"){
    include_once(ABSPATH .'wp-content/plugins/bcmv/pages/fbill.php');
  }
  elseif($_GET["subpage"] == "bill" && $_GET["type"] == "failed"){
    include_once(ABSPATH .'wp-content/plugins/bcmv/pages/opbill.php');
  }
}

add_action("vtupress_history_submenu","addbcmvsubmenu");
function addbcmvsubmenu(){
?>
<li class="sidebar-item bg bg-success">   
                  <a
                  class="sidebar-link has-arrow waves-effect waves-dark"
                  href="javascript:void(0)"
                  aria-expanded="false"
                  ><i class="mdi mdi-television-guide"></i
                  ><span class="hide-menu">Cable</span></a
                >
                <ul aria-expanded="false" class="collapse first-level">
                <li class="sidebar-item">
                      <a href="?page=vtupanel&adminpage=history&subpage=cable&type=unsuccessful" class="sidebar-link"
                      ><i class="mdi mdi-network-question"></i
                      ><span class="hide-menu">Pending</span></a
                    >
                  </li>
                <li class="sidebar-item">
                      <a href="?page=vtupanel&adminpage=history&subpage=cable&type=successful" class="sidebar-link"
                      ><i class="far fa-check-circle"></i
                      ><span class="hide-menu">Successful</span></a
                    >
                  </li>
                  <li class="sidebar-item">
                      <a href="?page=vtupanel&adminpage=history&subpage=cable&type=failed" class="sidebar-link"
                      ><i class="fas fa-ban"></i
                      ><span class="hide-menu">Failed</span></a
                    >
                  </li>
</ul>
</li>          
 <li class="sidebar-item bg bg-success">   
                  <a
                  class="sidebar-link has-arrow waves-effect waves-dark"
                  href="javascript:void(0)"
                  aria-expanded="false"
                  ><i class="mdi mdi-lightbulb""></i
                  ><span class="hide-menu">Bill</span></a
                >
                <ul aria-expanded="false" class="collapse first-level">
                <li class="sidebar-item">
                      <a href="?page=vtupanel&adminpage=history&subpage=bill&type=unsuccessful" class="sidebar-link"
                      ><i class="mdi mdi-network-question"></i
                      ><span class="hide-menu">Pending</span></a
                    >
                  </li>
                <li class="sidebar-item">
                      <a href="?page=vtupanel&adminpage=history&subpage=bill&type=successful" class="sidebar-link"
                      ><i class="far fa-check-circle"></i
                      ><span class="hide-menu">Successful</span></a
                    >
                  </li>
                  <li class="sidebar-item">
                      <a href="?page=vtupanel&adminpage=history&subpage=bill&type=failed" class="sidebar-link"
                      ><i class="fas fa-ban"></i
                      ><span class="hide-menu">Failed</span></a
                    >
                  </li>
</ul>
</li>
<?php
}




register_activation_hook(__FILE__,'sbill');
register_activation_hook(__FILE__,'sbilldata');
register_activation_hook(__FILE__,'scable');
register_activation_hook(__FILE__,'scabledata');

?>
