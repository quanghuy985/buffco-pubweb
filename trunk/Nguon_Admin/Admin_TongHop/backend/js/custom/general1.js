/*
 * 	Additional function for this template
 *	Written by ThemePixels	
 *	http://themepixels.com/
 *
 *	Copyright (c) 2012 ThemePixels (http://themepixels.com)
 *	
 *	Built for Amanda Premium Responsive Admin Template
 *  http://themeforest.net/category/site-templates/admin-templates
 */



j121212(document).ready(function(){
								
								
	///// SHOW/HIDE USERDATA WHEN USERINFO IS CLICKED ///// 
	
	j121212('.userinfo').click(function(){
		if(!j121212(this).hasClass('active')) {
			j121212('.userinfodrop').show();
			j121212(this).addClass('active');
		} else {
			j121212('.userinfodrop').hide();
			j121212(this).removeClass('active');
		}
		//remove notification box if visible
		j121212('.notification').removeClass('active');
		j121212('.noticontent').remove();
		
		return false;
	});
	
	
	///// SHOW/HIDE NOTIFICATION /////
	
	j121212('.notification a').click(function(){
		var t = j121212(this);
		var url = t.attr('href');
		if(!j121212('.noticontent').is(':visible')) {
			j121212.post(url,function(data){
				t.parent().append('<div class="noticontent">'+data+'</div>');
			});
			//this will hide user info drop down when visible
			j121212('.userinfo').removeClass('active');
			j121212('.userinfodrop').hide();
		} else {
			t.parent().removeClass('active');
			j121212('.noticontent').hide();
		}
		return false;
	});
	
	
	
	///// SHOW/HIDE BOTH NOTIFICATION & USERINFO WHEN CLICKED OUTSIDE OF THIS ELEMENT /////


	j121212(document).click(function(event) {
		var ud = j121212('.userinfodrop');
		var nb = j121212('.noticontent');
		
		//hide user drop menu when clicked outside of this element
		if(!j121212(event.target).is('.userinfodrop') 
			&& !j121212(event.target).is('.userdata') 
			&& ud.is(':visible')) {
				ud.hide();
				j121212('.userinfo').removeClass('active');
		}
		
		//hide notification box when clicked outside of this element
		if(!j121212(event.target).is('.noticontent') && nb.is(':visible')) {
			nb.remove();
			j121212('.notification').removeClass('active');
		}
	});
	
	
	///// NOTIFICATION CONTENT /////
	
	j121212('.notitab a').live('click', function(){
		var id = j121212(this).attr('href');
		j121212('.notitab li').removeClass('current'); //reset current 
		j121212(this).parent().addClass('current');
		if(id == '#messages')
			j121212('#activities').hide();
		else
			j121212('#messages').hide();
			
		j121212(id).show();
		return false;
	});
	
	
	
	///// SHOW/HIDE VERTICAL SUB MENU /////	
	
	j121212('.vernav > ul li a, .vernav2 > ul li a').each(function(){
		var url = j121212(this).attr('href');
		j121212(this).click(function(){
			if(j121212(url).length > 0) {
				if(j121212(url).is(':visible')) {
					if(!j121212(this).parents('div').hasClass('menucoll') &&
					   !j121212(this).parents('div').hasClass('menucoll2'))
							j121212(url).slideUp();
				} else {
					j121212('.vernav ul ul, .vernav2 ul ul').each(function(){
							j121212(this).slideUp();
					});
					if(!j121212(this).parents('div').hasClass('menucoll') &&
					   !j121212(this).parents('div').hasClass('menucoll2'))
							j121212(url).slideDown();
				}
				return false;	
			}
		});
	});
	
	
	///// SHOW/HIDE SUB MENU WHEN MENU COLLAPSED /////
	j121212('.menucoll > ul > li, .menucoll2 > ul > li').live('mouseenter mouseleave',function(e){
		if(e.type == 'mouseenter') {
			j121212(this).addClass('hover');
			j121212(this).find('ul').show();	
		} else {
			j121212(this).removeClass('hover').find('ul').hide();	
		}
	});
	
	
	///// HORIZONTAL NAVIGATION (AJAX/INLINE DATA) /////	
	
	j121212('.hornav a').click(function(){
		
		//this is only applicable when window size below 450px
		if(j121212(this).parents('.more').length == 0)
			j121212('.hornav li.more ul').hide();
		
		//remove current menu
		j121212('.hornav li').each(function(){
			j121212(this).removeClass('current');
		});
		
		j121212(this).parent().addClass('current');	// set as current menu
		
		var url = j121212(this).attr('href');
		if(j121212(url).length > 0) {
			j121212('.contentwrapper .subcontent').hide();
			j121212(url).show();
		} else {
			j121212.post(url, function(data){
				j121212('#contentwrapper').html(data);
				j121212('.stdtable input:checkbox').uniform();	//restyling checkbox
			});
		}
		return false;
	});
	
	
	///// SEARCH BOX WITH AUTOCOMPLETE /////
	
	var availableTags = [
			"ActionScript",
			"AppleScript",
			"Asp",
			"BASIC",
			"C",
			"C++",
			"Clojure",
			"COBOL",
			"ColdFusion",
			"Erlang",
			"Fortran",
			"Groovy",
			"Haskell",
			"Java",
			"JavaScript",
			"Lisp",
			"Perl",
			"PHP",
			"Python",
			"Ruby",
			"Scala",
			"Scheme"
		];
	j121212('#keyword').autocomplete({
		source: availableTags
	});
	
	
	///// SEARCH BOX ON FOCUS /////
	
	j121212('#keyword').bind('focusin focusout', function(e){
		var t = j121212(this);
		if(e.type == 'focusin' && t.val() == 'Enter keyword(s)') {
			t.val('');
		} else if(e.type == 'focusout' && t.val() == '') {
			t.val('Enter keyword(s)');	
		}
	});
	
	
	///// NOTIFICATION CLOSE BUTTON /////
	
	j121212('.notibar .close').click(function(){
		j121212(this).parent().fadeOut(function(){
			j121212(this).remove();
		});
	});
	
	
	///// COLLAPSED/EXPAND LEFT MENU /////
	j121212('.togglemenu').click(function(){
		if(!j121212(this).hasClass('togglemenu_collapsed')) {
			
			//if(j121212('.iconmenu').hasClass('vernav')) {
			if(j121212('.vernav').length > 0) {
				if(j121212('.vernav').hasClass('iconmenu')) {
					j121212('body').addClass('withmenucoll');
					j121212('.iconmenu').addClass('menucoll');
				} else {
					j121212('body').addClass('withmenucoll');
					j121212('.vernav').addClass('menucoll').find('ul').hide();
				}
			} else if(j121212('.vernav2').length > 0) {
			//} else {
				j121212('body').addClass('withmenucoll2');
				j121212('.iconmenu').addClass('menucoll2');
			}
			
			j121212(this).addClass('togglemenu_collapsed');
			
			j121212('.iconmenu > ul > li > a').each(function(){
				var label = j121212(this).text();
				j121212('<li><span>'+label+'</span></li>')
					.insertBefore(j121212(this).parent().find('ul li:first-child'));
			});
		} else {
			
			//if(j121212('.iconmenu').hasClass('vernav')) {
			if(j121212('.vernav').length > 0) {
				if(j121212('.vernav').hasClass('iconmenu')) {
					j121212('body').removeClass('withmenucoll');
					j121212('.iconmenu').removeClass('menucoll');
				} else {
					j121212('body').removeClass('withmenucoll');
					j121212('.vernav').removeClass('menucoll').find('ul').show();
				}
			} else if(j121212('.vernav2').length > 0) {	
			//} else {
				j121212('body').removeClass('withmenucoll2');
				j121212('.iconmenu').removeClass('menucoll2');
			}
			j121212(this).removeClass('togglemenu_collapsed');	
			
			j121212('.iconmenu ul ul li:first-child').remove();
		}
	});
	
	
	
	///// RESPONSIVE /////
	if(j121212(document).width() < 640) {
		j121212('.togglemenu').addClass('togglemenu_collapsed');
		if(j121212('.vernav').length > 0) {
			
			j121212('.iconmenu').addClass('menucoll');
			j121212('body').addClass('withmenucoll');
			j121212('.centercontent').css({marginLeft: '56px'});
			if(j121212('.iconmenu').length == 0) {
				j121212('.togglemenu').removeClass('togglemenu_collapsed');
			} else {
				j121212('.iconmenu > ul > li > a').each(function(){
					var label = j121212(this).text();
					j121212('<li><span>'+label+'</span></li>')
						.insertBefore(j121212(this).parent().find('ul li:first-child'));
				});		
			}

		} else {
			
			j121212('.iconmenu').addClass('menucoll2');
			j121212('body').addClass('withmenucoll2');
			j121212('.centercontent').css({marginLeft: '36px'});
			
			j121212('.iconmenu > ul > li > a').each(function(){
				var label = j121212(this).text();
				j121212('<li><span>'+label+'</span></li>')
					.insertBefore(j121212(this).parent().find('ul li:first-child'));
			});		
		}
	}
	
	
	j121212('.searchicon').live('click',function(){
		j121212('.searchinner').show();
	});
	
	j121212('.searchcancel').live('click',function(){
		j121212('.searchinner').hide();
	});
	
	
	
	///// ON LOAD WINDOW /////
	function reposSearch() {
		if(j121212(window).width() < 520) {
			if(j121212('.searchinner').length == 0) {
				j121212('.search').wrapInner('<div class="searchinner"></div>');	
				j121212('<a class="searchicon"></a>').insertBefore(j121212('.searchinner'));
				j121212('<a class="searchcancel"></a>').insertAfter(j121212('.searchinner button'));
			}
		} else {
			if(j121212('.searchinner').length > 0) {
				j121212('.search form').unwrap();
				j121212('.searchicon, .searchcancel').remove();
			}
		}
	}
	reposSearch();
	
	///// ON RESIZE WINDOW /////
	j121212(window).resize(function(){
		
		if(j121212(window).width() > 640)
			j121212('.centercontent').removeAttr('style');
		
		reposSearch();
		
	});

	
	///// CHANGE THEME /////
	j121212('.changetheme a').click(function(){
		var c = j121212(this).attr('class');
		if(j121212('#addonstyle').length == 0) {
			if(c != 'default') {
//				j121212('head').append('<link id="addonstyle" rel="stylesheet" href="css/style.'+c+'.css" type="text/css" />');
				j121212.cookie("addonstyle", c, { path: '/' });
			}
		} else {
			if(c != 'default') {
//				j121212('#addonstyle').attr('href','css/style.'+c+'.css');
				j121212.cookie("addonstyle", c, { path: '/' });
			} else {
				j121212('#addonstyle').remove();	
				j121212.cookie("addonstyle", null);
			}
		}
	});
	
	///// LOAD ADDON STYLE WHEN IT'S ALREADY SET /////
	if(j121212.cookie('addonstyle')) {
		var c = j121212.cookie('addonstyle');
		if(c != '') {
//			j121212('head').append('<link id="addonstyle" rel="stylesheet" href="css/style.'+c+'.css" type="text/css" />');
			j121212.cookie("addonstyle", c, { path: '/' });
		}
	}
	
	

});