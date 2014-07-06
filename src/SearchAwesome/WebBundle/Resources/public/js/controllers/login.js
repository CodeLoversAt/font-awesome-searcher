/**
 * Created by daniel on 05.07.14.
 */
(function() {
    var app = angular.module('login', ['auth']);

    app.controller('LoginController', ['$rootScope', '$scope', 'AuthService', 'AUTH_EVENTS', 'USER_ROLES', function ($rootScope, $scope, AuthService, AUTH_EVENTS, USER_ROLES) {
        $rootScope.currentTab = 'login';
        $rootScope.title = 'Login';

        $scope.credentials = {
            email: '',
            password: '',
            rememberBe: 'on'
        };
        $scope.errors = [];

        $scope.login = function (credentials) {
            $scope.errors = [];
            AuthService.login(credentials).then(function () {
                $rootScope.$broadcast(AUTH_EVENTS.loginSuccess);
            }, function (res) {
                $scope.errors = res.data.errors || [];
                $rootScope.$broadcast(AUTH_EVENTS.loginFailed);
            });
        };
    }]);
})();