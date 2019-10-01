var app = angular.module('semms', ['ui.bootstrap', 'ui.router', 'ngRoute', 'admin', 'user', 'bursary', 'counselor']);
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
    .state('main.case-details', {
        url: '/counselor/cases/case-details?id',
        templateUrl: 'views/counselor/case-details.php',
        controller: 'counselorCtrl'
    })
    .state('main.reports', {
        url: '/counselor/reports',
        templateUrl: 'views/counselor/reports.php',
        controller: 'counselorCtrl'
    })
    .state('main.payments', {
        url: '/counselor/payments',
        templateUrl: 'views/counselor/payments.php',
        controller: 'counselorCtrl'
    })
    .state('main.permission-denied', {
        url: '/403',
        templateUrl: 'views/403.php',
        controller: 'userCtrl'
    });
});

app.run(function($rootScope, $http, $state, $timeout, $uibModal) {
    $rootScope.openLoadingModal = function(callback){
        var modal;
        modal =  $uibModal.open({
            // templateUrl: "views/modals/loadingModal.php",
            templateUrl: "views/modals/loading-modal.php",
            backdropClass: 'dark-backdrop',
            windowClass : 'show',
            backdrop: 'static',
            keyboard: false,
            windowTemplateUrl: "views/modal-window.php",
            size: 'sm',
            controller: function ($scope, $uibModalInstance) {
                callback($uibModalInstance);
              }
          });
        
        modal.result.then(function(){
            //Get triggers when modal is closed
        }, function(){
            //gets triggers when modal is dismissed.
        });
    };
    
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
                        location: 'replace',
                        reload: true
                    });
                 })
            }
            callback();
        }, 
        function myError(response) {
            callback();
          });
    }
  });
