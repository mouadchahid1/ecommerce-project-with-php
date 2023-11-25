<?php
session_start();
echo "<script>
document.cookie='pagination2=0';
document.cookie='fcookie=null';</script>";
if(!isset($_SESSION['user']) || $_SESSION['user']=="none"){
    $_SESSION['ind'] = "0";
    echo "<script>window.location.href='login.php'</script>";
}
?>
<html>
<head>
    <title>E-commerce</title>
    <link rel="stylesheet" href="style.css"/>
    <link rel="stylesheet" href="media.css"/>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <script>
    if(document.cookie.indexOf("currency")==-1){
        document.cookie="currency=American USD";
        document.cookie="rt=null";
    }
    </script>
    </head>
    <body>
    <div id="wrapper">
        <form style="width: 100%; height: 100%" method="post" target="_self">
            <div id="platform">
        <div id="basic-info">
            <a>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</a>
            </div>
            <div id="further-info">
            <div id="inner">
                <div id="basic-nav">
                <a href="login.php">My account</a>
                    <a onclick="RETRIEVE(); window.location.href='cart.php'">Cart</a>
                <a href="about.php">About us</a>
                <a href="contact.php">Contact</a>
                </div>
                <div id="right">
                <a>Need help? Call us at: <a style="color: dodgerblue">+212 600000000</a></a>
                    <div onclick="OpenPopup('langs', 'lang-title','lang-list')" class="flex" style="margin-left: 20px; cursor: pointer;display:none">
                    <button>English</button>
                    <img src="assets/down-arrow.png"/>
                    </div>
                    <div onclick="OpenPopup('currency', 'currency-title','currency-list')" style="margin-left: 10px; cursor: pointer" class="flex">
                    <button type="button" id="currencybtn"></button>
                    <img src="assets/down-arrow.png"/>
                    </div>
                </div>
                </div>
            </div>
             <div id="search-nav">
                 
                 <img id="menu" onclick="OpenMenu()" src="assets/menu.png"/>
                 
            <div id="logo-bar">
                 <img class="logo" src="assets/logo.png"/>
                <a>Lorem ipsum dolor sit amet</a>
                 </div>
                 <div id="search-bar">
                 <input id='search' onkeypress="ENTER(this,event)" type="search"  placeholder="Search for something"/>
                     <div style="width: 100%; height: 100%; display: flex;position: absolute;left: 0;top: 0;align-items: center;">
                     <img onclick="SEARCH()" id="search" src="assets/search.png"/>
                     </div>
                 </div>
                 
                 <div id="details" style="margin-left: auto; ;align-items: center;height: 100%;margin-right: 20px;">
                 
                     <div  onclick="window.location.href='login.php'" class="circle medium-size-holder border-holder center" style="cursor: pointer">
                     <img class="small-img" src="assets/person.png"/>
                     </div>
                     
                               <div id="balance">
                     <?php
                         $currency = trim(explode(' ',$_COOKIE['currency'])[1]);
                         $rt=0;
          if(!empty($_COOKIE['rt']) && $_COOKIE['rt']!="null"){
              $rt = $_COOKIE['rt'];
          }
          else{
             
              
          $req_url = 'https://api.exchangerate-api.com/v4/latest/USD';
      
          $arrContextOptions = array("ssl" => array(         "verify_peer" => false,         "verify_peer_name" => false,       ) );      $context = stream_context_create($arrContextOptions);

$response_json = file_get_contents($req_url,false,$context);

// Continuing if we got a result
if(false !== $response_json) {

    // Try/catch for json_decode operation
    try {

    // Decoding
    $response_object = json_decode($response_json);

        $rt = $response_object->rates->$currency;
       echo "<script>document.cookie='rt=".$rt."'; window.location.href=window.location.href</script>";
    

    }
    catch(Exception $e) {
        // Handle JSON parse error...
    }
}
           
          }   

                         
                         if(isset($_SESSION['user']) && $_SESSION['user']!="none"){
                             
                             
                             $servername = "localhost";
$username = "root";
$password = "";
$dbname = "ecommerce";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
                $encryption = $_SESSION['user'];
  
  
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
  
                $sql = "select sum(total) as somme from orders where trim(lower(user)) like trim(lower('".$decryption."'))";
                


$result = $conn->query($sql);       
if ($result->num_rows > 0) {
    
$row = $result->fetch_assoc();
    $somme =$row['somme'];
      if($rt != 0)
      $somme = round(($row['somme'] * $rt), 2);
     echo $currency." ".$somme;
                         
                         }
                             
                             $conn->close();
                         }
                         else echo $currency." 0";    
                         
                         
                         
                         ?>
                     </div>
                     
                     <div id="cart-btn" onmouseover="document.getElementById('cart').style.display='flex'" onmouseout="document.getElementById('cart').style.display='none'" class="circle medium-size-holder center color-holder" style="cursor: pointer">
                     <img class="small-img" src="assets/briefcase.png"/>
                     </div>
                     
              <div id="cart" onmouseover="document.getElementById('cart').style.display='flex'" onmouseout="document.getElementById('cart').style.display='none'">
                     <div id="inner">
                    <div id="top" class="cart-inside">
                        
                        
                        
                        
                         </div>
                    <div id="bottom" class="cart-hidden">
                         <button type="button" onclick="window.location.href='checkout.php'">Checkout</button>
                        <button type="button" onclick="RETRIEVE(); window.location.href='cart.php'">View cart</button>
                         </div>
                    </div>
                     </div>     
                     
                     
                     
                 </div>
                 
            </div>
            <div id="main-nav">
             <div onclick="ShowCats2()" class="browse-mobile ref1" >
                <img src="assets/menu.png"/>
                <a>Browse Categories</a>
                <img src="assets/arrow-down2.png"/>
                </div>
                 <div id="basic-nav2" class="ref2">
                <a href="index.php">Home</a>
                 <a onclick="document.cookie='query=null';document.getElementById('u').value='shop.php';document.getElementById('sh').click()">Shop</a>
                     <input type="text" id="u" name="u" hidden/>
                     <button hidden id="sh" name="sh"></button>
                     <?php
            if(isset($_POST['sh'])){
               $_SESSION['brand']="all";
                $_SESSION['mn']="0";
                $_SESSION['mx']="9999999";
                $_SESSION['stock']="false";
                $_SESSION['offer']="false";
                echo "<script>   localStorage.setItem('mn','0');
                localStorage.setItem('mx','9999999');localStorage.setItem('stock','0');localStorage.setItem('offer','0');</script>";
                echo "<script>
                window.addEventListener('load', function(){
                RESET('".$_POST['u']."');
                }, false);
                </script>";
            }
            ?>
                <a hidden href="featured.php">Featured</a>
                     <a href="about.php">About us</a>
                     <a href="contact.php">Contact Us</a>
                     <a href="services.php">Our Services</a>
                </div>
                <div id="all-cats">
                  
                    
                    
                </div>
            </div>
            
        <div id="myaccount">
        
            <div id="top">
            <h1 class="op">DASHBOARD</h1>
            <h1 class="op">ORDERS</h1>
                <h1 class="op">SHIPPING ADDRESS</h1>
                <h1 class="op">ACCOUNT DETAILS</h1>
            <h1 class="op" >LOGOUT</h1>
            </div>
            <div id="bottom">
            <div class="tb">
                <a>Hello <strong><?php 
                    $encryption = $_SESSION['user'];
  //echo "<script>alert('".$encryption."')</script>";
  
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
  
                    
                    
                    
                    echo explode('@', $decryption)[0];
                
                    ?></strong>! (not <strong><?php 
                    $encryption = $_SESSION['user'];
  
  
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
  
                    echo explode('@', $decryption)[0];
                    ?></strong>? <a style="color: dodgerblue; cursor: pointer" onclick="LogOut()">Logout</a>)</a>
                
                <br><br>
                
                <a>From your account dashboard you can view your <a style="color: dodgerblue; cursor: pointer" onclick="tmp(1) ;Show(1)">recent orders</a>, manage your <a style="color: dodgerblue; cursor: pointer" onclick="tmp(2); Show(2)">shipping and billing addresses</a>, and edit your <a style="color: dodgerblue; cursor: pointer" onclick="tmp(3); Show(3)">password and account details.</a></a>
                </div>
                <div class="tb">
        
                     <div id="cart-box">
        <div id="left" >
            

            
            <?php
            
            MyOrders();
            
            ?>
            
            
            
            
            </div>
                    </div>
                    
                    
                </div>
                <div class="tb" style="width:100%">
                
                
                    <div id="checkout" >
        <div id="left">
            <div id="inner">
            
        <div id="bar" class="partial">
              <div id="in">
              <a>First name*</a>
            <input id="firstname" name="firstname" type="text"/>
            </div>
                </div>
                <div id="emp"></div>
                
                <div id="bar" class="partial">
                    <div id="in">
                <a>Last name*</a>
            <input id="lastname" name="lastname" type="text"/>
                    </div>
                </div>
                <div id="bar" class="full">
                    <div id="in">
                <a>Company name(optional)</a>
            <input id="company" name="company" type="text"/>
                    </div>
                </div>
                <div id="bar" class="full">
                    <div id="in">
                <a>Country / Region*</a>
            <select id='selector'>
                <option>Country name</option>
                <option>Morocco</option>
                <option>Country name</option>
                <option>Country name</option>
                        </select>
                        <input type="text" hidden id="s" name="country"/>
                    </div>
                </div>
                <div id="bar" style="height: 115px; margin-bottom: 15px;" class="full">
                    <div id="in">
                <a>Street Address*</a>
            <input id="street1" name="street1" type="text" />
                        <input id="street2" name="street2" type="text" style="margin-top:10px"/>
                    </div>
                </div>
                 <div id="bar" class="full">
                    <div id="in">
                <a>Town / City*</a>
            <input id="city" name="city" type="text"/>
                    </div>
                </div>
                 <div id="bar" class="full">
                    <div id="in">
                <a>Zip Code*</a>
            <input id="zip" name="zip" type="text"/>
                    </div>
                </div>
                 <div id="bar" class="partial">
              <div id="in">
              <a>Phone*</a>
            <input id="phone" name="phone" type="text"/>
            </div>
                </div>
                <div id="emp"></div>
                
                <div id="bar" class="partial">
                    <div id="in">
                <a>Email*</a>
            <input id="email" readonly name="email" type="text"/>
                    </div>
                </div>
                
                
                
            </div>
            </div>
            <div id="right" style="align-items: flex-start">
            <div id="inner" >
            
                <div id="in">
                    
                    
                <div id="title">
                    SHIPPING ADDRESS
                    </div>
                    
                    <div id="bar" style="padding: 0">
                    <button id="btn1" name="btn1">Set Address</button>
                    </div>
                    
                    
                    
                    
                    
                    
                </div>
                
            </div>
            </div>
            </div>
                    
                </div>
                <div class="tb">
                
                    
            <div id="checkout" >
        <div id="left">
            <div id="inner">
            
        <div id="bar" class="partial">
              <div id="in">
              <a>First name*</a>
            <input id="firstname2" name="firstname2" type="text"/>
            </div>
                </div>
                <div id="emp"></div>
                
                <div id="bar" class="partial">
                    <div id="in">
                <a>Last name*</a>
            <input id="lastname2" name="lastname2" type="text"/>
                    </div>
                </div>
                <div id="bar" class="full">
                    <div id="in">
                <a >Email address*</a>
            <input id="emailaddress" name="emailaddress" type="email"/>
                    </div>
                </div>
                
                
                 <div id="bar" class="full">
                    <div id="in">
                <a>Current password*</a>
            <input id="mypass" name="mypass" type="password"/>
                    </div>
                </div>
                 <div id="bar" class="full">
                    <div id="in">
                <a>New password (leave blank if not necessary)</a>
            <input id="mypass2" name="mypass2" type="password"/>
                    </div>
                </div>
                
                
                
                
            </div>
            </div>
            <div id="right" style="align-items: flex-start">
            <div id="inner" >
            
                <div id="in">
                    
                    
                <div id="title">
                    ACCOUNT DETAILS
                    </div>
                    
                    <div id="bar" style="padding: 0">
                    <button id="svd" name="svd">Save Details</button>
                    </div>
                    
                    
                    
                    
                    
                    
                </div>
                
            </div>
            </div>
            </div>
                    
                </div>
            </div>
            
        </div>
      
        
             
             <div id="newsletter">
            <img src="assets/img5.png"/>
                <div id="inner">
                <a>$20 discount for your first order</a>
        <h1>Join our newsletter and get...</h1>
                    <p>Join our email subscription now to get updates on promotions and coupons.</p>
            <div id="email-bar">
                    <input name="news-input" type="text" placeholder="Enter your email"/>
                <button name="news-btn">Subscribe</button>
                <?php
                if(isset($_POST['news-btn'])){
                    
                        
                      $servername = "localhost";
$username = "root";
$password = "";
$dbname = "ecommerce";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
                    $sql = "select * from newsletter where trim(lower(email)) like '".$_POST['news-input']."'";

            
                    
$result = $conn->query($sql);
                    
                    
            
                    
                if($result->num_rows <=0){
                    
                    
                $sql = "insert into newsletter (email) values ('".$_POST['news-input']."')";
                

                    
                    
                    
if($conn->query($sql)=== TRUE){
 echo "<script>window.location.href=window.location.href</script>";   
}
                    
                }
                    
                    
                    
                }
                    
                
                ?>
                    
                    </div>
                </div>
            
            </div>
            
            
            <div id="about">
            
                <div id="part">
                <img src="assets/shipping.png"/>
                    <a>FREE SHIPPING ON ORDERS OVER $100</a>
                </div>
                <div id="part">
                <img src="assets/call.png"/>
                    <a>HAVE A QUESTIONS? +212 6000000</a>
                </div>
                <div id="part">
                <img src="assets/money.png"/>
                    <a>100% MONEY BACK GUARANTEE</a>
                </div>
                <div id="part">
                <img src="assets/info.png"/>
                    <a>30 DAYS RETURN SERVICE</a>
                </div>
                
            </div>
        
        
            <footer>
            
                <div id="part">
              <div id="inner">
                      <h1>SHOPPING GUIDE</h1>
                    <a>Blog</a>
                    <a>FAQs</a>
                    <a>Payment</a>
                    <a>Shipment</a>
                    <a>Where is my order</a>
                    <a>Return Policy</a>
                    </div>
                    </div>
                <div id="part">
                <div id="inner">
                    <h1>STYLE ADVISOR</h1>
                    <a>Your Account</a>
                    <a>Information</a>
                    <a>Addresses</a>
                    <a>Discount</a>
                    <a>Orders History</a>
                    <a>Order Tracking</a>
                    </div>
                    </div>
                <div id="part">
                <div id="inner">
                    <h1>INFORMATION</h1>
                    <a>Site Map</a>
                    <a>Search Terms</a>
                    <a>Advanced Search</a>
                    <a>About Us</a>
                    <a>Contact Us</a>
                    <a>Suppliers</a>
                    </div>
                </div>
                <div id="part">
                <div id="inner">
                    <h1>CONTACT US</h1>
                    <div style="width: auto; display: flex; align-items: center; margin-bottom: 25px">
                    <img style="margin-right: 20px;" src="assets/call.png"/>
                        <a style="margin: 0">+212 6000000</a>
                    </div>
                    <div style="width: auto; display: flex; align-items: center; margin-bottom: 25px">
                    <img style="margin-right: 20px;" src="assets/location.png"/>
                        <a style="margin: 0">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt.</a>
                    </div>
                    <div style="width: auto; display: flex; align-items: center; margin-bottom: 25px">
                    <img style="margin-right: 20px;" src="assets/email.png"/>
                        <a style="margin: 0">a95yman@gmail.com</a>
                    </div>
                    
                    </div>
                </div>
                
                
            </footer>
            
        <div id="langs">
        <div id="center-full">
            <div id="lang-title">
            <a style="margin-left: 20px;">Select a language</a>
            </div>
            <div id="lang-list">
                
                
            <div class="lang-bar">
                <img src="assets/lang.png"/>
                <a>Language name</a>
                </div>
                <div class="lang-bar">
                <img src="assets/lang.png"/>
                <a>Language name</a>
                </div>
                <div class="lang-bar">
                <img src="assets/lang.png"/>
                <a>Language name</a>
                </div>
                <div class="lang-bar">
                <img src="assets/lang.png"/>
                <a>Language name</a>
                </div>
                <div class="lang-bar">
                <img src="assets/lang.png"/>
                <a>Language name</a>
                </div>
                <div class="lang-bar">
                <img src="assets/lang.png"/>
                <a>Language name</a>
                </div>
                <div class="lang-bar">
                <img src="assets/lang.png"/>
                <a>Language name</a>
                </div>
                <div class="lang-bar">
                <img src="assets/lang.png"/>
                <a>Language name</a>
                </div>
                
                
                
            </div>
            <img id="close-popup" onclick="ClosePopup('langs', 'lang-title','lang-list')" src="assets/close.png"/>
            </div>
        </div>
        <div id="currency">
        <div id="center-full">
            <div id="currency-title">
            <a style="margin-left: 20px;">Select a currency</a>
            </div>
   <div id="currency-list">
                
                
                
            </div>
            <img id="close-popup" onclick="ClosePopup('currency', 'currency-title','currency-list')" src="assets/close.png"/>
            </div>
        </div>
        <div id="menu-bar">
        <div id="menu-inner">
            
            <div id="close-bar">
            <div style="display: flex;align-items: center;justify-content: center;width: auto;margin-right: auto">
                    <img src="assets/logo.png"/>
                <div  onclick="window.location.href='login.php'"  class="circle medium-size-holder border-holder center" style="cursor: pointer;margin-left: 20px;width: 25px; height: 25px">
                     <img style="margin: 0; width: 15px; height: 15px" class="small-img" src="assets/person.png"/>
                     </div>
                <div onclick="RETRIEVE(); window.location.href='cart.php'" class="circle medium-size-holder color-holder center" style="cursor: pointer;margin-left: 10px;width: 25px; height: 25px">
                     <img style="margin: 0; width: 15px; height: 15px" class="small-img" src="assets/briefcase.png"/>
                     </div>
                </div>
                     
            <img id="close-menu" onclick="CloseMenu()" src="assets/close.png"/>
            </div>
            
            <div style="width: 100%;" class="center">
            <div onclick="ShowCats()" class="browse-mobile">
                <img src="assets/menu_white.png"/>
                <a>Browse Categories</a>
                <img src="assets/arrow-down.png"/>
                </div>
            </div>
            
            <div id="cats">
             
                
                
                
            </div>
            
            <div class="title">
            <a>-- Site Navigation --</a>
            </div>
     
             <div class="item" onclick="window.location.href='index.php'">
                <div id="main" class="nav">
                     <img src="assets/menuitem.png"/>
                    <a>Home</a>
                    </div>
                  
                </div>
                <div class="item" onclick="document.cookie='query=null';document.getElementById('u').value='shop.php';document.getElementById('sh').click()">
                <div id="main" class="nav">
                     <img src="assets/menuitem.png"/>
                    <a>Shop</a>
                     <?php
            if(isset($_POST['sh'])){
               $_SESSION['brand']="all";
                $_SESSION['mn']="0";
                $_SESSION['mx']="9999999";
                $_SESSION['stock']="false";
                $_SESSION['offer']="false";
                echo "<script>   localStorage.setItem('mn','0');
                localStorage.setItem('mx','9999999');localStorage.setItem('stock','0');localStorage.setItem('offer','0');</script>";
                echo "<script>
                window.addEventListener('load', function(){
                RESET('".$_POST['u']."');
                }, false);
                </script>";
            }
            ?>
                    </div>
                  
                </div>



            <div hidden class="item" onclick="window.location.href='featured.php'">
                <div id="main" class="nav">
                     <img src="assets/menuitem.png"/>
                    <a>Featured</a>
                    </div>
                  

            </div>
            <div class="item" onclick="window.location.href='about.php'">
                <div id="main" class="nav">
                     <img src="assets/menuitem.png"/>
                    <a>About</a>
                    </div>
                  
                </div>
            <div class="item" onclick="window.location.href='contact.php'">
                <div id="main" class="nav">
                     <img src="assets/menuitem.png"/>
                    <a>Contact</a>
                    </div>
                  
                </div>
            <div class="item" onclick="window.location.href='services.php'">
                <div id="main" class="nav">
                     <img src="assets/menuitem.png"/>
                    <a>Services</a>
                    </div>
                  
                </div>
                  
            
            <div class="title">
            <a>-- Site Language --</a>
            </div>
            
            
            <div class="item">
                <div id="main" class="nav">
                     <img src="assets/lang2.png"/>
                    <a>Language name</a>
                    </div>
                </div>
            <div class="item">
                <div id="main" class="nav">
                     <img src="assets/lang2.png"/>
                    <a>Language name</a>
                    </div>
                </div>
            <div class="item">
                <div id="main" class="nav">
                     <img src="assets/lang2.png"/>
                    <a>Language name</a>
                    </div>
                </div>
            <div class="item">
                <div id="main" class="nav">
                     <img src="assets/lang2.png"/>
                    <a>Language name</a>
                    </div>
                </div>
            <div class="item">
                <div id="main" class="nav">
                     <img src="assets/lang2.png"/>
                    <a>Language name</a>
                    </div>
                </div>
            <div class="item">
                <div id="main" class="nav">
                     <img src="assets/lang2.png"/>
                    <a>Language name</a>
                    </div>
                </div>
            
            
            <div class="title">
            <a>-- Select your currency --</a>
            </div>
            
            <div class="item">
                <div id="main" class="nav">
                     <img src="assets/currency2.png"/>
                    <a>USD</a>
                    </div>
                    <div id="subs" class="cr-mobile">
                    </div>
                </div>
            
            <div id="copyright">
            <a>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,</a>
            </div>
            
            </div>
        </div>
            <button id="pt" name="pt" hidden></button>
        <button id="logout" name="logout" hidden></button>
            <?php
            if(isset($_POST["logout"])){
                $_SESSION['user'] = "none";
                echo "<script>window.location.href='login.php'</script>";
            }
            ?>
        
            </div>
            <div id="loader">
            <img src="assets/load.gif"/>
            </div>
            
            
            <script>
                function ENTER(target, e){
                 if(e.key=="Enter"){
                     SEARCH();
                     event.preventDefault();
                 }
                     

                 return false;
             }
                document.cookie='query=null';
