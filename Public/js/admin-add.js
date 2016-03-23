/**
 * Created by Lenovo on 2016/2/24.
 */

function redirec(x){

    //alert("ininin");

    var te = document.getElementById("stu_grade");
    te.className += " testyryty";


    var select_aca_len = document.aca_spe_form.aca.options.length;
    var select_spe = new Array(select_aca_len);

    for(i = 0;i < select_aca_len;i++){
        select_spe[i] = new Array();
    }
    select_spe[0][0] = new Option("请选择专业","请选择专业");
    //select_spe[0][0].addClass("preselect");
    //alert(select_spe[0][0].className);

    //s1.className = +"preselect";
    select_spe[1][0] = new Option("请选择专业","请选择专业");

    select_spe[1][1] = new Option("汉语言文学","汉语言文学");
    select_spe[1][2] = new Option("汉语言文学（作家班）","汉语言文学（作家班）");
    select_spe[1][3] = new Option("戏剧影视文学","戏剧影视文学");
    select_spe[1][4] = new Option("中文基地","中文基地");

    select_spe[2][0] = new Option("请选择专业","请选择专业");
    select_spe[2][1] = new Option("历史学","历史学");
    select_spe[2][2] = new Option("考古学","考古学");
    select_spe[2][3] = new Option("考古学（文物鉴定）","考古学（文物鉴定）");
    select_spe[2][4] = new Option("历史基地","历史基地");

    select_spe[3][0] = new Option("请选择专业","请选择专业");
    select_spe[3][1] = new Option("法学","法学");
    select_spe[3][2] = new Option("法学（第二学位）","法学（第二学位）");
    select_spe[3][3] = new Option("法学（运动员班）","法学（运动员班）");

    select_spe[4][0] = new Option("请选择专业","请选择专业");
    select_spe[4][1] = new Option("哲学","哲学");
    select_spe[4][2] = new Option("哲学基地","哲学基地");

    select_spe[5][0] = new Option("请选择专业","请选择专业");
    select_spe[5][1] = new Option("新闻学","新闻学");
    select_spe[5][2] = new Option("广告学","广告学");
    select_spe[5][3] = new Option("广播电视新闻学","广播电视新闻学");
    select_spe[5][4] = new Option("新闻学（记者班）","新闻学（记者班）");
    select_spe[5][5] = new Option("新闻学（运动员班）","新闻学（运动员班）");
    select_spe[5][6] = new Option("广播电视学","广播电视学");
    select_spe[5][7] = new Option("新闻学（传媒实验班）","新闻学（传媒实验班）");

    select_spe[6][0] = new Option("请选择专业","请选择专业");
    select_spe[6][1] = new Option("政治学与行政学","政治学与行政学");
    select_spe[6][2] = new Option("行政管理","行政管理");
    select_spe[6][3] = new Option("国际政治","国际政治");
    select_spe[6][4] = new Option("政治学","政治学");
    select_spe[6][5] = new Option("行政管理（劳动与社会保障方向）","行政管理（劳动与社会保障方向）");
    select_spe[6][6] = new Option("教育技术学","教育技术学");
    select_spe[6][7] = new Option("劳动与社会保障","劳动与社会保障");
    select_spe[6][8] = new Option("行政管理（运动员班）","行政管理（运动员班）");
    select_spe[6][9] = new Option("行政管理（新疆班）","行政管理（新疆班）");
    select_spe[6][10] = new Option("政治学类","政治学类");

    select_spe[7][0] = new Option("请选择专业","请选择专业");
    select_spe[7][1] = new Option("信息管理与信息系统","信息管理与信息系统");
    select_spe[7][2] = new Option("图书馆学","图书馆学");
    select_spe[7][3] = new Option("档案学","档案学");
    select_spe[7][4] = new Option("编辑出版学","编辑出版学");
    select_spe[7][5] = new Option("理科类","理科类");
    select_spe[7][6] = new Option("档案学（第二学士学位）","档案学（第二学士学位）");

    select_spe[8][0] = new Option("请选择专业","请选择专业");
    select_spe[8][1] = new Option("社会学","社会学");
    select_spe[8][2] = new Option("社会工作","社会工作");
    select_spe[8][3] = new Option("应用心理学","应用心理学");

    select_spe[9][0] = new Option("请选择专业","请选择专业");
    select_spe[9][1] = new Option("经济学","经济学");
    select_spe[9][2] = new Option("国际经济与贸易","国际经济与贸易");
    select_spe[9][3] = new Option("工商管理","工商管理");
    select_spe[9][4] = new Option("会计学","会计学");
    select_spe[9][5] = new Option("财务管理","财务管理");
    select_spe[9][6] = new Option("金融学","金融学");
    select_spe[9][7] = new Option("电子商务","电子商务");
    select_spe[9][8] = new Option("市场营销","市场营销");
    select_spe[9][9] = new Option("工商管理类","工商管理类");
    select_spe[9][10] = new Option("工商管理（二学位）","工商管理（二学位）");
    select_spe[9][11] = new Option("国际经济与贸易（二学位）","国际经济与贸易（二学位）");
    select_spe[9][12] = new Option("工商管理（人力资源管理方向）","工商管理（人力资源管理方向）");
    select_spe[9][13] = new Option("保险","保险");
    select_spe[9][14] = new Option("金融工程","金融工程");
    select_spe[9][15] = new Option("经济学（产业经济方向）","经济学（产业经济方向）");

    select_spe[10][0] = new Option("请选择专业","请选择专业");
    select_spe[10][1] = new Option("英语","英语");
    select_spe[10][2] = new Option("俄语","俄语");
    select_spe[10][3] = new Option("日语","日语");
    select_spe[10][4] = new Option("法语","法语");
    select_spe[10][5] = new Option("德语","德语");
    select_spe[10][6] = new Option("西班牙语","西班牙语");
    select_spe[10][7] = new Option("英语（国际商务方向）","英语（国际商务方向）");
    select_spe[10][8] = new Option("应用英语强化班","应用英语强化班");
    select_spe[10][9] = new Option("朝鲜语","朝鲜语");

    select_spe[11][0] = new Option("请选择专业","请选择专业");
    select_spe[11][1] = new Option("数学与应用数学","数学与应用数学");
    select_spe[11][2] = new Option("信息与计算科学","信息与计算科学");
    select_spe[11][3] = new Option("统计学","统计学");
    select_spe[11][4] = new Option("应用模块","应用模块");
    select_spe[11][5] = new Option("数学（英才计划）","数学（英才计划）");

    select_spe[12][0] = new Option("请选择专业","请选择专业");
    select_spe[12][1] = new Option("物理学","物理学");
    select_spe[12][2] = new Option("应用物理学","应用物理学");
    select_spe[12][3] = new Option("声学","声学");
    select_spe[12][4] = new Option("物理基地","物理基地");
    select_spe[12][5] = new Option("物理学（英才计划）","物理学（英才计划）");

    select_spe[13][0] = new Option("请选择专业","请选择专业");
    select_spe[13][1] = new Option("化学","化学");
    select_spe[13][2] = new Option("应用化学","应用化学");
    select_spe[13][3] = new Option("化学（基地）","化学（基地）");
    select_spe[13][4] = new Option("化学（英才计划）","化学（英才计划）");

    select_spe[14][0] = new Option("请选择专业","请选择专业");
    select_spe[14][1] = new Option("生物技术","生物技术");
    select_spe[14][2] = new Option("生物科学","生物科学");
    select_spe[14][3] = new Option("生态学","生态学");
    select_spe[14][4] = new Option("生物技术（与药科大学联办）","生物技术（与药科大学联办）");
    select_spe[14][5] = new Option("生物科学（基地）","生物科学（基地）");
    select_spe[14][6] = new Option("生物科学（英才计划）","生物科学（英才计划）");

    select_spe[15][0] = new Option("请选择专业","请选择专业");
    select_spe[15][1] = new Option("地质学","地质学");
    select_spe[15][2] = new Option("地球化学","地球化学");
    select_spe[15][3] = new Option("地质工程","地质工程");
    select_spe[15][4] = new Option("水文与水资源工程","水文与水资源工程");
    select_spe[15][5] = new Option("信息资源与计算机管理","信息资源与计算机管理");
    select_spe[15][6] = new Option("矿物岩石矿床","矿物岩石矿床");
    select_spe[15][7] = new Option("地质学（古生物学方向）","地质学（古生物学方向）");
    select_spe[15][8] = new Option("地下水科学与工程","地下水科学与工程");
    select_spe[15][9] = new Option("数字媒体技术","数字媒体技术");
    select_spe[15][10] = new Option("地科基地","地科基地");
    select_spe[15][11] = new Option("地质学（地球物理学方向）","地质学（地球物理学方向）");

    select_spe[16][0] = new Option("请选择专业","请选择专业");
    select_spe[16][1] = new Option("资源环境与城乡规划管理","资源环境与城乡规划管理");
    select_spe[16][2] = new Option("地理信息系统","地理信息系统");
    select_spe[16][3] = new Option("城市规划","城市规划");
    select_spe[16][4] = new Option("地理科学","地理科学");
    select_spe[16][5] = new Option("城市与资源学","城市与资源学");
    select_spe[16][6] = new Option("旅游管理","旅游管理");
    select_spe[16][7] = new Option("海洋科学","海洋科学");
    select_spe[16][8] = new Option("地理信息科学","地理信息科学");
    select_spe[16][9] = new Option("自然地理与资源环境","自然地理与资源环境");
    select_spe[16][10] = new Option("地理基地","地理基地");
    select_spe[16][11] = new Option("海洋基地","海洋基地");

    select_spe[17][0] = new Option("请选择专业","请选择专业");
    select_spe[17][1] = new Option("大气科学","大气科学");
    select_spe[17][2] = new Option("应用气象学","应用气象学");
    select_spe[17][3] = new Option("大气科学（基地）","大气科学（基地）");
    select_spe[17][4] = new Option("应用气象学（基地）","应用气象学（基地）");

    select_spe[18][0] = new Option("请选择专业","请选择专业");
    select_spe[18][1] = new Option("电子信息科学与技术","电子信息科学与技术");
    select_spe[18][2] = new Option("声学","声学");
    select_spe[18][3] = new Option("通信工程","通信工程");
    select_spe[18][4] = new Option("生物医学工程","生物医学工程");
    select_spe[18][5] = new Option("微电子学","微电子学");
    select_spe[18][6] = new Option("微电子科学与工程","微电子科学与工程");

    select_spe[19][0] = new Option("请选择专业","请选择专业");
    select_spe[19][1] = new Option("材料物理","材料物理");
    select_spe[19][2] = new Option("材料化学","材料化学");
    select_spe[19][3] = new Option("光电信息科学与工程","光电信息科学与工程");
    select_spe[19][4] = new Option("新能源科学与工程","新能源科学与工程");
    select_spe[19][5] = new Option("生物医学工程","生物医学工程");
    select_spe[19][6] = new Option("光电信息工程","光电信息工程");

    select_spe[20][0] = new Option("请选择专业","请选择专业");
    select_spe[20][1] = new Option("环境工程","环境工程");
    select_spe[20][2] = new Option("环境科学","环境科学");
    select_spe[20][3] = new Option("环境科学（环化）","环境科学（环化）");
    select_spe[20][4] = new Option("环境科学（环生）","环境科学（环生）");
    select_spe[20][5] = new Option("环境科学（环规）","环境科学（环规）");

    select_spe[21][0] = new Option("请选择专业","请选择专业");
    select_spe[21][1] = new Option("天文学","天文学");
    select_spe[21][2] = new Option("空间科学与技术","空间科学与技术");
    select_spe[21][3] = new Option("天文基地","天文基地");
    select_spe[21][4] = new Option("天文学（英才计划）","天文学（英才计划）");

    select_spe[22][0] = new Option("请选择专业","请选择专业");
    select_spe[22][1] = new Option("计算机科学与技术","计算机科学与技术");
    select_spe[22][2] = new Option("计算机科学与技术（英才计划）","计算机科学与技术（英才计划）");

    select_spe[23][0] = new Option("请选择专业","请选择专业");
    select_spe[23][1] = new Option("医学类（5+3）","医学类（5+3）");
    select_spe[23][2] = new Option("临床医学","临床医学");
    select_spe[23][3] = new Option("临床医学（5+3）","临床医学（5+3）");
    select_spe[23][4] = new Option("临床医学（八年制）","临床医学（八年制）");
    select_spe[23][5] = new Option("口腔医学","口腔医学");
    select_spe[23][6] = new Option("口腔医学（5+3）","口腔医学（5+3）");
    select_spe[23][7] = new Option("临床医学（军总）","临床医学（军总）");
    select_spe[23][8] = new Option("基础医学","基础医学");

    select_spe[24][0] = new Option("请选择专业","请选择专业");
    select_spe[24][1] = new Option("理科强化班","理科强化班");
    select_spe[24][2] = new Option("理强（数理方向）","理强（数理方向）");
    select_spe[24][3] = new Option("理强（生物化学）","理强（生物化学）");
    select_spe[24][4] = new Option("英才计划（物理班）","英才计划（物理班）");
    select_spe[24][5] = new Option("英才计划(天文)","英才计划(天文)");
    select_spe[24][6] = new Option("理强(大气基地)","理强(大气基地)");
    select_spe[24][7] = new Option("英才计划(化学班)","英才计划(化学班)");
    select_spe[24][8] = new Option("英才计划(生命科学班)","英才计划(生命科学班)");
    select_spe[24][9] = new Option("理强(地科基地)","理强(地科基地)");
    select_spe[24][10] = new Option("理强(地理基地)","理强(地理基地)");
    select_spe[24][11] = new Option("理强(海洋基地)","理强(海洋基地)");
    select_spe[24][12] = new Option("理强(建筑基地)","理强(建筑基地)");
    select_spe[24][13] = new Option("理强(教育基地)","理强(教育基地)");
    select_spe[24][14] = new Option("理强(中文基地)","理强(中文基地)");
    select_spe[24][15] = new Option("理强(历史基地)","理强(历史基地)");
    select_spe[24][16] = new Option("理强(哲学基地)","理强(哲学基地)");
    select_spe[24][17] = new Option("英才计划(大理科班)","英才计划(大理科班)");
    select_spe[24][18] = new Option("英才计划(计算机班)","英才计划(计算机班)");
    select_spe[24][19] = new Option("英才计划(数学班)","英才计划(数学班)");
    select_spe[24][20] = new Option("文强(经济学)","文强(经济学)");
    select_spe[24][21] = new Option("文强(金融学)","文强(金融学)");
    select_spe[24][22] = new Option("文强(国际经济与贸易)","文强(国际经济与贸易)");
    select_spe[24][23] = new Option("文强(工商管理)","文强(工商管理)");
    select_spe[24][24] = new Option("文强(会计学)","文强(会计学)");
    select_spe[24][25] = new Option("文强(电子商务)","文强(电子商务)");
    select_spe[24][26] = new Option("文强(新闻学)","文强(新闻学)");
    select_spe[24][27] = new Option("文强(法学)","文强(法学)");
    select_spe[24][28] = new Option("文强(广告学)","文强(广告学)");
    select_spe[24][29] = new Option("文强(广播电视)","文强(广播电视)");
    select_spe[24][30] = new Option("文强(财务管理)","文强(财务管理)");
    select_spe[24][31] = new Option("文强(社会学)","文强(社会学)");
    select_spe[24][32] = new Option("文强(心理学)","文强(心理学)");
    select_spe[24][33] = new Option("文强(汉语言文学)","文强(汉语言文学)");
    select_spe[24][34] = new Option("文强(金融工程)","文强(金融工程)");
    select_spe[24][35] = new Option("理强(统计学)","理强(统计学)");
    select_spe[24][36] = new Option("理强(生物物理)","理强(生物物理)");
    select_spe[24][37] = new Option("理强(物理)","理强(物理)");
    select_spe[24][38] = new Option("理强(化学)","理强(化学)");
    select_spe[24][39] = new Option("理强(数学与应用数学)","理强(数学与应用数学)");
    select_spe[24][40] = new Option("理强(天文学)","理强(天文学)");
    select_spe[24][41] = new Option("理强(计算机科学)","理强(计算机科学)");
    select_spe[24][42] = new Option("理强(信息与计算科学)","理强(信息与计算科学)");
    select_spe[24][43] = new Option("理强(生物学)","理强(生物学)");

    select_spe[25][0] = new Option("请选择专业","请选择专业");
    select_spe[25][1] = new Option("软件工程","软件工程");

    select_spe[26][0] = new Option("教育技术学类","教育技术学类");

    select_spe[27][0] = new Option("请选择专业","请选择专业");
    select_spe[27][1] = new Option("自动化","自动化");
    select_spe[27][2] = new Option("工业工程","工业工程");
    select_spe[27][3] = new Option("金融工程","金融工程");
    select_spe[27][4] = new Option("信息工程","信息工程");
    select_spe[27][5] = new Option("工业工程类","工业工程类");
    select_spe[27][6] = new Option("自动化类","自动化类");
    select_spe[27][7] = new Option("电气信息类","电气信息类");

    select_spe[28][0] = new Option("请选择专业","请选择专业");
    select_spe[28][1] = new Option("对外汉语","对外汉语");
    select_spe[28][2] = new Option("汉语言","汉语言");
    select_spe[28][3] = new Option("汉语国际教育","汉语国际教育");

    select_spe[29][0] = new Option("请选择专业","请选择专业");
    select_spe[29][1] = new Option("城市规划","城市规划");
    select_spe[29][2] = new Option("城乡规划","城乡规划");
    select_spe[29][3] = new Option("建筑基地","建筑基地");

    var temp = document.aca_spe_form.spe;
    //$("#search").find("option").remove();
    temp.options.length=0;

    for(i = 0;i < select_spe[x].length;i++){
            temp.options[i] = new Option(select_spe[x][i].text,
                select_spe[x][i].value);
            temp.options[0].selected = true;

        }
    temp.options[0].className = "preselect";
}




