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

var Event = MyModel.extend({

});


var Artist = MyModel.extend({

});

var Musician = MyModel.extend({

});

var Instrument = MyModel.extend({

});

var Header = MyView.extend({
    template: _.template(tamplates.indexx)
});



$(function(){

});
