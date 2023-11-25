<?php
session_start();
?>
<html>
<head>
    <title>E-commerce</title>
    <link rel="stylesheet" href="style.css"/>
    <link rel="stylesheet" href="media.css"/>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <script>
        var i = 0;
    function send_br(br){
        if(i==1){
            BRAND(br);
        }
        else send_br(br);
    }
        window.addEventListener('load', function(){
            i = 1;
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
                    <button type="button">English</button>
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
                 </div>
                 <div id="search-bar">
                 <input id='search' onkeypress="ENTER(this,event)" type="search"  placeholder="Search for something"/>
                     <div style="width: 100%; height: 100%; display: flex;position: absolute;left: 0;top: 0;align-items: center;">
                     <img onclick="SEARCH()" id="search" src="assets/search.png"/>
                     </div>
                 </div>
                 
                 <div id="details" style="margin-left: auto; ;align-items: center;height: 100%;margin-right: 20px;">
                 
                     <div  onclick="window.location.href='login.php'"  class="circle medium-size-holder border-holder center" style="cursor: pointer">
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
                         <button type="button"   onclick="window.location.href='checkout.php'">Checkout</button>
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
            
        
        
        <div id="shop">
        <div id="left">
            
             <div class="title" style="margin-bottom: 0">
            <a style="font-weight: bold; color: #333">-- PRODUCTS CATEGORIES --</a>
            </div>
            
            <div id="all-cats2">
            
            
            </div>
            
            <br>
            <div class="title">
            <a style="font-weight: bold; color: #333">-- FILTER BY PRICE --</a>
            </div>
            
            
            <div id="prices">
            <input type="number" placeholder="Min price" id="mn"/>
                <input type="number" placeholder="Max price" id="mx"/>
                <button type="button" onclick="RANGE()">Set Range</button>
            </div>
            
            <br>
            <div class="title">
            <a style="font-weight: bold; color: #333">-- PRODUCT STATUS --</a>
            </div>
            
            <span>
            <input  type="checkbox" value="In Stock" id="stock"/>
            <label style="color: #666; font-size: 14px" for="stock">In Stock</label>
                <input type="text"  id="stock_inp" name="stock_inp" hidden/>
                <input type="text"  id="offer_inp" name="offer_inp" hidden/>
                <button id="casebtn" name="casebtn" hidden></button>
            </span>
            <br><br>
            <span>
            <input  type="checkbox" value="Has Offer" id="offer"/>
            <label style="color: #666; font-size: 14px" for="offer">Has Offer</label>
            </span>
            
            <br><br>
              <div class="title" >
            <a style="font-weight: bold; color: #333">-- BRANDS --</a>
            </div>
            
      <?php
            
         fillbrands();
            
            ?>
            
            <img id="poster1" src="assets/poster.gif"/>
            
            
            </div>
            <div id="right">
            
                <div id="poster-holder">
                <img id="poster2" src="assets/bg1.jpg"/>
                    <div id="inner">
                    <a>Organic Meals Prepared</a>
                        <div style="display: flex"><h1>Delivered to</h1>&nbsp;<h1 style="color: white">your Home</h1></div>
                        <p>Fully prepared and delivered nationwide</p>
                    </div>
                </div>
                
                
                <div id="browse-by-cat" style="border: none;width: 100%;">
                
                    <div id="right">
                    <div id="top" style="border-top:1px solid transparent">
                        
                
            <?php 
                        fillpros();
                        ?>
                        
                        
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
            <div style="display: flex;align-items: center;justify-content: center;width: auto;margin-right: auto;">
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
                echo "<script>  
                document.cookie='pagination2=0';
                
                
                localStorage.setItem('mn','0');
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
         
            </div>   
            <div id="loader">
            <img src="assets/load.gif"/>
            </div>
        <button hidden id='ref_br' name='ref_br'></button>    
            <input hidden type="text" id="inp_br" name='inp_br'/>
            
            <input hidden type="text" id="tmp_mn" name="tmp_mn"/>
            <input hidden type="text" id="tmp_mx" name="tmp_mx"/>
            <button hidden id="tmp_range" name="tmp_range"></button>
            
        <script>
            function ENTER(target, e){
                 if(e.key=="Enter"){
                     SEARCH();
                     event.preventDefault();
                 }
                     

                 return false;
             }
            if(document.cookie.indexOf("query=")!=-1){
                
                var t = document.cookie.substring(document.cookie.indexOf('query=')+6);
                t = t.substring(0, t.indexOf(';'));
                if(t!="null")
                document.getElementById('search').value = t;
            }
                 
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

            function RESET(url){
                 document.body.style.opacity="0";
                 window.location.href=url;
             }
            if(localStorage.getItem("mn") != null){
               if(localStorage.getItem("mn") != "0") document.getElementById("mn").value=localStorage.getItem("mn");
               
                if(localStorage.getItem("mx") != "9999999") document.getElementById("mx").value=localStorage.getItem("mx");
            }
            function RANGE(){
                var mn = document.getElementById("mn").value;
                var mx = document.getElementById("mx").value;
                if(mn==null || (""+mn).trim().length==0) mn="0";
                if(mx==null || (""+mx).trim().length==0) mx="9999999";
                document.getElementById('tmp_mn').value=mn+"";
                document.getElementById('tmp_mx').value=mx+"";
                localStorage.setItem("mn",mn+"");
                localStorage.setItem("mx",mx+"");
                setTimeout(function(){
                    document.getElementById('tmp_range').click();
                }
                    , 100);
            }
            function BRAND(br){
                document.getElementById('inp_br').value=br;
                setTimeout(function(){
                    document.getElementById('ref_br').click();
                }
                    , 100);
            }
        var stock = document.getElementById("stock");
            var offer = document.getElementById("offer");
            if(localStorage.getItem("stock")===null){
                stock.checked=false;

            }
            else{
                if(localStorage.getItem("stock")==="1")
                    stock.checked=true;
                else stock.checked=false;
            }
                        document.getElementById("stock_inp").value=stock.checked;
            if(localStorage.getItem("offer")===null)
             {   offer.checked=false;
            
             }
            else{
                if(localStorage.getItem("offer")==="1")
                    offer.checked=true;
                else offer.checked=false;
            }
            
            document.getElementById("offer_inp").value=offer.checked;
        stock.onchange=function(){
           if(stock.checked)
             localStorage.setItem("stock","1");
                else localStorage.setItem("stock","0");
            
            document.getElementById("stock_inp").value=stock.checked;
            LOADER();
            setTimeout(function(){
                document.getElementById("casebtn").click();
            }, 500);
        };
            offer.onchange=function(){
                if(offer.checked)
             localStorage.setItem("offer","1");
                else localStorage.setItem("offer","0");
                
                document.getElementById("offer_inp").value=offer.checked;
                LOADER();
                setTimeout(function(){
                document.getElementById("casebtn").click();
            }, 500);
            
        };
            
            
            
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
            var allcats3 = document.getElementById("all-cats2");
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
             
             var ar3 = [];
             var ind3=0;
function FillCats5(dep, cat){

            ar3.push(false);
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
        catClick(div_sub, "none", cat.trim().split('\n')[i]);
    }
    
    allcats3.appendChild(div_item);
    
    div_item.style.height="50px";
    Do2(div_item, ind3, h, ar3);
    ind3++;
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
            function FillCats6(cat){
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
        catClick(div_main, "none", cat.trim());
    
    
    allcats3.appendChild(div_item);
    
    div_item.style.height="50px";
}
             
             function catClick(div, dep, cat){
                 div.onclick = function(){
                     if(dep==="none"){
                           window.location.href='shop.php?category='+cat;   
                     }
                     else{
                         
                          document.cookie='query=null';
                         document.getElementById('u').value='shop.php?category='+cat;
                     document.getElementById('sh').click();
                         }
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
           
            
            function PAGINATION(i){
                    document.cookie="pagination2="+i;
                    window.location.href=window.location.href;
                }
                
            
            
            </script>
        <script src="script.js"></script>    
            
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
  //echo "0 results";
}
$conn->close();
         
                    

        function treat($dep, $cat){
                        if(strlen($dep)>0){
    echo "<script>FillCats('".$dep."','".$cat."')</script>";
echo "<script>FillCats2('".$dep."','".$cat."')</script>";
                            echo "<script>FillCats5('".$dep."','".$cat."')</script>";
          
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
  //echo "0 results";
}
$conn->close();
         
                    

        function treat2($cat){
    echo "<script>FillCats3('".$cat."')</script>";
            echo "<script>FillCats4('".$cat."')</script>";
            echo "<script>FillCats6('".$cat."')</script>";
            }
        ?>    
       
    
         <?php
           
            
            
            
            
            if(isset($_POST['casebtn'])){
                session_start();
                if(isset($_POST['stock_inp'])){
                    $_SESSION['stock'] = $_POST['stock_inp'];
                     
                } else $_SESSION['stock'] = false;
                if(isset($_POST['offer_inp'])){
                    $_SESSION['offer'] = $_POST['offer_inp'];
                    
                }
                 else $_SESSION['offer'] = false;
                
                session_write_close();
                echo "<script>window.location.href=window.location</script>";
            }
            
           
            
            
          function fillpros(){
                
              
              
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
              
                $servername = "localhost";
$username = "root";
$password = "";
$dbname = "ecommerce";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$sql="";
               $url= $_SERVER['HTTP_HOST'];   
        $url.= $_SERVER['REQUEST_URI'];
              
              $how_many_elements = 10;
                $limit = 0;
              
            if(strpos($url, '?') > -1){
            $parts = parse_url($url);
parse_str($parts['query'], $query);
        
                $ct = urldecode(explode("=",$url)[1]);
            
    $sql="select *,(select name from category where id=product.category_id) as 'catname' from product where category_id in (select id from category where ltrim(rtrim(lower(name)))=ltrim(rtrim(lower('".$ct."'))))";  
            }
            else{
                $sql = "select *,(select name from category where id=product.category_id) as 'catname' from product";
                
                
            }
              
              
              
               if(isset($_SESSION['brand'])){
                   if($_SESSION['brand']!="all"){
                       
                   $where = strpos($sql, 'product where ');
                   if($where){
                       $sql = $sql . " and brand='".$_SESSION['brand']."'"    ;
                   }
                  else $sql = $sql . " where            brand='".$_SESSION['brand']."'";
                   }
                  }
              
              if(isset($_SESSION['stock'])){
                  if($_SESSION['stock']==="true"){
                   $where = strpos($sql, 'product where ');
                   if($where){
                      $sql = $sql .  " and quantity > 0";
                   }
                  else $sql = $sql .  " where quantity > 0";
                  }
                  }
              
              if(isset($_SESSION['offer'])){
                  if($_SESSION['offer']==="true"){
                   $where = strpos($sql, 'product where ');
                   if($where){
                      $sql = $sql .  " and msg is not null and msg <> ''";
                   }
                  else $sql = $sql .  " where msg is not null and msg <> ''";
                  }
                  }
              
            if(isset($_SESSION['mn'])){
               $where = strpos($sql, 'product where ');
                   if($where){
                      $sql = $sql .  " and sell_price between ".$_SESSION['mn']." and ".$_SESSION['mx'];
                   }
                  else $sql = $sql .  " where sell_price between ".$_SESSION['mn']." and ".$_SESSION['mx'];
              }
              if(isset($_COOKIE['query']) && $_COOKIE['query']!="null" && !empty($_COOKIE['query'])){
               $where = strpos($sql, 'product where ');
                   if($where){
                      $sql = $sql .  " and trim(lower(name)) like '%".$_COOKIE['query']."%' or tags like '%".$_COOKIE['query']."%' order by name";
                   }
                  else $sql = $sql .  " where trim(lower(name)) like '%".$_COOKIE['query']."%' or tags like '%".$_COOKIE['query']."%' order by name";
              }
              
              
              
              
$result = $conn->query($sql);
              $limit = (ceil($result->num_rows/$how_many_elements))-1;
              
              $indice = 0;
            if(isset($_COOKIE['pagination2']))
            {
                $indice = $_COOKIE['pagination2'];
            }
             
        $from = $indice;
                    $to = $indice+$how_many_elements;
              
              
              
              
              $sql.=" limit ".((int)$from*(int)$how_many_elements).",".$how_many_elements;
              $result = $conn->query($sql);
              //echo "<script>alert('".$limit."')</script>";
              

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
                            <a style='color: tomato;font-size: 20px;font-weight: bold'>". $currency." ".$final_price."</a>
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
    
    
      
                    $left = $from-3;
                    if($left<0) $left = 0;
                    $right = ($to);
                    if($right > $limit) $right = $limit;


 echo "<div id='pagination'>";
                    for($i = $left; $i<=$right;$i++) {
                        if($i == $from) echo "<button type='button' onclick=\"PAGINATION('".$i."')\"  style='background:royalblue;color:white'>".$i."</button>";    
                    else echo "<button type='button' onclick=\"PAGINATION('".$i."')\">".$i."</button>";    
                        
                    }
                    echo "</div>";
    
} else {
  //echo "0 results";
}
$conn->close();
         
                    

          }
        
        ?> 
            
            <?php
            
            
            function fillbrands(){
            $username = "root";
                $servername='localhost';
$password = "";
$dbname = "ecommerce";
                
                
                
                

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$sql="";
             
                
                
           
                $sql = "select DISTINCT brand, count(brand) as 'count' FROM product group by brand";
                
             
$result = $conn->query($sql);
        if(!$result){
            return;
        }
if ($result->num_rows > 0) {
    $st="color:#666";
    if(isset($_SESSION['brand'])){
      if($_SESSION['brand']==="all")
          $st="color:#666; font-weight:bold";
      else $st="color:#666";
      }
    echo "<div onclick=\"send_br('all')\" style='width: 80%;display: flex; align-items: 
                        center'>
                
                
                    <label style='cursor:pointer; margin-left: 5px; font-size: 14px;".$st."'>Shop all brands</label>
                    <a style='margin-left: auto; color: #333;font-size: 14px'>
                    
                    </a>
                </div> 
            <br>";
    
  while($row = $result->fetch_assoc()) {
      
      $brand = $row['brand'];
      $count = $row['count'];
      
      if(isset($_SESSION['brand'])){
      if($brand === $_SESSION['brand'])
          $st="color:#666; font-weight:bold";
      else $st="color:#666";
      }
      
      echo "<div onclick=\"send_br('".$brand."')\" style='width: 80%;display: flex; align-items: 
                        center'>
                
                
                    <label style='cursor:pointer; margin-left: 5px; font-size: 14px;".$st."'>".$brand."</label>
                    <a style='margin-left: auto;font-size: 14px;".$st."'>
                    (".$count.")
                    </a>
                </div> 
            <br>";
      
  }
    
    
} else {
  
    
    
}
$conn->close();
         
    
            }
            
            if(isset($_POST['ref_br'])){
                $_SESSION['brand'] = $_POST['inp_br'];
                echo "<script>window.location.href=window.location</script>";
            }
            if(isset($_POST['tmp_range'])){
                $_SESSION['mn'] = $_POST['tmp_mn'];
                $_SESSION['mx'] = $_POST['tmp_mx'];
                echo "<script>window.location.href=window.location</script>";
            }
            
            ?>
        
            
            
        </form>
        </div>
        
        
    </body>
</html>