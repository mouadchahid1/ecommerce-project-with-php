<?php
session_start();

if(isset($_COOKIE["del"]) && $_COOKIE["del"] != "null"){
    $table = explode('-',$_COOKIE["del"])[0];
    $id = explode('-',$_COOKIE["del"])[1];
    
    
    if($table==="dep"){
        DEP($id);
    }
    if($table==="cat"){
        CAT($id);
    }
    if($table==="prod"){
        PROD2($id);
    }
    
    
    echo "<script>
    
    document.cookie='del=null';
    window.location.href=window.location.href;
    
    </script>";
}

  if(isset($_COOKIE["id"]) && $_COOKIE["id"] != "null"){
   
      $id = $_COOKIE["id"];
      
      
      
                     $servername = "localhost";
$username = "root";
$password = "";
$dbname = "ecommerce";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
      
      $sql = 'select * from orders where id='.$id;
      
      
       $result = $conn->query($sql);       
                            
if ($result->num_rows > 0) {
    
$row = $result->fetch_assoc();
    
$js = $row['order_string'];
    $ar = explode("}", $js);
    
    $problem = false;
    $error="";
foreach($ar as $value){
        if(!empty($value)){
            $id2 = trim(explode(";",$value)[2]);
            $name = trim(explode(";",$value)[1]);
            $qn =  trim(explode(";",$value)[3]);
            
            $sql = "select quantity from product where id=".$id2;
             $result = $conn->query($sql);       
            $row = $result->fetch_assoc();
            
            if( ((int)$row['quantity']-(int)$qn) <0 )
            {
                $error.= "Product (".$name.") quantity is not sufficient, please consider adding ".(((int)$row['quantity']-(int)$qn)*-1)." to its quantity!           ";
                $problem=true;
            }
            
            
        }
    }
    
}
      if($problem){
          echo "<script>alert('".$error."           The query failed!"."')</script>";
      }
      
      else{
          
          foreach($ar as $value){
        if(!empty($value)){
            $id2 = trim(explode(";",$value)[2]);
            $name = trim(explode(";",$value)[1]);
            $qn =  trim(explode(";",$value)[3]);
            
            $sql = "select quantity from product where id=".$id2;
             $result = $conn->query($sql);       
            $row = $result->fetch_assoc();
            
            
                
                   $sql = "update product set quantity=quantity - ".$qn." where id=".$id2;
                
          

$conn->query($sql);
                
            
            
            
        }
    }

          
      
                $sql = "update orders set status='Received' where id=".$id;
                
          

$conn->query($sql);

          
      
    }

  echo "<script>  document.cookie='id=null';
          
      //document.cookie='pagination=0-0-0-0-0';
      
      window.location.href=window.location.href;</script>";
    
    $conn->close();
                
      

      
  }
            
            
            if(isset($_COOKIE["pr_curr"])){
                $cr = $_COOKIE["pr_curr"];
                $rt = $_COOKIE["pr_r"];
                echo "<script>
                window.addEventListener('load', function(){
                SetCookie2('".$cr."','".$rt."');
                }, false);        
                        </script>";
            }
            else{
                echo "<script>
                window.addEventListener('load', function(){
                SetCookie('USD','1');
                }, false);
                        </script>";
            }
            
            


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
        
        $conn->close();
        
        FillFields();
        
       
    }
    else{
        $_SESSION['admin']='null';
        echo "<script>alert('You are not an admin!')</script>";
    echo "<script>
                window.location.href='dashboard.php';
                </script>";
    }

}
    else{
        $_SESSION['admin']='null';
    echo "<script>
                window.location.href='dashboard.php';
                </script>";
    }
    
    
    
    
}
else echo "<script>
                window.location.href='dashboard.php';
                </script>";
?>
<html>
<head>
    <title>E-commerce</title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="style-dashboard.css"/>
    <link rel="stylesheet" href="media-dashboard.css"/>
    <style>
        body{
            overflow: hidden;
            background: white;
        }
        #wrapper{
            opacity: 0;
        }
    </style>
    
    </head>
    <body>
        <form style="width: 100%; height: 100%" method="post" target="_self" enctype="multipart/form-data">
 
        <div id="wrapper">
            <div id="container">
            <div id="top" class="topbar">
            <img class="medium" src="assets/database.png"/>
                <div id="title">
                <h3>E-commerce app</h3>
                    <a>Through this planel, you can manipulate your project's database</a>
                </div>
                <div id="right-div">
                <img src="assets/notif-off.png" onclick="OpenPopup('notifs', 'centered')" id='my-notif'/>
                    <button type="button" onclick="DISCONNECT()">Disconnect</button>
                    <button id="btn1" hidden name="btn1"></button>
                    <?php
    if(isset($_POST['btn1'])){
        $_SESSION['admin']='null';
        echo "<script>window.location.href='dashboard.php';</script>";
    }
    ?>       
                </div>
            </div>
            <div id="bottom">
            <div id="left">
                
                <div id="menu-item">
                <a>-- Main dashboard --</a>
                </div>
                
                <div class="item">
                <div id="main" onclick="Click('0')">
                    <img src="assets/home.png"/>
                    <a>Home</a>
                    </div>
                </div>
                <div class="item">
                <div id="main">
                    <img src="assets/category.png"/>
                    <a>Departments</a>
                    </div>
                    <div id="subs">
                    
                        <div id="sub"  onclick="Click('1')">
                        <a>Add department</a>
                        </div>
                        <div id="sub"  onclick="Click('2')">
                        <a>Check list</a>
                        </div>
                        
                    </div>
                </div>
                <div class="item">
                <div id="main">
                    <img src="assets/department.png"/>
                    <a>Categories</a>
                    </div>
                    <div id="subs">
                    
                        <div id="sub" onclick="Click('3')">
                        <a>Add category</a>
                        </div>
                        <div id="sub" onclick="Click('4')">
                        <a>Check list</a>
                        </div>
                        
                    </div>
                </div>
                <div class="item">
                <div id="main">
                    <img src="assets/product.png"/>
                    <a>Products</a>
                    </div>
                    <div id="subs">
                    
                        <div id="sub" onclick="Click('5')">
                        <a>Add product</a>
                        </div>
                        <div id="sub" onclick="Click('6')">
                        <a>Check list</a>
                        </div>
                        
                    </div>
                </div>
                <div class="item" >
                <div id="main">
                    <img src="assets/orders.png"/>
                    <a>Orders</a>
                    </div>
                    <div id="subs">
                    <div id="sub" onclick="Click('11')">
                        <a>Pending</a>
                        </div>
                        <div id="sub" onclick="Click('12')">
                        <a>Received</a>
                        </div>
                        <div style="display:none" id="sub" onclick="Click('13')">
                        <a>Cancelled</a>
                        </div>
                    </div>
                </div>
                <div class="item">
                <div id="main">
                    <img src="assets/settings.png"/>
                    <a>Settings</a>
                    </div>
                    <div id="subs">
                    
                        <div id="sub" onclick="Click('8')">
                        <a>Privacy</a>
                        </div>
                        <div style='display:none' id="sub" onclick="Click('9')">
                        <a>Users list</a>
                        </div>
                        <div id="sub" onclick="Click('10')">
                        <a>Newsletter</a>
                        </div>
                        <div id="sub" onclick="DISCONNECT()">
                        <a>Disconnect</a>
                        </div>
                        
                    </div>
                </div>
                
                
                
                </div>
                <div id="right">
                <div id="center">
                    
                    <div class="section">
                    
                        <div id="main-title">
                            <a>-- Home --</a>
                        </div>
                        
                        <div id="inside">
                        
                        <div id="holder">
                            
                            <div class="home-card">
                            
                            <div id="inner">
                                
                                <img src="assets/home-logo.png"/>
                                <a><strong style="font-weight:bold;" id='dep-txt'></strong><br>
                                <br>You can add or view a list of available departments through the menu!
                                </a>
                                
                                </div>
                            </div>
                            <div class="home-card">
                            
                            <div id="inner">
                                
                                <img src="assets/home-logo.png"/>
                                <a><strong style="font-weight:bold;" id='cat-txt'></strong><br>
                                <br>You can add or view a list of available categories through the menu!
                                </a>
                                
                                </div>
                            </div>
                            <div class="home-card">
                            
                            <div id="inner">
                                
                                <img src="assets/home-logo.png"/>
                                <a><strong style="font-weight:bold;" id='prod-txt'></strong><br>
                                <br>You can add or view a list of available products through the menu!
                                </a>
                                
                                </div>
                            </div>
                            
                            
                   
                            <div class="home-card">
                            
                            <div id="inner">
                                
                                <img src="assets/home-logo.png"/>
                                <a><strong style="font-weight:bold;" id='pending-txt'></strong><br>
                                <br>You can view a list of available pending orders through the menu!
                                </a>
                                
                                </div>
                            </div>
                            
                            
                            <div class="home-card">
                            
                            <div id="inner">
                                
                                <img src="assets/home-logo.png"/>
                                <a><strong style="font-weight:bold;" id='received-txt'></strong><br>
                                <br>You can view a list of available received orders through the menu!
                                </a>
                                
                                </div>
                            </div>
                            
                              <div class="home-card">
                            
                            <div id="inner">
                                
                                <img src="assets/home-logo.png"/>
                                <a><strong style="font-weight:bold;" id='users-txt'></strong><br>
                                <br>For security reasons, if you would like to see a list of users check the database!
                                </a>
                                
                                </div>
                            </div>
                     
                            
                            
                            </div>
                        </div>
                        
                        
                    </div>
                    <div class="section">
                    
                        <div id="main-title">
                            <a>-- Add new department --</a>
                        </div>
                        
                        <div id="inside">
                        
                            <div id="bar">
                            <a>Identity</a>
                                <input id="department-id" name="department-id" type="number" readonly/>
                            </div>
                            <div id="bar">
                            <a>Department name</a>
                                <input type="text" id="department-name" name="department-name" />
                            </div>
                            
                        </div>
                        
                        <button id="department-btn" name="department-btn" class="insertion">Confirm Insertion</button>
                        <button id="modify1" name="modify1" class="insertion">Confirm Modification</button>
                        <?php
                        if(isset($_POST['modify1'])){
                               $name = $_POST['department-name'];
                
                
                      $servername = "localhost";
$username = "root";
$password = "";
$dbname = "ecommerce";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
                $sql = "update category_group set name='".$name."' where id=".$_POST['department-id'];
                

if ($conn->query($sql) === TRUE)
{
    echo "<script>window.location.href=window.location.href</script>";
}
                $conn->close();
             
                        }
                        ?>
                        <button type="button" onclick="Click('2')" id="modify1_1"  class="modification">Cancel</button>
                        
            <?php
            if(isset($_POST['department-btn'])){
                $name = $_POST['department-name'];
                
                
                      $servername = "localhost";
$username = "root";
$password = "";
$dbname = "ecommerce";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
                $sql = "insert into category_group (name) values('".$name."')";
                

if ($conn->query($sql) === TRUE)
{
    echo "<script>window.location.href=window.location.href</script>";
}
                $conn->close();
                
            }
            
            ?>
            
              
                    </div>
                    <div class="section">
                    
                        <div id="main-title">
                            <a>-- List of departments --</a>
                        </div>
                        <div id="bar">
