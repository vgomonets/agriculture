DROP PROCEDURE IF EXISTS `add_nomenclatura_type`;
DELIMITER $$

CREATE PROCEDURE `add_nomenclatura_type` (`ext_id_val` VARCHAR(255), `name_val` VARCHAR(255))
BEGIN
    DECLARE lines_count INT DEFAULT 0;
    SET lines_count = (SELECT count(*) FROM nomenclatura_types WHERE ext_id = ext_id_val);
    IF (lines_count > 0)
    THEN
      UPDATE nomenclatura_types
      SET
        name        = name_val,
        updated_at  = NOW()
      WHERE ext_id = ext_id_val;
    ELSE
      INSERT INTO nomenclatura_types
      SET
        name        = name_val,
        created_at  = NOW(),
        updated_at  = NOW(),
        ext_id = ext_id_val;
    END IF;
END
$$
DELIMITER ;

-- call add_nomenclatura_type('nomenclatura_type_ext_id_val', 'name_val');
