<?php
/**
 * Created by JetBrains PhpStorm.
 * User: tetsu
 * Date: 12/02/26
 * Time: 14:05
 * To change this template use File | Settings | File Templates.
 */
foreach (glob('*Test.php') as $file)
{
    require $file;
}

class AllTests
{
    public static function suite()
    {
        $suite = new PHPUnit_Framework_TestSuite('PHPUnit');

        foreach (glob('*Test.php') as $file)
        {
            $suite->addTestSuite(substr($file,0,-4));
        }

        return $suite;
    }
}