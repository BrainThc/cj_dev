//获取url中的参数
function getUrlParam(name,def_val) {
    if(typeof(def_val) == 'undefined'){
        def_val = '';
    }
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)"); //构造一个含有目标参数的正则表达式对象
    var r = window.location.search.substr(1).match(reg);  //匹配目标参数
    if (r != null) return unescape(r[2]); return def_val; //返回参数值
}

// JSON转URL参数
function parseParams(data, encode = true) {
    if(typeof(data) === 'string') {
        data = JSON.parse(data)
    }
    try {
        var tempArr = [];
        for (var i in data) {
            if(encode === true){
                var key = encodeURIComponent(i);
                var value = encodeURIComponent(data[i]);
            }else{
                var key = i;
                var value = data[i];
            }
            tempArr.push(key + '=' + value);
        }
        var urlParamsStr = tempArr.join('&');
        return urlParamsStr;
    } catch (err) {
        return '';
    }
}

//树状结构多维数组转一维数组
function setTreeGrid(cate_list){
    var nbsp = '';
    var tree = '';
    for( var i = 0; i < cate_list.length; i++ ){
        tree = '';
        nbsp = '';
        if( cate_list[i].pNum > 0 ){
            tree += '├';
            for( var t = 0; t < cate_list[i].pNum; t++ ){
                // nbsp += '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                tree += '──';
            }
            cate_list[i].name = nbsp+tree+cate_list[i].name;
        }
    }
    return cate_list;
}

//树状结构多维数组转一维数组
function setTreeList(cate_list,child,pNum,returnList){
    if( typeof(pNum) == 'undefined' ){
        pNum = 0;
    }
    if( typeof(returnList) == 'undefined' ){
        returnList = new Array();
    }
    for( var keys in cate_list ){
        cate_list[keys]['pNum'] = pNum;
        console.log(cate_list[keys]);
        returnList.push(cate_list[keys]);
        if( typeof(cate_list[keys][child]) != 'undefined' && cate_list[keys][child].length > 0 ){
            returnList = setTreeList(cate_list[keys][child],child,pNum+1,returnList);
        }
    }
    return returnList;
}

function checkSort(obj,max){
    var num = $(obj).val();
    if(typeof(max) == 'undefined'){
        max = 255;
    }
    if(num > max){
        $(obj).val(max);
    }else if(num < 0){
        $(obj).val(0);
    }
}

function alidateFloatEmpty(obj,type){
    var num = $(obj).val();
    if( num.trim() == '' || isNaN(num) ){
        num = 0;
    }else{
        num = String(parseFloat(num));//防止多余小数点 或 字母字符 残留
    }
    $(obj).val(num);
}

function validateFloat(num,type){
    num = String(num);
    if( num < 0 ){
        num = 0;
    }else{
        var arr = num.split(".");
        if( arr.length == 2){
            num = arr[0]+'.'+arr[1].slice(0,2);
        } else if( arr.length > 2){
            num = arr[0]+'.'+arr[1].slice(0,2);
        }
    }
    return true;
}