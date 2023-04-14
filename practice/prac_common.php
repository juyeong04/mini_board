<?php
function db_conn(&$param)
{
    $host = "localhost";
    $user = "root";
    $pass = "root506";
    $charset = "utf8mb4";
    $db_name = "board";
    $dns = "mysql:host=".$host.";dbname=".$db_name.";charset=".$charset;
    $pdo_option =
        array(
            PDO::ATTR_EMULATE_PREPARES      => false
            ,PDO::ATTR_ERRMODE              => PDO::ERRMODE_EXCEPTION
            ,PDO::ATTR_DEFAULT_FETCH_MODE   => PDO::FETCH_ASSOC
        );

    try 
    {
        $param = new PDO($dns, $user, $pass, $pdo_option);
        return $param; // 리턴값 넣어주기!!!
    }
    catch (Exception $e)
    {
        $param = null;
        return $e->getMessage();
    }
}

function select_list()
{
    $sql = 
        " SELECT "
        ." board_no "
        ." , board_title "
        ." , board_write_date "
        ." FROM "
        ." board_info "
        ." WHERE "
        ." board_del_flg = '0' "
    ;

        $obj = null;
        $pdo = db_conn($obj);
        $stmt = $pdo->query($sql); // select는 prepare 없기 때문에 query로 돌려줌
        $result = $stmt->fetchAll();
        $obj = null;
        return $result;
}

function list_search (&$param)
{
    $sql =
        " SELECT "
        ." board_no "
        .",board_title "
        .",board_write_date "
        ." FROM "
        ." board_info "
        ." WHERE "
        ." board_del_flg = '0' "
        ." AND board_title LIKE CONCAT('%', :search, '%') "
        ;

    $arr = array(
        ":search" => $param["search_page"]
    );

    
        $obj = null;
        $conn = db_conn($obj);
        $stmt = $conn->prepare($sql);
        $stmt->execute($arr);
        $result = $stmt->fetchAll();
        $obj = null;
        return $result;
    }




?>