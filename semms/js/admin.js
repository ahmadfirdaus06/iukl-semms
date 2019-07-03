var app = angular.module('admin', []);
app.controller('adminCtrl', function($scope, $http, $route, $timeout, $window){
    $scope.pageAccess = "Admin";

    $scope.checkAccess = function(){
        var data = {
            page_access: $scope.pageAccess
        }
        $http({
            method : "GET",
            url : "http://localhost:8080/iukl-semms/semms/api/user/redirect-access.php",
            data: data,
            dataType: "application/json"
        })
        .then(function mySuccess(response) {
            console.log(JSON.stringify(response.data));
            // $window.location.replace("#!" + response.data.url);
        }, 
        function myError(response) {
                // console.log(JSON.stringify(response));
          });
        
    }
});