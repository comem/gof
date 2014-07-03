var LAST_FORM = 'event';

// Application router
// ==================
var AppRouter = Backbone.Router.extend({
        routes: {
        	'': 'index',
          ':tab/:form' : 'formHandler',
          ':tab': 'tabHandler'
        },
  		index: function(){
  			console.log('default url -> add/'+LAST_FORM);  			
        this.navigate('add/' + LAST_FORM, {replace: true});
        Backbone.history.loadUrl('add/' + LAST_FORM);
  		},
      formHandler: function(tab, form) {
          console.log("tab " + tab + " form " + form)
          showMain(tab);
          scrollForm(form);
          LAST_FORM = form;
        },
        tabHandler: function(tab){
			    console.log('route with tab '+ tab + " last form" + LAST_FORM);
          showMain(tab);
          this.navigate(tab + '/' + LAST_FORM, {replace: true});
        }
    });