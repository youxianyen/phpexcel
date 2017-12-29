<?php
$host='localhost';
$user_name='root';
$password='';

$conn=mysqli_connect($host,$user_name,$password);
if (!$conn)
{
    die('数据库连接失败：'.mysqli_error());
}
echo '数据库连接成功！';

if (mysqli_close($conn))
{
    echo '<br/>...<br/>';
    echo '到数据库的连接已经成功关闭';
}
?>