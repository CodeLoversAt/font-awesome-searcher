/**
 * Created by daniel on 02.07.14.
 */
window.App = Ember.Application.create();

DS.RESTAdapter.reopen({
    namespace: 'api'
});