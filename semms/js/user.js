var app = angular.module('user', []);
app.controller('userCtrl', function($scope, $http, $route, $timeout, $window, $location){
    angular.element(document).ready(function(){
        $('#loginModal').modal('show');
        $('#loginAlert').hide();
        $scope.getSession();
    });

    $scope.hidePanel = function(){
        $('#header').hide();
        $('#footer').hide();
    }

    $scope.showPanel = function(){
        $('#header').show();
        $('#footer').show();
    }

    $scope.checkSession = function(){
        $http({
            method : "GET",
            url : "http://localhost:8080/iukl-semms/semms/api/user/redirect.php",
            dataType: "application/json"
        })
        .then(function mySuccess(response) {
            if (response.data.url != null){
                $('#loginModal').modal('hide');
                $location.path(response.data.url).replace();
                $scope.getSession();
                $scope.showPanel();
            }
        }, 
        function myError(response) {
                // console.log("Error");
          });
    }

    $scope.getSession = function(){
        $http({
            method : "GET",
            url : "http://localhost:8080/iukl-semms/semms/api/user/read-user-session-data.php",
            dataType: "application/json"
        })
        .then(function mySuccess(response) {
            if (response.data != ""){
                $scope.name = response.data.user_session.name;
                $scope.user_type = response.data.user_session.user_type;
                $scope.last_login = "Last login: " + (response.data.user_session.last_login);
            }
        }, 
        function myError(response) {
                // console.log("Error");
          });
    }

    $scope.login = function(){
        var data = {
            staff_id: $scope.staff_id,
            password: $scope.password
        };
        $http({
            method : "POST",
            url : "http://localhost:8080/iukl-semms/semms/api/user/login-web.php",
            data: data,
            dataType: "application/json"
        })
        .then(function mySuccess(response) {
            if (response.data.message == 'Access Granted'){
                $scope.checkSession();
            }
            else if (response.data.message == 'Access Denied'){
                $('#loginAlert').show();
            }
        }, 
        function myError(response) {
                // console.log(JSON.stringify(response));
          });
    }

    $scope.logout = function(){
        
        $http({
            method : "GET",
            url : "http://localhost:8080/iukl-semms/semms/api/user/logout-user.php",
            dataType: "application/json"
        })
        .then(function mySuccess(response) {
            $location.path(response.data.url).replace();
        }, 
        function myError(response) {
                // console.log(JSON.stringify(response));
          });
    }
});