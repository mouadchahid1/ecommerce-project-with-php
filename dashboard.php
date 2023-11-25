<?php
session_start();
if(isset($_SESSION['admin']) && $_SESSION['admin']!="null")
{
        $encryption = $_SESSION['admin'];
  
  
// Store the cipher method
$ciphering = "AES-128-CTR";
  
// Use OpenSSl Encryption method
$iv_length = openssl_cipher_iv_length($ciphering);
$options = 0;
  
// Non-NULL Initialization Vector for decryption
$decryption_iv = '1234567891011121';
  
// Store the decryption key
$decryption_key = "GeeksforGeeks";
  
// Use openssl_decrypt() function to decrypt the data
$decryption=openssl_decrypt ($encryption, $ciphering, 
        $decryption_key, $options, $decryption_iv);
  
    
         $servername = "localhost";
$username = "root";
$password = "";
$dbname = "ecommerce";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
                $sql = "select user_role from users where trim(lower(email)) like trim(lower('".$decryption."'))";
                
            $result = $conn->query($sql);       
if ($result->num_rows > 0) {
    
$row = $result->fetch_assoc();
    if($row['user_role']==="admin"){
        echo "<script>
        document.cookie='pagination=0-0-0-0-0';
                window.location.href='panel.php';
                </script>";
    }
    else{
        $_SESSION['admin']='null';
        echo "<script>alert('You are not an admin!')</script>";
    echo "<script>
                window.addEventListener('load', function(){
                LOADER();
                }, false);
                </script>";
    }

}
    else{
        $_SESSION['admin']='null';
    echo "<script>
                window.addEventListener('load', function(){
                LOADER();
                }, false);
                </script>";
    }
    
    
    
    
}
else echo "<script>
                window.addEventListener('load', function(){
                LOADER();
                }, false);
                </script>";
?>
<html>
<head>
    <title>E-commerce</title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="style-dashboard.css"/>
    <link rel="stylesheet" href="media-dashboard.css"/>
    </head>
    <body>
        <form style="width: 100%; height: 100%" method="post" target="_self">
        <div id="login-container">
            <img src="assets/database.png"/>
            <h2>Sign In</h2>
            <input type="email"  id="email" name="email" placeholder="Email address"/>
            <input type="password"  enterkeyhint="done" id="pass" name="pass" placeholder="Password"/>
            <button type="button" onclick="Check()">Login to your account</button>
            <button hidden id="btn1" name="btn1"></button>
        </div>
        <div id="loader">
        <img class="logo" src="assets/load.gif"/>
        </div>
        <script>
            var em = document.getElementById("email");
            var ps = document.getElementById("pass");
            em.focus();
            em.onkeypress=function(event){
              if(event.key=="Enter")  {
                  ps.focus();
                  event.preventDefault();
              }
                
            };
            ps.onkeypress=function(event){
              if(event.key=="Enter")  {
                  Check();
                  event.preventDefault();
              }
                
            };
            
            function Check(){
                localStorage.setItem('ar',""); 
                localStorage.setItem('sections','0');
                var email = document.getElementById("email").value;
                var password = document.getElementById("pass").value;
                if(email.trim().length == 0){
                    alert("You should enter an email address!");
                    return;
                }
                if(password.trim().length == 0){
                    alert("You should enter a password!");
                    return;
                }
         document.getElementById('loader').style.display="flex";       document.getElementById('loader').style.opacity="1";
                setTimeout(function(){
                    document.getElementById("btn1").click();
                }, 500);
            }
            
         function LOADER(){
        
         document.getElementById('loader').style.display="flex";
                setTimeout(function(){
                    document.getElementById('loader').style.opacity="1";
                    setTimeout(function(){
                        document.getElementById('loader').style.opacity="0";
                        setTimeout(function(){
                        document.getElementById('loader').style.display="none";
                            document.getElementById('platform').style.opacity="1";
                        
                    }, 100);
                    }, 1000);
                }, 100);
    }
            
        </script>
            <?php
            if(isset($_POST['btn1'])){
                $email = $_POST['email'];
                $pass = $_POST['pass'];
                
                         
                      $servername = "localhost";
$username = "root";
$password = "";
$dbname = "ecommerce";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
                $sql = "select user_role from users where trim(lower(email)) like trim(lower('".$email."')) and pass like '".$pass."' and user_role='admin'";
                
            $result = $conn->query($sql);       
if ($result->num_rows > 0) {
    
$row = $result->fetch_assoc();

      $simple_string = $email;
  
  
// Store the cipher method
$ciphering = "AES-128-CTR";
  
// Use OpenSSl Encryption method
$iv_length = openssl_cipher_iv_length($ciphering);
$options = 0;
  
// Non-NULL Initialization Vector for encryption
$encryption_iv = '1234567891011121';
  
// Store the encryption key
$encryption_key = "GeeksforGeeks";
  
// Use openssl_encrypt() function to encrypt the data
$encryption = openssl_encrypt($simple_string, $ciphering,
            $encryption_key, $options, $encryption_iv);
  
    $_SESSION['admin']=$encryption;
    
                echo "<script>window.location.href=window.location.href</script>";
}
                else {
                    
                    echo "<script>alert('Wrong email or password!')</script>";
                    $_SESSION['admin']="null";
                echo "<script>window.location.href=window.location.href</script>";
                }
                
                 $conn->close();
              
            }
            ?>
        </form>
    </body>
</html>