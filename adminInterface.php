<?php
    include('db.php');
    session_start();
    class adminChange{
        public function addNewUser($con,$query){
            if(mysqli_query($con,$query)){
                echo '<script>alert("New user is added successfully!")</script>';
            }else{
                echo 'script>alert("we are not able to do this task!")</script>';
            }
        }
        public function showUser($con,$query){
            $table=mysqli_query($con,$query);
            if($table){
                $row=$table->fetch_assoc();
                echo "<div class=\"row bg-success text-info text-lg-center\">";
                echo "<div class=\"col-md-5 card m-auto\"><p class=\"card-header\"> user Email:";
                echo $row['userEmail'];
                echo "</p></div>";
                echo "<div class=\"col-md-5 card m-auto\"><p class=\"card-header\"> user Name:";
                echo $row['userName'];
                echo "</p></div>";
                echo "<div class=\"col-md-5 card m-auto\"><p class=\"card-header\"> user Id:";
                echo $row['userId'];
                echo "</p></div>";
                echo "<div class=\"col-md-5 card m-auto\"><p class=\"card-header\"> User Role with us:";
                echo $row['userRole'];
                echo "</p></div>";
                echo "</div>"; 
            }else{
                echo '<script>alert("We are not able to do this task")</script>';
            }
        }
        public function updateUserInfo($con,$query){
            if(mysqli_query($con,$query)){
                echo '<script>alert("Your Information is updated successfully")</script>';
            }else{
                echo '<script>alert("We are not able to do this task")</script>';
            }
        }
        public function updateUserPassword($con,$query){
            if(mysqli_query($con,$query)){
                echo '<script>alert("Your password is updated successfully")</script>';
            }else{
                echo '<script>alert("We are not able to do this task")</script>';
            }
        }
        public function deleteAnyUser($con,$query){
            if(mysqli_query($con,$query)){
                echo '<script>alert("User deleted Successfully!")</script>';
            }else{
                echo '<script>alert("We are not able to do this task! please try again.")</script>';
            }
        }
        public function showAllUserToAdmin($con,$query){
            $table=mysqli_query($con,$query);
            if($table){
                while($row=$table->fetch_assoc()){
                    echo "</br>";
                    echo " user ID ".$row['userId'];
                    echo " user name: ".$row['userName'];
                    echo " userEmail: ".$row['userEmail'];
                    echo " user Role: ".$row['userRole'];
                    echo " valid: ".$row['valid'];
                    echo "<hr/>";
                }
            }else{
                echo 'we are not able to do this task';
            }
        }
        public function approveUser($con,$query){
            if(mysqli_query($con,$query)){
                echo '<script>alert("User is approved successfully!")</script>';
            }else{
                echo '<script>alert("We are not able to do this task!")</script>';
            }
        }
        public function disApproveUser($con,$query){
            if(mysqli_query($con,$query)){
                echo '<script>alert("User is blocked successfully!")</script>';
            }else{
                echo '<script>alert("We are not able to do this task!")</script>';
            }
        }
    }
    if($_SESSION['userRole']=="admin"){
        if(isset($_POST['showDetailClick'])){
            $userId=(int)$_SESSION['userId'];
            $dbObj=new dbConnection();
            $dbObj->connectDb();
            $queryObj=new createQuery();
            $queryObj->selectWithCond($userId);
            $userObj=new adminChange();
            $userObj->showUser($dbObj->con,$queryObj->myQuery);
            $dbObj->dissconnectDb();
        }else if (isset($_POST['logoutClick'])) {
            session_destroy();
            echo '<script>alert("You clicked me! Now i\'m logging you out")</script>';
            header("Location:admin.php");
        }else if(isset($_POST['updateInfo'])){
            $userId=$_POST['userId'];
            $userName=$_POST['userName'];
            $userEmail=$_POST['userEmail'];
            $dbObj=new dbConnection();
            $dbObj->connectDb();
            $queryObj=new createQuery();
            $queryObj->updateInfoQuery($userId,$userName,$userEmail);
            $userObj=new adminChange();
            $userObj->updateUserInfo($dbObj->con,$queryObj->myQuery);
            $dbObj->dissconnectDb();
        }elseif (isset($_POST['updatePassword'])) {
            $userId=$_POST['userId'];
            $userEnteredPassword=$_POST['userEnteredPassword'];
            $userConformationPassword=$_POST['userConformationPassword'];
            if($userEnteredPassword==$userConformationPassword){
                $dbObj=new dbConnection();
                $dbObj->connectDb();
                $queryObj=new createQuery();
                $queryObj->updatePassword($userId,$userEnteredPassword);
                $userObj=new adminChange();
                $userObj->updateUserPassword($dbObj->con,$queryObj->myQuery);
                $dbObj->dissconnectDb();
            }else{
                echo '<script>alert("please enter password carefully!")</script>';
            }
        }else if(isset($_POST['addNewUser'])){
            $userName=$_POST['newUserName'];
            $userEmail=$_POST['newUserEmail'];
            $userRole=$_POST['newUserRole'];
            $userRole=strtolower($userRole);
            $userPassword=$_POST['newUserPassword'];
            $newUservalid=$_POST['newUservalid'];
            // $userPassword=sha1($userPassword);
            $dbObj=new dbConnection();
            $dbObj->connectDb();
            $queryObj=new createQuery();
            $queryObj->addUserQuery($userName,$userEmail,$userRole,$userPassword,$newUservalid);
            $userObj=new adminChange();
            $userObj->addNewUser($dbObj->con,$queryObj->myQuery);
            $dbObj->dissconnectDb();
        }else if(isset($_POST['otherUserInfo'])){
            $userId=$_POST['randomQueryUserId'];
            $dbObj=new dbConnection();
            $dbObj->connectDb();
            $queryObj=new createQuery();
            $queryObj->selectWithCond($userId);
            $userObj=new adminChange();
            $userObj->showUser($dbObj->con,$queryObj->myQuery);
            $dbObj->dissconnectDb();
        }else if(isset($_POST['otherUserDeletion'])){
            $userId=$_POST['randomQueryUserId'];
            $dbObj=new dbConnection();
            $dbObj->connectDb();
            $queryObj=new createQuery();
            $queryObj->deleteQuery($userId);
            $userObj=new adminChange();
            $userObj->deleteAnyUser($dbObj->con,$queryObj->myQuery);
            $dbObj->dissconnectDb();
        }else if(isset($_POST['approveUserInfo'])){
            $userId=$_POST['randomQueryUserId'];
            $dbObj=new dbConnection();
            $queryObj=new createQuery();
            $userObj=new adminChange();
            $dbObj->connectDb();
            $queryObj->validateQuery($userId);
            $userObj->approveUser($dbObj->con,$queryObj->myQuery);
            $dbObj->dissconnectDb();
        }else if(isset($_POST['blockUserInfo'])){
            $userId=$_POST['randomQueryUserId'];
            $dbObj=new dbConnection();
            $queryObj=new createQuery();
            $userObj=new adminChange();
            $dbObj->connectDb();
            $queryObj->deValidateQuery($userId);
            $userObj->disApproveUser($dbObj->con,$queryObj->myQuery);
            $dbObj->dissconnectDb();
        }else if(isset($_POST['showAllMember'])){
            $dbObj=new dbConnection();
            $dbObj->connectDb();
            $queryObj=new createQuery();
            $queryObj->selectAllUserQuery();
            $userObj=new adminChange();
            $userObj->showAllUserToAdmin($dbObj->con,$queryObj->myQuery);
            $dbObj->dissconnectDb();
        }
    }else{
        echo '<script>alert("You are not logged in as an admin! go back and logged in")</script>';
        header("Location:admin.php");
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>UserDashboard</title>
</head>
<body>
    <div class="jumbotron bg-dark">
        <h3 class="text-warning">This Dashboard is a simple page Whose purpose is just to Provide information about User. to the admin</h3>
    </div>
    <div class="container">
        <form action="" method="POST"></br>
        <button class="btn btn-danger" name="showDetailClick">Showdetail</button></br></br>
        <button class="btn btn-danger" name="logoutClick">Logout</button></br></br></br>
        <button name="showAllMember" class="btn bg-primary">Show all Members</button></br></br>
        </form>
        <div>
            <button name="updateInfoModal" data-toggle="modal" data-target="#updationInfoModal" class="btn btn-secondary">Update User Information</button></br></br>
            <div class="modal" id="updationInfoModal" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Updation form</h4>
                        </div>
                        <div class="modal-body">
                            <form action="" method="POST">
                                <input type="text" class="form-control" name="userId" placeholder="Enter user ID.">
                                <input type="text"  name="userName" class="form-control" placeholder="enter user name">
                                <input type="text" class="form-control" name="userEmail" placeholder="enter email" >
                                <button  class="btn btn-primary" name="updateInfo">update User</button>
                                <button  class="btn btn-default"  data-dismiss="modal">Close</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <button name="updatePasswordModal" data-toggle="modal" data-target="#updatePasswordModal" class="btn btn-secondary">Update password</button></br></br>
            <div class="modal" id="updatePasswordModal" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Update password form</h4>
                        </div>
                        <div class="modal-body">
                            <form action="" method="POST">
                                <input type="text" class="form-control" name="userId" placeholder="Enter Id">
                                <input type="text"  name="userEnteredPassword" class="form-control" placeholder="enter new password">
                                <input type="text" class="form-control" name="userConformationPassword" placeholder="enter password again" >
                                <button  class="btn btn-primary" name="updatePassword">update User</button>
                                <button  class="btn btn-default"  data-dismiss="modal">Close</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <button name="addUserModal1" data-toggle="modal" data-target="#addUserModal" class="btn btn-secondary">Add New User</button></br></br>
            <div class="modal" id="addUserModal" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Add new user Form</h4>
                        </div>
                        <div class="modal-body">
                            <form action="" method="POST">
                                <input type="text" class="form-control" name="newUserName" placeholder="Enter Name for new user">
                                <input type="text"  name="newUserEmail" class="form-control" placeholder="enter email for new user">
                                <input type="text" class="form-control" name="newUserRole" placeholder="enter role for new user either endUser/admin" >
                                <input type="text"  name="newUserPassword" class="form-control" placeholder="enter password for new user">
                                <input type="text"  name="newUservalid" class="form-control" placeholder="user is valid or not yes/no">
                                <button  class="btn btn-primary" name="addNewUser">Add User</button>
                                <button  class="btn btn-default"  data-dismiss="modal">Close</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <form action="" method="POST">
                <input type="text" name="randomQueryUserId" placeholder="enter user id" require>
                <button class="btn btn-primary bg-dark" name="otherUserInfo">Show Info</button>
                <button class="btn btn-primary bg-dark" name="otherUserDeletion">DeleteUser</button>
                <button class="btn btn-primary bg-dark" name="approveUserInfo">Approve User</button>
                <button class="btn btn-primary bg-dark" name="blockUserInfo">Block User</button>
            </form>
        </div>    
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
</body>
</html>