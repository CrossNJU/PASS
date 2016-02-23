/**
 * Created by Lenovo on 2016/2/16.
 */
$(document).ready(function() {

    $(".delete-btn").click(function() {
        var hwid = $(this).attr("data-hwid");
        var btn = $(this);
        jQuery.ajax({
            async:false,
            url:"assignment_delete",
            data:"assignment_id="+hwid,
            dataType:"json",
            success:function (msg){
                if(msg == "delete success!"){
                    btn.parent(".card-info").slideUp(function(){
                        btn.parent(".card-info").remove();
                    });
                    showStateBar("success","作业删除成功");
                }else {
                    showStateBar("danger","作业删除失败");
                }
            },
        });


    });
});