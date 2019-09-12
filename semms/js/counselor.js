var app = angular.module('counselor', []);
app.controller('counselorCtrl', function($scope, $rootScope, $http, $route, $timeout, $window, $location, $state){

    $scope.initDOM = function(){
        $('#notificationTable').hide();
    };

    $scope.go = function(path){
        $state.go(path, null, {
            location: 'replace'
        });
    };

    $scope.get = function(){
        $('#content').hide();
        $('#loadingModal').modal('show');
        $scope.verifySession(function(data){
            if (!data.err){
                $scope.getAllNotifications(function(data){
                    if (data){
                        $scope.getReportCount(function(data){
                            if (data){
                                $('#content').show();
                                $('#loadingModal').modal('hide');
                            }
                        });
                    }
                });
            }
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
                    }, 500);    
                    $('#notificationTable').show();
                    callback(true)
                }
            }
        }, 
        function myError(response) {
            callback(true)
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
                callback(true)
            }
        }, 
        function myError(response) {
            callback(true)
        });
    };

    $scope.searchTable = function(text){
        // var table = $scope.table;
        table.search(text).draw();
    };
});