<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\Abac\Condition;
use App\Models\DTO\AbacConditionDTO;

class AbacConditionTest extends TestCase
{
    public function testCorrectAtributes()
    {
        $attributes = $this->attributes();
        $cond_value = $this->condition();
        $attr_group = $cond_value['attr_group'];
        $attribute  = $cond_value['attribute'];
        $value      = $cond_value['value'];
        $abac_condition_dto = new AbacConditionDTO($attributes, $attr_group, $attribute, $value);
        $condition = new Condition();
        $result = $condition->check($abac_condition_dto);
        $this->assertTrue($result);
    }

    public function testWrongRole()
    {
        $attributes = $this->attributes();
        $attributes['user']['role'] = 'wrongrole';
        $cond_value = $this->condition();
        $attr_group = $cond_value['attr_group'];
        $attribute  = $cond_value['attribute'];
        $value      = $cond_value['value'];
        $abac_condition_dto = new AbacConditionDTO($attributes, $attr_group, $attribute, $value);
        $condition = new Condition();
        $result = $condition->check($abac_condition_dto);
        $this->assertFalse($result);
    }

    private function attributes()
    {
        $user = array(
            'id'     => 1,
            'name'   => 'Пётр',
            'role'   => 'cook',
            'active' => true,
        );
        $resource = array(
            'resource' => 'query {orders {id status}}',
        );
        $attributes = array(
            'user'     => $user,     // Атрибуты пользователя
            'resource' => $resource, // Атрибуты ресурса
        );
        return $attributes;
    }

    private function condition()
    {
        $condition = array(
            'attr_group' => 'user',
            'attribute'  => 'role',
            'value'      => 'cook',
        );
        return $condition;
    }
}
