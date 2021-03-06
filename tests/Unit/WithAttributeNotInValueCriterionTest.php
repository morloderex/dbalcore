<?php

namespace Napp\Core\Dbal\Tests\Unit;

use Napp\Core\Dbal\Criteria\CriterionInterface;
use Napp\Core\Dbal\Criteria\WithAttributeNotInValuesCriterion;
use Napp\Core\Dbal\Tests\TestCase;

class WithAttributeNotInValueCriterionTest extends TestCase
{
    /**
     * @var WithAttributeNotInValuesCriterion
     */
    protected $criterion;

    public function setUp()
    {
        parent::setUp();

        $this->criterion = new WithAttributeNotInValuesCriterion('email', ['john@example.com']);
    }

    public function test_it_implements_interface()
    {
        $this->assertInstanceOf(CriterionInterface::class, $this->criterion);
    }

    public function test_it_applies_constraints()
    {
        $model = $this->getMockBuilder(\Illuminate\Database\Eloquent\Model::class)->getMock();
        $model->expects($this->once())
            ->method('getTable')
            ->willReturn('users');

        $query = $this->getMockBuilder(\Illuminate\Database\Query\Builder::class)
            ->disableOriginalConstructor()
            ->getMock();
        $query->expects($this->once())
            ->method('whereNotIn')
            ->with('users.email', ['john@example.com'])
            ->willReturn($query);

        $builder = $this->getMockBuilder(\Illuminate\Database\Eloquent\Builder::class)
            ->disableOriginalConstructor()
            ->setMethods(['getQuery', 'getModel'])
            ->getMock();
        $builder->expects($this->once())
            ->method('getModel')
            ->willReturn($model);
        $builder->expects($this->once())
            ->method('getQuery')
            ->willReturn($query);

        $this->criterion->apply($builder);
    }
}
