<?php
define( "DOC_ROOT", $_SERVER["DOCUMENT_ROOT"]."/" ); // $_SERVER : 슈퍼글로벌 변수 ($_대문자) / 현재 사이트가 위치한 서버상의 위치
define( "URL_DB", DOC_ROOT."mini_board/src/common/db_common.php" );
include_once( URL_DB ); // db_common.php 불러옴

$arr_get = $_GET;

$result_cnt = delete_board_info_no( $arr_get["board_no"] );

header( "Location: board_list.php" );
exit();


?>