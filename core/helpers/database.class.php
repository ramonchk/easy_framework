<?php 
class database{
	private $database;
	private $usage;
	private $connection;
	public $returntype = 'json';

	public function init( $database = "default", $databaseinfos = null ){
		if( $databaseinfos == null ):
			$this->database = get_database_infos( $database );
		else:
			$this->database = $databaseinfos;
		endif;
		$this->usage = $this->database['driver'];
	}

	public function query( $sql, $data = null ){
		$pdo = array("mysql", "pgsql");

		if( in_array($this->usage, $pdo) ):
			$conn = $this->connection = new PDO( $this->database['driver'].":dbname=".$this->database['schema'].";host=".$this->database['host'], $this->database['username'], $this->database['password'], array( PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'" ) );
			$conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );    
			$query = $conn->prepare( $sql );

			if( $data != null ):
				foreach ( $data as $key => $value ):
					$query->bind_param( $key, $value );
				endforeach;
			endif;

			$data = array();
			$query->execute();

			while( $row = $query->fetch() ):
				foreach ( $row as $key => $value ):
					if( is_int($key) ):
						unset( $row[$key] );
					endif;
				endforeach;
				
				array_push( $data, ($row) );
			endwhile;
			
			$conn = null;
			return $this->returnt( $data );
		endif;

		if( $this->usage == "mysqli" ):
			$this->connection = new mysqli( $this->database['host'], $this->database['username'], $this->database['password'], $this->database['schema'] );

			if ( mysqli_connect_errno() ):
				printf( "Falha na conexão: %s\n", mysqli_connect_error() ); 
				exit(); 
			endif;

			mysqli_set_charset( $this->connection, "utf8" );
			$querystmt = $this->connection->prepare( $sql );

			if( $data != null ):
				foreach ( $data as $key => $value ):
					$querystmt->bind_param( $key, $value );
				endforeach;
			endif;

			$querystmt->execute();
			$res = $querystmt->get_result();
			$data = array();

			while( $row = $res->fetch_array( MYSQLI_ASSOC ) ):
				array_push( $data, ($row) );
			endwhile;

			$this->connection->close();
			return $this->returnt( $data );
		endif;
	}

	private function returnt( $data ){
		if( $this->returntype == "json" ):
			return json_encode( $data,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES );
		elseif( $this->returntype == "array" ):
			return $data;
		else:
			return $data;
		endif;
	}
}
