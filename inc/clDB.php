<?php

/**
 * Arquivo: clDB.php
 * Função: Classe responsável pela conexão e operações com o banco de dados MySQL utilizando mysqli e prepared statements.
 * Local: /inc/
 */

class clDB {

	/** @var mysqli Conexão com o banco */
	protected $connection;
	/** @var mysqli_stmt Resultado da query */
	protected $query;
	/** @var bool Controla se a última query foi fechada */
	protected $query_closed = true;
	/** @var bool Exibir mensagens de erro */
	protected $show_errors = true;
	/** @var int Contador de queries executadas */
	public $query_count = 0;
	/** @var string Classificação do erro para depuração */
	public $class_error = "";

	/**
	 * Construtor: cria conexão com o banco
	 */
	public function __construct($dbhost = 'localhost', $dbuser = 'root', $dbpass = '', $dbname = '', $charset = 'utf8') {
		$this->connection = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
		if ($this->connection->connect_error) {
			$this->error('Falha ao conectar no MySQL - ' . $this->connection->connect_error);
		}
		$this->connection->set_charset($charset);
	}

	/**
	 * Prepara e executa uma query com ou sem parâmetros
	 */
	public function query($query) {
		if (!$this->query_closed) {
			$this->query->close();
		}

		if ($this->query = $this->connection->prepare($query)) {
			if (func_num_args() > 1) {
				$x = func_get_args();
				$sqlErr = $x[0];
				$args = array_slice($x, 1);
				$types = '';
				$args_ref = array();
				foreach ($args as $k => &$arg) {
					if (is_array($args[$k])) {
						foreach ($args[$k] as $j => &$a) {
							$types .= $this->_gettype($args[$k][$j]);
							$args_ref[] = &$a;
						}
					} else {
						$types .= $this->_gettype($args[$k]);
						$args_ref[] = &$arg;
					}
				}
				array_unshift($args_ref, $types);
				call_user_func_array(array($this->query, 'bind_param'), $args_ref);
			} else {
				$sqlErr = $query;
			}
			$this->query->execute();
			if ($this->query->errno) {
				$this->class_error = "Query";
				$this->error('Erro MySQL ao executar a query - ' . $this->query->error, str_replace("'", "`", $sqlErr));
			}
			$this->query_closed = false;
			$this->query_count++;
			$this->class_error = "NoError";
		} else {
			$sqlErr = $query;
			if (func_num_args() > 1) {
				$x = func_get_args();
				$sqlErr = $x[0];
			}
			$this->class_error = "Connection";
			$this->error('Erro MySQL ao preparar a query - ' . $this->connection->error, str_replace("'", "`", $sqlErr));
		}
		return $this;
	}

	/**
	 * Retorna todos os resultados da query como array de arrays
	 */
	public function fetchAll($callback = null) {
		$params = array();
		$row = array();
		$meta = $this->query->result_metadata();
		while ($field = $meta->fetch_field()) {
			$params[] = &$row[$field->name];
		}
		call_user_func_array(array($this->query, 'bind_result'), $params);
		$result = array();
		while ($this->query->fetch()) {
			$r = array();
			foreach ($row as $key => $val) {
				$r[$key] = $val;
			}
			if ($callback != null && is_callable($callback)) {
				$value = call_user_func($callback, $r);
				if ($value === 'break') break;
				$result[] = $value;
			} else {
				$result[] = $r;
			}
		}
		$this->query->close();
		$this->query_closed = true;
		return $result;
	}

	/**
	 * Retorna um único resultado da query como array associativo
	 */
	public function fetchArray() {
		$params = array();
		$row = array();
		$meta = $this->query->result_metadata();
		while ($field = $meta->fetch_field()) {
			$params[] = &$row[$field->name];
		}
		call_user_func_array(array($this->query, 'bind_result'), $params);
		$result = array();
		if ($this->query->fetch()) {
			foreach ($row as $key => $val) {
				$result[$key] = $val;
			}
		}
		$this->query->close();
		$this->query_closed = true;
		return $result;
	}

	/** Fecha a conexão com o banco */
	public function close() {
		return $this->connection->close();
	}

	/** Retorna o número de linhas retornadas pela query */
	public function numRows() {
		$this->query->store_result();
		return $this->query->num_rows;
	}

	/** Retorna o número de linhas afetadas */
	public function affectedRows() {
		return $this->query->affected_rows;
	}

	/** Retorna o ID da última inserção */
	public function lastInsertID() {
		return $this->connection->insert_id;
	}

	/**
	 * Exibe erro e registra em arquivo de log
	 */
	public function error($error, $params = "") {
		// Caminho para a pasta /log/ na raiz do projeto
        $log_dir = __DIR__ . '/../log/';
        
        // Cria a pasta /log/ se não existir
        if (!is_dir($log_dir)) {
            mkdir($log_dir, 0755, true);
        }

        $log_file = $log_dir . 'db_errors.log';
        $max_size = 5 * 1024 * 1024; // 5 MB

      // Se o arquivo existe e ultrapassa o limite, renomeia com timestamp detalhado
        if (file_exists($log_file) && filesize($log_file) >= $max_size) {
            // pega timestamp com milissegundos
            $microtime = microtime(true);
            $micro_sec = sprintf("%03d", ($microtime - floor($microtime)) * 1000);
            $date = new DateTime(date('Y-m-d H:i:s.' . $micro_sec, (int)$microtime));
            $timestamp = $date->format("YmdHis") . $micro_sec;

            $new_name = __DIR__ . "/db_erros" . $timestamp . ".log";
            rename($log_file, $new_name);
        }

		$date = date('Y-m-d H:i:s');
		$class = $this->class_error ?: 'Desconhecido';
		$log_entry = "[$date] Erro $class: $error\n";
		if ($params !== "") {
			$log_entry .= "Query/Parâmetros: $params\n";
		}
		$log_entry .= "------------------------\n";
		file_put_contents($log_file, $log_entry, FILE_APPEND);
		if ($this->show_errors) {
			exit($error);
		}
	}

	/**
	 * Retorna o tipo para bind_param com base no tipo da variável
	 */
	private function _gettype($var) {
		if (is_string($var)) return 's';
		if (is_float($var)) return 'd';
		if (is_int($var)) return 'i';
		return 'b';
	}
}
