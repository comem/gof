
function autocompleteEvent(){
var noResultClass = "noResultEvent";
var listToBeFilled = $("#artistToEvent");
var noResButtAppTo = $("#showAllEvents");

$('#eventName').autocomplete({
		source: function(request,response){
			$.ajax({
				url:'http://pingouin.heig-vd.ch/gof/api/v1/nights/search',
				dataType : "json",
				data:{string:request.term},
				success:function(data){
					//console.log(data);
					response($.map(data, function(item){
					
						return{
							label:item.title_de,
							value: item.title_de,
							id: item.id
						
						}
					}))
				},
				error: function(result) {
                    alert("Data event not found");
                }
			})
		},
		 messages: {
		        noResults: function(){
		        	//if the create new artist button doesnt exist, add it once
		        	$('#noEventResultInfo').slideDown();
		        	$('#createNewEvent').insertAfter(noResButtAppTo).slideDown()
		        }, 
		        results: function(result) {   
		        	//$(noResultButton).slideUp()
		        	$('#createNewGenreButton').slideUp()
		        	$("#noEventResultInfo").slideUp()
		        	$('.noResult addEvent').slideUp('fast',function(){
		        		$('.noResult addEvent').remove()
		        	});
		        }
		    },
		minLength: 0, // must be 0 if you want to show all
		
		select: function(event,ui){
				var selectedObj = ui.item 
			//console.log(selectedObj.value);
			
				//if we have already selected a musician, dont add it twice, dialog box
				if($("#eventResult"+selectedObj.id).length>0){
					$( "<div>").dialog({
						title: 'Attention!',
				      modal: true,
				      buttons: {
				        Ok: function() {
				          $(this).dialog( "close" );
				      		}
				      }
					}).append('The event <b>'+selectedObj.value + '</b> (id'+selectedObj.id+') is already in the list!');

				}else{
					//console.log(selectedObj.label.data('originalLabel'));
					$(listToBeFilled).show() //show the div we will append to
					var evento = new EventModel({title_de: selectedObj.value, id:selectedObj.id})
					
					eventColl2.add(evento);
					eventsNestedColl2.get('events').add(evento);

					console.log(eventsNestedColl2.toJSON());

					//var artistToEvent = new EventFieldArtist({model : eventsNestedColl2})
					artistToEvent.render().$el.appendTo(listToBeFilled)
					
					
					
				}
		    }//end select
});//end autocomplete

		$.ui.autocomplete.prototype._renderItem = function (ul, item) {
					
			 
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

	$("#artistToEvent").hide();
	$(".deleteEvent").hide();
	$("#createNewEvent").hide();
	

	$('#showAllEvents').click(function() {
	   $('#eventName').val('')
	   $('#eventName').trigger("focus")
	   .autocomplete("search"); 
	  
});




autocompleteEvent()

});

