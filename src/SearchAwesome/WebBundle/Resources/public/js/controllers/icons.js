/**
 * Created by daniel on 04.07.14.
 */
(function() {
    "use strict";

    var app = angular.module('iconControllers', ['iconList', 'iconService', 'siteService', 'tagService', 'ui.event', 'vcRecaptcha', 'ui.bootstrap', 'session']);

    app.controller('IconsController', ['$scope', '$rootScope', 'iconListService', function ($scope, $rootScope, iconListService) {
        this.lastSearch = '';
        this.reloadTimer = null;
        $rootScope.currentTab = 'icons';
        $rootScope.title = 'Search Awesome!';
        $scope.model = iconListService.model;

        var self = this;

        this.isLoading = function () {
            return iconListService.loading;
        };

        this.onKeyup = function () {
            if (this.reloadTimer !== null ) {
                window.clearTimeout(this.reloadTimer);
            }
            window.setTimeout(function() {
                self.reloadTimer = null;
                if (iconListService.model.search === self.lastSearch) {
                    return;
                }
                self.lastSearch = iconListService.model.search;
                self.reload();
            }, 400);
        };

        this.reset = function () {
            if (iconListService.model.search !== '') {
                iconListService.model.search = '';
                this.reload();
            }
        };

        this.reload = function() {
            iconListService.refresh();
        }
    }]);

    app.controller('IconDetailController', ['$scope', '$rootScope', '$stateParams',  '$http', '$modal', 'icon', 'Site', 'Tag', 'vcRecaptchaService', 'Session', function ($scope, $rootScope, $stateParams, $http, $modal, icon, Site, Tag, vcRecaptchaService,  Session) {
        this.loading = true;
        this.submitting = false;
        var self = this;
        $rootScope.currentTab = 'icons';
        $scope.errors = {};

        this.needsCaptcha = function () {
            return Session.needsCaptcha();
        };

        // load data
        this.site = new Site();
        this.tags = [];

        icon.$promise.then(function (icon) {
            var tmp = 2;
            self.icon = icon;
            $rootScope.title = icon.name;

            if (icon.tags.length) {
                self.tags = Tag.query({'ids[]': icon.tags}, function () {
                    if (--tmp == 0) {
                        self.loading = false;
                    }
                });
            } else {
                --tmp;
            }

            self.site = Site.get({siteId: icon.site}, function () {
                if (--tmp == 0) {
                    self.loading = false;
                }
            });
        });

        this.recaptchaKey = window.RECAPTCHA_PUBLIC_KEY || false;

        this.tag = new Tag();
        this.tagMaster = new Tag();

        this.href = function () {
            if (this.loading) {
                return '';
            }

            return self.site.url + self.site.detailsPath + self.icon.name;
        };

        this.isSubmitting = function () {
            return this.submitting;
        };

        this.addTag = function() {
            if (true === this.submitting) {
                return;
            }
            this.submitting = true;

            // clear errors
            $scope.errors = {};

            // add recaptcha data
            if (true === this.needsCaptcha()) {
                this.tag.recaptcha = vcRecaptchaService.data();
            }

            $http.post('/api/icons/' + this.icon.id + '/tags', this.tag).success(function (tag) {
                self.submitting = false;
                self.tag = angular.copy(self.tagMaster);
                $scope.tagForm.$setPristine();

                for (var i = 0; i < self.tags.length; i++) {
                    if (self.tags[i].id === tag.id) {
                        return;
                    }
                }
                self.tags.push(tag);
                Session.captchaSuccess();
            }).error(function (data) {
                var errors = data.errors;
                self.submitting = false;
                for (var field in errors) {
                    if ($scope.tagForm[field]) {
                        $scope.tagForm[field].$setValidity('server', false);
                    }
                    $scope.errors[field] = errors[field];
                }

                if (data.children) {
                    for (var field in data.children) {
                        if ($scope.tagForm[field]) {
                            $scope.tagForm[field].$setValidity('server', false);
                        }
                        var tmp = data.children[field];
                        if (tmp.errors) {
                            $scope.errors[field] = data.children[field].errors
                        } else if (angular.isArray(tmp) && tmp.length) {
                            $scope.errors[field] = tmp;
                        }
                    }
                }

                if (true === self.needsCaptcha()) {
                    vcRecaptchaService.reload();
                }
            });
        };

        var performDelete = function(tag, data) {
            if (true === tag.deleting) {
                return;
            }

            var params;

            if (!data) {
                params = null;
            } else {
                params = {params: data};
            }

            tag.deleting = true;
            $http.delete('/api/icons/' + self.icon.id + '/tags/' + tag.id, params).success(function () {
                tag.deleting = false;
                self.tags.splice(self.tags.indexOf(tag), 1);
                Session.captchaSuccess();
            }).error(function() {
                tag.deleting = false;
                displayCaptchaModal(tag);
            });
        };

        var displayCaptchaModal = function (tag) {
            var modal = $modal.open({
                templateUrl: 'partials/recaptcha.html',
                controller: 'ModalInstanceCtrl',
                resolve: {
                    key: function() {
                        return self.recaptchaKey;
                    }
                }
            });

            modal.result.then(function (data) {
                performDelete(tag, {recaptcha: data});
            });
        };

        this.removeTag = function(tag) {
            if (false === this.needsCaptcha()) {
                performDelete(tag);
                return;
            }

            displayCaptchaModal(tag);
        };
    }]);

    var ModalInstanceCtrl = app.controller('ModalInstanceCtrl', ['$scope', '$modalInstance', 'vcRecaptchaService', function ($scope, $modalInstance, vcRecaptchaService) {
        $scope.key = window.RECAPTCHA_PUBLIC_KEY;

        $scope.ok = function () {
            $modalInstance.close(vcRecaptchaService.data());
        };

        $scope.cancel = function () {
            $modalInstance.dismiss('cancel');
        };
    }]);
})();