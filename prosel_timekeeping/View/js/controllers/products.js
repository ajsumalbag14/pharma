function productsCtrl($scope, $http, $uibModal) {
    $scope.displayProducts = function() {
        $http.post("../Controller/ProductsController.php", 
        {
            "method" : "display"
        })
        .then(function(response) {
            $scope.products = response.data;
        })
    }

}