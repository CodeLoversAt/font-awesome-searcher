/**
 * Created by daniel on 05.07.14.
 */
(function() {
    var app = angular.module('session', []);

    app.service('Session', function () {
        var store;
        try {
            store = angular.fromJson(sessionStorage.session) || {};
        } catch (err) {
            console.log(err);
            store = {};
        }

        this.create = function (sessionId, userId, email, userRoles) {
            this.id = sessionId;
            this.userId = userId;
            this.userRoles = userRoles;
            this.email = email;

            this.set('_session', {
                id: sessionId,
                userId: userId,
                userRoles: userRoles,
                email: email
            });
        };

        this.destroy = function () {
            this.id = null;
            this.userId = null;
            this.userRoles = [];
            store = {};
            try {
                sessionStorage.clear();
            } catch (err) {
                console.log(err);
            }
        };

        this.get = function (key) {
            if ('undefined' !== typeof store[key]) {
                return store[key];
            }
            return null;
        };

        this.set = function (key, value) {
            store[key] = value;
            try {
                sessionStorage.session = angular.toJson(store);
            } catch (err) {
                console.log(err);
            }
        };

        this.remove = function(key) {
            var result = null;

            if (store[key]) {
                result = store[key];
                delete store[key];
                try {
                    sessionStorage.session = angular.toJson(store);
                } catch (err) {
                    console.log(err);
                }
            }

            return result;
        };

        this.needsCaptcha = function () {
            var needsCaptcha = this.get('_needsCaptcha');

            if ('undefined' !== typeof needsCaptcha) {
                return needsCaptcha;
            }

            return true;
        };

        this.captchaSuccess = function () {
            this.set('_needsCaptcha', false);
        };

        this.resetCaptcha = function () {
            this.set('_needsCaptcha', true);
        };

        // restore state
        var state = this.get('_session');
        if (null !== state) {
            this.create(state.id, state.userId, state.email, state.userRoles);
        }
        this.set('_needsCaptcha', window.RECAPTCHA_NEEDED || false);

        return this;
    });
})();