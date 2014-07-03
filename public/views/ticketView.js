var TicketCategoryField = Backbone.View.extend({
            initialize: function(){
              this.listenTo(this.model, 'all', this.render);
            },

           template : _.template(templates.add_ticketCategoryField),
            render: function() {
                this.$el.html(this.template(this.model.toJSON()));
                return this;
            },
            events:{
              "click .deleteTicket": 'deleteTicket'
            },
            deleteTicket: function(evt){

             var index = $(evt.target).attr("data-index")-0
             var ticket = this.model.get('tickets').at(index)
             
            }
        });

var ticketField = new TicketCategoryField({model:ticketsNestedColl})
   