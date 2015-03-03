<?php
require __DIR__."/../vendor/autoload.php";

?>

<!doctype html>
<html lang="en" ng-app="albumSample">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
	<link rel="stylesheet" href="/bower_components/bootstrap/dist/css/bootstrap.min.css"/>
	<link rel="stylesheet" href="/bower_components/angular/angular-csp.css"/>

	<script src="/bower_components/jquery/dist/jquery.min.js"></script>
	<script src="/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
	<script src="/bower_components/angular/angular.min.js"></script>
	<script src="/bower_components/angular-bootstrap/ui-bootstrap.min.js"></script>
	<script src="/bower_components/angular-bootstrap/ui-bootstrap-tpls.min.js"></script>

	<script src="/js/common.js"></script>
</head>
<body>
<div data-ng-include="'/header.html'"></div>
<div class="container">
    <div class="row">
	    <div class="col-sm-12" data-ng-controller="imageListController">

<!--            <div class="alert alert-danger">-->
<!--                <strong>hogehoge</strong>-->
<!--                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid amet aperiam architecto autem delectus deleniti et exercitationem fuga ipsam magni molestiae nesciunt nostrum perferendis provident quidem quo, similique vel voluptate.</p>-->
<!--            </div>-->
            <div id="SimpleUploadTab" data-ng-include="'/partial/simpleUpload.html'"></div>
            <div id="ImageListTab" data-ng-include="'/partial/imageList.html'"
                ></div>
        </div>
    </div>


</div>



</body>
</html>