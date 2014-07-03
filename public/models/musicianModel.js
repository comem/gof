

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



        var ArtistInstruments = Backbone.Model.extend({
            nested: 'instruments',
            defaults: function(){
                return {
                    artist_id:'',
                    instruments : new InstrumentsColl()
                }
            }

        });

        var ArtistInstrumentsColl = Backbone.Collection.extend({
            model: ArtistInstruments
            
        })

        var PivotMusician = Backbone.Collection.extend({
         //   nested: 'hejj',
             defaults: function(){
                return {
                    artist_id: '',
                    instrument_id:'',
                    musician_id:''
                }
            },

            });


        //Model Musician
        var Musician = MyModelNestedCollection.extend({
            urlRoot: 'http://pingouin.heig-vd.ch/gof/api/v1/musicians',
          
            initialize: function(){
                 //this.listenTo(this.model, 'all', this.render);
            },
            nested:'artistsInstruments',
            defaults: function(){
                return {
                    
                    first_name :'',
                    artistsInstruments : new ArtistInstrumentsColl(),
                    pivot: new PivotMusician(),
                    instruments: new InstrumentsColl(),
                    last_name:'',
                    stagename:''
                }
            },
            validate: function(attributes, options){
                if(attributes.first_name == '' || attributes.first_name.length ==0){
                    $( "<div title='Attention!'>").dialog({
                      
                      buttons: {
                        Close: function() {
                          $(this).dialog( "close" );
                            },
                      }
                    }).append('Fill the musician name');
                }
             },
            parse: function (response) {
                if (typeof response.data != "undefined") {
                    response = response.data;

                }
                musician = new Musician(response);
     
                return response;
            }
        });



        //la collection de tous les musiciens
        var MusiciansColl = Backbone.Collection.extend({
            model: Musician,
            parse: function (response) {
                if (typeof response.data != "undefined") {
                    response = response.data;
                }
                response.comments = new InstrumentsColl(response.comments);
                console.log(response);
                return response;

                  }
            });

        var allMusicians = new MusiciansColl();
    
        //Model qui est une collection des musiciens
       var MusicianNestedColl = MyModelNestedCollection.extend({
            nested: 'musicians',
            defaults: function(){
                return{
                    musicians: new MusiciansColl()
                }
            }
       });
       
     var aMusiciansList = new MusicianNestedColl();


     //*******************//**********SERVER*********//**************
     
        var MusicianCollServer = Backbone.Collection.extend({
            url: 'http://pingouin.heig-vd.ch/gof/api/v1/musicians',
            model: Musician,
            parse: function (response) {
                if (typeof response.data != "undefined") {
                    response = response.data;
                }
                musician = new Musician(response)
                return response;
            }
        });
        var musicianCollServer = new MusicianCollServer();


        var MusicianNestedCollServer = MyModelNestedCollection.extend({
            url: 'http://pingouin.heig-vd.ch/gof/api/v1/musicians',
            nested:'musicians',
            defaults: function(){
                return {
                    musicians : new MusicianCollServer()
                }
            },
            parse: function (response) {
            if (typeof response.data != "undefined") {
                response = response.data;

            }
            musician = new Musician(response)
            return musician;
        }
        });
        var musicianNestedCollServer = new MusicianNestedCollServer();




