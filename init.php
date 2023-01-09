<?php

class Debug {

  private static bool $status = false;
  
  public static function getter_status() {
    return self::$status;
  }

}

interface IEntity{ }

class EntityDomain implements IEntity {
  private string $id;
  private string $dtRegister;  // private DateTime $dtRegister;

  public function setter_id($id) {
    Debug::getter_status() ? print_r('EntityDomain -> setter_id($id)' . '<br>') : '';
    $this->id = $id;
  }

  public function getter_id() {
    Debug::getter_status() ? print_r('EntityDomain -> getter_id()' . '<br>') : '';
    return $this->id;
  }

  public function setter_dtRegister($dtRegister) {
    Debug::getter_status() ? print_r('EntityDomain -> setter_dtRegister($dtRegister)' . '<br>') : '';
    $this->dtRegister = $dtRegister;
  }

  public function getter_dtRegister() {
    Debug::getter_status() ? print_r('EntityDomain -> getter_dtRegister()' . '<br>') : '';
    return $this->dtRegister;
  }

  public function __construct() {
    Debug::getter_status() ? print_r('EntityDomain -> Construtor()' . '<br>') : '';
  }

  public function print_entitydomain() {
    echo 'id: ' . $this->getter_id() . '<br>';
    echo 'dtRegister: ' . $this->getter_dtRegister() . '<br>';      
  }
  
}

class Person extends EntityDomain implements JsonSerializable {
  
  private string $firstName;
  private string $lastName;

  public function setter_firstName($firstName) {
    Debug::getter_status() ? print_r('Person -> setter_firstName($firstName)' . '<br>') : '';
    $this->firstName = $firstName;
  }

  public function getter_firstName() {
    Debug::getter_status() ? print_r('Person -> getter_firstName()' . '<br>') : '';
      return $this->firstName;
  }

  public function setter_lastName($lastName) {
    Debug::getter_status() ? print_r('Person -> setter_lastName($lastName)' . '<br>') : '';
    $this->lastName = $lastName;
  }

  public function getter_lastName() {
    Debug::getter_status() ? print_r('Person -> getter_lastName()' . '<br>') : '';
    return $this->lastName;
  }

  public function __construct() {
    Debug::getter_status() ? print_r('Person -> Construtor()' . '<br>') : '';
  }
  
  public function print_person() {
    echo 'id: ' . $this->getter_id() . '<br>';
    echo 'dtRegister: ' . $this->getter_dtRegister() . '<br>';
    echo 'firstName: ' . $this->getter_firstName() . '<br>';
    echo 'lastName: ' . $this->getter_lastName() . '<br>';   
  }

  public function jsonSerialize() {
    return [
      'id' => $this->getter_id(),
      'dtRegister' => $this->getter_dtRegister(),
      'firstName' => $this->getter_firstName(),
      'lastName' => $this->getter_lastName()
    ];
  }

}

class Result {

  private ?string $message = null;
  private $entities = [];

  public function setter_msg($message) {
    Debug::getter_status() ? print_r('Result -> setter_msg($msg)' . '<br>') : '';
    $this->message = $message;
  }

  public function getter_msg() {
    Debug::getter_status() ? print_r('Result -> getter_msg($msg)' . '<br>') : '';
    return $this->message;
  }

  public function setter_entities($entities) {
    Debug::getter_status() ? print_r('Result -> setter_entities($entities)' . '<br>') : '';
    array_push($this->entities, $entities);
  }

  public function getter_entities() {
    Debug::getter_status() ? print_r('Result -> getter_entities($entities)' . '<br>') : '';
    return $this->entities;
  }

  public function print_entitydomain() {
      echo "---------<br>";
      print_r("msg: ". $this->getter_msg().PHP_EOL);
      foreach($this->getter_entities() as $entity) {
          print_r("entity: ". $entity->print_entity().PHP_EOL);
      }
  }

}

interface IDAO {
  public function insert(EntityDomain $entitydomain) : void;
  public function update(EntityDomain $entitydomain) : void;
  public function read(EntityDomain $entitydomain) : array;
  public function delete(EntityDomain $entitydomain) : void;
}

