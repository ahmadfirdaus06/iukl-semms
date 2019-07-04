var app = angular.module('semms', ['ngRoute', 'admin', 'user', 'bursary', 'counselor']);
app.config(function($routeProvider){
    $routeProvider
    .when('/', {
        templateUrl: 'login-page.php',
        controller: 'userCtrl'
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
    .when('/counselor/report', {
        templateUrl: 'admin/report.php',
        controller: 'adminCtrl'
    })
    .when('/counselor/case', {
        templateUrl: 'admin/case.php',
        controller: 'adminCtrl'
    })
    .otherwise({ 
        redirectTo:'/'
    });
});