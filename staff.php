<?php
    include('db.php');
    class handleUser{
        public function loginUser($con,$query,$email,$password){
            $table=mysqli_query($con,$query);
            if($table){
                session_start();
                while($row=$table->fetch_assoc()){
                    if($row['userEmail']==$email){
                        if($row['userRole']=="staff"){
                            // $row['userPassword']=sha1($row['userPassword']);
                            if($row['userPassword']==$password){
                                $_SESSION['userId']=$row['userId'];
                                $_SESSION['userRole']=$row['userRole'];
                                echo '<script>alert("You are logged in")</script>';
                                header("Location:staffInterface.php");
                            }else{
                                echo '<script>alert("please enter a valid password!")</script>';
                            }
                        }else{
                            echo '<script>alert("you are not from Staff! please take care of that.")</script>';
                        }
                    }else{
                        continue;
                    }
                }
            }else{
                echo '<script>alert("Please log in Carefully!")</script>';
            }
        }
    }
    if(isset($_POST['loginClick'])){
        $loginEmail=$_POST['loginEmail'];
        $loginPassword=$_POST['loginPassword'];
        // $loginPassword=sha1($loginPassword);
        $dbObj=new dbConnection();
        $dbObj->connectDb();
        $queryObj = new createQuery();
        $queryObj->selectAllUserQuery();
        $userObj = new handleUser();
        $userObj->loginUser($dbObj->con,$queryObj->myQuery,$loginEmail,$loginPassword);

    }elseif (isset($_POST['adminPageClick'])) {
        header("Location:admin.php"); 
    }elseif (isset($_POST['managerPageClick'])) {
        header("Location:manager.php"); 
    }elseif (isset($_POST['welcomePageClick'])) {
        header("Location:welcome.php"); 
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
    <title>staffLogin</title>
</head>

<body class="bg-dark">
    <div class="container bg-dark">
        <div class="jumbotron bg-success">
            <h3>If You a staff Member you can login On this page.</h3>
        </div>
        <div class="row">
            <div class="col card" style="width: 18rem;">
                <div>You Can Login as a staff.</div>
                <form action="" method="POST" class="form" id="loginForm">
                    <div class="form-group">
                        <input type="text" name="loginEmail" id="loginEmail" class="form-control" placeholder="Enter Your Email" required> 
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="loginPassword" id="loginPassword" placeholder="Enter Your Password" required>
                    </div>
                    <div class="form-group">
                        <button name="loginClick" class="btn btn-primary">LogIN</button>
                        
                    </div>
                </form>
                <form action="" method="POST">
                    <button name="adminPageClick" class="btn btn-danger">Go To Admin Page</button>
                    <button name="managerPageClick" class="btn btn-danger">Go To Manager Page</button>
                    <button name="welcomePageClick" class="btn btn-warning">Go To welcome Page</button>
                </form>
            </div>
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