DROP PROCEDURE IF EXISTS `add_contractors`;
DELIMITER $$

CREATE PROCEDURE `add_contractors` (
    `ext_id_val` VARCHAR(255),
    `user_ext_id_val` VARCHAR(255),
    `type_val` VARCHAR(255),
    `is_buyer_val` INTEGER(2),
    `is_supplier_val` INTEGER(2),
    `is_not_residend_val` INTEGER(2),
    `contractor_group_id_val` VARCHAR(255),
    `name_val` VARCHAR(255),
    `full_name_val` VARCHAR(255),
    `inn_val` VARCHAR(255),
    `code_egrpou_val` VARCHAR(255),
    `number_vat_val` VARCHAR(255),
    `city_id_val` VARCHAR(255)
)
BEGIN
    DECLARE lines_count INT DEFAULT 0;
    DECLARE contractor_group_id_v INT DEFAULT 0;
    DECLARE city_id_v INT DEFAULT NULL;
    DECLARE contractor_activity_id_v INT DEFAULT NULL;
    DECLARE user_id_v INT DEFAULT NULL;

    IF (contractor_group_id_val != '' AND contractor_group_id_val != 0 AND contractor_group_id_val IS NOT NULL)
    THEN
        SET contractor_group_id_v  = (SELECT id FROM contractor_groups WHERE ext_id = contractor_group_id_val LIMIT 1);
    END IF;

    -- IF (user_ext_id_val != '' AND user_ext_id_val != 0 AND user_ext_id_val IS NOT NULL)
    -- THEN
        SET user_id_v  = (SELECT id FROM users WHERE ext_id = user_ext_id_val LIMIT 1);
    -- END IF;

    SET city_id_v  = (SELECT id FROM cities WHERE ext_id = city_id_val);

    IF (type_val != 'Физ. лицо' AND type_val != 'Юр. лицо')
    THEN
        SIGNAL SQLSTATE 'ERR0R' SET MESSAGE_TEXT = 'Invalid type type_val';
    END IF;

    IF (type_val = 'Физ. лицо')
    THEN

        SET lines_count = (SELECT count(*) FROM contractors WHERE ext_id = ext_id_val);
        IF (lines_count > 0)
        THEN
            UPDATE contractors
            SET
                `is_buyer`                = is_buyer_val,
                `is_supplier`             = is_supplier_val,
                `is_not_residend`         = is_not_residend_val,
                `contractor_group_id`     = contractor_group_id_v,
                `name`                    = name_val,
                `full_name`               = full_name_val,
                `inn`                     = inn_val,
                `code_egrpou`             = code_egrpou_val,
                `number_vat`              = number_vat_val,
                `city_id`                 = city_id_v,
                `user_id`                 = user_id_v,
                `updated_at`              = NOW()
            WHERE ext_id                  = ext_id_val;
        ELSE
            INSERT INTO contractors
            SET
                `is_buyer`                = is_buyer_val,
                `is_supplier`             = is_supplier_val,
                `is_not_residend`         = is_not_residend_val,
                `contractor_group_id`     = contractor_group_id_v,
                `name`                    = name_val,
                `full_name`               = full_name_val,
                `inn`                     = inn_val,
                `code_egrpou`             = code_egrpou_val,
                `number_vat`              = number_vat_val,
                `city_id`                 = city_id_v,
                `user_id`                 = user_id_v,
                `created_at`              = NOW(),
                `updated_at`              = NOW(),
                `ext_id`                  = ext_id_val;
        END IF;

    ELSEIF(type_val = 'Юр. лицо')
    THEN

        SET lines_count = (SELECT count(*) FROM companies WHERE ext_id = ext_id_val);
        IF (lines_count > 0)
        THEN
            UPDATE companies
            SET
                `is_buyer`                = is_buyer_val,
                `is_supplier`             = is_supplier_val,
                `is_not_residend`         = is_not_residend_val,
                `contractor_group_id`     = contractor_group_id_v,
                `name`                    = name_val,
                `full_name`               = full_name_val,
                `inn`                     = inn_val,
                `code_egrpou`             = code_egrpou_val,
                `number_vat`              = number_vat_val,
                `city_id`                 = city_id_v,
                `user_id`                 = user_id_v,
                `updated_at`              = NOW()
            WHERE ext_id                  = ext_id_val;
        ELSE
            INSERT INTO companies
            SET
                `is_buyer`                = is_buyer_val,
                `is_supplier`             = is_supplier_val,
                `is_not_residend`         = is_not_residend_val,
                `contractor_group_id`     = contractor_group_id_v,
                `name`                    = name_val,
                `full_name`               = full_name_val,
                `inn`                     = inn_val,
                `code_egrpou`             = code_egrpou_val,
                `number_vat`              = number_vat_val,
                `city_id`                 = city_id_v,
                `user_id`                 = user_id_v,
                `created_at`              = NOW(),
                `updated_at`              = NOW(),
                `ext_id`                  = ext_id_val;
        END IF;

    END IF;
END
$$
DELIMITER ;

-- call add_contractors ('11122', 'test_user_id', 'Юр. лицо', 1, 1, 1, 'c14d17b7-ab7b-11e4-9394-001e6711e0dd', 'test name2', 'test full name', '112233', '445566', '778899', '');
