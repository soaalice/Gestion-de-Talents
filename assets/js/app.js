var app = angular.module('park', []);

app.controller('place', function($scope) {
    $scope.value = 0;
    $scope.reserve = function () {
        var val = $scope.value;
        var etat = "";
        if (val == 0){
            etat = "Non prise"
            $scope.value = 1;
        }else if (val == 1){
            etat = "Prise";
            $scope.value = 0;   
        }
        console.log('Place '+etat);
        alert('Place '+etat );
    }
});
