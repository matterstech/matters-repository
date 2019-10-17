# matters-repository

[![Build Status](https://travis-ci.org/matterstech/matters-repository.svg?branch=master)](https://travis-ci.org/matterstech/matters-repository)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/matterstech/matters-repository/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/matterstech/matters-repository/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/matterstech/matters-repository/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/matterstech/matters-repository/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/inovia-team/matters-repository/v/stable)](https://packagist.org/packages/inovia-team/matters-repository)
[![License](https://poser.pugx.org/inovia-team/matters-repository/license)](https://packagist.org/packages/inovia-team/matters-repository)

Matters proposal usage of zend-repository

# Usage

## Definition of a \Matters\Repository

```php
<?php
    class TableRepository extends \Matters\Repository {

        public function findAllByName(string $name)
        {
            $select = $this->select();
            $select->where
                ->equalTo([
                    'name'       => $name,
                ]);

            $select->order(['created_at' => 'DESC']);

            return $this->fetchListEntities($select);
        }
    }
```

## Instanciation

```php
<?php
    $hydratingResultSet = new \Zend\Db\ResultSet\HydratingResultSet(
        new Hydrator(),
        new Model()
    );

    $tableGateway = new \Zend\Db\TableGateway\TableGateway(
        'table_name',
        new \Zend\Db\Adapter\Adapter($config),
        null,
        $hydratingResultSet
    );

    $tableRepository = new TableRepository($tableGateway);
    $entities = $tableRepository->findAllByName('Bob');    
```

# Tests

```php
./vendor/bin/phpunit tests
```
