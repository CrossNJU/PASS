/**
 * Created by Lenovo on 2016/2/17.
 */
function showStateBar(type,text){
    var barType = "respond-"+type;
    $("body").prepend("<div class='toast' style='top:-80px;'> <div class='respond "+barType+"'><p class='respond-text'>"+text+"</p></div></div>");
    $(".toast").animate({
        top: "+=80px",
    });
    $(".toast").delay(1500);
    $(".toast").animate({
        top: "-=80px"
    },function(){
        $(".toast").remove();
    })
}