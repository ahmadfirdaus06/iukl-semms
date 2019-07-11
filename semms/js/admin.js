var app = angular.module('admin', []);
app.controller('adminCtrl', function($scope, $http, $route, $timeout, $window, $location, $rootScope){

    angular.element(document).ready(function () {     
        $('#userTable').hide();
    });
    
    $scope.pageAccess = "Admin";

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

    $scope.getAllUser = function(){
        $http({
            method : "GET",
            url : $rootScope.url + "/api/user/read.php",
            dataType: "application/json"
        })
        .then(function mySuccess(response) {
            $scope.allUser = response.data.data;
            if($scope.allUser != ""){
                $timeout(function() {
                    $('#userTable').DataTable({
                        "pageLength": 5,
				        "lengthMenu": [ 5, 10, 25, 50, 100 ]
                    });
                    $('#userTable').show();
                    $('#loading').hide();
                }, 500);
            }
        }, 
        function myError(response) {
            console.log("Error");
        });
    };
});