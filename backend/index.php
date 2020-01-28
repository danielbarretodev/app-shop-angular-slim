<?php


//CONEXION CON SLIM
require_once 'vendor/autoload.php';
use \Slim\App;

$app = new \Slim\App();

//BD
$db = new mysqli('localhost', 'root','','curso_angular4');

// Configuración de cabeceras
//sirve para las peticiones ajax desde el frontend
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
$method = $_SERVER['REQUEST_METHOD'];
if($method == "OPTIONS") {
    die();
}



//prueba
$app->get("/pruebas", function() use($app,$db){
  echo "Hola mundo desde Slim PHP";

});

//CREAR PRODUCTOS EN LA BD
$app->post('/productos', function ($request, $response, $args) use($db) {
      $json = $request->getParsedBody()['json'];
      $data = json_decode($json,true);

      if(!isset($data['imagen'])){
        $data['imagen']=null;
      }
      if(!isset($data['description'])){
        $data['description']=null;
      }
      if(!isset($data['nombre'])){
        $data['nombre']=null;
      }
      if(!isset($data['precio'])){
        $data['precio']=null;
      }


      $query = "INSERT INTO productos VALUES(NULL,".
              "'{$data['nombre']}',".
              "'{$data['description']}',".
              "'{$data['precio']}',".
              "'{$data['imagen']}'".
              ")";

      $insert = $db -> query($query);

      if($insert) {
        $result = array(
          'status' => 'success',
          'code' => 200,
          'message' => 'Producto creado correctamente'
        );
     }

      //var_dump($query);

    echo json_encode($result);



      return $response;
});

//LISTAR PRODUCTOS DESDE LA BD
$app->get('/productos', function ($request, $response, $args) use($db) {

      $sql = 'SELECT * FROM productos ORDER BY id DESC';

      $query = $db -> query($sql);

      $productos = array();
      while($producto = $query->fetch_assoc()){
        $productos[] = $producto;
      }

      $result = array(
        'status' => 'success',
        'code' => '200',
        'data' => $productos
      );


      echo json_encode($result);
});


//DEVOLVER UN SOLO PRODUCTO
$app->get('/producto/{id}', function ($request, $response, $args) use($db) {



  $sql = 'SELECT * FROM productos WHERE id = ' .$args['id'];

  $query = $db -> query($sql);




  if($query->num_rows == 1){

    $producto = $query->fetch_assoc();

    $result = array(
      'status' => 'success',
      'code' => '200',
      'data' => $producto
    );

  } else {

      $result = array(
        'status' => 'error',
        'code' => '404',
        'message' => 'Producto no disponible'
      );

  }



  echo json_encode($result);


});


// ELIMINAR UN PRODUCTO
$app->get('/delete/{id}', function ($request, $response, $args) use($db) {



  $sql = 'DELETE FROM productos WHERE id = ' .$args['id'];

  $query = $db -> query($sql);




  if($query){

    $result = array(
      'status' => 'success',
      'code' => '200',
      'message' => 'El producto se ha eliminado correctamente!!'
    );

  } else {

      $result = array(
        'status' => 'error',
        'code' => '404',
        'message' => 'Ha habido un error al eliminar el producto'
      );

  }

  echo json_encode($result);

});

//ACTUALIZAR UN PRODUCTO

$app->post('/update/{id}', function ($request, $response, $args) use($db) {

  $json = $request->getParsedBody()['json'];
  $data = json_decode($json,true);


        if(!isset($data['imagen'])){
          $data['imagen']=null;
        }
        if(!isset($data['description'])){
          $data['description']=null;
        }
        if(!isset($data['nombre'])){
          $data['nombre']=null;
        }
        if(!isset($data['precio'])){
          $data['precio']=null;
        }



  $sql = "UPDATE productos SET " .
        "nombre = '{$data["nombre"]}',".
        "description = '{$data["description"]}',";

  if(isset($data['imagen'])){
        $sql .= "imagen = '{$data["imagen"]}',";
  }


  $sql .= "precio = '{$data["precio"]}' WHERE id = " .$args['id'];

  $query = $db -> query($sql);

  //echo var_dump($query);


  if($query) {
    $result = array(
      'status' => 'success',
      'code' => 200,
      'message' => 'Producto actualizado correctamente'
    );
  } else {

    $result = array(
      'status' => 'error',
      'code' => '404',
      'message' => 'Ha habido un error al actualizar el producto'
    );
  }

  echo json_encode($result);
});


//SUBIR IMAGEN AL SERVIDOR

$app->post('/upload',function() use($db){

  if(isset($_FILES['uploads'])){
    $piramide = new PiramideUploader();
    $upload = $piramide->upload('image','uploads','uploads',array('image/jpeg','image/png','image/gif'));
    $file = $piramide->getInfoFile();
    $file_name = $file['complete_name'];
    //var_dump($file);

    $result = array(
      'status' => 'error',
      'code' => '404',
      'message' => 'La imagen no ha podido subirse'
    );


    if(isset($upload) && $upload['uploaded'] == false){
      $result = array(
        'status' => 'error',
        'code' => '404',
        'message' => 'La imagen no ha podido subirse'
      );
    } else {
      $result = array(
        'status' => 'success',
        'code' => '200',
        'message' => 'La imagen se ha subido correctamente',
        'filename' => $file_name
      );
    }

      echo json_encode($result);
  }






});

$app->run();