<input class="searching" oninput="SRCH('department-table','search-department',0)" type="search" id="search-department" name="search-department" placeholder="Search for a department by name" />
                            </div>
                        <div id="inside" style="margin-top:30px;height:70%">
                       
              
                    
                    <?php
                    
echo "  <table id='department-table' border='0'>
                    <tr>
                    <th style='width:10%;'>Id</th>
                        <th id='depname2' style=''>Department name</th>
                        <th></th>
                        <th></th>
                    </tr>";
        
                    
                    
         $servername = "localhost";
$username = "root";
$password = "";
$dbname = "ecommerce";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
                    $how_many_elements = 10;
                $limit = 0;
                    $sql = "select count(*) as 'max' from category_group";
                
            $result = $conn->query($sql);       
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $limit = (ceil($row['max']/$how_many_elements))-1;
}
                    
                        $indice = 0;
            if(isset($_COOKIE['pagination']))
            {
                $indice = explode('-', $_COOKIE['pagination'])[0];
            }
             
        $from = $indice;
                    $to = $indice+$how_many_elements;
 $sql = "select * from category_group";
                
            $result = $conn->query($sql);       
if ($result->num_rows > 0) {
    
while($row = $result->fetch_assoc()){
    echo "<tr style='height:50px'>";
    echo "<td>".$row['id']."</td>";
    echo "<td >".$row['name']."</td>";
    echo "<td><div onclick=\"document.getElementById('department-id').value='".$row['id']."';document.getElementById('department-name').value='".$row['name']."';document.getElementById('department-btn').style.display='none';document.getElementById('modify1').style.display='block';document.getElementById('modify1_1').style.display='block';Click('1')\" class='modify'><img src='assets/edit.png'/></div></td>";
    echo "<td><div class='delete' onclick=\"
    
    document.cookie='del=dep-".$row['id']."';
    window.location.href=window.location.href;
    
    \"><img src='assets/delete.png'/></div></td>";
    echo "</tr>";
}
}
                    
                    $left = $from-3;
                    if($left<0) $left = 0;
                    $right = ($to);
                    if($right > $limit) $right = $limit;
                    
                    //echo "<script>alert('".$left."')</script>";
                    //echo "<script>alert('".$right."')</script>";
                    //echo "<script>alert('".$limit."')</script>";
                            
                            echo "</table>";
                    
                
                    
                    $conn->close();
                    
                    ?>
                    
                            
                            
                        </div>
                        
                    </div>
                    <div class="section">
                    
                        <div id="main-title">
                            <a>-- Add new category --</a>
                        </div>
                        
                         <div id="inside">
                        
                            <div id="bar">
                            <a>Identity</a>
                                <input id="category-id" name="category-id" type="number" readonly/>
                            </div>
                            <div id="bar">
                            <a>Category name</a>
                                <input type="text" id="category-name" name="category-name" />
                            </div>
                             <div id="bar" name='prop' onclick="SideBar(0)">
                            <a>Department name (optional)</a>
                                <input type="text" id="department-name2" name="department-name2" readonly />
                            </div>
                            
                        </div>
                        
                        <button name="category-btn" id="category-btn" class="insertion">Confirm Insertion</button>
                        <button id="modify2" name="modify2" class="insertion">Confirm Modification</button>
                        <?php
                        if(isset($_POST['modify2'])){
                               $name = $_POST['category-name'];
                
                
                      $servername = "localhost";
$username = "root";
$password = "";
$dbname = "ecommerce";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
                $sql = "update category set name='".$name."' where id=".$_POST['category-id'];
                

if ($conn->query($sql) === TRUE)
{
    echo "<script>window.location.href=window.location.href</script>";
}
                $conn->close();
             
                        }
                        ?>
                        <button type="button" onclick="Click('4')" id="modify2_1"  class="modification">Cancel</button>
                        
                      <?php
            if(isset($_POST['category-btn'])){
                                $name = $_POST["category-name"];
                $dep = $_POST["department-name2"];
                
                
                      $servername = "localhost";
$username = "root";
$password = "";
$dbname = "ecommerce";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
                $sql="";
                if(!empty($dep)){
                    $id = trim(explode("-",trim($dep))[0]);
                $sql = "insert into category (name, category_group_id) values('".$name."',".$id.")";
                }
                else $sql = "insert into category (name) values('".$name."')";
                

                
if ($conn->query($sql) === TRUE){
    echo "<script>window.location.href=window.location.href</script>";
}
                $conn-close();
            
            }
            ?>
                        
                    </div>
                    <div class="section">
                    
                        <div id="main-title">
                            <a>-- List of categories --</a>
                        </div>
                         <div id="bar">
<input class="searching" oninput="SRCH('category-table','search-category',1)" type="search" id="search-category" name="search-category" placeholder="Search for a category by name" />
                            </div>
                        <div id="inside" style="margin-top:30px;height:70%">
                       
              
                    
                    <?php
                    
echo "  <table id='category-table' border='0'>
                    <tr>
                    <th style='width:10%;'>Id</th>
                        <th style='width:calc(40%);'>Category name</th>
                        <th id='depname' style=''>Deparment name</th>
                        <th></th>
                        <th></th>
                    </tr>";
        
                    
                    
         $servername = "localhost";
$username = "root";
$password = "";
$dbname = "ecommerce";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
                    $how_many_elements = 10;
                $limit = 0;
                    $sql = "select count(*) as 'max' from category";
                
            $result = $conn->query($sql);       
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $limit = (ceil($row['max']/$how_many_elements))-1;
}
                    
                        $indice = 0;
            if(isset($_COOKIE['pagination']))
            {
                $indice = explode('-', $_COOKIE['pagination'])[1];
            }
             
        $from = $indice;
                    $to = $indice+$how_many_elements;
 $sql = "select *, (select name from category_group where id = category.category_group_id) as 'dep' from category";
                
            $result = $conn->query($sql);       
