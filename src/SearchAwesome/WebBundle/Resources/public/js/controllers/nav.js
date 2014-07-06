/**
 * Created by daniel on 04.07.14.
 */
(function() {
    "use strict";

    var app = angular.module('navbar', ['ui.bootstrap', 'ui.gravatar', 'auth']);

    app.config(['gravatarServiceProvider', function (gravatarServiceProvider) {
        gravatarServiceProvider.defaults = {
            "size": 25,
            "default": 'mm'
        };

        gravatarServiceProvider.secure = true;
    }]);

    app.controller('NavController', ['$rootScope', '$scope', 'AUTH_EVENTS', 'AuthService', function ($rootScope, $scope, AUTH_EVENTS, AuthService) {
        $rootScope.currentTab = 'icons';

        $scope.dropdownItems = ['Logout'];
        $scope.isCollapsed = true;

        this.selectedTab = function (tab) {
            return $rootScope.currentTab === tab;
        };

        $scope.logout = function() {
            AuthService.logout().then(function () {
                $rootScope.$broadcast(AUTH_EVENTS.logoutSuccess);
            });
        }
    }]);
})();