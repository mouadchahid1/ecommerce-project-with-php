<?php
session_start();
echo "<script>
document.cookie='pagination2=0';
document.cookie='fcookie=null';</script>";
?>
<html>
<head>
    <title>E-commerce</title>
    <link rel="stylesheet" href="style.css"/>
    <link rel="stylesheet" href="media.css"/>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <script>
    if(document.cookie.indexOf("currency=")==-1){
        document.cookie="currency=American USD";
        document.cookie="rt=null";
    }
    </script>
    </head>
    <body>
        
    <div id="wrapper" style="opacity: 0">
        <form style="width:100%; height:100%" method="post" target="_self">
            
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
                    <div onclick="OpenPopup('langs', 'lang-title','lang-list')" class="flex" style="margin-left: 20px; cursor: pointer; display:none" >
                    <button type="button" >English</button>
                    <img src="assets/down-arrow.png"/>
                    </div>
                    <div onclick="OpenPopup('currency', 'currency-title','currency-list')" style="margin-left: 10px; cursor: pointer" class="flex">
                    <button type="button" id='currencybtn'></button>
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
                     <img onclick='SEARCH()' id="search" src="assets/search.png"/>
                     </div>
                 </div>
                 
                 <div id="details" style="margin-left: auto; ;align-items: center;height: 100%;margin-right: 20px;">
                 
                     <div onclick="window.location.href='login.php'" class="circle medium-size-holder border-holder center" style="cursor: pointer">
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
                                <a onclick="document.cookie='query=null';document.getElementById('wrapper').style.opacity='0';  
                                            document.getElementById('wrapper').style.transition='0.5s';  
                                            document.getElementById('u').value='shop.php';document.getElementById('sh').click()">Shop</a>
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
            
            <div id="bg">
            <img class="carousel" src="assets/bg1.jpg"/>
                <img class="carousel" src="assets/bg2.jpg"/>
                <img class="carousel" src="assets/bg3.jpg"/>
                <div id="inner">
                
                    <div id="solde" class="center" style="justify-content: flex-start">
                        <a>Lorem ipsum</a>
                        <button>-50% Off</button>
                    </div>
                    <h1>Lorem ipsum dolor sit amet, consectetur adipiscing elit</h1>
                    <a>Lorem ipsum dolor sit amet.</a>
                    <div id="solde-from" style="display: flex;align-items: flex-end">
                        <a>from</a>
                        <h1 style="margin: 0; margin-left: 10px; color: tomato">$07.99</h1>
                    </div>
                    <button onclick="document.getElementById('u').value='shop.php';document.getElementById('sh').click()" class="shop-now" type="button">Shop Now</button>
                </div>
            </div>
            
            <div id="secure">
            
                <a><strong>Lorem ipsum dolor sit amet, </strong> consectetur adipiscing elit, sed do eiusmod tempor incididunt.</a>
                
            </div>
            
            
            <div id="holder1">
            
                <div id="left">
                <img src="assets/img2.jpg"/>
                    
                    <div id="inner">
                    <h1>Lorem ipsum dolor sit amet</h1>
                        <a>Lorem ipsum dolor sit amet</a> 
                        
                    </div>
                    
                </div>
                <div id="right">
                <img  src="assets/img3.jpg"/>
                    <div id="inner">
                    <h1>Lorem ipsum dolor sit amet</h1>
                        <a>Lorem ipsum dolor sit amet</a> 
                        
                    </div>
                </div>
            
            </div>
            
            
            <div class="section">
            <h1>Lorem ipsum dolor sit amet</h1>
                <a>Lorem ipsum dolor sit amet, consectetur adipiscing elit</a>
            </div>
            
            <div id="browse-by-cat">
            <div id="left">
                <div id="div1">
                    <img src="assets/img4.jpg"/>
                <h1>Lorem ipsum dolor sit amet</h1>
                        <a>Lorem ipsum dolor sit amet</a> 
                        
                </div>
                <div id="div2">
                
                    <div style="display:flex; align-items:center; justify-content:center;color:#555;margin-top:20px">
                    <a style='width:90%; font-size:14px; line-height:1.6'>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</a>
                    </div>
                    
                </div>
                <div style="margin-top: 20px;
                            padding-bottom: 30px;">
                <a style="cursor: pointer;color: #336083;margin-left: 20px;" onclick="document.getElementById('u').value='shop.php';document.getElementById('sh').click()">Shop all categories</a>
                </div>
                </div>
                <div id="right">
                
                    <div id="top">
                    
                <?php 
                        fillpros();
                        ?>
                        
                        
                    </div>
                
                    
                    
                    
                </div>
            </div>
            
            <div id="secure2" style="background: linear-gradient(90deg, #fcf1f4, #fcf1f4, #fbe4e4)">
            
                <a><strong>Lorem ipsum dolor sit amet, </strong> consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</a>
            </div>
            
            <div id="holder1">
            
                <div id="left">
                <img src="assets/bg1.jpg"/>
                    
                    <div id="inner" >
                    <h1>Lorem ipsum dolor sit amet</h1>
                        <a>Lorem ipsum dolor sit amet</a> 
                        
                    </div>
                    
                </div>
                <div id="right">
                <img  src="assets/bg3.jpg"/>
                    <div id="inner" >
                    <h1>Lorem ipsum dolor sit amet</h1>
                        <a>Lorem ipsum dolor sit amet</a> 
                        
                    </div>
                </div>
            
            </div>
            
            <div class="section" id="deals-title">
            <h1>Lorem ipsum dolor sit amet</h1>
                <a>Lorem ipsum dolor sit amet, consectetur adipiscing elit</a>
            </div>
            
            <div id="deals">
            
                <img src="assets/bg3.jpg" style="z-index: -1" class="main"/>
                <div id="inner">
                
                    <div class="section" style="margin: 0;">
                        <h1>-- HURRY UP! --</h1>
            <h1 style="font-weight:normal;color: #aaa; font-size: 18px; margin-top: 5px">-- DEAL OF THE WEEK --</h1>
                        
                        
                        <div id="slider">
                
                
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
                      <h1>SITE GUIDE</h1>
                    <a href="index.php">Home</a>
