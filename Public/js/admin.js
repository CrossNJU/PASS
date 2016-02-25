/**
 * Created by danni on 2016/2/22.
 */
$(document).ready(function(){
    $('.up').click(function() {
        //alert("in");
        $(this).siblings('.test').children('.test-1').toggle();
    });
});

$(document).ready(function(){
    $('#btn-add-stu').click(function(){
        window.location.href="student_add";

    })
})

$(document).ready(function(){
    $('#btn-add-cou').click(function(){
        window.location.href="course_add";

    })
})

$(document).ready(function(){
    $('#btn-add-tea').click(function(){
        window.location.href="teacher_add";

    })
})