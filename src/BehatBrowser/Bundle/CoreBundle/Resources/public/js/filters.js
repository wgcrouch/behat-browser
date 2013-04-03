angular.module('behatBrowserFilters', []).filter('ucfirst', function() {
  return function(input) {
    return input[0].toUpperCase() + s.slice(1);
  };
});