if ($result->num_rows > 0) {
    
while($row = $result->fetch_assoc()){
    
    $nm = $row['name'];
    if(strlen($nm) > 20)
        $nm = substr($nm, 0, 20) . "...";
    
    echo "<tr style='height:50px'>";
    echo "<td>".$row['id']."</td>";
    echo "<td >".$nm."</td>";
    echo "<td >".$row['dep']."</td>";
    echo "<td><div onclick=\"document.getElementById('category-id').value='".$row['id']."';document.getElementById('category-name').value='".$row['name']."';document.getElementById('department-name2').value='".$row['dep']."';document.getElementsByName('prop')[0].style.display='none';document.getElementById('category-btn').style.display='none';document.getElementById('modify2').style.display='block';document.getElementById('modify2_1').style.display='block';Click('3')\" class='modify'><img src='assets/edit.png'/></div></td>";
    echo "<td><div onclick=\"
    
    document.cookie='del=cat-".$row['id']."';
    window.location.href=window.location.href;
    
    \" class='delete'><img src='assets/delete.png'/></div></td>";
    echo "</tr>";
}
}
                    
                    $left = $from-3;
                    if($left<0) $left = 0;
                    $right = ($to);
                    if($right > $limit) $right = $limit;
                    
                    //echo "<script>alert('".$left."')</script>";
                    //echo "<script>alert('".$right."')</script>";
                    //echo "<script>alert('".$limit."')</script>";
                            
                            echo "</table>";
                    
                  
                    
                    $conn->close();
                    
                    ?>
                    
                            
                            
                        </div>
                       
                        
                    </div>
                    <div class="section">
                    
                        <div id="main-title">
                            <a>-- Add new product --</a>
                        </div>
                        <div id="inside">
                        
                            <div id="bar">
                            <a>Identity</a>
                                <input id="product-id" name="product-id" type="number" readonly/>
                            </div>
                            <div id="bar">
                            <a>Product name</a>
                                <input id="product-name" name="product-name" type="text" />
                            </div>
                            <div id="bar" name="prop" onclick="SideBar(1)">
                            <a>Category name</a>
                                <input id="category-name2" name="category-name2"  type="text" readonly/>
                            </div>
                            <div id="bar">
                            <a>Product brand</a>
                                <input id="product-brand" name="product-brand" type="text" />
                            </div>
                            <div id="bar">
                            <a>Product SKU</a>
                                <input id="product-sku" name="product-sku" type="text" />
                            </div>
                            <div id="bar">
                            <a>Is there any discount?</a>
                                <input id="product-discount" name="product-discount" placeholder="0%" type="number" />
                            </div>
                            <div id="bar">
                            <a>Currency (you can change it from settings/privacy)</a>
                                <input id="currency" name="currency" value="USD" type="text" readonly/>
                            </div>
                            <div id="bar">
                            <a>Product initial price</a>
                                <input id="product-initialprice" name="product-initialprice" type="number" />
                            </div>
                            <div id="bar">
                            <a>Product sell price</a>
                                <input id="product-sellprice" name="product-sellprice" type="number" />
                            </div>
                            <div id="bar">
                            <a>Product quantity</a>
                                <input id="product-quantity" name="product-quantity" type="number" />
                            </div>
                            <div id="bar">
                            <a>Product short description (max 150 characters)</a>
                                <textarea id="product-shortdesc" name="product-shortdesc" type="text" maxlength="150"></textarea>
                            </div>
                            <div id="bar">
                            <a>Product long description (optional)</a>
                                <textarea id="product-longdesc" name="product-longdesc" type="text"></textarea>
                            </div>
                            <div id="bar">
                            <a>Product additional information (optional)</a>
                                <textarea id="product-additional" name="product-additional" type="text" ></textarea>
                            </div>
                            
                             <div id="bar">
                            <a>Product type</a>
                                <input id="product-type" name="product-type" type="text" />
                            </div>
                             <div id="bar">
                            <a>Product mfg</a>
                                <input id="product-mfg" name="product-mfg" type="text" />
                            </div>
                             <div id="bar">
                            <a>Product life</a>
                                <input id="product-life" name="product-life" type="text" />
                            </div>
                             <div id="bar">
                            <a>Product tags (separated by comma ',')</a>
                                <input id="product-tags" name="product-tags" type="text" />
                            </div>
                            <div id="bar" name="prop">
                            <a  id="for-image">Main product picture</a>
                                <label for="image" class="upload">Upload</label>
                            </div>
                            <div id="bar" name="prop">
                            <a id="for-image1">Product additional picture (optional)</a>
                                <label for="image1" class="upload">Upload</label>
                            </div>
                            <div id="bar" name="prop">
                            <a id="for-image2">Product additional picture (optional)</a>
                                <label for="image2" class="upload">Upload</label>
                            </div>
                            <div id="bar" name="prop">
                            <a id="for-image3">Product additional picture (optional)</a>
                                <label for="image3" class="upload">Upload</label>
                            </div>
                            
          <input onchange="document.getElementById('for-image').innerHTML ='Main product picture (' + document.getElementById('image').files[0].name+')'; " type="file" hidden id="image" name="image" >
              <input onchange="document.getElementById('for-image1').innerHTML ='Product additional picture (' + document.getElementById('image1').files[0].name+')'; "   id="image1" hidden type="file" name="image1" >
        <input onchange="document.getElementById('for-image2').innerHTML ='Product additional picture (' + document.getElementById('image2').files[0].name+')'; " id="image2"  hidden type="file" name="image2" >
         <input onchange="document.getElementById('for-image3').innerHTML ='Product additional picture (' + document.getElementById('image3').files[0].name+')'; " id="image3"  hidden type="file" name="image3" >

                            
                            
                        </div>
                        
                        <button name="product-btn" id="product-btn" class="insertion">Confirm Insertion</button>
                        
                        <button id="modify3" name="modify3" class="insertion">Confirm Modification</button>
                        <?php
                        if(isset($_POST['modify3'])){
                               
                
                
                      $servername = "localhost";
$username = "root";
$password = "";
$dbname = "ecommerce";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
                            
                            $name = $_POST['product-name'];
                            
                            $initial_price = $_POST['product-initialprice'];
                            $sell_price = $_POST['product-sellprice'];
                            
                        $rt = (double)$_COOKIE['pr_r']; 
             $final_price_initial = round(($initial_price * $rt), 2);
         $final_price_sell = round(($sell_price * $rt), 2);
                            
                $sql = "update product set name='".$name."',brand='".$_POST['product-brand']."',sku='".$_POST['product-sku']."',msg='discount',value='".$_POST['product-discount']."',initial_price='".$final_price_initial."',sell_price='".$final_price_sell."',quantity='".$_POST['product-quantity']."',short_desc='".$_POST['product-shortdesc']."',long_desc='".$_POST['product-longdesc']."',additional_info='".$_POST['product-additional']."',type='".$_POST['product-type']."',mfg='".$_POST['product-mfg']."',life='".$_POST['product-life']."',tags='".$_POST['product-tags']."' where id=".$_POST['product-id'];
                

if ($conn->query($sql) === TRUE)
{
    echo "<script>window.location.href=window.location.href</script>";
}
                $conn->close();
             
                        }
                        ?>
                        <button type="button" onclick="Click('6')" id="modify3_1"  class="modification">Cancel</button>
                        
                        
                        <?php
                        
                        if(isset($_POST['product-btn'])){
                           
                               $name = $_POST['product-name'];
                            $cat_id = trim(explode("-",trim($_POST['category-name2']))[0]);
                            $brand = $_POST['product-brand'];
                            $sku = $_POST['product-sku'];
                            $msg="";
                            $value="";
                            if(!empty($_POST['product-discount'])){
                                $msg = "discount";
                                $value = $_POST['product-discount'];
                            }
                            $initial_price = $_POST['product-initialprice'];
                            $sell_price = $_POST['product-sellprice'];
                            $quantity = $_POST['product-quantity'];
                            
        $short_desc = str_replace("\n","<br>", $_POST['product-shortdesc']);
      $short_desc = str_replace("'","", $short_desc);
      $short_desc = str_replace("\"","", $short_desc);
      $short_desc = str_replace("\\","", $short_desc);        
            
                           
                        $long_desc = str_replace("\n","<br>", $_POST['product-longdesc']);
      $long_desc = str_replace("'","", $long_desc);
      $long_desc = str_replace("\"","", $long_desc);
      $long_desc = str_replace("\\","", $long_desc);
      $additional = str_replace("\n","<br>", $_POST['product-additional']);
      $additional = str_replace("'","", $additional);
      $additional = str_replace("\"","", $additional);
      $additional = str_replace("\\","", $additional);
                            
                            $type = $_POST['product-type'];
                            $mfg = $_POST['product-mfg'];
                            $life = $_POST['product-life'];
                            $tags = $_POST['product-tags'];
                            
            
                            
     if($_FILES['image']['size'] <= 0 ){
      echo "<script>alert('You should choose the main picture of this product!');
      window.location.href=window.location.href</script>";   
         return;
     }
            
                            
                            
                            
                            
                         
                            $servername = "localhost";
$username = "root";
$password = "";
$dbname = "ecommerce";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
                

                            $sql = "select max(id) as 'max' from product ";
                
            $result = $conn->query($sql);       
                 $max=1;
if ($result->num_rows > 0) {
    
$row = $result->fetch_assoc();
if(!empty($row['max'])){
    $max = (int)$row['max'] + 1;        
}
}
                            
                            //echo "<script>alert('".$max."')</script>";
                            
                            
                
                            
                            
 $image=$_FILES['image']['name']; 
                            
                              
     $imageArr=explode('.',$image); //first index is file name and second index file type
     $rand=rand(10000,99999);
     $newImageName="main.jpg";
     $uploadPath="categories/".$cat_id."/".$max."/".$newImageName;
                mkdir("categories/".$cat_id."/".$max, 0700, true);

     $isUploaded=move_uploaded_file($_FILES["image"]["tmp_name"],$uploadPath);
                            
     if($isUploaded)
     {
         $index=1;
         if($_FILES['image1']['size'] > 0 ){
             $image=$_FILES['image1']['name']; 
                            
                              
     $imageArr=explode('.',$image); //first index is file name and second index file type
     $rand=rand(10000,99999);
     $newImageName=$index.".jpg";
     $uploadPath="categories/".$cat_id."/".$max."/".$newImageName;
             
     $isUploaded=move_uploaded_file($_FILES["image1"]["tmp_name"],$uploadPath);
             if($isUploaded){
                 $index++;
             }
 
         }
         
         if($_FILES['image2']['size'] > 0 ){
             $image=$_FILES['image2']['name']; 
                            
                              
     $imageArr=explode('.',$image); //first index is file name and second index file type
     $rand=rand(10000,99999);
     $newImageName=$index.".jpg";
     $uploadPath="categories/".$cat_id."/".$max."/".$newImageName;
                
             
     $isUploaded=move_uploaded_file($_FILES["image2"]["tmp_name"],$uploadPath);
             if($isUploaded){
                 $index++;
             }
 
         }
         
         if($_FILES['image3']['size'] > 0 ){
             $image=$_FILES['image3']['name']; 
                            
                              
     $imageArr=explode('.',$image); //first index is file name and second index file type
     $rand=rand(10000,99999);
     $newImageName=$index.".jpg";
     $uploadPath="categories/".$cat_id."/".$max."/".$newImageName;
                
             
     $isUploaded=move_uploaded_file($_FILES["image3"]["tmp_name"],$uploadPath);
             if($isUploaded){
                 $index++;
             }
 
         }
         
         $rt = (double)$_COOKIE['pr_r']; 
             $final_price_initial = round(($initial_price * $rt), 2);
         $final_price_sell = round(($sell_price * $rt), 2);
         
            $sql = "insert into product (id,name,category_id,brand,sku,msg,value,initial_price,sell_price,quantity,short_desc,long_desc,additional_info,type,mfg,life,tags) values(".$max.",'".$name."',".$cat_id.", '".$brand."','".$sku."','".$msg."','".$value."',".$final_price_initial.", ".$final_price_sell.",".$quantity.",'".$short_desc."','".$long_desc."','".$additional."','".$type."','".$mfg."','".$life."','".$tags."')";
                

         
                
if ($conn->query($sql) === TRUE){
    echo "<script>window.location.href=window.location.href</script>";
}
         else{
         }
                $conn-close();
                

             
     }
     
                
                            
                            
                            
                            
                            
                            
                        //echo "<script>alert('".$cat_id."')</script>";
                        }
                        
                        ?>
                        
                    </div>
                    <div class="section">
                    
                        <div id="main-title">
                            <a>-- List of products --</a>
                        </div>
                        <div id="bar" style="position:relative; ">
<input class="searching" type="search" id="search-products" name="search-products" placeholder="Search for a product by name" />
                            <button type="button" onclick="SEARCH('search-products')" id='srch'>Search</button>
                            
                            
                            </div>
                        <div id="inside" style="margin-top:30px;height:70%">
                       
              
                    
                    <?php
                    
echo "  <table id='products-table' border='0'>
                    <tr>
                    <th style='width:10%;'>Id</th>
                        <th style='width:calc(26%);'>Product name</th>
                        <th style='width:calc(26%);'>Category name</th>
                        <th class='primage' style=''>Image</th>
                        <th></th>
                        <th></th>
                    </tr>";
        
                    
                    
         $servername = "localhost";
