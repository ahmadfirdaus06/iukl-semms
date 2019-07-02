var app = angular.module('semms', ['ngRoute', 'admin', 'user']);
app.config(function($routeProvider){
    $routeProvider
    .when('/admin', {
        templateUrl: 'admin/admin-dashboard.php',
        controller: 'adminCtrl'
    })
    .when('/bursary', {
        templateUrl: 'bursary/bursary-dashboard.php',
        controller: 'bursaryCtrl'
    })
    .when('/counselor', {
        templateUrl: 'counselor/counselor-dashboard.php',
        controller: 'counselorCtrl'
    })
    .when('/login', {
        templateUrl: 'login-page.php',
        controller: 'userCtrl'
    });
});