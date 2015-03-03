<?php
/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2015/02/03
 * Time: 0:12
 */

namespace Chatbox\Album\HTTP;

use Silex\Application;

class API {

    static public function boot($param){
        $obj = new static($param);
        return $obj;
    }

    /**
     * 色々アクセサ伸ばすのめんどいしpublicでOK
     * @var Application
     */
    public $app;

    function __construct($param)
    {
        $this->app = new Application($param);
    }

    protected function configure(){
	    $this->app->register(new \Silex\Provider\ServiceControllerServiceProvider());

        $this->app["photo.controller"] = $this->app->share(function(){
            return new \Chatbox\Album\HTTP\Route\Photo();
        });
	    $this->app["upload.controller"] = $this->app->share(function(){
		    return new \Chatbox\Album\HTTP\Route\Upload();
	    });

        $this->app->get("/photo/list/{category}/","photo.controller:actionList");
        $this->app->get("/photo/show/{category}/{originName}","photo.controller:actionShow");
        $this->app->post("/upload/post","upload.controller:actionPost");
        $this->app->post("/upload/file","upload.controller:actionFile");
    }

    public function run(){
        $this->configure();
        $this->app->run();
    }




} 