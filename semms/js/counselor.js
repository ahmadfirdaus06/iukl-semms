var app = angular.module('counselor', []);
app.controller('counselorCtrl', function($scope, $http, $route, $timeout, $window, $location, $state){

    $scope.pageAccess = "Counselor";

    $scope.checkAccess = function(){
        var data = {
            page_access: $scope.pageAccess
        }
        $http({
            method : "GET",
            url : "http://localhost:8080/iukl-semms/semms/api/user/redirect.php",
            data: data,
            dataType: "application/json"
        })
        .then(function mySuccess(response) {
            $location.path(response.data.url).replace();
        }, 
        function myError(response) {
                // console.log(JSON.stringify(response));
          });
        
    }

    $scope.go = function(path){
        $state.go(path, null, {
            location: 'replace'
        });
    }
});