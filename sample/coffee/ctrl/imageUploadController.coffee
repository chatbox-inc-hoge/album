setUploadEvent = ($scope) ->
  $ ->
    url = '/api.php/upload/data'
    $(document).on 'change', '#fileupload', ->
      $file = $(this).prop('files')[0]
      if !$file
        console.log 'ファイルの選択がない'
        return
      console.log 'ファイルが選択されました', $file
      $reader = new FileReader
      $reader.readAsDataURL $file, 'UTF-8'
      $reader.onload = (evt) ->
        console.log '読み込み完了', evt, this
        $scope.image.file = $file.name
        $scope.image.data = @result
        $scope.$apply()
        $scope.openUploadModal()
#        http = $.post url,
#          file: $file.name
#          data: @result
#        http.success (data) ->
#          console.log '転送完了'
#          $file = null


module.exports = [
  "$scope","$modal"
  ($scope,$modal)->
    console.log "upload Controller"
    setUploadEvent $scope

    $scope.image = {};

    $scope.openUploadModal = ()->
      modalInstance = $modal.open
        templateUrl: "uploadModal.html"
        controller: "imageUploadModalController"
        resolve:
          image: ->
            return $scope.image
      modalInstance.result.then ->
        console.log "アップロード完了"
]