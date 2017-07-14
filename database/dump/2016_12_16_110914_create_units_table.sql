DROP PROCEDURE IF EXISTS `add_unit`;
DROP PROCEDURE IF EXISTS `remove_unit`;


DROP FUNCTION IF EXISTS `add_unit`;
DELIMITER $$

CREATE FUNCTION `add_unit` (`unit_val` VARCHAR(255))
RETURNS VARCHAR(10) DETERMINISTIC
BEGIN
    DECLARE lines_count_units INT DEFAULT 0;
    SET lines_count_units = (SELECT count(*) FROM units WHERE value = unit_val);
    IF (lines_count_units = 0)
    THEN
        INSERT INTO units
        SET
          value       = unit_val,
          created_at  = NOW(),
          updated_at  = NOW();
    END IF;

    RETURN (SELECT id FROM units WHERE value = unit_val LIMIT 1);
END
$$
DELIMITER ;


DROP PROCEDURE IF EXISTS `add_nomenclatura_unit`;
DELIMITER $$

CREATE PROCEDURE `add_nomenclatura_unit` (`nomenclatura_ext_id_val` VARCHAR(255), `unit_val` VARCHAR(255), `coefficient_val` FLOAT)
BEGIN
    DECLARE lines_count INT DEFAULT 0;
    DECLARE nomenclatura_id_val INT DEFAULT NULL;

    SET nomenclatura_id_val = (SELECT id FROM nomenclaturas WHERE ext_id = nomenclatura_ext_id_val);

    IF (nomenclatura_id_val IS NULL)
    THEN
        SIGNAL SQLSTATE 'ERR0R' SET MESSAGE_TEXT = 'Nomenclatura not found';
    END IF;

    SET lines_count = (SELECT count(*) FROM relation_nomenclaturas_units WHERE nomenclatura_id = nomenclatura_id_val AND unit_id = unit_id_val);
    IF (lines_count = 0)
    THEN
        INSERT INTO relation_nomenclaturas_units
        SET
          nomenclatura_id   = nomenclatura_id_val,
          unit_id           = add_unit(unit_id_val),
          coefficient       = coefficient_val,
          created_at        = NOW(),
          updated_at        = NOW();
    ELSE
        UPDATE relation_nomenclaturas_units
        SET
          coefficient           = coefficient_val,
          updated_at            = NOW()
        WHERE nomenclatura_id   = nomenclatura_id_val
            AND unit_id         = add_unit(unit_id_val);
    END IF;
END
$$
DELIMITER ;


DROP PROCEDURE IF EXISTS `remove_nomenclatura_unit`;
DELIMITER $$

CREATE PROCEDURE `remove_nomenclatura_unit` (`nomenclatura_ext_id_val` VARCHAR(255), `unit_val` VARCHAR(255))
BEGIN
    DECLARE unit_id_val INT DEFAULT NULL;
    DECLARE nomenclatura_id_val INT DEFAULT NULL;

    SET unit_id_val = (SELECT id FROM units WHERE value = unit_val);
    SET nomenclatura_id_val = (SELECT id FROM nomenclaturas WHERE ext_id = nomenclatura_ext_id_val);

    IF ((unit_id_val IS NOT NULL) AND (nomenclatura_id_val IS NOT NULL))
    THEN
        DELETE FROM relation_nomenclaturas_units
        WHERE nomenclatura_id   = nomenclatura_id_val
            AND unit_id         = unit_id_val;
    END IF;
END
$$
DELIMITER ;

-- call add_nomenclatura_unit ('nomencatura_ext_id_val', 'кг.', 0.5);
