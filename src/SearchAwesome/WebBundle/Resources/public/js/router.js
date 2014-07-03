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

(function() {

    var get = Ember.get, set = Ember.set;

    Ember.Location.registerImplementation('hashbang', Ember.HashLocation.extend({

        getURL: function() {
            return get(this, 'location').hash.substr(2);
        },

        setURL: function(path) {
            get(this, 'location').hash = "!"+path;
            set(this, 'lastSetURL', path);
        },

        onUpdateURL: function(callback) {
            var self = this;
            var guid = Ember.guidFor(this);

            Ember.$(window).bind('hashchange.ember-location-'+guid, function() {
                Ember.run(function() {
                    var path = location.hash.substr(2);
                    if (get(self, 'lastSetURL') === path) { return; }

                    set(self, 'lastSetURL', null);

                    callback(path);
                });
            });
        },

        formatURL: function(url) {
            return '#!'+url;
        }

    })
    );

})();

App.Router.reopen({
    location: 'hashbang'
});