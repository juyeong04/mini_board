INSERT INTO board_info (
	board_title
	, board_contents
	, board_write_date
)
VALUES (
	'제목 20'
	, '내용 20'
	, NOW()
);


-- TRUNCATE table board_info;
SELECT* FROM board_info;
