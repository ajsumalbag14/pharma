
function indexCtrl($scope, sessionService) {
    //check for authentication
    if(!sessionService.get("userID")) //not authenticated
    {
        $location.path('/login');
    }

    var fullName = sessionService.get("firstName") + " " + sessionService.get("lastName")

    //set the name on the left sidebar
    $scope.main.userName = fullName;
    $scope.main.userTypeID = sessionService.get("userTypeID");
    $scope.main.userType = sessionService.get("userType");
    
}
