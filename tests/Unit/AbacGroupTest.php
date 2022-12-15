<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\Abac\Group;
use App\Models\DTO\AbacGroupDTO;

class AbacGroupTest extends TestCase
{
    public function testCorrectAtributes()
    {
        $attributes    = $this->attributes();
        $policy_groups = $this->policygroups();
        $policy_group  = $policy_groups[0];
        $abac_group_dto = new AbacGroupDTO($attributes, $policy_group);
        $group = new Group();
        $result = $group->check($abac_group_dto);
        $this->assertTrue($result);
    }

    public function testWrongRole()
    {
        $attributes    = $this->attributes();
        $policy_groups = $this->policygroups();
        $attributes['user']['role'] = 'wrongrole';
        $policy_group  = $policy_groups[0];
        $abac_group_dto = new AbacGroupDTO($attributes, $policy_group);
        $group = new Group();
        $result = $group->check($abac_group_dto);
        $this->assertFalse($result);
    }

    public function testInactive()
    {
        $attributes    = $this->attributes();
        $policy_groups = $this->policygroups();
        $attributes['user']['active'] = false;
        $policy_group  = $policy_groups[0];
        $abac_group_dto = new AbacGroupDTO($attributes, $policy_group);
        $group = new Group();
        $result = $group->check($abac_group_dto);
        $this->assertFalse($result);
    }

    public function testWrongResource()
    {
        $attributes    = $this->attributes();
        $policy_groups = $this->policygroups();
        $attributes['resource']['resource'] = 'query {orders {id status phone}}';
        $policy_group  = $policy_groups[0];
        $abac_group_dto = new AbacGroupDTO($attributes, $policy_group);
        $group = new Group();
        $result = $group->check($abac_group_dto);
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

    public function policygroups()
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
        $rule1[] = $condition1;
        $rule1[] = $condition2;
        $rule1[] = $target;

        // Политика
        $policy1[] = $rule1;

        // Группа политик
        $policy_group1[] = $policy1;

        // Группы политик
        $policy_groups[] = $policy_group1;
        return $policy_groups;
    }
}
