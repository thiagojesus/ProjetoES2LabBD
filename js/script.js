var isSplash = -1;
function start(){
	
};
function startF(){	
	setTimeout(function () {
		//$('.car1').css({marginRight:-500}).stop().delay(100).animate({marginRight:0},1200,'easeOutBack');
	}, 200);
};
function showSplash(){
	setTimeout(function () {		
		$('.top1').stop().delay(0).animate({'marginTop':'0px'}, 800, "easeOutExpo");
		$('#menu .nav4').stop().delay(100).animate({'marginTop':'0px'}, 800, "easeOutExpo").delay(0).animate({'marginLeft':'0px'}, 800, "easeOutExpo");
		$('#menu .nav3').stop().delay(100).animate({'marginTop':'0px'}, 800, "easeOutExpo").delay(0).animate({'marginLeft':'0px'}, 800, "easeOutExpo");
		$('#menu .nav6').stop().delay(200).animate({'marginTop':'0px'}, 800, "easeOutExpo").delay(0).animate({'marginLeft':'0px'}, 800, "easeOutExpo");
		$('#menu .nav5').stop().delay(200).animate({'marginTop':'0px'}, 800, "easeOutExpo").delay(0).animate({'marginLeft':'0px'}, 800, "easeOutExpo");
		$('#menu .nav8').stop().delay(1100).animate({'marginTop':'0px'}, 800, "easeOutExpo");
		$('#menu .nav7').stop().delay(1100).animate({'marginTop':'0px'}, 800, "easeOutExpo");
		$('.slider').stop().delay(1200).animate({'marginTop':'0px'}, 800, "easeOutExpo");
	}, 400);	
};
function hideSplash(){ 
	$('.slider').stop().animate({'marginTop':'-600px'}, 800, "easeOutExpo");		
	$('#menu .nav8').stop().delay(100).animate({'marginTop':'-486px'}, 800, "easeOutExpo");
	$('#menu .nav7').stop().delay(100).animate({'marginTop':'-486px'}, 800, "easeOutExpo");
	$('#menu .nav6').stop().delay(200).animate({'marginLeft':'648px'}, 800, "easeOutExpo").delay(0).animate({'marginTop':'-324px'}, 800, "easeOutExpo");
	$('#menu .nav5').stop().delay(200).animate({'marginLeft':'648px'}, 800, "easeOutExpo").delay(0).animate({'marginTop':'-324px'}, 800, "easeOutExpo");
	$('#menu .nav4').stop().delay(300).animate({'marginLeft':'324px'}, 800, "easeOutExpo").delay(0).animate({'marginTop':'-162px'}, 800, "easeOutExpo");
	$('#menu .nav3').stop().delay(300).animate({'marginLeft':'324px'}, 800, "easeOutExpo").delay(0).animate({'marginTop':'-162px'}, 800, "easeOutExpo");
	$('.top1').stop().delay(1000).animate({'marginTop':'-60px'}, 800, "easeOutExpo");







};
function hideSplashQ(){
	$('.slider').css({'marginTop':'-600px'});
	$('#menu .nav8').css({'marginTop':'-486px'});
	$('#menu .nav7').css({'marginTop':'-486px'});
	$('#menu .nav6').css({'marginLeft':'648px','marginTop':'-324px'});
	$('#menu .nav5').css({'marginLeft':'648px','marginTop':'-324px'});
	$('#menu .nav4').css({'marginLeft':'324px','marginTop':'-162px'});
	$('#menu .nav3').css({'marginLeft':'324px','marginTop':'-162px'});
	$('.top1').css({'marginTop':'-60px'});
};

