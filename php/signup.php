<?php 
    session_start();
    include_once  "db.php";
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$password = $_POST['pass'];
$cpassword = $_POST['cpass'];
$Role = 'user';

// checking fields are not empty
if(!empty($fname) && !empty($lname) && !empty($email) && !empty($phone) && !empty($password) && !empty($cpassword)){
    //if email is valid
    if(filter_var($email,FILTER_VALIDATE_EMAIL)){
        //checking email already exists
        $sql = mysqli_query($conn,"SELECT email FROM users WHERE email = '{$email}'");
        if(mysqli_num_rows($sql) > 0){
            echo "$email - Already Exists!";
        }
        else{
            if($password == $cpassword){
                    $random_id = rand(time(),10000000);
                    // let's start insert data into table

                    $sql2 = mysqli_query($conn,"INSERT INTO users (unique_id, fname, lname, email, phone, password,  Role)
                    VALUES ({$random_id},'{$fname}','{$lname}','{$email}','{$phone}','{$password}',  '{$Role}')");
                    if($sql2){
                        $sql3 = mysqli_query($conn,"SELECT * FROM users WHERE email = '{$email}'");
                        if(mysqli_num_rows($sql3)>0){
                            $row = mysqli_fetch_assoc($sql3);
                            $_SESSION['unique_id'] = $row['unique_id'];
                            $_SESSION['email'] = $row['email'];
                        }
                        echo "Accout created successfully! you can login now";
                    }
                    else {
                        echo "Somethings went wrong! " . mysqli_error($conn);
                    }
                }
                else{
                    echo "Confirm Password Don't Match!";
                    
                }
            }
        }
    }
    
    else {
        echo "$email ~ This is not valid Email!";
    }
    
?>

