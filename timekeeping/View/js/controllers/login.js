//timekeeping functions section begin
function loginCtrl($scope, $http, $location, sessionService) {
    $scope.login = function() {
        
        $http.post("../Controller/LoginController.php", 
        {
            "username" : $scope.username,
            "password" : md5($scope.password)
        })
        .then(function(response) {

            if(response.data.account.result == 1) {
                //put the credentials to session
                sessionService.set("userID", response.data.account.userID);
                sessionService.set("firstName", response.data.account.firstName);
                sessionService.set("lastName", response.data.account.lastName);
                sessionService.set("userTypeID", response.data.account.userTypeID);
                sessionService.set("userType", response.data.account.userType);

                //redirect after this
                $location.path('/index');
            }
            else { //login failed
                $scope.msg = "Login Failed";
            }
        })        
    }
}

function logoutCtrl($scope, $http, $location, sessionService) {
    //destroy session credentials
    sessionService.unset("userID");
    sessionService.unset("firstName");
    sessionService.unset("lastName");
    sessionService.unset("userTypeID");

    // //redirect to login
    $location.path('/login');
}
