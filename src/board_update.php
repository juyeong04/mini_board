<?php

    define( "DOC_ROOT", $_SERVER["DOCUMENT_ROOT"]."/" ); // $_SERVER : 슈퍼글로벌 변수 ($_대문자) / 현재 사이트가 위치한 서버상의 위치
    define( "URL_DB", DOC_ROOT."mini_board/src/common/db_common.php" );
    include_once( URL_DB ); // db_common.php 불러옴

    $http_method = $_SERVER["REQUEST_METHOD"]; // get방식이면 GET post방식이면 POST 라고 출력

    // GET 일때
    
    if( $http_method === "GET" )
    {
        $board_no = 1;
        if( array_key_exists( "board_no", $_GET) ) // $_GET : 슈퍼글로벌 변수, 연상배열로 불러와서 get에 담김
        {
            $board_no = $_GET["board_no"]; 
        }
        $result_info = select_board_info_no( $board_no );
    }
    
    // POST 일때 : url 뒤에 값이 보이지 않음
    else
    {
        $arr_post = $_POST; // post 변수 임시 변수에 저장
        $arr_info =
            array(
                "board_no" => $arr_post["board_no"]
                ,"board_title" => $arr_post["board_title"]
                ,"board_contents" => $arr_post["board_contents"]
            );
        // update
        $result_cnt = update_board_info_no( $arr_info );

        // // select : update된 거 다시 화면에 출력
        // $result_info = select_board_info_no( $arr_post["board_no"] ); 0412 del

        header("Location: board_detail.php?board_no=".$arr_post["board_no"]);
        //Location: board_detail.php?board_no=1 이렇게 표시됨
        exit(); // exit 이후 코드는 실행 안함 header 이용해서 redirect 해서 다른 화면 넘어갈거기 때문
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
    <form method="post" action="board_update.php"> <!-- name 값은 key값이 됨 -->
        <label for="bno">게시글 번호 : </label>
        <input type="text" name= "board_no" id= "bno" value="<?php echo $result_info['board_no'] ?>" readonly>
        <br>
        <label for="title">게시글 제목 : </label>
        <input type="text" name= "board_title" id= "title" value="<?php echo $result_info['board_title'] ?>" >
        <br>
        <label for="contents">게시글 내용 : </label>
        <input type="text" name= "board_contents" id= "contents" value="<?php echo $result_info['board_contents'] ?>" > 
        <br>
        <button type="submit">수정</button>
        <button type="button">
            <a href="board_detail.php?board_no=<?php echo $result_info["board_no"]?>">
                취소
            </a>
        </button>
    </form>
    <button type="button"><a href="board_list.php">리스트</a></button>

</body>
</html>