var tdScrollToClass={};
(function(){tdScrollToClass={items:[],item:function(){this.handlerObj=void 0;this._is_initialized=!1},init:function(){tdScrollToClass.items=[]},_initialize_item:function(a){!0!==a._is_initialized&&(a.handlerObj.on("click",function(a){a.preventDefault();a.stopImmediatePropagation();jQuery("body").removeClass("td-menu-mob-open-menu");var b=jQuery(this),c=b.offset(),d=b.data("scroll-to-class");a=tdScrollToClass.determineCurrOffset(b.data("scroll-offset"));var e=b.data("scroll-target");if("undefined"===
typeof a||""===a)a=0;if("undefined"!==typeof d&&""!==d){var f=jQuery("."+d);768>tdEvents.window_innerWidth?setTimeout(function(){tdScrollToClass.td_helper_scroll_to_class(b,f,c,0,e,d)},500):tdScrollToClass.td_helper_scroll_to_class(b,f,c,a,e,d)}}),a._is_initialized=!0)},addItem:function(a){if("undefined"===typeof a.handlerObj)throw"item.rowUid is not defined";tdScrollToClass.items.push(a);tdScrollToClass._initialize_item(a)},resetItems:function(){jQuery(window).unbind("resize.scrollToClassResize").unbind("scroll.scrollToClassScroll");
tdScrollToClass.items=[]},manageActiveClasses:function(){var a=jQuery(window),e=jQuery("body"),b=tdScrollToClass.items;b.length&&(a.bind("resize.scrollToClassResize",function(){b.forEach(function(c){var d=c.handlerObj,g=d.data("scroll-to-class"),f=tdScrollToClass.determineCurrOffset(d.data("scroll-offset")),h=b[jQuery.inArray(c,b)+1];a.bind("scroll.scrollToClassScroll",function(){var a=!1;e.find("."+g).map(function(b,c){b=jQuery(c);tdScrollToClass.isScrolledIntoView(b,f)&&(a=!0);if("undefined"!==
typeof h){b=h.handlerObj;c=e.find("."+b.data("scroll-to-class"));var d=tdScrollToClass.determineCurrOffset(b.data("scroll-offset"));c.map(function(b,c){b=jQuery(c);tdScrollToClass.isScrolledIntoView(b,d)&&(a=!1)})}});a?d.hasClass("td-scroll-in-view")||d.addClass("td-scroll-in-view"):d.hasClass("td-scroll-in-view")&&d.removeClass("td-scroll-in-view")});a.scroll()})}),a.resize())},td_helper_scroll_to_class:function(a,e,b,c,d,g){e.length?(e=e.offset(),b=400*Math.floor(Math.abs(b.top-e.top)/100),1500<
b?b=1500:500>b&&(b=500),tdUtil.scrollToPosition(e.top+c,b),a=a.parent().parent("li.menu-item"),a.length&&(a.siblings(".current-menu-item").removeClass("current-menu-item"),a.addClass("current-menu-item")),jQuery("body").removeClass("td-menu-mob-open-menu")):"undefined"!==typeof d&&""!==d&&(td_set_cookies_life(["td-cookie-scroll-to-class",g,864E5]),td_set_cookies_life(["td-cookie-scroll-offset",c,864E5]),jQuery("body").removeClass("td-menu-mob-open-menu"),window.location=d)},isScrolledIntoView:function(a,
e){var b=jQuery(window),c=b.scrollTop(),d=0;jQuery("body").hasClass("admin-bar")&&782<=b.width()&&(d=jQuery("#wpadminbar").height());b=a.offset().top-d;a=b+a.outerHeight();0>e&&(b+=e);return b<=c&&a>=c},determineCurrOffset:function(a){if("undefined"===typeof a||""===a)return 0;var e=jQuery("body"),b=tdViewport.getCurrentIntervalIndex();e=e.hasClass("admin-bar")?0!==b?32:46:0;if(/^(?:[A-Za-z0-9+/]{4})*(?:[A-Za-z0-9+/]{2}==|[A-Za-z0-9+/]{3}=|[A-Za-z0-9+/]{4})$/.test(a)){var c=JSON.parse(atob(a));switch(b){case 0:a=
"undefined"!==typeof c.phone?parseInt(c.phone):a;break;case 1:a="undefined"!==typeof c.portrait?parseInt(c.portrait):a;break;case 2:a="undefined"!==typeof c.landscape?parseInt(c.landscape):a;break;case 3:a="undefined"!==typeof c.all?parseInt(c.all):a}}return a+e}}})();
