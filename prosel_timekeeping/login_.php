<!--THIS HOLDS THE VIEW - department view test-->

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>USER Login</title>
    
</head>

<body>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<div ng-app="MyApp" ng-controller="ctrl">
    <!--LOGIN FORMS-->
    <div>
        <h1>LOGIN</h1>

        EMAIL ADDRESS <input type="text" ng-model="email_address" name="email_address" value="juandelacruz@yahoo.com" />
        PASSWORD <input type="text" ng-model="password" name="password" value="447812a4f56887ac0395842ce13e6103" />
        <input type="button" value="LOGIN" ng-click="login()">
        {{msg}}
    </div>

    <script type="text/javascript">
        var app = angular.module("MyApp", []);
        app.controller('ctrl', function($scope, $http){

            //AUTHENTICATE
            $scope.login = function() {
                $http.post("Controller/LoginController.php", 
                {
                    "email_address" : $scope.email_address,
                    "password" : $scope.password
                })
                .then(function(response) {
                    result = response.data.result.RESULT;

                    if(result == 1) //login successful {
                    {
                        $scope.msg = "Login Successful";
                    }
                    else if (result == 0) { //login failed
                        $scope.msg = "Login Failed";
                    }

                    //alert("response is: " + response.data.result.RESULT); // working
                    
                    //$scope.departments = response.data.departments;
                })
            }
        })
    </script>
    
    </div>

    </body>

</html>

