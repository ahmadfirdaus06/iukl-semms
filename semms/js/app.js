var app = angular.module('semms', ['ngRoute', 'admin', 'user']);
app.config(function($routeProvider){
    $routeProvider
    .when('/', {
        templateUrl: 'main.php',
    })
    .when('/admin/dashboard', {
        templateUrl: 'admin/admin-dashboard.php',
        controller: 'adminCtrl'
    })
    .when('/bursary/dashboard', {
        templateUrl: 'bursary/bursary-dashboard.php',
        controller: 'bursaryCtrl'
    })
    .when('/counselor/dashboard', {
        templateUrl: 'counselor/counselor-dashboard.php',
        controller: 'counselorCtrl'
    })
    .when('/login', {
        templateUrl: 'login-page.php',
        controller: 'userCtrl'
    });
});