function SEARCH(){
                 var query = document.getElementById('search').value;
                 document.cookie='query='+query;
                 window.location.href='shop.php';
             }
                  var currency_list = document.getElementById('currency-list');
             var currencies = [];
             currencies.push("Moroccan MAD");
             currencies.push("American USD");
             for(var i =0;i<currencies.length; i++){
                 var index = i;
                 currency_list.innerHTML+= "<div onclick='CR("+index+")' class='currency-bar'><img src='assets/currency.png'/><a>"+currencies[i]+"</a></div>";
                 document.getElementsByClassName('cr-mobile')[0].innerHTML+="<div onclick='CR("+index+")' id='sub'><a style='margin-left: 80px;'>"+currencies[i]+"</a></div>";
             }
             if(document.cookie.indexOf("currency=")==-1){
              var crn=currencies[0].split(" ")[1].trim();
             document.getElementById("currencybtn").innerHTML=crn;
             document.cookie="currency="+crn;   
             }
             else {
                 var crn = document.cookie.substring(document.cookie.indexOf("currency=")+9);
                 crn = crn.substring(0, crn.indexOf (";")).trim().split(" ")[1];
                 
                 document.getElementById("currencybtn").innerHTML=crn;
             }
             
             function CR(i){
                 var crn2=currencies[i].split(" ")[1].trim();
                 document.cookie="currency="+currencies[i];
                 document.getElementById("currencybtn").innerHTML=crn2;
                 ClosePopup('currency', 'currency-title','currency-list');
                 document.cookie='rt=null';
                 setTimeout(function(){
                     window.location.href=window.location.href;
                 }, 600);
             }

                 document.getElementById("platform").style.display='0';
                   LOADER();
            
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
            function TR(pt){
                document.cookie="pattern="+pt; 
                document.getElementById('pt').click();
            }
           
            var cart_hidden = document.getElementsByClassName("cart-hidden")[0];
            var cart_inside = document.getElementsByClassName("cart-inside")[0];
               if(cart_inside.innerHTML.trim().length==0){
                cart_hidden.style.display="none";
            }
            RETRIEVE();
              function RETRIEVE(){
                document.cookie='fcookie=null';
                var pr="";
                var catid="";
                var prid="";
                var name="";
                var img="";
                var q="";
                var str2="";
                var con=false;
                cart_inside.innerHTML="";
                
                if(localStorage.getItem("count")){
                    
                    for(var i =0; i<Number(localStorage.getItem("count"));i++){
                        pr = localStorage.getItem("product"+i);
                        if(pr!="null"){
                            con=true;
                catid=pr.split(";")[0];
                        prid=pr.split(";")[1];
                        name=pr.split(";")[2];
                        img=pr.split(";")[3];
                        q=pr.split(";")[4];
                        str2+=catid+" "+prid+" "+q+" "+i+"-";
                        cart_hidden.style.display="flex";
                cart_inside.innerHTML += "<div id='pr'><div id='left'><img src='"+img+"'/></div><div id='right'><h1>"+name+"</h1><a>Quantity: <strong>"+q+"</strong></a><button type='button' onclick=\"RemCart('"+i+"')\">Remove</button></div><div id='line'></div></div>";
                        }
                    }
                    if(con==false){
                        localStorage.removeItem("count");
                        for(var i =0; i<=Number(localStorage.getItem("count"));i++){
                            localStorage.removeItem("product"+i);
                        }
                       
                        document.cookie='fcookie=null';
                        cart_hidden.style.display="none";
                        
                    }
                    else{
                       
                        document.cookie='fcookie='+str2; 
                        

                    }
                }
            }

                  function RemCart(count){
                localStorage.setItem("product"+count,"null");
                RETRIEVE();
            }
           document.getElementById('s').value=document.getElementById('selector').value;
            document.getElementById("selector").onchange=function(){
                document.getElementById('s').value=document.getElementById('selector').value;
               
            }
            function LogOut(){
                document.getElementById('logout').click();
            }
        var ops = document.getElementsByClassName("op");
            var tbs = document.getElementsByClassName("tb");
            ops[0].style.color="#333";
            for(var i = 0; i<ops.length; i++){
                
                Do(ops[i], i);
            }
            function Do(op, index){
                op.onclick=function(){
                    for(var i = 0; i<ops.length; i++)
                        if(i!=index)
                        ops[i].style.color="#aaa";
                    ops[index].style.color="#333";
                    Show(index);
                };
            }
            
            function Show(index){
                if(index==4){
                    LogOut();
                }
                else{
                    for(var i = 0; i<tbs.length; i++)
                        if(i!=index)
                            tbs[i].style.display="none";
                    tbs[index].style.display="block";
                }
            }
            Show(0);    
            function tmp(index){
                for(var i = 0; i<ops.length; i++)
                        if(i!=index)
                        ops[i].style.color="#aaa";
                    ops[index].style.color="#333";
            }
        </script>
        
        <script>
              var allcats = document.getElementById("all-cats");
             var allcats2 = document.getElementById("cats");
             var ar = [];
             var ind=0;
