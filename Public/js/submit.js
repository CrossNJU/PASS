/**
 * Created by Lenovo on 2016/3/20.
 */

function validate(type) {
    var errorStr = "你上传的文件格式应为";
    var name = $(".file_text").val();
    var submittedType =  name.substring(name.lastIndexOf(".")+1).toLowerCase();

    switch(type) {
        case 'pdf':
            errorStr = errorStr + "PDF文件";
            if(submittedType != 'pdf') {
                showStateBar('danger',errorStr);
                return false;
            }
            break;
        case 'word':
            errorStr = errorStr + "WORD/PPT文件";
            if(submittedType != 'doc' && submittedType != 'docx' && submittedType != 'ppt' && submittedType != 'pptx') {
                showStateBar('danger',errorStr);
                return false;
            }
            break;
        case 'mp4':
            errorStr = errorStr + "MP4文件";
            if(submittedType != 'mp4') {
                showStateBar('danger',errorStr);
                return false;
            }
            break;
    }


}