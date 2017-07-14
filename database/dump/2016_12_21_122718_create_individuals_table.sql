DROP PROCEDURE IF EXISTS `add_individual`;
DELIMITER $$

CREATE PROCEDURE `add_individual` (
    `ext_id_val` VARCHAR(255),
    `name_val` VARCHAR(255)
)
BEGIN
    DECLARE lines_count INT DEFAULT 0;
    SET lines_count = (SELECT count(*) FROM individuals WHERE ext_id = ext_id_val);
    IF (lines_count > 0)
    THEN
        UPDATE individuals
        SET
            name = name_val,
            updated_at  = NOW()
        WHERE ext_id = ext_id_val;
    ELSE
        INSERT INTO individuals
        SET
            name = name_val,
            created_at  = NOW(),
            updated_at  = NOW(),
            ext_id = ext_id_val;
    END IF;
END
$$
DELIMITER ;

-- call add_individual('161616', 'test individual');
-- call add_individual('161616', 'test individual2');
