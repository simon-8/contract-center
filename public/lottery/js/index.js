$(document).ready(function() {
	//加的效果
	$(".plus").click(function() {
		var n = $(this).prev().val();
		var num = parseInt(n) + 1;
		if (num == 0) {
			return;
		}
		$(this).prev().val(num);
	});
	//减的效果
	$(".decade").click(function() {
		var n = $(this).next().val();
		var num = parseInt(n) - 1;
		if (num == 0) {
			return
		}
		$(this).next().val(num);
	});

	// ....................抽奖播报
	$(".font_inner li:eq(0)").clone(true).appendTo($(".font_inner")); //克隆第一个放到最后(实现无缝滚动)
	var liHeight = $(".swiper_wrap").height(); //一个li的高度
	//获取li的总高度再减去一个li的高度(再减一个Li是因为克隆了多出了一个Li的高度)
	var totalHeight = ($(".font_inner li").length * $(".font_inner li").eq(0).height()) - liHeight;
	$(".font_inner").height(totalHeight); //给ul赋值高度
	var index = 0;
	var autoTimer = 0; //全局变量目的实现左右点击同步
	var clickEndFlag = true; //设置每张走完才能再点击
	function tab() {
		$(".font_inner").stop().animate({
			top: -index * liHeight
		}, 400, function() {
			clickEndFlag = true; //图片走完才会true
			if (index == $(".font_inner li").length - 1) {
				$(".font_inner").css({
					top: 0
				});
				index = 0;
			}
		})
	}
	function next() {
		index++;
		if (index > $(".font_inner li").length - 1) { //判断index为最后一个Li时index为0
			index = 0;
		}
		tab();
	}
	function prev() {
		index--;
		if (index < 0) {
			index = $(".font_inner li").size() - 2; //因为index的0 == 第一个Li，减二是因为一开始就克隆了一个LI在尾部也就是多出了一个Li，减二也就是_index = Li的长度减二
			$(".font_inner").css("top", -($(".font_inner li").size() - 1) * liHeight); //当_index为-1时执行这条，也就是走到li的最后一个
		}
		tab();
	}
	//自动轮播
	autoTimer = setInterval(next, 3000);
	$(".font_inner a").hover(function() {
		clearInterval(autoTimer);
	}, function() {
		autoTimer = setInterval(next, 3000);
	})
	// //鼠标放到左右方向时关闭定时器
	// $(".swiper_wrap .lt,.swiper_wrap .gt").hover(function() {
	// 	clearInterval(autoTimer);
	// }, function() {
	// 	autoTimer = setInterval(next, 3000);
	// })
})