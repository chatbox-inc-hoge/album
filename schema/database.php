<?php
use \Illuminate\Database\Schema\Blueprint;
use \Illuminate\Database\Query\Builder;

return [
    "schema" => [
        "album_image" => function(Blueprint $table){
                $table->unsignedInteger("id",true);
                $table->string("category");
                $table->string("origin_name");
                $table->string("hashed_name");
                $table->unsignedInteger("size");
                $table->string("mime");
                $table->string("comment");
                $table->text("meta");
                $table->dateTime("created_at");
                $table->dateTime("updated_at");
            },
        "album_data" => function(Blueprint $table){
                $table->unsignedInteger("id",true);
                $table->binary("data");
                $table->dateTime("created_at");
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



