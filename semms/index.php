<HTML ng-app="semms" ng-controller="userCtrl" ng-init="checkSession();getSession()">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- included library -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.7.8/angular.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.7.8/angular-route.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        <script>window.location.href = "#!login"</script>
    </head>
    <body>
    <div class="container-fluid p-0">
        <div class="panel-default">
            <div id="header" class="panel-heading p-3">
                <div class="row">
                    <div class="col-sm my-auto">
                        <h2 class="text-primary"><i>IUKL SEMMS</i></h2>
                    </div>
                    <div class="my-auto">
                        <div class="row bg-info border border-white rounded">
                                <p class="col-sm my-auto text-white" data-toggle="tooltip" title="{{last_login}}" ng-cloak><b><i>{{name}}</i> [<i>{{user_type}}</i>]</b></p>
                                <button class="my-auto btn btn-info bg-white text-secondary btn-md p-3 rounded-0" data-toggle="tooltip" title="Edit Profile"><i class="fas fa-cog"></i></button>
                        </div>
                    </div>
                    <div class="my-auto ml-4 mr-3">
                        <button class="my-auto btn btn-danger text-white btn-md p-3" ng-click="logout()" data-toggle="tooltip" title="Sign out"><i class="fas fa-sign-out-alt"></i></button>
                    </div>
                </div>
            </div>
            <div class="panel-body"><div ng-view></div></div>
            <div id="footer" class="panel-footer"></div>
        </div>
    </div>
    <!-- custom angularjs script -->
    <script src="js\app.js"></script>
    <script src="js\admin.js"></script>
    <script src="js\user.js"></script>
    <script src="js\bursary.js"></script>
    <script src="js\counselor.js"></script>
    </body>
</HTML>