var wrapper = document.getElementById("wrapper");
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
    
}
Init();
window.addEventListener("resize", function(args){
    Init();
}, true);
function OpenPopup(id, id2, id3){
    var popup = document.getElementById(id);
    var popup_inner1 = document.getElementById(id2);
    var popup_inner2 = document.getElementById(id3);
    popup.style.display = "flex";
    setTimeout(function(){
        popup.style.opacity = "1";
        setTimeout(function(){
            popup_inner1.style.opacity="1";
            popup_inner1.style.top="0px";
            setTimeout(function(){
            popup_inner2.style.opacity="1";
            popup_inner2.style.top="0px";
        }, 250);
        }, 250);
    }, 100);
}
function ClosePopup(id, id2, id3){
    var popup = document.getElementById(id);
    var popup_inner1 = document.getElementById(id2);
    var popup_inner2 = document.getElementById(id3);
    popup_inner2.style.opacity="0";
    popup_inner2.style.top="50px";
    setTimeout(function(){
            popup_inner1.style.opacity="0";
            popup_inner1.style.top="50px";        
        setTimeout(function(){
            popup.style.opacity="0";
            setTimeout(function(){
            popup.style.display = "none";
            
        }, 500);
        }, 350);
        }, 250);
        
    popup_inner2.style.top="50px";
    
}
function OpenMenu(){
    var menu_bar = document.getElementById('menu-bar');
    var menu_inner = document.getElementById('menu-inner');
     menu_bar.style.display = "flex";
    setTimeout(function(){
        menu_bar.style.opacity = "1";
     setTimeout(function(){
         menu_inner.style.left="0px";
     }, 500);
    }, 100);
}
function CloseMenu(){
    var menu_bar = document.getElementById('menu-bar');
    var menu_inner = document.getElementById('menu-inner');
    setTimeout(function(){
        menu_inner.style.left="-80%";
        setTimeout(function(){
        menu_bar.style.opacity = "0";
        setTimeout(function(){
        menu_bar.style.display = "none";
    }, 500);
    }, 500);
    }, 100);
}

    var items = document.getElementsByClassName("item");
var ar = [];
for(var i = 0; i < items.length; i++){
    var item = items[i];
    ar.push(false);
    Do(item, i);
}
function Do(item, i){
    var h = item.offsetHeight;
    
    item.style.height="50px";
    if(item.getElementsByTagName("div").length > 1){
    item.getElementsByTagName("div")[0].onclick = function(){
        
        if(ar[i] == false){
         ar[i] = true;
            if(Number(h)==0) item.style.height="auto";
            else item.style.height=h+"px";
        }
        else{
            ar[i] = false;
            item.style.height="50px";
        }
    };
    }
}
document.getElementById("menu-bar").style.display="none";
document.getElementById("cats").style.display="none";
document.getElementById("all-cats").style.display="none";

var shown = false;
function ShowCats(){
    if(shown==false){
     shown = true;
        document.getElementById("cats").style.display="block";
    }
    else{
     shown = false;
        document.getElementById("cats").style.display="none";
    }
}
var shown2 = false;
function ShowCats2(){
    if(shown2==false){
     shown2 = true;
        document.getElementById("all-cats").style.display="block";
        document.getElementById("all-cats").style.opacity="1";
    }
    else{
     shown2 = false;
        document.getElementById("all-cats").style.display="none";
        document.getElementById("all-cats").style.opacity="0";
    }
}
var bgs = document.getElementsByClassName("carousel");
for(var i = 1; i < bgs.length; i++){
    bgs[i].style.opacity="0";
}
var from = 0;
setTimeout(f, 1000);
function f(){
    bgs[from].style.opacity="1";
    bgs[from].style.transition="1s";
    for(var i = 0; i < bgs.length; i++){
        if(i!=from){
        bgs[i].style.opacity="0";
        }
        bgs[i].style.transition="1s";
    }
    from++;
    if(from == bgs.length) from = 0;
    setTimeout(f, 4000);
}
var ids = [];
var titles = [];
ids.push("desc-tab");
ids.push("info-tab");
titles.push("title1");
titles.push("title2");
function ShowTab(id, title){
    
    for(var i =0; i<ids.length; i++)
    document.getElementById(ids[i]).style.display="none";    
    
    for(var i =0; i<titles.length; i++)
    document.getElementById(titles[i]).style.color="#999";
    
    document.getElementById(id).style.display="block";
    document.getElementById(title).style.color="#333";
}
ShowTab('desc-tab', 'title1');
