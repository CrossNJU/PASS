/**
 * Created by Lenovo on 2016/2/25.
 */
$(document).ready(function(){
    $(document).on("click",".admin-remove-btn",function(){
        var btn = $(this);
        var id = btn.attr("data-id");
        showDialog("确定删除该课程？");
        $(".confirm-btn").click(function(){
            jQuery.ajax({
                async: false,
                data: "course_id="+id,
                url:"/PASS/Administer/course_del",
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
    });


    $(document).on("click",".download-hwk",function(){
        var asid = $(this).parent().next().text();
        console.log($(this));

        jQuery.ajax({
            async: false,
            data: "assignment_id="+asid,
            url:"download",
            type: "post",
            success: function(msg){
                if (msg == 'wrong'){
                    showStateBar("warning","暂无作业");
                }else window.location.href = "http://localhost/PASS/" + msg;
            },
            error: function(){
                showStateBar("danger","批量下载失败");
            }
        });
    });

})






