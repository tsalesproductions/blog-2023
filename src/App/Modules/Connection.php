<?php
	namespace App\Modules;
	
	use PDO;

	class Connection{
		private $pdo;
    
		public function __construct($host, $username, $password, $database) {
			try {
				$this->pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
				$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			} catch (PDOException $e) {
				die("Erro na conexão com o banco de dados: " . $e->getMessage());
			}
		}
		
		public function query($sql, $params = []) {
			try {
				$stmt = $this->pdo->prepare($sql);
				$stmt->execute($params);
				return $stmt;
			} catch (PDOException $e) {
				die("Erro na execução da consulta: " . $e->getMessage());
			}
		}

		public function select($table, $columns = '*', $where = '', $params = []) {
			$sql = "SELECT $columns FROM $table";
			if (!empty($where)) {
				$sql .= " WHERE $where";
			}

			$stmt = $this->query($sql, $params);
			return $stmt->fetchAll(PDO::FETCH_ASSOC);
		}

		public function insert($table, $data) {
			$columns = implode(', ', array_keys($data));
			$placeholders = implode(', ', array_fill(0, count($data), '?'));

			$sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";

			try {
				$stmt = $this->query($sql, array_values($data));
				return $this->pdo->lastInsertId();
			} catch (PDOException $e) {
				die("Erro na inserção de dados: " . $e->getMessage());
			}
		}

		public function update($table, $data, $where, $params = []) {
			$setClause = implode('=?, ', array_keys($data)) . '=?';
			$sql = "UPDATE $table SET $setClause WHERE $where";

			try {
				$stmt = $this->query($sql, array_merge(array_values($data), $params));
				return $stmt->rowCount();
			} catch (PDOException $e) {
				die("Erro na atualização de dados: " . $e->getMessage());
			}
		}

		public function delete($table, $where, $params = []) {
			$sql = "DELETE FROM $table WHERE $where";

			try {
				$stmt = $this->query($sql, $params);
				return $stmt->rowCount();
			} catch (PDOException $e) {
				die("Erro na exclusão de dados: " . $e->getMessage());
			}
		}
		
	}

	// Exemplo de uso:
	$db = new Connection(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

	// Consulta de seleção
	$results = $db->select('banners', '*', '', []);
	var_dump($results);

	// Inserção
	//$insertedId = $db->insert('tabela', ['coluna1' => 'valor1', 'coluna2' => 'valor2']);

	// Atualização
	//$affectedRows = $db->update('tabela', ['coluna1' => 'novo_valor'], 'coluna2 = ?', ['valor2']);

	// Exclusão
	//$affectedRows = $db->delete('tabela', 'coluna1 = ?', ['valor1']);
?>
