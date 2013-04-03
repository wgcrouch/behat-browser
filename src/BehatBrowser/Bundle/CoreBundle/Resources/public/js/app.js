angular.module('behatBrowser', []).
  config(['$routeProvider', function($routeProvider) {

  basePath = "bundles/behatbrowsercore/templates/"
  $routeProvider.
      when('/definitions', {templateUrl: basePath + 'definition-list.html',   controller: DefinitionListCtrl}).
      when('/definition/:definitionId', {templateUrl: basePath + 'definition-detail.html', controller: DefinitionDetailCtrl}).
      when('/feature/:featureId', {templateUrl: basePath + 'feature-detail.html',   controller: FeatureDetailCtrl}).
      when('/features', {templateUrl: basePath + 'feature-list.html',   controller: FeatureListCtrl}).
      otherwise({redirectTo: '/definitions'})

}]);