module.exports = [
  "$scope","$modalInstance","image","$http"
  ($scope,$modalInstance,image,$http)->
    console.log "upload Modal Controller",image
    $scope.image = image;
    $scope.upload = ->
      $http.post "/api.php/upload/data",image


]