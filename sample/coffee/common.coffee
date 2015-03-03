app = angular.module('albumSample', [
  "ui.bootstrap"
])
app.controller "imageListController",require "./ctrl/imageListController"
app.controller "imageModalController",require "./ctrl/imageModalController"
app.controller "imageUploadController",require "./ctrl/imageUploadController"
app.controller "imageUploadModalController",require "./ctrl/imageUploadModalController"
