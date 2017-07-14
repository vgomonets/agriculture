DROP PROCEDURE IF EXISTS `add_nomenclatura_group`;
DELIMITER $$

CREATE PROCEDURE `add_nomenclatura_group` (`ext_id_val` VARCHAR(255), `parent_ext_id_val` VARCHAR(255), `name_val` VARCHAR(255))
BEGIN
    DECLARE lines_count INT DEFAULT 0;
    DECLARE parent_id_val INT DEFAULT 0;
    DECLARE id_val INT DEFAULT NULL;

    IF (ext_id_val = '')
    THEN
        SIGNAL SQLSTATE 'ERR0R' SET MESSAGE_TEXT = 'Field "ext_id_val" can not be empty';
    END IF;

    SET lines_count = (SELECT count(*) FROM nomenclatura_groups WHERE ext_id = ext_id_val);
    SET parent_id_val = (SELECT id FROM nomenclatura_groups WHERE ext_id = parent_ext_id_val);
    IF (lines_count > 0)
    THEN
        UPDATE nomenclatura_groups
        SET
            name        = name_val,
            parent_id   = parent_id_val,
            parent_ext_id   = parent_ext_id_val,
            updated_at  = NOW()
        WHERE ext_id = ext_id_val;
    ELSE
        INSERT INTO nomenclatura_groups
        SET
            name        = name_val,
            parent_id   = parent_id_val,
            parent_ext_id   = parent_ext_id_val,
            created_at  = NOW(),
            updated_at  = NOW(),
            ext_id = ext_id_val;
    END IF;

    SET id_val = (SELECT id FROM nomenclatura_groups WHERE ext_id = ext_id_val LIMIT 1);
    UPDATE nomenclatura_groups SET parent_id = id_val WHERE parent_ext_id = ext_id_val;
END
$$
DELIMITER ;

-- call add_nomenclatura_group('nomenclatura_group_ext_id_val', 'nomenclatura_group_parent_ext_id_val', 'name_val');
