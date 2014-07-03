/**
 * Created by daniel on 02.07.14.
 */

App.Icon = DS.Model.extend({
    name: DS.attr('string'),
    cssClass: DS.attr('string'),
    unicode: DS.attr('string'),
    createdAt: DS.attr('isodate'),
    updatedAt: DS.attr('isodate'),
    tags: DS.hasMany('tag', {
        inverse: 'icons',
        async: true,
    }),
    aliases: DS.attr(),
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
