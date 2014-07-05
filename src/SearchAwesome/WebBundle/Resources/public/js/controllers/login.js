/**
 * Created by daniel on 05.07.14.
 */
(function() {
    var app = angular.module('login', ['auth']);

    app.controller('LoginController', ['$rootScope', '$scope', 'AuthService', 'AUTH_EVENTS', function ($rootScope, $scope, AuthService, AUTH_EVENTS) {
        $scope.credentials = {
            email: '',
            password: '',
            rememberBe: 'on'
        };

        $scope.login = function (credentials) {
            AuthService.login(credentials).then(function () {
                $rootScope.$broadcast(AUTH_EVENTS.loginSuccess);
            }, function () {
                $rootScope.$broadcast(AUTH_EVENTS.loginFailed);
            });
        };
    }]);
})();