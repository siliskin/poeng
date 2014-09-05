var app = angular.module('poengApp', ['ngRoute', 'poengController', 'poengFilters']);

app.config(['$routeProvider',
  function($routeProvider) {
    $routeProvider.
    when('/register', {
      templateUrl: 'views/register.html',
      controller: 'RegisterCtrl'
    }).
    when('/review', {
      templateUrl: 'views/review.html',
      controller: 'ReviewDetailCtrl'
    }).
    otherwise({
      redirectTo: '/register'
    });
  }]);