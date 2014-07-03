/**
 * Created by daniel on 02.07.14.
 */

App.IconsController = Ember.ArrayController.extend({
    sortProperties: ['name'],
    sortAscending: true,
    iconsLoaded: false,
    searchTimer: null,
    isSearching: false,

    searchResults: Ember.computed.defaultTo('arrangedContent'),

    actions: {
        resetSearch: function() {
            this.set('searchText', '');
        }
    },

    searchFilter: function() {
        var searchInput = this.get('searchText');

        if (!searchInput || 0 === searchInput.length) {
            // nothing to search for
            this.set('searchResults', this.store.all('icon'));
            return;
        }

        if (null !== this.searchTimer) {
            window.clearTimeout(this.searchTimer);
        }

        var self = this;

        this.searchTimer = window.setTimeout(function() {
            self.searchTimer = null;
            self.set('isSearching', true);

            self.store.find('icon', {search: searchInput}).then(function (result) {
                self.set('searchResults', result);
                self.set('isSearching', false);
            });
        }, 400);
    }.observes('searchText', 'content.loaded')
});