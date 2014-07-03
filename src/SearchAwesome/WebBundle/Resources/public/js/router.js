/**
 * Created by daniel on 02.07.14.
 */

App.Router.map(function () {
    this.resource('icons', { path: '/'});
    this.resource('icon', { path: '/icons/:icon_id' });
    this.resource('tags', {path: '/tags'});
});

App.IconsRoute = Ember.Route.extend({
    isLoaded: false,

    model: function () {
//        var store = this.store;
//        console.log({search: this.get('search')});
//
//        return new Em.RSVP.Promise(function(resolve) {
//            store.find('tag').then(function() {
//                store.find('icon').then(function(icons) {
//                    var promisArr = icons.getEach('tags');
//
//
//                    Em.RSVP.all(promisArr).then(function() {
//                        var filter = store.filter('icon', function(icon, index, enumberable) {
//                            var match = false;
//                            icon.get('tags').forEach(function(tag) {
//                                if (tag.get('name') === 'adjust') {
//                                    match = true;
//                                }
//                            });
//
//                            return match;
//                        }); // filter
//
//                        resolve(filter);
//                    }); // RSVP all
//                }); // find icon
//            }); // find tag
//        }); // promise


        if (this.get('isLoaded')) {
            return this.store.all('icon');
        }
        this.set('isLoaded', true);
        return this.store.find('icon');
    }
});

App.IconRoute = Ember.Route.extend({
    model: function(params) {
        return this.store.find('icon', params.icon_id);
    }
});

App.TagsRoute = Ember.Route.extend({
    isLoaded: false,

    model: function () {
        if (this.get('isLoaded')) {
            return this.store.all('tag');
        }
        this.set('isLoaded', true);
        return this.store.find('tag');
    }
});