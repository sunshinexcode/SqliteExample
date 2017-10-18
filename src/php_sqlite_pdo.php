<?php
/**
 * Sqlite PDO demo
 * CURD操作实例
 *
 * 20171018 - 第1版本
 *
 * Function
 * （功能）
 * - CURD操作实例
 *
 * Usage
 * （使用方法）
 * - 下载源码，点击运行run_php_sqlite_pdo.bat
 *
 * MIT license
 * Github: https://github.com/sunshinexcode/SqliteExample
 * Email: 24xinhui@163.com
 *
 * @author sunshine
 */
try {
    # Create (connect to) database in file
    # （创建数据库文件）
    $pdo = new PDO('sqlite:php_sqlite_pdo.db');


    # Create table user
    # （创建表）
    $pdo->exec("CREATE TABLE IF NOT EXISTS user (
                id INTEGER PRIMARY KEY, 
                name TEXT, 
                time TEXT)");


    # Insert data
    # （插入数据）
    # 方式1
    $sql = "INSERT INTO user (name, time) VALUES (:name, :time)";
    $stmt = $pdo->prepare($sql);
    $name = 'sunshine1';
    $time = date('Y-m-d H:i:s');
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':time', $time);
    $stmt->execute();

    # 方式2
    $sql = "INSERT INTO user (name, time) VALUES (:name, :time)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':name', 'sunshine2');
    $stmt->bindValue(':time', date('Y-m-d H:i:s'));
    $stmt->execute();

    # 方式3
    $sql = "INSERT INTO user (name, time) VALUES (:name, :time)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':name' => 'sunshine3', ':time' => date('Y-m-d H:i:s')]);

    # 方式4
    $sql = "INSERT INTO user (name, time) VALUES (?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['sunshine4', date('Y-m-d H:i:s')]);

    # 方式5
    $sql = "INSERT INTO user (name, time) VALUES ('sunshine5', '" . date('Y-m-d H:i:s') . "')";
    $pdo->exec($sql);


    # Update data
    # （更新数据，参考插入多种方式）
    $sql = "UPDATE user SET name = :name WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':name' => 'sunshine1_updated', ':id' => 1]);


    # Delete data
    # （删除数据）
    $sql = "DELETE FROM user WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => 2]);


    # Select data
    # （查询数据）
    $sql = "SELECT * FROM user";
    print_r($pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC));


    # Truncate data
    # （清空数据）
    $sql = "DELETE FROM sqlite_sequence WHERE name = 'user'";
    $pdo->exec($sql);
    $sql = "DELETE FROM user";
    $pdo->exec($sql);

} catch(Exception $e) {
    print_r($e);
}