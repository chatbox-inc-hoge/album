loadList = ($scope) ->
  console.log 'データを送信します', $scope
  $.get '/api.php/photo/list/' + $scope.category + '/', {}, (data) ->
    $scope.$apply ->
      if data.list
        $scope.lists.length = 0
        $scope.lists.push.apply $scope.lists, data.list
        console.log data
      else
        console.error 'データの受信形式が異常です。'

module.exports = [
  '$scope','$modal',
  ($scope,$modal) ->
    console.log 'hogehoge controller'
    $scope.lists = []
    $scope.alerts = [];
    $scope.category = 'common'
    $scope.srcMode = "hashed" # hashed redirect origin

    $scope.reload = ->
      loadList $scope
    loadList $scope

    $scope.getSrc = (apiEntry,index)->
      if image = $scope.lists[index]
        if $scope.srcMode == "hashed"
          return image.hashedUrl
        else if $scope.srcMode == "redirect"
          return apiEntry+image.redirectUrl
        else if $scope.srcMode == "origin"
          return apiEntry+image.originUrl
        else
          console.error "invalid srcMode",$scope.srcMode;
      else
        console.error "image index #{index} is out of range"



    $scope.openModal = ()->
      image = $scope.lists[this.$index]
      console.log "open modal for",image
      if image
        modalInstance = $modal.open
          templateUrl: "imageModal.html"
          controller: "imageModalController"
          resolve:
            image: ->
              return image
        modalInstance.result.then (status)->
          if status == "deleted"
            $scope.reload();
            $scope.alerts.push
              type: "success"
              msg: "delete image completed"
          else if status == "failToDelete"
            $scope.alerts.push
              type: "danger"
              msg: "fail to delete image"
    $scope.closeAlert = (index)->
      $scope.alerts.splice index,1


]
