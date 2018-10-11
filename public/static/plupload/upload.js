/**
 *  上传文件夹选择
 */
(function($){
    $.fn.WebUpload = function(){
        var dir    = typeof(arguments[0]) == 'undefined' ? '' : arguments[0];
        var func   = typeof(arguments[1]) == 'undefined' ? '' : arguments[1];
        var error_func   = typeof(arguments[2]) == 'undefined' ? '' : arguments[2];
        var _utype   = typeof(arguments[3]) == 'undefined' ? 'user' : arguments[3];
        var _uid   = typeof(arguments[4]) == 'undefined' ? 'user' : arguments[4];
        var that   = this;
        var _id    = that.attr('id');
        var uploader = null;
        var response = null;

        this.init = function(){
            uploader = new plupload.Uploader({
                runtimes : 'html5,flash,silverlight,html4',
                browse_button : _id, // you can pass an id...
                container: document.getElementById('upload_main'), // ... or DOM Element itself
                url : '/commit/index/index.html?dir='+dir+'&utype='+_utype+'&uid='+_uid,
                flash_swf_url : '/static/plupload/Moxie.swf',
                silverlight_xap_url : '/static/plupload/Moxie.xap',
                filters : {
                    max_file_size : '2mb',
                    mime_types: [
                        {title : "Image files", extensions : "jpg,gif,png,jpeg,ico,JPG,GIF,PNG,JPEG,ICO"},
                        // {title : "Zip files", extensions : "zip"}
                    ]
                },
                init:{
                    PostInit:function(){
                        //init
                    },
                    Browse:function(up){
                    },
                    QueueChanged:function(up){
                    },
                    BeforeUpload:function(up, file){

                        var upFileName = file.name;
                        var index1=upFileName.lastIndexOf(".");
                        var length=upFileName.length;
                        var suffix=upFileName.substring(index1+1,length);//后缀名
                        var after_leng = suffix.length;


                        if(suffix == "JPEG" || suffix == "jpeg"){
                            file.name = file.name.substring(0,length - after_leng) + 'jpg';
                        }
                        // console.log(file.name);
                    },
                    UploadProgress:function(up, file){
                        // var percent = file.percent;
                        // //进度条
                        // // $('#progressbar'+$this.parentId).Progressing(percent);
                        //
                        // alert(percent);
                        // layer.msg(percent, {
                        //     skin: 'layui-layer-huise'
                        // });

                        // console.log(percent);
                        //console.log(file);
                    },
                    FileFiltered:function(up, file){
                        //console.log(file);
                    },
                    FilesAdded:function(up, file){
                        uploader.start();
                    },
                    FilesRemoved:function(up, file){
                    },
                    FileUploaded:function(up, file, info){
                        // console.log(file.name);
//                        console.log(up);
//                        console.log(file);
//                        console.log(info);
                        response = $.parseJSON(info.response);
                        //console.log(response);
                        // console.log(_id);
                        $("#"+_id).val(response.filePath);
                        if(func != 'undefined') {
                            response.elementId = _id;
                            func(response);
                        }
                    },
                    UploadComplete:function(up, files){
                        //console.log(files);
                    },
                    Error:function(up, args){

                        if(error_func != 'undefined') {
                            // console.log(args);
                            error_func(args);
                        }
                    }
                }

            });
            uploader.init();
        };

        this.init();
        return uploader;

    }
}(jQuery))