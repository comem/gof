var InstrumentView = Backbone.View.extend({
            initialize: function(attrs, options){
                 this.listenTo(this.model, 'all', this.render);
                 //this.listenTo(this.model, 'remove', this.logDelete);
                 //this.listenTo(this.model, 'add' ,this.logAdd)
            },
           template : _.template(templates.add_instrumentsSelectedFieldMusician),
            render: function() {
                this.$el.html(this.template(this.model.toJSON()));
                return this;
            },
            events: {
                'click .deleteInstrument': 'delete'
            },  
            delete: function (event) {
              
              var len = instrumentsNestedColl.toJSON().instruments.length;
              if (len == 1)  $('#instrumentsPlayedMusician').fadeOut("slow");
            
             var instrumentIndex = $(event.target).attr('data-indice');
             
             var instrumentDelete = this.model.get('instruments').at(instrumentIndex);
             //remove from nested model
              this.model.get('instruments').remove(instrumentDelete);
              //remove from collection\
               instrumentsColl.remove(instrumentsColl.at(instrumentIndex));
            },
            logDelete: function(){
              console.log('deleted from instruments  list nested =')
              console.log(instrumentsNestedColl.toJSON())
              console.log('deleted from all instruments coll = ');
              console.log(instrumentsNestedColl.toJSON())
            },
            logAdd: function(){
              console.log('added to allMusicians coll=')
              console.log(allMusicians.toJSON());
              console.log('added to musiciansList nested= '+aMusiciansList.toJSON())

            }
        });

var instrumentsAddedToMusician = new InstrumentView({model: instrumentsNestedColl});

var ListInstruments = Backbone.View.extend({
            initialize: function(attrs, options){
                 this.listenTo(this.model, 'all', this.render);
                 //this.listenTo(this.model, 'remove', this.logDelete);
                 //this.listenTo(this.model, 'add' ,this.logAdd)
            },
           template : _.template(templates.lists_listInstruments),
            render: function() {
                this.$el.html(this.template(this.model.toJSON()));
                return this;
            }
            
        });

var instrumentsList = new ListInstruments({model : instrumentsNestedCollServer})



$(document).ready(function(){
 
})
