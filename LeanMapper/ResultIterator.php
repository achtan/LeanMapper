<?php
/**
 * This file is part of the LeanMapper.
 * User: david
 * Created at: 9/23/13 8:54 PM
 */

namespace LeanMapper;


class ResultIterator extends \DibiResultIterator {

	/**
	 * @var Repository
	 */
	private $repository;


	/**
	 * @param \DibiResult $result
	 * @param Repository $repository
	 */
	public function __construct(\DibiResult $result, Repository $repository)
	{
		$this->repository = $repository;
		parent::__construct($result);
	}


	/**
	 * @inheritdoc
	 */
	public function current()
	{
		$row = parent::current();
		return $this->repository->createEntity($row);
	}

}