$username = "root";
$password = "";
$dbname = "ecommerce";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
                    $how_many_elements = 10;
                $limit = 0;
                            $sql="";
                            if(!isset($_COOKIE['pattern']) || $_COOKIE['pattern']=="-1"){
                    $sql = "select count(*) as 'max' from product";            
                            }
                            else{
                                $sql = "select count(*) as 'max' from product where lower(trim(name)) like '%".$_COOKIE['pattern']."%'";   
                            }
                    
                
            $result = $conn->query($sql);       
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $limit = (ceil($row['max']/$how_many_elements))-1;
}
                    
                        $indice = 0;
            if(isset($_COOKIE['pagination']))
            {
                $indice = explode('-', $_COOKIE['pagination'])[2];
            }
             
        $from = $indice;
                    $to = $indice+$how_many_elements;
                            if(!isset($_COOKIE['pattern']) || $_COOKIE['pattern']=="-1"){
 $sql = "select *, (select name from category where id = product.category_id) as 'cat' from product limit ".((int)$from*(int)$how_many_elements).",".$how_many_elements;                               
                            }
                            else{
                
                echo "<script>document.getElementById('search-products').value='".$_COOKIE['pattern']."'</script>";
                
                                $sql = "select *, (select name from category where id = product.category_id) as 'cat' from product where lower(trim(name)) like '%".$_COOKIE['pattern']."%' limit ".((int)$from*(int)$how_many_elements).",".$how_many_elements; 
                            }
 
                

                            
            $result = $conn->query($sql);       
                            
                            
if ($result->num_rows > 0) {
    
while($row = $result->fetch_assoc()){
    
    $nm = $row['name'];
    if(strlen($nm) > 20)
        $nm = substr($nm, 0, 20) . "...";
    $nm2 = $row['cat'];
    if(strlen($nm2) > 20)
        $nm2 = substr($nm2, 0, 20) . "...";
    
    echo "<tr style='height:50px'>";
    echo "<td>".$row['id']."</td>";
    echo "<td >".$nm."</td>";
    echo "<td >".$nm2."</td>";
    echo "<td ><img src='categories/".$row['category_id']."/".$row['id']."/main.jpg' class='product-img'/></td>";
    echo "<td><div onclick=\"document.getElementById('product-id').value='".$row['id']."';document.getElementById('product-name').value='".$row['name']."';document.getElementById('product-brand').value='".$row['brand']."';document.getElementById('product-sku').value='".$row['sku']."';document.getElementById('product-shortdesc').value='".$row['short_desc']."';document.getElementById('product-longdesc').value='".$row['long_desc']."';document.getElementById('product-additional').value='".$row['additional_info']."';document.getElementById('product-type').value='".$row['type']."';
    
    document.getElementById('product-mfg').value='".$row['mfg']."';
    document.getElementById('product-life').value='".$row['life']."';
    document.getElementById('product-tags').value='".$row['tags']."';
    
    document.getElementsByName('prop')[1].style.display='none';
    document.getElementsByName('prop')[2].style.display='none';
    document.getElementsByName('prop')[3].style.display='none';
    document.getElementsByName('prop')[4].style.display='none';
    document.getElementsByName('prop')[5].style.display='none';
    
    
    document.getElementById('product-btn').style.display='none';document.getElementById('modify3').style.display='block';document.getElementById('modify3_1').style.display='block';Click('5')\" class='modify'><img src='assets/edit.png'/></div></td>";
    echo "<td><div onclick=\"
    
    document.cookie='del=prod-".$row['id']."';
    window.location.href=window.location.href;
    
    \" class='delete'><img src='assets/delete.png'/></div></td>";
    echo "</tr>";
}
}
                    
                    $left = $from-3;
                    if($left<0) $left = 0;
                    $right = ($to);
                    if($right > $limit) $right = $limit;
                    
                    //echo "<script>alert('".$left."')</script>";
                    //echo "<script>alert('".$right."')</script>";
                    //echo "<script>alert('".$limit."')</script>";
                            
                            echo "</table>";
                    
                    echo "<div id='pagination'>";
                    for($i = $left; $i<=$right;$i++) {
                        if($i == $from) echo "<button type='button' onclick=\"PAGINATION('".$i."',2)\"  style='background:royalblue;color:white'>".$i."</button>";    
                    else echo "<button type='button' onclick=\"PAGINATION('".$i."',2)\">".$i."</button>";    
                        
                    }
                    echo "</div>";
                    
                    $conn->close();
                    
                    ?>
                        </div>
                        
                    </div>
                    <div class="section">
                    
                        <div id="main-title">
                            <a>-- Orders --</a>
                        </div>
                        
                    </div>
                    <div class="section">
                    
                        <div id="main-title">
                            <a>-- Privacy --</a>
                        </div>
                        
                        <div id="inside">
                        
                            
                             <div id="bar" onclick="SideBar(2)">
                            <a>Currency</a>
                                <input type="text" id="currency2" name="currency2" readonly />
                            </div>
                            <div id="bar">
                            <a>Email address</a>
                                <input type="email" id="email" name="email"/>
                            </div>
                            <div id="bar">
                            <a>Current password*</a>
                                <input type="password" id="pass1" name="pass1"/>
                            </div>
                            <div id="bar">
                            <a>New password (optional)</a>
                                <input type="password" id="pass2" name="pass2"/>
                            </div>
                            
                        </div>
                        
                        <button name="privacy-btn" class="insertion">Confirm Update</button>
                        
                        <?php
                        
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
  
                        echo "<script>document.getElementById('email').value='".$decryption."'</script>";
                        
    
         if(isset($_POST['privacy-btn'])){
             
             $servername = "localhost";
$username = "root";
$password = "";
$dbname = "ecommerce";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
                $sql = "select * from users where trim(lower(email)) like trim(lower('".$decryption."'))";
                
            $result = $conn->query($sql);       
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $id=$row['id'];
    $pass=$row['pass'];
    $pass1 = $_POST['pass1'];
    $pass2 = $_POST['pass2'];
    
    if($pass1==$pass){
        $sql="";
        if(empty($pass2)){
           $sql="update users set email='".trim($_POST['email'])."' where id=".$id; 
        }
        else{
            $sql="update users set email='".trim($_POST['email'])."',pass='".$pass2."' where id=".$id; 
        }
        if ($conn->query($sql) === TRUE){
            $conn->close();
            $_SESSION['admin']='null';
            echo "<script>window.location.href='dashboard.php'</script>";
        }

        
    }
    else{
        echo "<script>Wrong password!</script>";
    }
                            
}
             $conn->close();
             
         }
                        
                        ?>
                        
                    </div>
                    <div class="section">
                    
                        <div id="main-title">
                            <a>-- Available users --</a>
                        </div>
                        
                    </div>
                    <div class="section">
                    
                        <div id="main-title">
                            <a>-- Newsletter --</a>
                        </div>
                        
                    </div>
                    <div class="section">
                    
                        <div id="main-title">
                            <a>-- Pending Orders --</a>
                        </div>
                        
                         <div id="bar" style="position:relative; ">
<input class="searching" type="search" id="search-orders" name="search-orders" placeholder="Search for an order by code" />
                            <button type="button" onclick="SEARCH('search-orders')" id='srch'>Search</button>
                            
                            
                            </div>
                        <div id="inside" style="margin-top:30px;height:70%">
                       
              
                    
                    <?php
                    
echo "  <table id='orders-table' border='0'>
                    <tr>
                    
                        <th id='us' style=''>User</th>
                        <th id='cd'>Code</th>
                        <th id='dt' style=''>Datetime</th>
                        <th class='prreceived' 
                        <th></th>
                    </tr>";
        
                    
                    
         $servername = "localhost";
$username = "root";
$password = "";
$dbname = "ecommerce";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
                    $how_many_elements = 10;
                $limit = 0;
                            $sql="";
                            if(!isset($_COOKIE['pattern']) || $_COOKIE['pattern']=="-1"){
                    $sql = "select count(*) as 'max' from orders where lower(trim(status)) like 'pending'";            
                            }
                            else{
                                $sql = "select count(*) as 'max' from orders where lower(trim(status)) like 'pending' and lower(trim(order_code)) like '%".$_COOKIE['pattern']."%'";   
                            }
                    
                
            $result = $conn->query($sql);       
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $limit = (ceil($row['max']/$how_many_elements))-1;
    //echo "<script>alert('".($row['max']/$how_many_elements)." ".$limit."')</script>";
}
                    
                        $indice = 0;
            if(isset($_COOKIE['pagination']))
            {
                $indice = explode('-', $_COOKIE['pagination'])[3];
            }
             
        $from = $indice;
                    $to = $indice+$how_many_elements;
                            if(!isset($_COOKIE['pattern']) || $_COOKIE['pattern']=="-1"){
 $sql = "select * from orders where lower(trim(status)) like 'pending' limit ".((int)$from*(int)$how_many_elements).",".$how_many_elements;                               
                            }
                            else{
                
                echo "<script>document.getElementById('search-orders').value='".$_COOKIE['pattern']."'</script>";
                
                                $sql = "select * from orders where lower(trim(status)) like 'pending' and  lower(trim(order_code)) like '%".$_COOKIE['pattern']."%' limit ".((int)$from*(int)$how_many_elements).",".$how_many_elements; 
                            }
 $cr = 'USD';
                            if(isset($_COOKIE['pr_curr']) && $_COOKIE['pr_curr'] != 'null' && !empty($_COOKIE['pr_curr'])){
                                $cr = $_COOKIE["pr_curr"];
                            }
                            if(isset($_COOKIE['pr_r2']) && $_COOKIE['pr_r2'] != 'null' && !empty($_COOKIE['pr_r2']))
                                        $rt2 = $_COOKIE['pr_r2'];
                            else{
                        $req_url = 'https://api.exchangerate-api.com/v4/latest/USD';
      
      $arrContextOptions = array(
      "ssl" => array(
        "verify_peer" => false,
        "verify_peer_name" => false,
      )
);  
  
$context = stream_context_create($arrContextOptions);

                                
                                
$response_json = file_get_contents($req_url,false,$context);

// Continuing if we got a result
if(false !== $response_json) {

    // Try/catch for json_decode operation
    try {

    // Decoding
    $response_object = json_decode($response_json);

        $rt2 = $response_object->rates->$cr;
        echo "<script>
        
        
        
                        document.cookie='pr_r2='+'".$rt2."';
                       
                        </script>";

    }
    catch(Exception $e) {
        // Handle JSON parse error...
    }
}
                            }

                            
            $result = $conn->query($sql);       
                            
                         $i=0;   
