<?php
use \Illuminate\Database\Schema\Blueprint;
use \Illuminate\Database\Query\Builder;

return [
    "schema" => [
        "album_image" => function(Blueprint $table){
                $table->unsignedInteger("id",true);
                $table->string("category");
                $table->string("filename");
                $table->unsignedInteger("size");
                $table->string("mime");
                $table->string("comment");
                $table->text("meta");
                $table->dateTime("created_at");
                $table->dateTime("updated_at");
            },
    ],
    "seeds" => [
        ["sample_table",function(Builder $builder){
            $builder->insert($data);
        }],
    ],
//    "includes" => [
//        "user" => __DIR__."/data/user.php"
//    ]
];



