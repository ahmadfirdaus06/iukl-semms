var app = angular.module('semms', ['ui.router', 'ngRoute', 'admin', 'user', 'bursary', 'counselor']);
app.config(function($stateProvider, $urlRouterProvider){
    
    $urlRouterProvider.otherwise('/login');

    $stateProvider
    .state('login', {
        url: '/login',
        templateUrl: 'login-page.php',
        controller: 'userCtrl'
    })
    .state('main', {
        url: '/main',
        templateUrl: 'main.php',
        controller: 'userCtrl'
    })
    .state('main.admin-dashboard', {
        url: '/admin/dashboard',
        templateUrl: 'admin/admin-dashboard.php',
        controller: 'adminCtrl'
    })
    .state('main.bursary-dashboard', {
        url: '/bursary/dashboard',
        templateUrl: 'bursary/bursary-dashboard.php',
        controller: 'bursaryCtrl'
    })
    .state('main.counselor-dashboard', {
        url: '/counselor/dashboard',
        templateUrl: 'counselor/counselor-dashboard.php',
        controller: 'counselorCtrl'
    })
    .state('main.cases', {
        url: '/counselor/cases',
        templateUrl: 'counselor/cases.php',
        controller: 'counselorCtrl'
    })
    .state('main.reports', {
        url: '/counselor/reports',
        templateUrl: 'counselor/reports.php',
        controller: 'counselorCtrl'
    });

    
});

app.run(function($rootScope) {
    
    // $rootScope.url = "http://localhost:8080/iukl-semms/semms";
    $rootScope.url = "http://semms.ddns.net:8080/iukl-semms/semms";

    $rootScope.button = false;
  });
