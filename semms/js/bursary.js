var app = angular.module('bursary', []);
app.controller('bursaryCtrl', function($state, $scope, $rootScope, $http, $timeout, $uibModal){
    
    
    $scope.getDashboard = function(){
        $rootScope.openLoadingModal(function(modal){
            $scope.loadingModal = modal;
        });
        $scope.getAllPayments(function(){
            $timeout(function(){
                $scope.loadingModal.dismiss();
                $scope.loadingModal.closed.then(function(){
                    $('#content').css({'display': 'block'});
                    $scope.createPaymentTable();
                });
            },500);
        });
    };

    $scope.getAllPayments = function(callback){
        $http({
            method : "GET",
            url : $rootScope.url + "/api/bursary/fetch-all-payments.php",
            dataType: "application/json;",
        })
        .then(function success(response){
            if (response.data.message == 'Success'){
                $scope.paymentList = response.data.paymentList;
                $scope.pendingList = response.data.pendingList;
            }
            callback();
        },
         function error(response){
            console.log(response)
            callback();
        });
    };

    
    
    //create payment tables
    $scope.createPaymentTable = function(){  
        $scope.paymentTable1 = $('#paymentTable1').DataTable({
            pageLength: 5,
            destroy: true,
            lengthMenu: [ 5, 10, 25, 50, 100 ],
            dom: 't, p',
            scrollY: '50vh',
            scrollCollapse: true
        });
        $scope.paymentTable2 = $('#paymentTable2').DataTable({
            pageLength: 5,
            destroy: true,
            lengthMenu: [ 5, 10, 25, 50, 100 ],
            dom: 't, p',
            scrollY: '50vh',
            scrollCollapse: true
        });
        $scope.pendingCount = $scope.paymentTable1.rows().count();
        $scope.paymentCount = $scope.paymentTable2.rows().count();
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
            url : $rootScope.url + "/api/bursary/fetch-single-payment.php",
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
                        templateUrl: "views/modals/settle-payment-modal.php",
                        backdropClass: 'dark-backdrop',
                        windowClass : 'show',
                        backdrop: 'static',
                        keyboard: false,
                        windowTemplateUrl: "views/modal-window.php",
                        size: 'md',
                        controller: function ($scope, $uibModalInstance, paymentDetails, pay) {
                            $scope.close = function(){
                                $uibModalInstance.dismiss();  
                            };

                            $scope.paymentDetails = paymentDetails;

                            $scope.paymentDetails.issued_amount = parseFloat($scope.paymentDetails.issued_amount).toFixed(2);
                            $scope.paymentDetails.outstanding = parseFloat($scope.paymentDetails.outstanding).toFixed(2);

                            $scope.pay = function(){
                                $scope.paymentDetails.paid_amount = parseFloat($scope.paymentDetails.paid_amount).toFixed(2);
                                pay($scope.paymentDetails);
                            };
                            
                        },
                        resolve:{
                            paymentDetails: function(){
                                return response.data.paymentDetails[0];
                            },
                            pay: function(){
                                return $scope.pay;
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
    
    $scope.pay = function(data){
        bootbox.confirm({
            message: "Make Payment?",
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
            callback: function (result){
                if (result){
                    $rootScope.openLoadingModal(function(modal){
                        $scope.loadingModal = modal;
                    });
                    $http({
                        method : "POST",
                        url : $rootScope.url + "/api/bursary/finalise-payment.php",
                        data: data,
                        dataType: "application/json;",
                    })
                    .then(function success(response){
                        $timeout(function(){
                            $scope.loadingModal.dismiss();
                        },500);
                        $scope.loadingModal.closed.then(function(){
                            if (response.data.message == 'Success'){
                                $scope.paymentDetailsModal.dismiss();
                                $scope.paymentDetailsModal.closed.then(function(){
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
                    }
                    ,function error(response){
                        console.log(response)
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

});