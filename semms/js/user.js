var app = angular.module('user', []);
app.controller('userCtrl', function($timeout, $scope, $http, $state, $rootScope, $uibModal){

    $scope.checkSession = function(){
        $http({
            method : "GET",
            url : $rootScope.url + "/api/user/redirect.php",
            dataType: "application/json"
        })
        .then(function mySuccess(response) {
            if (response.data.url != null){
                if ($scope.loginModal != undefined){
                    $scope.loginModal.dismiss();
                }
                $state.go(response.data.url, null, {
                    location: 'replace'
                });
            }
            else{
                $scope.loginModal =  $uibModal.open({
                    templateUrl: "views/modals/login-modal.php",
                    backdropClass: 'dark-backdrop',
                    windowClass : 'show',
                    backdrop: 'static',
                    keyboard: false,
                    size: 'md',
                    windowTemplateUrl: "views/modal-window.php",
                    controller: function ($scope, $uibModalInstance, login) {
                        
                        $scope.login = function(){
                            login($scope.staff_id, $scope.password);
                        };
                    },
                    resolve:{
                        login: function(){
                            return $scope.login;
                        }
                    }
                });
                
                $scope.loginModal.result.then(function(){
                    //Get triggers when modal is closed
                }, function(){
                    //gets triggers when modal is dismissed.
                });
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

    $scope.login = function(staff_id, password){
        $('#loginSpinner').show();
        var data = {
            staff_id: staff_id,
            password: password
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
                $scope.checkSession();
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
        $rootScope.openLoadingModal(function(modal){
            $scope.loginModal = modal;
        });
        $http({
            method : "GET",
            url : $rootScope.url + "/api/user/logout-user.php",
            dataType: "application/json"
        })
        .then(function mySuccess(response) {
            if (response.data.message == "Success"){
                $('#logoutSpinner').hide();
                $('#logoutIcon').show();
                $timeout(function(){
                    $scope.loginModal.dismiss();
                }, 500);
                $scope.loginModal.closed.then(function(){
                    $state.go("login", null, {
                        location: 'replace'
                    });
                });
                
            }
            
        }, 
        function myError(response) {
                // console.log(JSON.stringify(response));
          });
    }

    $scope.openEditProfileModal = function(){
        $rootScope.openLoadingModal(function(modal){
            $scope.loadingModal = modal;
        });
        $http({
            method : "GET",
            url : $rootScope.url + "/api/user/read-user-session-data.php",
            dataType: "application/json"
        })
        .then(function mySuccess(response) {
            if (response.data != ""){
                $timeout(function(){
                    $scope.loadingModal.dismiss();
                }, 500);
                $scope.loadingModal.closed.then(function(){
                    $scope.editProfileModal = $uibModal.open({
                        templateUrl: "views/modals/edit-profile-modal.php",
                        backdropClass: 'dark-backdrop',
                        windowClass : 'show',
                        backdrop: 'static',
                        keyboard: false,
                        windowTemplateUrl: "views/modal-window.php",
                        size: 'lg',
                        controller: function ($scope, $uibModalInstance, edit, save) {
                            
                            $scope.edit = edit;

                            $scope.save = function(){
                                save($scope.edit);
                            }

                            $scope.close = function(){
                                $uibModalInstance.dismiss();
                            };
                            
                        },
                        resolve:{
                            edit: function(){
                                return response.data.user_session;
                            },
                            save: function(){
                                return $scope.saveEditProfile;
                            }
                            
                        }
                    });
                    
                    $scope.editProfileModal.result.then(function(){
                        //Get triggers when modal is closed
                    }, function(){
                        //gets triggers when modal is dismissed.
                    });
                });
                
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
                        $rootScope.openLoadingModal(function(modal){
                            $scope.loadingModal = modal;
                        });
                        $('#editProfileModal #saveSpinner').show();
                        $('#editProfileModal #saveIcon').hide();
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
                                $timeout(function(){
                                    $scope.loadingModal.dismiss();
                                    $('#editProfileModal #saveSpinner').hide();
                                    $('#editProfileModal #saveIcon').show();
                                }, 500);
                                $scope.loadingModal.closed.then(function(){
                                    $scope.editProfileModal.dismiss();
                                });
                                $scope.editProfileModal.closed.then(function(){
                                    var box = bootbox.dialog({
                                        message: "<strong>Success!</strong>",
                                        backdrop: false,
                                        size: 'small'
                                    });
                                    box.find('.modal-content').addClass('text-white bg-success');
                                    box.find('.modal-dialog').addClass('float-right mr-3').css({'width': '100%', 'margin-top': '0 auto'});
                                    setTimeout(function() {
                                        box.modal('hide');
                                        $state.reload();
                                    }, 1000);
                                });
                            }
                            else{
                                $timeout(function(){
                                    $scope.loadingModal.dismiss();
                                    $('#editProfileModal #saveSpinner').hide();
                                    $('#editProfileModal #saveIcon').show();
                                }, 500);
                                $scope.loadingModal.closed.then(function(){
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
                                });
                            }
                        }, 
                        function myError(response) {
                            $timeout(function(){
                                $scope.loadingModal.dismiss();
                                $('#editProfileModal #saveSpinner').hide();
                                $('#editProfileModal #saveIcon').show();
                            }, 500);
                            $scope.loadingModal.closed.then(function(){
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
                        });         
                    }
                }
            });
        }
        
    };
});