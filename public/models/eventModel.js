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

var ImageModel = Backbone.Model.extend({
    urlRoot:'http://pingouin.heig-vd.ch/gof/api/v1/store',

    defaults: function(){
                return{
                 
                 id:''
                 }
            }

})

var ImagesColl = Backbone.Collection.extend({
    url: 'http://pingouin.heig-vd.ch/gof/api/v1/images',
    model: ImageModel,
    parse: function (response) {
        if (typeof response.data != "undefined") {
            response = response.data;
        }
       
        return response;
    }

});

var ImagesCollNested = MyModelNestedCollection.extend({
    nested : "images",
    defaults: function(){
                return{
                 
                 images: new ImagesColl()
                 }
            }

});

    var imagescollnested = new ImagesCollNested()

    // var imagesCollection = new ImagesColl()
    // imagesCollection.fetch({
    //     success: function(){
    //         console.log('Images:');
    //         console.log(imagesCollection.toJSON());

    //         musicianList = new MusicianMultipleView({model:musicianNestedCollServer})
    //         musicianList.render().$el.appendTo('#musicianList')
    //         $('.myAccordion').accordion({collapsible: true, active: false,heightStyle: "content"})
    //     }
    //     });


var NightType = Backbone.Model.extend({
     defaults: function(){
                return{
                id:'',
                name_de:''

                 }
            }
})
var NightTypeColl = Backbone.Collection.extend({
    model: NightType
})
var NightTypeNestedColl = MyModelNestedCollection.extend({
    nested: 'nighttype',
    defaults: function(){
                return{
                    nighttype : new NightTypeColl()
     
                }
            }

})
var nightTypeNestedColl = new NightTypeNestedColl()

var Platform = Backbone.Model.extend({

})
var PlatformsColl = Backbone.Collection.extend({
    model: Platform
})

var EventModel = Backbone.Model.extend({
    urlRoot:'http://pingouin.heig-vd.ch/gof/api/v1/nights',


            defaults: function(){
                return{
                    artists: new ArtistColl(),
                    ticket_categories: new TicketsColl(),
                    title_de:'',
                    //image: new ImagesColl(),
                    nighttype: new NightType(),
                    platforms: new PlatformsColl()
     
                }
            }/*,
        validate: function(attrs, options){
            if (!_.isDate(attrs.startDate) || attrs.startDate =='') {
                alert('event start date has to be a date!')
            }
            if(!_.isNumber(attrs.ticketPrice)){
                alert('ticket price has to be a number!')
            }
             if(!_.isNumber(attrs.ticketQt)){
                alert('ticket quantity has to be a number!')
            }
             if(!_.isNumber(attrs.nbPlaces)){
                alert('number of places has to be a number!')
            }
             if(!_.isNumber(attrs.nbNormalMeals)){
                alert('number of normal meals has to be a number!')
            }
             if(!_.isNumber(attrs.nbVeganMeals)){
                alert('number of vegan meals has to be a number!')
            }
        }*/

        });

var EventColl = Backbone.Collection.extend({
    url:'http://pingouin.heig-vd.ch/gof/api/v1/nights',
    model:EventModel,
    parse: function (response) {
        if (typeof response.data != "undefined") {
            response = response.data;
        }
       
        return response;
    }
}) 
var eventColl = new EventColl()



var EventsNestedColl = MyModelNestedCollection.extend({ 
 url:'http://pingouin.heig-vd.ch/gof/api/v1/nights',   
    nested: 'events',
    defaults: function(){
        return {
            events : new EventColl()
        }
    }
})

eventsNestedColl = new EventsNestedColl()




var EventColl2 = Backbone.Collection.extend({
    

    model:EventModel,
   
}) 
var eventColl2 = new EventColl()

var EventsNestedColl2 = MyModelNestedCollection.extend({
      
    nested: 'events',
    defaults: function(){
        return {
            events : new EventColl2()
        }
    }
})

eventsNestedColl2 = new EventsNestedColl()



