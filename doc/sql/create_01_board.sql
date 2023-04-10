CREATE DATABASE board;

USE board;

-- 데이터베이스 새로 만들어서 사용 지정해주기

-- 이하 new 테이블 생성

CREATE TABLE board_info (
	board_no INT PRIMARY KEY AUTO_INCREMENT
	, board_title VARCHAR(100) NOT NULL
	, board_contents VARCHAR(1000) NOT NULL 
	, board_write_date DATETIME NOT NULL 
	, board_del_flg CHAR(1) NOT NULL DEFAULT ('0') -- 디폴트 괄호넣기!
	, board_del_date DATETIME
);

DESC board_info; --  만든거 밑에 출력해서 보여줌(원래 이렇게 확인해야됨!!)

