<?php

const USER_TYPES = [
    'id' => 'integer',
    'name' => 'string',
    'test' => 'integer|string'
];

class User
{
    public function firstMethod($id)
    {
        return $id;
    }

    final protected function secondMethod()
    {
    }

    private static function thirdMethod()
    {
    }
}

function verifyTypes($target, $argName) {
    if ($argName === 'id') {
        return gettype($target) === USER_TYPES['id'];
    }
    if ($argName === 'name') {
        return gettype($target) === USER_TYPES['name'];
    }
    if ($argName === 'test') {
        $types = explode("|", USER_TYPES['test']);
        return in_array(gettype($target), $types);
    }
}

try {
    $class = new ReflectionMethod('User', 'firstMethod');
    $methods = $class->getParameters();
    $id = 1234;
    $result = verifyTypes($id, $methods[0]->getName());
    if (!$result) {
        throw new TypeError('type is different.');
    }
    echo $class->invoke(new User(), $id) . "\n";
} catch (TypeError $e) {
    echo $e->getMessage() . "\n";
}