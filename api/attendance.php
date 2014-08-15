<?php
header('content-type: application/json; charset=utf-8');
header("access-control-allow-origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');

require 'Slim/Slim.php';
\Slim\Slim::registerAutoloader();

//require 'vendor/autoload.php';
use Slim\Slim;
$app = new \Slim\Slim(array(
  'mode' => 'development',
  'debug' => true
  ));

$app->response()->header('Content-Type', 'application/json;charset=utf-8');    

// //users
$app->get('/hei', function() {
  echo "Heissan";
});

$app->get('/users', 'getUsers');
$app->get('/users/:id', 'getUser');
// $app->get('/users/group/:id', 'getUserGroup');
$app->post('/users/user', 'addUser');
//$app->put('/users/user/:id', 'updateUser');
// $app->delete('/users/:id',  'deleteUser');
$app->get('/attendance', 'getAttendance');
$app->get('/attendance/:id', 'getAttendanceForUser');
$app->post('/attendance/:date', 'setAttendance');
// $app->post('/attendance/:uid/:date/:attendance', 'addAttendance');
// $app->put('/attendance/:date', 'editAttendance');


$app->get('/', function () {
  echo "Hello there";
});

function getUsers() {
  $sql = "select * FROM users ORDER BY name";
  try {
    $db = getConnection();
    $stmt = $db->query($sql);  
    $users = $stmt->fetchAll(PDO::FETCH_OBJ);
    $db = null;
    global $app;
    echo json_encode($users, JSON_UNESCAPED_UNICODE);
  } catch(PDOException $e) {
    echo '{"error":{"text":'. $e->getMessage() .'}}'; 
  }
}

function getUser($id) {
  $sql = "SELECT * FROM users WHERE id=:id";
  try {
    $db = getConnection();
    $stmt = $db->prepare($sql);  
    $stmt->bindParam("id", $id);
    $stmt->execute();
    $user = $stmt->fetchObject();  
    $db = null;
    echo json_encode($user, JSON_UNESCAPED_UNICODE); 
  } catch(PDOException $e) {
    echo '{"error":{"text":'. $e->getMessage() .'}}'; 
  }
}

function addUser() {
  error_log('addUser\n', 3, '/var/tmp/php.log');
  $request = Slim::getInstance()->request();
  $user = json_decode($request->getBody());
  $sql = "INSERT INTO users (name, group_id, sex, year, image_path) VALUES (:name, :group_id, :sex, :year, :image_path)";
  try {
    $db = getConnection();
    $stmt = $db->prepare($sql);  
    $stmt->bindParam("name", $user->name);
    $stmt->bindParam("group_id", $user->group_id);
    $stmt->bindParam("sex", $user->sex);
    $stmt->bindParam("image_path", $user->image_path);
    $stmt->bindParam("year", $user->year);
    $stmt->execute();
    $db = null;
    echo json_encode($user, JSON_UNESCAPED_UNICODE); 
  } catch(PDOException $e) {
    error_log($e->getMessage(), 3, '/var/tmp/php.log');
    echo '{"error":{"text":'. $e->getMessage() .'}}'; 
  }
}

function updateUser($id) {
  error_log('updateUser\n', 3, '/var/tmp/php.log');
  $request = Slim::getInstance()->request();
  $user = json_decode($request->getBody());
  $sql = "INSERT INTO users (id, name, group_id, sex, year, image_path) VALUES (:id, :name, :group_id, :sex, :year, :image_path) ON DUPLICATE KEY UPDATE";
  try {
    $db = getConnection();
    $stmt = $db->prepare($sql);  
    $stmt->bindParam("id", $user->id);
    $stmt->bindParam("name", $user->name);
    $stmt->bindParam("group_id", $user->group_id);
    $stmt->bindParam("sex", $user->sex);
    $stmt->bindParam("image_path", $user->image_path);
    $stmt->bindParam("year", $user->year);
    $stmt->execute();
    $db = null;
    echo json_encode($user, JSON_UNESCAPED_UNICODE); 
  } catch(PDOException $e) {
    error_log($e->getMessage(), 3, '/var/tmp/php.log');
    echo '{"error":{"text":'. $e->getMessage() .'}}'; 
  }
}

function deleteUser($id) {
  $sql = "DELETE FROM users WHERE id=:id";
  try {
    $db = getConnection();
    $stmt = $db->prepare($sql);  
    $stmt->bindParam("id", $id);
    $stmt->execute();
    $db = null;
    echo '{"result": "ok"}';
  } catch(PDOException $e) {
    echo '{"error":{"text":'. $e->getMessage() .'}}'; 
  }
}
// Attendance
// $app->get('/attendance', 'getAttendance');
// $app->get('/attendance/:uid', 'getAttendance');
// $app->post('/attendance/:uid/:date/:attendance', 'addAttendance');
// $app->put('/attendance/:date', 'editAttendance');

function getAttendance() {
  $sql = "SELECT user_id, DATE_FORMAT(date, '%d-%m-%Y') as date FROM attendance ORDER BY date DESC";
  try {
    $db = getConnection();
    $stmt = $db->query($sql);  
    $users = $stmt->fetchAll(PDO::FETCH_OBJ);
    $db = null;
    echo json_encode($users, JSON_UNESCAPED_UNICODE);
  } catch(PDOException $e) {
    echo '{"error":{"text":'. $e->getMessage() .'}}'; 
  }
}

function getAttendanceForUser($id) {
  $sql = "SELECT DATE_FORMAT(date, '%d-%m-%Y') as date FROM attendance WHERE user_id=:id";
  try {
    $db = getConnection();
    $stmt = $db->prepare($sql);  
    $stmt->bindParam("id", $id);
    $stmt->execute();
    $attendance = $stmt->fetchAll(PDO::FETCH_OBJ);
    $db = null;
    echo json_encode($attendance, JSON_UNESCAPED_UNICODE); 
  } catch(PDOException $e) {
    echo '{"error":{"text":'. $e->getMessage() .'}}'; 
  }
}

function setAttendance($date) {

  error_log('updateUser\n', 3, '/var/tmp/php.log');
  $request = Slim::getInstance()->request();
  $attendance = json_decode($request->getBody());
  $sql = 'INSERT INTO attendance (user_id, date, comment, attended) VALUES ( :id, :date, :comment, :attended) ON DUPLICATE KEY UPDATE comment=:comment, attended=:attended';
  // print_r($attendance);
  try {
    $db = getConnection();
    $stmt = $db->prepare($sql);
    foreach ($attendance as $item) {
      $attended = intval(intval($item->attended));
      $stmt->bindParam("id", $item->id);
      $stmt->bindParam("date", $date);
      $stmt->bindParam("comment", $item->comment);
      $stmt->bindParam("attended", $attended);
      $stmt->execute();
    }
    $db = null;
    echo '{"result":"ok"}'; 
  
  } catch(PDOException $e) {
    error_log($e->getMessage(), 3, '/var/tmp/php.log');
    echo '{"error":{"text":'. $e->getMessage() .'}}'; 
  }

}

//DB
function getConnection() {
  // $dbhost="db.grimstadsvommeklubb.no";
  // $dbuser="wno561517";
  // $dbpass="5ukkert0pp";
  // $dbname="wno561517";
  $dbhost="localhost";
  $dbuser="jam";
  $dbpass="letmein";
  $dbname="gsk";
  $dbh = new PDO("mysql:host=$dbhost;dbname=$dbname;charset=utf8", $dbuser, $dbpass);  
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  return $dbh;
}


$app->run();
?>
