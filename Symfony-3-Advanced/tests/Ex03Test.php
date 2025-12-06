<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use PHPUnit\Framework\TestCase;
use App\Service\Ex03Service;
use Simplex\Framework;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentResolverInterface;
use Symfony\Component\HttpKernel\Controller\ControllerResolverInterface;
use Symfony\Component\Routing;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;


class Ex03Test extends TestCase{

    public function testUppercaseWords(){

        $ex03service = new Ex03Service();

        #case1
        $request = "hello";
        $compare = "Hello";

        $return = $ex03service->uppercaseWords($request);
        $this->assertEquals($compare, $return);

        #case2
        $request = "";
        $compare = "";

        $return = $ex03service->uppercaseWords($request);
        $this->assertEquals($compare, $return);

        #case3
        $request = "fsd rf jh qw a  ad";
        $compare = "Fsd Rf Jh Qw A  Ad";

        $return = $ex03service->uppercaseWords($request);
        $this->assertEquals($compare, $return);
        
    }


    public function testCountNumbers(){

        $ex03service = new Ex03Service();

        #case1
        $request = "43534";
        $compare = 5;

        $return = $ex03service->countNumbers($request);
        $this->assertEquals($compare, $return);

        #case2
        $request = "";
        $compare = 0;

        $return = $ex03service->countNumbers($request);
        $this->assertEquals($compare, $return);

        #case3
        $request = "a3das fgh5h d6fg q w213";
        $compare = 6;

        $return = $ex03service->countNumbers($request);
        $this->assertEquals($compare, $return);
    }

}


?>