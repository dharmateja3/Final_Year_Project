<?php 
//   session_start();
//   include 'php/db.php';
//   $unique_id = $_SESSION['unique_id'];
//   $email = $_SESSION['email'];
//   if(empty($unique_id))
//   {
//       header ("Location: login.php");
//   } 
//  $qry = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");
//   if(mysqli_num_rows($qry) > 0){
//     $row = mysqli_fetch_assoc($qry);
//   }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tank Sluice With Tower Head</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="css/loader.css" />
    <style>
      @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@600&display=swap");
      *{
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: "Poppins", "sans-serif";
      }
      body{
        position: relative;
        width: 100%;
        height: 100vh;
      }
      a{
        text-decoration: none;
      }
      ul{
        list-style: none;
      }
      body{
        position: relative;
        width: 100%;
      }
      #header{
        display: flex;
        justify-content: space-between;
        padding: 15px;
        background: #ddd;
      }
      #header a.Logo h1{
        text-transform: uppercase;
        color: #006692;
      }
      button.logout_btn{
        padding: 9px 25px;
        background-color: #006692;
        border-radius: 8px;
        border: 1px solid #00b3ff;
        cursor: pointer;
        transition: all 0.3s ease 0s;
        color: #f2f3f7;
        text-transform: uppercase;
        font-weight: 600;
        letter-spacing: 1px;
      }
      span{
        color: #006698;
        cursor: pointer;
        text-decoration: underline;
      }
        body{
            background-color: rgb(136, 153, 251);
            background-image: linear-gradient(0deg, rgb(41, 137, 185) 0%, rgba(4,10,10,0.2638305322128851) 100%);
            
        }
        table {
            background: #ebf6fb;
            background:cover;
            margin : 0 auto;
            margin-top: -270px;
            padding: 30px;
            border: 1px solid black;
            border-radius: 5px;
            box-shadow: 20px 20px 20px 0px rgba(51, 49, 49, 0.7);
            font-family: "Poppins", "sans-serif";
            }
        h1{
            margin-top: -50px;
            font-size: 25px;
            width: 650px;
            height: 50px;
            border-bottom: 2px solid black;
        }
        .table input[type="submit"]{
            background-color:rgba(169, 220, 217, 0.188);
            border-radius: 5px;
            border-style: solid;
            width:100px;
            height:30px;
            font-size: 17px;
        }
        .table input[type="submit"]:hover{
            background-color:#7cbee4;
            cursor:pointer;
        }
        .table input[type="number"]{
            background: #fff;
            color: #080808;
            padding: 5px;
            border-radius: 5px;
            border-style: solid;
        }
        ::placeholder
        {
            color: #3b3a3a;
        }
        td{
            font-size: 17px;
        }
        th {
			padding-top: 50px;
      padding-bottom: 10px;
		}
    
        
    </style>
</head>
<body>  

    <header id="header">
        <a href="#"><h2>Welcome</h2></a>
        <nav>
            <ul class="navigation">
                <li><a href="php/logout.php"><button class="logout_btn">Log Out</button></a></li>
            </ul>
        </nav>
    </header>

<!--<div id="loader">
  <div class="loader row-item">
	<span class="circle"></span>
	<span class="circle"></span>
	<span class="circle"></span>
	<span class="circle"></span>
	<span class="circle"></span>
</div>-->
        
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        <form action="calculation.php" method="POST">
        <table class="table" align="center">
                <center><tr><th><h1><b>TANK SLUICE WITH A TOWER HEAD - DATA INPUT</b></h1></th></tr></center>
                <tr><td>Please enter the Ayacut to be irrigated(ha)</td>
                    <td><input type="number"placeholder="Enter" name = "ayacut" step="0.01" min="1"required></td></tr><br>
                <tr><td>Please enter the Duty(ha/cumec)</td>
                    <td><input type="number"placeholder="Enter" name = "duty" step="0.01" min="1" required></td></tr><br>
                <tr><td>Please enter the Top Width of tank bund(m)</td>
                    <td><input type="number"placeholder="Enter" name = "topwidth" step="0.01" min="1" required></td></tr><br>
                <tr><td>Please enter the Top level of bank(m)</td>
                    <td><input type="number"placeholder="Enter" name = "toplevel" step="0.01" min="1" required></td></tr><br>
                <tr><td>Please enter the Ground level at the site(m)</td>
                    <td><input type="number"placeholder="Enter" name = "groundlevel" step="0.01" min="1" required></td></tr><br>
                <tr><td>Please enter the Hard soil for Foundation(m)</td>
                    <td><input type="number"placeholder="Enter" name = "hardfoundation" step="0.01" min="1" required></td></tr><br>
                <tr><td>Please enter the Sill of the sluice at off take(m)</td>
                    <td><input type="number"placeholder="Enter" name = "sill" step="0.01" min="1" required></td></tr><br>
                <tr><td>Please enter the Maximum water level in tank(m)</td>
                    <td><input type="number"placeholder="Enter" name = "max_water" step="0.01" min="1" required></td></tr><br>
                <tr><td>Please enter the Full tank level(m)</td>
                    <td><input type="number"placeholder="Enter" name = "ftl" step="0.01" min="1"  required></td></tr><br>
                <tr><td>Please enter the Average low water level of the tank(m)</td>
                    <td><input type="number"placeholder="Enter" name = "avglowwater" step="0.01" min="1" required></td></tr><br>
                <tr><td>Please enter the Channel bed level(m)</td>
                    <td><input type="number"placeholder="Enter" name = "channelbed" step="0.01" min="1" required></td></tr><br>
                <tr><td>Please enter the Full supply level(m)</td>
                    <td><input type="number"placeholder="Enter" name = "fsl" step="0.01" min="1" required></td></tr><br>
                <tr><td>Please enter the Bed width(m)</td>
                    <td><input type="number"placeholder="Enter" name = "bedwidth" step="0.01" min="1" required></td></tr>
                <tr><td>Please enter the Side slope level(m)</td>
                    <td><input type="number"placeholder="Enter" name = "sideslopelevel" step="0.01" min="1" required></td></tr>        
                <tr><td colspan="2" align = "center"><input type="submit" value = "Submit"id="button" name = "submit"></td></tr>
        </table>
        </form>
    </body>
</html>