if ($result->num_rows > 0) {
    
while($row = $result->fetch_assoc()){
    
     $js = $row['order_string'];
    $ar = explode("}", $js);
    
    
    
    echo "<tr style='height:50px'>";
    echo "<td >".$row['user']."</td>";
    echo "<td >".$row['order_code']."</td>";
    echo "<td id='dt2'>".$row['date_time']."</td>";
    echo "<td><div onclick=\"Expand(".$i.")\" id='details'><img src='assets/eye.png'/></div></td>";
    $i++;
    echo "</tr>";
    echo "<tr><td class='hidden' colspan='4'>
    
    <div id='expansion'>
    <h3>Order(s)</h3>
    ";
    
    
    foreach($ar as $value){
        if(!empty($value)){
            $img = trim(str_replace("{","",explode(";",$value)[0]));
            $name = trim(explode(";",$value)[1]);
            $qn =  trim(explode(";",$value)[3]);
            $total = trim(explode(";",$value)[4]);   
            
            echo "<div id='hor-bar' >
            <div id='pic'>
            <img src='".$img."'/>
            </div>
            <div id='name-pr' style=' font-weight:normal'>".$name."</div>
            <div id='price' style='flex:1; display:flex; font-weight:bold;margin-left:20px'>Quantity(".$qn.")</div>
            
            
            </div>";
            
        }
    }
    
    
    $total = round(($row['total'] * $rt2), 2);
    
    echo "<div id='hor-bar' style='margin-top:40px'>
            <div id='l'>
            <h3>Total</h3>
            </div>
            <div id='r' style='width:60%; font-weight:normal'>".$_COOKIE['pr_curr']." ".$total."</div>
            
            </div>";
    
    echo "<div id='hor-bar' style='margin-top:0px'>
            <div id='l'>
            <h3>Shipping</h3>
            </div>
            <div id='r' style='width:60%; font-weight:normal;'>".$row['shipping']."</div>
            
            </div>";
    
    echo "<div id='hor-bar' style='margin-top:0px'>
            <div id='l'>
            <h3>Client's name</h3>
            </div>
            <div id='r' style='width:60%; font-weight:normal;'>".$row['firstname']." ".$row['lastname']."</div>
            </div>";
    
    echo "<div id='hor-bar' style='margin-top:0px'>
            <div id='l'>
            <h3>Company</h3>
            </div>
            <div id='r' style='width:60%; font-weight:normal;'>".$row['company']."</div>
            </div>";
    
    echo "<div id='hor-bar' style='margin-top:0px'>
            <div id='l'>
            <h3>Country</h3>
            </div>
            <div id='r' style='width:60%; font-weight:normal;'>".$row['country']."</div>
            </div>";
    
    echo "<div id='hor-bar' style='margin-top:0px'>
            <div id='l'>
            <h3>Address</h3>
            </div>
            <div id='r' style='width:60%; font-weight:normal;'>".$row['street1']."</div>
            </div>";
    echo "<div id='hor-bar' style='margin-top:0px'>
            <div id='l'>
            <h3>Address (additional)</h3>
            </div>
            <div id='r' style='width:60%; font-weight:normal;'>".$row['street2']."</div>
            </div>";
    
    echo "<div id='hor-bar' style='margin-top:0px'>
            <div id='l'>
            <h3>City</h3>
            </div>
            <div id='r' style='width:60%; font-weight:normal;'>".$row['city']."</div>
            </div>";
    
    echo "<div id='hor-bar' style='margin-top:0px'>
            <div id='l'>
            <h3>Zip code</h3>
            </div>
            <div id='r' style='width:60%; font-weight:normal;'>".$row['zipcode']."</div>
            </div>";
    
    echo "<div id='hor-bar' style='margin-top:0px'>
            <div id='l'>
            <h3>Email</h3>
            </div>
            <div id='r' style='width:60%; font-weight:normal;'>".$row['email']."</div>
            </div>";
    echo "<div id='hor-bar' style='margin-top:0px'>
            <div id='l'>
            <h3>Date</h3>
            </div>
            <div id='r' style='width:60%; font-weight:normal;'>".$row['date_time']."</div>
            </div>";
    
    echo "<button class='rc' type='button' onclick=\"
    document.cookie='id=".$row['id']."';
    window.location.href=window.location.href;
    \">Move to Received</button>";
    
    
    echo "</div>
    </td></tr>";
}
}
                    
                    $left = $from-3;
                    if($left<0) $left = 0;
                    $right = ($to);
                    if($right > $limit) $right = $limit;
                    
                    //echo "<script>alert('".$left."')</script>";
                    //echo "<script>alert('".$right."')</script>";
                    //echo "<script>alert('".$limit."')</script>";
                            
                            echo "</table>";
                    
                    echo "<div id='pagination'>";
                    for($i = $left; $i<=$right;$i++) {
                        if($i == $from) echo "<button type='button' onclick=\"PAGINATION('".$i."',3)\"  style='background:royalblue;color:white'>".$i."</button>";    
                    else echo "<button type='button' onclick=\"PAGINATION('".$i."',3)\">".$i."</button>";    
                        
                    }
                    echo "</div>";
                    
                    $conn->close();
                    
                    ?>
                        </div>
                        
                        
                    </div>
                    <div class="section">
                    
                        <div id="main-title">
                            <a>-- Received Orders --</a>
                        </div>
                        
                        
                         <div id="bar" style="position:relative; ">
<input class="searching" type="search" id="search-orders-received" name="search-orders-received" placeholder="Search for an order by code" />
                            <button type="button" onclick="SEARCH('search-orders-received')" id='srch'>Search</button>
                            
                            
                            </div>
                        <div id="inside" style="margin-top:30px;height:70%">
                       
              
                    
                    <?php
                    
echo "  <table id='orders-table' border='0'>
                    <tr>
                    
                        <th id='us' style=''>User</th>
                        <th id='cd'>Code</th>
                        <th id='dt' style=''>Datetime</th>
                        <th class='prreceived' 
                        <th></th>
                    </tr>";
        
                    
                    
         $servername = "localhost";
$username = "root";
$password = "";
$dbname = "ecommerce";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
                    $how_many_elements = 10;
                $limit = 0;
                            $sql="";
                            if(!isset($_COOKIE['pattern']) || $_COOKIE['pattern']=="-1"){
                    $sql = "select count(*) as 'max' from orders where lower(trim(status)) like 'received'";            
                            }
                            else{
                                $sql = "select count(*) as 'max' from orders where lower(trim(status)) like 'received' and lower(trim(order_code)) like '%".$_COOKIE['pattern']."%'";   
                            }
                    
                
            $result = $conn->query($sql);       
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $limit = (ceil($row['max']/$how_many_elements))-1;
    //echo "<script>alert('".($row['max']/$how_many_elements)." ".$limit."')</script>";
}
                    
                        $indice = 0;
            if(isset($_COOKIE['pagination']))
            {
                $indice = explode('-', $_COOKIE['pagination'])[3];
            }
             
        $from = $indice;
                    $to = $indice+$how_many_elements;
                            if(!isset($_COOKIE['pattern']) || $_COOKIE['pattern']=="-1"){
 $sql = "select * from orders where lower(trim(status)) like 'received' limit ".((int)$from*(int)$how_many_elements).",".$how_many_elements;                               
                            }
                            else{
                
                echo "<script>document.getElementById('search-orders-received').value='".$_COOKIE['pattern']."'</script>";
                
                                $sql = "select * from orders where lower(trim(status)) like 'received' and  lower(trim(order_code)) like '%".$_COOKIE['pattern']."%' limit ".((int)$from*(int)$how_many_elements).",".$how_many_elements; 
                            }
 $cr = 'USD';
                            if(isset($_COOKIE['pr_curr']) && $_COOKIE['pr_curr'] != 'null' && !empty($_COOKIE['pr_curr'])){
                                $cr = $_COOKIE["pr_curr"];
                            }
                            if(isset($_COOKIE['pr_r2']) && $_COOKIE['pr_r2'] != 'null' && !empty($_COOKIE['pr_r2']))
                                        $rt2 = $_COOKIE['pr_r2'];
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

        $rt2 = $response_object->rates->$cr;
        echo "<script>
        
        
        
                        document.cookie='pr_r2='+'".$rt2."';
                       
                        </script>";

    }
    catch(Exception $e) {
        // Handle JSON parse error...
    }
}
                            }

                            
            $result = $conn->query($sql);       
                            
                         $i=0;   
