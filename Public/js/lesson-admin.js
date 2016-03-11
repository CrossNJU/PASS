/**
 * Created by Lenovo on 2016/2/25.
 */
$(document).ready(function(){
    $(document).on("click",".admin-remove-btn",function(){
        var btn = $(this);
        console.log($(this));
        var id = btn.attr("data-id");

        jQuery.ajax({
            async: false,
            data: "course_id="+id,
            url:"course_del",
            type: "post",
            success: function(msg){
                if(msg == -1){
                    showStateBar("danger","课程删除失败");
                }else if(msg == 1){
                    showStateBar("success","课程删除成功");
                    btn.parent(".homework").slideUp(function(){
                        btn.parents(".homework").remove();
                    })
                }
            },
            error: function(){
                showStateBar("danger","课程删除失败");
            },
        });
    });


    $(document).on("click",".download-hwk",function(){
        var asid = $(this).parent().next().text();
        //alert(asid);

        console.log($(this));

        jQuery.ajax({
            async: false,
            data: "assignment_id="+asid,
            url:"download",
            type: "post",
            success: function(msg){
                alert(msg);
                //this.attr("herf","_ROOT__/index.php/Home/" + msg);
                //window.location.herf = msg;
                window.location.href = "http://localhost/PASS/" + msg;


            },
            error: function(){
                showStateBar("danger","批量下载失败");
            }
        });
    });

})






