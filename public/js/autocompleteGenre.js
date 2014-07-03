

function autocompleteGenre(){
var noResultClass = "noResultGenre";
var listToBeFilled = $("#genresSelected");
var noResButtAppTo = $("#showAllGenres");

$('#genre').autocomplete({
		source: function(request,response){
			$.ajax({
				url:'http://pingouin.heig-vd.ch/gof/api/v1/genres/search',
				dataType : "json",
				data:{string:request.term},
				success:function(data){
					//console.log(data);
					response($.map(data, function(item){
					
						return{
							label:item.name_de,
							value: item.name_de,
							id: item.id
						
						}
					}))
				},
				error: function(result) {
                    alert("Data genre not found");
                }
			})
		},
		 messages: {
		        noResults: function(){
		        	//if the create new artist button doesnt exist, add it once
		        	$('#noGenreResultInfo').slideDown();
		        	$('#createNewGenreButton').insertAfter(noResButtAppTo).slideDown()
		        }, 
		        results: function(result) {   
		        	//$(noResultButton).slideUp()
		        	$('#createNewGenreButton').slideUp()
		        	$("#noGenreResultInfo").slideUp()
		        	$('.noResult addGenre').slideUp('fast',function(){
		        		$('.noResult addGenre').remove()
		        	});
		        }
		    },
		minLength: 0, // must be 0 if you want to show all
		
		select: function(event,ui){
				var selectedObj = ui.item 
			//console.log(selectedObj.value);
			
				//if we have already selected a musician, dont add it twice, dialog box
				if($("#genreResult"+selectedObj.id).length>0){
					$( "<div>").dialog({
						title: 'Attention!',
				      modal: true,
				      buttons: {
				        Ok: function() {
				          $(this).dialog( "close" );
				      		}
				      }
					}).append('The genre <b>'+selectedObj.value + '</b> (id'+selectedObj.id+') is already in the list!');

				}else{
					//console.log(selectedObj.label.data('originalLabel'));
					$(listToBeFilled).show() //show the div we will append to
					var genre = new Genre({name_de: selectedObj.value, id:selectedObj.id})
					
					genresCollection.add(genre);
					genresNestedColl.get('genres').add(genre);

					console.log(genresNestedColl.toJSON());

					var renderGenre = genresAddedToArtist.render().$el
					$(renderGenre[0]).appendTo(listToBeFilled)
					//console.log(aMusiciansList.toJSON())
					
				}
		    }//end select
});//end autocomplete

		$.ui.autocomplete.prototype._renderItem = function (ul, item) {
					
					console.log(item); 
					$(item).data('originalLabel', item.label);
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

	$("#noGenreResultInfo").hide();
	$(".deleteGenre").hide();
	$("#createNewGenreButton").hide();
	$("#genresSelected").hide();
	autocompleteGenre();
	$('#showAllGenres').click(function() {
	   $('#genre').val('')
	   $('#genre').trigger("focus")
	   .autocomplete("search"); 
	  
});

	$('body').on('click',"#showAllGenres",autocompleteShowAll)




});

function autocompleteShowAll(){

	//show all on click autocomplete
	$('#showAllGenres').click(function() {
	   $('#genre').val('')
	   $('#genre').trigger("focus")
	   .autocomplete("search"); 
	  
});
}