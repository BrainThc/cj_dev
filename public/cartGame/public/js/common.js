//页面加载时调用
$(document).ready(function(){
	orient();
	//按钮点击音效
	$('.click_voice').click(function(){
		if( $('#sound_box').length > 0 ){
			soudPlay('open');
		}
	});
	
	//点击关闭按钮音效
	$('.close_btn').click(function(){
		if( $('#sound_box').length > 0 ){
			soudPlay('close');
		}
	});
	
	//点击开启或关闭音乐
	$('#bgm_btn').click(function(){
		if( $(this).prop('checked') == true ){
			parent.window.bgm_play_state = 1;
			sessionStorage.setItem('bgm_play_state',1);
			parent.window.document.getElementById('bgm').play();
		}else{
			parent.window.bgm_play_state = 0;
			sessionStorage.setItem('bgm_play_state',0);
			parent.window.document.getElementById('bgm').pause();
		}
	});
	
	//点击开启或关闭音效
	$('#sound_btn').click(function(){
		if( $(this).prop('checked') == true ){
			parent.window.audio_play_state = 1;
			sessionStorage.setItem('audio_play_state',1);
		}else{
			parent.window.audio_play_state = 0;
			sessionStorage.setItem('audio_play_state',0);
		}
	});
});


//点击按钮播放音效
var audio_play_state;//设置是否播放音效标识
var bgm_play_state;//设置背景音乐是否播放标识
function checkVoiceState(page_view){
	if( sessionStorage.getItem('audio_play_state') != undefined && sessionStorage.getItem('audio_play_state') != '' && sessionStorage.getItem('audio_play_state') != null ){
		audio_play_state = sessionStorage.getItem('audio_play_state');
		if( page_view == 'def' ){			
			$('#sound_btn').prop('checked',audio_play_state == 1 ? true : false);
		}
	}else{
		audio_play_state = 1;
		sessionStorage.setItem('audio_play_state',audio_play_state);
	}
};

function checkBgmState(page_view){
	if( sessionStorage.getItem('bgm_play_state') != undefined && sessionStorage.getItem('bgm_play_state') != '' && sessionStorage.getItem('bgm_play_state') != null ){
		bgm_play_state = sessionStorage.getItem('bgm_play_state');
		if( page_view == 'def' ){
			$('#bgm_btn').prop('checked',bgm_play_state == 1 ? true : false);
		}
	}else{
		bgm_play_state = 1;
		sessionStorage.setItem('bgm_play_state',bgm_play_state);
	}
};


//各种音效配置
function soudPlay(voice){
	var audioArr = document.querySelectorAll(".sound_bgm");
	var sound_url = '';
	switch (voice){
		case 'chips_one':
			sound_url = '../public/media/chips_one.mp3';//单个筹码投注音效
			break;
		case 'chips':
			sound_url = '../public/media/chips.mp3';//多个筹码投注音效
			break;
		case 'open':
			sound_url = '../public/media/openwin.mp3';//按钮点击音效
			break;
		case 'close':
			sound_url = '../public/media/closewin.mp3';//点击关闭窗口音效
			break;
	}
	if( audio_play_state == 1 ){
		for(var i = 0; i < audioArr.length; i++){
			if(audioArr[i].ended){
				audioArr[i].play();
				return;
			}
		}
		if(audioArr.length != 0){
			audioArr[0].currentTime = 0;
			audioArr[0].play();
		}else{
			var audio = document.createElement("audio");
			audio.src = sound_url;
			document.getElementById('sound_box').appendChild(audio);
			audio.autoplay = 'autoplay';
			audio.play();
		}
	}
};

//背景音乐自动播放
function audioAutoPlay(id,type){
	var audio = document.getElementById(id);
	if( bgm_play_state == 1 && type == 'bgm' ){
		audio.play();
		document.addEventListener("WeixinJSBridgeReady", function () {
			audio.play();
		}, false);
		document.addEventListener('YixinJSBridgeReady', function() {
			audio.play();
		}, false);
	}
	if( audio_play_state == 1 && type == 'sound' ){
		audio.play();
		document.addEventListener("WeixinJSBridgeReady", function () {
			audio.play();
		}, false);
		document.addEventListener('YixinJSBridgeReady', function() {
			audio.play();
		}, false);
	}
}