function FillCats(dep, cat){

            ar.push(false);
var div_item = document.createElement("div");
    div_item.classList.add("item");
    
    var div_main = document.createElement("div");
    div_main.id="main";
    div_main.classList.add("nav");
    div_main.style.color="#444";
    
    div_main.innerHTML="<img src='assets/menuitem.png'/><a>"+dep+"</a>";
    
    var div_subs = document.createElement("div");
    div_subs.id="subs";
    div_subs.style.color="#555";
    
    
    div_item.appendChild(div_main);
    div_item.appendChild(div_subs);
    var h=50; 
    for(var i=0; i<cat.trim().split('\n').length; i++){
        h+=50;
    var div_sub = document.createElement("div");
    div_sub.id="sub";
    div_sub.innerHTML=" <a style='margin-left: 70px;'>"+cat.trim().split('\n')[i]+"</a>";
    div_subs.appendChild(div_sub);    
        catClick(div_sub, dep, cat.trim().split('\n')[i]);
    }
    
    allcats.appendChild(div_item);
    
    div_item.style.height="50px";
    Do2(div_item, ind, h, ar);
    ind++;
}
             
             var ar2 = [];
             var ind2=0;
function FillCats2(dep, cat){

            ar2.push(false);
var div_item = document.createElement("div");
    div_item.classList.add("item");
    
    var div_main = document.createElement("div");
    div_main.id="main";
    div_main.classList.add("nav");
    div_main.style.color="#444";
    
    div_main.innerHTML="<img src='assets/menuitem.png'/><a>"+dep+"</a>";
    
    var div_subs = document.createElement("div");
    div_subs.id="subs";
    div_subs.style.color="#555";
    
    
    div_item.appendChild(div_main);
    div_item.appendChild(div_subs);
    var h=50; 
    for(var i=0; i<cat.trim().split('\n').length; i++){
        h+=50;
    var div_sub = document.createElement("div");
    div_sub.id="sub";
    div_sub.innerHTML=" <a style='margin-left: 70px;'>"+cat.trim().split('\n')[i]+"</a>";
    div_subs.appendChild(div_sub);    
        catClick(div_sub, dep, cat.trim().split('\n')[i]);
    }
    
    allcats2.appendChild(div_item);
    
    div_item.style.height="50px";
    Do2(div_item, ind2, h, ar2);
    ind2++;
}
             
