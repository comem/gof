$(document).ready(function(){
var def =$.localise.defaultLanguage = 'de'; 
         
function localise(){
	$('#changeLocale').change(function() { 

		 var newLang = $(this).val();  
		 $.localise('lang/lang', {language: newLang});
		//******** ADD ARTIST
        $('#addArtistHeader1').text(artistHeader); 
        $('#artistInformation1').text(artistInformation);
        $("#artistName1").text(artistNameLabel)
        $("#artistLead1").text(artistLead)
        $("#artistDesc1").text(artistDesc)
        $("#linksTitle").text(theLinksTitle)
        $("#theLinkTitle").text(theLinkTitleLabel)
        $("#theLinkName").text(theLinkName)
        $("#theLinkUrl").text(theLinkUrl)
        $("#imageHeader").text(imageHeader)
        $("#browseExistingImage").text(browseExistingImage)
        $("#uploadNewImage").text(uploadNewImage)
        $("#createNewArtistButton").text(createNewArtistButton)
        $("#createNewGenreButton").text(createNewGenreButton)
        $("#genreHeader").text(genreHeader)
        $("#genreLabel").text(genreLabel)
        $("#artistGenresSelected").text(artistGenresSelected)
        $("#noGenreResultInfo").text(noGenreResultInfo)
        $("#deleteGenreButtonArtist").text(deleteGenreButtonArtist);
        $("#musicianHeader").text(musicianHeader)
        $(".deleteMusician").text(deleteMusician)
        $(".deleteInstrument").text(deleteInstrument)
        $("#artistAddMusicianLabel").text(musicianHeader)

        

       // $("#createNewMusicianButton").text(createNewMusicianButton)

        $("#musicianField").text(musicianField)
        $("#noMusicianResultsInfo").text(noMusicianResultsInfo)
        $("#addToEventArtist").text(addToEventArtist)
        $("#addToEventLabel").text(addToEventLabel)
        $("#artistArrivalHourLabel").text(artistArrivalHourLabel)

        //*****MENU
        $("#addEventMenu").text(addEventMenu)
        $("#addArtistMenu").text(addArtistMenu)
        $("#addMusicianMenu").text(addMusicianMenu)
        $("#addStuffMenu").text(addStuffMenu)
        $("#addLi").text(addLi)
        $("#listLi").text(listLi)
        $("#listEventMenu").text(listEventMenu)
        $("#listArtistMenu").text(listArtistMenu)
        $("#listMusicianMenu").text(listMusicianMenu)
        $("#listStuffMenu").text(listStuffMenu)
        //*******ADD MUSICIAN
        $("#addNewMusicianHeader").text(addNewMusicianHeader)
        $("#newMusicianName").text(newMusicianName)
        $("#newMusicianLastN").text(newMusicianLastN)
        $("#newMusicianStageN").text(newMusicianStageN)
    
        $("#newMusicianInstrument").text(newMusicianInstrument)
        $("#instrumentsPlayed").text(instrumentsPlayed)
        $("#noInstrumentResultInfo").text(noInstrumentResultInfo)
        $("#createNewInstrumentButton").text(createNewInstrumentButton)
        $("#musicianAddToArtist").text(musicianAddToArtist)

        //$("#createNewMusicianButton").text(createNewMusicianButton)


        //********Musician add from artist
        $("#musicianNameTemplate").text(musicianNameTemplate)
        $(".musicianHeaderTemplate").text(musicianTitleTemplate)
     


    }).val($.localise.defaultLanguage).change();
}
localise();
})