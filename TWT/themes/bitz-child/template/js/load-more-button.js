$(document).ready(function() {
	$(".moreBox").hide();
	$(".moreBox").slice(0, 6).show();
    if ($(".blogBox:hidden").length != 0) {
      $("#loadMore").show();
    }   
    $("#loadMore").on('click', function (e) {
      e.preventDefault();
      $(".moreBox:hidden").slice(0, 6).slideDown();
      if ($(".moreBox:hidden").length == 0) {
		  $(".moreBox").show();
        $("#loadMore").fadeOut('slow');
      }
    });
  });
  
  
  
  $(document).ready(function() {
	$(".latestmoreBox").hide();
	$(".latestmoreBox").slice(0, 6).show();
    if ($(".latestblogBox:hidden").length != 0) {
      $("#latestloadMore").show();
    }   
    $("#latestloadMore").on('click', function (e) {
      e.preventDefault();
      $(".latestmoreBox:hidden").slice(0, 6).slideDown();
      if ($(".latestmoreBox:hidden").length == 0) {
		  $(".latestmoreBox").show();
        $("#latestloadMore").fadeOut('slow');
      }
    });
  });