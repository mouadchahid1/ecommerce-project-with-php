<html>
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <style>
        #success{
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }
        #success a{
            font-size: 20px;
            color: #555;
            text-align: center;
            width: 40%;
        }
        #success strong{
            font-size: 25px;
            color: tomato;
        }
        #success img{
            width: 30%;
            height: auto;
            margin-bottom: -50px;
        }
        *{
            font-family: sans-serif;
        }
         
        @media only screen and  (max-width:1000px){
          #success a{
            font-size: 16px;
            }
            #success strong{
            font-size: 20px;
            }
            #success img{
            width: 30%;
            height: auto;
            margin-bottom: -20px;
        }
        }
        @media only screen and  (max-width:600px){
            #success img{
            width: 60%;
            height: auto;
        }
        }
        @media only screen and  (max-width:480px){
            #success a{
                width: 80%;
                font-size: 14px;
            }
            #success strong{
                font-size: 18px;
            }
            #success img{
                margin-bottom: 0px;
            }
        }
        .rembtn{
    border-radius: 50px;
    margin-bottom: 10px;
    padding: 10px;
    padding-left: 20px;
    padding-right: 20px;
    border: none;
    background: tomato;
    color: white;
        outline: none;
        cursor: pointer;
        }
    </style>
    </head>
    <body>
    <div id="success">
        <img src="assets/success.gif"/>
        <a>Your <strong>Order</strong> code is <strong><?php echo $_COOKIE['order']; 
            echo "<script>document.cookie='order=null';</script>";
            ?></strong>, please keep it!</a>
        <button class="rembtn" style="margin:0; margin-top:20px" onclick="Do()">Go to home</button>
        </div>
        <script>
            function Do(){
                document.cookie="fcookie=null";
                localStorage.removeItem("count");
                        for(var i =0; i<=Number(localStorage.getItem("count"));i++){
                            localStorage.removeItem("product"+i);
                        }
        setTimeout(function(){
            window.location.href='index.php';
        }, 100);
            }
        </script>
    </body>
</html>