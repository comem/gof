 var ArtistView = Backbone.View.extend({
            initialize: function(attrs, options) {
              this.listenTo(this.model, 'all', this.render);
             },
           template : _.template(templates.add_artistViewTemplate),
            render: function() {
                this.$el.html(this.template(this.model.toJSON()));
                return this;
            }
        });

var ArtistMultipleView = Backbone.View.extend({
            

           template : _.template(templates.add_multipleArtistsTemplate),
            render: function() {
                this.$el.html(this.template(this.model.toJSON()));
                return this;
            }
        });

var multipleArtists = new ArtistMultipleView({model:artistNestedCollServer});


var ArtistFieldInMusician = Backbone.View.extend({
          initialize: function(attrs, options) {
              this.listenTo(this.model, 'all', this.render);
             },
           template : _.template(templates.add_artistsSelectedFieldMusician),
            render: function() {
            this.$el.html(this.template(this.model.toJSON()));
                return this;
            },
            events: {
                'click .deleteArtist': 'delete'
            }, 
            delete: function (event) {
              //ARTIST IN MUSICIAN
                  console.log('MUSICIAN ARTIST');
                 var len = artistNestedList.toJSON().artists.length;
                  if (len == 1)  $('#musicianAddedToArtist').fadeOut("slow");
                
                 var artistIndex = $(event.target).attr('data-indice');
                 
                 var artistDelete = artistNestedList.get('artists').at(artistIndex);
                 //remove from nested model
                  artistNestedList.get('artists').remove(artistDelete);
                  console.log(artistNestedList.toJSON());
              
              //ARTIST IN EVENT
                   var len2 =artistEventNestedList.toJSON().artists.length
                   console.log('EVENT ARTIST');
                   console.log(artistEventNestedList.toJSON());

                   if (len2 == 0)  $('#artistInEvent').fadeOut("slow");
                   var artistEventIndex = $(event.target).attr('data-indice');
                 
                 var artistEventDelete = this.m.get('artists').at(artistEventIndex);
                 //remove from nested model
                  artistEventNestedList.get('artists').remove(artistEventDelete);
                  this.render()
            }
        });


        artistFieldMusician = new ArtistFieldInMusician({model : artistNestedList})
        artistFieldEvent = new ArtistFieldInMusician({model :artistEventNestedList})
       
       



       