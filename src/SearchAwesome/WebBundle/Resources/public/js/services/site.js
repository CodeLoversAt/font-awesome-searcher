/**
 * Created by daniel on 04.07.14.
 */

(function() {
    "use strict";

    var siteService = angular.module('siteService', ['ngResource']);

    siteService.factory('Site', ['$resource', function($resource) {
        return $resource('/api/sites/:siteId', {siteId: '@id'}, {
            'update': { method: 'PUT'}
        });
    }]);
})();