<a onclick="document.cookie='query=null';document.getElementById('wrapper').style.opacity='0';  
                                            document.getElementById('wrapper').style.transition='0.5s';  
                                            document.getElementById('u').value='shop.php';document.getElementById('sh').click()">Shop</a>
<a hidden href="featured.php">Featured</a>
                     <a href="about.php">About us</a>
                     <a href="contact.php">Contact Us</a>
                     <a href="services.php">Our Services</a>
                    </div>
                    </div>
                <div id="part">
                <div id="inner">
                    <h1>INFORMATION</h1>
                    <a href="login.php">Your Account</a>
                    <a onclick="RETRIEVE(); window.location.href='cart.php'" >Cart</a>
                    <a href="checkout.php">Checkout</a>
                    
                    </div>
                    </div>
                <div id="part">
                <div id="inner">
                    <h1>SITE POLICY</h1>
                    <a href="policy/Payment.php">Payment</a>
                    <a href="policy/Return%20Policy.php">Return Policy</a>
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
                <div onclick="RETRIEVE(); window.location.href='cart.php'"  class="circle medium-size-holder color-holder center" style="cursor: pointer;margin-left: 10px;width: 25px; height: 25px">
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
                    <a>Currency</a>
                    </div>
                    <div id="subs" class="cr-mobile">
                        
                    </div>
                </div>
            
            <div id="copyright">
            <a>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,</a>
            </div>
            
            </div>
        </div>
        
        
        <div id="expand" style="background:rgba(0,0,0,0.7);">
        <div id="center-full">
            <div id="expand-inner">
            <div id="top">
                <div id="pr-title"></div>
                <div id="info">
                <a style="color: #777">Brand: <strong id="brandname"></strong></a>
                    <a style="color: #777">SKU: <strong id="sku"></strong></a>
                         
                    
                </div>
                <img id="close-popup2" onclick="ClosePopup('expand', 'expand-inner','empty')" src="assets/close.png" style="right: 20px;"/>
                </div>
                <div id="bottom">
                
                    <div id="left">
                    <div id="main">
                        <img class='pr-main'/>
                        <div id="top-bar" class="ms-val">
                        <div id="msg">
                                <a id="mymsg"></a>
                                </div>
                                <div id="percentage">
                                <a id="myvalue"></a>
                                </div>
                        
                        </div>
                        </div>
                        <div id="pics" class="pr-pics">
                        </div>
                    </div>
                    <div id="right">
                    
                <div id="price" class="pr-price">
                        
                        </div>
                <button class="quantity" id="pr-quantity"></button>
            <a id="desc" style="color: #666" class="pr-desc"></a>        
            <div id="quantity">
                <div id="circle" onclick="Min()">-</div>
                <a id="qn">1</a>
                <div id="circle" onclick="Add()">+</div>
                <button type="button" onclick="AddCart()">Add to cart</button>
                        </div>
                        
                <div id="infos">
                <div id="bar">
                    <img src="assets/check.png"/>
                    <a  class="pr-info"></a>
                    </div>
                    <div id="bar">
                    <img src="assets/check.png"/>
                    <a class="pr-info"></a>
                    </div>
                    <div id="bar">
                    <img src="assets/check.png"/>
                    <a class="pr-info"></a>
                    </div>
                    
                    <div id="bar" style="margin-top: 30px">
                    <a>Category: <strong class="pr-info"></strong></a>
                    </div>
                    <div id="bar">
                    <a>Tags: <strong class="pr-info"></strong></a>
                    </div>

                    
                    
                        </div>
                        
                    </div>
                </div>
            
              
            </div>
            <div id="empty" style="display: none">
            
            </div>
            
            </div>
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
                  function PRODUCT(name, brandname, sku, msg, value,pr,q,desc,type,mfg,life,tags,catname, src, imgs,prid, catid, desclong, additional) {
                
            localStorage.setItem("product_name",name);
                localStorage.setItem("product_brand",brandname);
                localStorage.setItem("product_sku",sku);
                localStorage.setItem("product_price",pr);
                localStorage.setItem("product_q",q);
                localStorage.setItem("product_desc",desc);
                localStorage.setItem("product_type",type);
                localStorage.setItem("product_mfg",mfg);
                localStorage.setItem("product_life",life);
                localStorage.setItem("product_cat",catname);
                localStorage.setItem("product_tags",tags);
                localStorage.setItem("product_src",src);
                localStorage.setItem("product_catid",catid);
                localStorage.setItem("product_prid",prid);
                localStorage.setItem("product_imgs",imgs);
                localStorage.setItem("product_desclong",desclong);
                localStorage.setItem("product_additional",additional);
                
                
            
        if(msg.trim().length>0 && value.trim().length>0){
        localStorage.setItem("product_msg",msg);
            localStorage.setItem("product_value",value);
    }
                else{
                    localStorage.setItem("product_msg","");
            localStorage.setItem("product_value","");
                }
                
                
                window.location.href='product.php';
                
            }
             var slider = document.getElementById("slider");
             slider.innerHTML="";
             function REP(style, img,msg,value,name,brand,sku,price,quantity,shortdesc,type,mfg,life,tags,catname,i,id,cat_id){
                 
            var html =   " <div class='card2' "+style+"><div id='in'><div id='top'><img class='bg' src='"+img+"'/>";
                 
             if(msg.trim().length>0){
          html+= "<div id='solde'><div id='solde-inner'><div id='msg'>"+msg+"</div><div id='percentage'>"+value+"%</div></div></div>";
      }
                 var ds = shortdesc;
      if(shortdesc.length>80)
          ds = ds.substring(0,80)+"...";
                    html+= "<div id='expansion'><div  onclick=\"FillPopup('"+name+"','"+brand+"','"+sku+"','"+msg+"','"+value+"%','"+price+"','"+quantity+"','"+shortdesc+"','"+type+"','"+mfg+"','"+life+"','"+tags+"','"+catname+"','categories/"+cat_id+"/"+id+"/main.jpg','"+i+"','"+id+"','"+cat_id+"'); OpenPopup('expand', 'expand-inner','empty')\"  class='circle medium-size-holder center color-holder' style='cursor: pointer'><img class='small-img' src='assets/expand.png'/></div><div onclick=\"AddCart1('"+name+"','categories/"+cat_id+"/"+id+"/main.jpg','"+cat_id+"','"+id+"')\"  class='circle medium-size-holder center color-holder' style='cursor: pointer;margin-left: 10px;'><img class='small-img' src='assets/briefcase.png'/></div></div></div><div id='bottom'><h1>"+name+"</h1><a>"+ds+"</a><a class='price'>"+price+"</a></div></div></div>";
  
                 
                 slider.innerHTML+=html;
                 
                 
                 
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
             
             
             
             
             localStorage.setItem('stp','0');
             //document.body.style.opacity="0";
             setTimeout(function(){
                 //document.body.style.opacity="1";
                 //document.body.style.transition="0.5s";
             }, 300);
             function RESET(url){
                 document.body.style.opacity="0";
                 window.location.href=url;
             }
             function HD(){
                 document.getElementById('deals-title').style.display="none";
                 document.getElementById('deals').style.display="none";
             }
        var cart_hidden = document.getElementsByClassName("cart-hidden")[0];
            var cart_inside = document.getElementsByClassName("cart-inside")[0];
            if(cart_inside.innerHTML.trim().length==0){
                cart_hidden.style.display="none";
            }
            var qn = document.getElementById("qn");
            
            var prtitle = document.getElementById("pr-title");
            var brand = document.getElementById("brandname");
            var _sku = document.getElementById("sku");
            var _msg = document.getElementById("mymsg");
            var msgval = document.getElementById("myvalue");
            var pr_price = document.getElementsByClassName("pr-price")[0];
            var pr_desc = document.getElementsByClassName("pr-desc")[0];
            var quantity = document.getElementById("pr-quantity");
        var _type = document.getElementsByClassName("pr-info")[0];
            var _mfg = document.getElementsByClassName("pr-info")[1];
            var _life = document.getElementsByClassName("pr-info")[2];
            var cat = document.getElementsByClassName("pr-info")[3];
            var _tags = document.getElementsByClassName("pr-info")[4];
            
            var pr_main = document.getElementsByClassName("pr-main")[0];
            var pr_pics = document.getElementsByClassName("pr-pics")[0];
            var sr="";
            var nm="";
            function Min(){
                if(Number(qn.innerHTML) > 1 )
                    qn.innerHTML = Number(qn.innerHTML)-1;
            }
            function Add(){
                qn.innerHTML = Number(qn.innerHTML)+1;
            }
             var category_id;
            var product_id;
function FillPopup(name, brandname, sku, msg, value,pr,q,desc,type,mfg,life,tags,catname, src, imgs,prid, catid){
    category_id = catid;
    product_id = prid;
    qn.innerHTML = "1";
    sr=src;
    nm = name;
    pr_pics.innerHTML="";
    for(var i=1; i<=imgs; i++){
        
        
       pr_pics.innerHTML+="<div id='part'><img onmouseover='IMG(this)' onmouseout='IMGOUT()' src='categories/"+catid+"/"+prid+"/"+i+".jpg'/></div>"; //pr_main.src="";
        
    }
    pr_main.src=src;
    document.getElementsByClassName('ms-val')[0].style.display="flex";
    prtitle.innerHTML=name;
    brand.innerHTML=brandname;
    _sku.innerHTML=sku;
    pr_desc.innerHTML=desc;
    pr_price.innerHTML=pr;
    cat.innerHTML=catname;
    _type.innerHTML="TYPE: "+type;
    _mfg.innerHTML="MFG: "+mfg;
    _life.innerHTML="LIFE: "+life;
    _tags.innerHTML=tags;
    if(Number(q)>0){
        quantity.innerHTML='In Stock';
        quantity.style.color="#67c61c";
        quantity.style.width="80px";
        quantity.style.background="#e2f5d3";
    }
    else {
        quantity.innerHTML='Out of Stock';
        quantity.style.color="#e05a5a";
        quantity.style.width="110px";
        quantity.style.background="#f3e7e7";
    }
    if(msg.trim().length>0 && value.trim().length>0){
        _msg.innerHTML=msg;
        msgval.innerHTML=value;
    }
    else{
        document.getElementsByClassName('ms-val')[0].style.display="none";
    }
}
            
             
            function AddCart(){
               PROCESS(nm, sr, category_id, product_id, qn.innerHTML);
                RETRIEVE();
                document.getElementById('loader').style.display="flex";
                setTimeout(function(){
                    document.getElementById('loader').style.opacity="1";
                    
                    setTimeout(function(){
                        document.getElementById('loader').style.opacity="0";
                        setTimeout(function(){
                        document.getElementById('loader').style.display="none";
                        
                    }, 500);
                    }, 1000);
                }, 100);
            }
            function AddCart1(name, img, catid, prid){
            PROCESS(name, img, catid, prid, 1);
                RETRIEVE();
                
                
                document.getElementById('loader').style.display="flex";
                setTimeout(function(){
                    document.getElementById('loader').style.opacity="1";
                
                    setTimeout(function(){
                        document.getElementById('loader').style.opacity="0";
                        setTimeout(function(){
                        document.getElementById('loader').style.display="none";
                        
                    }, 500);
                    }, 1000);
                }, 100);
            }
            
            function PROCESS(name, img, catid, prid, q){
                
                var count = "0";
                if(localStorage.getItem("count")!= null)
                    count = localStorage.getItem("count");
                var str = catid+";"+prid+";"+name+";"+img+";"+q;
                localStorage.setItem("product"+count,str);
                var n = Number(count) + 1;
                localStorage.setItem("count", n+"");
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
             
            function IMG(img){
                pr_main.src=img.src;
            }
            function IMGOUT(){
                pr_main.src=sr;
            }
             
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
    
            
             
            </script>
        <script src="script.js"></script>
        <div id="loader" >
            <img src="assets/load.gif"/>
            </div>
        <script>
            document.getElementById('loader').style.display="none";
            document.getElementById('loader').style.opacity="0";
        function LOADER(){
        
         document.getElementById('loader').style.display="flex";
                setTimeout(function(){
                    document.getElementById('loader').style.opacity="1";
                    setTimeout(function(){
                        document.getElementById('loader').style.opacity="0";
                        setTimeout(function(){
                        document.getElementById('loader').style.display="none";
                           
                        
                    }, 100);
                    }, 1000);
                }, 100);
    }
        </script>   
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
      function fillpros(){
              
                $servername = "localhost";
$username = "root";
$password = "";
$dbname = "ecommerce";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
                $sql = "select *,(select name from category where id=product.category_id) as 'catname' from product order by rand() limit 8";
                

              



          
          
$result = $conn->query($sql);
          
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

if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
      $id = $row['id'];
      $catname = $row['catname'];
      $name = $row['name'];
      $cat_id = $row['category_id'];
      $brand = $row['brand'];
      $sku = $row['sku'];
      $msg = $row['msg'];
      $value = $row['value'];
      $initial_price = $row['initial_price'];
      $sell_price = $row['sell_price'];
      $quantity = $row['quantity'];
      $short_desc = str_replace("\n","", $row['short_desc']);
      $short_desc = preg_replace('/[^A-Za-z0-9\-, <br>]/', '', $short_desc);
      $long_desc = str_replace("\n","", $row['long_desc']);
      $long_desc = preg_replace('/[^A-Za-z0-9\-, <br>]/', '', $long_desc);
      $additional = str_replace("\n","", $row['additional_info']);
      $additional = preg_replace('/[^A-Za-z0-9\-, <br>]/', '', $additional);
      
      
      $type = $row['type'];
      $mfg = $row['mfg'];
      $life = $row['life'];
      $tags = $row['tags'];
      
      $i=1;
      while(true){if(!file_exists("categories/".$cat_id."/".$id."/".$i.".jpg")) break;
          $i++;
      }
      $i--;
      $final_price =$sell_price;
      if($rt != 0)
      $final_price = round(($sell_price * $rt), 2);
      
      $desc = $short_desc;
      if(strlen($short_desc)>80)
          $desc = substr($short_desc,0,80)."...";
      
echo "<div class='card'>
                    <div id='in'>
                            <div id='inner'>
                        
                        <div id='centered'>
                        <img src='categories/".$cat_id."/".$id."/main.jpg' class='main'/>
                            <strong>".$name."</strong>
                            <a>".$desc."</a>
                            <div style='margin-top: 0px;margin-bottom: 40px;'>
                            <a style='color: tomato;font-size: 20px;font-weight: bold'>".$currency." ".$final_price."</a>
                            </div>
                            
                            <div id='top-bar'>
                             <div onclick=\"FillPopup('".$name."','".$brand."','".$sku."','".$msg."','".$value."%','".$currency." ".$final_price."','".$quantity."','".$short_desc."','".$type."','".$mfg."','".$life."','".$tags."','".$catname."','categories/".$cat_id."/".$id."/main.jpg','".$i."','".$id."','".$cat_id."'); OpenPopup('expand', 'expand-inner','empty')\" class='circle medium-size-holder center color-holder' style='cursor: pointer'>
                     <img class='small-img' src='assets/expand.png'/>
                     </div>
                                 <div class='circle medium-size-holder center color-holder' style='cursor: pointer;margin-top: 10px' onclick=\"AddCart1('".$name."','categories/".$cat_id."/".$id."/main.jpg','".$cat_id."','".$id."')\">
                     <img class='small-img' src='assets/briefcase.png' />
                     </div>
                            </div>
                            <div id='bottom-bar'>
                            <button type='button' onclick=\"PRODUCT('".$name."','".$brand."','".$sku."','".$msg."','".$value."','".$sell_price."','".$quantity."','".$short_desc."','".$type."','".$mfg."','".$life."','".$tags."','".$catname."','categories/".$cat_id."/".$id."/main.jpg','".$i."','".$id."','".$cat_id."','".$long_desc."','".$additional."')\">Shop Now</button>
                                
                            </div> 
                        </div>
                        
                        </div>
                            </div>
                    </div>  ";
    
      
  }
    
    
} else {
  
}
$conn->close();
          fillpros2();
          }
            
            
    function fillpros2(){
        $currency = trim(explode(' ',$_COOKIE['currency'])[1]);
            $rt =$_COOKIE['rt'];
              
                $servername = "localhost";
$username = "root";
$password = "";
$dbname = "ecommerce";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$sql="";
             
                
                
           
                $sql = "select *,(select name from category where id=product.category_id) as 'catname' from product where msg is not null and msg <> '' order by rand() limit 8 ";
                
             
$result = $conn->query($sql);
        
$ind = 0;
        $style="style=\"margin:0\"";
        
        
        
        
        
        
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
      $id = $row['id'];
       
      $catname = $row['catname'];
      $name = $row['name'];
      $cat_id = $row['category_id'];
      
      
      
      $brand = $row['brand'];
      $sku = $row['sku'];
      $msg = $row['msg'];
      $value = $row['value'];
      $initial_price = $row['initial_price'];
      $sell_price = $row['sell_price'];
      $quantity = $row['quantity'];
      $short_desc = $row['short_desc'];
      $long_desc = $row['long_desc'];
      $additional = $row['additional_info'];
      $type = $row['type'];
      $mfg = $row['mfg'];
      $life = $row['life'];
      $tags = $row['tags'];
      
      $i=1;
      while(true){if(!file_exists("categories/".$cat_id."/".$id."/".$i.".jpg")) break;
          $i++;
      }
      $i--;
      
      $final_price =$sell_price;
      if($rt != 0)
      $final_price = round(($sell_price * $rt), 2);
      
      
       echo "<script>
      document;
      window.addEventListener('load', function(){
      REP('".$style."','categories/".$cat_id."/".$id."/main.jpg','".$msg."','".$value."','".$name."','".$brand."','".$sku."','".$currency." ".$final_price."','".$quantity."','".$short_desc."','".$type."','".$mfg."','".$life."','".$tags."','".$catname."','".$i."','".$id."','".$cat_id."');
      });
      </script>";
                    
      $style='';
  
      
  }
    
    
} else {
  
    echo "<script>
            window.addEventListener('load', function(){
            
            HD();
            
            }, false);
            </script>";
    
}
$conn->close();
        
         echo "<script>document.getElementById('wrapper').style.opacity='1'; document.getElementById('wrapper').style.transition='0.5s';
         </script>";
                    

          }
            
            
            ?>
 
            
        </form>
        </div>
        
    </body>
</html>