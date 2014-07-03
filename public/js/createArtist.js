   function createArtist(){
     var artistName = $("#nameArtist").val()
     var leado = $("#lead").val()
     var descriptione = $('#artistDescription').val()

     var linkTitle = $('#titleLink').val()
     var linkName = $('#nameLink').val()
     var linkUrl = $('#linkUrl').val()
     var arrivalDate= $('#arrivalHour').val();
     var arrivalHour = $('#arrivalHourHour').val();
     var order = $('#order').val();
     var support = $('#support').val();


     //create new Artist
     var artist = new Artist({name: artistName, 
     short_description_de: leado, complete_description_de: descriptione })
     //add the links info to the artist
     artist.get('links').set({url :linkUrl, title_de: linkTitle, name_de: linkName})


console.log(JSON.stringify(artist));


       if(artist.get('first_name') != ''){
        
          if(linkUrl.length != 0){

            if (support == "yes") {
                  artist.get('night').set({isSupport: 1})
            }if(support=="no"){
              artist.get('night').set({isSupport: 0})
            }
            if(support ==""){

            }


        //convert data to the one used in database, us_format
        function formatDate(date,time){

          var euro_date = date;
          euro_date = euro_date.split('.');
          var us_date = euro_date.reverse().join('-');

          var hour = time+':00'
          return us_date+" "+hour
        }

        artist.get('night').set({artist_hour_arrival: formatDate(arrivalDate, arrivalHour), order: order})
      
      
              //Add musicians
               allMusicians.each(function( model ) {
                  var musicianInst = new MusicianInstruments({musician_id: model.attributes.id
                    ,instrument_id:'1' })
                  artist.get('musicianInstruments').add(musicianInst)
                 });


               //Add genres
               genresCollection.each(function( model ) {
                  var genre = new Genre({id: model.attributes.id})
                  artist.get('genres').add(genre)
                });
              
               eventColl2.each(function(model){
                console.log(model);
                  artist.get('night').set({id:model.attributes.id})
               })
               console.log(JSON.stringify(artist));


               artist.save(null,{
                  success: function(model, response) {
                      // put the inputs to nothing
                      genresAddedToArtist.remove()
                      viewMusiciansPlaying.remove()
                      artistToEvent.remove()
                         $("#genresSelected").hide()
                         $("#musiciansPlaying").hide()
                         $("#artistToEvent").hide()

                        $("#nameArtist").val('')
                        $("#lead").val('')
                        $("#artistDescription").val('')
                        $("#titleLink").val('')
                        $("#nameLink").val('')
                        $("#linkUrl").val('')
                        $("#genre").val('')
                        $("#musician").val('')
                        $("#eventName").val('')
                        $("#arrivalHour").val('')
                        $("#order").val('')

                          $( "<div title='Neuer Künstler'>").dialog({            
                              buttons: {
                                Schliessen: function() {
                                  $(this).dialog( "close" );
                                    },
                              }
                            }).append('Der Künstler wurde erfolgreich hinzugefügt');
                  },
                  error: function(model, response) {
                     $( "<div title='Neuer Künstler'>").dialog({            
                                    buttons: {
                                      Schliessen: function() {
                                        $(this).dialog( "close" );
                                          },
                                    }
                                  }).append('Etwas ist schief gelaufen!');
                 
                    
                  }
              });
  

                 }else{
                   $( "<div>").dialog({    
                   title: 'Attention!'      ,  
                          buttons: {
                            Close: function() {
                              $(this).dialog( "close" );
                                },
                          }
                        }).append('URL link missing');
                 }
          }else{// Musician not complete
            artist.isValid();
         }
   }

$(document).ready(function(){

  $('#createNewArtistButton').on('click',createArtist)
  $('.artistTemplate').accordion({collapsible: true, active: false,heightStyle: "content"})


})
