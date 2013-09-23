<?php
/**
 * This file is part of the LeanMapper.
 * User: david
 * Created at: 9/23/13 8:11 PM
 */

namespace LeanMapper;


class ResultSet implements \Countable, \IteratorAggregate {


	/**
	 * @var \DibiDataSource
	 */
	private $query;

	/**
	 * @var Repository
	 */
	private $repository;


	/**
	 * @var \DibiResult
	 */
	private $dibiResult;

	/**
	 * @var \DibiResultIterator
	 */
	private $dibiResultIterator;


	/**
	 * @param \DibiDataSource $query
	 * @param Repository $repository
	 */
	public function __construct(\DibiDataSource $query, Repository $repository)
	{

		$this->query = $query;
		$this->repository = $repository;
	}


	/**
	 * @param $row
	 * @param string $sorting
	 *
	 * @return $this
	 * @throws \RuntimeException
	 */
	public function applySorting($row, $sorting = 'ASC')
	{
		if ($this->dibiResultIterator !== NULL) {
			throw new \RuntimeException("Cannot modify result set, that was already fetched from storage.");
		}

		$this->query->orderBy($row, $sorting);

		return $this;
	}


	/**
	 * @param $limit
	 * @param null $offset
	 *
	 * @return $this
	 * @throws \RuntimeException
	 */
	public function applyPaging($limit, $offset = NULL)
	{
		if ($this->dibiResultIterator !== NULL) {
			throw new \RuntimeException("Cannot modify result set, that was already fetched from storage.");
		}

		$this->query->applyLimit($limit, $offset);

		return $this;
	}


	/**
	 * @return int
	 */
	public function count()
	{
		return $this->getDibiResult()->count();
	}


	/**
	 * @return ResultIterator
	 */
	public function getIterator()
	{
		if(!$this->dibiResultIterator) {
			$dibiResult = $this->getDibiResult();

			$this->dibiResultIterator =  new ResultIterator($dibiResult, $this->repository);
		}

		return $this->dibiResultIterator;
	}


	/**
	 * @return \DibiResult
	 */
	private function getDibiResult()
	{
		if(!$this->dibiResult) {
			$this->dibiResult = $this->query->getResult();
		}

		return $this->dibiResult;
	}
}
