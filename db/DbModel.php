<?php

namespace paul_core\paul_core\db;
use paul_core\paul_core\Application;
use paul_core\paul_core\Model;

abstract class DbModel extends Model
{
    abstract public static function tableName(): string;

    abstract public function attributes(): array;

    abstract public static function primaryKey(): string;

    public function save()
    {
        $tableName = $this->tableName();
        $attributes = $this->attributes();
        $params = array_map(fn($attr) => ":$attr", $attributes);
        $statement = self::prepare("INSERT INTO $tableName (".implode(',', $attributes).") 
                VALUES(".implode(',', $params).")");
        foreach ($attributes as $attribute)
        {
            $statement->bindValue(":$attribute", $this->{$attribute});
        }
        $statement->execute();
        return true;
    }
    public static function findOne($where)         // bsp: ['email' => 'asdf@asdf.asdf', 'firstname' => 'zura']
    {
        $tableName = static::tableName();   //self::tableName() -> wont work because abstract
        $attributes = array_keys($where);
        $sql = implode(" AND ", array_map(fn($attr) => "$attr = :$attr", $attributes));
        // SELECT * FROM $tableName WHERE $sql
        $statement = self::prepare("SELECT * FROM $tableName WHERE $sql");
        foreach ($where as $key => $item)    {
            $statement->bindValue(":$key", $item);
        }
        $statement->execute();
        return $statement->fetchObject(static::class);
    }
    public static function prepare($sql)
    {
        return Application::$app->db->pdo->prepare($sql);
    }
}