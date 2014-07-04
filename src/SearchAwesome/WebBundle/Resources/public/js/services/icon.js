/**
 * Created by daniel on 04.07.14.
 */

(function() {
    "use strict";

    var iconService = angular.module('iconService', ['ngResource']);

    iconService.factory('Icon', ['$resource', function($resource) {
        return $resource('/api/icons/:iconId', {iconId: '@id'}, {
            'update': { method: 'PUT'}
        });
    }]);
})();