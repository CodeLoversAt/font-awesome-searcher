/**
 * Created by daniel on 04.07.14.
 */

(function() {
    "use strict";

    var tagService = angular.module('tagService', ['ngResource']);

    tagService.factory('Tag', ['$resource', function($resource) {
        return $resource('/api/tags/:tagId', {tagId: '@id'}, {
            'update': { method: 'PUT'}
        });
    }]);
})();