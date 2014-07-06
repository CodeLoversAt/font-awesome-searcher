/**
 * Created by daniel on 05.07.14.
 */

(function() {
    var app = angular.module('auth', ['session']);

    app.factory('AuthService', function ($http, Session) {
        var hasRole = function (roles) {
            if (!angular.isArray(roles)) {
                roles = [roles];
            }

            for (var i = 0; i < Session.userRoles.length; i++) {
                if (-1 !== roles.indexOf(Session.userRoles[i])) {
                    return true;
                }
            }

            return false;
        };

        return {
            login: function(credentials) {
                return $http
                    .post('/login_check', {
                        _username: credentials.email,
                        _password: credentials.password,
                        _remember_me: credentials.rememberMe ? 'on' : null
                    })
                    .then(function (res) {
                        Session.create(res.data.id, res.data.userId, res.data.email, res.data.roles);
                    });
            },

            isAuthenticated: function() {
                return !!Session.userId;
            },

            isAuthorized: function(roles) {
                return (this.isAuthenticated() && hasRole(roles));
            },

            logout: function() {
                return $http.post('/logout').then(function () {
                    Session.destroy();
                });
            },

            refresh: function(callback) {
                if ('function' !== typeof callback) {
                    callback = function() {};
                }
                return $http.post('/api/login_status').then(function (res) {
                    if (res.data && res.data !== 'null') {
                        Session.create(res.data.id, res.data.userId, res.data.email, res.data.roles);
                        callback();
                    }
                });
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

    // check login status on start
    app.run(['$http', '$rootScope', 'AuthService', 'AUTH_EVENTS', function ($http, $rootScope, AuthService, AUTH_EVENTS) {
        if (false === AuthService.isAuthenticated()) {
            AuthService.refresh(function() {
                $rootScope.$broadcast(AUTH_EVENTS.loginSuccess);
            });
        }
    }]);
})();