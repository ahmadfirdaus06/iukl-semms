var app = angular.module('admin', []);
app.controller('adminCtrl', function($scope, $http, $route, $timeout, $window, $location, $rootScope, $state){
    
    var table;

    $scope.initDOMAdmin = function(callback){
        $('#userTable').hide();
        $('#confirmPasswordAlert2').hide();
        $('#existedIdAlert').hide();
        $('#deleteSpinner').hide();
        $('#editUserDataModal #saveSpinner').hide();
        $('#addNewUserModal #saveSpinner').hide();
        callback();
    };

    $scope.get = function(){
        $('#content').hide();
        $('#loadingModal').modal('show');
        $scope.verifySession(function(){
            $scope.initDOMAdmin(function(){
                $scope.getAllUser(function(){
                    $('#content').show();
                    $('#loadingModal').modal('hide');
                });
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
                    table = $('#userTable').DataTable({
                        pageLength: 5,
                        lengthMenu: [ 5, 10, 25, 50, 100 ],
                        dom: 't, p'
                    });
                    $('#userTable').show();
                    $('#loading').hide();
                    callback();
                }, 500);
            }
        }, 
        function myError(response) {
            callback();
        });
    };

    $scope.openEditUserDataModal = function(user){
        $('#loadingModal').modal('show');
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
                    $('#loadingModal').modal('hide');
                }, 500);
                $scope.edit = response.data.data[0];
                $("#loadingModal").on("hidden.bs.modal", function () {
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
                        }, 
                        function myError(response) {
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
                    }
                }
            });
        }
        
    };

    $scope.searchTable = function(text){
        // var table = $scope.table;
        table.search(text).draw();
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
                        }, 
                        function myError(response) {
                            // console.log(response);
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

    $scope.removeUser = function(user){
        bootbox.confirm({
            message: "<p class='text-danger'><strong><i class='fas fa-exclamation-triangle'></i> Are you sure you want to remove this user?</strong></p><br>" + 
            "<p class='text-danger'>Removing such user could cause error in database record!</p>" +
            "<br>Staff ID => " + user.staff_id +
            "<br>Name => " + user.name +
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
                if (result){
                    $('#deleteSpinner').show();
                    $('#deleteIcon').hide();
                    var data = {
                        user_id: user.user_id
                    };

                    $http({
                        method : "DELETE",
                        url : $rootScope.url + "/api/user/delete.php",
                        data: data,
                        dataType: "application/json"
                    })
                    .then(function mySuccess(response) {
                        if (response.data.message == "User Deleted"){
                            $('#deleteSpinner').hide();
                            $('#deleteIcon').show();
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
                            $('#deleteSpinner').hide();
                            $('#deleteIcon').show();
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
                        $('#deleteSpinner').hide();
                        $('#deleteIcon').show();
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
                }
            }
        });

    };
});