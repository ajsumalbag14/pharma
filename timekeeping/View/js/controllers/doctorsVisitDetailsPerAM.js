function doctorsVisitDetailsPerAMCtrl($scope, $location, $http, sessionService, $stateParams){ 
    var userID = $location.search().userID;
    var firstName = $location.search().firstName;
    var lastName = $location.search().lastName;

    var fullName = firstName + " " + lastName;

    $scope.displayDoctorsVisitPerUser = function()
    {

        $http.post("../Controller/DoctorsVisitController.php", 
        {
            "method" : "displayDoctorsVisitPerUser",
            "userID" : userID
        })
        .then(function(response) {
            $scope.doctorsVisit = response.data;
            $scope.fullName = fullName;
        })
    }

    $scope.displayDoctorVisitDetails = function(doctorVisitID, doctorID) 
    {
        //display the following: 
        //1. doctor details on top but first query is the doctor visit to get the doctor ID
        //2. available balance
        //3. doctor visit (with signature and google maps)

        $http.post("../Controller/DoctorsVisitController.php", 
        {
            "method" : "getDoctorVisitDetails",
            "doctorVisitID" : doctorVisitID
        })
        .then(function(response) {
            $scope.doctorVisitID = response.data[0].DOCTOR_VISIT_ID;
            $scope.userID = response.data[0].USER_ID;
            $scope.doctorID = response.data[0].DOCTOR_ID;
            $scope.visitDatetime = response.data[0].VISIT_DATETIME;
            $scope.doctorSignature = response.data[0].DOCTOR_SIGNATURE;
            $scope.doctorSignatureFileType = response.data[0].DOCTOR_SIGNATURE_FILE_TYPE;
            $scope.locationLat = response.data[0].LOCATION_LAT;
            $scope.locationLong = response.data[0].LOCATION_LONG;
            $scope.remarks = response.data[0].REMARKS;           

            initMap($scope.locationLat, $scope.locationLong);
        })
        
        //DOCTOR DETAILS
        $http.post("../Controller/DoctorController.php", 
        {
            "method" : "getDetails",
            "doctorID" : doctorID
        })
        .then(function(response) {
            //$scope.doctor = response.data;
            $scope.doctorID = response.data[0].DOCTOR_ID;
            $scope.firstName = response.data[0].FIRST_NAME;
            $scope.middleInitial = response.data[0].MIDDLE_INITIAL;
            $scope.lastName = response.data[0].LAST_NAME;
            $scope.doctorSpecialtyID = response.data[0].DOCTOR_SPECIALTY_ID;
            $scope.address1 = response.data[0].ADDRESS1;
            $scope.address2 = response.data[0].ADDRESS2;

            $scope.doctorFullName = $scope.firstName + " " + $scope.middleInitial + " " + $scope.lastName;
        })
        
        //AVAILABLE BALANCE
        $http.post("../Controller/DoctorBalanceController.php", 
        {
            "method" : "displayDoctorBalance",
            "doctorID" : doctorID
        })
        .then(function(response) {
            //$scope.doctor = response.data;
            $scope.balance = response.data[0].BALANCE;
            $scope.balanceExpirationDate = response.data[0].BALANCE_EXPIRATION_DATE;  
        })

         //DOCTOR PURCHASE LIST
        $http.post("../Controller/DoctorsPurchaseController.php", 
        {
            "method" : "displayDoctorPurchasePerDoctorVisit",
            "doctorVisitID" : doctorVisitID
        })
        .then(function(response) {
            $scope.doctorPurchase = response.data;
            
            //GET THE TOTAL NET PRICE
            /*var totalNetPrice = 0;

            for(var i = 0; i < $scope.doctorPurchase.length; i++){
                var NET_PRICE = parseFloat($scope.doctorPurchase[i].NET_PRICE);
                totalNetPrice += NET_PRICE;
            }

            $scope.totalNetPrice = totalNetPrice.toLocaleString();
            */
        })

        //GET THE TOTAL NET PRICE
        $http.post("../Controller/DoctorsPurchaseController.php", 
        {
            "method" : "displayDoctorPurchaseTotalPerDoctorVisit",
            "doctorVisitID" : doctorVisitID
        })
        .then(function(response) {
            //$scope.doctor = response.data;
            $scope.totalNetPrice = response.data[0].TOTAL;
            //$scope.balanceExpirationDate = response.data[0].BALANCE_EXPIRATION_DATE;  
            
        })

    }

    function initMap (locationLat, locationLong) {
        var vLocationLat = parseFloat(locationLat);
        var vLocationLong = parseFloat(locationLong);

        var myLatLng = {
            lat: vLocationLat,
            lng: vLocationLong
        }
        var map;      
        map = new google.maps.Map(document.getElementById('mapAM'), {
        center: {
                lat: vLocationLat,
                lng: vLocationLong
            },
        gestureHandling: 'cooperative',
        zoom: 16
    });
    
    var marker = new google.maps.Marker({
        position: myLatLng,
        map: map,
        title: 'Location'
    });
    
}

    $scope.backToAMSummary = function() {
        $location.path('index/areaManager');
    }

    $scope.backToAMDetails = function() {
        $location.path('index/AMDetails');
    }

}