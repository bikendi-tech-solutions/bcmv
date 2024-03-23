<?php
if(!defined('ABSPATH')){
    $pagePath = explode('/wp-content/', dirname(__FILE__));
    include_once(str_replace('wp-content/' , '', $pagePath[0] . '/wp-load.php'));
}
if(WP_DEBUG == false){
error_reporting(0);	
}
include_once(ABSPATH."wp-load.php");
include_once(ABSPATH .'wp-content/plugins/vtupress/admin/pages/history/functions.php');
include_once(ABSPATH .'wp-content/plugins/vtupress/functions.php');

?>

<div class="row">

    <div class="col-12">
    <link
      rel="stylesheet"
      type="text/css"
      href="<?php echo esc_url(plugins_url("vtupress/admin")); ?>/assets/extra-libs/multicheck/multicheck.css"
    />
    <link
      href="<?php echo esc_url(plugins_url("vtupress/admin")); ?>/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css"
      rel="stylesheet"
    />
<div class="card">
                <div class="card-body">
                  <h5 class="card-title">Pending Bill Payments</h5>

                  <?php

if(!isset($_GET["trans_id"])){
    pagination_history_before("sbill","false");
}
elseif(empty($_GET["trans_id"])){
  pagination_history_before("sbill","false");
}
else{
    if(is_numeric($_GET["trans_id"])){
        $id = $_GET["trans_id"];
        pagination_history_before("sbill","false","AND id = '$id'");
    }
    else{
        $id = $_GET["trans_id"];
        pagination_history_before("sbill","false","AND request_id = '$id'");
    }
}


?>

                  <div class="table-responsive">
                    <table
                      id="zero_config"
                      class="table table-striped table-bordered"
                    >
                      <thead>
                      <tr>
                      <th class="">
                          <label class="customcheckbox mb-3">
                            <input type="checkbox" id="mainCheckbox"  />
                            <span class="checkmark"></span>
                          </label>
                        </th>
<th scope='col'>ID</th>
<th scope='col' class=''>Request ID</th>
<th scope='col'>R.ID</th>
<th scope='col'>User Name</th>
<th scope='col'>User Email</th>
<th scope='col'>Meter Number</th>
<th scope='col'>Meter Token</th>
<th scope='col'>Product Id</th>
<th scope='col'>Amount</th>
<th scope='col'>User ID</th>
<th scope='col'>Type</th>
<th scope='col'>Time</th>
<th scope='col' class=''>Browser</th>
<th scope='col' class=''>T.Type</th>
<th scope='col' class=''>T.Method</th>
<th scope='col' class=''>T.Calls</th>
<th scope='col' class=''>Via</th>
<th scope='col'>Action</th>
<th scope='col'>Response</th>
</tr>
                      </thead>
                      <tbody>
                   
                      <?php


global $transactions;
if($transactions == "null"){
?>
    <tr  class="text-center">
    <td colspan="8">No Successful Transaction Found</td>
    </tr>
<?php
}else{
            $option_array = json_decode(get_option("vp_options"),true);
global $wpdb;
#GET LEVELS
$table_name = $wpdb->prefix."vp_levels";
$level = $wpdb->get_results("SELECT * FROM  $table_name");

$current_amt = 0;

foreach($transactions as $result){


    echo"
    <tr>
    <th class=''>
    <label class=\"customcheckbox\">
      <input type=\"checkbox\" class=\"listCheckbox\" value=\"$result->id\" amount='$result->amount' user='$result->user_id'/>
      <span class=\"checkmark\"></span>
    </label>
  </th>
    <th scope='row'>".$result->id."</th>
    <th scope='row'>".vp_getvalue($result->request_id)."</th>
    <th scope='row'>".vp_getvalue($result->response_id)."</th>
    <th>".$result->name."</td>
    <td>".$result->email."</td>
    <td>".$result->meterno."</td>
    <td>".$result->meter_token."</td>
    <td>".$result->product_id."</td>
    <td>".$result->amount."</td>
    <td>".$result->user_id."</td>
    <td>".$result->type."</td>
    <td>".$result->time."</td>
    <td>".vp_getvalue($result->browser)."</td>
    <td>".vp_getvalue($result->trans_type)."</td>
    <td>".vp_getvalue($result->trans_method)."</td>
    <td>".vp_getvalue($result->time_taken)."</td>
    <td>".vp_getvalue($result->via)."</td>
    <td> 
    <div class='input-group'>
    <button class='bg bg-danger' onclick='reversetransaction(\"sbill\",\"".$result->id."\", \"".$result->user_id."\", \"".$result->amount."\");'> <i class=' fas fa-retweet  bg-danger text-white'></i></button>
    <button class='bg bg-success' onclick='approvetransaction(\"sbill\",\"".$result->id."\", \"".$result->user_id."\", \"".$result->amount."\");'> <i class='  fas fa-check bg-success text-white'></i></button>
    </div>
    </td>
    <td>".$result->resp_log."</td>


  </tr>
    ";
    
}

}
                    ?>
                    </tbody>
                    <tfoot>
                    <tr>
                      
                    <th class="">
