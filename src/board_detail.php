<?php

define( "DOC_ROOT", $_SERVER["DOCUMENT_ROOT"]."/" ); // $_SERVER : 슈퍼글로벌 변수 ($_대문자) / 현재 사이트가 위치한 서버상의 위치
define( "URL_DB", DOC_ROOT."mini_board/src/common/db_common.php" );
include_once( URL_DB ); // db_common.php 불러옴

// Request parameter 획득(GET)
$arr_get = $_GET;

// DB에서 게시글 정보 획득
$result_info = select_board_info_no( $arr_get["board_no"] );

?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif+KR:wght@400;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./board_list.css">
</head>
<body>
    <div class="detail_container">
        <div>
            <p class="detail_board_no">게시글 번호 : <?php echo $result_info["board_no"]?></p>
            <p class="detail_board_write_date">작성일 : <?php echo $result_info["board_write_date"]?></p>
            <p>게시글 제목 : <?php echo $result_info["board_title"]?></p>
            <p>게시글 내용 : <?php echo $result_info["board_contents"]?></p>
        </div>
    
        <button type="button">
            <a href="board_update.php?board_no=<?php echo $result_info["board_no"]?> ">
                수정
            </a>
        </button>
        <button type="button">
            <a href="board_delete.php?board_no=<?php echo $result_info["board_no"]?>">
                삭제
            </a>
        </button>
    </div>
</body>
</html>