interface IStrategy {
  public function process(EntityDomain $entitydomain) : string;
}

interface IFacade {
  public function insert(EntityDomain $entitydomain) : Result;
  public function update(EntityDomain $entitydomain) : Result;
  public function read(EntityDomain $entitydomain) : Result;
  public function delete(EntityDomain $entitydomain) : Result;
}

class CompleteDateRegister implements IStrategy {
  public function process(EntityDomain $entitydomain) : string {
    Debug::getter_status() ? print_r('CompleteDateRegister -> process($entitydomain)' . '<br>') : '';
    if(is_null($entitydomain->getter_dtRegister())) {
      $dtnow = date('d/m/Y', time());
      $entitydomain->setter_dtRegister( $dtnow );
      Debug::getter_status() ? print_r('CompleteDateRegister -> process($entitydomain) -> today: ' . $entitydomain->getter_dtRegister()) : '';
    }
    return '';
  }
}

class UtilDAO {

  private static string $ServerName = 'localhost';
  private static string $UserName = 'root';
  private static string $Password = '';
  private static string $DbName = 'teste';
  
  public static function getConnectionMySql() {
    Debug::getter_status() ? print_r('UtilDAO -> getConnectionMySql()' . '<br>') : '';
    $connection = null;
    try {
      $connection = new mysqli(self::$ServerName, self::$UserName, self::$Password, self::$DbName);
    } catch (Exception $ex) {
      throw new Exception('Get connection error');
    } finally {
      return $connection;
    }
  }

}

abstract class AbstractDAO implements IDAO {

  protected $connection;

  public function setter_connection($connection) {
    Debug::getter_status() ? print_r('AbstractDAO -> setter_connection(connection)' . '<br>') : '';
    $this->connection = $connection;
  }

  public function getter_connection() {
    Debug::getter_status() ? print_r('AbstractDAO -> getter_connection()' . '<br>') : '';
    return $this->connection;
  }

  public function __construct() {
    Debug::getter_status() ? print_r('AbstractDAO -> __construct()' . '<br>') : '';
    $connection = null;
  }

  protected function openConnection() : void {
    Debug::getter_status() ? print_r('AbstractDAO -> openConnection()' . '<br>') : '';
    try {
      if(is_null($this->getter_connection())){
        $this->setter_connection( UtilDAO::getConnectionMySql() );
        Debug::getter_status() ? print_r('AbstractDAO -> openConnection() -> connection::OPEN' . '<br>') : '';
      }
    } catch (Exception $ex) {
      throw new Exception('Open connection error');
    }
  }

  public function closeConnection() : void {
    Debug::getter_status() ? print_r('AbstractDAO -> closeConnection()' . '<br>') : '';
    if(!is_null($this->getter_connection())) {
      $this->getter_connection()->connection->closeConnection();
    }
  }

}

class PersonDAO extends AbstractDAO {

  public function insert(EntityDomain $entitydomain): void {
    Debug::getter_status() ? print_r('PersonDAO -> insert(EntityDomain)' . '<br>') : '';
    $conn = null;
    if(is_null($entitydomain)) { 
      Debug::getter_status() ? print_r('PersonDAO -> insert(EntityDomain) -> entitydomain::NULL' . '<br>') : '';
      return; 
    }
    try {
      $this->openConnection();
      $conn = $this->getter_connection();

      $_sql_ = sprintf(
        "INSERT INTO person (dtregister, firstname, lastname) VALUES ('%s', '%s', '%s')", 
        $entitydomain->getter_dtRegister(), $entitydomain->getter_firstName(), $entitydomain->getter_lastName()
      );

      $conn->query($_sql_);
    } catch (Exception $ex) {
      throw new Exception('DB_INSERT_ERROR');
    } finally {
      $conn->closeConnection();
    }
  }

