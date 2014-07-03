   function createEvent(){
    console.log('qweq');
     var eventName = $("#nameEvent").val()
     var startDate = $("#startDate").val()
     var startTime = $('#startTime').val()

     var openingDoorsTime = $('#openingDoorsTime').val()
     var endDate = $('#endDate').val()
     var endHour = $('#endHour').val()
     var mealNotes = $('#mealNotes').val();
     var normalMeals = $('#normalMeals').val();
     var veganMeals = $('#veganMeals').val();
     var ticketPrice = $('#ticketPrice').val()
     var ticketQuantity = $('#ticketQuantity').val();
     var ticketNote = $('#ticketInfo').val();
     var veganMeals = $('#veganMeals').val();
     var complementaryNotes = $('#compInfo').val()
      var placesNumber = $('#placesNumber').val()
      var followed = $("#followed").val()// 0 or 1

     var eventType = $('#eventType').val();
     var ticketType = $('#ticketType').val();
    


     var evento = new EventModel({start_date_hour: startDate+" "+startTime, ending_date_hour: 
      endDate+" "+endHour, opening_doors: openingDoorsTime, nb_meal : normalMeals, nb_vegans_meal: veganMeals,
      meal_notes: mealNotes, nb_places: placesNumber, followed_by_private: followed, 
      notes: complementaryNotes, nighttype_id: eventType})
       
     /*
     evento.get('nighttype').set({id :linkUrl, title_de: linkTitle, name_de: linkName})
     evento.get('ticketcategories').set({})



            if (support == "Yes") {
                  artist.get('night').set({isSupport: 1})
            }else{
              artist.get('night').set({isSupport: 0})
            }

            artist.get('night').set({artist_hour_arrival: arrivalHour, order: order})
            

              //Add artists
               artistList.each(function( model ) {
                  var artist = new Artist({artist_id:model.attributes.id })
                    evento.get('artists').add(artist)
                 });


               console.log(JSON.stringify(evento));
               evento.save()
 
                 $( "<div title='Add new event'>").dialog({            
                          buttons: {
                            Close: function() {
                              $(this).dialog( "close" );
                                },
                          }
                        }).append('The event has been successfully added');

   */
               }
                
$(document).ready(function(){

  $('#submitEvent').on("body",'click',createEvent)
  
})
