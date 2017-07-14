DROP PROCEDURE IF EXISTS `add_contractor_contact_user`;
DELIMITER $$

CREATE PROCEDURE `add_contractor_contact_user` (
    `ext_id_val` VARCHAR(255),
    `contractor_ext_id_val` VARCHAR(255),
    `role_ext_id_val` VARCHAR(255),
    `type_val` VARCHAR(255),
    `phone_val` VARCHAR(255),
    `phone2_val` VARCHAR(255),
    `email_val` VARCHAR(255),
    `address_val` VARCHAR(255),
    `position_val` VARCHAR(255)
)
BEGIN
    DECLARE lines_count INT DEFAULT 0;
    DECLARE contractor_id_val INT DEFAULT NULL;
    DECLARE contractor_user_role_id_val INT DEFAULT NULL;

    SET contractor_id_val = (SELECT id FROM contractors WHERE ext_id = contractor_ext_id_val);
    IF (contractor_id_val IS NULL)
    THEN
        SET contractor_id_val = (SELECT id FROM companies WHERE ext_id = contractor_ext_id_val);
    END IF;
    IF (contractor_id_val IS NULL)
    THEN
        SIGNAL SQLSTATE 'ERR0R' SET MESSAGE_TEXT = 'Contractor not found';
    END IF;

    SET contractor_user_role_id_val = (SELECT id FROM contractor_contact_user_roles WHERE ext_id = role_ext_id_val);
    IF (contractor_user_role_id_val IS NULL)
    THEN
        SIGNAL SQLSTATE 'ERR0R' SET MESSAGE_TEXT = 'Contractor user role not found';
    END IF;

    SET lines_count = (SELECT count(*) FROM contractor_contact_users WHERE ext_id = ext_id_val);
    IF (lines_count > 0)
    THEN
        UPDATE contractor_contact_users
        SET
            contractor_id               = contractor_id_val,
            role_id                     = contractor_user_role_id_val,
            type                        = type_val,
            phone                       = phone_val,
            phone2                      = phone2_val,
            email                       = email_val,
            address                     = address_val,
            position                    = position_val,
            updated_at                  = NOW()
        WHERE ext_id                    = ext_id_val;
    ELSE
        INSERT INTO contractor_contact_users
        SET
            contractor_id               = contractor_id_val,
            role_id                     = contractor_user_role_id_val,
            type                        = type_val,
            phone                       = phone_val,
            phone2                      = phone2_val,
            email                       = email_val,
            address                     = address_val,
            position                    = position_val,
            created_at                  = NOW(),
            updated_at                  = NOW(),
            ext_id                      = ext_id_val;
    END IF;
END
$$
DELIMITER ;

call add_contractor_contact_user(
    'ext_id_val', -- ext_id_val
    'contractor_ext_id_val', -- contractor_ext_id_val
    'role_ext_id_val', -- role_ext_id_val
    'worker', -- type_val
    'phone_val', -- phone_val
    'phone2_val', -- phone2_val
    'email_val', -- email_val
    'address_val', -- address_val
    'position_val' -- position_val
);
