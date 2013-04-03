angular.module('behatBrowserFilters', []).filter('ucfirst', function() {
  return function(input) {
    return input ? input[0].toUpperCase() + input.slice(1) : input;
  };
});