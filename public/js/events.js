//var ACTIVE_TAB = 'add';
//var ACTIVE_FORM = "addEvent";
var whichForm = "eventForm";
var addButton = true;
var one = "1";

$(function(){
	var router = new AppRouter ();
	Backbone.history.start({
    pushState: false,
    root: "/zed/"
	});

	// Navigate to deafault form
	console.log("navigate to deafult form");
	$('.musicianTemplate h1').on('click', function(){
		console.log('yeah click on it');
	});
	setTimeout(pageHeight, 2000);
	

	// Scrolling
	$(window).scroll(showAtScroll);

	$('a').click(function () {
    router.navigate($(this).attr('href')); 
    Backbone.history.loadUrl($(this).attr('href'));
    return false;
	});
});


function showMain(href){
	// Btn List
	if (href == 'list') {
		if (addButton) {
			$('#addMain').css({right: '0%'}).animate({right: '100%'});
			$('#listMain').css({right: '-100%'}).animate({right: '0%'});
			addButton = false;
		};
		
	}else{
		// Btn Add
		if (!addButton) {
			$('#listMain').css({right: '0%'}).animate({right: '-100%'});
			$('#addMain').css({right: '100%'}).animate({right: '0%'});
			addButton = true;
		};
	};
	//e.preventDefault(); return false;
}


 function showAtScroll(){
// 	var heightLimit = $(document).scrollTop();
// 	var positionElementInPage = '300';
// 	if ($(window).scrollTop() > 90) {  
		
// 		$('body>div>nav').removeClass('normalNav');
// 		$('body>div>nav').addClass('downNav');

		
		
//        //$('body>div>nav').switchClass('normalNav','downNav',800,'easeOutBounce');
//     } else {

//     	$('body>div>nav').removeClass('downNav');
// 		$('body>div>nav').addClass('normalNav');

		
//   		//$('body>nav').switchClass('normalNav','downNav',0,'easeOutBounce');
// 	};

// 	if($(window).scrollTop()>180){
// 		$('.normalSecondNav').removeClass('normalSecondNav').addClass('downSecondNav');
// 	}else{
// 		$('.downSecondNav').removeClass('downSecondNav').addClass('normalSecondNav');
// 	}
 }


function scrollForm(href){
	console.log('dans form '+href);

	isFocus(href);

	if (href == "event") {
		
		$('.main nav ul li ').css('background-color','#7A664C');
		$('.liEvent').css('background-color','#B39C7F');
		$('.event').animate({left: '0%'});	
		$('.artist').animate({left: '100%'});
		$('.musician').animate({left: '200%'});
		$('.stuff').animate({left: '300%'});	
	};

	if (href == "artist") {

		$('.main nav ul li ').css('background-color','#7A664C');
		$('.liArtist ').css('background-color','#B39C7F');
		$('.event').animate({left: '-100%'});
		$('.artist').animate({left: '0%'});
		$('.musician').animate({left: '100%'});
		$('.stuff').animate({left: '200%'});	
	};

	if (href == "musician") {

		$('.main nav ul li ').css('background-color','#7A664C');
		$('.liMusician').css('background-color','#B39C7F');
		$('.event').animate({left: '-200%'});	
		$('.artist').animate({left: '-100%'});
		$('.musician').animate({left: '0%'});
		$('.stuff').animate({left: '100%'});
	};

	if (href == "stuff") {
		$('.main nav ul li ').css('background-color','#7A664C');
		$('.liStuff').css('background-color','#B39C7F');
		$('.event').animate({left: '-300%'});	
		$('.artist').animate({left: '-200%'});
		$('.musician').animate({left: '-100%'});
		$('.stuff').animate({left: '0%'});
	};

	//e.preventDefault(); return false;
}


function isFocus(href){
	var clicked = false;

	if (href == 'artist') {
		$('.addArtist a').css('backgroud-color','red');
	};
}

function pageHeight(){

	var heightPage = $('#musicianList').height();
	console.log($('#musicianList').height());
	if (heightPage > 2000) {
		console.log(heightPage);
		$('.forms1').css({'height' : heightPage + 300 });
	};
}