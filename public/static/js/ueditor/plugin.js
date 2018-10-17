/**
 * Created by developer on 2016/7/25.
 */
var getCookie = function(objName){

    var arrStr = document.cookie.split("; ");
    for (var i = 0; i < arrStr.length; i++) {
        var temp = arrStr[i].split("=");
        if (temp[0] == objName) return unescape(temp[1]);
    }
    return "";
};

var QingUpload = function(func){
    var _that = this;
    var _cid = 'c-id_'+Math.random().toFixed(8).replace('.', '');
    var _pid = 'b-id_'+Math.random().toFixed(8).replace('.', '');
    //var sid = this.getCookie('PHPSESSID');
    //
    var uploadTpl = '<div id="'+_cid+'">'+
        '<div style="display: none;" id="'+_pid+'"></div>'+
        '</div>';

    $("body").append(uploadTpl);

    var uploader = new plupload.Uploader({
        runtimes : 'html5,flash,silverlight,html4',
        browse_button : _pid, // you can pass an id...
        container: document.getElementById(_cid), // ... or DOM Element itself
        url : '/api/upload/index.html?dir=article&utype=admin',
        flash_swf_url : '/static/plupload/Moxie.swf',
        silverlight_xap_url : '/static/plupload/Moxie.xap',

        filters : {
            // max_file_size : '2mb',
            mime_types: [
                {title : "Image files", extensions : "jpg,gif,png,jpeg,ico,JPG,GIF,PNG,JPEG,ICO"},
                {title : "Zip files", extensions : "zip"}
            ]
        },

        init:{
            PostInit:function(){
                // console.log('plupload init');
            },
            FilesAdded:function(up,files){
                // console.log(files);
                uploader.start();
            },
            FileUploaded:function(up, file, info){
                //console.log(file);
                fi = $.parseJSON(info.response);
                /*ueObj.execCommand('inserthtml','<img src="'+fi.filePath+'">');*/
                if(typeof(func) == 'function'){
                    func(fi);
                }
            }
        }

    });

    this.start = function(){
        document.getElementById(_pid).click();
        //console.log('click '+_pid);
    };
    //
    uploader.init();
}

var CreateUeditorUI = function(description, func){

    UE.registerUI(description, function(editor, uiname){
        editor.registerCommand(uiname, {
            execCommand:function(){
                //
                if(typeof(func) == 'function'){
                    func(editor);
                }
                //editor.execCommand('inserthtml','wwwww');
            }
        });
        var btn = new UE.ui.Button({
            name:uiname,
            title:uiname,
            cssRules:'background-position: -380px 0;',
            onclick:function(){
                editor.execCommand(uiname);
            }
        });

        editor.addListener('selectionchange',function(){
            var state = editor.queryCommandState(uiname);
            if(state == -1){
                btn.setDisabled(true);
                btn.setChecked(false);
            }else{
                btn.setDisabled(false);
                btn.setChecked(state);
            }
        });

        return btn;
    });
}