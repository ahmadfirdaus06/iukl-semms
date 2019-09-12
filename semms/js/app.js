var app = angular.module('semms', ['ui.router', 'ngRoute', 'admin', 'user', 'bursary', 'counselor']);
app.config(function($stateProvider, $urlRouterProvider){
    
    $urlRouterProvider.otherwise('/login');

    $stateProvider
    .state('login', {
        url: '/login',
        templateUrl: 'views/login-page.php',
        controller: 'userCtrl'
    })
    .state('main', {
        url: '/main',
        templateUrl: 'views/main.php',
        controller: 'userCtrl'
    })
    .state('main.admin-dashboard', {
        url: '/admin/dashboard',
        templateUrl: 'views/admin/admin-dashboard.php',
        controller: 'adminCtrl'
    })
    .state('main.bursary-dashboard', {
        url: '/bursary/dashboard',
        templateUrl: 'views/bursary/bursary-dashboard.php',
        controller: 'bursaryCtrl'
    })
    .state('main.counselor-dashboard', {
        url: '/counselor/dashboard',
        templateUrl: 'views/counselor/counselor-dashboard.php',
        controller: 'counselorCtrl'
    })
    .state('main.cases', {
        url: '/counselor/cases',
        templateUrl: 'views/counselor/cases.php',
        controller: 'counselorCtrl'
    })
    .state('main.reports', {
        url: '/counselor/reports',
        templateUrl: 'views/counselor/reports.php',
        controller: 'counselorCtrl'
    })
    .state('main.permission-denied', {
        url: '/403',
        templateUrl: 'views/403.php',
        controller: 'userCtrl'
    })
});

app.run(function($rootScope, $location, $http, $state, $window, $timeout) {
    // $rootScope.url = "http://localhost:8080/iukl-semms/semms";
    $rootScope.url = "http://semms.ddns.net:8080/iukl-semms/semms";
    $rootScope.verifySession = function(callback){
        var data = {
            current_page: $state.current.name
        };
        $http({
            method : "POST",
            url : $rootScope.url + "/api/user/get-page-permission.php",
            data: data,
            dataType: "application/json"
        })
        .then(function mySuccess(response) {
            if (response.data.url !=  ''){
                $timeout(function(){
                    $state.go(response.data.url, null, {
                        location: 'replace'
                    });
                 })
            }
            callback({err: false})
        }, 
        function myError(response) {
            callback({err: false})
          });
    }
  });
