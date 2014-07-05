/**
 * Created by daniel on 02.07.14.
 */

(function() {
    var app = angular.module('searchAwesome', ['iconControllers', 'ngRoute', 'helpers', 'navbar', 'tagControllers', 'auth', 'ui.router', 'iconService', 'tagService', 'siteService', 'login', 'admin']);

    app.config(['$stateProvider', '$urlRouterProvider', '$locationProvider', 'USER_ROLES', function ($stateProvider, $urlRouterProvider, $locationProvider, USER_ROLES) {
            $stateProvider
                .state('icons', {
                    url: '/icons',
                    templateUrl: 'partials/icon-list.html',
                    controller: 'IconsController',
                    controllerAs: 'iconsCtrl'
                })
                .state('icon', {
                    url: '/icons/:iconId',
                    templateUrl: 'partials/icon-detail.html',
                    controller: 'IconDetailController',
                    controllerAs: 'iconCtrl',
                    resolve: {
                        icon: function($stateParams, Icon) {
                            return Icon.get({iconId: $stateParams.iconId});
                        }
                    }
                })
                .state('tags', {
                    url: '/tags',
                    templateUrl: 'partials/tag-list.html',
                    controller: 'TagsController',
                    controllerAs: 'tagsCtrl'
                })
                .state('login', {
                    url: '/login',
                    templateUrl: 'partials/login.html',
                    controller: 'LoginController',
                    controllerAs: 'loginCtrl'
                })
                .state('admin', {
                    url: '/admin',
                    templateUrl: 'partials/admin-index.html',
                    controller: 'AdminIndexController',
                    controllerAs: 'adminIndexCtr',
                    data: {
                        authorizedRoles: [USER_ROLES.admin, USER_ROLES.editor]
                    }
                });

            $urlRouterProvider.otherwise('/icons');

            $locationProvider.html5Mode(false).hashPrefix('!');
        }])
        .run(['$rootScope', 'AUTH_EVENTS', 'AuthService', function ($rootScope, AUTH_EVENTS, AuthService) {
            $rootScope.$on('$stateChangeStart', function (event, next) {
                if (next.data && next.data.authorizedRoles) {
                    var authorizedroles = next.data.authorizedRoles;
                    if (!AuthService.isAuthorized(authorizedroles)) {
                        event.preventDefault();

                        if (AuthService.isAuthenticated()) {
                            // user is not allowed
                            $rootScope.$broadcast(AUTH_EVENTS.notAuthorized);
                        } else {
                            // user is not logged in
                            $rootScope.$broadcast(AUTH_EVENTS.notAuthenticated);
                        }
                    }
                }
            });

            $rootScope.$on('$routeChangeStart', function () {
                if (sessionStorage.restorestate == 'true') {
                    $rootScope.$broadcast('restorestate');
                    sessionStorage.restorestate = false;
                }
            });

            $rootScope.title = 'Search Awesome!';

            window.onbeforeunload = function () {
                sessionStorage.restorestate = angular.toJson(true);
            };
        }]);

    app.controller('ApplicationController', ['$scope', 'USER_ROLES', 'AuthService', function ($scope, USER_ROLES, AuthService) {
        $scope.currentUser = null;
        $scope.userRoles = USER_ROLES;
        $scope.isAuthorized = AuthService.isAuthorized;
    }]);
})();
