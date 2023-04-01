//游戏开始提示
var start_times = 5,//设置游戏开始倒计时初始值
	seal_times = 4,//设置封盘倒计时初始值
	wait_times = 18,//设置等待开奖倒计时初始值
	over_time = 5,//设置游戏结束等待时间
	restart_times = 10;//设置自动重新开始游戏时间
var cartData = null;
var urlheader = '../public/images/';
$(document).ready(function(){
	//运动过程40s
	cartData = {
		start_bg : urlheader+'cartbg.png',
		end_bg : urlheader+'cartbg.png',
		canvas_obj : '#cart_box',
		canvas_width : 7.5,//画布大小
		canvas_height : 2.84,//画布大小
		canvas_bg : urlheader+'cart/IMG_0892_03.jpg',
		def_width : 2.2,
		def_height : .3,
		shrink_size : 0.2,//塞车缩减值
		list : [
			{image:urlheader+'cart/图层-19.png',fight_image:urlheader+'cart/fight.png',color:'pink','rank':0},
			{image:urlheader+'cart/图层-20.png',fight_image:urlheader+'cart/fight.png',color:'red','rank':0},
			{image:urlheader+'cart/图层-21.png',fight_image:urlheader+'cart/fight.png',color:'greenyellow','rank':0},
			{image:urlheader+'cart/图层-22.png',fight_image:urlheader+'cart/fight.png',color:'#bbb','rank':0},
			{image:urlheader+'cart/图层-23.png',fight_image:urlheader+'cart/fight.png',color:'green','rank':0},
			{image:urlheader+'cart/图层-41.png',fight_image:urlheader+'cart/fight.png',color:'orange','rank':0},
			{image:urlheader+'cart/图层-42.png',fight_image:urlheader+'cart/fight.png',color:'#FB5A5C','rank':0},
			{image:urlheader+'cart/图层-45.png',fight_image:urlheader+'cart/fight.png',color:'blue','rank':0},
		],
		sec : wait_times,
		run_sec : wait_times,
		champion : null,
		ranking_obj : '.ranking_bar',
		rank_list : []
	};
	racingConfig(cartData);
	checkVoiceState();
	checkBgmState();
	audioAutoPlay('bgm','bgm');
	OpeningTips();
});

function racingConfig(cartData){
	var html = '';
	var rank_html = ''; 
	//配置画布
	if( typeof(cartData.canvas_width) != 'number' || typeof(cartData.canvas_height) != 'number' ){
		alert('画布布置出错');
		return false;
	}
	$(cartData.canvas_obj).css('width',cartData.canvas_width+'rem');
	$(cartData.canvas_obj).css('height',cartData.canvas_height+'rem');
	if( typeof(cartData.def_width) != 'number' || typeof(cartData.shrink_size) != 'number' || cartData.list.length <=0 ){
		alert('车辆配置出错');
		return false;
	}
	let def_width = cartData.def_width;
	let def_height = cartData.def_height;
	let shrink_size = cartData.shrink_size;
	let size = cartData.list.length;
	//检查是否可距离缩放
	if( def_width - (size * shrink_size) < def_height ){
		alert('缩减值出错');
		return false;
	}
	var cart_num = 0;
	for(var c = 0; c < size; c++){
		cart_num = c+1;
		//配置排名
		rank_html += '<div class="ranking_num" data-num="'+cart_num+'"><img src="../public/images/ranking_num'+cart_num+'.png" alt="" /></div>'
		html = '<div class="cart_list" style="height:'+(def_height+0.01)+'rem; width:'+cartData.canvas_width+'rem;" ><div class="cart cart_'+cart_num+'" style="float:left; position:relative; left:'+(cartData.canvas_width-( def_width - ( c * shrink_size ) ) )+'rem; height:'+def_height+'rem; width:'+( def_width - ( c * shrink_size ) )+'rem;  background:url('+cartData.list[c].image+') no-repeat center center; background-size:100% 100%;" ><i class="fight" style="width:0.5rem; height:'+def_height+'rem; display:none; float:left; position:absolute; right:-0.5rem; background:url('+cartData.list[c].fight_image+') no-repeat center center; background-size:100% 100%;" /></i></div></div>'+html;
	}
	$(cartData.canvas_obj).html(html);
	$(cartData.ranking_obj).html(rank_html);
	cartData.startState = false;
}

function getChampion(){
    if( typeof(cartData.champion) != 'underfind' && typeof(cartData.champion) == 'number' && parseInt(cartData.champion) < cartData.list.length && parseInt(cartData.champion) > 0){
     	cartData.champion = cartData.champion - 1
    }else{
    	cartData.champion = 1 + Math.round( Math.random() * (cartData.list.length - 1) ) - 1;
    }
}


