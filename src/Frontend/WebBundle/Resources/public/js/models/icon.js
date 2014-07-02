/**
 * Created by daniel on 02.07.14.
 */

App.Icon = DS.Model.extend({
    name: DS.attr('string'),
    cssClass: DS.attr('string'),
    createdAt: DS.attr('date'),
    updatedAt: DS.attr('date'),
    tags: DS.hasMany('tag', {
        inverse: 'icons',
        async: true
    }),
    site: DS.belongsTo('site', {
        async: true,
        inverse: 'icons'
    }),

    becameError: function() {
        console.log('becameError');
        console.log(arguments);
    },

    becameInvalid: function() {
        console.log('becameInvalid');
        console.log(arguments);
    }
});