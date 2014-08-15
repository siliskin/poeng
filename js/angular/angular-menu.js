/**
 *
 * Responsive website using AngularJS
 * http://www.script-tutorials.com/responsive-website-using-angularjs/
 *
 * Licensed under the MIT license.
 * http://www.opensource.org/licenses/mit-license.php
 *
 * Copyright 2013, Script Tutorials
 * http://www.script-tutorials.com/
 */

'use strict';

// angular.js main app initialization
var app = angular.module('bonanzooka', []).
config(['$routeProvider',
    function($routeProvider) {
        $routeProvider.
        when('/', {
            templateUrl: 'pages/dashboard.html',
            activetab: 'projects',
            controller: HomeCtrl
        }).
        when('/project/:projectId', {
            templateUrl: function(params) {
                return 'pages/' + params.projectId + '.html';
            },
            controller: ProjectCtrl,
            activetab: 'projects'
        }).
        when('/mail', {
            templateUrl: 'pages/mail.html',
            controller: MailCtrl,
            activetab: 'mail'
        }).
        when('/about', {
            templateUrl: 'pages/about.html',
            controller: AboutCtrl,
            activetab: 'about'
        }).
        when('/general', {
            templateUrl: 'pages/general.html',
            controller: GeneralCtrl,
            activetab: 'general'
        }).
        when('/icons', {
            templateUrl: 'pages/icons.html',
            controller: IconsCtrl,
            activetab: 'icons'
        }).
        when('/slider', {
            templateUrl: 'pages/slider.html',
            controller: SliderCtrl,
            activetab: 'slider'
        }).
        when('/morris', {
            templateUrl: 'pages/morris.html',
            controller: MorrisCtrl,
            activetab: 'morris'
        }).
        when('/editors', {
            templateUrl: 'pages/editors.html',
            controller: EditorsCtrl,
            activetab: 'editors'
        }).
        when('/advanced', {
            templateUrl: 'pages/advanced.html',
            controller: AdvancedCtrl,
            activetab: 'advanced'
        }).
        when('/general-element', {
            templateUrl: 'pages/general-element.html',
            controller: GeneralElementCtrl,
            activetab: 'GeneralElement'
        }).
        when('/table', {
            templateUrl: 'pages/table.html',
            controller: TableCtrl,
            activetab: 'Table'
        }).
        when('/data-table', {
            templateUrl: 'pages/data-table.html',
            controller: DataTableCtrl,
            activetab: 'DataTable'
        }).
        when('/button', {
            templateUrl: 'pages/button.html',
            controller: ButtonCtrl,
            activetab: 'Button'
        }).
        when('/typhography', {
            templateUrl: 'pages/typhography.html',
            controller: TyphographyCtrl,
            activetab: 'Typhography'
        }).
        when('/calendar', {
            templateUrl: 'pages/calendar.html',
            controller: CalendarCtrl,
            activetab: 'Calendar'
        }).
        when('/invoice', {
            templateUrl: 'pages/invoice.html',
            controller: InvoiceCtrl,
            activetab: 'Invoice'
        }).
        when('/masonry', {
            templateUrl: 'pages/masonry.html',
            controller: MasonryCtrl,
            activetab: 'Masonry'
        }).
        when('/404', {
            templateUrl: 'pages/404.html',
            controller: ErrorCtrl,
            activetab: 'Error'
        }).
        when('/timeline', {
            templateUrl: 'pages/timeline.html',
            controller: TimeLineCtrl,
            activetab: 'TimeLine'
        }).
        when('/blank', {
            templateUrl: 'pages/blank.html',
            controller: BlankCtrl,
            activetab: 'Blank'
        }).
        when('/blog-list', {
            templateUrl: 'pages/blog-list.html',
            controller: BlogListCtrl,
            activetab: 'BlogList'
        }).
        when('/blog-detail', {
            templateUrl: 'pages/blog-detail.html',
            controller: BlogDetailCtrl,
            activetab: 'BlogDetail'
        }).
        when('/flot', {
            templateUrl: 'pages/flot.html',
            controller: FloatCtrl,
            activetab: 'Float'
        }).
        when('/shop', {
            templateUrl: 'pages/shop.html',
             controller: ShopCtrl,
            activetab: 'Shop'
        }).
        when('/shop-detail', {
            templateUrl: 'pages/shop-detail.html',
            controller: ShopDetailCtrl,
            activetab: 'ShopDetail'
        }).
        when('/shop-list', {
            templateUrl: 'pages/shop-list.html',
            controller: ShopListCtrl,
            activetab: 'ShopList'

        }).

        otherwise({
            redirectTo: '/'
        });
    }
]).run(['$rootScope', '$http', '$browser', '$timeout', "$route",
    function($scope, $http, $browser, $timeout, $route) {

        $scope.$on("$routeChangeSuccess", function(scope, next, current) {
            $scope.part = $route.current.activetab;
        });

        // onclick event handlers
        $scope.showForm = function() {
            $('.contactRow').slideToggle();
        };
        $scope.closeForm = function() {
            $('.contactRow').slideUp();
        };

        // save the 'Contact Us' form
        $scope.save = function() {
            $scope.loaded = true;
            $scope.process = true;
            $http.post('sendemail.php', $scope.message).success(function() {
                $scope.success = true;
                $scope.process = false;
            });
        };
    }
]);

app.config(['$locationProvider',
    function($location) {
        $location.hashPrefix('!');
    }
]);
