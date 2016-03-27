/**
 * Created by Lenovo on 2016/2/25.
 */
$(document).ready(function(){
    $(document).on("click",".admin-remove-btn",function(){
        var btn = $(this);
        var id = btn.attr("data-id");
        showDialog("确定删除该教师？");
        $(".confirm-btn").click(function () {
            jQuery.ajax({
                async: false,
                data: "teacher_id="+id,
                //url:"teacher_del",
                url:rootUrl+"/Administer/teacher_del",
                type: "post",
                success: function(msg){
                    if(msg == -1){
                        showStateBar("danger","教师删除失败");
                    }else if(msg == 1){
                        showStateBar("success","教师删除成功");
                        btn.parent(".homework").slideUp(function(){
                            btn.parents(".homework").remove();
                        })
                    }
                },
                error: function(){
                    showStateBar("danger","教师删除失败");
                }
            });
        });
    });
});

function show(){
    var $p1 = $("#msg").val();
    var $p2 = $("#type").val();
    if ($p1!=""){
        showStateBar($p2,$p1);
    }
}
