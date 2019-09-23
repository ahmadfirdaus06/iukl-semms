var app = angular.module('admin', []);
app.controller('adminCtrl', function($scope, $http, $timeout, $rootScope, $state){

    $scope.getDashboard = function(){
        $rootScope.openLoadingModal(function(modal){
            $scope.loadingModal = modal;
        });
        $scope.verifySession(function(){
            $scope.getAllUser(function(){
                $timeout(function(){
                    $scope.loadingModal.dismiss();
                    $scope.loadingModal.closed.then(function(){
                        $('#content').css({'display': 'block'});
                        $scope.createUserTable();
                    });
                },500);
            });
        }); 
    }

    $scope.getAllUser = function(callback){
        $http({
            method : "POST",
            url : $rootScope.url + "/api/user/read.php",
            dataType: "application/json;",
        })
        .then(function mySuccess(response) {
            $scope.allUser = response.data.data;
            $scope.totalUser = response.data.data.length;
            if($scope.allUser != ""){
                $timeout(function() {
                    callback();
                }, 500);
            }
        }, 
        function myError(response) {
            callback();
        });
    };

    $scope.createUserTable = function(){
        $scope.userTable = $('#userTable').DataTable({
            destroy: true,
            pageLength: 10,
            destroy: true,
            dom: 't, p',
            scrollY: '40vh',    
        });
    };

    $scope.openEditUserDataModal = function(user){
        $rootScope.openLoadingModal(function(modal){
            $loadingModal = modal;
        });
        var data = {
            user_id: user.user_id
        };
        $http({
            method : "POST",
            url : $rootScope.url + "/api/user/read.php",
            dataType: "application/json;",
            data: data
        })
        .then(function mySuccess(response) {
            if (response.data.data != ""){
                setTimeout(function(){
                    $loadingModal.dismiss();
                }, 500);
                $scope.edit = response.data.data[0];
                $scope.loadingModal.closed.then(function(){
                    $('#editUserDataModal').modal('show');
                });
            }
        }, 
        function myError(response) {
            // console.log(response);
            $rootScope.button = false;
        });
        
    };

    $scope.saveEditUserData = function(edit){
        if (edit.change_password && edit.new_password != undefined && edit.confirm_password != undefined){
            if (edit.confirm_password != edit.new_password){
                $('#confirmPasswordAlert2').show();
            }
            else{
                $('#confirmPasswordAlert2').hide();

            }
        }
        if (!$("#confirmPasswordAlert2").is(":visible")){
            bootbox.confirm({
                message: "Are you sure you want to update user record?",
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
                        $('#editUserDataModal #saveSpinner').show();
                        $('#editUserDataModal #saveIcon').hide();
                        $rootScope.openLoadingModal(function(modal){
                            $scope.loadingModal = modal;
                        });
                        var data = {
                            user_id: edit.user_id,
                            name: edit.name,
                            email: edit.email,
                            contact_no: edit.contact_no,
                            password: edit.new_password,
                            user_type: edit.user_type,
                            staff_id: edit.staff_id,
                            granted_access: edit.granted_access
                        };
                
                        $http({
                            method : "PUT",
                            url : $rootScope.url + "/api/user/update-user-data.php",
                            data: data,
                            dataType: "application/json"
                        })
                        .then(function mySuccess(response) {
                            $timeout(function(){
                                $scope.loadingModal.dismiss();
                            },500);
                            $scope.loadingModal.closed.then(function(){
                                if (response.data.message == "User Data Updated"){
                                    $('#editUserDataModal #saveSpinner').hide();
                                    $('#editUserDataModal #saveIcon').show();
                                    $('#editUserDataModal').modal('hide');
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
                                    $('#editUserDataModal #saveSpinner').hide();
                                    $('#editUserDataModal #saveIcon').show();
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
                            });
                            
                        }, 
                        function myError(response) {
                            console.log(response);
                            $scope.loadingModal.dismiss();
                            $scope.loadingModal.closed.then(function(){
                                $('#editUserDataModal #saveSpinner').hide();
                                $('#editUserDataModal #saveIcon').show();
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

    $scope.searchTable = function(text){
        $scope.userTable.search(text).draw();
    };

    $scope.checkExistingId = function(text){
        if (text != ""){
            var data = {
                staff_id: text
            };
            $http({
                method : "POST",
                url : $rootScope.url + "/api/user/check-existing-user.php",
                data: data,
                dataType: "application/json"
            })
            .then(function mySuccess(response) {
                if (response.data.message == "User Existed"){
                    $('#existedIdAlert').show();
                }
                else{
                    $('#existedIdAlert').hide();
                }

            }, 
            function myError(response) {
                console.log(response);
            });    
        }
    };

    $scope.registerUser = function(user){
        if (!$("#existedIdAlert").is(":visible")){
            bootbox.confirm({
                message: "<strong><i class='fas fa-exclamation-triangle'></i> Are you sure you want to register user with this information?</strong><br>" +
                "<br>Staff ID => " + user.staff_id +
                "<br>Name => " + user.name +
                "<br>Email => " + user.email +
                "<br>Contact Number => " + user.contact_no +
                "<br>Access => " + user.user_type,
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
                    $('#addNewUserModal #saveSpinner').show();
                    $('#addNewUserModal #saveIcon').hide();
                    if (result){
                        $rootScope.openLoadingModal(function(modal){
                            $scope.loadingModal = modal;
                        });
                        var data = {
                            staff_id: user.staff_id,
                            name: user.name,
                            email: user.email,
                            contact_no: user.contact_no,
                            user_type: user.user_type
                        };
                
                        $http({
                            method : "POST",
                            url : $rootScope.url + "/api/user/create.php",
                            data: data,
                            dataType: "application/json"
                        })
                        .then(function mySuccess(response) {
                            $scope.loadingModal.dismiss();
                            $scope.loadingModal.closed.then(function(){
                                if (response.data.message == "User Created"){
                                    $('#addNewUserModal #saveSpinner').hide();
                                    $('#addNewUserModal #saveIcon').show();
                                    $('#addNewUserModal').modal('hide');
                                        var box = bootbox.dialog({
                                            message: "<strong>Success!</strong><br>Instruct user to login and change the default password => 123",
                                            backdrop: false,
                                        });
                                        box.find('.modal-content').addClass('text-white bg-success');
                                        setTimeout(function() {
                                            box.modal('hide');
                                        }, 5000);
                                        $state.reload();
                                }
                                else{
                                    $('#addNewUserModal #saveSpinner').hide();
                                    $('#addNewUserModal #saveIcon').show();
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
                            });
                        }, 
                        function myError(response) {
                            console.log(response);
                            $scope.loadingModal.dismiss();
                            $scope.loadingModal.closed.then(function(){
                                $('#addNewUserModal #saveSpinner').hide();
                                $('#addNewUserModal #saveIcon').show();
                                var box = bootbox.dialog({
                                    message: "<strong>Error! "+ response.data.message +"</strong>",
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

    $scope.cancelRegisterUser = function(user){
        if (user != undefined){
            bootbox.confirm({
                message: "Discard changes?",
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
                    if (result){
                        $("#addNewUserModalForm").trigger('reset');
                        $scope.new = undefined;
                        $('#addNewUserModal').modal('hide');
                    }
                }
            });
        }
        else{
            $("#addNewUserModalForm").trigger('reset');
            $scope.new = undefined;
            $('#addNewUserModal').modal('hide');
        }
    };

    // $scope.openAddNewUserModal = function(){
    //     $scope.addUserModal = $uibModal.open({
    //         templateUrl: "views/modals/add-new-user-modal.php",
    //         backdropClass: 'dark-backdrop',
    //         windowClass : 'show',
    //         backdrop: 'static',
    //         keyboard: false,
    //         windowTemplateUrl: "views/modal-window.php",
    //         size: 'md',
    //         controller: function ($scope, $uibModalInstance) {
                
    //         },
    //         resolve:{
    //         }
    //     });
        
    //     $scope.addUserModal.result.then(function(){
    //         //Get triggers when modal is closed
    //     }, function(){
    //         //gets triggers when modal is dismissed.
    //     });
    // };
});