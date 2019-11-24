<?php

namespace Test;

use \stdClass;
use EasyDB\EasyDB;
use Dotenv\Dotenv;
use PHPUnit\Framework\TestCase;


class EasyDBTest extends TestCase
{
    public $config;
    public $data;

    public function __construct()
    {
        parent::__construct();

        if (file_exists(__DIR__ . '/.env'))
        {
            $dotenv = Dotenv::create(__DIR__ );
            $dotenv->load();
        }
        else
        {
            trigger_error("No configuration found",  E_USER_WARNING);
        }

        $this->config = require __DIR__ . '/databases.php';

    }

    public function test_list()
    {
        $data = $this->add();

        $db = new EasyDB('db1', $this->config);

        $result = json_decode($db->list(), true);

        $this->assertTrue(key_exists($data->key, $result));
        $this->assertTrue($result[$data->key] === $data->value);

        $this->remove($data->key);
    }

    public function test_put_with_scalars()
    {
        $db     = new EasyDB('db1', $this->config);
        $key    = uniqid();
        $value  = rand(1,1000);

        $db->put($key, $value);

        $result = json_decode($db->get($key), true);

        $this->assertTrue($result === $value);

        $this->remove($key);
    }

    public function test_put_with_complex_values()
    {
        $db     = new EasyDB('db1', $this->config);
        $key    = uniqid();
        $value  = [
            'hamlet' => 'Listen to many, speak to a few.',
            'henry v' => 'Once more unto the breach, dear friends'
        ];

        $db->put($key, $value);

        $result = json_decode($db->get($key), true);

        $this->assertTrue($result['hamlet'] === $value['hamlet']);

        $this->remove($key);
    }

    public function test_get()
    {
        $data   = $this->add();
        $db     = new EasyDB('db1', $this->config);
        $result = $db->get($data->key);

        $this->assertNotEmpty($result);
        $this->assertTrue($data->value == $result);

        $this->remove($data->key);
    }

    public function test_delete()
    {
        $data = $this->add();

        $db = new EasyDB('db1', $this->config);
        $result = $db->delete($data->key);

        $this->assertTrue($result === '');
    }

    protected function add(): stdClass
    {
        $db     = new EasyDB('db1', $this->config);
        $key    = uniqid();
        $value  = rand(1,1000);

        $db->put($key, $value);

        $data        = new stdClass();
        $data->key   = $key;
        $data->value = $value;

        return $data;
    }

    /**
     * @param string $key
     */
    protected function remove($key)
    {
        $db = new EasyDB('db1', $this->config);
        $db->delete($key);
    }
}