function rankSettting(end_list){
	var randk_html = '';
	var html = '';
	let size = cartData.list.length;
	let objs = cartData.list;
	if( typeof(end_list) != 'undefined' ){
	 	objs = end_list;
	}
	var cart_num = 0;
	var n_sum = 0;
	var l_sum = 0;
	$(cartData.ranking_obj).html('');
	for(var c = 0; c < size; c++){
		cart_num = c+1;
		//配置排名
		html = '<div class="ranking_num" data-num="'+cart_num+'"><img src="../public/images/ranking_num'+cart_num+'.png" alt="" /></div>';
    	if( typeof(end_list) != 'undefined' ){
			if( c == 0 || objs[c] == objs[c-1] ){
				randk_html += html; 
				$(cartData.ranking_obj).append(html);
			}else if( objs[c] > objs[c-1] ){
				$(cartData.ranking_obj).prepend(html);
			}else if( objs[c] < objs[c-1] ){
				$(cartData.ranking_obj).append(html);
			}
		}else{
			if( c == 0 || objs[c].rank == objs[c-1].rank ){
				randk_html += html; 
				$(cartData.ranking_obj).append(html);
			}else if( objs[c].rank > objs[c-1].rank ){
				$(cartData.ranking_obj).prepend(html);
			}else if( objs[c].rank < objs[c-1].rank ){
				$(cartData.ranking_obj).append(html);
			}
			
		}
	}
}
//比赛开始
function racingStart(){
	$(cartData.canvas_obj).css('background','url('+cartData.canvas_bg+') repeat-x 0 center');
	if(cartData.startState === true){
		alert('已开始');
		return false;
	}else{
		cartData.startState = true;
	}
	//布景滚动
	cartData.cavasT = setInterval("canvasRun()",100);
	cartData.secT = setInterval("timIng()",1000);
	getChampion();
}
//比赛停止
function racingStop(){
	//获取
	$(cartData.canvas_obj).css('background-position-x',0);
	clearInterval(cartData.cavasT);
	clearInterval(cartData.secT);
	cartData.run_sec = cartData.sec
	cartData.startState = false;
	$('.cart').find('i').hide();
}
//重置比赛
function racingReset(){
	$(cartData.canvas_obj).css('background-position-x',0);
	clearInterval(cartData.cavasT);
	clearInterval(cartData.secT);
	cartData.run_sec = cartData.sec
	cartData.startState = false;
	$('.cart').find('i').hide();
	$(cartData.canvas_obj).css('background','none');
	racingConfig(cartData);
}
function canvasRun(){
	$(cartData.canvas_obj).css('background-position-x',((parseInt($(cartData.canvas_obj).css('background-position-x')))+1)+'rem');

}
function cartRun(){
	let proportion = parseInt($('html').css('font-size'));
	let champion = cartData.champion;
	let wid = cartData.canvas_width - ( cartData.canvas_width * 0.2 );
	wid = wid * proportion;
	let sec = cartData.sec;
	let run_sec = cartData.run_sec;
	let min = wid;
	let size = 0;
	let an_time = 1000;
	var index = 0;
	$('.cart').each(function(){
		index = $('.cart').index($(this));
		o_wi = parseInt($(this).css('left'));
		max = wid - parseInt($(this).width());
		size = max / 4
		if( run_sec < 2 ){
			if( champion != index ){
				an_time = 1001 + Math.round( Math.random() * ( 2000 - 1001) );
			}else{
				an_time = 1000;
			}
			n_po = 0;
		}else if( sec / 3 > run_sec ){
			_max = max - (size * 2);
			min = max - (size * 3);
			n_po = min + Math.round( Math.random() * (_max - min) );
		}else if( (sec / 3) * 2 > run_sec ){
			_max = max - (size * 1);
			min = max - (size * 2);
			n_po = min + Math.round( Math.random() * (_max - min) );
		}else if(sec > run_sec ){
			_max = max;
			min = max - size;
			n_po = min + Math.round( Math.random() * (_max - min) );
		}else{
			return false;
		}
		if(n_po < o_wi ){
			$(this).find('i').show();
		}else{
			$(this).find('i').hide();
		}
		if( run_sec == 0 ){
			cartData.rank_list.push(an_time)
		}else{
			cartData.list[index].rank = n_po;
		}
		$(this).animate({'left':n_po+'px'},an_time);
	});
	if( run_sec >= 2 ){
		rankSettting();
	}else if( run_sec ){
		rankSettting(cartData.rank_list);
	}
}
function timIng(){
	cartData.run_sec--;
	cartRun();
	if( cartData.run_sec == 0 ){
		clearInterval(cartData.cavasT);
		clearInterval(cartData.secT);
		cartData.run_sec = cartData.sec
		cartData.startState = false;
		$('.cart').find('i').hide();
		$(cartData.canvas_obj).css('background','none');
	}
}



