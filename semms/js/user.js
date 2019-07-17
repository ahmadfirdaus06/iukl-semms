var app = angular.module('user', []);
app.controller('userCtrl', function($scope, $http, $route, $timeout, $window, $location, $state, $rootScope){

    $scope.initDOMLogin = function(){
        $('#loginAlert').hide();
        $('#loginSpinner').hide();
    };

    $scope.initDOMMain = function(){
        $('#confirmPasswordAlert1').hide();
        $('#logoutSpinner').hide();
        $('#saveSpinner').hide();
    };

    $scope.checkSession = function(){
        $("#loginModal").modal('show');
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
        $('#loginSpinner').show();
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
                $('#loginSpinner').hide();
                $scope.staff_id = "";
                $scope.password = "";
                $()
                $state.go("main", null, {
                    location: 'replace'
                });
            }
            else if (response.data.message == 'Access Denied'){
                $('#loginSpinner').hide();
                $('#loginAlert').show();
            }
        }, 
        function myError(response) {
            $('#loginSpinner').hide();
                // console.log(JSON.stringify(response));
          });
    }

    $scope.logout = function(){
        $('#logoutSpinner').show();
        $('#logoutIcon').hide();
        $http({
            method : "GET",
            url : $rootScope.url + "/api/user/logout-user.php",
            dataType: "application/json"
        })
        .then(function mySuccess(response) {
            if (response.data.message == "Success"){
                $('#logoutSpinner').hide();
                $('#logoutIcon').show();
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
                $('#confirmPasswordAlert1').show();
            }
            else{
                $('#confirmPasswordAlert1').hide();

            }
        }
        if (!$("#confirmPasswordAlert1").is(":visible")){
            bootbox.confirm({
                message: "Are you sure you want to update your profile?",
                buttons: {
                    confirm: {
                        label: 'Yes',
                        className: 'btn-success'
                    },
                    cancel: {
                        label: 'No',
                        className: 'btn-danger'
                    }
                },
                callback: function (result) {
                    if(result){
                        $('#saveSpinner').show();
                        $('#saveIcon').hide();
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
                            if (response.data.message == "User Data Updated"){
                                $('#saveSpinner').hide();
                                $('#saveIcon').show();
                                $('#editProfileModal').modal('hide');
                                var box = bootbox.dialog({
                                    message: "<strong>Success!</strong>",
                                    backdrop: false,
                                    size: 'small'
                                });
                                box.find('.modal-content').addClass('text-white bg-success');
                                box.find('.modal-dialog').addClass('float-right mr-3').css({'width': '100%'});
                                setTimeout(function() {
                                    box.modal('hide');
                                }, 1000);
                                $state.reload();
                            }
                            else{
                                $('#saveSpinner').hide();
                                $('#saveIcon').show();
                                var box = bootbox.dialog({
                                    message: "<strong>Failed! "+ response.data.message +"</strong>",
                                    backdrop: false,
                                    size: 'small'
                                });
                                box.find('.modal-content').addClass('text-white bg-danger');
                                box.find('.modal-dialog').addClass('float-right mr-3').css({'width': '100%'});
                                setTimeout(function() {
                                    box.modal('hide');
                                }, 1000);
                            }
                        }, 
                        function myError(response) {
                            $('#saveSpinner').hide();
                            $('#saveIcon').show();
                            var box = bootbox.dialog({
                                message: "<strong>Error!</strong>",
                                backdrop: false,
                                size: 'small'
                            });
                            box.find('.modal-content').addClass('text-white bg-danger');
                            box.find('.modal-dialog').addClass('float-right mr-3').css({'width': '100%'});
                            setTimeout(function() {
                                box.modal('hide');
                            }, 1000);
                        });         
                    }
                }
            });
        }
        
    };
});