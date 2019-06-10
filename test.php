<?php
require_once './Orm.php';


$conf = [];
$conf['host'] = '127.0.0.1';
$conf['port'] = 3306;
$conf['user'] = 'root';
$conf['passwd'] = 'root';
$conf['dbname'] = 'test';
$mysql = new Orm($conf);

//插入
$data = array(
    'sid' => 101,
    'aa' => 123456,
    'bbc' => 'aaaaaaaaaaaaaa',
);
$mysql->insert('t_table', $data);
//查询
$res = $mysql->field(array('sid', 'aa', 'bbc'))
    ->order(array('sid' => 'desc', 'aa' => 'asc'))
    ->where(array('sid' => "101", 'aa' => array('123455', '>', 'or')))
    ->limit(1, 2)
    ->select('t_table');
$res = $mysql->field('sid,aa,bbc')
    ->order('sid desc,aa asc')
    ->where('sid=101 or aa>123455')
    ->limit(1, 2)
    ->select('t_table');
//获取最后执行的sql语句
$sql = $mysql->getLastSql();
var_dump($sql );
echo  PHP_EOL;

//直接执行sql语句
$sql = "show tables";
$res = $mysql->doSql($sql);
var_dump($res);
echo  PHP_EOL;
//事务
$mysql->startTrans();
$mysql->where(array('sid' => 102))->update('t_table', ['aa' => 666666,'bbc' => '12sadas爱迪生']);
$mysql->where(array('sid' => 103))->update('t_table',['bbc' => '呵呵8888呵呵']);
$mysql->where(array('sid' => 104))->delete('t_table');
$mysql->commit();