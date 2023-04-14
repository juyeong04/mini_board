<?php
define("ROOT_SER", $_SERVER["DOCUMENT_ROOT"]."/mini_board/practice");
define("URL", ROOT_SER."/prac_common.php");
//include_once("D:\Students\workspace\mini_board\practice\prac_common.php"); // 상수는 $ 붙이면 안됨!!!!
include_once(URL);

$rqs_mt = $_SERVER["REQUEST_METHOD"];

if( $rqs_mt === "GET" )
{
    $arr_get = $_GET;
    $result_list = list_search($arr_get);
}
else
{
    $result_list = select_list();
}


?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>게시판</title>
</head>
<body>
    <form action="prac_board_list.php" method="get">
        <label for="search">검색
            <input type="text" name="search_page" id="search">
        </label>
        <button type="submit">검색</button>
    </form>
    <table>
        <thead>
            <tr>
                <th>게시글 번호</th>
                <th>게시글 제목</th>
                <th>게시글 작성일자</th>
            </tr>
        </thead>
        <tbody>
                <?php foreach ($result_list as $val) 
                {
                ?>
            <tr>
                    <td><?php echo $val["board_no"]?></td>
                    <td><?php echo $val["board_title"]?></td>
                    <td><?php echo $val["board_write_date"]?></td>
            </tr>
                <?php
                }
                ?>
        </tbody>
    </table>
</body>
</html>