/**
 * Created by daniel on 05.07.14.
 */

(function() {
    "use strict";
    var app = angular.module('tagList', ['tagService']);

    app.factory('tagListService', ['$rootScope', 'Tag', function ($rootScope, Tag) {
        var addToCache = function (tags) {
            for (var i = 0; i < tags.length; i++) {
                var tag = tags[i];
                service.cache[tag.id] = tag;
            }
        };

        var service = {
            loading: true,
            model: {
                tags: []
            },

            cache: {},

            refresh: function() {
                service.loading = true;
                Tag.query(function (tags) {
                    service.model.tags = tags;
                    service.loading = false;
                });
            },
            saveState: function() {
                sessionStorage.tagListService = angular.toJson(service.model);
            },

            restoreState: function() {
                service.model = angular.fromJson(sessionStorage.tagListService);
            },

            addTag: function(name) {
                var tag = new Tag();
                tag.name = name;

                return tag.$save();
            }
        };

        service.refresh();

        $rootScope.$on('savestate', service.saveState);
        $rootScope.$on('restorestate', service.restoreState);

        return service;
    }]);
})();