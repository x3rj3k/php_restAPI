<?php
  //Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Post.php';

  //instantiate DB and connect

  $database = new Database();
  $db = $database->connect();

  //instantiate post
  $post = new Post($db);

  //post query
  $result = $post->read();

  $num = $result->rowCount();

  if($num > 0){
    $post_arr = array();
    while($row = $result->fetch(PDO::FETCH_ASSOC)){
        extract($row);

        $post_item = array(
            'id' => $id,
            'title' => $title,
            'body' => html_entity_decode($body),
            'author' => $author,
            'category_id' => $category_id,
            'category_name' => $category_name
        );
        
        //push data
        array_push($post_arr, $post_item);
    }
    //turn into json
    echo json_encode($post_arr);
  }else {
      //no post
      echo json_encode(
          array('message'=> 'No Post Found')
      );
  } 