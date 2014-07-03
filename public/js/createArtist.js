   function createArtist(){
     var artistName = $("#nameArtist").val()
     var lead = $("#lead").val()
     var description = $('#artistDescription').val()

     var linkTitle = $('#titleLink').val()
     var linkName = $('#nameLink').val()
     var linkUrl = $('#linkUrl').val()
     var arrivalDate= $('#arrivalHour').val();
     var arrivalHour = $('#arrivalHourHour').val();
     var order = $('#order').val();
     var support = $('#support').val();

     //create new Artist
     var artist = new Artist({name: artistName, 
     short_description: lead, complete_description: description })
     //add the links info to the artist
     artist.get('links').set({url :linkUrl, title_de: linkTitle, name_de: linkName})



       if(artist.get('first_name') != ''){
        
          if(linkUrl.length != 0){

            musIns2 = new MusicianInstruments({musician_id: 03003, instrument_id:69})
            // img = new Images({id:23})
            //img2 = new Images({id:22992})
            // artist.get('images').add([img, img2])
            if (support == "yes") {
                  artist.get('night').set({isSupport: 1})
            }if(support=="no"){
              artist.get('night').set({isSupport: 0})
            }
            if(support ==""){

            }

            artist.get('night').set({artist_hour_arrival: arrivalDate+" "+arrivalHour, order: order})
            

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
               artist.save()

               // put the inputs to nothing
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
                   
                    

                    


 
                 $( "<div title='Add new artist'>").dialog({            
                          buttons: {
                            Close: function() {
                              $(this).dialog( "close" );
                                },
                          }
                        }).append('The artist has been successfully added');
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
