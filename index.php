<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="manifest" href="manifest.json" />
  </head>
  <body>
    <?php include_once('constants.php'); ?>
    <header>

      <nav class="navbar navbar-light ">
        <a class="navbar-brand" href="#">CMS</a>
        <div class="position-relative dropdown d-md-none">
          <a class="position-relative navbar-link dropdown-toggle-no-caret mr-3" href="#" role="button" id="link-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-bars fa-1x"></i>
          </a>
          <div class="dropdown-menu" aria-labelledby="link-dropdown">
            <h6><a class="nav-link disabled" href="#">Dashboard</a></h6>
            <h6><a class="nav-link active" href="#">Students</a></h6>
            <h6><a class="nav-link disabled" href="#">Tasks</a></h6>
          </div>
        </div> 
        
        <div class="position-relative dropdown ml-auto">
          <a class="position-relative navbar-link dropdown-toggle-no-caret mr-3" href="#" role="button" id="notification-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-bell fa-2x text-dark"></i>
            <span class="position-absolute badge badge-pill badge-danger animate__animated animate__heartBeat">1</span>  
          </a>
          <div class="dropdown-menu" aria-labelledby="notification-dropdown">
            <h6 class="dropdown-item"><img src="img/profile_pic.jpg" class="navbar-item rounded-circle message-pic " alt="Profile picture">User1: Hello</h6>
            <h6 class="dropdown-item"><img src="img/profile_pic.jpg" class="navbar-item rounded-circle message-pic " alt="Profile picture">User2: How is review?</h6>
          </div>
        </div> 
    
        <img src="img/profile_pic.jpg" class="navbar-item rounded-circle profile-pic mr-3" alt="Profile picture">
        <div class="dropdown">
          <a class="navbar-link dropdown-toggle-no-caret" href="#" role="button" id="profile-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Oleksandr Babilia
          </a>
          <div class="dropdown-menu" aria-labelledby="profile-dropdown">
            <a class="dropdown-item" href="#">My profile</a>
            <a class="dropdown-item" href="#">Log out</a>
          </div>
        </div>
      </nav>

    </header>
    
    <!-- Table -->
    <div class="container-fluid">    
      <div class="row">
        <nav class="nav flex-column ml-5 mt-3 col-md-3 d-none d-md-block" >
          <h4><a class="nav-link disabled" href="#">Dashboard</a></h4>
          <h4><a class="nav-link active" href="file:///C:/Users/djess/OneDrive/Desktop/4%20SEM/Labs/PVI/Lab1/lab1_2.0/index.html">Students</a></h4>
          <h4><a class="nav-link disabled" href="#">Tasks</a></h4>
        </nav>
        <div class="col-md-6 col-12 mt-4">
          <h1>Students</h1>
          <button class="btn float-right bg-transparent icon-holder" id="add_student" data-toggle="modal" data-target="#addModal" data-source="addButton"><i class="fas fa-plus-square" ></i></button>
          <div class="table-responsive">
            <table class="table table-bordered">
              <tr class="text-center">
                <th><input type="checkbox" name="select" id="check-all"></th>
                <th>Group</th>
                <th>Name</th>
                <th>Gender</th>
                <th>Birthday</th>
                <th>Status</th>
                <th>Options</th> 
              </tr>
              <?php 
              $students = $conn->query("SELECT * FROM students"); 
                
              
              foreach ($students as $student) {
                 
               ?>
                     
                      <tr class="text-center" data-id="<?= $student['id'] ?>">
                        <td>
                          <input type="checkbox" name="select">
                        </td>    
                        <td><?= $groups_arr[$student['group_id']] ?></td>    
                        <td class="user-name" data-name='<?= $student['name']?>' data-surname='<?= $student['surname']?>'><?= $student['name'] . " " .   $student['surname'] ?></td>    
                        <td><?= $genders_arr[$student['gender_id']] ?></td>    
                        <td><?= $student['birthday'] ?></td>   
                        <td><figure class="circle-green"></figure></td>
                        <td>
                          <button class="btn bg-transparent edit-btn icon-holder"><i class=" far fa-edit edit-btn"></i></button>    
                          <button class="btn bg-transparent delete-btn icon-holder"><i class="fas fa-trash-alt "></i></button>
                      </td>
                    </tr>
                    <?php  } 
                    
                  ?>
            </table>
          </div>
          <ul class="pagination justify-content-center">
            <li class="page-item disabled">
              <a class="page-link" href="#" tabindex="-1"><<</a>
            </li>
            <li class="page-item"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item"><a class="page-link" href="#">4</a></li>
            <li class="page-item">
              <a class="page-link" href="#">>></a>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <!-- Add/Edit Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="addModalLabel"></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form>
              <div class="form-group">
                <input type="number" class="d-none" id="id_student">
                <label for="group">Group</label>
                <select class="form-control" id="group">
                  <option value="0">Select group</option>
                    <?php foreach($groups_arr as $key => $group) { ?>
                      <option value="<?= $key ?>"><?=$group?></option>
                    <?php  } ?>
                </select>
                <div id="group-error" class="invalid-feedback" hidden>

                </div>
              </div>
              <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter name">
                <div id="first-name-error" class="invalid-feedback" hidden>

                </div>
              </div>
              <div class="form-group">
                <label for="surname">Surname</label>
                <input type="text" class="form-control" id="surname" name="surname" placeholder="Enter surname">
                <div id="last-name-error" class="invalid-feedback" hidden>

                </div>
              </div>
              <div class="form-group">
                <label for="gender">Gender</label>
                <select class="form-control" id="gender">
                <option value="0">Select gender</option>
                  <?php foreach($genders_arr as $key => $gender) { ?>
                      <option value="<?= $key ?>"><?= $gender ?></option>
                  <?php  } ?>
            
                </select>
                <div id="gender-error" class="invalid-feedback" hidden>

                </div>
              </div>
              <div class="form-group">
                <label for="dob">Date of Birth</label>
                <input type="date" class="form-control" id="dob" >
                <div id="birthday-error" class="invalid-feedback" hidden>
                
                </div>
              </div>
              <div class="form-group"  id="server-error-addModal" hidden>
              
              </div>
              
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="addData">Confirm</button>
          </div>
        </div>
      </div>
    </div>
    <!-- Delete Modal -->
    <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="confirmModalLabel">Confirmation</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body" id="delete-text">
          <input type="number" class="d-none" id="id_delete_student">
            Are you sure you want to delete this student?
          </div>
          <div class="form-group" id="server-error-deleteModal" hidden>
              
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
          </div>
        </div>
      </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="js/modal_window_handler.js"></script>
    
  </body>
</html>