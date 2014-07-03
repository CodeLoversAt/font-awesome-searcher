/**
 * Created by daniel on 02.07.14.
 */

App.IconController = Ember.ObjectController.extend({
    iconClass: function() {
        return this.get('cssClass');
    }.property('cssClass'),

    href: function() {
        return this.get('site').get('url') + 'icon/' + this.get('name');
    }.property('site.url', 'name')
});
