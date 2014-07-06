/**
 * Created by daniel on 02.07.14.
 */

(function() {
    var app = angular.module('searchAwesome', ['iconControllers', 'ngRoute', 'helpers', 'navbar', 'tagControllers', 'auth', 'session', 'ui.router', 'iconService', 'tagService', 'siteService', 'login', 'admin', 'ui.gravatar']);

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
        .config(['$httpProvider', function($httpProvider) {
            $httpProvider.defaults.headers.common["X-Requested-With"] = 'XMLHttpRequest';
        }])
        .run(['$rootScope', 'AUTH_EVENTS', 'AuthService', '$state', 'Session', function ($rootScope, AUTH_EVENTS, AuthService, $state, Session) {
            $rootScope.$on('$stateChangeStart', function (event, next, nextParams, from, fromParams) {
                if (next.data && next.data.authorizedRoles) {
                    var authorizedroles = next.data.authorizedRoles;
                    if (!AuthService.isAuthorized(authorizedroles)) {
                        event.preventDefault();

                        if (AuthService.isAuthenticated()) {
                            // user is not allowed
                            $rootScope.$broadcast(AUTH_EVENTS.notAuthorized);
                        } else {
                            // user is not logged in
                            // store target
                            Session.set('_login_target', next.name);
                            Session.set('_login_target_params', nextParams);
                            $rootScope.$broadcast(AUTH_EVENTS.notAuthenticated);
                        }
                    }
                } else if (next.name === 'login') {
                    Session.set('_login_target', from.name);
                    Session.set('_login_target_params', fromParams);
                }
            });

            $rootScope.title = 'Search Awesome!';

            $rootScope.$on(AUTH_EVENTS.notAuthenticated, function () {
                $state.go('login');
            });

            $rootScope.$on(AUTH_EVENTS.logoutSuccess, function() {
                var current = $state.$current;
                Session.resetCaptcha();

                if (current.data && current.data.authorizedRoles) {
                    // store target
                    Session.set('_login_target', current.name);
                    $rootScope.$broadcast(AUTH_EVENTS.notAuthenticated);
                } else {
                    $state.reload();
                }
            });

            $rootScope.$on(AUTH_EVENTS.loginSuccess, function() {
                var target = Session.remove('_login_target');
                Session.captchaSuccess();

                if (target) {
                    $state.go(target, Session.remove('_login_target_params'));
                }
            });
        }]);

    app.controller('ApplicationController', ['$scope', '$rootScope', 'USER_ROLES', 'AUTH_EVENTS', 'AuthService', 'Session', function ($scope, $rootScope, USER_ROLES, AUTH_EVENTS, AuthService, Session) {
        $scope.currentUser = Session.email || null;
        $scope.userRoles = USER_ROLES;
        $scope.isAuthorized = AuthService.isAuthorized;
        $scope.isAuthenticated = AuthService.isAuthenticated;

        $rootScope.$on(AUTH_EVENTS.loginSuccess, function() {
            $scope.currentUser = Session.email;
        });

        $rootScope.$on(AUTH_EVENTS.logoutSuccess, function() {
            $scope.currentUser = null;
        });

        $rootScope.$on(AUTH_EVENTS.notAuthenticated, function () {
            $scope.currentUser = null;
        });
    }]);
})();
