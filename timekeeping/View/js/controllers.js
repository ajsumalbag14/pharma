/**
 * INSPINIA - Responsive Admin Theme
 *
 */

/**
 * MainCtrl - controller
 */
function MainCtrl($http, $scope, $location, sessionService) {
    
    if(!sessionService.get("userID")) //not authenticated
    {
        $location.path('/login');
    }

    //this.userName = 'Welcome ';
    //this.helloText = 'Welcome User!';
    //this.descriptionText = 'Please see the records on the left';

    var fullName = sessionService.get("firstName") + " " + sessionService.get("lastName")

    //set the name on the left sidebar
    $scope.main.userName = fullName;
    $scope.main.userTypeID = sessionService.get("userTypeID");
    $scope.main.userType = sessionService.get("userType");

    //load the modules on the left side navigation
     $scope.loadModuleAccessPerUserType = function(){
         $http.post("../Controller/ModulesController.php", 
         {
             "method" : "loadModuleAccessPerUserType",
             "userTypeID" : sessionService.get("userTypeID")
         })
         .then(function(response) {
             $scope.modules = response.data;
         })
     }   
};

/**
 * formValidation - Controller for validation example
 */
function formValidation($scope) {

    $scope.signupForm = function() {
        if ($scope.signup_form.$valid) {
            // Submit as normal
        } else {
            $scope.signup_form.submitted = true;
        }
    }

    $scope.signupForm2 = function() {
        if ($scope.signup_form.$valid) {
            // Submit as normal
        }
    }

};


angular
    .module('inspinia')
    .controller('MainCtrl', MainCtrl)
    .controller('doctorCtrl', doctorCtrl)
    .controller('doctorsVisitCtrl', doctorsVisitCtrl)
    .controller('doctorsVisitDetailsCtrl', doctorsVisitDetailsCtrl)
    .controller('doctorsVisitDetailsPerAMCtrl', doctorsVisitDetailsPerAMCtrl)
    .controller('doctorAddCtrl', doctorAddCtrl)
    .controller('doctorEditCtrl', doctorEditCtrl)
    .controller('indexCtrl', indexCtrl)
    .controller('loginCtrl', loginCtrl)
    .controller('logoutCtrl', logoutCtrl)
    .controller('modulesCtrl', modulesCtrl)
    .controller('productsCtrl', productsCtrl)
    .controller('usersCtrl', usersCtrl)
    .controller('usersDetailsCtrl', usersDetailsCtrl)
    .controller('usersAddCtrl', usersAddCtrl)
    .controller('usersEditCtrl', usersEditCtrl)
    .controller('doctorDetailsCtrl', doctorDetailsCtrl)
    .controller('areaManagerCtrl', areaManagerCtrl)
    .controller('AMDetailsCtrl', AMDetailsCtrl)
    .controller('formValidation', formValidation)
    
    
    