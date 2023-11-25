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
     var i3=0,i2=0;
         function RETRIEVE2(){
            i2=1;
                }
        var global="";
        function SubTotal(_global){
            if(document.cookie.indexOf("currency=")==-1){
            global = "USD" + _global;
            }
            else{
                var rt = document.cookie.substring(document.cookie.indexOf("rt=")+3);
           rt=rt.substring(0,rt.indexOf(";"));
           var curr = document.cookie.substring(document.cookie.indexOf("currency=")+9);
           curr=curr.substring(0,curr.indexOf(";")).split(" ")[1].trim();
           global =curr+" "+ (Number(_global) * Number(rt.trim())).toFixed(2);
           
                
            }
        
            i3=1;
        }
        window.addEventListener('load', function(){
                if(i2==1){
                i2=0;
            RETRIEVE();
                   var tm = document.cookie;
                if(tm.indexOf('fcookie=')!=-1){
                tm=tm.substr(tm.indexOf('fcookie=')+8);
                    tm = tm.substr(0, tm.indexOf(';'));
                    if(tm!="null"){
                        window.location.href=window.location.href;
                    }
                    else cart_hidden.style.display="none";
                }
            }
            if(i3==1){
                TOTAL(global);
            }
        }, false);
    </script>
    <script>
    if(document.cookie.indexOf("currency")==-1){
        document.cookie="currency=American USD";
        document.cookie="rt=null";
    }
    </script>
    </head>
    <body>
    <div id="wrapper">
        <form method="post" target="_self" style="width:100%; height:100%">
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
                 
                     <div onclick="window.location.href='login.php'"  class="circle medium-size-holder border-holder center" style="cursor: pointer">
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
           
        
        <div id="cart-page">
        <div id="main">
            <h1>Billing Details</h1>
                <a>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</a>
            </div>
            </div>
       
        <div id="checkout">
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
            <input id="email" name="email" type="text"/>
                    </div>
                </div>
                
                
                
            </div>
            </div>
            <div id="right">
            <div id="inner">
            
                <div id="in">
                    
                    
                <div id="title">
                    YOUR ORDER
                    </div>
                    <div id="bar" style="border-bottom: 1px solid #ccc;">
                    <a>Product</a>
                        <a>Subtotal</a>
                    </div>
               
                    
                    
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
            
                    Cart();
                    
                          function Cart(){

                if (isset($_COOKIE["fcookie"])) 
            {
                        
                    if($_COOKIE["fcookie"]==="null"){
                        echo "<script>RETRIEVE2()</script>";
                        return;
                    }
                $ar = explode("-", $_COOKIE["fcookie"]);
                $count = count($ar);
                $str="";
                    $in=0;
                    $global=(double)0.0;
                for($i=0;$i<$count;$i++){
                    $str=$ar[$i];
                    if(!empty($str)){
                     fill(explode(" ",$str)[0], explode(" ",$str)[1], explode(" ",$str)[2], explode(" ",$str)[3], $in, $global);
                        $in++;
                    }
                }
                    $global =  number_format((float)$global, 2, '.', ''); ;

                    echo "<script>SubTotal('".$global."')</script>";
            }
                else Cart();
            }
                    
                    function fill($cat, $pr, $q2, $index, $in, &$global){
                   $servername = "localhost";
$username = "root";
$password = "";
$dbname = "ecommerce";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
                $sql = "select * from product where category_id=".$cat."  and id=".$pr;
                

                       $currency = trim(explode(' ',$_COOKIE['currency'])[1]);
          $rt=0;
          if(!empty($_COOKIE['rt']) && $_COOKIE['rt']!="null"){
              $rt = $_COOKIE['rt'];
          }



$result = $conn->query($sql);

if ($result->num_rows > 0) {
    
  while($row = $result->fetch_assoc()) {
      $id = $row['id'];
      $name = $row['name'];
      $cat_id = $row['category_id'];
      $sell_price = $row['sell_price'];
      $quantity = $row['quantity'];
      $short_desc = $row['short_desc'];
      
      $msg = $row['msg'];
      $value = $row['value'];
      $final_price =$sell_price;
      if($rt != 0)
      $final_price = round(($sell_price * $rt), 2);
      if(!empty($msg) && !empty($value) && is_numeric($value)){
          $pt =((double)$sell_price - ((double)$sell_price * (double)$value)/100) * ((int)$q2);
          $global = ((double)$global) + $pt;
           echo "<div id='bar'>
                    <a>".$name."</a>
                        <a style='width:50%;margin-left:auto;text-align:right'><strong>".$currency." ".(((double)$final_price) * ((int)$q2))." (-".$value."%)"."</strong></a>
                    </div>";
      }
      else{
      $global = ((double)$global) + ((double)$sell_price) * ((int)$q2);
           echo "<div id='bar'>
                    <a>".$name."</a>
                        <a style='width:50%;margin-left:auto;text-align:right'><strong>".$currency." ".(((double)$final_price) * ((int)$q2))."</strong></a>
                    </div>";
      }
      
     

   
    
      
  }
            }
                $conn->close();
            }
                    
                    ?>
                    
                    
                    
                    <div id="shipping" style="border-bottom: 1px solid #ccc;border-top: 1px solid #ccc;">
                    <div id="l">
                        <strong>Shipping</strong>
                        </div>
                        <div id="r">
                 <div id="on-line">
                            <label for="free">Free shipping </label>
                            <input style="margin: 0" type="radio" id="free"/>
                            </div>
                            <div id="on-line">
                            <label for="local">Local pickup</label>
                            <input style="margin: 0" type="radio" id="local"/>
                            </div>
                        </div>
                    </div>
                     <div id="bar" style="border-bottom: 1px solid #ccc;">
                    <a>Total</a>
                        <a><strong style="color: tomato" id='total-a'></strong></a>
                    </div>
                    <div id="bar" style="display: block; color: #333; font-weight: bold;">
                    
                        <div id="on-line">
                        <input type="radio" id="cash"/>
                        <label for="cash">Cash on delivery</label>
                        </div>
                    
                    </div>
                    <div id="bar" style="display: block; padding-top: 0;color: #555;line-height: 1.5; font-size: 14px">
                    Your personal data will be used to process your order, support your experience throughout this website, and for other purposes described in our privacy policy.
                    </div>
                    
                     <div id="bar" style="display: block; color: #555;padding-top: 0">
                    
                    <div id="on-line">
                        <input type="checkbox" id="policy"/>
                        <label for="policy">I have read and agree to the website <a style="color: tomato; font-weight: bold; line-height: 1.5">terms and conditions</a></label>
                        </div>
                    </div>
                    
                    <div id="bar" style="padding: 0">
                    <button type="button" onclick="ORDER()">Place Order</button>
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
                <div  onclick="window.location.href='login.php'" class="circle medium-size-holder border-holder center" style="cursor: pointer;margin-left: 20px;width: 25px; height: 25px">
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
            
            <input hidden type="text" id='txt1' name='txt1'/>
            <button hidden id="btn1" name="btn1"></button>
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

                document.getElementById("selector").onchange=function(){
                document.getElementById('s').value=document.getElementById('selector').value;
               
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


                
 function RESET(url){
                 document.body.style.opacity="0";
                 window.location.href=url;
             }
                  var cart_hidden = document.getElementsByClassName("cart-hidden")[0];
            var cart_inside = document.getElementsByClassName("cart-inside")[0];
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
                        
                        window.location.href="index.php";
                        
                    }
                    else{
                       
                        document.cookie='fcookie='+str2; 
                        

                    }
                }
                          else {
                              window.location.href="index.php";
                          }
            }

                
            function RemCart(count){
               
                localStorage.setItem("product"+count,"null");
                
                RETRIEVE();
                window.location.href=window.location.href;
                
            }
                var free = document.getElementById("free");
                var local = document.getElementById("local");
                 free.onchange=function(){
            local.checked=!free.checked;
        }
        local.onchange=function(){
            free.checked=!local.checked;
        }
            var tm = document.cookie;
                if(tm!=null && tm.trim().length >0){
                    tm = document.cookie.substr(document.cookie.indexOf('option=')+7);
                    if(tm.indexOf('.')!=-1){
                        tm=tm.substr(0, tm.indexOf('.'));
                        if(tm.trim()=='local')
                            local.checked=true;
                        else if(tm.trim()=='free')
                            free.checked=true;
                    }
                }
                else {
                    free.checked=true;
                }
                function TOTAL(global){
                    document.getElementById('total-a').innerHTML=global;
                }
                function ORDER(){
                    if(!document.getElementById('cash').checked){
                        alert("Please select a payment method!");
                        return;
                    }
                    if(!document.getElementById('policy').checked){
                        alert("You need to agree to the website terms & services");
                        return;
                    }
                    if(free.checked){
                    document.getElementById('txt1').value="free" ;   
                    }
                    else if(local.checked){
                        document.getElementById('txt1').value="local" ;
                    }
                    document.getElementById('btn1').click();
                }
                function RN(rn){
                    document.cookie='order='+rn;
                }
            </script>
        <script src="script.js"></script>
        <?php
              
            if(isset($_SESSION['user']) && $_SESSION['user']!="none"){
             FillDetails();   
            }
            
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
    
    echo "<script>document.getElementById('firstname').value='".$row['firstname']."';
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
    document.getElementById('email').value='".$row['email']."';</script>";
    
}
        
                $conn->close();
                
                
            }
            
 
            
            if(isset($_POST['btn1'])){
                $shipping = $_POST['txt1'];
                
                
                  $encryption ="";
  if(isset($_SESSION['user'])){
      if($_SESSION['user']!="none"){
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
          $encryption = $decryption;
      }
      else {
          $encryption = "UNREGISTRED";
      }
  }
                else {
                    $encryption = "UNREGISTRED";
                }
                
                 if (isset($_COOKIE["fcookie"])) 
            {
                        
                    if($_COOKIE["fcookie"]==="null"){
                        echo "<script>RETRIEVE2()</script>";
                        return;
                    }
                $ar = explode("-", $_COOKIE["fcookie"]);
                $count = count($ar);
                $str="";
                    $in=0;
                    $global=(double)0.0;
                     $js="";
                     
                for($i=0;$i<$count;$i++){
                    $str=$ar[$i];
                    if(!empty($str)){
                     fill2(explode(" ",$str)[0], explode(" ",$str)[1], explode(" ",$str)[2], explode(" ",$str)[3], $in, $global,$js);
                        $in++;
                    }
                }
                    $global =  number_format((float)$global, 2, '.', ''); ;

                    PlaceOrder($encryption,$shipping, $js, $global);
            }
  

            }
            
                 
                    function fill2($cat, $pr, $q2, $index, $in, &$global,&$js){
                        
                   $servername = "localhost";
$username = "root";
$password = "";
$dbname = "ecommerce";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
                $sql = "select * from product where category_id=".$cat."  and id=".$pr;
                

              



$result = $conn->query($sql);

if ($result->num_rows > 0) {
    
  while($row = $result->fetch_assoc()) {
      $id = $row['id'];
      $name = $row['name'];
      $cat_id = $row['category_id'];
      $sell_price = $row['sell_price'];
      $quantity = $row['quantity'];
      $short_desc = $row['short_desc'];
      $img = "categories/".$cat_id."/".$id."/main.jpg";
      
      $msg = $row['msg'];
      $value = $row['value'];
      $pt=0;
      if(!empty($msg) && !empty($value) && is_numeric($value)){
          $pt =((double)$sell_price - ((double)$sell_price * (double)$value)/100) * ((int)$q2);
          $global = ((double)$global) + $pt;
      }
      else{
      $global = ((double)$global) + ((double)$sell_price) * ((int)$q2);
          $pt = (((double)$sell_price) * ((int)$q2));
      }
      

      $js.= "{".$img."; ".$name."; ".$id."; ".$q2."; ".$pt."}";
   
    
      
  }
            }
                $conn->close();
            }
               
            function PlaceOrder($user, $shipping, $js, $global){
                echo "<script>".$js."</script>";
                      $servername = "localhost";
$username = "root";
$password = "";
$dbname = "ecommerce";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
                
                $sql = "select max(id) as max from orders";
                $result = $conn->query($sql);
                $indice = 1;
if ($result->num_rows > 0) {
  $row = $result->fetch_assoc() ;
      $indice = (int)$row['max'] + 1;
}
                
                $date = date('m/d/Y h:i:s a', time());
                $rand = rand(1,1000000) . " - " . $indice;
                echo "<script>RN('".$rand."')</script>";
                $sql = "insert into orders (user,order_string,total,shipping,firstname,lastname,company,country,street1,street2,city,zipcode,phone,email, status,date_time,order_code) values ('".$user."','".$js."',".$global.",'".$shipping."','".$_POST['firstname']."','".$_POST['lastname']."','".$_POST['company']."','".$_POST['country']."','".$_POST['street1']."','".$_POST['street2']."','".$_POST['city']."','".$_POST['zip']."','".$_POST['phone']."','".$_POST['email']."','Pending','".$date."','".$rand."')";
                

if ($conn->query($sql) === TRUE) {
  
    echo "<script>window.location.href='success.php'</script>";
    
} else {
  
}

$conn->close();
                
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

        </form>
        </div>
        
        
    </body>
</html>