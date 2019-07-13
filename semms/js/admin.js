var app = angular.module('admin', []);
app.controller('adminCtrl', function($scope, $http, $route, $timeout, $window, $location, $rootScope, $state){

    // angular.element(document).ready(function () {     
    //     $('#userTable').hide();
    //     $('#confirmPasswordAlert').hide();
    // });
    
    var table;

    $scope.initDOMAdmin = function(){
        $('#userTable').hide();
        $('#confirmPasswordAlert2').hide();
    };

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
            method : "POST",
            url : $rootScope.url + "/api/user/read.php",
            dataType: "application/json;",
        })
        .then(function mySuccess(response) {
            $scope.allUser = response.data.data;
            if($scope.allUser != ""){
                $timeout(function() {
                    table = $('#userTable').DataTable({
                        pageLength: 5,
                        lengthMenu: [ 5, 10, 25, 50, 100 ],
                        dom: 't, p'
                    });
                    $('#userTable').show();
                    $('#loading').hide();
                }, 500);
            }
        }, 
        function myError(response) {
            console.log(response);
        });
    };

    $scope.openEditUserDataModal = function(user){
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
                $scope.edit = response.data.data[0];
                $('#editUserDataModal').modal('show');
            }
            
            
        }, 
        function myError(response) {
            // console.log(response);
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
                                $('#editUserDataModal').modal('hide');
                                var box = bootbox.dialog({
                                    message: "<strong>Success!</strong>",
                                    backdrop: false,
                                    size: 'small'
                                });
                                box.find('.modal-content').addClass('text-success border border-success');
                                box.find('.modal-dialog').addClass('float-right mr-3').css({'width': '100%'});
                                setTimeout(function() {
                                    box.modal('hide');
                                }, 1000);
                                $state.reload();
                            }
                            else{
                                var box = bootbox.dialog({
                                    message: "<strong>Failed! "+ response.data.message +"</strong>",
                                    backdrop: false,
                                    size: 'small'
                                });
                                box.find('.modal-content').addClass('text-danger border border-danger');
                                box.find('.modal-dialog').addClass('float-right mr-3').css({'width': '100%'});
                                setTimeout(function() {
                                    box.modal('hide');
                                }, 1000);
                            }
                        }, 
                        function myError(response) {
                            var box = bootbox.dialog({
                                message: "<strong>Error!</strong>",
                                backdrop: false,
                                size: 'small'
                            });
                            box.find('.modal-content').addClass('text-danger border border-danger');
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
});