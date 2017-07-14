DROP PROCEDURE IF EXISTS `add_nomenclatura_price_type`;
DELIMITER $$

CREATE PROCEDURE `add_nomenclatura_price_type` (
    `ext_id_val` VARCHAR(255),
    `name_val` VARCHAR(255),
    `currency_val` VARCHAR(255)
)
BEGIN
    DECLARE lines_count_currencies INT DEFAULT 0;
    DECLARE lines_count INT DEFAULT 0;
    DECLARE currency_id_val INT DEFAULT 0;

    IF (name_val = '')
    THEN
        SIGNAL SQLSTATE 'ERR0R' SET MESSAGE_TEXT = 'Field "name_val" can not be empty';
    END IF;
    IF (currency_val = '')
    THEN
        SIGNAL SQLSTATE 'ERR0R' SET MESSAGE_TEXT = 'Field "currency_val" can not be empty';
    END IF;

    SET lines_count_currencies = (SELECT count(*) FROM currencies WHERE name = currency_val);
    IF (lines_count_currencies = 0)
    THEN
        INSERT INTO currencies
        SET
          name        = currency_val,
          created_at  = NOW(),
          updated_at  = NOW();
    END IF;

    SET currency_id_val = (SELECT id FROM currencies WHERE name = currency_val LIMIT 1);

    SET lines_count = (SELECT count(*) FROM nomenclatura_price_types WHERE ext_id = ext_id_val);
    IF (lines_count = 0)
    THEN
        INSERT INTO nomenclatura_price_types
        SET
            currency_id       = currency_id_val,
            name              = name_val,
            ext_id            = ext_id_val,
            created_at        = NOW(),
            updated_at        = NOW();
    ELSE
        UPDATE nomenclatura_price_types
        SET
            currency_id       = currency_id_val,
            name              = name_val,
            updated_at        = NOW()
        WHERE ext_id          = ext_id_val;
    END IF;
END
$$
DELIMITER ;
