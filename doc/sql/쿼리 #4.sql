SELECT 
	board_no
	, board_title
	, board_write_date
FROM board_info
WHERE board_del_flg = '0' -- 삭제되지 않은 게시글만 불러오기
ORDER BY board_no ASC
LIMIT 5 OFFSET 0
;