if ($result->num_rows > 0) {
    
while($row = $result->fetch_assoc()){
    
     $js = $row['order_string'];
    $ar = explode("}", $js);
    
    
    
    echo "<tr style='height:50px'>";
    echo "<td>".$row['user']."</td>";
    echo "<td >".$row['order_code']."</td>";
    echo "<td id='dt2'>".$row['date_time']."</td>";
    echo "<td><div onclick=\"Expand2(".$i.")\" id='details'><img src='assets/eye.png'/></div></td>";
    $i++;
    echo "</tr>";
    echo "<tr><td class='hidden2' colspan='4'>
    
    <div id='expansion'>
    <h3>Order(s)</h3>
    ";
    
    
    foreach($ar as $value){
        if(!empty($value)){
            $img = trim(str_replace("{","",explode(";",$value)[0]));
            $name = trim(explode(";",$value)[1]);
            $qn =  trim(explode(";",$value)[3]);
            $total = trim(explode(";",$value)[4]);   
            
            echo "<div id='hor-bar' >
            <div id='pic'>
            <img src='".$img."'/>
            </div>
            <div id='name-pr' style=' font-weight:normal'>".$name."</div>
            <div id='price' style='flex:1; display:flex; font-weight:bold;margin-left:20px'>Quantity(".$qn.")</div>
            
            
            </div>";
            
        }
    }
    
    
    $total = round(($row['total'] * $rt2), 2);
    
    echo "<div id='hor-bar' style='margin-top:40px'>
            <div id='l'>
            <h3>Total</h3>
            </div>
            <div id='r' style='width:60%; font-weight:normal'>".$_COOKIE['pr_curr']." ".$total."</div>
            
            </div>";
    
    echo "<div id='hor-bar' style='margin-top:0px'>
            <div id='l'>
            <h3>Shipping</h3>
            </div>
            <div id='r' style='width:60%; font-weight:normal;'>".$row['shipping']."</div>
            
            </div>";
    
    echo "<div id='hor-bar' style='margin-top:0px'>
            <div id='l'>
            <h3>Client's name</h3>
            </div>
            <div id='r' style='width:60%; font-weight:normal;'>".$row['firstname']." ".$row['lastname']."</div>
            </div>";
    
    echo "<div id='hor-bar' style='margin-top:0px'>
            <div id='l'>
            <h3>Company</h3>
            </div>
            <div id='r' style='width:60%; font-weight:normal;'>".$row['company']."</div>
            </div>";
    
    echo "<div id='hor-bar' style='margin-top:0px'>
            <div id='l'>
            <h3>Country</h3>
            </div>
            <div id='r' style='width:60%; font-weight:normal;'>".$row['country']."</div>
            </div>";
    
    echo "<div id='hor-bar' style='margin-top:0px'>
            <div id='l'>
            <h3>Address</h3>
            </div>
            <div id='r' style='width:60%; font-weight:normal;'>".$row['street1']."</div>
            </div>";
    echo "<div id='hor-bar' style='margin-top:0px'>
            <div id='l'>
            <h3>Address (additional)</h3>
            </div>
            <div id='r' style='width:60%; font-weight:normal;'>".$row['street2']."</div>
            </div>";
    
    echo "<div id='hor-bar' style='margin-top:0px'>
            <div id='l'>
            <h3>City</h3>
            </div>
            <div id='r' style='width:60%; font-weight:normal;'>".$row['city']."</div>
            </div>";
    
    echo "<div id='hor-bar' style='margin-top:0px'>
            <div id='l'>
            <h3>Zip code</h3>
            </div>
            <div id='r' style='width:60%; font-weight:normal;'>".$row['zipcode']."</div>
            </div>";
    
    echo "<div id='hor-bar' style='margin-top:0px'>
            <div id='l'>
            <h3>Email</h3>
            </div>
            <div id='r' style='width:60%; font-weight:normal;'>".$row['email']."</div>
            </div>";
    echo "<div id='hor-bar' style='margin-top:0px'>
            <div id='l'>
            <h3>Date</h3>
            </div>
            <div id='r' style='width:60%; font-weight:normal;'>".$row['date_time']."</div>
            </div>";
    
    
    
    echo "</div>
    </td></tr>";
}
}
                    
                    $left = $from-3;
                    if($left<0) $left = 0;
                    $right = ($to);
                    if($right > $limit) $right = $limit;
                    
                    //echo "<script>alert('".$left."')</script>";
                    //echo "<script>alert('".$right."')</script>";
                    //echo "<script>alert('".$limit."')</script>";
                            
                            echo "</table>";
                    
                    echo "<div id='pagination'>";
                    for($i = $left; $i<=$right;$i++) {
                        if($i == $from) echo "<button type='button' onclick=\"PAGINATION('".$i."',3)\"  style='background:royalblue;color:white'>".$i."</button>";    
                    else echo "<button type='button' onclick=\"PAGINATION('".$i."',3)\">".$i."</button>";    
                        
                    }
                    echo "</div>";
                    
                    $conn->close();
                    
                    ?>
                        </div>
                        
                        
                    </div>
                    <div class="section">
                    
                        <div id="main-title">
                            <a>-- Cancelled Orders --</a>
                        </div>
                        
                    </div>
                    
                    
                    </div>
                </div>
            </div>
            </div>
            </div>
            
            <div id="side-bar">
            <div id="side-bar-inner">
              
              <div class="list">
                
                  
                  
                </div>
                <div class="list">
                
                  
                  
                </div>
                
                <div class="list">
                
                   <div id='bar' onclick="document.getElementById('currency2').value='MAD'; CloseSideBar();setTimeout(function(){document.getElementById('change-currency').click();},500);"><a>Moroccan MAD</a></div>
                    <div id='bar' onclick="document.getElementById('currency2').value='USD'; CloseSideBar();setTimeout(function(){document.getElementById('change-currency').click();},500);"><a>American USD</a></div>
                    
                    <button hidden id="change-currency" name="change-currency"></button>
                    <?php
                    if(isset($_POST['change-currency'])){
                        $cr = $_POST['currency2'];
                        
                        $rt = 1;
                        $req_url = 'https://api.exchangerate-api.com/v4/latest/'.$cr;
      
          $arrContextOptions = array("ssl" => array(         "verify_peer" => false,         "verify_peer_name" => false,       ) );      $context = stream_context_create($arrContextOptions);

$response_json = file_get_contents($req_url,false,$context);

// Continuing if we got a result
if(false !== $response_json) {

    // Try/catch for json_decode operation
    try {

    // Decoding
    $response_object = json_decode($response_json);

        $rt = $response_object->rates->USD;
    

    }
    catch(Exception $e) {
        // Handle JSON parse error...
    }
}
                        
                         $rt2 = 1;
                        $req_url = 'https://api.exchangerate-api.com/v4/latest/USD';
      
          $arrContextOptions = array("ssl" => array(         "verify_peer" => false,         "verify_peer_name" => false,       ) );      $context = stream_context_create($arrContextOptions);

$response_json = file_get_contents($req_url,false,$context);

// Continuing if we got a result
if(false !== $response_json) {

    // Try/catch for json_decode operation
    try {

    // Decoding
    $response_object = json_decode($response_json);

        $rt2 = $response_object->rates->$cr;
    

    }
    catch(Exception $e) {
        // Handle JSON parse error...
    }
}
           
             

                        
                        
                        echo "<script>
                        document.cookie='pr_curr='+'".$cr."';
                        
                        document.cookie='pr_r='+'".$rt."';
                        document.cookie='pr_r2='+'".$rt2."';
                        window.location.href=window.location.href;
                        </script>";
                        
                    }
                    ?>
                  
                </div>

                <img id="close-sidebar" onclick="CloseSideBar()" src="assets/close.png"/>
                </div>
            </div>
            
                  <div id="notifs">
        <div id="center-full">
            <div id="centered" style="">
              
              <?php
                
                
                 $servername = "localhost";
$username = "root";
$password = "";
$dbname = "ecommerce";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
                $sql = "select * from orders where trim(lower(status)) like 'pending' order by date_time";
                
            $result = $conn->query($sql);       
