//*** extending Backbone classes

var MyModel = Backbone.Model.extend();
var MyCollection = Backbone.Collection.extend();
var MyView = Backbone.View.extend();
var MyModelNestedCollection = Backbone.Model.extend({
    nested: 'collection',
    initialize: function (attrs, options) {
        this.get(this.nested).on('change', function() {
            this.trigger('change', this);
        }, this);
    },
    toJSON: function() {
        var colObj = {};
        colObj[this.nested] = this.get(this.nested).toJSON();
        return _.extend(
            Backbone.Model.prototype.toJSON.apply(this, arguments),
            colObj
        );
    }
});


 // Create a modal view class
var Modal = Backbone.Modal.extend({
    template: _.template(templates.add_uploadImage),
    cancelEl: '.bbm-button',
    events:{
        "click  #selectable li img" : 'imageSelect',
        "click  #imageUpload"       : 'uploadImage'
       
    },
    imageSelect:function(event){
        var genreIndex = $(event.target).attr('id');
        var id = $(event.target).attr('id');  
        console.log($(event.target).attr('id'));
        console.log(genreIndex);
        $('#selectable li img').css('border','none');
        $(event.target).css('border','2px solid red');
    },
    imageUpload:function(){
        console.log('imageupload');
        $('#selectable li img').css('border','none');
    }
});


var Header = MyView.extend({
    template: _.template(templates.main_header),
    render:function(){
        this.$el.html(this.template());
        return this;
    }
});

var Home = MyView.extend({
    template: _.template(templates.main_home),
    render:function(){
        this.$el.html(this.template());
        return this;
    }
});

var Nav = MyView.extend({
    template: _.template(templates.main_nav),
    render:function(){
        this.$el.html(this.template());
        return this;
    }
});

var Add = MyView.extend({
    template: _.template(templates.main_add),
    render:function(){
        this.$el.html(this.template());
        return this;
    }
});

var AddNav = MyView.extend({
    template: _.template(templates.main_addSecondNav),
    render:function(){
        this.$el.html(this.template());
        return this;
    }
});

var List = MyView.extend({
    template: _.template(templates.main_list),
    render:function(){
        this.$el.html(this.template());
        return this;
    }
});

var ListNav = MyView.extend({
    template: _.template(templates.main_listSecondNav),
    render:function(){
        this.$el.html(this.template());
        return this;
    }
});

var EventList = MyView.extend({
    template: _.template(templates.lists_listEvent),
    render:function(){
        this.$el.html(this.template());
        return this;
    }
});

var ArtistList = MyView.extend({
    template: _.template(templates.lists_listArtist),
    render:function(){
        this.$el.html(this.template());
        return this;
    }
});


/*
 musicianNestedCollServer.get('musicians').fetch({
        success:function(){

           musicianList = new MusicianMultipleView({model:musicianNestedCollServer})
           musicianList.render().$el.appendTo('#musicianList')
            $('.myAccordion').accordion({collapsible: true, active: false,heightStyle: "content"})

           
        }
    })
*/
var MusicianList = MyView.extend({
    template: _.template(templates.lists_listMusician),
    render:function(){
        this.$el.html(this.template());
        return this;
    },
    loadStuff: function(){
        var self = this;
        musicianNestedCollServer.get('musicians').fetch({
            xhr: function() {

                var xhr = $.ajaxSettings.xhr();
                xhr.onprogress = self.handleProgress;
                return xhr;
            }
        });
    },
    handleProgress: function(evt){
        var percentComplete = 0;
        if (evt.lengthComputable) {  
            percentComplete = evt.loaded / evt.total;
            
        }
        if(percentComplete ==100){

           musicianList = new MusicianMultipleView({model:musicianNestedCollServer})
           musicianList.render().$el.appendTo('#musicianList')
            $('.myAccordion').accordion({collapsible: true, active: false,heightStyle: "content"})

        }
        console.log(Math.round(percentComplete * 100)+"%");
    }

});



var StuffList = MyView.extend({
    template: _.template(templates.lists_listStuff),
    render:function(){
        this.$el.html(this.template());
        return this;
    }
});

