<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\Abac\Rule;
use App\Models\DTO\AbacRuleDTO;

class AbacRuleTest extends TestCase
{
    public function testCorrectAtributes()
    {
        $attributes = $this->attributes();
        $rule_value = $this->rule();
        $abac_rule_dto = new AbacRuleDTO($attributes, $rule_value);
        $rule = new Rule();
        $result = $rule->check($abac_rule_dto);
        $this->assertTrue($result);
    }

    public function testWrongRole()
    {
        $attributes = $this->attributes();
        $rule_value = $this->rule();
        $attributes['user']['role'] = 'wrongrole';
        $abac_rule_dto = new AbacRuleDTO($attributes, $rule_value);
        $rule = new Rule();
        $result = $rule->check($abac_rule_dto);
        $this->assertFalse($result);
    }

    public function testInactive()
    {
        $attributes = $this->attributes();
        $rule_value = $this->rule();
        $attributes['user']['active'] = false;
        $abac_rule_dto = new AbacRuleDTO($attributes, $rule_value);
        $rule = new Rule();
        $result = $rule->check($abac_rule_dto);
        $this->assertFalse($result);
    }

    public function testWrongResource()
    {
        $attributes = $this->attributes();
        $rule_value = $this->rule();
        $attributes['resource']['resource'] = 'query {orders {id status phone}}';
        $abac_rule_dto = new AbacRuleDTO($attributes, $rule_value);
        $rule = new Rule();
        $result = $rule->check($abac_rule_dto);
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

    private function rule()
    {
        // например повар может видеть в заказах только id и статус
        // Условия
        // Условие1: должен быть поваром
        $condition1 = array(
            'attr_group' => 'user',
            'attribute'  => 'role',
            'value'      => 'cook',
        );
        // Условие2: должен быть активным
        $condition2 = array(
            'attr_group' => 'user',
            'attribute'  => 'active',
            'value'      => true,
        );
        // Цель: запрос к таблице заказов, поля id status
        $target = array(
            'attr_group' => 'resource',
            'attribute'  => 'resource',
            'value'      => 'query {orders {id status}}',
        );
        // Правило
        $rule[] = $condition1;
        $rule[] = $condition2;
        $rule[] = $target;
        return $rule;
    }
}