  public function update(EntityDomain $entitydomain) : void {
    Debug::getter_status() ? print_r('PersonDAO -> update(EntityDomain)' . '<br>') : '';
    $conn = null;
    if(is_null($entitydomain)) { 
      Debug::getter_status() ? print_r('PersonDAO -> update(EntityDomain) -> entitydomain::NULL' . '<br>') : '';
      return; 
    }
    try {
      $this->openConnection();
      $conn = $this->getter_connection();
      $_sql_ = sprintf(
        "UPDATE person SET firstname = '%s', lastname = '%s' WHERE id = %u", 
        $entitydomain->getter_firstName(), $entitydomain->getter_lastName(), $entitydomain->getter_id()
      );
      $conn->query($_sql_);
    } catch (Exception $ex) {
      throw new Exception('DB_UPDATE_ERROR');
    } finally {
      $conn->closeConnection();
    }
  }

  public function read(EntityDomain $entitydomain) : array {
    Debug::getter_status() ? print_r('PersonDAO -> read(EntityDomain)' . '<br>') : '';
    
    if(is_null($entitydomain)) { 
      Debug::getter_status() ? print_r('PersonDAO -> read(EntityDomain) -> entitydomain::NULL' . '<br>') : '';
      return []; 
    }
    
    $conn = null;
    $entities = [];
    
    try {
      
      $this->openConnection();
      $conn = $this->getter_connection();

      $_sql_ = '';
      if(is_null($entitydomain->getter_id()) || empty($entitydomain->getter_id()) || $entitydomain->getter_id() == 0) {
        $_sql_ = "SELECT * FROM person";
      } else if ($entitydomain->getter_id() > 0) {
        $_sql_ = sprintf("SELECT * FROM person WHERE id = %u", $entitydomain->getter_id());
      }

      $query_result = $conn->query($_sql_);
      
      if ($query_result->num_rows == 0) {
        throw new Exception('No data');
      }

      while($row = $query_result->fetch_assoc()) {
        $entity_person = new Person();
        // $entity_person->setter_id((int)$row["id"]);
        $entity_person->setter_id($row["id"]);
        $entity_person->setter_dtRegister($row["dtregister"]);
        $entity_person->setter_firstName($row["firstname"]);
        $entity_person->setter_lastName($row["lastname"]);
        Debug::getter_status() ? print_r('PersonDAO -> read(EntityDomain) -> Person item' . '<br>' . $entity_person->print_person() . '<br>') : '';
        array_push($entities, $entity_person);
      }

    } catch (Exception $ex) {
      throw new Exception('DB_INSERT_ERROR');
    } finally {
      // $conn->closeConnection();
      return $entities;
    }
  }

  public function delete(EntityDomain $entitydomain) : void {
    Debug::getter_status() ? print_r('PersonDAO -> delete(EntityDomain)' . '<br>') : '';
    $conn = null;
    if(is_null($entitydomain)) { 
      Debug::getter_status() ? print_r('PersonDAO -> delete(EntityDomain) -> entitydomain::NULL' . '<br>') : '';
      return; 
    }
    try {
      $this->openConnection();
      $conn = $this->getter_connection();
      $_sql_ = '';
      if(is_null($entitydomain->getter_id()) || empty($entitydomain->getter_id()) || $entitydomain->getter_id() == 0) {
        $_sql_ = "DELETE FROM person";
      } else if ($entitydomain->getter_id() > 0) {
        $_sql_ = sprintf("DELETE FROM person WHERE id = %u", $entitydomain->getter_id());
      }
      $conn->query($_sql_);
    } catch (Exception $ex) {
      throw new Exception('DB_UPDATE_ERROR');
    } finally {
      $conn->closeConnection();
    }
  }
  
}

class Facade implements IFacade {

  private Result $result;
  private $daos = [];
  private $rns = [];

  public function setter_result($result) {
    Debug::getter_status() ? print_r('Facade -> setter_result($result)' . '<br>') : '';
    $this->result = $result;
  }

  public function getter_result() {
    Debug::getter_status() ? print_r('Facade -> getter_result()' . '<br>') : '';
    return $this->result;
  }

  public function setter_daos($daos) {
    Debug::getter_status() ? print_r('Facade -> setter_daos($daos)' . '<br>') : '';
    $this->daos = $daos;
  }

