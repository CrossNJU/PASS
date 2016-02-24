/**
 * Created by danni on 2016/2/22.
 */
$(document).ready(function(){
    $('.up').click(function() {
        //alert("in");
        $(this).siblings('.test').children('.test-1').toggle();
    });
});