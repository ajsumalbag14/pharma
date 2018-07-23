function modulesCtrl($scope, $http) {
    $http.post("../Controller/ModulesController.php", 
        {
            "method" : "displayModules"
        }
    )
    .then(function(response) {
        $scope.modules = response.data;
    })
}