<label class="customcheckbox mb-3">
  <input type="checkbox" id="mainCheckbox"  />
  <span class="checkmark"></span>
</label>
</th>

<th scope='col'>ID</th>
<th scope='col' class=''>Request ID</th>
<th scope='col'>R.ID</th>
<th scope='col'>User Name</th>
<th scope='col'>User Email</th>
<th scope='col'>Meter Number</th>
<th scope='col'>Meter Token</th>
<th scope='col'>Product Id</th>
<th scope='col'>Amount</th>
<th scope='col'>User ID</th>
<th scope='col'>Type</th>
<th scope='col'>Time</th>
<th scope='col' class=''>Browser</th>
<th scope='col' class=''>T.Type</th>
<th scope='col' class=''>T.Method</th>
<th scope='col' class=''>T.Calls</th>
<th scope='col' class=''>Via</th>
<th scope='col'>Action</th>
<th scope='col'>Response</th>
</tr>
                      </tfoot>
                    </table>
                    
<div class="input-group">
  <span class="input-group-text">Bulk Action</span>

  <select onchange="openfunction('sbill','Utility')">
                      <option >--Select--</option>
                      <option value="reverse">Reverse Transaction</option>
                      <option value="success">Mark Successful</option>
                      <option value="delete">Delete Selected Record</option>
</select>
<?php include_once(ABSPATH."wp-content/plugins/vtupress/admin/pages/history/history.php");?>
    
</div>

<script>
function reversetransaction(db,trans_id,user_id,amount){

var obj = {};
obj['trans_id'] = trans_id;
obj['user_id'] = user_id;
obj['amount'] = amount;
obj['table'] = db;
obj['type'] = "Bill";
obj['action'] = 'reverse';
if(confirm("Do You Want To Reverse The Transaction With ID "+trans_id+"?") == true){
  jQuery(".preloader").show();
jQuery.ajax({
  url: "<?php echo esc_url(plugins_url('vtupress/admin/pages/history/saves/history.php'));?>",
  data: obj,
  dataType: "json",
  "cache": false,
  "async": true,
  error: function (jqXHR, exception) {
	  jQuery(".preloader").hide();
        var msg = "";
        if (jqXHR.status === 0) {
            msg = "No Connection.\n Verify Network.";
     swal({
  title: "Error!",
  text: msg,
  icon: "error",
  button: "Okay",
});
  
        } else if (jqXHR.status == 404) {
            msg = "Requested page not found. [404]";
			 swal({
  title: "Error!",
  text: msg,
  icon: "error",
  button: "Okay",
});
        } else if (jqXHR.status == 500) {
            msg = "Internal Server Error [500].";
			 swal({
  title: "Error!",
  text: msg,
  icon: "error",
  button: "Okay",
});
        } else if (exception === "parsererror") {
            msg = "Requested JSON parse failed.";
			   swal({
  title: msg,
  text: jqXHR.responseText,
  icon: "error",
  button: "Okay",
});
        } else if (exception === "timeout") {
            msg = "Time out error.";
			 swal({
  title: "Error!",
  text: msg,
  icon: "error",
  button: "Okay",
});
        } else if (exception === "abort") {
            msg = "Ajax request aborted.";
			 swal({
  title: "Error!",
  text: msg,
  icon: "error",
  button: "Okay",
});
        } else {
            msg = "Uncaught Error.\n" + jqXHR.responseText;
			 swal({
  title: "Error!",
  text: msg,
  icon: "error",
  button: "Okay",
});
        }
    },
  success: function(data) {
	jQuery(".preloader").hide();
        if(data == "100" ){
	
		  swal({
  title: "Done!",
  text: "Transaction Refunded",
  icon: "success",
  button: "Okay",
}).then((value) => {
	location.reload();
});
	  }
	  else{
		  
	jQuery(".preloader").hide();
	 swal({
  title: "Error",
  text: "Process Wasn't Completed",
  icon: "error",
  button: "Okay",
});
	  }
  },
  type: "POST"
});



}
else{

    return;
}

}


