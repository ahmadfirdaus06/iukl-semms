var app = angular.module('user', []);
app.controller('userCtrl', function($scope, $http, $route, $timeout){
    $scope.checkAccess = function(){
        $('#loginModal').modal('show');
        $('#loginAlert').hide();
    }
});