/////////////////////// ready
$(document).ready(function() {
	MSIE8 = ($.browser.msie) && ($.browser.version == 8),
	$.fn.ajaxJSSwitch({
		classMenu:"#menu",
		classSubMenu:".submenu",
		topMargin: 380,//mandatory property for decktop
		bottomMargin: 80,//mandatory property for decktop
		topMarginMobileDevices: 380,//mandatory property for mobile devices
		bottomMarginMobileDevices: 80,//mandatory property for mobile devices
		delaySubMenuHide: 300,
		fullHeight: true,
		bodyMinHeight: 820,
		menuInit:function (classMenu, classSubMenu){
			//classMenu.find(">li").each(function(){
			//	$(">a", this).append("<div class='openPart'></div>");
			//})
		},
		buttonOver:function (item){
            //$('>.over1',item).stop().animate({'opacity':'0.6'},300,'easeOutCubic');            
            //$('>.txt1',item).stop().animate({'color':'#ff0000'},300,'easeOutCubic');
		},
		buttonOut:function (item){
            //$('>.over1',item).stop().animate({'opacity':'0'},300,'easeOutCubic');
            //$('>.txt1',item).stop().animate({'color':'#ffffff'},300,'easeOutCubic');           
		},
		subMenuButtonOver:function (item){
		},
		subMenuButtonOut:function (item){
		},
		subMenuShow:function(subMenu){        	
        	//subMenu.stop(true,true).animate({"height":"show"}, 500, "easeOutCubic");
		},
		subMenuHide:function(subMenu){
        	//subMenu.stop(true,true).animate({"height":"hide"}, 700, "easeOutCubic");
		},
		pageInit:function (pages){
			//console.log('pageInit');
		},
		currPageAnimate:function (page){
			//console.log('currPageAnimate');
			var Delay=400; // default
			if(isSplash==-1){ // on reload				
				hideSplashQ();
				Delay=0;				
			}
			if(isSplash==0){ // on first time click				
				hideSplash();
				Delay=1800;
			}
			isSplash = 2;
			
			// animation of current page
			jQuery('body,html').animate({scrollTop: 0}, 0); 
			
			page.css({"left":$(window).width()}).stop(true).delay(Delay).animate({"left":0}, 1000, "easeOutCubic", function (){
					$(window).trigger('resize');
			});    	
		},
		prevPageAnimate:function (page){
			//console.log('prevPageAnimate');
			page.stop(true).animate({"display":"block", "left":-$(window).width()}, 500, "easeInCubic");
		},
		backToSplash:function (){
			//console.log('backToSplash');
			if(isSplash==-1){
				isSplash = 0;
				startF();				
			}
			else{
				isSplash = 0;				
				showSplash();
			};
			$(window).trigger('resize');			      
		},
		pageLoadComplete:function (){
			//console.log('pageLoadComplete');            
    }
	});  /// ajaxJSSwitch end

	////// sound control	
	$("#jquery_jplayer").jPlayer({
		ready: function () {
			$(this).jPlayer("setMedia", {
				mp3:"music.mp3"
			});
			//$(this).jPlayer("play");
			var click = document.ontouchstart === undefined ? 'click' : 'touchstart';
          	var kickoff = function () {
            $("#jquery_jplayer").jPlayer("play");
            document.documentElement.removeEventListener(click, kickoff, true);
         	};
          	document.documentElement.addEventListener(click, kickoff, true);
		},
		
		repeat: function(event) { // Override the default jPlayer repeat event handler				
				$(this).bind($.jPlayer.event.ended + ".jPlayer.jPlayerRepeat", function() {
					$(this).jPlayer("play");
				});			
		},
		swfPath: "js",
		cssSelectorAncestor: "#jp_container",
		supplied: "mp3",
		wmode: "window"
	});

	/////// icons
	$(".icons li a").css({opacity:0.7});
	$(".icons li a").hover(function() {
		$(this).stop().animate({opacity:1 }, 400, 'easeOutExpo');		    
	},function(){
	  $(this).stop().animate({opacity:0.7 }, 400, 'easeOutExpo' );		   
	});
	

	

	
	
	
	

	
		
});

/////////////////////// load
$(window).load(function() {	
	setTimeout(function () {					
  		$('#spinner').fadeOut();		
  		$(window).trigger('resize');
  		start();
	}, 100);
	setTimeout(function () {$("#jquery_jplayer").jPlayer("play");}, 2000);	
});