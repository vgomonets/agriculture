DROP PROCEDURE IF EXISTS `add_nomenclatura`;
DELIMITER $$

CREATE PROCEDURE `add_nomenclatura`(`ext_id_val` VARCHAR(255),
    IN `nomenclatura_group_ext_id_val` VARCHAR(255),
    IN `nomenclatura_ext_type_id_val` VARCHAR(255),
    IN `customs_declaration_val` VARCHAR(255),
    IN `name_val` VARCHAR(255),
    IN `full_name_val` VARCHAR(255),
    IN `vat_val` VARCHAR(255)
)
BEGIN
    DECLARE lines_count INT DEFAULT 0;
    DECLARE nomenclatura_group_id_val INT DEFAULT NULL;
    DECLARE nomenclatura_type_id_val INT DEFAULT NULL;
    DECLARE vat_id_val INT DEFAULT NULL;

    IF (ext_id_val = '')
    THEN
        SIGNAL SQLSTATE 'ERR0R' SET MESSAGE_TEXT = 'Field "ext_id_val" can not be empty';
    END IF;

    SET nomenclatura_group_id_val = (SELECT id FROM nomenclatura_groups WHERE ext_id = nomenclatura_group_ext_id_val);
    IF (nomenclatura_group_id_val IS NULL)
    THEN
        SIGNAL SQLSTATE 'ERR0R' SET MESSAGE_TEXT = 'Nomenclatura group not found';
    END IF;

    SET nomenclatura_type_id_val = (SELECT id FROM nomenclatura_types WHERE ext_id = nomenclatura_ext_type_id_val);
    IF (nomenclatura_type_id_val IS NULL)
    THEN
        SIGNAL SQLSTATE 'ERR0R' SET MESSAGE_TEXT = 'Nomenclatura type not found';
    END IF;

    SET vat_id_val = (SELECT id FROM vats WHERE value = vat_val);
    IF (vat_id_val IS NULL)
    THEN
        SIGNAL SQLSTATE 'ERR0R' SET MESSAGE_TEXT = 'VAT not found';
    END IF;

    SET lines_count = (SELECT count(*) FROM nomenclaturas WHERE ext_id = ext_id_val);
    IF (lines_count > 0)
    THEN
        UPDATE nomenclaturas
        SET
            nomenclatura_group_id = nomenclatura_group_id_val,
            nomenclatura_type_id = nomenclatura_type_id_val,
            customs_declaration = customs_declaration_val,
            name = name_val,
            full_name = full_name_val,
            vat_id = vat_id_val,
            updated_at  = NOW()
        WHERE ext_id = ext_id_val;
    ELSE
        INSERT INTO nomenclaturas
        SET
            nomenclatura_group_id = (SELECT id FROM nomenclatura_groups WHERE ext_id = nomenclatura_group_ext_id_val),
            nomenclatura_type_id = (SELECT id FROM nomenclatura_types WHERE ext_id = nomenclatura_ext_type_id_val),
            customs_declaration = customs_declaration_val,
            name = name_val,
            full_name = full_name_val,
            vat_id = vat_id_val,
            created_at  = NOW(),
            updated_at  = NOW(),
            ext_id = ext_id_val;
    END IF;
END
$$
DELIMITER ;

-- call add_nomenclatura('nomencatura_ext_id_val', 'nomenclatura_group_ext_id_val', 'nomenclatura_type_ext_id_val', 'customs_declaration_val', 'name_val', 'full_name_val', '7%');
