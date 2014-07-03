
function autocompleteArtist(){


//var noResultClass = "noResultGenre";
var listToBeFilled = $("#musicianAddedToArtist");
var noResButtAppTo = $("#showAllArtistInMusician");
var artistListMusician = new ArtistNestedColl();
$('#addToArtist').autocomplete({
	source: function(request,response){
			$.ajax({
           	 url: 'http://pingouin.heig-vd.ch/gof/api/v1/artists/search',
				dataType : "json",
				data:{string:request.term},
				success:function(data){
					//console.log(data);	
					response($.map(data, function(item) {
                        // console.log(item.name);
                           return {                    
                               label: item.name,  
                               id: item.id,
                               category :'Artists',   
                           };  
					}))
				},
				error: function(result) {
                    alert("Data artist not found");
                }
			})
		},
		 messages: {
		        noResults: function(){
		        	//if the create new artist button doesnt exist, add it once
		        	$('#noArtistResultInfo').slideDown();
		        	$('.noResult addArtist').insertAfter(noResButtAppTo).slideDown()
		        }, 
		        results: function(result) {   
		        	//$(noResultButton).slideUp()
		        	
		        	$("#noArtistResultInfo").slideUp()
		        	$('.noResult addArtist').slideUp('fast',function(){
		        		$('.noResult addArtist').remove()
		        	});
		        }
		    },
		minLength: 0, // must be 0 if you want to show all
		dataType : "json",
		select: function(event,ui){
				var selectedObj = ui.item;  
			
				//if we have already selected a musician, dont add it twice, dialog box
				if($().length==1){
					$( "<div>").dialog({
						title: 'Attention!',
				      modal: true,
				      buttons: {
				        Ok: function() {
				          $(this).dialog( "close" );
				      		}
				      }
					}).append('The artist <b>'+selectedObj.value + '</b> (id'+selectedObj.id+') is already in the list!');

				}else{
					$(listToBeFilled).show() //show the div we will append to


								var artist = new Artist({name : selectedObj.value, id: selectedObj.id})
								//console.log(artist);
									artistNestedList.get('artists').add(artist)
								
									//console.log(artistNestedList.toJSON());

					
									var renderArtist = artistField.render().$el
									$(renderArtist).appendTo(listToBeFilled)
									listToBeFilled.show()
												
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
		        currentCategory = "";
		      $.each( items, function( index, item ) {
		        if ( item.category != currentCategory ) {
		          ul.append( "<li class='ui-autocomplete-category'>" + item.category + "</li>" );
		          currentCategory = item.category;
		        }
		        that._renderItemData( ul, item );
		      });
		    };
		//********************************
		//////// END AUTOCOMPLETE
		//************************
}


$(document).ready(function() { 

	$("#noArtistResultInfo").hide();
	$(".deleteArtist").hide();
	//$("#createNewGenreButton").hide();
	$("#musicianAddedToArtist").hide();
	$('#chuj').hide()

	autocompleteArtist();
	
	$('#showAllArtistInMusician').click(function() {
	   $('#addToArtist').val('')
	   $('#addToArtist').trigger("focus")
	   .autocomplete("search"); 
	})
	   
	  
});

	//$('body').on('click',"#showAllGenres",autocompleteShowAll)



