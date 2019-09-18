var app = angular.module('counselor', []);
app.controller('counselorCtrl', function($scope, $rootScope, $http, $timeout, $state, $uibModal){

    //initiate dashboard page element
    $scope.initDashboardDOM = function(callback){
        $('#content').css({'display': 'none'});
        callback();
    };

    //initiate report page element
    $scope.initReportDOM = function(callback){
        $('#content').css({'display': 'none'});
        callback();
    };

    //redirect
    $scope.go = function(path){
        $state.go(path, null, {
            location: 'replace',
            reload: true
        });
    };
    
    //finish dashboard function before load page
    $scope.getDashboard = function(){
        $rootScope.openLoadingModal(function(modal){
            $scope.loadingModal = modal;
        });
        $scope.verifySession(function(){
            $scope.initDashboardDOM(function(){
                $scope.getAllNotifications(function(){
                    $scope.getReportCount(function(){
                        $timeout(function(){
                            $scope.loadingModal.dismiss();
                            $scope.loadingModal.closed.then(function(){
                                $('#content').css({'display': 'block'});
                                $scope.createNotificationTable();
                            });
                        }, 500);
                    });
                });
            });
        }); 
    };

    //finish report function before load page
    $scope.getReport = function(){
        $rootScope.openLoadingModal(function(modal){
            $scope.loadingModal = modal;
        });
        $scope.verifySession(function(){
            $scope.initReportDOM(function(){
                $scope.getAllReports(function(){
                    $timeout(function(){
                        $scope.loadingModal.dismiss();
                        $scope.loadingModal.closed.then(function(){
                            $('#content').css({'display': 'block'});
                            $scope.createReportTable();
                        });
                    }, 500);
                    
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
                // $timeout(function() {
                //     $scope.createNotificationTable();
                    callback();
                // }, 500); 
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

    //create report tables
    $scope.createReportTable = function(){  
        $scope.reportTable1 = $('#reportTable1').DataTable({
            pageLength: 5,
            destroy: true,
            lengthMenu: [ 5, 10, 25, 50, 100 ],
            dom: 't, p',
            scrollY: '50vh',
            scrollCollapse: true,
            columns: [
                { width: "5%" },
                { width: "10%" },
                null,
                { width: "10%" },
                { width: "5%" },
              ]
        });
        $scope.reportTable2 = $('#reportTable2').DataTable({
            pageLength: 5,
            destroy: true,
            lengthMenu: [ 5, 10, 25, 50, 100 ],
            dom: 't, p',
            scrollY: '50vh',
            scrollCollapse: true,
            columns: [
                { width: "5%" },
                { width: "10%" },
                null,
                { width: "10%" },
                { width: "5%" },
              ]
        });
        $scope.unreadCount = $scope.reportTable1.rows().count();
        $scope.reportCount = $scope.reportTable2.rows().count();
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

    //searchable notification table
    $scope.searchNotificationTable = function(text){
        $scope.notificationTable.search(text).draw();
    };

    //searchable report table
    $scope.searchReportTable = function(text){
        $scope.reportTable2.search(text).draw();
    };

    //open notification modal
    $scope.openNotificationDetailsModal = function(notification){
        var data = {
            notification_id: notification.notification_id
        }
        $rootScope.openLoadingModal(function(modal){
            $scope.loadingModal = modal;
        });
        $http({
            method : "POST",
            url : $rootScope.url + "/api/counselor/fetch-single-notification.php",
            data: data,
            dataType: "application/json;",
        })
        .then(function mySuccess(response) {
            if (response.data.message == 'Success'){
                setTimeout(function(){
                    $scope.loadingModal.dismiss();
                }, 500);
                $scope.loadingModal.closed.then(function(){
                    var modal;
                    modal =  $uibModal.open({
                        templateUrl: "views/modals/notification-details-modal.php",
                        backdropClass: 'dark-backdrop',
                        windowClass : 'show',
                        backdrop: 'static',
                        keyboard: false,
                        windowTemplateUrl: "views/modal-window.php",
                        size: 'md',
                        controller: function ($scope, $uibModalInstance, notification, openReportDetailsModal) {
                            $scope.notification = notification;

                            $scope.openReportDetails = function () {
                                $uibModalInstance.dismiss();
                                $uibModalInstance.closed.then(function(){
                                    openReportDetailsModal(notification);
                                });

                            };
                            
                            $scope.close = function () {
                                $uibModalInstance.dismiss();
                                $uibModalInstance.closed.then(function(){
                                    $state.reload();
                                });
                            };
                        },
                        resolve:{
                            notification: function(){
                                return response.data.notification[0];
                            },
                            openReportDetailsModal: function(){
                                return $scope.openReportDetailsModal;
                            }
                        }
                    });
                    
                    modal.result.then(function(){
                        //Get triggers when modal is closed
                    }, function(){
                        //gets triggers when modal is dismissed.
                    });
                });
            }
        }, 
        function myError(response) {
            console.log(response);
        });
    };

    //get all reports
    $scope.getAllReports = function(callback){
        $http({
            method : "GET",
            url : $rootScope.url + "/api/counselor/fetch-all-reports.php",
            dataType: "application/json;",
        })
        .then(function mySuccess(response) {
            if (response.data.message == 'Success'){
                $scope.reportList = response.data.reportList;
                $scope.pendingList = response.data.pendingList;
                callback(); 
            }
        }, 
        function myError(response) {
            callback();
        });
    };



    //open report details modal
    $scope.openReportDetailsModal = function(report){
        $rootScope.openLoadingModal(function(modal){
            $scope.loadingModal = modal;
        });
        var temp_id1 = report.related_id;
        var temp_id2 = report.report_id
        var id = "";
        
        if (temp_id1 != undefined){
            id = temp_id1;
        }
        else if (temp_id2 != undefined){
            id = temp_id2;
        }

        var data = {
            report_id: id
        };
        
        $http({
            method : "POST",
            url : $rootScope.url + "/api/counselor/fetch-single-report.php",
            data: data,
            dataType: "application/json;",
        })
        .then(function mySuccess(response) {
            if (response.data.message == 'Success'){
                setTimeout(function(){
                    $scope.loadingModal.dismiss();
                }, 500);

                $scope.loadingModal.closed.then(function(){
                    var modal;
                    modal =  $uibModal.open({
                        templateUrl: "views/modals/report-details-modal.php",
                        backdropClass: 'dark-backdrop',
                        windowClass : 'show',
                        backdrop: 'static',
                        keyboard: false,
                        windowTemplateUrl: "views/modal-window.php",
                        size: 'lg',
                        controller: function ($scope, $uibModalInstance, report, student, reporter, attachmentList, misconductList) {
                            $scope.report = report;
                            $scope.student = student;
                            $scope.reporter = reporter;
                            $scope.attachmentList = attachmentList;
                            $scope.misconductList = misconductList;

                            $scope.later = function () {
                                $uibModalInstance.dismiss();

                            };
                        },
                        resolve:{
                            report: function(){
                                return response.data.report[0];
                            },
                            student: function(){
                                return response.data.student[0];
                            },
                            reporter: function(){
                                return response.data.reporter[0];
                            },
                            attachmentList: function(){
                                return response.data.attachmentList;
                            },
                            misconductList: function(){
                                return response.data.misconductList;
                            }
                        }
                    });
                    
                    modal.result.then(function(){
                        //Get triggers when modal is closed
                    }, function(){
                        //gets triggers when modal is dismissed.
                    });
                });
            }
        }, 
        function myError(response) {
            setTimeout(function(){
                $scope.loadingModal.dismiss();
            }, 500);
        });
        
    };
    
});