<?php
    require './functions.php';
    session_start();
    checkUser(3); // Level: Staff
?>

<head>
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>

<body>
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#allocate">
  Allocate Student Button
</button>

<!-- Modal -->
<div class="modal fade" id="allocate" tabindex="-1" role="dialog" aria-labelledby="allocate" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Allocate Student</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form name="studentAllocate" action="studentAllocation_func.php" method="POST">  
        <div class="modal-body">

            <div class="teacherSelect">
                <div class="form-group">
                    <label for="teacherSelect">Teacher</label>
                    <select class="form-control" id="teacherSelect" name="teacher">
                      <?php 
                        $teachers = getuserList("tutor");
                        while($row = $teachers->fetch_assoc()) {
                            ?>
                                <option value="<?= $row['user_id']?>"> <?= $row['fullname']?> </option>
                            <?php
                        }
                      ?>
                    </select>
                </div>
            </div>
           
            <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Students
                </button>
                <div class="dropdown-menu col-md-12" aria-labelledby="dropdownMenuButton">
                    <?php 
                    $students = getUnAllocatedStudents();
                    foreach($students as $student) {
                        ?>
                            <a class="dropdown-item" href="javascript:void(0)" style="cursor: default;" data-value="<?= $student['user_id'] ?>" tabIndex="-1"> 
                                <input id=" <?= $student['user_id'] ?> "type="checkbox" name="student[]" value="<?= $student['user_id'] ?>"> 
                                <label for="<?= $student['user_id'] ?>"> <?= $student['fullname'] ?> </label> 
                            </a>
                        <?php
                        }
                    if(count($students) <= 0) {
                        echo "<p>No available students</p>";
                    }
                    ?>
                </div>
            </div>
            
        </div>
        <div class="modal-footer">
            <input type="submit" name="allocate" value="Save" class="btn btn-primary">
        </div>
      </form>    
    </div>
  </div>
</div>
</body>

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script>
    var options = [];
    var total=$(this).find('input[name="student[]"]:checked').length;

    $( '.dropdown-menu a' ).on( 'click', function( event ) {

       var $target = $( event.currentTarget ),
           val = $target.attr( 'data-value' ),
           $inp = $target.find( 'input' ),
           idx;

       if ( ( idx = options.indexOf( val ) ) > -1 ) {
          options.splice( idx, 1 );
          setTimeout( function() { $inp.prop( 'checked', false ) }, 0);
       } else {
          options.push( val );
          setTimeout( function() { $inp.prop( 'checked', true ) }, 0);
       }

       $( event.target ).blur();

       console.log( options );
       return false;
    });
</script>