function approvetransaction(db,trans_id,user_id,amount){

var obj = {};
obj['trans_id'] = trans_id;
obj['user_id'] = user_id;
obj['amount'] = amount;
obj['table'] = db;
obj['type'] = "Bill";
obj['action'] = 'success';
if(confirm("Do You Want To Mark The Transaction With ID "+trans_id+" Successful?")){

jQuery.ajax({
  url: "<?php echo esc_url(plugins_url('vtupress/admin/pages/history/saves/history.php'));?>",
  data: obj,
  dataType: "json",
  "cache": false,
  "async": true,
  error: function (jqXHR, exception) {
	  jQuery(".preloader").hide();
        var msg = "";
        if (jqXHR.status === 0) {
            msg = "No Connection.\n Verify Network.";
     swal({
  title: "Error!",
  text: msg,
  icon: "error",
  button: "Okay",
});
  
        } else if (jqXHR.status == 404) {
            msg = "Requested page not found. [404]";
			 swal({
  title: "Error!",
  text: msg,
  icon: "error",
  button: "Okay",
});
        } else if (jqXHR.status == 500) {
            msg = "Internal Server Error [500].";
			 swal({
  title: "Error!",
  text: msg,
  icon: "error",
  button: "Okay",
});
        } else if (exception === "parsererror") {
            msg = "Requested JSON parse failed.";
			   swal({
  title: msg,
  text: jqXHR.responseText,
  icon: "error",
  button: "Okay",
});
        } else if (exception === "timeout") {
            msg = "Time out error.";
			 swal({
  title: "Error!",
  text: msg,
  icon: "error",
  button: "Okay",
});
        } else if (exception === "abort") {
            msg = "Ajax request aborted.";
			 swal({
  title: "Error!",
  text: msg,
  icon: "error",
  button: "Okay",
});
        } else {
            msg = "Uncaught Error.\n" + jqXHR.responseText;
			 swal({
  title: "Error!",
  text: msg,
  icon: "error",
  button: "Okay",
});
        }
    },
  success: function(data) {
	jQuery(".preloader").hide();
        if(data == "100" ){
	
		  swal({
  title: "Done!",
  text: "Transaction Successful!",
  icon: "success",
  button: "Okay",
}).then((value) => {
	location.reload();
});
	  }
	  else{
		  
	jQuery(".preloader").hide();
	 swal({
  title: "Error",
  text: "Process Wasn't Completed",
  icon: "error",
  button: "Okay",
});
	  }
  },
  type: "POST"
});



}
else{

    return;
}

}

function loadinfo(id){

window.location = "?page=vtupanel&adminpage=users&subpage=info&id="+id;

}
</script>
                  </div>
                </div>
              </div>
</div>


</div>



<?php
?>