if ($result->num_rows > 0) {
    echo "<script>
    document.getElementById('my-notif').src='assets/notif-on.png';
    </script>";
    while($row=$result->fetch_assoc()){
        
        $email = $row['email'];
        if(empty($email))
            $email = $row['user'];
    echo "<div class='notif-bar'  >
    <div id='inner'>
    
    <a>'<strong>".$email."</strong>' has ordered at 
    '<strong>".$row['date_time']."</strong>'</a>
    
    </div>
    </div>";    
    }
    
    
}
                
                
                
                
                ?>
               
                
                 <img id="close-popup" onclick="ClosePopup('notifs', 'centered')" src="assets/close.png"/>
            </div>
            </div>
           
        </div>
        <div id="loader">
        <img class="logo" src="assets/load.gif"/>
        </div>
            <script>
                
                var right = document.querySelector("#container #bottom #right");
                
                
                
                var inputs = document.getElementsByTagName("input");
                for(var i = 0;i<inputs.length;i++){
                    if(inputs[i].placeholder.trim().length>0 && inputs[i].placeholder.toLowerCase().indexOf('search')!=-1){
                    SRCHKEY(inputs[i]);
                        
                    }
                    else{
                    PRVKEY(inputs[i]);
                    }
                }
                function SRCHKEY(input){
                    input.onkeypress=function(event){
                        if(event.key=="Enter"){
                    if(input.id!="search-department" && input.id!="search-category" ){
                        SEARCH(input.id);
                    }
                            event.preventDefault();
                        }
                    };
                }
                function PRVKEY(input){
                    input.onkeypress=function(event){
                        if(event.key=="Enter"){
                            event.preventDefault();
                        }
                    };
                }
                
                function PAGINATION(i, index){
                    var str= "0-0-0-0-0";
                    var tm = document.cookie;
                    if(tm.indexOf('pagination=')!=-1)
                        {
                            str = tm.substring(tm.indexOf('pagination=')+11);
                            str = str.substring(0,str.indexOf(';'));
                        }
                    if(index==0){
                        //department
                    str = str.substring(str.indexOf('-')+1);
                    str = i+"-"+str;
                    }
                    else if(index==1){
                        //category
                        //0-0-0
                    str = str.substring(str.indexOf('-')+1);
                        str = str.substring(str.indexOf('-')+1);
                    str = "0-"+i+"-"+str;
                    }
                    else if(index==2){
                        //product
                        //0-0
                    str = str.substring(str.indexOf('-')+1);
                        str = str.substring(str.indexOf('-')+1);
                        str = str.substring(str.indexOf('-')+1);
                    str = "0-0-"+i+"-"+str;
                    }
                    else if(index==3){
                        //product
                        //0
                    str = str.substring(str.indexOf('-')+1);
                        str = str.substring(str.indexOf('-')+1);
                        str = str.substring(str.indexOf('-')+1);
                        str = str.substring(str.indexOf('-')+1);
                    str = "0-0-0-"+i+"-"+str;
                    }
                    document.cookie="pagination="+str;
                    window.location.href=window.location.href;
                }
                
                function SEARCH(id){
                    var txt = document.getElementById(id).value;
                    
                    document.cookie="pagination=0-0-0-0-0"; document.cookie="pattern="+txt.toLowerCase();
                    setTimeout(function(){
                        window.location.href=window.location.href;
                    }, 100);
                }
                
                function SRCH(table, textbox,index){
                    var department_tds;
                    department_tds = document.getElementById(table).getElementsByTagName('tr');
                    var tr;
                    var name;
                    var btnIndex1=2;
                    var btnIndex2=3;
                    if(index==0){
                        btnIndex1=2;
                        btnIndex2=3;
                    }
                    else if(index==1){
                        btnIndex1=3;
                        btnIndex2=4;
                    }
                    else if(index==2){
                        btnIndex1=4;
                        btnIndex2=5;
                    }
                    var btn1, btn2;
                    var query = document.getElementById(textbox).value;
                    
                    if(query.trim().length==0){
                        
                    
                    for(var i =1; i<department_tds.length; i++){
                        tr = department_tds[i];
                        
                        if(index==2){
                            tr.getElementsByTagName('td')[3].getElementsByTagName('img')[0].style.height="30px";
                        }
                        
                        name = tr.getElementsByTagName('td')[1].innerHTML;
                       
                           btn1 = tr.getElementsByTagName('td')[btnIndex1].getElementsByTagName('div')[0];
                           btn2 = tr.getElementsByTagName('td')[btnIndex2].getElementsByTagName('div')[0];
                           
                           btn1.style.height="35px";
                           btn2.style.height="35px";
                           
                           tr.style.fontSize="14px";
                           tr.style.height="50px";
                        tr.style.visibility="visible";    
                        
                         
                    }
                        return;
                    }
                    
                    for(var i =1; i<department_tds.length; i++){
                        tr = department_tds[i];
                        name = tr.getElementsByTagName('td')[1].innerHTML;
                        btn1 = tr.getElementsByTagName('td')[btnIndex1].getElementsByTagName('div')[0];
                           btn2 = tr.getElementsByTagName('td')[btnIndex2].getElementsByTagName('div')[0];
                        if(name.toUpperCase().indexOf(query.toUpperCase())==-1){
                            if(index==2){
                            tr.getElementsByTagName('td')[3].getElementsByTagName('img')[0].style.height="0px";
                        }
                          
                           
                           btn1.style.height="0px";
                           btn2.style.height="0px";
                           
                           tr.style.fontSize="0px";
                           tr.style.height="0px";
                           tr.style.visibility="hidden";
                            
                        }
                        else {
                            
                            if(index==2){
                            tr.getElementsByTagName('td')[3].getElementsByTagName('img')[0].style.height="30px";
                        }
                             btn1.style.height="35px";
                           btn2.style.height="35px";
                            
                            tr.style.fontSize="14px";
                           tr.style.height="50px";
                            tr.style.visibility="visible";
                        }
                    }
                    
                    
                }
                function SetCookie(c,r){
                        document.cookie="pr_curr=USD";
                        document.cookie="pr_r=1";
                    window.location.href=window.location.href;
                }
                function SetCookie2(c,r){
                    document.getElementById('currency').value=c;
                    document.getElementById('currency2').value=c;
                }
            function FillDep(id, name){
                var html = "<div id='bar' onclick=\"document.getElementById('department-name2').value='"+id+" - "+name+"'; CloseSideBar()\"><a>"+id+" - "+name+"</a></div>";
                document.getElementsByClassName('list')[0].innerHTML+=html;
            }
            </script>
    
        <script>
            function CloseSideBar(){
                var side_bar = document.getElementById('side-bar');
                var side_bar_inner = document.getElementById('side-bar-inner');
                setTimeout(function(){
                    side_bar_inner.style.left="100%";
                    side_bar_inner.style.opacity="0";
                    setTimeout(function(){
                        side_bar.style.opacity="0";
                        setTimeout(function(){
                            side_bar.style.display="none";
                        }, 500);
                    }, 500);
                }, 100);
            }
            function SideBar(n){
                for(var i =0;i<document.getElementsByClassName('list').length;i++){
                    document.getElementsByClassName('list')[i].style.display='none';
                }
                document.getElementsByClassName('list')[n].style.display='block';
                var side_bar = document.getElementById('side-bar');
                var side_bar_inner = document.getElementById('side-bar-inner');
                side_bar.style.display="block";
                setTimeout(function(){
                    side_bar.style.opacity="1";
                    setTimeout(function(){
                    side_bar_inner.style.opacity="1";
                        side_bar_inner.style.left="calc(100% - 300px)";
                }, 300);
                }, 100);
            }
            var sections = document.getElementsByClassName('section');
            
            if(localStorage.getItem('sections')==null ||
              localStorage.getItem('sections').trim().length==0){
                sections[0].style.display="block";
                localStorage.setItem('sections','0');
            }
            else{
                    var n = Number(localStorage.getItem('sections'));
                sections[n].style.display="block";
            }
            var ar_hiddens = [];
            var ar_hiddens2 = [];
            var hiddens = document.getElementsByClassName('hidden');
            var hiddens2 = document.getElementsByClassName('hidden2');
            for(var i=0;i<hiddens.length;i++){
                HideTd(hiddens[i], i);
            }
            for(var i=0;i<hiddens2.length;i++){
                HideTd2(hiddens2[i], i);
            }
            
            function HideTd(el,i){
                var h = el.offsetHeight;
                ar_hiddens.push(h);
                el.getElementsByTagName('div')[0].style.opacity="0";
                el.getElementsByTagName('div')[0].style.height="0px";
                el.getElementsByTagName('div')[0].style.paddingTop="0px";
                el.getElementsByTagName('div')[0].style.paddingBottom="0px";
                el.style.height="0px";
            }
            function HideTd2(el,i){
                var h = el.offsetHeight;
                ar_hiddens2.push(h);
                el.getElementsByTagName('div')[0].style.opacity="0";
                el.getElementsByTagName('div')[0].style.height="0px";
                el.getElementsByTagName('div')[0].style.paddingTop="0px";
                el.getElementsByTagName('div')[0].style.paddingBottom="0px";
                el.style.height="0px";
            }
            
            function Expand(i){
                if(hiddens[i].offsetHeight<20){
                hiddens[i].style.height=ar_hiddens[i]+"px";
                hiddens[i].getElementsByTagName('div')[0].style.opacity="1";
                hiddens[i].getElementsByTagName('div')[0].style.paddingTop="30px";
                hiddens[i].getElementsByTagName('div')[0].style.paddingBottom="30px";
                hiddens[i].getElementsByTagName('div')[0].style.height=ar_hiddens[i]+"px";
                }
                else{
                    hiddens[i].style.height="0px";
                hiddens[i].getElementsByTagName('div')[0].style.opacity="0";
                hiddens[i].getElementsByTagName('div')[0].style.paddingTop="0px";
                hiddens[i].getElementsByTagName('div')[0].style.paddingBottom="0px";
                hiddens[i].getElementsByTagName('div')[0].style.height="0px";
                }
            }
            function Expand2(i){
                if(hiddens2[i].offsetHeight<20){
                hiddens2[i].style.height=ar_hiddens2[i]+"px";
                hiddens2[i].getElementsByTagName('div')[0].style.opacity="1";
                hiddens2[i].getElementsByTagName('div')[0].style.paddingTop="30px";
                hiddens2[i].getElementsByTagName('div')[0].style.paddingBottom="30px";
                hiddens2[i].getElementsByTagName('div')[0].style.height=ar_hiddens2[i]+"px";
                }
                else{
                    hiddens2[i].style.height="0px";
                hiddens2[i].getElementsByTagName('div')[0].style.opacity="0";
                hiddens2[i].getElementsByTagName('div')[0].style.paddingTop="0px";
                hiddens2[i].getElementsByTagName('div')[0].style.paddingBottom="0px";
                hiddens2[i].getElementsByTagName('div')[0].style.height="0px";
                }
            }
            window.addEventListener('load', function(){
                if(Number(window.innerWidth) <= 800)
                right.scrollIntoView();
            }, false);
            function Click(n){
                if(Number(window.innerWidth) <= 800)
                right.scrollIntoView();
                for(var i = 0; i<sections.length;i++)
                    sections[i].style.display="none";
                localStorage.setItem('sections',n+"");
                if(n==2 || n ==4 || n == 6 || n==11 ||n==12||n==13){
                    document.cookie='pagination=0-0-0-0-0';
                   document.cookie='pattern=-1'; window.location.href=window.location.href;
                }
                else sections[Number(n)].style.display="block";
            }
            
            function DISCONNECT(){
                 document.getElementById('loader').style.display="flex";       document.getElementById('loader').style.opacity="1";
                setTimeout(function(){
                    document.getElementById("btn1").click();
                }, 1000);
                
            }
            
            function OpenPopup(id, id2){
    var popup = document.getElementById(id);
    var popup_inner1 = document.getElementById(id2);
    popup.style.display = "flex";
    setTimeout(function(){
        popup.style.opacity = "1";
        setTimeout(function(){
            popup_inner1.style.opacity="1";
            popup_inner1.style.top="0px";
        }, 250);
    }, 100);
}
function ClosePopup(id, id2){
    var popup = document.getElementById(id);
    var popup_inner1 = document.getElementById(id2);
    popup_inner1.style.opacity="0";
            popup_inner1.style.top="50px";        
    setTimeout(function(){
            popup.style.opacity="0";
        setTimeout(function(){
            popup.style.display = "none";
        }, 500);
        }, 250);
}
            
         function LOADER(){
        
         document.getElementById('loader').style.display="flex";
                setTimeout(function(){
                    document.getElementById('loader').style.opacity="1";
                    setTimeout(function(){
                        document.getElementById('loader').style.opacity="0";
                        setTimeout(function(){
                        document.getElementById('loader').style.display="none";
                            document.getElementById('wrapper').style.opacity="1";
                            document.getElementById('wrapper').style.transition="0.5s";
                            
                        
                    }, 100);
                    }, 1000);
                }, 1000);
    }
            var wrapper = document.getElementById("wrapper");
            var menu = document.querySelector("#container #bottom #left");
            var topbar = document.getElementsByClassName("topbar")[0];
