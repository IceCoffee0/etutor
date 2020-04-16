<?php
    require './functions.php';
    session_start();
    checkUser(3); // Level: Staff
?>

<head>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js" integrity="sha384-6khuMg9gaYr5AxOqhkVIODVIvm9ynTT5J4V1cfthmT+emCG6yVmEZsRHdxlotUnm" crossorigin="anonymous"></script>
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>

<body>
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
  Allocate Student Button
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
            
            <div>
                <ul style="list-style: none;">
                    <?php 
                    $students = getUnAllocatedStudents();
                    foreach($students as $student) {
                        ?>
                            <li>
                                <input id="<?= $student['user_id'] ?>"  type="checkbox" name="student[]" value="<?= $student['user_id'] ?>">
                                <label> <?= $student['fullname'] ?> </label> <br>
                            </li>
                        <?php
                        }
                    ?>
               </ul>
            </div>

        </div>
        <div class="modal-footer">
            <input type="submit" name="allocate" value="Save" class="btn btn-secondary">
        </div>
      </form>    
    </div>
  </div>
</div>
</body>