<?php

namespace Of\InxStmtChanger;

/**
 * Statement changer
 * 
 * <code>
 * 
 * $sc = new StatementChanger("select * table from date_of > :date_of", ["date_of" => "2016-11-11"]);
 * $sc->execute();
 * $params = $sc->getParameters();
 * $sql = $sc->getSql();
 * 
 * </code>
 * 
 * @author openforce
 *
 */
class StatementChanger {
	
	private $targetSQL;
	
	private $sql;
	
	private $binds;
	
	
	private $parameters;
	
	public function __construct($sql, $binds = null)
	{
		$this->targetSql = $sql;
		$this->binds = $binds;
	}
	
	public function execute()
	{
		$sql = $this->targetSQL;
		
		$matches = array();
		preg_match_all("/:([0-9a-zA-Z_]+)/", $sql, $matches);
		$binds = $this->binds;
		$params = array();
		foreach($matches[1] as $idx => $key)
		{
			$params[$idx + 1] = $binds[$key];
			$sql = str_replace(":".$key, "?", $sql);
		}
		
		$this->sql = $sql;
		$this->parameters  = $params;
	}
	
	
	/**
	 * changed sql
	 * 
	 * before : select * from table where num > :num
	 * after  : select * from table where num > ?
	 * 
	 * @return string
	 */
	public function getSql() {
		return $this->sql;
	}

	
	public function getBinds() {
		return $this->binds;
	}
	public function setBinds($binds) {
		$this->binds = $binds;
		return $this;
	}
	
	public function getParameters() {
		return $this->parameters;
	}
	
	
}