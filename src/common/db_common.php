<?php

// --- PDO 함수
function db_conn( &$param_conn )
{
    $host       = "localhost";
    $user       = "root";
    $pass       = "root506";
    $charset    = "utf8mb4";
    $db_name    = "board";
    $dns        = "mysql:host=".$host.";dbname=".$db_name.";charset=".$charset;
    $pdo_option = 
        array(
            PDO::ATTR_EMULATE_PREPARES      => false
            , PDO::ATTR_ERRMODE             => PDO::ERRMODE_EXCEPTION 
            , PDO::ATTR_DEFAULT_FETCH_MODE  => PDO::FETCH_ASSOC 
        );

    try
    {
        $param_conn = new PDO( $dns, $user, $pass, $pdo_option );

    }
    catch ( Exception $e )
    {
        $param_conn = null;
        throw new Exception( $e->getMessage() );
    }
}

// --- 쿼리 함수
// 게시글 페이지
function select_board_info_paging( &$param_arr )
{
    $sql = 
    " SELECT " 
	." board_no "
	.", board_title "
	.", board_write_date "
    ." FROM "
    ." board_info "
    ." WHERE " 
    ." board_del_flg = '0' " 
    ." ORDER BY " 
    ." board_no DESC "
    ." LIMIT :limit_num OFFSET :offset "
    ;

    $arr_prepare = 
        array(
            ":limit_num"    => $param_arr["limit_num"]
            ,":offset"      => $param_arr["offset"]
        );
    
    $conn = null;
    
    try
    {
        db_conn( $conn );
        $stmt = $conn->prepare( $sql );
        $stmt->execute($arr_prepare);
        $result = $stmt->fetchAll();
    }
    catch( Exception $e )
    {
        return $e->getMessage();
    }
    finally
    {
        $conn = null; // 닫음
    }

    return $result;
}





// --- 전체 count 가져오기
function select_board_info_cnt() 
{
    $sql = 
    " SELECT "
    ."      COUNT(*) cnt "
    ." FROM "
    ."      board_info "
    ." WHERE "
    ."      board_del_flg = '0' " // 빼먹지 말기!
    ;
    $arr_prepare = array();
    
    $conn = null;
    
    try
    {
        db_conn( $conn );
        $stmt = $conn->prepare( $sql );
        $stmt->execute( $arr_prepare );
        $result = $stmt->fetchAll();
    }
    catch( Exception $e )
    {
        return $e->getMessage();
    }
    finally
    {
        $conn = null; // 닫음
    }
    
    return $result;
}


// TODO :  test Start
// $arr = 
//     array(
    //         "limit_num" => 5
    //         ,"offset"    => 0
    //     );
    // $result = select_board_info_paging( $arr );
    // // print_r( $result );
    
    
    // TODO : test End



// 게시글번호 1번 불러오면 게시글1번 정보가 불러지게
function select_board_info_no( &$param_no )
    {
        $sql = 
        " SELECT " 
        ." board_no "
        ." ,board_title "
        ." ,board_contents "
    ." FROM "
    ." board_info "
    ." WHERE " 
    ." board_no = :board_no " 
    ;
    
    $arr_prepare = 
    array(
        ":board_no" => $param_no
    );
    
    $conn = null;
    
    try
    {
        db_conn( $conn );
        $stmt = $conn->prepare( $sql );
        $stmt->execute($arr_prepare);
        $result = $stmt->fetchAll();
    }
    catch( Exception $e )
    {
        return $e->getMessage();
    }
    finally
    {
        $conn = null; // 닫음
    }
    
    return $result[0]; // fetch했을때 이차원배열로 가져옴
    /* array(
        array(
            "board_no" => "1"
            ,"board_title" => "제목1"
            )
            )*/
        }
        
    // TODO : start
    $i = 1;
    print_r(select_board_info_no($i));
    // // TODO : end


//------------------------------------
// 함수명   : update_board_info_no
// 기능     : 게시판 특정 게시글 정보 검색
// 파라미터 : Array     &$param_arr
// 리턴값   : INT/STRING      $result_cnt/ERRMSG(에러메세지)
//------------------------------------
function update_board_info_no( &$param_arr )
{
    $sql = 
    " UPDATE "
    ." board_info "
    ." SET "
    ."  board_title = :board_title "
    ."  ,board_contents = :board_contents "
    ." WHERE "
    ."  board_no = :board_no "
    ;
    $arr_prepare = 
    array(
        ":board_title" => $param_arr["board_title"]
        ,":board_contents" => $param_arr["board_contents"]
        ,":board_no" => $param_arr["board_no"]
    );

    $conn = null;
    
    try
    {
        db_conn( $conn ); // PDO object set(db연결)
        $conn-> beginTransaction(); // transaction 시작 (commit, rollback 만나면 트랜잭션 종료됨)
        $stmt = $conn->prepare( $sql ); // statement object 셋팅
        $stmt->execute( $arr_prepare ); // db request
        $result_cnt = $stmt->rowCount();// update 때 수정된(영향받은) 행의 갯수가 넘어옴
        $conn->commit();
    }
    catch( Exception $e )
    {
        $conn->rollback();
        return $e->getMessage();
    }
    finally
    {
        $conn = null; // PDO 파기
    }
    
    return $result_cnt;
}


// $arr=
//     array(
    //         "board_no" => 1
    //         ,"board_title" => "test1"
    //         ,"board_contents" =>"testtest1"
    //     );
    // echo update_board_info_no( $arr );
?>