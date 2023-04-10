<?php
//vscode cmd 터미널에서 폴더 hdox에 복붙하기 =>
// xcopy D:\Students\workspace\mini_board\src C:\Apache24\htdocs\mini_board\src /E /H /F /Y -->
    
define( "DOC_ROOT", $_SERVER["DOCUMENT_ROOT"]."/" ); // $_SERVER : 슈퍼글로벌 변수 ($_대문자) / 현재 사이트가 위치한 서버상의 위치
    define( "URL_DB", DOC_ROOT."mini_board/src/common/db_common.php" );
    include_once( URL_DB ); // db_common.php 불러옴

    if( array_key_exists( "page_num", $_GET) )
    {
        $page_num = $_GET["page_num"]; // 페이지 이동
    }
    else
    {
        $page_num = 5; // 디폴트 페이지 값
    }



    $limit_num = 5;

    // 게시판 정보 테이블 전체 카운트 획득
    $result_cnt = select_board_info_cnt();

    // max page number
    $max_page_num = ceil( (int)$result_cnt[0]["cnt"] / $limit_num ); // 올림

    // offset : 1페이지일때 0, 2페이지일때 5, 3페이지일때 10... 
    $offset = ( $page_num * $limit_num ) - $limit_num;

    $arr_prepare = 
        array(
            "limit_num" => $limit_num
            ,"offset" => $offset
        );
    $result_paging = select_board_info_paging( $arr_prepare );
    // print_r($max_page_num);

    var_dump($result_paging);
?>


<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <title>게시판</title>
</head>
<body>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>게시글 번호</th>
                <th>게시글 제목</th>
                <th>작성일자</th>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach( $result_paging as $recode )
                {
            ?>
                    <tr>
                    <td><?php echo $recode["board_no"] ?></td>
                    <td><?php echo $recode["board_title"] ?></td>
                    <td><?php echo $recode["board_write_date"] ?></td>
                    </tr>
            <?php
                }
            ?>
        </tbody>
    </table>
    <?php
        for ($i = 1; $i <= $max_page_num; $i++) 
        { 
    ?>
            <a href='board_list.php?page_num=<?php echo $i ?>'><?php echo $i ?></a>
            <!-- get 방식 -->
    <?php
        }
    ?>
</body>
</html>
