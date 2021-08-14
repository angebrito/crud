<?php

require_once "user.php";

header("Content-Type: application/json");
$data = [];

$fn = $_REQUEST["fn"] ?? null;
$id = $_REQUEST["id"] ?? 0;
$name = $_REQUEST["name"] ?? null;
$email = $_REQUEST["email"] ?? null;
$password = $_REQUEST["password"] ?? null;


$user = new User;
$user->setId($id);

if ($fn === "create" && $name !== null && $email !== null && $password !== null) {
    $user -> setName($name);
    $user -> setEmail($email);
    $user -> setPassword($password);
    $data["user"] = $user->create();
}

if ($fn === "read" ) {
    $data["user"] = $user->read();
}

if ($fn === "update" && $id > 0 && $name !== null && $email !== null && $password !== null) {
    $user -> setName($name);
    $user -> setEmail($email);
    $user -> setPassword($password);
    $data["user"] = $user->update();
}

if ($fn === "delete"  && $id > 0) {
    $data["user"] = $user->delete();
}

die(json_encode($data));