///°°°°° ADD STUFF °°°°/////
var AddStuff = MyView.extend({
    template: _.template(templates.add_addStuff),
    render:function(){
        this.$el.html(this.template());
        return this;
    },
    
    events:{
        "click  #stuffGenreButton" : 'addGenre',
        "click  #stuffInstrumentButton" : 'addInstrument',
        "click  #stuffEventButton" : 'addEvent',
        "click  #stuffTicketButton" : 'addTicket'
    },

    ///ADD GENRE///
    addGenre: function(){
       var name = this.$el.find("input[name='stuffGenre']").val();
       var genre = new Genre({name_de: name})
       if(name==''){
        $( "<div >").dialog({
                  title :'Genre',

                  buttons: {
                    Close: function() {
                      $(this).dialog( "close" );
                        },
                        
                  },

                }).append('Veuillez remplir le champ');

       }else{
        genre.save()
       $( "<div >").dialog({
                  title :'Genre',
                  buttons: {
                    Close: function() {
                      $(this).dialog( "close" );
                        },
                  }
                }).append('Votre genre a été crée');
       $("input[name='stuffGenre']").val('');
       }
    },
    ///ADD INSTRUMENT///
    addInstrument: function(){
        var name = this.$el.find("input[name='stuffInstrument']").val();
       var instrument = new Instrument({name_de: name})
       if(name==''){
        $( "<div >").dialog({
                  title :'Instrument',
                  buttons: {
                    Close: function() {
                      $(this).dialog( "close" );
                        },
                  }
                }).append('Veuillez remplir le champ');

       }else{
        instrument.save()
       $( "<div >").dialog({
                  title :'Instrument',
                  buttons: {
                    Close: function() {
                      $(this).dialog( "close" );
                        },
                  }
                }).append('Votre instrument a été crée');
       $("input[name='stuffInstrument']").val('');
       }

    },
    ///ADD TICKET TYPE///
    addTicket: function(){
        var name = this.$el.find("input[name='stuffTicketType']").val();
       var ticket = new Ticket({type: name})
       
       if(name==''){
        $( "<div >").dialog({
                  title :'TicketType',
                  buttons: {
                    Close: function() {
                      $(this).dialog( "close" );
                        },
                  }
                }).append('Veuillez remplir le champ');

       }else{
        ticket.save()
       $( "<div >").dialog({
                  title :'TicketType',
                  buttons: {
                    Close: function() {
                      $(this).dialog( "close" );
                        },
                  }
                }).append('Votre ticket a été crée');
       $("input[name='stuffTicketType']").val('');
       }

    },
    ///ADD EVENT TYPE///
    addEvent: function(){
        var name = this.$el.find("input[name='stuffEventType']").val();
       var eventType = new EventType({type: name})
       
       if(name==''){
        $( "<div >").dialog({
                  title :'EventType',
                  buttons: {
                    Close: function() {
                      $(this).dialog( "close" );
                        },
                  }
                }).append('Veuillez remplir le champ');

       }else{
        eventType.save()
       $( "<div >").dialog({
                  title :'EventType',
                  buttons: {
                    Close: function() {
                      $(this).dialog( "close" );
                        },


                  }
                }).append('Votre typeEvent a été crée');
       $("input[name='stuffEventType']").val('');
       }


    }
});

