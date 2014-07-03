   function createMusician(){    
  var musicianName = $("#nameMusician").val()
     var musicianLastName = $("#lastNameMusician").val()
     var stageName = $('#stagename').val()
    
     var addToArtist = $('#addToArtist').val()

    
   

      if(( musicianName != '' || artistNestedList.toJSON().length != 0 )){ 
        
        if(musicianName != ''){
             if (artistNestedList.toJSON().length != 0 ){
                 //new musician
                    var musician = new Musician({first_name: musicianName, 
                    stagename: stageName, last_name: musicianLastName})
                
                  //add the artist id
                  if (artistNestedList.get('artists').length==0) {
                      $( "<div title='Achtung!'>").dialog({            
                                      buttons: {
                                        Schliesse: function() {
                                          $(this).dialog( "close" );
                                            },
                                      }
                                    }).append('Kein Künstler')
                  };
                    var artistId = artistNestedList.get('artists').at(0).get('id');
                    var artistInstruments = new ArtistInstruments({artist_id: artistId})

                   //Add instruments to the artist from this musician
                    instrumentsColl.each(function( model ) {
                      var instrument = new Instrument({ instrument_id: model.attributes.instrument_id})
                         artistInstruments.get('instruments').add(instrument)
                     });

                  console.log(artistNestedList.toJSON());

                  //add the data to musician (must fit to what the application needs to receive)
                    musician.get('artistsInstruments').add(artistInstruments)                  
                    console.log(JSON.stringify(musician));


                  musician.save( null,{
                      success: function(model, response) {

                    
                            $( "<div title='Add new musician'>").dialog({            
                                      buttons: {
                                        Close: function() {
                                          $(this).dialog( "close" );
                                            },
                                      }
                                    }).append('Der Musiker wurde erfolgreich hinzugefügt')

                          artistNestedList.get('artists').reset()
                                instrumentsNestedColl.get('instruments').reset()

                      
                          $("#instrumentsPlayedMusician").hide()
                          $("#musicianAddedToArtist").hide()

                          instrumentsAddedToMusician.remove()



                            // put the inputs to nothing
                            $("#nameMusician").val('')
                            $("#lastNameMusician").val('')
                            $("#stagename").val('')
                            $("#addToArtist").val('')
                            $("#instrumentMusician").val('')
                            //empty the lists
                            
                            instrumentsColl.reset()
                            console.log(instrumentsColl.toJSON());


       
                            },
                        error: function(model, response) {
                             $( "<div title='Achtung!'>").dialog({            
                                              buttons: {
                                                Schliessen: function() {
                                                  $(this).dialog( "close" );
                                                    },
                                              }
                                            }).append('Etwas ist schief gelaufen!'+response)
                        }
                    });
                          
             }else{//Artist not found
                $( "<div >").dialog({
                  title :'Attention!',
                  buttons: {
                    Close: function() {
                      $(this).dialog( "close" );
                        },
                  }
                }).append('Artist not found');}
       }else{// Musician not complete
        // musician.isValid();
       }
      }else{
           $( "<div >").dialog({
                  title :'Attention!',
                  buttons: {
                    Close: function() {
                      $(this).dialog( "close" );
                        },
                  }
                }).append('Musician name and artist missing');
      }

   }


$(document).ready(function(){
 $("body").on('click',"#createNewMusician",createMusician)
 
})
 