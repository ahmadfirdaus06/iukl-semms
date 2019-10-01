var app = angular.module('counselor', []);

var today = new Date();

app.factory('data', function($http, $rootScope){
    return {
        getAllCases: function(){
            return $http({
                method : "GET",
                url : $rootScope.url + "/api/counselor/fetch-all-cases.php",
                dataType: "application/json;",
            });
        },
        getAllReports: function(){
            return $http({
                method : "GET",
                url : $rootScope.url + "/api/counselor/fetch-all-reports.php",
                dataType: "application/json;",
            });
        },
        getAllPayments: function(){
            return $http({
                method : "GET",
                url : $rootScope.url + "/api/counselor/fetch-all-payments.php",
                dataType: "application/json;",
            });
        },
        getAllNotifications: function(){
            return $http({
                method : "GET",
                url : $rootScope.url + "/api/counselor/fetch-all-notifications.php",
                dataType: "application/json;",
            });
        }
    }
});

app.controller('counselorCtrl', function($scope, $rootScope, $http, $timeout, $state, $uibModal, $stateParams, data, $q){

    //finish dashboard function before load page
    $scope.getDashboard = function(){
        $rootScope.openLoadingModal(function(modal){
            $scope.loadingModal = modal;
        });
        $scope.verifySession(function(){
            $q.all([
                data.getAllCases(),
                data.getAllReports(),
                data.getAllPayments(),
                data.getAllNotifications(),
            ]).then(function success(response){
                if (response[0].data.message == 'Success'){
                    $scope.caseCount = response[0].data.caseList.length;
                }
                if (response[1].data.message == 'Success'){
                    $scope.reportCount = response[1].data.reportList.length;
                }
                if (response[2].data.message == 'Success'){
                    $scope.paymentCount = response[2].data.paymentList.length;
                }
                if (response[3].data.message == 'Success'){
                    $scope.notificationList = response[3].data.notificationList;
                    $scope.unreadCount = response[3].data.unreadCount;
                }
                $timeout(function(){
                    $scope.loadingModal.dismiss();
                },500);
                $scope.loadingModal.closed.then(function(){
                    $('#content').css({'display': 'block'});
                    $scope.createNotificationTable();
                });
                
            },
            function error(response){
                console.log(response);
                $timeout(function(){
                    $scope.loadingModal.dismiss();
                },500);
                $scope.loadingModal.closed.then(function(){
                    $('#content').css({'display': 'block'});
                });
            });
        }); 
    };    
    
    //redirect
    $scope.go = function(path, id){
        if (id == null){
            $state.go(path, null, {
                location: 'replace',
                reload: true
            });
        }else{
            $state.go(path, ({id: id}), {
                location: 'replace',
                reload: true
            });
        }    
    };

    //finish report function before load page
    $scope.getReport = function(){
        $rootScope.openLoadingModal(function(modal){
            $scope.loadingModal = modal;
        });
        $scope.verifySession(function(){
            $scope.getAllReports(function(){
                $timeout(function(){
                    $scope.loadingModal.dismiss();
                    $scope.loadingModal.closed.then(function(){
                        $('#content').css({'display': 'block'});
                        $scope.createReportTable();
                        $scope.hasId = false;
                    });
                }, 500);
                
            });
        }); 
    };

    //finish case function before load page
    $scope.getCase = function(){
        $rootScope.openLoadingModal(function(modal){
            $scope.loadingModal = modal;
        });
        $scope.verifySession(function(){
            $scope.getAllCases(function(){
                $timeout(function(){
                    $scope.loadingModal.dismiss();
                    $scope.loadingModal.closed.then(function(){
                        $('#content').css({'display': 'block'});
                        $scope.createCaseTable();
                        $scope.hasId = false;
                    });
                }, 500);
                
            });
        }); 
    };

    //finish payment function before load page
    $scope.getPayment = function(){
        $rootScope.openLoadingModal(function(modal){
            $scope.loadingModal = modal;
        });
        $scope.verifySession(function(){
            $scope.getAllPayments(function(){
                $timeout(function(){
                    $scope.loadingModal.dismiss();
                    $scope.loadingModal.closed.then(function(){
                        $('#content').css({'display': 'block'});
                        $scope.createPaymentTable();
                        $scope.hasId = false;
                    });
                }, 500);
                
            });
        }); 
    }

    //finish case details function before load page
    $scope.getCaseDetails = function(){
        $rootScope.openLoadingModal(function(modal){
            $scope.loadingModal = modal;
        });
        var data = {
            report_id : $stateParams.id
        };
        $http({
            method : "POST",
            url : $rootScope.url + "/api/counselor/fetch-single-case.php",
            dataType: "application/json;",
            data: data
        })
        .then(function mySuccess(response) {
            $timeout(function(){
                $scope.loadingModal.dismiss();
                $scope.loadingModal.closed.then(function(){
                    if (response.data.message == 'Success'){
                        $scope.caseDetails = response.data.caseDetails[0];
                        $scope.paymentDetails = response.data.paymentDetails[0];
                        $scope.caseHistoryList = response.data.stageList;
                    }
                    
                });
                $('#content').css({'display': 'block'});
                $scope.hasId = true;
            }, 500);
        }, 
        function myError(response) {
            console.log(response);
            $scope.loadingModal.dismiss();
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
            }
            callback();
        }, 
        function myError(response) {
            callback();
        });
    };

    //get all cases data
    $scope.getAllCases = function(callback){
        $http({
            method : "GET",
            url : $rootScope.url + "/api/counselor/fetch-all-cases.php",
            dataType: "application/json;",
        })
        .then(function mySuccess(response) {
            if (response.data.message == 'Success'){
                $scope.caseList = response.data.caseList;
                $scope.ongoingList = response.data.ongoingList;
                $scope.caseCount = response.data.caseList.length;
                
            }
            callback();
        }, 
        function myError(response) {
            callback();
        });
    };

    //get all payments data
    $scope.getAllPayments = function(callback){
        $http({
            method : "GET",
            url : $rootScope.url + "/api/counselor/fetch-all-payments.php",
            dataType: "application/json;",
        })
        .then(function mySuccess(response) {
            if (response.data.message == 'Success'){
                $scope.paymentList = response.data.paymentList;
                $scope.pendingList = response.data.pendingList;
                $scope.paymentCount = response.data.paymentList.length;
            }
            callback();
        }, 
        function myError(response) {
            console.log(response);
            callback();
        });
    };

    //create notification table
    $scope.createNotificationTable = function(){  
        $scope.notificationTable = $('#notificationTable').DataTable({
            pageLength: 10,
            destroy: true,
            dom: 't, p',
            scrollY: '40vh'
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
            scrollCollapse: true
        });
        $scope.reportTable2 = $('#reportTable2').DataTable({
            pageLength: 5,
            destroy: true,
            lengthMenu: [ 5, 10, 25, 50, 100 ],
            dom: 't, p',
            scrollY: '50vh',
            scrollCollapse: true
        });
        $scope.unreadCount = $scope.reportTable1.rows().count();
        $scope.reportCount = $scope.reportTable2.rows().count();
    };

    //create payment tables
    $scope.createPaymentTable = function(){  
        $scope.paymentTable1 = $('#paymentTable1').DataTable({
            pageLength: 5,
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
        $scope.paymentTable2 = $('#paymentTable2').DataTable({
            pageLength: 5,
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
        $scope.pendingCount = $scope.paymentTable1.rows().count();
        $scope.paymentCount = $scope.paymentTable2.rows().count();
    };

    //searchable notification table
    $scope.searchNotificationTable = function(text){
        $scope.notificationTable.search(text).draw();
    };

    //searchable report table
    $scope.searchReportTable = function(text){
        $scope.reportTable2.search(text).draw();
    };

    //searchable 1st case table
    $scope.searchCaseTable1 = function(text){
        $scope.caseTable1.search(text).draw();
    }

    //searchable 2nd case table
    $scope.searchCaseTable2 = function(text){
        $scope.caseTable2.search(text).draw();
    }

    //open notification modal
    $scope.openNotificationDetailsModal = function(notification){
        var data = {
            id: notification.id
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
                        controller: function ($scope, $uibModalInstance, notification, openReportDetailsModal, openPaymentDetails) {
                            $scope.notification = notification;

                            $scope.openReportDetails = function () {
                                $uibModalInstance.dismiss();
                                $uibModalInstance.closed.then(function(){
                                    openReportDetailsModal(notification);
                                });

                            };

                            $scope.openPaymentDetails = function(){
                                $uibModalInstance.dismiss();
                                $uibModalInstance.closed.then(function(){
                                    openPaymentDetails(notification.related_id);
                                });
                            }
                            
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
                            },
                            openPaymentDetails: function(){
                                return $scope.openPaymentDetailsModal;
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
                $scope.reportCount = response.data.reportList.length;
                
            }
            callback(); 
        }, 
        function myError(response) {
            callback();
        });
    };

    //approve or deny report(update)
    $scope.updateReport = function(report, status){
        bootbox.confirm({
            message: "Mark report #" + report.report_id + " as '" + status + "'?",
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
                    var data = {
                        report_id : report.report_id,
                        report_status : status
                    };
                    $http({
                        method : "PUT",
                        url : $rootScope.url + "/api/counselor/approve-report.php",
                        data: data,
                        dataType: "application/json;",
                    })
                    .then(function mySuccess(response) {
                        $timeout(function(){
                            $scope.loadingModal.dismiss();
                        },500);
                        if (response.data.message == 'Success'){
                            $scope.loadingModal.closed.then(function(){
                                $scope.reportDetailsModal.dismiss();
                                $scope.reportDetailsModal.closed.then(function(){
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
                            });
                        }
                        else{
                            $timeout(function(){
                                $scope.loadingModal.dismiss();
                            },500);
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
                        console.log(response);
                        $timeout(function(){
                            $scope.loadingModal.dismiss();
                        },500);
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
                        size: 'md',
                        controller: function ($scope, $uibModalInstance, report, student, reporter, attachmentList, misconductList, updateReport, hasId, openCaseDetails) {
                            $scope.report = report;
                            $scope.student = student;
                            $scope.reporter = reporter;
                            $scope.attachmentList = attachmentList;
                            $scope.misconductList = misconductList;
                            $scope.hasId = hasId;

                            $scope.later = function () {
                                $uibModalInstance.dismiss();
                                $uibModalInstance.closed.then(function(){
                                    if ($state.current.name == 'main.counselor-dashboard'){
                                        $state.reload();
                                    }
                                });
                            };

                            $scope.approve = function(){
                                updateReport($scope.report, 'Approved');
                            };

                            $scope.deny = function(){
                                updateReport($scope.report, 'Denied');
                            };

                            $scope.openCaseDetails = function(){
                                $uibModalInstance.dismiss();
                                $uibModalInstance.closed.then(function(){
                                    openCaseDetails('main.case-details', $scope.report.report_id);
                                });
                                
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
                            },
                            updateReport: function(){
                                return $scope.updateReport;
                            },
                            openCaseDetails: function(){
                                return $scope.go;
                            },
                            hasId: function(){
                                return $scope.hasId;
                            }
                        }
                    });
                    
                    modal.result.then(function(){
                        //Get triggers when modal is closed
                    }, function(){
                        //gets triggers when modal is dismissed.
                    });

                    $scope.reportDetailsModal = modal;
                });
            }
        }, 
        function myError(response) {
            setTimeout(function(){
                $scope.loadingModal.dismiss();
            }, 500);
        });
        
    };

    //create case table
    $scope.createCaseTable = function(){  
        $scope.caseTable1 = $('#caseTable1').DataTable({
            pageLength: 5,
            destroy: true,
            lengthMenu: [ 5, 10, 25, 50, 100 ],
            dom: 't, p',
            scrollY: '50vh',
            scrollCollapse: true,
            columns: [
                { width: "10%" },
                { width: "10%" },
                { width: "10%" },
                { width: "15%" },
                { width: "5%" },
              ]
        });
        $scope.caseTable2 = $('#caseTable2').DataTable({
            pageLength: 5,
            destroy: true,
            lengthMenu: [ 5, 10, 25, 50, 100 ],
            dom: 't, p',
            scrollY: '50vh',
            scrollCollapse: true,
            columns: [
                { width: "10%" },
                { width: "10%" },
                { width: "10%" },
                { width: "15%" },
                { width: "5%" },
              ]
        });
        $scope.ongoingCount = $scope.caseTable1.rows().count();
        $scope.caseCount = $scope.caseTable2.rows().count();
    };

    $scope.openStageDetails = function(stage_id, type){
        switch(type){
            case 'Primary Investigation':
                $scope.openPrimaryInvestigationModal(stage_id);
                break;
            case 'Hearing':
                $scope.openHearingModal(stage_id);
                break;
            case 'Appeal':
                $scope.openAppealModal(stage_id);
                break;
            case 'Fine Settlement':
                $scope.openFineSettlementModal(stage_id);
                break;
        }
    };

    $scope.openPrimaryInvestigationModal = function(stage_id){
        $rootScope.openLoadingModal(function(modal){
            $scope.loadingModal = modal;
        });
        var data = {
            stage_id: stage_id
        }
        $http({
            method : "POST",
            url : $rootScope.url + "/api/counselor/fetch-single-primary-investigation.php",
            data: data,
            dataType: "application/json;",
        })
        .then(function success(response){
            $timeout(function(){
                $scope.loadingModal.dismiss();
            }, 500);
            $scope.loadingModal.closed.then(function(){
                if (response.data.message == 'Success'){
                    $scope.primaryInvestigationModal = $uibModal.open({
                        templateUrl: "views/modals/primary-investigation-modal.php",
                        backdropClass: 'dark-backdrop',
                        windowClass : 'show',
                        backdrop: 'static',
                        keyboard: false,
                        windowTemplateUrl: "views/modal-window.php",
                        size: 'lg',
                        controller: function ($scope, $uibModalInstance, stage, proceed) {
                            $scope.close = function(){
                                $uibModalInstance.dismiss();  
                            };
                            $scope.stage = stage;

                            if ($scope.stage.result != ''){
                                switch($scope.stage.result){
                                    case 'Hearing':
                                        $scope.stage.result = 'Proceeded to case hearing.';
                                        break;
                                    case 'Appeal':
                                        $scope.stage.result = 'Proceeded to case appeal.';
                                        break;
                                    case 'Fine Settlement':
                                        $scope.stage.result = 'Proceeded to fine settlement.';
                                        break;
                                }
                            } 

                            $scope.proceed = function(){
                                proceed($scope.stage);
                            };
                        },
                        resolve:{
                            stage: function(){
                                return response.data.stageDetails[0];
                            },
                            proceed: function(){
                                return $scope.proceed;
                            }
                        }
                    });
                    
                    $scope.primaryInvestigationModal.result.then(function(){
                        //Get triggers when modal is closed
                    }, function(){
                        //gets triggers when modal is dismissed.
                    });
                }
                else{
                    console.log(response);
                }
            });

        },
        function error(response){
            console.log(response);
            $timeout(function(){
                $scope.loadingModal.dismiss();
            }, 500);
        });
        
    };

    $scope.openHearingModal = function(stage_id){
        $rootScope.openLoadingModal(function(modal){
            $scope.loadingModal = modal;
        });
        var data = {
            stage_id: stage_id
        }
        $http({
            method : "POST",
            url : $rootScope.url + "/api/counselor/fetch-single-case-hearing.php",
            data: data,
            dataType: "application/json;",
        })
        .then(function success(response){
            $timeout(function(){
                $scope.loadingModal.dismiss();
            }, 500);
            $scope.loadingModal.closed.then(function(){
                if (response.data.message == 'Success'){
                    $scope.hearingModal = $uibModal.open({
                        templateUrl: "views/modals/hearing-modal.php",
                        backdropClass: 'dark-backdrop',
                        windowClass : 'show',
                        backdrop: 'static',
                        keyboard: false,
                        windowTemplateUrl: "views/modal-window.php",
                        size: 'lg',
                        controller: function ($scope, $uibModalInstance, stage, proceed) {
                            $scope.close = function(){
                                $uibModalInstance.dismiss();  
                            };

                            $scope.stage = stage;

                            if ($scope.stage.result != ''){
                                switch($scope.stage.result){
                                    case 'Appeal':
                                        $scope.stage.result = 'Proceeded to case appeal.';
                                        break;
                                    case 'Fine Settlement':
                                        $scope.stage.result = 'Proceeded to fine settlement.';
                                        break;
                                    case 'Drop Case':
                                        $scope.stage.result = 'This case was dropped.';
                                        break;
                                }
                            } 

                            $scope.proceed = function(){
                                proceed($scope.stage);
                            };
                        },
                        resolve:{
                            stage: function(){
                                return response.data.stageDetails[0];
                            },
                            proceed: function(){
                                return $scope.proceed;
                            }
                        }
                    });
                    
                    $scope.hearingModal.result.then(function(){
                        //Get triggers when modal is closed
                    }, function(){
                        //gets triggers when modal is dismissed.
                    });
                }
                else{
                    console.log(response);
                }
            });

        },
        function error(response){
            console.log(response);
            $timeout(function(){
                $scope.loadingModal.dismiss();
            }, 500);
        });
        
    };

    $scope.openAppealModal = function(stage_id){
        $rootScope.openLoadingModal(function(modal){
            $scope.loadingModal = modal;
        });
        var data = {
            stage_id: stage_id
        }
        $http({
            method : "POST",
            url : $rootScope.url + "/api/counselor/fetch-single-case-appeal.php",
            data: data,
            dataType: "application/json;",
        })
        .then(function success(response){
            $timeout(function(){
                $scope.loadingModal.dismiss();
            }, 500);
            $scope.loadingModal.closed.then(function(){
                if (response.data.message == 'Success'){
                    $scope.appealModal = $uibModal.open({
                        templateUrl: "views/modals/appeal-modal.php",
                        backdropClass: 'dark-backdrop',
                        windowClass : 'show',
                        backdrop: 'static',
                        keyboard: false,
                        windowTemplateUrl: "views/modal-window.php",
                        size: 'lg',
                        controller: function ($scope, $uibModalInstance, stage, proceed) {
                            $scope.close = function(){
                                $uibModalInstance.dismiss();  
                            };

                            $scope.stage = stage;

                            if ($scope.stage.result != ''){
                                switch($scope.stage.result){
                                    case 'Fine Settlement':
                                        $scope.stage.result = 'Proceeded to fine settlement.';
                                        break;
                                }
                            } 

                            $scope.proceed = function(){
                                $scope.stage.result = "Fine Settlement";
                                proceed($scope.stage);
                            };
                        },
                        resolve:{
                            stage: function(){
                                return response.data.stageDetails[0];
                            },
                            proceed: function(){
                                return $scope.proceed;
                            }
                        }
                    });
                    
                    $scope.appealModal.result.then(function(){
                        //Get triggers when modal is closed
                    }, function(){
                        //gets triggers when modal is dismissed.
                    });
                }
                else{
                    console.log(response);
                }
            });

        },
        function error(response){
            console.log(response);
            $timeout(function(){
                $scope.loadingModal.dismiss();
            }, 500);
        });
        
    };

    $scope.openFineSettlementModal = function(stage_id){
        $rootScope.openLoadingModal(function(modal){
            $scope.loadingModal = modal;
        });
        var data = {
            stage_id: stage_id
        }
        $http({
            method : "POST",
            url : $rootScope.url + "/api/counselor/fetch-single-fine-settlement.php",
            data: data,
            dataType: "application/json;",
        })
        .then(function success(response){
            $timeout(function(){
                $scope.loadingModal.dismiss();
            }, 500);
            $scope.loadingModal.closed.then(function(){
                if (response.data.message == 'Success'){
                    $scope.fineSettlementModal = $uibModal.open({
                        templateUrl: "views/modals/fine-settlement-modal.php",
                        backdropClass: 'dark-backdrop',
                        windowClass : 'show',
                        backdrop: 'static',
                        keyboard: false,
                        windowTemplateUrl: "views/modal-window.php",
                        size: 'lg',
                        controller: function ($scope, $uibModalInstance, stage, proceed) {
                            $scope.close = function(){
                                $uibModalInstance.dismiss();  
                            };

                            $scope.stage = stage;

                            if ($scope.stage.fine_amount == '0'){
                                $scope.stage.fine_amount = '';
                            } 

                            if ($scope.stage.result != ''){
                                switch($scope.stage.result){
                                    case 'Payment':
                                        $scope.stage.result = 'Waiting for pending payment by student.';
                                        break;
                                }
                            } 

                            $scope.proceed = function(){
                                $scope.stage.result = "Payment";
                                $scope.stage.fine_amount = parseFloat($scope.stage.fine_amount).toFixed(2);
                                proceed($scope.stage);
                            };
                        },
                        resolve:{
                            stage: function(){
                                return response.data.stageDetails[0];
                            },
                            proceed: function(){
                                return $scope.proceed;
                            }
                        }
                    });
                    
                    $scope.fineSettlementModal.result.then(function(){
                        //Get triggers when modal is closed
                    }, function(){
                        //gets triggers when modal is dismissed.
                    });
                }
                else{
                    console.log(response);
                }
            });

        },
        function error(response){
            console.log(response);
            $timeout(function(){
                $scope.loadingModal.dismiss();
            }, 500);
        });
        
    };

    $scope.proceed = function(stage){
        bootbox.confirm({
            message: "Proceed with " + stage.result + "?",
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
                    switch(stage.result){
                        case 'Hearing':
                            $scope.proceedToCaseHearing(stage);
                            break;
                        case 'Appeal':
                            $scope.proceedToCaseAppeal(stage);
                            break;
                        case 'Fine Settlement':
                            $scope.proceedToFineSettlement(stage);
                            break;
                        case 'Drop Case':
                            $scope.dropCase(stage);
                            break;
                        case 'Payment':
                            $scope.setPayment(stage);
                            break;
                    }
                }
            }
        });
    };

    $scope.proceedToCaseHearing = function(info){
        $rootScope.openLoadingModal(function(modal){
            $scope.loadingModal = modal;
        });
        $http({
            method : "POST",
            url : $rootScope.url + "/api/counselor/trigger-case-hearing.php",
            data: info,
            dataType: "application/json;",
        })
        .then(function success(response){
            if (response.data.message == "Success"){
                $timeout(function(){
                    $scope.loadingModal.dismiss();
                    $scope.loadingModal.closed.then(function(){
                        $scope.primaryInvestigationModal.dismiss();
                        $scope.primaryInvestigationModal.closed.then(function(){
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
                    });
                },500);
            }
            else{
                $timeout(function(){
                    $scope.loadingModal.dismiss();
                },500);
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
        function error(response){
            console.log(response);
            $timeout(function(){
                $scope.loadingModal.dismiss();
            },500);
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
    };

    $scope.proceedToCaseAppeal = function(info){
        $rootScope.openLoadingModal(function(modal){
            $scope.loadingModal = modal;
        });
        $http({
            method : "POST",
            url : $rootScope.url + "/api/counselor/trigger-case-appeal.php",
            data: info,
            dataType: "application/json;",
        })
        .then(function success(response){
            if (response.data.message == "Success"){
                $timeout(function(){
                    $scope.loadingModal.dismiss();
                    $scope.loadingModal.closed.then(function(){
                        if ($scope.primaryInvestigationModal != undefined){
                            $scope.primaryInvestigationModal.dismiss();
                            $scope.primaryInvestigationModal.closed.then(function(){
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
                        else if ($scope.hearingModal != undefined){
                            $scope.hearingModal.dismiss();
                            $scope.hearingModal.closed.then(function(){
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
                        
                    });
                },500);
            }
            else{
                $timeout(function(){
                    $scope.loadingModal.dismiss();
                },500);
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
        function error(response){
            console.log(response);
            $timeout(function(){
                $scope.loadingModal.dismiss();
            },500);
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
    };

    $scope.proceedToFineSettlement = function(info){
        $rootScope.openLoadingModal(function(modal){
            $scope.loadingModal = modal;
        });
        $http({
            method : "POST",
            url : $rootScope.url + "/api/counselor/trigger-fine-settlement.php",
            data: info,
            dataType: "application/json;",
        })
        .then(function success(response){
            if (response.data.message == "Success"){
                $timeout(function(){
                    $scope.loadingModal.dismiss();
                    $scope.loadingModal.closed.then(function(){
                        if ($scope.primaryInvestigationModal != undefined){
                            $scope.primaryInvestigationModal.dismiss();
                            $scope.primaryInvestigationModal.closed.then(function(){
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
                        else if ($scope.hearingModal != undefined){
                            $scope.hearingModal.dismiss();
                            $scope.hearingModal.closed.then(function(){
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
                        else if ($scope.appealModal != undefined){
                            $scope.appealModal.dismiss();
                            $scope.appealModal.closed.then(function(){
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
                        
                    });
                },500);
            }
            else{
                $timeout(function(){
                    $scope.loadingModal.dismiss();
                },500);
                $scope.loadingModal.closed.then(function(){
                    var box = bootbox.dialog({
                        message: "<strong>Failed! " + response.data.message +"</strong>",
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
        function error(response){
            console.log(response);
            $timeout(function(){
                $scope.loadingModal.dismiss();
            },500);
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
    };

    $scope.dropCase = function(info){
        $rootScope.openLoadingModal(function(modal){
            $scope.loadingModal = modal;
        });
        $http({
            method : "POST",
            url : $rootScope.url + "/api/counselor/drop-case.php",
            data: info,
            dataType: "application/json;",
        })
        .then(function success(response){
            if (response.data.message == "Success"){
                $timeout(function(){
                    $scope.loadingModal.dismiss();
                    $scope.loadingModal.closed.then(function(){
                        $scope.hearingModal.dismiss();
                        $scope.hearingModal.closed.then(function(){
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
                    });
                },500);
            }
            else{
                $timeout(function(){
                    $scope.loadingModal.dismiss();
                },500);
                $scope.loadingModal.closed.then(function(){
                    var box = bootbox.dialog({
                        message: "<strong>Failed! " + response.data.message +"</strong>",
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
        function error(response){
            console.log(response);
            $timeout(function(){
                $scope.loadingModal.dismiss();
            },500);
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
    };

    $scope.setPayment = function(info){
        
        $rootScope.openLoadingModal(function(modal){
            $scope.loadingModal = modal;
        });
        $http({
            method : "POST",
            url : $rootScope.url + "/api/counselor/trigger-payment.php",
            data: info,
            dataType: "application/json;",
        })
        .then(function success(response){
            if (response.data.message == "Success"){
                $timeout(function(){
                    $scope.loadingModal.dismiss();
                    $scope.loadingModal.closed.then(function(){
                        $scope.fineSettlementModal.dismiss();
                        $scope.fineSettlementModal.closed.then(function(){
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
                    });
                },500);
            }
            else{
                $timeout(function(){
                    $scope.loadingModal.dismiss();
                },500);
                $scope.loadingModal.closed.then(function(){
                    var box = bootbox.dialog({
                        message: "<strong>Failed! " + response.data.message +"</strong>",
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
        function error(response){
            console.log(response);
            $timeout(function(){
                $scope.loadingModal.dismiss();
            },500);
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
    };

    $scope.openPaymentDetailsModal = function(payment_id){
        $rootScope.openLoadingModal(function(modal){
            $scope.loadingModal = modal;
        });
        var data = {
            payment_id: payment_id
        };
        $http({
            method : "POST",
            url : $rootScope.url + "/api/counselor/fetch-single-payment.php",
            data: data,
            dataType: "application/json;",
        })
        .then(function success(response){
            $timeout(function(){
                $scope.loadingModal.dismiss();
            },500);
            $scope.loadingModal.closed.then(function(){
                if (response.data.message == 'Success'){
                    $scope.paymentDetailsModal = $uibModal.open({
                        templateUrl: "views/modals/payment-details-modal.php",
                        backdropClass: 'dark-backdrop',
                        windowClass : 'show',
                        backdrop: 'static',
                        keyboard: false,
                        windowTemplateUrl: "views/modal-window.php",
                        size: 'md',
                        controller: function ($scope, $uibModalInstance, paymentDetails) {
                            $scope.close = function(){
                                $uibModalInstance.dismiss(); 
                                $uibModalInstance.closed.then(function(){
                                    if ($state.current.name == 'main.counselor-dashboard'){
                                        $state.reload();
                                    }
                                }); 
                            };
                            $scope.paymentDetails = paymentDetails;

                            $scope.paymentDetails.outstanding = "RM " + parseFloat($scope.paymentDetails.outstanding).toFixed(2);

                            if ($scope.paymentDetails.last_paid == null){
                                $scope.paymentDetails.last_paid = 'Not paid yet.';
                            }
                        },
                        resolve:{
                            paymentDetails: function(){
                                return response.data.paymentDetails;
                            }
                        }
                    });
                    
                    $scope.paymentDetailsModal.result.then(function(){
                        //Get triggers when modal is closed
                    }, function(){
                        //gets triggers when modal is dismissed.
                    });
                }
                else{
                    console.log(response);
                }
            });
        }
        ,function error(response){
            console.log(response);
        });


    };

    $scope.convertToCurrency = function(value){
        return parseFloat(value).toFixed(2);
    };

});