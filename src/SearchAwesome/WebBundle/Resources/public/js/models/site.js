/**
 * Created by daniel on 02.07.14.
 */

App.Site = DS.Model.extend({
    name: DS.attr('string'),
    url: DS.attr('string'),
    icons: DS.hasMany('icon', {
        inverse: 'site',
        async: true
    }),

    becameError: function () {
        console.log('becameError');
        console.log(arguments);
    },

    becameInvalid: function () {
        console.log('becameInvalid');
        console.log(arguments);
    }
});