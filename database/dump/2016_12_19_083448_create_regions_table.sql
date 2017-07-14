DROP PROCEDURE IF EXISTS `add_region`;
DELIMITER $$

CREATE PROCEDURE `add_region` (`ext_id_val` VARCHAR(255), `name_val` VARCHAR(255))
BEGIN
    DECLARE lines_count INT DEFAULT 0;
    SET lines_count = (SELECT count(*) FROM regions WHERE ext_id = ext_id_val);
    IF (lines_count > 0)
    THEN
      UPDATE regions
      SET
        name        = name_val,
        updated_at  = NOW()
      WHERE ext_id = ext_id_val;
    ELSE
      INSERT INTO regions
      SET
        name        = name_val,
        created_at  = NOW(),
        updated_at  = NOW(),
        ext_id = ext_id_val;
    END IF;
END
$$
DELIMITER ;

-- call add_region('777', 'test region');
-- call add_region('777', 'test region2');
