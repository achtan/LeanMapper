<?php

use LeanMapper\Entity;
use LeanMapper\QueryObject;
use LeanMapper\Repository;
use LeanMapper\Result;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';

//////////

class Book extends Entity
{
}

class AvailableBooks extends QueryObject
{

	/** @inheritdoc */
	protected function doCreateQuery(Repository $repository)
	{
		return $repository->getCommand()->where('available = %i', 1);
	}
}

class BookRepository extends Repository {

}


$bookRepository = new BookRepository($connection, $mapper);

$books = $bookRepository->fetch(new AvailableBooks())->applyPaging(1);

foreach($books as $book) {
	Assert::true($book instanceof Book);
}
