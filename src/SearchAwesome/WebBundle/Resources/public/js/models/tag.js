/**
 * Created by daniel on 02.07.14.
 */


App.Tag = DS.Model.extend({
    name: DS.attr('string'),
    icons: DS.hasMany('icon', {
        inverse: 'tags',
        async: true
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