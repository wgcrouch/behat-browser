function DefinitionListCtrl($scope, $http) {
    $http.get('/api/definitions').success(function(data) {
        $scope.definitions = data;
    });

    $scope.orderProp = 'description';   
}

function DefinitionDetailCtrl($scope, $routeParams, $http) {

      var definitionId = $routeParams.definitionId;
      $http.get('/api/definitions/' + definitionId).success(function(data) {
            $scope.definition = data;
      });
      $http.get('/api/definitions/' + definitionId + '/features').success(function(data) {
            $scope.features = data;
      });

}

function FeatureDetailCtrl($scope, $routeParams, $http) {

      var featureId = $routeParams.featureId;
      $http.get('/api/features/' + featureId).success(function(data) {
            $scope.feature = data;
      });
}

function FeatureListCtrl($scope, $routeParams, $http) {
      $http.get('/api/features').success(function(data) {
            $scope.features = data;
      });
}