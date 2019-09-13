var app = angular.module('counselor', []);
app.controller('counselorCtrl', function($scope, $rootScope, $http, $route, $timeout, $window, $location, $state){

    var table;
    $scope.unreadCount = "";
    $scope.notificationList = {};

    $scope.initDOM = function(callback){
        $('#content').css({'visibility': 'hidden'});
        callback();
    };

    $scope.go = function(path){
        $state.go(path, null, {
            location: 'replace',
            reload: true
        });
    };

    $scope.get = function(){
        $('#loadingModal').modal('show');
        $scope.verifySession(function(){
            $scope.initDOM(function(){
                $scope.getAllNotifications(function(){
                    $scope.getReportCount(function(){
                        $('#content').css({'visibility': 'visible'});
                        $('#loadingModal').modal('hide');
                    });
                });
            });
        }); 
    };

    $scope.getAllNotifications = function(callback){
        $http({
            method : "GET",
            url : $rootScope.url + "/api/counselor/fetch-all-notifications.php",
            dataType: "application/json;",
        })
        .then(function mySuccess(response) {
            if (response.data.message == 'Success'){
                $scope.notificationList = response.data.notificationList;
                $scope.unreadCount = response.data.unreadCount;
                if($scope.notificationList != ""){
                    $timeout(function() {
                        table = $('#notificationTable').DataTable({
                            pageLength: 10,
                            destroy: true,
                            lengthMenu: [ 5, 10, 25, 50, 100 ],
                            dom: 't, p',
                            scrollY: '50vh',
                            scrollCollapse: true,
                            columns: [
                                { width: "5%" },
                                null,
                                null,
                                { width: "5%" },
                              ]
                        });
                        callback();
                    }, 500);   
                }
            }
        }, 
        function myError(response) {
            callback();
        });
    };

    $scope.getReportCount = function(callback){
        $http({
            method : "GET",
            url : $rootScope.url + "/api/counselor/fetch-report-count.php",
            dataType: "application/json;",
        })
        .then(function mySuccess(response) {
            if (response.data.message == 'Success'){
                $scope.reportCount = response.data.reportCount;
                callback();
            }else{
                $scope.reportCount = '0';
                callback();
            }
        }, 
        function myError(response) {
            callback();
        });
    };

    $scope.searchTable = function(text){
        // var table = $scope.table;
        table.search(text).draw();
    };

    $scope.closeNotificationDetailsModal = function(){
        $("#notificationDetailsModal").modal('hide');
        $("#notificationDetailsModal").on("hidden.bs.modal", function () {
            $window.location.reload();
        });
    };

    $scope.openNotificationDetailsModal = function(notification){
        var data = {
            notification_id: notification.notification_id
        }
        $('#loadingModal').modal('show');
        $http({
            method : "POST",
            url : $rootScope.url + "/api/counselor/fetch-single-notification.php",
            data: data,
            dataType: "application/json;",
        })
        .then(function mySuccess(response) {
            if (response.data.message == 'Success'){
                setTimeout(function(){
                    $('#loadingModal').modal('hide');
                }, 500);
                $scope.notification = response.data.notification[0];
                $("#loadingModal").on("hidden.bs.modal", function () {
                    $('#notificationDetailsModal').modal('show');
                });
            }
        }, 
        function myError(response) {
            console.log(response);
        });
        
    };

    $scope.goToReportDetails = function(notification){
        $('#notificationDetailsModal').modal('hide');
        $("#notificationDetailsModal").on("hidden.bs.modal", function () {
            $scope.go('main.reports');
            $("#loadingModal").on("hidden.bs.modal", function () {
                console.log("Open Modal");
            });
        });
    };

    
});