/**
 * Created by daniel on 04.07.14.
 */
(function() {
    "use strict";

    var app = angular.module('tagControllers', ['tagList']);

    app.controller('TagsController', ['$scope', '$rootScope', 'tagListService', function ($scope, $rootScope, tagListService) {
        $rootScope.currentTab = 'tags';

        $scope.model = tagListService.model;
    }]);
})();