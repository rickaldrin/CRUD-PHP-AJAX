<?php 

/**
 * You can extends class config.
 */
class function_class {
	
	public function __construct($con){

		$this->con = $con;
		$this->dtc = date("Y-m-d H:i:s");
	}

	public function insert_task($task_name){
		
		if (empty($task_name)) {
			
			$res = 0;
			$msg = "Required Task.";
			$task_name = null;
			$status = null;
			$dtc = null;
			$lastinsert_id = null;
			
		}else{

			$new_insert = array('task_name' => $task_name, 'dtc' => $this->dtc);
  			$submit_todo = $this->con->insert_table('todo',$new_insert,'Error insert data');
  			$lastinsert_id = $this->con->lastinsert_table();

  			if ($submit_todo == 1) {
  				// task_name, status, dtc
  				$str = "SELECT * FROM todo WHERE todo_id = ?";
  				$qry = $this->con->select_table($str,array($lastinsert_id),"error_log(select todo)");
  				if ($row = $qry->fetch()) {
  					$task_name = $row['task_name'];
  					$status = $row['task_status'];
  					$dtc = $row['dtc'];
  					$res = 1;
					$msg = "Task added.";
  				}
  				
  			}else{

  				$task_name = null;
				$status = null;
				$dtc = null;
  				$res = 0;
				$msg = $submit_todo;
				$lastinsert_id = null;
  			}
			
		}

		return array('result' => $res, 'message' => $msg, 'task_name' => $task_name, 'status' => $status, 'dtc' => $dtc, 'task_id' => $lastinsert_id);
	}


	public function delete_task($task_id){

		if (empty($task_id)) {
			
			$res = 0;
			$msg = "Required task_id.";

		}else{

			 $str ="DELETE FROM todo WHERE todo_id = ?";
 			 $qry = $this->con->delete_table($str,array($task_id),'Delete Error query');
 			 $res = 1;
			 $msg = "Task Deleted.";
		}
		
		return array('result' => $res, 'message' => $msg);
	}

	public function update_task($task_id,$todo_status){

		if (empty($task_id)) {
			
			$res = 0;
			$msg = "Required task_id.";

		}elseif (empty($todo_status)) {
			
			$res = 0;
			$msg = "Required todo_status.";
		

		}else{

			 $str ="UPDATE  todo SET task_status = ? WHERE todo_id = ?";
 			 $qry = $this->con->update_table($str,array($todo_status,$task_id),'Delete Error query');
 			 $res = 1;
			 $msg = "Task Updated.";
		}
		
		return array('result' => $res, 'message' => $msg);
	}

}/* end class*/


?>