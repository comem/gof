
       var MusicianView = Backbone.View.extend({
            initialize: function(attrs, options){
                 this.listenTo(this.model, 'all', this.render);
                 //this.listenTo(this.model, 'remove', this.logDelete);
                 //this.listenTo(this.model, 'add' ,this.logAdd)
            },
           template : _.template(templates.add_musiciansPlayingField),
            render: function() {
                this.$el.html(this.template(this.model.toJSON()));
                return this;
            },
            events: {
                'click .deleteMusician': 'delete'
            },  
            delete: function (event) {
              var len = aMusiciansList.toJSON().musicians.length;
              if (len == 1)  $('#musiciansPlaying').fadeOut("slow");
   
             var musicianIndex = $(event.target).attr('data-indice');
             var musicianDelete = this.model.get('musicians').at(musicianIndex);
             //remove from nested model
              this.model.get('musicians').remove(musicianDelete);
              //remove from collection
               allMusicians.remove(allMusicians.at(musicianIndex));
            },
            logDelete: function(){
              console.log('deleted from aMusician list nested =')
              console.log(aMusiciansList.toJSON())
              console.log('deleted from all musicians coll = ');
              console.log(allMusicians.toJSON())
            },
            logAdd: function(){
              console.log('added to allMusicians coll=')
              console.log(allMusicians.toJSON());
              console.log('added to musiciansList nested= '+aMusiciansList.toJSON())

            }
        });

       var viewMusiciansPlaying = new MusicianView({model: aMusiciansList})

        var NewMusicianFormView = Backbone.View.extend({
            initialize: function(){
              this.render()
            },

           template : _.template(templates.add_templateMusicien),
            render: function() {
                this.$el.html(this.template(this));
                return this;
            }
        });
     var createNewMusicianForm = new NewMusicianFormView();


     var MusicianSingleView = Backbone.View.extend({
            initialize: function(){
              this.listenTo(this.model, 'all', this.render);
            },

           template : _.template(templates.add_musicianSingleViewTemplate),
            render: function() {
                this.$el.html(this.template(this.model.toJSON()));
                return this;
            }
        });

     var MusicianMultipleView = Backbone.View.extend({
            initialize: function(){
              this.listenTo(this.model, 'all', this.render);
            },

           template : _.template(templates.add_musicianMultipleTemplate),
            render: function() {
                this.$el.html(this.template(this.model.toJSON()));
                return this;
            },
            events:{
              "click .deleteMusicianTemplate": 'deleteMusician'
            },
            deleteMusician: function(evt){

             var index = $(evt.target).attr("data-index")-0
             console.log(index);

             var musician = this.model.get('musicians').at(index)
             musician.destroy();
            }
        });

        musicianList = new MusicianMultipleView({model:musicianNestedCollServer})
   