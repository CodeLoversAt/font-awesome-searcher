/**
 * Created by daniel on 02.07.14.
 */

(function() {
    var app = angular.module('searchAwesome', ['iconControllers', 'ngRoute', 'helpers', 'navbar', 'tagControllers']);

    app.config(['$routeProvider', function ($routeProvider) {
        $routeProvider
            .when('/icons', {
                templateUrl: 'partials/icon-list.html',
                controller: 'IconsController',
                controllerAs: 'iconsCtrl'
            })
            .when('/icons/:iconId', {
                templateUrl: 'partials/icon-detail.html',
                controller: 'IconDetailController',
                controllerAs: 'iconCtrl'
            })
            .when('/tags', {
                templateUrl: 'partials/tag-list.html',
                controller: 'TagsController',
                controllerAs: 'tagsCtrl'
            })
            .otherwise({
                redirectTo: '/icons'
            });
    }]);
})();
