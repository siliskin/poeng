
<?php
header("meta charset='utf-8'");
require 'vendor/autoload.php';
use Slim\Slim;
$app = new \Slim\Slim(array(
  'mode' => 'development',
  'debug' => true
  ));

$app->response()->header('Content-Type', 'application/json;charset=utf-8');    

//People
$app->get('/people', 'getPeople');
$app->get('/people/user/:id', 'getUser');
$app->post('/people/user', 'addUser');
$app->put('/people/user/:id', 'updateUser');
$app->delete('/people/:id',  'deleteUser');
$app->get('/activities', 'getActivities');
$app->get('/activities/activity/:id', 'getActivity');
$app->post('/activities/activity', 'addActivity');
$app->put('/activities/schedule', 'getSchedule');
// $app->get('/activities/schedule', 'getSchedule');
// $app->put('/activities/schedule', 'editSchedule');
// $app->get('/attendance', 'getAttendance');
// $app->get('/attendance/:uid', 'getAttendance');
// $app->post('/attendance/:date', 'addAttendance');
// $app->put('/attendance/:date', 'editAttendance');
// $app->get('/points', 'getPoints');
// $app->get('/points/:uid', 'getPoints');


$app->get('/', function () {
  echo "Hello there";
});



function getPeople() {
  $sql = "select * FROM users ORDER BY name";
  try {
    $db = getConnection();
    $stmt = $db->query($sql);  
    $people = $stmt->fetchAll(PDO::FETCH_OBJ);
    $db = null;
    global $app;
    echo '{"people": ' . json_encode($people) . '}';
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
    echo json_encode($user); 
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
    echo json_encode($user); 
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
  echo json_encode($user); 
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


//Activities

// $app->get('/activities/activity/:id', 'getActivity');
// $app->post('/activities/activity', 'addActivity');
// $app->get('/activities/schedule', 'getSchedule');
// $app->put('/activities/schedule', 'editSchedule');

function getActivities() {
  $sql = "SELECT * FROM activities ORDER BY points";
  try {
    $db = getConnection();
    $stmt = $db->query($sql);  
    $activities = $stmt->fetchAll(PDO::FETCH_OBJ);
    $db = null;
    global $app;
    echo '{"activities": ' . json_encode($activities) . '}';
  } catch(PDOException $e) {
    echo '{"error":{"text":'. $e->getMessage() .'}}'; 
  }
}
function getActivity($id) {
  $sql = "SELECT * FROM activities WHERE id=:id";
  try {
    $db = getConnection();
    $stmt = $db->prepare($sql);  
    $stmt->bindParam("id", $id);
    $stmt->execute();
    $act = $stmt->fetchObject();  
    $db = null;
    var_dump( $act );
    echo json_encode($act); 
  } catch(PDOException $e) {
    echo '{"error":{"text":'. $e->getMessage() .'}}'; 
  }
}

function addActivity() {
  $request = Slim::getInstance()->request();
  $act = json_decode($request->getBody());
  $sql = "INSERT INTO ACTIVITIES (name, points) VALUES(:name, :points)";
  try {
    $db = getConnection();
    $stmt = $db->prepare($sql);  
    $stmt->bindParam("name", $act->name);
    $stmt->bindParam("points", $act->points);
    $stmt->execute();
    $db = null;
    echo '{"result": "ok"}';
  } catch(PDOException $e) {
    echo '{"error":{"text":'. $e->getMessage() .'}}'; 
  }
}



function getConnection() {
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