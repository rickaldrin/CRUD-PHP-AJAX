<?php 
define('SECURITY_CHECK',1);
include_once ('class/config.php');
include_once ('class/function.php');
$con = new config();
$function_class = new function_class($con);

if (isset($_POST['submit_todo'])) {

	$task_name = $_POST['task_name'];
  	$submit_todo = $function_class->insert_task($task_name);
	echo json_encode($submit_todo);

}elseif (isset($_POST['delete_todo'])) {

	$task_id = $_POST['task_id'];
  	$delete_todo = $function_class->delete_task($task_id);
	echo json_encode($delete_todo);

}elseif (isset($_POST['update_todo'])) {

	$task_id = $_POST['task_id'];
	$todo_status = $_POST['task_status'];
  	$update_todo = $function_class->update_task($task_id,$todo_status);
	echo json_encode($update_todo);

}else{

	echo "no_isset()";
}

?>