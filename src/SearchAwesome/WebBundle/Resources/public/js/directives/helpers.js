/**
 * Created by daniel on 04.07.14.
 */

(function() {
    "use strict";

    var app = angular.module('helpers', []);

    app
        .directive('serverError', function () {
            return {
                restrict: 'A',
                require: '?ngModel',
                link: function(scope, element, attrs, ctrl) {
                    element.on('change', function() {
                        scope.$apply(function() {
                            ctrl.$setValidity('server', true);
                        })
                    })
                }
            };
        })

        .directive('focusMe', ['$timeout', '$parse', function ($timeout, $parse) {
            return {
                restrict: 'A',
                link: function (scope, element, attrs) {
                    var model = $parse(attrs.focusMe);
                    scope.$watch(model, function (value) {
                        if (value === true) {
                            $timeout(function () {
                                element[0].focus();
                            });
                        }
                    });
                }
            };
        }])

        .directive('formAutofillFix', function ($timeout) {
            return function (scope, element, attrs) {
                element.prop('method', 'post');
                if (attrs.ngSubmit) {
                    $timeout(function () {
                        element
                            .unbind('submit')
                            .bind('submit', function (event) {
                                event.preventDefault();
                                element
                                    .find('input, textarea, select')
                                    .trigger('input')
                                    .trigger('change')
                                    .trigger('keydown');
                                scope.$apply(attrs.ngSubmit);
                            });
                    });
                }
            };
        });
})();