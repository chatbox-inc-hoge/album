module.exports = [
  "$scope","$modalInstance","image","$http"
  ($scope,$modalInstance,image,$http)->
    console.log "upload Modal Controller",image
    $scope.image = image;
    $scope.upload = ->
      $http.post "/api.php/upload/data",image
    $scope.delete = ->
      http = $http.post "/api.php/image/delete/#{$scope.image.category}/#{$scope.image.hashed_name}"
      http.success (data)->
        if data.status == "OK"
          $modalInstance.close "deleted";
        else
          $modalInstance.close "undefinedError";
      http.error (data)->
        $modalInstance.close "failToDelete";
    $scope.ok = ->
      $modalInstance.dismiss "cancel"
    $scope.cancel = ->
      $modalInstance.dismiss "cancel"


]