function FillCats4(cat){
var div_item = document.createElement("div");
    div_item.classList.add("item");
    
    var div_main = document.createElement("div");
    div_main.id="main";
    div_main.classList.add("nav");
    div_main.style.color="#444";
    
    div_main.innerHTML="<img src='assets/menuitem.png'/><a>"+cat+"</a>";
    
    var div_subs = document.createElement("div");
    div_subs.id="subs";
    div_subs.style.color="#555";
    
    
    div_item.appendChild(div_main);
    div_item.appendChild(div_subs);
        catClick(div_main, "", cat.trim());
    
    
    allcats.appendChild(div_item);
    
    div_item.style.height="50px";
}
             function FillCats3(cat){
var div_item = document.createElement("div");
    div_item.classList.add("item");
    
    var div_main = document.createElement("div");
    div_main.id="main";
    div_main.classList.add("nav");
    div_main.style.color="#444";
    
    div_main.innerHTML="<img src='assets/menuitem.png'/><a>"+cat+"</a>";
    
    var div_subs = document.createElement("div");
    div_subs.id="subs";
    div_subs.style.color="#555";
    
    
    div_item.appendChild(div_main);
    div_item.appendChild(div_subs);
        catClick(div_main, "", cat.trim());
    
    
    allcats2.appendChild(div_item);
    
    div_item.style.height="50px";
}
             
             function catClick(div, dep, cat){
                 div.onclick = function(){
                     document.cookie='query=null';
                     document.getElementById('u').value='shop.php?category='+cat;
                     document.getElementById('sh').click();
                     
                 };
             }
             
