/**
 * Created by daniel on 05.07.14.
 */
(function() {
    var app = angular.module('session', []);

    app.service('Session', function () {
        this.create = function (sessionId, userId, userRole) {
            this.id = sessionId;
            this.userId = userId;
            this.userRole = userRole;
        };

        this.destroy = function () {
            this.id = null;
            this.userId = null;
            this.userRole = null;
        };

        return this;
    });
})();