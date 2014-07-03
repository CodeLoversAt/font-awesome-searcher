/**
 * Created by daniel on 02.07.14.
 */

App.IconsController = Ember.ArrayController.extend({
    sortProperties: ['name'],
    sortAscending: true,
    tagsLoaded: false,
    searchTimer: null,

    searchResults: Ember.computed.defaultTo('arrangedContent'),

    filterItem: function(model, regexes, searchInput) {

        if (!searchInput || 0 === searchInput.length) {
            return true;
        } else {
            var match = true;
            var tags = model.get('tags');

            // test all regular expressions
            for (var i = 0; i < regexes.length; i++) {
                var regex = regexes[i];
                if (true === match) {
                    var test = false;
                    tags.forEach(function(tag) {
                        if (-1 !== tag.get('name').search(regex)) {
                            test = true;
                        }
                    });

                    if (false === test) {
                        match = false;
                    }
                }
            }

            return match;
        }
    },

    performSearch: function() {
        this.tagsLoaded = true;
        if (null !== this.searchTimer) {
            window.clearTimeout(this.searchTimer);
        }
        this.searchTimer = window.setTimeout(function() {
            this.searchTimer = null;
            var searchInput = this.get('searchText'),
                terms = searchInput.split(' '),
                regexes = [];

            for (var i = 0; i < terms.length; i++) {
                if (-1 === terms[i].search(/^\s*$/)) {
                    regexes.push(new RegExp(terms[i], 'i'));
                }
            }
            this.set('searchResults', this.get('arrangedContent').filter(function(model) {
                return this.filterItem(model, regexes, searchInput);
            }.bind(this)));
        }.bind(this), 150);
    },

    searchFilter: function() {
        if (false === this.get('tagsLoaded')) {
            this.store.find('tag').then(function(tags) {
                this.store.push('tag', tags);
                console.log('tags loaded');
                this.performSearch();
            }.bind(this));
        } else {
            this.performSearch();
        }
    }.observes('searchText')
});