var GenreView = Backbone.View.extend({
            initialize: function(attrs, options){
                 this.listenTo(this.model, 'all', this.render);
                 //this.listenTo(this.model, 'remove', this.logDelete);
                 //this.listenTo(this.model, 'add' ,this.logAdd)
            },
           template : _.template(templates.add_genresSelectedFieldArtist),
            render: function() {
                this.$el.html(this.template(this.model.toJSON()));
                return this;
            },
            events: {
                'click .deleteGenre': 'delete'
            },  
            delete: function (event) {
              
              var len = genresNestedColl.toJSON().genres.length;
              if (len == 1)  $('#genresSelected').fadeOut("slow");
            
             var genreIndex = $(event.target).attr('data-indice');
             
             var genreDelete = this.model.get('genres').at(genreIndex);
             //remove from nested model
              this.model.get('genres').remove(genreDelete);
              //remove from collection\
               genresNestedColl.remove(genresNestedColl.at(genreIndex));
            },
            logDelete: function(){
              console.log('deleted from genres  list nested =')
              console.log(aMusiciansList.toJSON())
              console.log('deleted from all genres coll = ');
              console.log(allMusicians.toJSON())
            },
            logAdd: function(){
              console.log('added to genres coll=')
              console.log(allMusicians.toJSON());
              console.log('added to genres nested= '+aMusiciansList.toJSON())

            }
        });

var genresAddedToArtist = new GenreView({model: genresNestedColl});


var ListGenres = Backbone.View.extend({
            initialize: function(attrs, options){
                 this.listenTo(this.model, 'all', this.render);
                 //this.listenTo(this.model, 'remove', this.logDelete);
                 //this.listenTo(this.model, 'add' ,this.logAdd)
            },
           template : _.template(templates.lists_listGenres),
            render: function() {
                this.$el.html(this.template(this.model.toJSON()));
                return this;
            }
            
        });
var genresList = new ListGenres({model : genreNestedCollServer})



$(document).ready(function(){

})