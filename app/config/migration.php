<?php
use Classes\Migration;

Migration::table_ts("logs", [
    "id" => "@primary",
    "message" => ["varchar"=>800],
    "status" => ["int"=>11, "default" => 1]
]);

Migration::table_ts("emails", [
    "id" => PK,
    "email" => VARCHAR,
    "fname" => VARCHAR,
    "lname" => VARCHAR,
    "itype" => INTEGER,
    "message" => ["varchar" => 500],
], true);

Migration::table_ts("inquiry_type", [
    "id" => PK,
    "type" => VARCHAR,
    "details" => VARCHAR,
    "color" => VARCHAR,
]);

Migration::table_ts("users", [
    "id" => PK,
    "email" => VARCHAR,
    "password" => VARCHAR,
    "type" => INTEGER,
    "fname" => VARCHAR,
    "lname" => VARCHAR,
], true);

Migration::table_ts("roles", [
    "id" => PK,
    "role_code" => VARCHAR,
    "role_title" => VARCHAR,
    "role_desc" => VARCHAR,
    "redirect" => VARCHAR,
    "group" => INTEGER
]);

Migration::table_ts("notes", [
    "id" => PK,
    "user_id" => INTEGER,
    "category" => INTEGER,
    "title" => VARCHAR,
    "description" => ["varchar" => 1000],
    "date" => DATE,
], true);

Migration::table_ts("note_category", [
    "id" => PK,
    "name" => VARCHAR,
    "description"=> ["varchar" => "250"],
    "theme" => VARCHAR
], true);