var EventAdd = MyView.extend({
    template: _.template(templates.add_addEvent),
    render:function(){
        this.$el.html(this.template());
        return this;
    },
    events:{
        "click  .popup-with-form" : 'popup', 
        "click #submitEvent" : 'createEvent',
        "keydown #artistName" : 'autocompleteArtist',
        "click .showAll" : 'showAll',
        "click #showAllTypes" : 'showAllTypes',
        "keydown #eventTypeInput" : 'autocompleteEventType',
        "keydown #ticketCategory" : 'autocompleteTicketCategory',
    },  
    showAll: function(){
        
       $('#artistName').val('')
       $('#artistName').trigger("focus")
       .autocomplete("search"); 
        
    },
    showAllTypes: function(){
        
           $('#eventTypeInput').val('')
           $('#eventTypeInput').trigger("focus")
           .autocomplete("search"); 
        
    },
    autocompleteEventType: function(){
        var listToBeFilled = $("#eventTypesField");
            $('#eventTypeInput').autocomplete({
        source: function(request,response){
                $.ajax({
                 url: 'http://pingouin.heig-vd.ch/gof/api/v1/nighttypes/search',
                    dataType : "json",
                    data:{string:request.term},
                    success:function(data){
                        console.log(data);    
                        response($.map(data, function(item) {
                            // console.log(item.name_de);
                               return {                    
                                   label: item.name_de,  
                                   value: item.name_de,
                                   id: item.id,
                                   category :'Event type',
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
                        $('#noTypeEventResultInfo').slideDown();
                        //$('.noResult addArtist').insertAfter(noResButtAppTo).slideDown()
                    }, 
                    results: function(result) {   
                        //$(noResultButton).slideUp()
                        
                        $("#noTypeEventResultInfo").slideUp()
                        $('.noResult deleteTypeEvent').slideUp('fast',function(){
                        $('.noResult deleteTypeEvent').remove()
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
                        }).append('The type <b>'+selectedObj.value + '</b> (id'+selectedObj.id+') is already in the list!');

                    }else{
                        $(listToBeFilled).show() //show the div we will append to
     
                            var eventType = new NightType ({id:selectedObj.id, name_de: selectedObj.value})
                            nightTypeNestedColl.get('nighttype').add(eventType)
                            console.log(nightTypeNestedColl.toJSON());
                            eventTypeField.render().$el.appendTo('#eventTypesField')
            
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

    },
    popup: function (e) {
         e.preventDefault();
         console.log("yeah");
         $('.popup-with-form').magnificPopup({
              disableOn: 700,
              type: 'inline',
              removalDelay: 160,
              preloader: false,
              fixedContentPos: false
         });
      },
    createEvent: function (){
     var eventName = $("#nameEvent").val()
     var startDate = $("#startDate").val()
     var startTime = $('#startTime').val()

     var openingDoorsTime = $('#openingDoorsTime').val()
     var endDate = $('#endDate').val()
     var endHour = $('#endTime').val()
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
   
     if (followed == "Yes") {
        followed = true
     }else{
        followed = false;
     };
     //get night type id
     var nighttypeid = nightTypeNestedColl.get('nighttype').at(0).get('id')
  
     var evento = new EventModel({title_de: eventName, start_date_hour: startDate+" "+startTime, ending_date_hour: 
      endDate+" "+endHour, opening_doors:startDate +" "+openingDoorsTime, nb_meal : normalMeals, nb_vegans_meal: veganMeals,
      meal_note: mealNotes, nb_places: placesNumber, followed_by_private: followed, 
      notes: complementaryNotes,nighttype_id: nighttypeid});

     //add platforms
     var isCheckedFacebook =  $("input[value='facebook']").is(":checked")
     var isCheckedTwitter =  $("input[value='twitter']").is(":checked")

      if (isCheckedFacebook) {
        platformid = 1
        facebook = new Platform({platform_id: platformid})
        evento.get('platforms').add(facebook)
      };
      if (isCheckedTwitter) {
        platformid  = 2
        twitter = new Platform({platform_id: platformid})
        evento.get('platforms').add(twitter)
      };
      //add ticket 
      var ticketId = ticketsNestedColl.get('tickets').at(0).get('id')
     var ticket = new Ticket({amount: ticketPrice, comment: ticketNote, ticket_categorie_id: ticketId, quantitySold: ticketQuantity})


     evento.get('ticket_categorie').add(ticket)
    
     //addArtists
      artistEventNestedList.get('artists').each(function( model ) {
                    var artist = new Artist({id: model.attributes.id, name:model.attributes.name, 
                    artist_hour_arrival: '2014-01-03 10:01:01', is_support:0})
                    evento.get('artists').add(artist)
      });
       
   
          console.log(JSON.stringify(evento));
        evento.save()


               },
    autocompleteArtist: function(){

        var listToBeFilled = $("#artistInEvent");
        var noResButtAppTo = $("#addArtistButton");
        var artistListMusician = new ArtistNestedColl();
        $('#artistName').autocomplete({
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
                            $('#noArtistEventResultInfo').slideDown();
                            //$('.noResult addArtist').insertAfter(noResButtAppTo).slideDown()
                        }, 
                        results: function(result) {   
                            //$(noResultButton).slideUp()
                            
                            $("#noArtistEventResultInfo").slideUp()
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
                                    artistEventNestedList.get('artists').add(artist)
                                
                                    console.log(artistEventNestedList.toJSON());

                    
                                    var renderArtist = artistFieldEvent.render().$el
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

    },
    autocompleteTicketCategory: function(){

        //var noResultClass = "noResultGenre";
        var listToBeFilled = $("#ticketCategoryField");
        var noResButtAppTo = $("#addArtistButton");

        $('#ticketCategory').autocomplete({
            source: function(request,response){
                    $.ajax({
                     url: 'http://pingouin.heig-vd.ch/gof/api/v1/ticketcategories/search',
                        dataType : "json",
                        data:{string:request.term},
                        success:function(data){
                            //console.log(data);    
                            response($.map(data, function(item) {
                                
                                   return {                    
                                       label: item.name_de,  
                                       value: item.name_de,
                                       id: item.id,
                                       category :'Ticket category'   
                                   };  
                            }))
                        },
                        error: function(result) {
                            alert("Data ticket category not found");
                        }
                    })
                },
                 messages: {
                        noResults: function(){
                            //if the create new artist button doesnt exist, add it once
                            $('#noTicketCategoryResultInfo').slideDown();
                            //$('.noResult addArtist').insertAfter(noResButtAppTo).slideDown()
                        }, 
                        results: function(result) {   
                            //$(noResultButton).slideUp()
                            
                            $("#noTicketCategoryResultInfo").slideUp()
                            
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
                    }).append('The ticket category <b>'+selectedObj.value + '</b> (id'+selectedObj.id+') is already in the list!');

                }else{
                    
                    $(listToBeFilled).show() //show the div we will append to

                    var ticket = new Ticket({name : selectedObj.value, id: selectedObj.id})
                    
                    ticketsNestedColl.get('tickets').add(ticket)
                    console.log(ticketsNestedColl.toJSON());

  
    
                    var renderTicket = ticketField.render().$el
                    $(renderTicket).appendTo(listToBeFilled)
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
               
    
    
});

var ArtistAdd = MyView.extend({
    template: _.template(templates.add_addArtist),
    render:function(){
        this.$el.html(this.template());
        return this;
    },
    events:{
        "keyup input[name='nameLink']" : 'checkLinkName',
        "keyup input[name='url']" :'checkURL',
        "keyup input[name='nameArtist']" : 'checkName',
    },
    checkName : function(){
        var input = this.$el.find("input[name='nameArtist']");
        var artistName = this.$el.find("input[name='nameArtist']").val()
        if(artistName =='') {
            input.css('border', 'solid 2px red')
        }else{
            input.css('border', 'none')
        }  
    },
    checkURL: function(){
        var input =this.$el.find("input[name='url']")
        var url  =this.$el.find("input[name='url']").val()
        if(url ==''){
            input.css('border', 'solid 2px red')
        }else{
            input.css('border', 'none')
        }  
    },
    checkLinkName: function(){
        var input = this.$el.find("input[name='nameLink']")
        var linkNake  =this.$el.find("input[name='nameLink']").val()
        if(linkNake.length == 0){
             input.css('border', 'solid 2px red')
        }else{  
             input.css('border', 'none')
        }
    }
});

var MusicianAdd = MyView.extend({
    template: _.template(templates.add_addMusician),
    render:function(){
        this.$el.html(this.template());
        return this;
    },
    events:{
        "keyup input[name='nameMusician']" : 'checkFirstname',
        "keyup input[name='stagename']" :'checkStagename',
        "keyup input[name='lastNameMusician']" : 'checkLastname',
    },
    checkFirstname : function(){
        var input = this.$el.find("input[class='nameMusician']");
        var musicianFirstName = this.$el.find("input[class='nameMusician']").val()
        if(musicianFirstName =='') {
            input.css('border', 'solid 2px red')
        }else{
            input.css('border', 'none')
        }  
    },
    checkStagename: function(){
        var input =this.$el.find("input[name='stagename']")
        var stagename  =this.$el.find("input[name='stagename']").val()
        if(stagename !=''){
            //tick
        } 
    },
    checkLastname: function(){
        var input = this.$el.find("input[name='lastNameMusician']")
        var musicianLastName  =this.$el.find("input[name='lastNameMusician']").val()
        if(musicianLastName.length == 0){
             input.css('border', 'solid 2px red')
        }else{  
             input.css('border', 'none')
        }
    }

});


var header = new Header();
var home = new Home();
var nav = new Nav();
var add = new Add();
var list = new List();

var addSecondNav = new AddNav();
var listSecondNav = new ListNav();

var eventList = new EventList();
var artistList = new ArtistList();
var musicianList = new MusicianList();
musicianList.loadStuff()
var stuffList = new StuffList();

var addEvent = new EventAdd();
var addArtist = new ArtistAdd();

var addMusician = new MusicianAdd();
var addStuff = new AddStuff()


$(function(){
    
    header.render().$el.appendTo('body');    
    nav.render().$el.appendTo('body');
    add.render().$el.insertAfter('.normalNav');
    list.render().$el.insertAfter('#addMain');
    addSecondNav.render().$el.insertBefore('#formsAdd');
    listSecondNav.render().$el.appendTo('#listMain');

    eventList.render().$el.appendTo('#formsList');
    artistList.render().$el.appendTo('#formsList');
    musicianList.render().$el.appendTo('#formsList');
    stuffList.render().$el.appendTo('#formsList');

    addEvent.render().$el.appendTo('#formsAdd');
    addArtist.render().$el.appendTo('#formsAdd');
    addMusician.render().$el.appendTo('#formsAdd');
    addStuff.render().$el.appendTo('#stuffForm');


   
/*
artistNestedCollServer.get('artists').fetch({
    success:function(){
<<<<<<< HEAD
    //    render = ArtistMultipleView({model:artistNestedCollServer})
       // render.render().$el.appendTo('#artistList')
=======
       var render = ArtistMultipleView({model:artistNestedCollServer})
        render.render().$el.appendTo('#artistList')
>>>>>>> master
    }
})
*/
//single musician render
/*
musician1view.render().$el.appendTo('#eventForm')
musician2view.render().$el.appendTo('#eventForm')
musician3view.render().$el.appendTo('#eventForm')
*/
//single artist render
/*
 rammsteinView.render().$el.appendTo('#eventForm');
 chopintView.render().$el.appendTo('#eventForm');
 starWarsBandView.render().$el.appendTo('#eventForm');

//single event render
/*
starWarsView.render().$el.appendTo('#eventForm')
lastEventView.render().$el.appendTo('#eventForm')
montreuxView.render().$el.appendTo('#eventForm')
*/
//multiple render
/*
multipleArtists.render().$el.appendTo('#artistList');
multipleEvents.render().$el.appendTo('#eventList');
multipleMusicians.render().$el.appendTo('#musicianList')
*/

//artist
$("#arrivalHourHour").timepicker({'scrollDefaultNow': true, 'timeFormat': 'H:i'})
$("#arrivalHour").datepicker({dateFormat: 'dd.mm.yy',changeMonth: true, changeYear: true})
//events 
$("#startDate").datepicker({dateFormat: 'dd.mm.yy',changeMonth: true,
      changeYear: true})
$("#endDate").datepicker({dateFormat: 'dd.mm.yy',changeMonth: true,
      changeYear: true})
$("#openingDoorsTime").timepicker({'scrollDefaultNow': true, 'timeFormat': 'H:i'})

$("#startTime").timepicker({'scrollDefaultNow': true, 'timeFormat': 'H:i'})
$("#endTime").timepicker({'scrollDefaultNow': true, 'timeFormat': 'H:i'})




$('.myAccordion').accordion({collapsible: true, active: false,heightStyle: "content"})

 genresList.render().$el.appendTo('#stufflist');
 instrumentsList.render().$el.appendTo('#stufflist');

 $('.open').on('click', function(){

        // Render an instance of your modal
        var modalView = new Modal();
        $('.app').html(modalView.render().el);





});
$(".deleteArtistEvent").hide()
$("#artistInEvent").hide()
$("#noArtistEventResultInfo").hide()
$("#eventTypesField").hide()
$("#noTypeEventResultInfo").hide()
$(".deleteTypeEvent").hide()

$("#ticketCategoryField").hide()
$("#noTicketCategoryResultInfo").hide()
$
$(".buttonsListMusician").click(function(event){
    event.stopPropagation();
});




});
