DROP PROCEDURE IF EXISTS `add_nomenclatura_price`;
DELIMITER $$

CREATE PROCEDURE `add_nomenclatura_price` (
    `nomenclatura_price_type_ext_id_val` VARCHAR(255),
    `nomenclatura_ext_id_val` VARCHAR(255),
    `unit_val` VARCHAR(255),
    `date_val` DATE,
    `price_val` FLOAT
)
BEGIN
    DECLARE lines_count INT DEFAULT 0;
    DECLARE nomenclatura_price_type_id_val INT DEFAULT NULL;
    DECLARE nomenclatura_id_val INT DEFAULT NULL;

    SET nomenclatura_price_type_id_val = (SELECT id FROM nomenclatura_price_types WHERE ext_id = nomenclatura_price_type_ext_id_val);
    SET nomenclatura_id_val = (SELECT id FROM nomenclaturas WHERE ext_id = nomenclatura_ext_id_val);

    IF (nomenclatura_price_type_id_val IS NULL)
    THEN
        SIGNAL SQLSTATE 'ERR0R' SET MESSAGE_TEXT = 'Nomenclatura price type not found';
    END IF;
    IF (nomenclatura_id_val IS NULL)
    THEN
        SIGNAL SQLSTATE 'ERR0R' SET MESSAGE_TEXT = 'Nomenclatura not found';
    END IF;
    IF (date_val = '')
    THEN
        SIGNAL SQLSTATE 'ERR0R' SET MESSAGE_TEXT = 'Field "date_val" can not be empty';
    END IF;
    IF (price_val = '' || price_val = 0)
    THEN
        SIGNAL SQLSTATE 'ERR0R' SET MESSAGE_TEXT = 'Field "price_val" can not be empty';
    END IF;

    INSERT INTO nomenclatura_prices
    SET
        nomenclatura_price_type_id  = nomenclatura_price_type_id_val,
        nomenclatura_id             = nomenclatura_id_val,
        unit_id                     = add_unit(unit_val),
        `date`                      = date_val,
        `price`                     = price_val,
        created_at                  = NOW(),
        updated_at                  = NOW();

END
$$
DELIMITER ;

-- call add_nomenclatura_price('nomenclatura_price_type_ext_id_val', 'nomenclatura_ext_id_val', 'кг.', '2017-01-02', 0.5);
