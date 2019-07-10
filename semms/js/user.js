var app = angular.module('user', []);
app.controller('userCtrl', function($scope, $http, $route, $timeout, $window, $location, $state, $rootScope){
    angular.element(document).ready(function(){
        $('#loginAlert').hide();
        $('#confirmPasswordAlert').hide();
    });

    $scope.checkSession = function(){
        $http({
            method : "GET",
            url : $rootScope.url + "/api/user/redirect.php",
            dataType: "application/json"
        })
        .then(function mySuccess(response) {
            if (response.data.url != null){
                $('#loginModal').modal('hide');
                $state.go(response.data.url, null, {
                    location: 'replace'
                });
            }
            else{
                $('#loginModal').modal('show');
                $state.go("login", null, {
                    location: 'replace'
                });
            }
        }, 
        function myError(response) {
                // console.log("Error");
          });
    }

    $scope.getSession = function(){
        $http({
            method : "GET",
            url : $rootScope.url + "/api/user/read-user-session-data.php",
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
            url : $rootScope.url + "/api/user/login-web.php",
            data: data,
            dataType: "application/json"
        })
        .then(function mySuccess(response) {
            if (response.data.message == 'Access Granted'){
                $scope.staff_id = "";
                $scope.password = "";
                $state.go("main", null, {
                    location: 'replace'
                });
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
            url : $rootScope.url + "/api/user/logout-user.php",
            dataType: "application/json"
        })
        .then(function mySuccess(response) {
            if (response.data.message == "Success"){
                $state.go("login", null, {
                    location: 'replace'
                });
            }
            
        }, 
        function myError(response) {
                // console.log(JSON.stringify(response));
          });
    }

    $scope.openEditProfileModal = function(){
        $http({
            method : "GET",
            url : $rootScope.url + "/api/user/read-user-session-data.php",
            dataType: "application/json"
        })
        .then(function mySuccess(response) {
            if (response.data != ""){
                $('#editProfileModal').modal('show');
                $scope.edit = response.data.user_session;
            }
        }, 
        function myError(response) {
                // console.log("Error");
        });
    };

    $scope.saveEditProfile = function(edit){
        if (edit.change_password && edit.new_password != undefined && edit.confirm_password != undefined){
            if (edit.confirm_password != edit.new_password){
                $('#confirmPasswordAlert').show();
            }
            else{
                $('#confirmPasswordAlert').hide();

            }
        }
        var data = {
            user_id: edit.user_id,
            name: edit.name,
            email: edit.email,
            contact_no: edit.contact_no,
            password: edit.new_password
        };

        $http({
            method : "PUT",
            url : $rootScope.url + "/api/user/update-user-data.php",
            data: data,
            dataType: "application/json"
        })
        .then(function mySuccess(response) {
            console.log(response.data.message);
        }, 
        function myError(response) {
                console.log("Error");
        });
        

        
    };
});