<?php

/**
 * Test: Nette\Iterators\CachingIterator constructor.
 */

declare(strict_types=1);

use Nette\Iterators;
use Tester\Assert;


require __DIR__ . '/../bootstrap.php';


(function () { // ==> array
	$arr = ['Nette', 'Framework'];
	$tmp = [];
	foreach (new Iterators\CachingIterator($arr) as $k => $v) {
		$tmp[] = "$k => $v";
	}
	Assert::same([
		'0 => Nette',
		'1 => Framework',
	], $tmp);
})();


(function () { // ==> stdClass
	$arr = (object) ['Nette', 'Framework'];
	$tmp = [];
	foreach (new Iterators\CachingIterator($arr) as $k => $v) {
		$tmp[] = "$k => $v";
	}
	Assert::same([
		'0 => Nette',
		'1 => Framework',
	], $tmp);
})();


(function () { // ==> IteratorAggregate
	$arr = new ArrayObject(['Nette', 'Framework']);
	$tmp = [];
	foreach (new Iterators\CachingIterator($arr) as $k => $v) {
		$tmp[] = "$k => $v";
	}
	Assert::same([
		'0 => Nette',
		'1 => Framework',
	], $tmp);
})();


(function () { // ==> Iterator
	$arr = new ArrayObject(['Nette', 'Framework']);
	$tmp = [];
	foreach (new Iterators\CachingIterator($arr->getIterator()) as $k => $v) {
		$tmp[] = "$k => $v";
	}
	Assert::same([
		'0 => Nette',
		'1 => Framework',
	], $tmp);
})();


(function () { // ==> SimpleXMLElement
	$arr = new SimpleXMLElement('<feed><item>Nette</item><item>Framework</item></feed>');
	$tmp = [];
	foreach (new Iterators\CachingIterator($arr) as $k => $v) {
		$tmp[] = "$k => $v";
	}
	Assert::same([
		'item => Nette',
		'item => Framework',
	], $tmp);
})();


(function () { // ==> object
	Assert::exception(function () {
		$arr = dir('.');
		foreach (new Iterators\CachingIterator($arr) as $k => $v);
	}, InvalidArgumentException::class, NULL);
})();


class RecursiveIteratorAggregate implements IteratorAggregate
{
	public function getIterator()
	{
		return new ArrayObject(['Nette', 'Framework']);
	}
}


(function () { // ==> recursive IteratorAggregate
	$arr = new RecursiveIteratorAggregate;
	$tmp = [];
	foreach (new Iterators\CachingIterator($arr) as $k => $v) {
		$tmp[] = "$k => $v";
	}
	Assert::same([
		'0 => Nette',
		'1 => Framework',
	], $tmp);
})();