  public function getter_daos() {
    Debug::getter_status() ? print_r('Facade -> getter_daos()' . '<br>') : '';
    return $this->daos;
  }

  public function setter_rns($rns) {
    Debug::getter_status() ? print_r('Facade -> setter_rns($rns)' . '<br>') : '';
    $this->rns = $rns;
  }

  public function getter_rns() {
    Debug::getter_status() ? print_r('Facade -> getter_rns()' . '<br>') : '';
    return $this->rns;
  }

  public function __construct() {
    Debug::getter_status() ? print_r('Facade -> __construct()' . '<br>') : '';

    $this->daos = [
      get_class(new Person()) => new PersonDAO()
    ];

    $lstPersonValidations = [];

    $lstPersonValidationsUpsert = [
      new CompleteDateRegister()
    ];

    $dicPerson = [
      '_INSERT_' => $lstPersonValidationsUpsert
      , '_UPDATE_' => $lstPersonValidationsUpsert
      , '_READ_' => $lstPersonValidations
      , '_DELETE_'=> $lstPersonValidations
    ];

    $this->rns = [
      get_class(new Person()) => $dicPerson
    ];
  }
    
	public function insert(EntityDomain $entitydomain): Result {
    Debug::getter_status() ? print_r('Facade -> insert($entitydomain)' . '<br>') : '';
    $this->setter_result(new Result());
    $msg = $this->executarRegras($entitydomain, '_INSERT_');
    try {
      // if(!empty($msg)) {
      //   $this->getter_result()->setter_msg($msg);
      //   $this->getter_result()->setter_entities([]);
      // } else {
        $dao = $this->daos[ get_class($entitydomain) ];
        $dao->insert( $entitydomain );
        $this->getter_result()->setter_msg('');
        $this->getter_result()->setter_entities($entitydomain);
      // }
    } catch (Execption $ex) {
      $this->getter_result()->setter_msg('DB_INSERT_ERROR');
    } finally {
      return $this->getter_result();
    }
	}
	
	public function update(EntityDomain $entitydomain): Result {
    Debug::getter_status() ? print_r('Facade -> update($entitydomain)' . '<br>') : '';
    $this->setter_result(new Result());
    $msg = $this->executarRegras($entitydomain, '_UPDATE_');
    try {
      // if(!empty($msg)) {
      //   $this->getter_result()->setter_msg($msg);
      //   $this->getter_result()->setter_entities([]);
      // } else {
        $dao = $this->daos[ get_class($entitydomain) ];
        $dao->update( $entitydomain );
        $this->getter_result()->setter_msg('');
        $this->getter_result()->setter_entities($entitydomain);
      // }
    } catch (Execption $ex) {
      $this->getter_result()->setter_msg('DB_UPDATE_ERROR');
    } finally {
      return $this->getter_result();
    }
	}

	public function read(EntityDomain $entitydomain): Result {
    Debug::getter_status() ? print_r('Facade -> read($entitydomain)' . '<br>') : '';
    $this->setter_result(new Result());
    $msg = $this->executarRegras($entitydomain, '_READ_');
    try {
      // if(!empty($msg)) {
      //   $this->getter_result()->setter_msg($msg);
      //   $this->getter_result()->setter_entities([]);
      // } else {
        
        $dao = $this->daos[ get_class($entitydomain) ];
        $entities = $dao->read( $entitydomain );

        $this->getter_result()->setter_msg('');
        $this->getter_result()->setter_entities($entities);
        
        // $this->getter_result()->setter_msg('');
        // $this->getter_result()->setter_entities($entitydomain);
      // }
    } catch (Execption $ex) {
      $this->getter_result()->setter_msg('DB_READ_ERROR');
    } finally {
      return $this->getter_result();
    }    
	}

