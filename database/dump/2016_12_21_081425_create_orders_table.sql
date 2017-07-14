DROP PROCEDURE IF EXISTS `add_order`;
DELIMITER $$

CREATE PROCEDURE `add_order` (
    `ext_id_val` VARCHAR(255),
    `group_id_val` VARCHAR(255),
    `name_val` VARCHAR(255),
    `unit_val` VARCHAR(255),
    `full_name_val` VARCHAR(255),
    `nomenclatura_id_val` VARCHAR(255),
    `vat_val` VARCHAR(255),
    `customs_declaration_id_val` VARCHAR(255)
)
BEGIN
    DECLARE lines_count INT DEFAULT 0;
    SET lines_count = (SELECT count(*) FROM orders WHERE ext_id = ext_id_val);
    IF (lines_count > 0)
    THEN
        UPDATE orders
        SET
            group_id = (SELECT id FROM order_groups WHERE ext_id = group_id_val),
            name = name_val,
            unit_id = (SELECT id FROM units WHERE value = unit_val),
            full_name = full_name_val,
            nomenclatura_id = (SELECT id FROM nomenclaturas WHERE ext_id = nomenclatura_id_val),
            vat_id = (SELECT id FROM vats WHERE value = vat_val),
            customs_declaration_id = (SELECT id FROM customs_declarations WHERE ext_id = customs_declaration_id_val),
            updated_at  = NOW()
      WHERE ext_id = ext_id_val;
    ELSE
        INSERT INTO orders
        SET
            group_id = (SELECT id FROM order_groups WHERE ext_id = group_id_val),
            name = name_val,
            unit_id = (SELECT id FROM units WHERE value = unit_val),
            full_name = full_name_val,
            nomenclatura_id = (SELECT id FROM nomenclaturas WHERE ext_id = nomenclatura_id_val),
            vat_id = (SELECT id FROM vats WHERE value = vat_val),
            customs_declaration_id = (SELECT id FROM customs_declarations WHERE ext_id = customs_declaration_id_val),
            created_at  = NOW(),
            updated_at  = NOW(),
            ext_id = ext_id_val;
    END IF;
END
$$
DELIMITER ;

-- call add_nomenclatura_group('111', 'test nomenclatura2');
-- call add_unit('222', 'test unit2');
-- call add_nomenclatura_type('333', 'test nomenclatura type2');
-- call add_customs_declaration('444');
-- call add_nomenclatura('555', '111', '222', '333', '444', 'test nomenclatura name', 'test nomenclatura full name', '20%');
-- call add_nomenclatura('555', '111', '222', '333', '444', 'test nomenclatura name', 'test nomenclatura full name', '20%');
-- call add_order_group('141414', 'test order group');
-- call add_order('151515', '141414', 'test order name', 'test unit2', 'test order full name', '555', '20%', '444');
-- call add_order('151515', '141414', 'test order name2', 'test unit2', 'test order full name2', '555', '0%', '444');
