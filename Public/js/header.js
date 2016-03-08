/**
 * Created by Lenovo on 2016/3/3.
 */
function setCookie(name,value){
    var argv = setCookie.arguments;
    var argc = setCookie.arguments.length;        
    var expires = (argc>2)?argv[2]:null;         
    var path=(argc>3)?argv[3]:null;         
    var domain = (argc>4)?argv[4]:null;         
    var secure = (argc>5)?argv[5]:false;
    //利用所获取的参数设置cookie，并将cookies的名称和值用escape函数编码         
    // document.cookie=name+"="+escape(value)+";expires=Thursday, 10-Dec-11 12:00:00 GMT"             
    +((path==null)?"":(";path="+path))+((domain==null)?"":(";domain="+domain))             
    +((secure==true)?";secure":"");     
}

function sub1(){
    setCookie("userCookies",document.getElementById("user").value)
    return true
}


function getCookie(Name){         
    var search = Name+'=';
    if(document.cookie.length>0){//如果存在本文档的cookies             
        offset = document.cookie.indexOf(search);             
        if(offset != -1){ 
        offset += search.length; //设置索引开始位置 
        end = document.cookie.indexOf(';',offset); //设置索引结束位置                 
        if(end == -1) 
        end = document.cookie.length;
        return unescape(document.cookie.substring(offset,end));             
        }             
        else
        return null;
    }
}
alert(getCookie("userCookies"))  //用getCookie函数取值     </script>