	public function delete(EntityDomain $entitydomain): Result {
    Debug::getter_status() ? print_r('Facade -> delete($entitydomain)' . '<br>') : '';
    $this->setter_result(new Result());
    $msg = $this->executarRegras($entitydomain, '_DELETE_');
    try {
      // if(!empty($msg)) {
      //   $this->getter_result()->setter_msg($msg);
      //   $this->getter_result()->setter_entities([]);
      // } else {
        $dao = $this->daos[ get_class($entitydomain) ];
        $dao->delete( $entitydomain );
        $this->getter_result()->setter_msg('');
        $this->getter_result()->setter_entities($entitydomain);
      // }
    } catch (Execption $ex) {
      $this->getter_result()->setter_msg('DB_DELETE_ERROR');
    } finally {
      return $this->getter_result();
    }
	}

  private function executarRegras(EntityDomain $entitydomain, string $operation) : string {
    Debug::getter_status() ? print_r('Facade -> executarRegras($entitydomain, $operation)' . '<br>') : '';
    $operationsRules = $this->getter_rns()[ get_class(new Person()) ];
    $message = '';
    if(!is_null($operationsRules)) {
      $rules = $operationsRules[ $operation ];
      if(!is_null($rules)) {
        foreach ($rules as $rule) {
          $msg = $rule->process($entitydomain);
          if(!is_null($msg) || $msg != '') {
            $message .= $msg . PHP_EOL;
          }
        }
      }
    }
    return !empty($message) ? $message : '';
  }

}

class ControllerPessoa {

  private $facade;

  public function setter_facade($facade) {
    Debug::getter_status() ? print_r('ControllerPessoa -> setter_facade($facade)' . '<br>') : '';
    $this->facade = $facade;
  }

  public function getter_facade() {
    Debug::getter_status() ? print_r('ControllerPessoa -> getter_facade()' . '<br>') : '';
    return $this->facade;
  }

  public function __construct() {
    Debug::getter_status() ? print_r('ControllerPessoa -> __construct()' . '<br>') : '';
    $this->setter_facade(new Facade());
  }

  function insert($person) {
    Debug::getter_status() ? print_r('ControllerPessoa -> insert()' . '<br>') : '';

    $result = $this->getter_facade()->insert( $person );
    
    if(!empty($result->getter_msg())) {
      Debug::getter_status() ? print_r('OPERATION RESULT - INSERT() ==> ' . $result->getter_msg() . '<br>') : '';
    } else {
      Debug::getter_status() ? print_r('OPERATION RESULT - INSERT() ==> SUCCESS ' . $result->getter_msg() . '<br>') : '';
    }
  }

  function update($person) {
    Debug::getter_status() ? print_r('ControllerPessoa -> update()' . '<br>') : '';

    $result = $this->getter_facade()->update( $person );
    
    if(!empty($result->getter_msg())) {
      Debug::getter_status() ? print_r('OPERATION RESULT - UPDATE() ==> ' . $result->getter_msg() . '<br>') : '';
    } else {
      Debug::getter_status() ? print_r('OPERATION RESULT - UPDATE() ==> SUCCESS ' . $result->getter_msg() . '<br>') : '';
    }
  }

  function delete($person) {
    Debug::getter_status() ? print_r('ControllerPessoa -> delete()' . '<br>') : '';

    $result = $this->getter_facade()->delete( $person );

    if(!empty($result->getter_msg())) {
      Debug::getter_status() ? print_r('OPERATION RESULT - DELETE() ==> ' . $result->getter_msg() . '<br>') : '';
    } else {
      Debug::getter_status() ? print_r('OPERATION RESULT - DELETE() ==> SUCCESS ' . $result->getter_msg() . '<br>') : '';
    }
  }

  function read($person) {
    Debug::getter_status() ? print_r('ControllerPessoa -> read()' . '<br>') : '';

    $result = (object) $this->getter_facade()->read( $person );

    if(!empty($result->getter_msg())) {
      Debug::getter_status() ? print_r('OPERATION RESULT - READ() ==> ' . $result->getter_msg() . '<br>') : '';
    } else {
      Debug::getter_status() ? print_r('OPERATION RESULT - READ() ==> SUCCESS ' . $result->getter_msg() . '<br>') : '';
    }

    return $result->getter_entities()[0];
  }

}

?>