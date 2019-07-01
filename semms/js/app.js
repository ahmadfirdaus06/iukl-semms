var app = angular.module('semms', ['ngRoute', 'admin']);
app.config(function($routeProvider){
    $routeProvider
    .when('/', {
        templateUrl: 'index.php'
    })
    .when('/main', {
        templateUrl: 'main.php',
        controller: 'adminCtrl'
    })
    .when('/admin', {
        templateUrl: 'admin/admin-page.php',
        controller: 'adminCtrl'
    })
    .otherwise({redirectTo:'/'});
});