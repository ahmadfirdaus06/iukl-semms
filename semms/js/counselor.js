var app = angular.module('counselor', []);
app.controller('counselorCtrl', function($scope, $rootScope, $http, $route, $timeout, $window, $location, $state){

    //initiate dashboard element
    $scope.initDashboardDOM = function(callback){
        $('#content').css({'visibility': 'hidden'});
        callback();
    };

    //redirect
    $scope.go = function(path){
        $state.go(path, null, {
            location: 'replace'
        });
    };

    //finish dashboard function before load page
    $scope.getDashboard = function(){
        $rootScope.loadingModal.show();
        $scope.verifySession(function(){
            $scope.initDashboardDOM(function(){
                $scope.getAllNotifications(function(){
                    $scope.getReportCount(function(){
                        $('#content').css({'visibility': 'visible'});
                        $rootScope.loadingModal.hide();
                    });
                });
            });
        }); 
    };

    //get all notifications data
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
                        $scope.createNotificationTable();
                        callback();
                    }, 500); 
                    
                }
            }
        }, 
        function myError(response) {
            callback();
        });
    };

    //create notification table
    $scope.createNotificationTable = function(){  
        $scope.notificationTable = $('#notificationTable').DataTable({
            pageLength: 10,
            destroy: true,
            lengthMenu: [ 5, 10, 25, 50, 100 ],
            dom: 't, p',
            scrollY: '50vh',
            columns: [
                { width: "5%" },
                null,
                null,
                { width: "5%" },
              ]
        });
    };

    //get report count
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

    //searchable tabke
    $scope.searchTable = function(text){
        $scope.notificationTable.search(text).draw();
    };

    //close notification modal
    $scope.closeNotificationDetailsModal = function(){
        $("#notificationDetailsModal").modal('hide');
        $("#notificationDetailsModal").on("hidden.bs.modal", function () {
            $state.reload();
        });
    };

    //open notification modal
    $scope.openNotificationDetailsModal = function(notification){
        var data = {
            notification_id: notification.notification_id
        }
        $rootScope.loadingModal.modal('show');
        $http({
            method : "POST",
            url : $rootScope.url + "/api/counselor/fetch-single-notification.php",
            data: data,
            dataType: "application/json;",
        })
        .then(function mySuccess(response) {
            if (response.data.message == 'Success'){
                setTimeout(function(){
                    $rootScope.loadingModal.modal('hide');
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

    //go to report detalis modal
    $scope.goToReportDetails = function(notification){
        $('#notificationDetailsModal').modal('hide');
        $("#notificationDetailsModal").on("hidden.bs.modal", function () {
            $scope.go('main.reports');
            $rootScope.loadingModal.on("hidden.bs.modal", function () {
            });
        });
    };

    
});