var ImageView = Backbone.View.extend({
            initialize: function(attrs, options){
                 this.listenTo(this.model, 'all', this.render);
                 //this.listenTo(this.model, 'remove', this.logDelete);
                 //this.listenTo(this.model, 'add' ,this.logAdd)
            },
           template : _.template(templates.lists_listImage),
            render: function() {
                this.$el.html(this.template(this.model.toJSON()));
                return this;
            }
            
        });


var imageView = new ImageView({model:ImagesCollNested});

