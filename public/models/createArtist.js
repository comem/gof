
   function createArtist(){
     var artistName = $("#nameArtist").val()
     var lead = $("#lead").val()
     var description = $('#artistDescription').val()
     var linkTitle = $('#titleLink').val()
     var linkName = $('#nameLink').val()
     var linkUrl = $('#linkUrl').val()
     var genres;
     var musicians;
     var arrivalHour = $('#arrivalHour').val();

     var artist = new Artist({name: artistName, 
        lead: lead, description: description,linkURL: linkUrl, 
        linkTitle: linkTitle, linkName: linkName })

      var artistNested = artistList.get('artists').where({name: addToArtist});//nested coll
      var artist = artistColl.where({name: addToArtist}) //simple coll

    /*
       if(artist.get('name') != ''){
         if (musician != 0 ){
          if(url != 0){
              //Add instruments
               instrumentsColl.each(function( model ) {
                  var instrument = new Instrument({name: model.attributes.name})
                  musician.get('instruments').add(instrument)
                 });
                //Add to artist collections
                artist[0].attributes.musicians.add(musician) //simple coll
                artistNested[0].attributes.musicians.add(musician)//nested coll

                musician.set({addedToArtist: addToArtist})//set additional attribute (optional)

                 console.log('Addedto nested collection artist');
                 console.log(artistNested[0].attributes.musicians.toJSON());


                 $( "<div title='Add new artist'>").dialog({            
                          buttons: {
                            Close: function() {
                              $(this).dialog( "close" );
                                },
                          }
                        }).append('The artist has been successfully added');
                 }
         }else{//Artist not found
            $( "<div title='Attention!'>").dialog({
                              
                              buttons: {
                                Close: function() {
                                  $(this).dialog( "close" );
                                    },
                              }
                            }).append('Musician not found');}
         }else{// Musician not complete
            artist.isValid();
         }
     */


   }

$(document).ready(function(){
  $('#createNewArtistButton').click(createArtist);

})