//页面使用rem单位，1rem=100px
!function(win) {
    function resize() {
        var domWidth = domEle.getBoundingClientRect().width;
        if(domWidth / v > 750){
            domWidth = 750 * v;
        }
        win.rem = domWidth / 7.5;
        domEle.style.fontSize = win.rem + "px";
    }
    var v, initial_scale, timeCode, dom = win.document, domEle = dom.documentElement, viewport = dom.querySelector('meta[name="viewport"]'), flexible = dom.querySelector('meta[name="flexible"]');
    if (viewport) {
        var o = viewport.getAttribute("content").match(/initial\-scale=(["']?)([\d\.]+)\1?/);
        if(o){
            initial_scale = parseFloat(o[2]);
            v = parseInt(1 / initial_scale);
        }
    } else if(flexible) {
        var o = flexible.getAttribute("content").match(/initial\-dpr=(["']?)([\d\.]+)\1?/);
        if (o) {
            v = parseFloat(o[2]);
            initial_scale = parseFloat((1 / v).toFixed(2))
        }
    }
    if (!v && !initial_scale) {
        var n = (win.navigator.appVersion.match(/android/gi), win.navigator.appVersion.match(/iphone/gi));
        v = win.devicePixelRatio;
        v = n ? v >= 3 ? 3 : v >= 2 ? 2 : 1 : 1, initial_scale = 1 / v
    }
    //没有viewport标签的情况下
    if (domEle.setAttribute("data-dpr", v), !viewport) {
        if (viewport = dom.createElement("meta"), viewport.setAttribute("name", "viewport"), viewport.setAttribute("content", "initial-scale=" + initial_scale + ", maximum-scale=" + initial_scale + ", minimum-scale=" + initial_scale + ", user-scalable=no"), domEle.firstElementChild) {
            domEle.firstElementChild.appendChild(viewport)
        } else {
            var m = dom.createElement("div");
            m.appendChild(viewport), dom.write(m.innerHTML)
        }
    }
    win.dpr = v;
    win.addEventListener("resize", function() {
        clearTimeout(timeCode), timeCode = setTimeout(resize, 300)
    }, false);
    win.addEventListener("pageshow", function(b) {
        b.persisted && (clearTimeout(timeCode), timeCode = setTimeout(resize, 300))
    }, false);
    resize();
}(window);

//jQ写法
// $(window).on("resize",function(){
//     $("html").css("fontSize",$(window).width()/7.5);
// }).resize();



//检测用户在什么端打开页面
//判断手机是否是横屏状态，如果是横屏则屏蔽页面
function newEle(){
    var pre = document.createElement('pre');
        pre.style.cssText = "text-align:center;color:#fff;background-color:#000; height:100%;border:0;position:fixed;top:0;left:0;width:100%;z-index:1234;margin:0;";
        pre.innerHTML = '<div style="top: 50%;position: absolute;z-index: 100;width: 100%;"><div style="color: #ffffff;text-align: center;width: 100%;font-size: 20px;font-family:\'黑体\';">为了更好的体验，请选择竖屏模式进行观看</div></div>';
    document.body.appendChild(pre);
    document.getElementsByTagName('body')[0].style.overflow = 'hidden';
}

function orient() {
    if (window.orientation == 90 || window.orientation == -90) {
	    //ipad、iphone竖屏；Andriod横屏
	    newEle();
    }
    else if (window.orientation == 0 || window.orientation == 180) {
	    //ipad、iphone横屏；Andriod竖屏
	    return false;
    }
}

//用户变化屏幕方向时调用
window.addEventListener( 'orientationchange', function(e){
	orient();
	location = location;
});

//配置打开layer弹层
function viewOpen(obj,type){
	var link_url = '',
		area_size = new Array();
	switch (type){
		case 'bet_list'://下注列表
			area_size = ['6.62rem', '7.7rem'];
			link_url = '../view/bet_list.html';
			break;
		case 'player_list'://玩家列表
			area_size = ['6.5rem', '9.74rem'];
			link_url = '../view/player_list.html';
			break;
		case 'activity'://活动弹窗
			area_size = ['5.88rem', '7.28rem'];
			link_url = '../view/activity.html';
			break;
		case 'setting'://设置弹窗
			area_size = ['5.97rem', '4.06rem'];
			link_url = '../view/setting.html';
			break;
		case 'rule'://规则弹窗
			area_size = ['7.5rem', '100%'];
			link_url = '../view/rule.html';
			break;
		case 'charts'://走势图
			area_size = ['6.5rem', '10.1rem'];
			link_url = '../view/charts.html';
			break;
		case 'record'://战绩
			area_size = ['6.5rem', '9.3rem'];
			link_url = '../view/record_list.html';
			break;
		case 'angent'://代理
			area_size = ['6.5rem', '9.3rem'];
			link_url = '../view/angent.html';
			break;
		case 'nickname'://代理
			area_size = ['6.1rem', '4rem'];
			link_url = '../view/nickname_change.html';
			break;
	}
	layer.open({
		type: 2,
		title: false,
		closeBtn: ( type == 'rule' || type == 'setting' || type == 'nickname' ? false : true ),
		shadeClose: true,
		shade: 0.5,
		area: area_size,
		content: link_url,
		end: function(index, layero){
			soudPlay('close');
		}
	});
};

//打开二维码弹窗
function codeOpen(obj,type){
	var code_title = '',
		code_url = '',
		code_tips = '';
	switch (type){
		case 'master_ups'://首页房主弹窗
			code_title = '房主';
			code_url = 'http://pengjianquan.pro.bluej.cn/images/code.png';
			code_tips = '与房主对话';
			break;
		case 'customer_ser'://首页客服弹窗
			code_title = '客服';
			code_url = 'http://pengjianquan.pro.bluej.cn/images/code.png';
			code_tips = '添加客服';
			break;
	}
	$('.code_title').html(code_title);
	$('.code_img img').attr('src',code_url);
	$('.code_tips span').html(code_tips);
	$('.code_mask').fadeIn();
	$('.code_bar').css({
		'-webkit-animation' : 'Scale 500ms linear normal both',
		'animation' : 'Scale 500ms linear normal both'
	});

};

//关闭二维码弹窗
function codeClose(obj){
	$(obj).fadeOut();
	$(obj).next('.ups_wrap').css({
		'-webkit-animation' : 'Scale2 500ms linear normal both',
		'animation' : 'Scale2 500ms linear normal both'
	});
};

//设置layer打开弹出层页面的fontsize
var son_fontSize = $('html').css('fontSize');
function setParentFontsize(){
	$('html').css('font-size',parent.window.son_fontSize);
};

//点击首页更多按钮显示二级菜单
function dropMenuShow(obj){
	if( $(obj).hasClass('current') ){
		$(obj).removeClass('current');
		$('.drop_menu').slideUp(200);
	}else{
		$(obj).addClass('current');
		$('.drop_menu').slideDown(200);
	}
};

//打开分享引导层
function shareGuideOpen(){
	$('.share_mask').fadeIn();
	$('.share_ups').show();
};

//关闭分享引导层
function shareGuideClose(){
	$('.share_mask').fadeOut();
	$('.share_ups').hide();
};