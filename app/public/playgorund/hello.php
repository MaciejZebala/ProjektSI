<?php

class MathException extends InvalidArgumentException
{
}

class Math
{
    static public function inverse($x)
    {
        if (!$x) {
            throw new MathException('Division by zero!');
        }
        return 1/$x;
    }
}


try {
    var_dump(Math::inverse(5));
    var_dump(Math::inverse(0));
} catch (LogicException $e) {
    echo 'MathException!';
} catch (Exception $e) {
    echo 'Exception!';
} finally {
    echo 'Always executed!';
}