function OpeningTips(){
	$('.roulette').html(start_times);
	$('.game_star_tips').addClass('opening');
	$('.game_tips').html('游戏开始');
	resetAllstate();
	audioAutoPlay('start_bgm','sound');
	canbet = true;
	setTimeout(function(){
		$('.game_star_tips').hide();
	},1000);
	setTimeout(function(){
		$('.game_star_tips').removeClass('opening').show();
		$('.roulette').show();
		$('.game_tips').html('现在下注');
		countdown(start_times,'start');
	},1200);
};

//重置游戏状态
function resetAllstate(){
	racingReset();
	$('.card').hide();//重置盖牌状态
	$('.card').removeClass('animated');//重置翻牌动画状态
	$('.money').remove();//重置筹码状态
	$('#sound_box audio').remove();//清除点击按钮生成的音效
	$('.game_over').hide();//重置本局结算窗口
};

//倒计时
var T;
function countdown(times,type){
	clearInterval(T);//重置倒计时
	var ed_t = times;
	T = setInterval(function(){
		if( typeof(ed_t) == 'undefined' ){
	        clearInterval(T);
	        return false;
	    }
		if( type == 'undefined' ){
			clearInterval(T);
	        return false;
		}
		ed_t --;
		
		if( type == 'restart' ){
			$('.close_count span').html(ed_t);
		}else{
			$('.roulette').html(ed_t);
		}
	    
		if( ed_t <= 1 ){
			clearInterval(T);
			switch (type){
				case 'start':
					countdown(seal_times,'seal');
					setTimeout(function(){
						resetCover();
					},800);
					$('.game_tips').html('等待开奖');
					break;
				case 'seal':
					racingStart();
					countdown(wait_times,'wait');
					setTimeout(function(){
						$('.roulette').hide();
					},1000);
					break;
				case 'wait':
					showCardVal();
					$('.game_tips').html('正在开牌');
					setTimeout(function(){
						countdown(over_time,'over');
					},23000);
					break;
				case 'over':
					audioAutoPlay('loss','sound');
					$('.game_over').show();
					$('.close_count span').html(restart_times);
					countdown(restart_times,'restart');
					break;
				case 'restart':
					setTimeout(function(){
						OpeningTips();
					},1000);
					break;
			}
		}
	},1000);
};

//关闭本局结算弹窗
function closeSettle(){
	$('.game_over').hide();
};

//定位投注筹码参数集
var position_arr = [
	{'min_top':3.9,'min_left':0.1,'max_top':4.5,'max_left':1},//1
	{'min_top':3.9,'min_left':3,'max_top':4.5,'max_left':3.9},//2
	{'min_top':3.9,'min_left':5.8,'max_top':4.5,'max_left':6.7},//3
	{'min_top':6,'min_left':0.1,'max_top':6.6,'max_left':1},//4
	{'min_top':6,'min_left':5.8,'max_top':6.6,'max_left':6.7},//5
	{'min_top':8,'min_left':0.1,'max_top':8.6,'max_left':1},//6
	{'min_top':8,'min_left':3,'max_top':8.6,'max_left':3.9},//7
	{'min_top':8,'min_left':5.8,'max_top':8.6,'max_left':6.7}//8
];
var z_index = 50;//用于限制筹码位置
//筹码选中
$('.chip').click(function(){
	$('.chip').removeClass('active');
	$(this).addClass('active');
});

//主动调取
var canbet = true;//是否可投注标识
function linkageBet(bet_num,position){
	if( canbet === false ){
		return false;
	}
	soudPlay('chips');
	for(var b = 0; b < bet_num; b++){
		//放置筹码
		createBat(z_index,position,0 + Math.round( Math.random() * (6 - 0)));
		//联动配置
		putBet(z_index,position);
		z_index++;
	}
}
//被动调取
$('.bets_list .bets_area').click(function(){
	if( canbet === false ){
		return false;
	}
	soudPlay('chips_one');
	var area_index = $(this).parent().index();
	//放置筹码
	createBat(z_index,area_index);
	//联动配置
	putBet(z_index,area_index);
	z_index++;
});

//更新盘口筹码
function updateChips(){
	//后台给你自己发挥
}

