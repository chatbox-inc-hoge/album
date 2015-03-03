/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId])
/******/ 			return installedModules[moduleId].exports;
/******/
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			exports: {},
/******/ 			id: moduleId,
/******/ 			loaded: false
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.loaded = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(0);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/*!*************************************!*\
  !*** ./sample/coffee/common.coffee ***!
  \*************************************/
/***/ function(module, exports, __webpack_require__) {

	var app;
	
	app = angular.module('albumSample', ["ui.bootstrap"]);
	
	app.controller("imageListController", __webpack_require__(!(function webpackMissingModule() { var e = new Error("Cannot find module \"./ctrl/imageListController\""); e.code = 'MODULE_NOT_FOUND'; throw e; }())));
	
	app.controller("imageModalController", __webpack_require__(/*! ./ctrl/imageModalController */ 6));
	
	app.controller("imageUploadController", __webpack_require__(/*! ./ctrl/imageUploadController */ 1));
	
	app.controller("imageUploadModalController", __webpack_require__(/*! ./ctrl/imageUploadModalController */ 2));


/***/ },
/* 1 */
/*!*********************************************************!*\
  !*** ./sample/coffee/ctrl/imageUploadController.coffee ***!
  \*********************************************************/
/***/ function(module, exports, __webpack_require__) {

	var setUploadEvent;
	
	setUploadEvent = function($scope) {
	  return $(function() {
	    var url;
	    url = '/api.php/upload/data';
	    return $(document).on('change', '#fileupload', function() {
	      var $file, $reader;
	      $file = $(this).prop('files')[0];
	      if (!$file) {
	        console.log('ファイルの選択がない');
	        return;
	      }
	      console.log('ファイルが選択されました', $file);
	      $reader = new FileReader;
	      $reader.readAsDataURL($file, 'UTF-8');
	      return $reader.onload = function(evt) {
	        console.log('読み込み完了', evt, this);
	        $scope.image.file = $file.name;
	        $scope.image.data = this.result;
	        $scope.$apply();
	        return $scope.openUploadModal();
	      };
	    });
	  });
	};
	
	module.exports = [
	  "$scope", "$modal", function($scope, $modal) {
	    console.log("upload Controller");
	    setUploadEvent($scope);
	    $scope.image = {};
	    return $scope.openUploadModal = function() {
	      var modalInstance;
	      modalInstance = $modal.open({
	        templateUrl: "uploadModal.html",
	        controller: "imageUploadModalController",
	        resolve: {
	          image: function() {
	            return $scope.image;
	          }
	        }
	      });
	      return modalInstance.result.then(function() {
	        return console.log("アップロード完了");
	      });
	    };
	  }
	];


/***/ },
/* 2 */
/*!**************************************************************!*\
  !*** ./sample/coffee/ctrl/imageUploadModalController.coffee ***!
  \**************************************************************/
/***/ function(module, exports, __webpack_require__) {

	module.exports = [
	  "$scope", "$modalInstance", "image", "$http", function($scope, $modalInstance, image, $http) {
	    console.log("upload Modal Controller", image);
	    $scope.image = image;
	    return $scope.upload = function() {
	      return $http.post("/api.php/upload/data", image);
	    };
	  }
	];


/***/ },
/* 3 */,
/* 4 */,
/* 5 */,
/* 6 */
/*!********************************************************!*\
  !*** ./sample/coffee/ctrl/imageModalController.coffee ***!
  \********************************************************/
/***/ function(module, exports, __webpack_require__) {

	module.exports = [
	  "$scope", "$modalInstance", "image", "$http", function($scope, $modalInstance, image, $http) {
	    console.log("upload Modal Controller", image);
	    $scope.image = image;
	    $scope.upload = function() {
	      return $http.post("/api.php/upload/data", image);
	    };
	    $scope["delete"] = function() {
	      var http;
	      http = $http.post("/api.php/image/delete/" + $scope.image.category + "/" + $scope.image.hashed_name);
	      http.success(function(data) {
	        if (data.status === "OK") {
	          return $modalInstance.close("deleted");
	        } else {
	          return $modalInstance.close("undefinedError");
	        }
	      });
	      return http.error(function(data) {
	        return $modalInstance.close("failToDelete");
	      });
	    };
	    $scope.ok = function() {
	      return $modalInstance.dismiss("cancel");
	    };
	    return $scope.cancel = function() {
	      return $modalInstance.dismiss("cancel");
	    };
	  }
	];


/***/ }
/******/ ])
//# sourceMappingURL=common.js.map