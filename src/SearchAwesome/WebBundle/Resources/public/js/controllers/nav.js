/**
 * Created by daniel on 04.07.14.
 */
(function() {
    "use strict";

    var app = angular.module('navbar', []);

    app.controller('NavController', ['$rootScope', function ($rootScope) {
        $rootScope.currentTab = 'icons';

        this.selectedTab = function (tab) {
            return $rootScope.currentTab === tab;
        };
    }]);
})();