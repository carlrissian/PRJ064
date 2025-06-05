<?php


namespace App\Tests\Unit\Pricing\Group\Domain;


use PHPUnit\Framework\TestCase;
use Pricing\Group\Domain\Group;

class GroupTest extends TestCase
{
    /**
     * @test
     */
    public function should_be_return_a_group(){
        $group = new Group(1,"A3");
        $this->assertInstanceOf(Group::class,$group);
    }
}