function Do2(div_item, ind, h, ar){
    if(div_item.getElementsByTagName("div").length > 1){
    div_item.getElementsByTagName("div")[0].onclick = function(){
        if(ar[ind] == false){
         ar[ind] = true;
            if(Number(h)==0) div_item.style.height="auto";
            else div_item.style.height=h+"px";
        }
        else{
            ar[ind] = false;
            div_item.style.height="50px";
        }
    };
    }
    else{
        //check here
    }
}



             function RESET(url){
                 document.body.style.opacity="0";
                 window.location.href=url;
             }
        var login = document.getElementsByClassName("login-tab")[0];
var register = document.getElementsByClassName("login-tab")[1];
function logC(ind){
    if(ind==1){
        document.getElementById("login-txt").style.color="333";
        document.getElementById("register-txt").style.color="777";
        register.style.left="100%";
        register.style.opacity="0";
        register.style.transition="0.5s";
        login.style.left="0";
        login.style.opacity="1";
        login.style.transition="0.5s";
    }
    else{
        document.getElementById("login-txt").style.color="777";
        document.getElementById("register-txt").style.color="333";
        register.style.left="0";
        register.style.opacity="1";
        register.style.transition="0.5s";
        login.style.left="-100%";
        login.style.opacity="0";
        login.style.transition="0.5s";
        
    }
}
        </script>
        <script src="script.js"></script>
        <?php
            
            $ind = $_SESSION['ind'];
            echo "<script>tmp('".$ind."') ;Show('".$ind."')</script>";
            
            ?>
            
            
            <?php
            
            FillDetails();
            
            function FillDetails(){
            
                    
                      $servername = "localhost";
$username = "root";
$password = "";
$dbname = "ecommerce";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
                $encryption = $_SESSION['user'];
  
  
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
  
                $sql = "select * from users where trim(lower(email)) like trim(lower('".$decryption."'))";
                


$result = $conn->query($sql);       
if ($result->num_rows > 0) {
    
$row = $result->fetch_assoc();
    
    echo "<script>
    
   window.addEventListener('load', function(){
   document.getElementById('firstname2').value='".$row['firstname']."';
   document.getElementById('emailaddress').value='".$row['email']."';
   document.getElementById('lastname2').value='".$row['lastname']."';
   
   }, false);
   document.getElementById('firstname').value='".$row['firstname']."';
    
    document.getElementById('lastname').value='".$row['lastname']."';
    document.getElementById('company').value='".$row['company']."';
    
    var textToFind = '".$row['country']."';

var dd = document.getElementById('selector');
for (var i = 0; i < dd.options.length; i++) {
    if (dd.options[i].text === textToFind) {
        dd.selectedIndex = i;
        break;
    }
}
   document.getElementById('s').value=textToFind; document.getElementById('street1').value='".$row['street1']."';
    document.getElementById('street2').value='".$row['street2']."';
    document.getElementById('city').value='".$row['city']."';
    
    document.getElementById('zip').value='".$row['zipcode']."';
    document.getElementById('phone').value='".$row['phone']."';
    document.getElementById('email').value='".$row['email']."';
   
    
    </script>";
    
}
        
                $conn->close();
                
                
            }
            
            
            
            
            if(isset($_POST['btn1'])){
                
                  $servername = "localhost";
$username = "root";
$password = "";
$dbname = "ecommerce";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
                
                          $encryption = $_SESSION['user'];
  
  
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
  
                
                $sql = "update users set firstname='".$_POST['firstname']."', lastname='".$_POST['lastname']."',company='".$_POST['company']."',country='".$_POST['country']."',street1='".$_POST['street1']."',street2='".$_POST['street2']."',city='".$_POST['city']."',zipcode='".$_POST['zip']."',phone='".$_POST['phone']."' where trim(lower(email)) like trim(lower('".$decryption."'))";
                
                
                


if ($conn->query($sql) === TRUE){
    $conn->close();
    $_SESSION['ind'] = "2";
                
                echo "<script>window.location.href=window.location</script>";
}
                
                
                
            }
            
            ?>
            
            
            



