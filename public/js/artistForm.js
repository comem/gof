$.holdReady(true); // Indique à jQuery d'attendre avant l'evt. DOM ready
Modernizr.load({
    test: Modernizr.inputtypes.date,
    nope: 'css/jquery-ui.css',
    complete: function () {
        $.holdReady(false);
    }
});

$(document).ready(function() {

//***********************************
/* MUSICIAN variables */
var autocompleteInput = "#musician";
var autocompleteSource ='searchMusicians.php';
var appendTo = "#musiciansPlaying" //where append autocomplete results to
var showAllButton = "#showAllMusicians";//show all on click autocomplete
var noResultClass ="noResultMusician";
var resultId = "musicianID-";
var resultClass = "musicianResult";
var inputParent = "#musicianSelect";
var updateInput = '.nameMusician'
var deleteWhatText = "musician";
var deleteClass = "deleteMusician";
var deleteButtClass = "delButton";
var addFormButtClass ="add";
var listToBeFilled = "#musiciansPlaying";

var deleteMusicianButton = $(".deleteMusician");
var noResultsMusicianInfo = $("#noMusicianResultsInfo")
var createNewMusisianFormButton =$("#createNewMusicianButton")
var genresSelectedField = $("#genreMusicianSelected");
var noResultsEventtInfo = $("#noEventResultInfo");
//***********************************
//***********************************


//Hide at the beggining
$(listToBeFilled).hide();
noResultsMusicianInfo.hide()
createNewMusisianFormButton.hide();
deleteMusicianButton.hide();
noResultsEventtInfo.hide();
genresSelectedField.hide();

//Ajoute un formulaire d'ajout de MUSICIEN à la page d'event
$(inputParent).on('click',"."+addFormButtClass, addCreateMusicianForm);


//on <typing name> change, update the header too
function updateHeaderInput(inputParent,updateInput){
	$('.forms1').on('keyup' ,updateInput , function(event) {
		var headerName = $(this).val()
		$(this).parent().parent().parent().parent().find('h1').find('.titleMusicianForm').text(headerName)
});
}
updateHeaderInput(inputParent, updateInput);

function deleteAccordion(accordionParent){
	$(accordionParent).on('click', '.deleteMusicianButton', function(){
		/*$( "<div title='Attention!'>").dialog({
				      modal: true,
				      buttons: {
				        Close: function() {
				          $(this).dialog( "close" );
				      		},
				      	Yes: function(){	
				      	}
				      }
					}).append('Do you really want to delete this musician?');*/
		$(this).prev().closest('.ui-accordion').fadeOut("slow", function() { 
					$(this).closest('.ui-accordion').remove();
		});
			$(this).fadeOut('slow', function(){
				$(this).remove()
			});
});

	function checkLeadValid(){
		if(lead.val()>300){
			alert('le lead est trop long!')
		}
	}
}
deleteAccordion('.forms1');

function addCreateMusicianForm(){
	
	var headerToChange = "addArtistHeader";
	var titleToChange = ".titleMusicianForm"
	var formClass ="createMusicianForm";
	var copyInputTo = "nameMusician";
	var inputToHide = "instrumentsPlayed"
	var appendToWhat = ".nextFormArtist";
	
	var render =createNewMusicianForm.render().$el[0].children[0];

	if($('.createMusicianForm').length==0){
		$(render).accordion({collapsible: true, heightStyle: "content"})
		$(render).insertAfter('.nextFormArtist');
	}else{
		$(render).accordion({collapsible: true, heightStyle: "content"})
		$(render).insertAfter('.createMusicianForm:last');
	}
	$('.'+headerToChange+':last').find(titleToChange).text($(autocompleteInput).val());
	$('input[name="nameMusician"]:last').val($(autocompleteInput).val());
	$('.'+inputToHide+':last').hide();
	$('.'+formClass).last().effect('highlight',1000)
	 //go to the created form
	$('body').animate({scrollTop:($('.'+formClass).last().offset().top-50)},500);
 		
}

function removeInfoIfNoResult(input, noResultClass){
	//Gestion de resultats de recherche
	//s-il y en a pas, enlever les info 
	$(input).keypress(function (){
		if( $(input).val() =='' || $(input).length == 0 ){
				$('.'+noResultClass).remove();
		}
});

}
removeInfoIfNoResult(autocompleteInput,noResultClass);

function autocompleteShowAll(buttonName, input){
	//show all on click autocomplete
	$(buttonName).click(function() {
	   $(input).val('')
	   $(input).trigger("focus")
	   .autocomplete("search"); 
});
}


autocompleteShowAll(showAllButton, autocompleteInput);


/*
	you have to change the 	REQUEST.TERM name and the info text in dialog box
	check results button hide and show
*/


function autocomplete(input, source, noResultClass,resultClass,resultId,deleteWhatText, noResultButton, noResButtAppTo,allAppendTo){
var index = 0;
	$(input).autocomplete({
		source: function(request,response){

			$.ajax({
				url:'http://pingouin.heig-vd.ch/gof/api/v1/musicians/search',
				dataType : "json",
				data:{string:request.term},

				success:function(data){
					response($.map(data, function(item){
						return{
							label:item.first_name,
							value: item.first_name,
							stagename: item.stagename,
							id:item.id,
							category :'Musicians'
						}
					}))
				},
				error: function(result,error) {
                    alert("Data musicians not found"+error);
                }
			})
		},
		 messages: {
		        noResults: function(){
		        	//if the create new artist button doesnt exist, add it once
		        	$(noResultButton).slideDown();
		        	$(createNewMusisianFormButton).insertAfter(noResButtAppTo).slideDown()
		        }, 
		        results: function(result) {   
		        	$(noResultButton).slideUp()
		        	$(createNewMusisianFormButton).slideUp()
		        	$('.'+noResultClass).slideUp('fast',function(){
		        		$('.'+noResultClass).remove()
		        	});
		        }
		    },
		minLength: 0, // must be 0 if you want to show all
		dataType : "json",
		select: function(event,ui){
				var selectedObj = ui.item;  
				//console.log(selectedObj);
			
				//if we have already selected a musician, dont add it twice, dialog box
				if($("#"+resultId+selectedObj.id).length>0){
					$( "<div title='Attention!'>").dialog({
				      modal: true,
				      buttons: {
				        Ok: function() {
				          $(this).dialog( "close" );
				      		}
				      }
					}).append('The musician <b>'+selectedObj.value + '</b> (id'+selectedObj.id+') is already in the list!');

				}else{
					
					$(listToBeFilled).show() //show the div we will append to	
					var musician = new Musician({id:selectedObj.id, first_name: selectedObj.value, stagename: selectedObj.stagename })
					allMusicians.add(musician);

					aMusiciansList.get('musicians').add(musician)
					console.log(aMusiciansList.toJSON());

					var render = viewMusiciansPlaying.render().$el
					$(render).appendTo('#musiciansPlaying')
				}
		    }//end select
		});//end autocomplete

		$.ui.autocomplete.prototype._renderItem = function (ul, item) {
					//save data in a dom element 
					$(item.label).data('originalLabel', item.label);
		            item.label = item.label.replace(new RegExp("(^"+$.ui.autocomplete.escapeRegex(this.term) 
		            	+')', "gi"), 
		            "<b style='color:red;'>$1</b>");

		            return $("<li></li>")
		                    .data("item.autocomplete", item)
		                    .append("<a>" + item.label + "</a>")
		                    .appendTo(ul);
		        };
		$.ui.autocomplete.prototype._renderMenu=function( ul, items ) {
		      var that = this,
		        currentCategory = "Musicians";
		      $.each( items, function( index, item ) {
		        if ( item.category != currentCategory ) {
		          ul.append( "<li class='ui-autocomplete-category'>" + 'Musicians' + "</li>" );
		          currentCategory = item.category;
		        }
		        that._renderItemData( ul, item );
		      });
		    };
		//********************************
		//////// END AUTOCOMPLETE
		//************************
}
	
autocomplete(autocompleteInput, autocompleteSource,noResultClass, resultClass,resultId, deleteWhatText, noResultsMusicianInfo, showAllButton,appendTo);	


});//document ready

