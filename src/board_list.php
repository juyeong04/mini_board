<?php
//vscode cmd 터미널에서 폴더 hdox에 복붙하기 =>
// xcopy D:\Students\workspace\mini_board\src C:\Apache24\htdocs\mini_board\src /E /H /F /Y -->
    
define( "DOC_ROOT", $_SERVER["DOCUMENT_ROOT"]."/" ); // $_SERVER : 슈퍼글로벌 변수 ($_대문자) / 현재 사이트가 위치한 서버상의 위치
    define( "URL_DB", DOC_ROOT."mini_board/src/common/db_common.php" );
    include_once( URL_DB ); // db_common.php 불러옴

    // GET 체크
    if( array_key_exists( "page_num", $_GET) )
    {
        $page_num = $_GET["page_num"]; // 페이지 이동
    }
    else
    {
        $page_num = 1; // 디폴트 페이지 값
    }



    $limit_num = 5;

    // 게시판 정보 테이블 전체 카운트 획득
    $result_cnt = select_board_info_cnt();

    // max page number
    $max_page_num = ceil( (int)$result_cnt[0]["cnt"] / $limit_num ); // 올림

    var_dump($max_page_num);
    // offset : 1페이지일때 게시글번호 0번 부터 시작, 2페이지일때 게시글번호 5번 부터 시작, 3페이지일때 10... 
    $offset = ( $page_num * $limit_num ) - $limit_num;

    $arr_prepare = 
        array(
            "limit_num" => $limit_num
            ,"offset" => $offset
        );
    $result_paging = select_board_info_paging( $arr_prepare );
?>


<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="./board_list.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif+KR:wght@400;900&display=swap" rel="stylesheet">
    <title>게시판</title>
    </head>
<body>
    <h1>게시판</h1>
    <div class= "container">
        <div class= "table_all">
            <table class="table table-striped table table-bordered">
                <thead>
                    <tr>
                        <th class = "board_no" >게시글 번호</th>
                        <th class = "board_title" >게시글 제목</th>
                        <th class = "board_time">작성일자</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach( $result_paging as $recode )
                        {
                    ?>
                            <tr>
                            <td><?php echo $recode["board_no"] ?></td>
                            <td><a href="board_update.php?board_no=<?php echo $recode["board_no"]?>"><?php echo $recode["board_title"] ?></a></td>
                            <td><?php echo $recode["board_write_date"] ?></td>
                            </tr>
                    <?php
                        }
                    ?>
                </tbody>
            </table>
        </div>
        
        <div class= "a_tag">
            <?php
            if( $page_num > 1) // 
            {
            ?>
                <a href='board_list.php?page_num=<?php echo $page_num -1 ?>'class="btn btn-outline-primary"><</a>
            <?php
            }
            else
            {
            ?>
                <!-- <a href='board_list.php?page_num=<?php //echo $page_num ?>'class="btn btn-outline-primary"><</a> -->
                <a href=''class="btn btn-outline-primary"><</a> <!-- if 조건 false여도 남아 있게 하려면 href 값 없애주면 됨 -->
            <?php
            }
                for ($i = 1; $i <= $max_page_num; $i++) 
                { 
            ?>
                <a href='board_list.php?page_num=<?php echo $i ?>'class="btn btn-outline-primary"><?php echo $i ?></a>
                    <!-- get 방식 -->
                    
            <?php
                }
                if( $page_num < $max_page_num )
            {
            ?>
                <a href='board_list.php?page_num=<?php echo $page_num +1 ?>'class="btn btn-outline-primary">></a>
            <?php
            }
            else
            {
            ?>
                <!-- <a href='board_list.php?page_num=<?php //echo $page_num ?>'class="btn btn-outline-primary">></a> -->
                <a href=''class="btn btn-outline-primary">></a>
            <?php
            }
            ?>
        </div>
    </div>
    
    
</body>
</html>