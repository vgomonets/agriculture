DROP PROCEDURE IF EXISTS `add_customs_declaration`;
DELIMITER $$

CREATE PROCEDURE `add_customs_declaration` (`ext_id_val` VARCHAR(255))
BEGIN
    DECLARE lines_count INT DEFAULT 0;
    SET lines_count = (SELECT count(*) FROM customs_declarations WHERE ext_id = ext_id_val);
    IF (lines_count > 0)
    THEN
      UPDATE customs_declarations
      SET
        updated_at  = NOW()
      WHERE ext_id = ext_id_val;
    ELSE
      INSERT INTO customs_declarations
      SET
        created_at  = NOW(),
        updated_at  = NOW(),
        ext_id = ext_id_val;
    END IF;
END
$$
DELIMITER ;

-- call add_customs_declaration('444');
