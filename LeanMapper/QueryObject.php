<?php
/**
 * This file is part of the LeanMapper.
 * User: david
 * Created at: 9/23/13 6:48 PM
 */

namespace LeanMapper;


abstract class QueryObject {


	/**
	 * @param Repository $repository
	 *
	 * @return \DibiFluent|\DibiDataSource
	 */
	protected abstract function doCreateQuery(Repository $repository);


	/**
	 * @param Repository $repository
	 *
	 * @return \DibiDataSource
	 * @throws \UnexpectedValueException
	 */
	public function getQuery(Repository $repository)
	{
		$query = $this->doCreateQuery($repository);

		if(!$query instanceof \DibiFluent || !$query instanceof \DibiDataSource) {
			throw new \UnexpectedValueException(
				"Method 'doCreateQuery' must return " .
				"instanceof \\DibiFluent or \\DibiDataSource " .
				is_object($query) ? 'instance of ' . get_class($query) : gettype($query) . " given."
			);
		}

		if($query instanceof \DibiFluent) {
			$query = $query->toDataSource();
		}

		return $query;
	}


	/**
	 * @param Repository $repository
	 *
	 * @return mixed
	 */
	public function fetchOne(Repository $repository)
	{
		$query = $this->getQuery($repository)->applyLimit(1);

		return $query->fetch();
	}


}
