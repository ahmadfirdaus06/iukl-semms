<div ng-init="initDOMMain(); getSession()" class="container-fluid p-0">
    <div class="panel-default">
        <div id="header" class="panel-heading p-3 stylish-color" style="height:15%">
            <div class="row" style="height:100%" >
                <div class="col-sm my-auto">
                    <h2 class="text-white"><i><b><strong>IUKL S<small>tudent</small> E<small>xam</small> M<small>isconduct</small> M<small>anagement</small> S<small>ystem</small></strong></b></i></h2>
                </div>
                <div class="my-auto">
                    <div class="row special-color-dark border-special-color-dark rounded">
                            <p class="col-sm my-auto text-white" data-toggle="tooltip" title="{{last_login}}" ng-cloak><b>{{name}} [{{user_type}}]</b></p>
                            <button class="my-auto btn btn-flat btn-md p-3 text-white special-color-dark rounded-0" data-toggle="tooltip" data-target="#editProfileModal" ng-click="openEditProfileModal()" title="Edit Profile"><i class="fas fa-cog"></i></button>
                    </div>
                </div>
                <div class="my-auto ml-4 mr-3">
                    <button class="my-auto btn btn-danger text-white btn-md p-3" ng-click="logout()" data-toggle="tooltip" title="Sign out"><div class="row justify-content-center"><i id="logoutIcon" class="fas fa-sign-out-alt my-auto"></i><div id="logoutSpinner" style="display:none" class="spinner-border spinner-border-sm text-white my-auto"></div></div></button>
                </div>
            </div>
        </div>
        <div style="height:85%" class="bg-dark panel-body"><div ui-view></div></div>
        <!-- <div style="height:8%; font-size:10pt" class="bg-secondary panel-footer text-center text-white pt-2">
            Copyright &copy; <b>2019 Student Exam Misconduct Unit.</b> All rights reserved.
        </div> -->
    </div>
</div>