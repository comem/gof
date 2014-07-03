var MyModelNestedCollection = Backbone.Model.extend({
            nested: 'collection',
            initialize: function (attrs, options) {
                this.get(this.nested).on('all', function(eventName) {
                    this.trigger(eventName, this);
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

var MusicianInstruments = Backbone.Model.extend({
    defaults: function(){
                return{
                    musician_id:'',
                    instrument_id:''
                 }
            }

})

var MusicianInstrumentsColl = Backbone.Collection.extend({
    model: MusicianInstruments
})


var ArtistNight = Backbone.Model.extend({
    defaults: function(){
                return{
                    order:'',
                    isSupport:'',
                    id:'',
                    artist_hour_arrival:''
                 }
            }

})


var Images = Backbone.Model.extend({
    defaults: function(){
                return{
               
                 id:''
                 }
            }

})
var ImagesColl = Backbone.Collection.extend({
    model: Images
})


//*******************ARTIST MODEL//*******************
        var Artist = MyModelNestedCollection.extend({
            urlRoot: 'http://pingouin.heig-vd.ch/gof/api/v1/artists',
            initialize:function(){
             },
            nested:'musicians',
            nested:'genres',
            nested:'links',
            nested: 'musicianInstruments',
            nested: 'nights',
            nested:'images',

            defaults: function(){
                return{
                    name:'',
                    short_description_de :'',
                    complete_description_de: '',
                    genres: new GenresColl(),
                    night: new ArtistNight(),
                    images: new ImagesColl(),
                    musicians: new MusiciansColl(),
                    musicianInstruments: new MusicianInstrumentsColl(),
                    links : new LinksColl()
                }
            },

            validate: function(attrs, options){
                if(attrs.lead > 300){
                    $( "<div>").dialog({    
                   title: 'Attention!'      ,  
                          buttons: {
                            Close: function() {
                              $(this).dialog( "close" );
                                },
                          }
                        }).append('Lead is too long');
                 
                }
               if(attrs.first_name ==0){
                   $( "<div>").dialog({    
                   title: 'Attention!'      ,  
                          buttons: {
                            Close: function() {
                              $(this).dialog( "close" );
                                },
                          }
                        }).append('Artist name missing');
                 
                }
                if(attrs.linkName==0){
                    $( "<div>").dialog({    
                   title: 'Attention!'      ,  
                          buttons: {
                            Close: function() {
                              $(this).dialog( "close" );
                                },
                          }
                        }).append('Link name missing');
                 
                }
                if(attrs.linkURL==0){
                   $( "<div>").dialog({    
                   title: 'Attention!'      ,  
                          buttons: {
                            Close: function() {
                              $(this).dialog( "close" );
                                },
                          }
                        }).append('URL link missing');
                 
                }
                
            }

        });
        var ArtistColl = Backbone.Collection.extend({
            model:Artist
        }) 
        var artistList = new ArtistColl();


        var ArtistNestedColl = MyModelNestedCollection.extend({
            initialize:function(){
                //this.listenTo(this.model, 'add', this.render);
              },
            nested: 'artists',
            defaults: function(){
                return{
                    artists: new ArtistColl()
                }
            }
        })
        var artistNestedList = new ArtistNestedColl();
        var artistEventNestedList = new ArtistNestedColl()
    
       

//*******************//*******************//**************
//*******************//**********SERVER*********//**************
     
        var ArtistCollServer = Backbone.Collection.extend({
            url: 'http://pingouin.heig-vd.ch/gof/api/v1/artists',
            model: Genre,
            parse: function (response) {
                if (typeof response.data != "undefined") {
                    response = response.data;
                }
               // console.log(response);
                return response;

            }
        });
        var artistCollServer = new ArtistCollServer();


        var ArtistNestedCollServer = MyModelNestedCollection.extend({
            url: 'http://pingouin.heig-vd.ch/gof/api/v1/artists',
            nested:'artists',

            defaults: function(){
                return {
                    artists : new ArtistCollServer()
                }
            },
            parse: function (response) {
            if (typeof response.data != "undefined") {
                response = response.data;
            }
            console.log(response);
            artist = new Artist(response);
            
          
            return artist;
        }
        });
        var artistNestedCollServer = new ArtistNestedCollServer();

        artistNestedCollServer.get('artists').fetch({success: function(){
            console.log('artisnestedSERVER');
            console.log(artistNestedCollServer.toJSON());
        }})


    
