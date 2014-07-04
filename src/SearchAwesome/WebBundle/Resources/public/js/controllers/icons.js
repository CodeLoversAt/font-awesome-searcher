/**
 * Created by daniel on 04.07.14.
 */
(function() {
    "use strict";

    var app = angular.module('iconControllers', ['iconService', 'siteService', 'tagService', 'ui.event']);

    app.controller('IconsController', ['$scope', '$rootScope', 'Icon', function ($scope, $rootScope, Icon) {
        this.loading = true;
        this.lastSearch = '';
        this.reloadTimer = null;
        $rootScope.currentTab = 'icons';

        var self = this;

        $scope.icons = Icon.query(function() {
            self.loading = false;
        });

        this.onKeyup = function () {
            if (this.reloadTimer !== null ) {
                window.clearTimeout(this.reloadTimer);
            }
            window.setTimeout(function() {
                self.reloadTimer = null;
                if ($scope.search === self.lastSearch) {
                    return;
                }
                self.lastSearch = $scope.search;
                self.reload();
            }, 400);
        };

        this.reset = function () {
            $scope.search = '';
            this.reload();
        };

        this.reload = function() {
            this.loading = true;
            $scope.icons = Icon.query({search: $scope.search}, function () {
                self.loading = false;
            });
        }
    }]);

    app.controller('IconDetailController', ['$rootScope', '$routeParams', 'Icon', 'Site', 'Tag', function ($rootScope, $routeParams, Icon, Site, Tag) {
        this.loading = true;
        var self = this;
        $rootScope.currentTab = 'icons';

        this.site = new Site();

        this.icon = Icon.get({iconId: $routeParams.iconId}, function(icon) {
            var tmp = 2;
            self.site = Site.get({siteId: icon.site}, function() {
                if (0 === --tmp) {
                    self.loading = false;
                }
            });
            self.tags = Tag.query({'ids[]': icon.tags}, function () {
                if (0 === --tmp) {
                    self.loading = false;
                }
            });
        });

        this.href = function () {
            if (this.loading) {
                return '';
            }

            return self.site.url + 'icon/' + self.icon.name;
        };
    }]);
})();