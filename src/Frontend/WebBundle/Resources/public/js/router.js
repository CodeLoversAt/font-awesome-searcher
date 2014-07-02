/**
 * Created by daniel on 02.07.14.
 */

App.Router.map(function () {
    this.resource('icons', { path: '/'});
    this.resource('tags', {path: '/tags'});
});

App.IconsRoute = Ember.Route.extend({
    model: function () {
        return this.store.find('icon');
    }
});

App.TagsRoute = Ember.Route.extend({
    model: function () {
        return this.store.find('tag');
    }
});