/**
 * Created by daniel on 05.07.14.
 */
(function() {
    var app = angular.module('admin', []);

    app.controller('AdminIndexController', ['$rootScope', function ($rootScope) {
        $rootScope.currentTab = 'admin';
        $rootScope.title = 'Administration';
    }]);
})();