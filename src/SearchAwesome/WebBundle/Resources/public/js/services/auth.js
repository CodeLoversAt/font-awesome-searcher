/**
 * Created by daniel on 05.07.14.
 */

(function() {
    var app = angular.module('auth', ['session']);

    app.factory('AuthService', function ($http, Session) {
        return {
            login: function(credentials) {
                return $http
                    .post('/login_check', {
                        _username: credentials.email,
                        _password: credentials.password,
                        _remember_me: credentials.rememberMe,
                        _target_path: credentials.targetPath
                    })
                    .then(function (res) {
                        Session.create(res.id, res.userid, res.role);
                    });
            },

            isAuthenticated: function() {
                return !!Session.userId;
            },

            isAuthorized: function(roles) {
                if (!angular.isArray(roles)) {
                    roles = [roles];
                }

                return (this.isAuthenticated() && roles.indexOf(Session.userRole) !== -1);
            }
        };
    });

    app.config(['$httpProvider', function ($httpProvider) {
        $httpProvider.interceptors.push([
            '$injector',
            function ($injector) {
                return $injector.get('AuthInterceptor');
            }]);
    }]);

    app.factory('AuthInterceptor', ['$rootScope', '$q', 'AUTH_EVENTS', function ($rootScope, $q, AUTH_EVENTS) {
        return {
            responseError: function (response) {
                if (response.status === 401) {
                    $rootScope.$broadcast(AUTH_EVENTS.notAuthenticated, response);
                } else if (response.status === 403) {
                    $rootScope.$broadcast(AUTH_EVENTS.notAuthorized);
                } else if (response.status === 419 || response.status === 440) {
                    $rootScope.$broadcast(AUTH_EVENTS.sessionTimeout, response);
                }

                return $q.reject(response);
            }
        };
    }]);

    app.constant('USER_ROLES', {
        all: '*',
        admin: 'admin',
        editor: 'editor',
        guest: 'guest'
    });

    app.constant('AUTH_EVENTS', {
        loginSuccess: 'auth-login-success',
        loginFailed: 'auth-login-failed',
        logoutSuccess: 'auth-logout-success',
        sessionTimeout: 'auth-session-timeout',
        notAuthenticated: 'auth-not-authenticated',
        notAuthorized: 'auth-not-authorized'
    });
})();