<?php
            $servername = "localhost";
$username = "root";
$password = "";
$dbname = "ecommerce";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "select cg.id as 'idcg',cg.name as 'namecg', c.name from category_group cg inner join category c on cg.id=c.category_group_id";
$index =1;
$department="";
$category="";
                    $new = true;
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $index=-1;
    $i=0;
  while($row = $result->fetch_assoc()) {
     $idcg=$row['idcg'];
      $namecg=$row['namecg'];
      $namec=$row['name'];
      if($index!=$idcg){
          $index=$idcg;
          treat($department, $category);
          $department = $namecg;
          if($i<$result->num_rows)
          $category="";
      }
      
    $category = $category . $namec . '\n';
      $i++;
  }
    treat($department, $category);
    
    
} else {
  
}
$conn->close();
         
                    

        function treat($dep, $cat){
                        if(strlen($dep)>0){
    echo "<script>FillCats('".$dep."','".$cat."')</script>";
echo "<script>FillCats2('".$dep."','".$cat."')</script>";
          
                        }
                    }
        ?>    
            
               <?php
            $servername = "localhost";
$username = "root";
$password = "";
$dbname = "ecommerce";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "select * from category where category_group_id is null";


$result = $conn->query($sql);

if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
      $name=$row['name'];
      treat2( $name);
  }
    
    
} else {
  
}
$conn->close();
         
                    

        function treat2($cat){
    echo "<script>FillCats3('".$cat."')</script>";
            echo "<script>FillCats4('".$cat."')</script>";
            }
        ?>    

            <?php
            
            $currency = trim(explode(' ',$_COOKIE['currency'])[1]);
          $rt=0;
          if(!empty($_COOKIE['rt']) && $_COOKIE['rt']!="null"){
              $rt = $_COOKIE['rt'];
          }
          else{
             
              
          $req_url = 'https://api.exchangerate-api.com/v4/latest/USD';
      
          $arrContextOptions = array("ssl" => array(         "verify_peer" => false,         "verify_peer_name" => false,       ) );      $context = stream_context_create($arrContextOptions);

$response_json = file_get_contents($req_url,false,$context);

// Continuing if we got a result
if(false !== $response_json) {

    // Try/catch for json_decode operation
    try {

    // Decoding
    $response_object = json_decode($response_json);

        $rt = $response_object->rates->$currency;
       echo "<script>document.cookie='rt=".$rt."'; window.location.href=window.location.href</script>";
    

    }
    catch(Exception $e) {
        // Handle JSON parse error...
    }
}
           
          }   
            
            function MyOrders(){
                
                
                
                     $servername = "localhost";
$username = "root";
$password = "";
$dbname = "ecommerce";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
                $encryption = $_SESSION['user'];
  
  
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
  
                $sql = "select * from orders where trim(lower(user)) like trim(lower('".$decryption."')) order by date_time desc";
                


$result = $conn->query($sql);       
if ($result->num_rows > 0) {
    $ar = "";
    $currency = trim(explode(' ',$_COOKIE['currency'])[1]);
          $rt=0;
          if(!empty($_COOKIE['rt']) && $_COOKIE['rt']!="null"){
              $rt = $_COOKIE['rt'];
          }
while($row = $result->fetch_assoc()){
    
    $js = $row['order_string'];
    $ar = explode("}", $js);
    
    
      $simple_string = $row['id'];
  
  
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
  
  
    
    
    
    echo "<div id='pr-con'>
            <h3 style='color: #444'>".$row['date_time']."</h3>";
    if($row['status']==="Pending"){
                echo "<button type='button' onclick=\"TR('".$encryption."')\" class='rembtn'>Cancel</button>";
            }
    else if($row['status']==="Received"){
        echo "<div style='margin-bottom:20px'><strong style='color:green'>Received</strong></div>";
    }
    else if($row['status']==="Canceled"){
        echo "<div type='button'  style='margin-bottom:20px'><strong style='color:tomato'>Canceled</strong></div>";
    }
    foreach($ar as $value){
        if(!empty($value)){
            $img = trim(str_replace("{","",explode(";",$value)[0]));
            $name = trim(explode(";",$value)[1]);
            $qn =  trim(explode(";",$value)[3]);
            $total = trim(explode(";",$value)[4]);   
            
            echo "<div id='bar' >
            <div id='pic'>
            <img src='".$img."'/>
            </div>
            <div id='name' style='width:50%; font-weight:normal'>".$name."</div>
            <div id='price' style='flex:1; display:flex; font-weight:bold'>Quantity(".$qn.")</div>
            
            
            </div>";
            
        }
    }
     $final_price =$row['total'];
      if($rt != 0)
      $final_price = round(($row['total'] * $rt), 2);
    
    echo "<div style='margin-top:20px'>
    <strong style='color:#555'>Total: <strong style='color:tomato'>".$currency." ".$final_price."</strong><strong>
    </div>";
    echo "</div>";
    
}
}
        
                $conn->close();
                
                
                
            }
            
            if(isset($_POST['pt'])){
                $_SESSION['ind'] = "1";
                $encryption = $_COOKIE['pattern'];
                
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
                $sql = "update orders set status='Canceled' where id=".$decryption;
                

if ($conn->query($sql) === TRUE) {
    
}
  
    
    $conn->close();
                
                
                echo "<script>window.location.href='my-account.php'</script>";
            }
            
            
            function GetPass(){
                              $servername = "localhost";
$username = "root";
$password = "";
$dbname = "ecommerce";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
                $encryption = $_SESSION['user'];
  
  
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
  
                $sql = "select * from users where trim(lower(email)) like trim(lower('".$decryption."'))";
                


$result = $conn->query($sql);       
                
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $p = $row['pass'];
    $conn->close();
 return $p;
}
                $conn->close();
                return "-1";
                
            }
            if(isset($_POST['svd'])){
                $_SESSION['ind'] = "3";
                $userpass = GetPass();
                $pass = $_POST['mypass'];
                if($userpass!=$pass){
                    echo "<script>alert('Wrong password')</script>";
                }
                else {
                    UpUs();
                }
                echo "<script>window.location.href='my-account.php'</script>";
            }
            function UpUs(){
                                $servername = "localhost";
$username = "root";
$password = "";
$dbname = "ecommerce";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
                $encryption = $_SESSION['user'];
  
  
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
  
                if(!empty($_POST['mypass2']))
                $sql = "update users set email='".$_POST['emailaddress']."',pass='".$_POST['mypass2']."' where trim(lower(email)) like trim(lower('".$decryption."'))";
                else $sql = "update users set email='".$_POST['emailaddress']."' where trim(lower(email)) like trim(lower('".$decryption."'))";
                
                


if ($conn->query($sql) === TRUE){
 $simple_string = $_POST['emailaddress'];
  
// Display the original string
echo "Original String: " . $simple_string;
  
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
  
  
    $_SESSION['user'] = $encryption;   
    $conn->close();
    echo "<script>window.location.href='my-account.php'</script>";
}
                

              $conn->close();
            }
            
            ?>
        </form>
        </div>
        
        
        
    </body>
</html>