//生成筹码
function createBat(zc_index,area_index,bet_num){
	let money = document.createElement('div');
	if( zc_index > 8888 ){
		zc_index = 50;
		z_index = 50;
	}
	money.className = 'money money_'+zc_index+' bets_'+area_index;//设定标记
	money.style.top = '.2rem';
	money.style.left = '.2rem';
	money.style.display = 'block';
	money.style.zIndex = zc_index;
	if( typeof(bet_num) != 'underfind' && typeof(bet_num) == 'number' ){
		money.setAttribute.data_val = $('.chip').eq(bet_num).attr('data-val');
    	money.style.backgroundImage = $('.chip').eq(bet_num).css('background-image');
    }else{
		money.setAttribute.data_val = $('.chip_bar .active').attr('data-val');
    	money.style.backgroundImage = $('.chip_bar .active').css('background-image');
	}
	//放置对象
	document.getElementById('user_list').appendChild(money);
}
//筹码联动配置
function putBet(zc_index,index){
	var min_top = (position_arr[index].min_top)*100;
	var max_top = (position_arr[index].max_top)*100;
	var min_left = (position_arr[index].min_left)*100;
	var max_left = (position_arr[index].max_left)*100;
	let top = ( min_top + Math.round( Math.random() * (max_top - min_top) )) / 100;
	let left = (min_left + Math.round( Math.random() * (max_left - min_left) ) ) / 100;
	$('.money_'+zc_index).animate({'top':top+'rem','left':left+'rem'},500);
}

//筹码转移联动配置
function posting(start,end){
	var min_top = (position_arr[end].min_top)*100;
	var	max_top = (position_arr[end].max_top)*100;
	var	min_left = (position_arr[end].min_left)*100;
	var	max_left = (position_arr[end].max_left)*100;
	var top = 0;
	var left = 0;
	$('.bets_'+start).each(function(){
		top = ( min_top + Math.round( Math.random() * (max_top - min_top) )) / 100;
		left = (min_left + Math.round( Math.random() * (max_left - min_left) ) ) / 100;
		
		$(this).animate({'top':top+'rem','left':left+'rem'},1000);
		audioAutoPlay('got_reward','sound');
	});
	$('.bets_'+start).addClass('bets_'+end);//销毁标记
	$('.bets_'+start).removeClass('bets_'+start);//创建新标记
}

//设置牌子点数的图片
var new_cardval_arr = [
	{image:'../public/images/card_back.png'},
	{image:'../public/images/point01.png'},
	{image:'../public/images/point02.png'},
	{image:'../public/images/point03.png'},
	{image:'../public/images/point04.png'},
	{image:'../public/images/point05.png'},
	{image:'../public/images/point06.png'},
	{image:'../public/images/point07.png'},
	{image:'../public/images/point08.png'},
	{image:'../public/images/point09.png'},
	{image:'../public/images/point00.png'}
];

//定位盖牌参数集
var cover_arr = [
	{'left' : 3.13,'top' : 2.7},
	{'left' : .3,'top' : 2.7},
	{'left' : -2.5,'top' : 2.7},
	{'left' : 3.13,'top' : .6},
	{'left' : -2.5,'top' : .6},
	{'left' : 3.13,'top' : -1.4},
	{'left' : .3,'top' : -1.4},
	{'left' : -2.5,'top' : -1.4}
];

function showCardVal(type){
	$('.card').each(function(){
		var that = $(this);
		if( typeof(type) != 'undefined' && type == 'reset' ){
			that.find('img').attr('src',new_cardval_arr[that.find('img').attr('data-val')].image);
			that.css({
				'top' : cover_arr[$('.card').index(that)].top+'rem',
				'left' : cover_arr[$('.card').index(that)].left+'rem'
			});
			
			//盖牌动画
			var tims = seal_times * 100 * $('.card').index(that);
			var left = '0.27';
			var play_t = setInterval(function(){
				audioAutoPlay('closewin','sound');
			},340);
			
			setTimeout(function(){
				that.show().animate({
					'top' : '0rem',
					'left' : left + 'rem'
				},200);
				clearInterval(play_t);
			},tims);
		}else{
			that.find('img').attr('data-val',2);//设置翻牌结果domo，根据牌子点数数组2，显示的点数也为2
			
			//翻牌动画
			var carts_index = $('.card').index(that);
			var def_num = ( carts_index < 1 ) ? 800 : 3300,
				def_time = ( carts_index < 1 ) ? def_num * ( carts_index + 1 ) : def_num * carts_index;
			that.addClass('animated');
			var sec_time = ( carts_index < 1 ) ? 0 : ( carts_index - 1 ) * 200;
			var an_time = def_time - sec_time;
			setTimeout(function(){
				that.find('img').attr('src',new_cardval_arr[that.find('img').attr('data-val')].image);//翻牌结果，根据牌子点数，替换对应的图片
			},an_time);
		}
	})
};

//重置盖牌状态
function resetCover(){
	canbet = false;
	$('.card').find('img').attr('data-val',0);
	showCardVal('reset');
};

//修改昵称
function chageNickName(new_name){
	layer.msg('修改成功', {
		skin: 'layui-layer-huise'
	});
	$('.user_id span').html(new_name);
}
