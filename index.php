<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>    

    <style>
        h1 {
            text-align: center  ;
        }
        form {
            display: flex;
            justify-content: center;
        }
        p {
            text-align: center;
        }
    </style>
</head>
<body>

    <h1>LOGIN AS ADMIN</h1>
    <form method="post">
        <div>            
            <label for="userid">USER-ID:</label><br>
            <input type="text" id="userid" name="userid" value="User-ID"><br>
            <label for="lname">LASTNAME:</label><br>
            <input type="text" id="lname" name="lname" value="Lastname"><br><br>
            <input type="submit" value="Submit" name="Submit">
        </div>        
    </form>

    <br>
    <p><a href="user/user.php">OR CONTINUE AS GUEST</a></p>

    <?php
        session_start();
        if(array_key_exists('Submit', $_POST)) {
            submit();
        }
        function submit() { 
            $servername = "localhost"; // sending credentials to db (not query)
            $username = "user1"; // change to whatever user w/ sufficient privilege to db used
            $password = "1234567890";
            $dbname = "websitecasestudy-main-db";
        
            $conn = new mysqli($servername, $username, $password, $dbname);    
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $userID = $_POST['userid'];
            $lname = $_POST['lname'];
            $sql = "SELECT * FROM admin WHERE userid = ? AND lName = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $userID, $lname);
            $stmt->execute();
            $result = $stmt->get_result();

            
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    //echo "userid: " . $row["userid"]. " - Name: " . $row["lname"]. "<br>";                    
                    $_SESSION['lname'] = $row["lname"];               
                    echo "<script>window.location.href = 'admin/admin.php';</script>"; // resulting page after login success
                }
            } else {
                //echo "0 results";
                echo "<p style='color:red;'><u>Incorrect userID or Lastname</u></p>";
            }            
            $conn->close();
        }
    ?>
</body>
</html>
