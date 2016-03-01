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

})
