<?php
    include('db.php');
    class managerHandle{
        public function loginUser($con,$query,$email,$password){
            $table=mysqli_query($con,$query);
            if($table){
                session_start();
                while($row=$table->fetch_assoc()){
                    if($row['userEmail']==$email){
                        if($row['userRole']=="manager"){
                            if($row['userPassword']==$password){
                                $_SESSION['userRole']=$row['userRole'];
                                $_SESSION['userId']=$row['userId'];
                                echo '<script>alert("You are logged in")</script>';
                                header("Location:managerInterface.php");
                            }else{
                                echo '<script>alert("please enter a valid password!")</script>';
                            }
                        }else{
                            echo '<script>alert("you are not an manager! please take care of that.")</script>';
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
        $dbObj=new dbConnection();
        // var_dump($dbObj);
        $dbObj->connectDb();
        $queryObj = new createQuery();
        $queryObj->selectAllUserQuery();
        $managerObj = new managerHandle();
        $managerObj->loginUser($dbObj->con,$queryObj->myQuery,$loginEmail,$loginPassword);

    }elseif (isset($_POST['staffPageClick'])) {
        header("Location:staff.php"); 
    }elseif (isset($_POST['welcomePageClick'])) {
        header("Location:welcome.php"); 
    }elseif (isset($_POST['adminPageClick'])) {
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
    <title>managerPage</title>
</head>

<body class="bg-dark">
    <div class="container bg-dark">
        <div class="jumbotron bg-success">
            <h3>This website is a demo website to learn PHP and to make user management system. This is for the Manager.</h3>
        </div>
        <div class="row">
            <div class="col card" style="width: 18rem;">
                <div>You Can Login here if you are a manager.</div>
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
                    <button name="staffPageClick" class="btn btn-danger">Go To Staff Page</button>
                    <button name="adminPageClick" class="btn btn-secondary">Go To Admin Page</button>
                    <button name="welcomePageClick" class="btn btn-secondary">Go To welcome Page</button>
                </form>
                </br>
                <p><b>Note:</b> If You are not registered then contact with admin to register Yourself with us...</p>
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