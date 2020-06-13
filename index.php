<?php
include_once ('class/config.php');
$con = new config();

?>
<!DOCTYPE html>
<html>
<head>
	<title>CRUD PHP + Ajax</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>
	<body data-gr-c-s-loaded="true">
    <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
  <h5 class="my-0 mr-md-auto font-weight-normal">CRUD</h5>
</div>



<div class="container">
 
  <div class="row">
    <div class="col-md-8">
        <div id="msg_result"></div>
    </div>
    <div class="col-md-4">
      <div class="float-right">
        <form class="form-inline" method="POST" action="#">
          <label class="sr-only" for="task_name">Task</label>
          <input type="text" class="form-control mb-2 mr-sm-2" id="task_name" name="task" placeholder="Enter task">
          <button type="submit" id="submit_task" class="btn btn-primary mb-2">Submit</button>
        </form>
      </div>
    </div>
  </div>
 
 	<table class="table table-striped">
  <thead class="thead-dark">
    <tr>
      <th>#</th>
      <th>Task</th>
      <th>Status</th>
      <th>Date & Time</th>
      <th>Action</th>
    </tr>
  </thead>
   <tbody id="new_row">
  <?php 

  $str ="SELECT * FROM todo";
  $qry = $con->select_table($str,array(null),'Select Error query');
  $count = 1;
   while ($row = $qry->fetch()) {
     echo "<tr class='row_".$row['todo_id']."'>
            <td>".$count."</td>
            <td>".$row['task_name']."</td>
            <td class='row_status_".$row['todo_id']."'>".$row['task_status']."</td>
            <td>".$row['dtc']."</td>
            <td>
            <div class='row'>
            <div class='col-md-8'>
            <select class='form-control' id='change_status_".$row['todo_id']."' onchange='update_task(".$row['todo_id'].")'>
                <option disabled selected>Choose status</option>
                <option value='Pending'>Pending</option>
                <option value='Completed'>Completed</option>
              </select>
            </div>
              <div class='col-md-4'>
                <button type='button' onclick='delete_task(".$row['todo_id'].")' class='btn btn-danger'>Delete</button>
              </div>
              </div>
             </td>
            </tr>";

      $count++;
   }

  ?>

 </tbody>
</table>
<input type="hidden" id="next_count_row" value="<?php echo $count; ?>">
</div>


</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

<script type="text/javascript">
  $( "#submit_task" ).click(function(e) {
      
    let task_name = $('#task_name').val();
    let next_count_row = $('#next_count_row').val();
    
    $.ajax({
          url: 'process.php',
          method:"POST",
          dataType: "json",
          data:{
                  submit_todo:1,
                  task_name:task_name  
          },
         
          beforeSend: function() {
          // setting a timeout
             console.log('beforeSend');

          },
          success:function(response){
            console.log(response);

            if(response.result == 0){

              let msg_res = '<div class="alert alert-danger alert-dismissible fade show" role="alert">'+response.message+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button></div>';
              $('#msg_result').html(msg_res);

            }else{

              let msg_res = '<div class="alert alert-success alert-dismissible fade show" role="alert">'+response.message+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button></div>';
              $('#msg_result').html(msg_res);

              $("#new_row").append('<tr class="row_'+response.task_id+'"><td>'+next_count_row+'</td><td>'+response.task_name+'</td><td class="row_status_'+response.task_id+'">'+response.status+'</td><td>'+response.dtc+'</td><td><div class="row"> <div class="col-md-8"> <select class="form-control" id="change_status_'+response.task_id+'" onchange="update_task('+response.task_id+')"> <option disabled selected>Choose status</option> <option value="Pending">Pending</option> <option value="Completed">Completed</option> </select> </div><div class="col-md-4"> <button type="button" onclick="delete_task('+response.task_id+')" class="btn btn-danger">Delete</button> </div></div></td></tr>');
              $('#next_count_row').val(Number(next_count_row) + Number(1));
            }

        }

      });

    e.preventDefault(); // avoid to execute the actual submit of the form.
});
 
  function delete_task(id) {
 

  $.ajax({
          url: 'process.php',
          method:"POST",
          dataType: "json",
          data:{
                  delete_todo:1,
                  task_id:id  
          },
         
          beforeSend: function() {
          // setting a timeout
             console.log('beforeSend');

          },
          success:function(response){
            console.log(response);

            if(response.result == 0){

              let msg_res = '<div class="alert alert-danger alert-dismissible fade show" role="alert">'+response.message+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button></div>';
              $('#msg_result').html(msg_res);

            }else{

              let msg_res = '<div class="alert alert-success alert-dismissible fade show" role="alert">'+response.message+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button></div>';
              $('#msg_result').html(msg_res);
              $('.row_'+id).remove();
            }

        }

      });

}


function update_task(id) {
  
  
   let task_status = $('#change_status_'+id).val();

  
  $.ajax({
          url: 'process.php',
          method:"POST",
          dataType: "json",
          data:{
                  update_todo:1,
                  task_id:id,
                  task_status:task_status 
          },
         
          beforeSend: function() {
          // setting a timeout
             console.log('beforeSend');

          },
          success:function(response){
            console.log(response);

            if(response.result == 0){

              let msg_res = '<div class="alert alert-danger alert-dismissible fade show" role="alert">'+response.message+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button></div>';
              $('#msg_result').html(msg_res);

            }else{

              let msg_res = '<div class="alert alert-success alert-dismissible fade show" role="alert">'+response.message+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button></div>';
              $('#msg_result').html(msg_res);
              $('.row_status_'+id).text(task_status);
            }

        }

      });

}

</script>
</html>