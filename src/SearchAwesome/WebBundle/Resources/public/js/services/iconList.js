/**
 * Created by daniel on 05.07.14.
 */

(function() {
    "use strict";
    var app = angular.module('iconList', ['iconService']);

    app.factory('iconListService', ['$rootScope', 'Icon', function ($rootScope, Icon) {
        var service = {
            loading: true,
            model: {
                icons: [],
                search: ''
            },

            refresh: function() {
                service.loading = true;
                Icon.query({search: service.model.search}, function (icons) {
                    service.model.icons = icons;
                    service.loading = false;
                });
            },
            saveState: function() {
                sessionStorage.iconListService = angular.toJson(service.model);
            },

            restoreState: function() {
                service.model = angular.fromJson(sessionStorage.iconListService);
            }
        };

        service.refresh();

        $rootScope.$on('savestate', service.saveState);
        $rootScope.$on('restorestate', service.restoreState);

        return service;
    }]);
})();