var width;
function Init(){
    let screenWidth = window.screen.width;
let isMobile = screenWidth <= 480;
let details = navigator.userAgent;

let regexp = /android|iphone|kindle|ipad/i;

let isMobileDevice = regexp.test(details);

if (isMobileDevice && isMobile) {
    //alert("You are using a Mobile Device");
    width = window.innerWidth | document.documentElement.clientWidth | document.body.clientWidth;
    if(width > screen.width)
        width = screen.width;
    wrapper.style.width = width + "px";
} else if (isMobile) {
    //alert("You are using Desktop on Mobile"); // the most interesting
    width = 800;
    document.body.style.overflowX="auto";
    wrapper.style.width = "100%";
} else {
   //alert("You are using Desktop");
   width = window.innerWidth | document.documentElement.clientWidth | document.body.clientWidth;
    if(width > screen.width)
        width = screen.width;
    wrapper.style.width = width + "px";

}
    var n = Number(wrapper.offsetHeight) - 51;
    menu.style.height=n+"px";    
    
    
}
Init();
window.addEventListener("resize", function(args){
    if(window.innerWidth>800){
        document.querySelector('#container #top').scrollIntoView();
    }
    else right.scrollIntoView();
    Init();
}, true);
            var ar = [];
            
    var items = document.getElementsByClassName("item");
            for(var i = 0; i<items.length; i++){
                if(localStorage.getItem('ar')==null || 
              localStorage.getItem('ar').trim().length==0)
                {
                    ar.push(false);
                    Do(items[i], i, false);
                }
                else{
                    var cs = localStorage.getItem('ar').trim().split('\n')[i].trim();
                    if(cs === "true")
                    {
                        ar.push(true);
                        Do(items[i], i, true);
                    }
                    else {
                        ar.push(false);
                        Do(items[i], i, false);
                         }
                }
            }
            function Do(item, i, open){
                var h = item.offsetHeight;
                if(open) item.style.height=h+'px';
                else item.style.height='50px';
               if(item.getElementsByTagName('div').length>1){
                   item.getElementsByTagName('div')[0].onclick=function(){
                       if(ar[i] == false){
                           ar[i] = true;
                           item.style.height=h+'px';
                       }
                       else{
                           ar[i] = false;
                           item.style.height='50px';
                       }
                       var str ="";
                for(var j = 0; j<ar.length; j++)
                    str+=ar[j]+"\n";
                localStorage.setItem('ar',str.trim()); 
                   };
               }
            }
            if(localStorage.getItem('ar')==null || 
              localStorage.getItem('ar').trim().length==0){
                var str ="";
                for(var i = 0; i<ar.length; i++)
                    str+=ar[i]+"\n";
                localStorage.setItem('ar',str.trim()); 
            }
            
            function FillCat(id, name){
                var html = "<div id='bar' onclick=\"document.getElementById('category-name2').value='"+id+" - "+name+"'; CloseSideBar()\"><a>"+id+" - "+name+"</a></div>";
                document.getElementsByClassName('list')[1].innerHTML+=html;
            }
        </script>
            
            <?php
            
           function FillCats(){
                          
      $servername = "localhost";
$username = "root";
$password = "";
$dbname = "ecommerce";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
                $sql = "select * from category";
                
            $result = $conn->query($sql);       
                 $max=0;
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()){
        $id = $row['id'];
        $name = $row['name'];
        echo "<script>
        
                  FillCat('".$id."','".$name."');
        
        </script>";
    }
    
}
                          $sql = "select * from category_group";
                
            $result = $conn->query($sql);       
                 $max=0;
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()){
        $id = $row['id'];
        $name = $row['name'];
        echo "<script>
        
                  FillDep('".$id."','".$name."');
        
        </script>";

    }
    
}
               
                $conn->close();
               
            }
            
            
            
           
            
            
            
            FillCats();
            
            
            ?>
    
            
            
            <?php
            
            
             function FillFields(){
             
                 
      $servername = "localhost";
$username = "root";
$password = "";
$dbname = "ecommerce";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
                $sql = "select count(id) as 'max' from category_group ";
                
            $result = $conn->query($sql);       
                 $max=0;
if ($result->num_rows > 0) {
    
$row = $result->fetch_assoc();
if(!empty($row['max'])){
    $max = (int)$row['max'] + 1;        
}
}
                 $maxD=$max;
                                $sql = "select count(id) as 'max' from category ";
                
            $result = $conn->query($sql);       
                 $max=0;
if ($result->num_rows > 0) {
    
$row = $result->fetch_assoc();
if(!empty($row['max'])){
    $max = (int)$row['max'] + 1;        
}
}
                 $maxC=$max;
            $sql = "select count(id) as 'max' from product ";
                
            $result = $conn->query($sql);       
                 $max=0;
if ($result->num_rows > 0) {
    
$row = $result->fetch_assoc();
if(!empty($row['max'])){
    $max = (int)$row['max'] + 1;        
}
}
                 $maxP=$max;
                 
                 
                 $sql = "select count(id) as 'max' from orders where trim(lower(status)) like 'pending' ";
                
            $result = $conn->query($sql);       
                 $max=0;
if ($result->num_rows > 0) {
    
$row = $result->fetch_assoc();
if(!empty($row['max'])){
    $max = (int)$row['max'] + 1;        
}
}
                 $maxOP=$max;
                 
                 
                 
                 $sql = "select count(id) as 'max' from orders where trim(lower(status)) like 'received' ";
                
            $result = $conn->query($sql);       
                 $max=0;
if ($result->num_rows > 0) {
    
$row = $result->fetch_assoc();
if(!empty($row['max'])){
    $max = (int)$row['max'] + 1;        
}
}
                 $maxOR=$max;
                 
                 
                 
                 $sql = "select count(id) as 'max' from users";
                
            $result = $conn->query($sql);       
                 $max=0;
if ($result->num_rows > 0) {
    
$row = $result->fetch_assoc();
if(!empty($row['max'])){
    $max = (int)$row['max'] + 1;        
}
}
                 $maxU=$max;
                 
                 
            
             echo "<script>
                
                  window.addEventListener('load', function(){
                document.getElementById('department-id').value='".$maxD."';
                var n = ".($maxD-1).";
                if(Number(n)<0)
                document.getElementById('dep-txt').innerHTML='Departments (0)';
                else document.getElementById('dep-txt').innerHTML='Departments (".($maxD-1).")';
                
                document.getElementById('category-id').value='".$maxC."';  
                 n = ".($maxC-1).";
                if(Number(n)<0)
                document.getElementById('cat-txt').innerHTML='Categories (0)';
                else document.getElementById('cat-txt').innerHTML='Categories (".($maxC-1).")';
                
                document.getElementById('product-id').value='".$maxP."';  
                n = ".($maxP-1).";
                if(Number(n)<0)
                document.getElementById('prod-txt').innerHTML='Products (0)';
                else document.getElementById('prod-txt').innerHTML='Products (".($maxP-1).")';
                
                n = ".($maxOP-1).";
                if(Number(n)<0)
                document.getElementById('pending-txt').innerHTML='Pending orders (0)';
                else document.getElementById('pending-txt').innerHTML='Pending orders (".($maxOP-1).")';
                
                n = ".($maxOR-1).";
                if(Number(n)<0)
                document.getElementById('received-txt').innerHTML='Received orders (0)';
                else document.getElementById('received-txt').innerHTML='Received orders (".($maxOR-1).")';
                
                n = ".($maxU-1).";
                if(Number(n)<0)
                document.getElementById('users-txt').innerHTML='Users (0)';
                else document.getElementById('users-txt').innerHTML='Users (".($maxU-1).")';
                
                
                
                
                
                LOADER();
                
                }, false);
                </script>";  
                 
                 $conn->close();
             }
            
            ?>
            
            
            
            <?php
            
            function DEP($id){
                
                   $servername = "localhost";
$username = "root";
$password = "";
$dbname = "ecommerce";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
                $sql = "select id  from category where category_group_id=".$id;
                
            $result = $conn->query($sql);       
                $array = array();
if ($result->num_rows > 0) {
    

while($row = $result->fetch_assoc()){
    
    $array[] = $row['id'];
    
    
}
}
                $sql = "delete  from category_group where id=".$id;
                
            $conn->query($sql);    
    $conn->close();
    $dep = $id;
    for($i=0;$i<count($array);$i++){
        $cat = $array[$i];
        //echo "<script>alert('".$cat."')</script>";
        CAT($cat);
        
    }
                
                
                
       
    
    

                
            }
            
            function CAT($id){
               
                
                        $servername = "localhost";
$username = "root";
$password = "";
$dbname = "ecommerce";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
                $sql = "select *  from product where category_id=".$id;
                
            $result = $conn->query($sql);       
                $array = array();
if ($result->num_rows > 0) {
    

while($row = $result->fetch_assoc()){
    
    $array[] = $row['id'];
    
    
}
}
                $sql = "delete  from category where id=".$id;
                
            $conn->query($sql);    
    $conn->close();
    for($i=0;$i<count($array);$i++){
        PROD($array[$i]);
        $main = "categories/".$id."/".$array[$i]."/main.jpg";
       
      
        if(file_exists("categories/".$id."/".$array[$i]."/main.jpg")){
            unlink("categories/".$id."/".$array[$i]."/main.jpg");
        }
                if(file_exists("categories/".$id."/".$array[$i]."/1.jpg")){
            unlink("categories/".$id."/".$array[$i]."/1.jpg");
        }
                if(file_exists("categories/".$id."/".$array[$i]."/2.jpg")){
            unlink("categories/".$id."/".$array[$i]."/2.jpg");
        }
                if(file_exists("categories/".$id."/".$array[$i]."/3.jpg")){
            unlink("categories/".$id."/".$array[$i]."/3.jpg");
        }
        if(is_dir("categories/".$id."/".$array[$i]))
        rmdir("categories/".$id."/".$array[$i]);
        
    }
                
                if(is_dir("categories/".$id))
                rmdir("categories/".$id);
                
            }
            
            function PROD($id){
                
                        $servername = "localhost";
$username = "root";
$password = "";
$dbname = "ecommerce";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
                $sql = "delete  from product where id=".$id;
                
            $conn->query($sql);       
 
    $conn->close();
            }
            
            
            function PROD2($id){
                $id0=$id;
                        $servername = "localhost";
$username = "root";
$password = "";
$dbname = "ecommerce";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
                 $sql = "select *  from product where id=".$id0;
                
            $result = $conn->query($sql);       
            $row = $result->fetch_assoc();
                
       
                $array = array();
                $array[] = $row['id'];
                $i=0;
                $id=$row['category_id'];
        if(file_exists("categories/".$id."/".$array[$i]."/main.jpg")){
            unlink("categories/".$id."/".$array[$i]."/main.jpg");
        }
                if(file_exists("categories/".$id."/".$array[$i]."/1.jpg")){
            unlink("categories/".$id."/".$array[$i]."/1.jpg");
        }
                if(file_exists("categories/".$id."/".$array[$i]."/2.jpg")){
            unlink("categories/".$id."/".$array[$i]."/2.jpg");
        }
                if(file_exists("categories/".$id."/".$array[$i]."/3.jpg")){
            unlink("categories/".$id."/".$array[$i]."/3.jpg");
        }
                 if(is_dir("categories/".$id."/".$array[$i]))
        rmdir("categories/".$id."/".$array[$i]);
                
                
                $sql = "delete  from product where id=".$id0;
                
            $conn->query($sql);       
 
    $conn->close();
            }
            
            ?>
            
        </form>
    </body>
</html>