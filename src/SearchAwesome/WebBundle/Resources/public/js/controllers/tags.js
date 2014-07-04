/**
 * Created by daniel on 04.07.14.
 */
(function() {
    "use strict";

    var app = angular.module('tagControllers', ['tagService']);

    app.controller('TagsController', ['$scope', '$rootScope', 'Tag', function ($scope, $rootScope, Tag) {
        $rootScope.currentTab = 'tags';

        $scope.tags = Tag.query();
    }]);
})();