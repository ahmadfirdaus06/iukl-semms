<div ng-init="checkSession(); getSession()" class="container-fluid p-0">
    <div class="panel-default">
        <div id="header" class="panel-heading p-3 bg-secondary" style="height:15%">
            <div class="row" style="height:100%" >
                <div class="col-sm my-auto">
                    <h2 class="text-white"><i>IUKL SEMMS</i></h2>
                </div>
                <div class="my-auto">
                    <div class="row bg-info border border-info rounded">
                            <p class="col-sm my-auto text-white" data-toggle="tooltip" title="{{last_login}}" ng-cloak><b><i>{{name}}</i> [<i>{{user_type}}</i>]</b></p>
                            <button class="my-auto btn btn-md p-3 text-white rounded-0" data-toggle="tooltip" data-target="#editProfileModal" ng-click="openEditProfileModal()" title="Edit Profile"><i class="fas fa-cog"></i></button>
                    </div>
                </div>
                <div class="my-auto ml-4 mr-3">
                    <button class="my-auto btn btn-danger text-white btn-md p-3" ng-click="logout()" data-toggle="tooltip" title="Sign out"><i class="fas fa-sign-out-alt"></i></button>
                </div>
            </div>
        </div>
        <div style="height:85%" class="panel-body"><div ui-view></div></div>
    </div>
</div>
<div ng-include="'modal.php'"></div>