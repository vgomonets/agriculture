DROP PROCEDURE IF EXISTS `add_relation_user_contractor`;
DELIMITER $$

CREATE PROCEDURE `add_relation_user_contractor` (
    `user_ext_id_val` VARCHAR(255),
    `contractor_ext_id_val` VARCHAR(255)
)
BEGIN
    DECLARE user_id_val INT DEFAULT NULL;
    DECLARE contractor_id_val INT DEFAULT NULL;
    DECLARE company_id_val INT DEFAULT NULL;
    DECLARE contractor_relation_exists INT DEFAULT 0;
    DECLARE company_relation_exists INT DEFAULT 0;

    SET user_id_val = (SELECT id FROM users WHERE ext_id = user_ext_id_val);
    SET contractor_id_val = (SELECT id FROM contractors WHERE ext_id = contractor_ext_id_val);
    SET company_id_val = (SELECT id FROM companies WHERE ext_id = contractor_ext_id_val);

    IF (user_id_val IS NULL)
    THEN
        SIGNAL SQLSTATE 'ERR0R' SET MESSAGE_TEXT = 'User not found';
    END IF;
    IF (contractor_id_val IS NULL AND company_id_val IS NULL)
    THEN
        SIGNAL SQLSTATE 'ERR0R' SET MESSAGE_TEXT = 'Contractor not found';
    END IF;

    SET contractor_relation_exists = (SELECT count(*) FROM relation_user_contractors WHERE user_id = user_id_val AND contractor_id = contractor_id_val);
    SET company_relation_exists = (SELECT count(*) FROM relation_user_companies WHERE user_id = user_id_val AND company_id = company_id_val);

    IF (contractor_id_val IS NOT NULL AND contractor_relation_exists = 0)
    THEN
        
        INSERT INTO relation_user_contractors
        SET
            user_id           = user_id_val,
            contractor_id     = contractor_id_val,
            created_at        = NOW(),
            updated_at        = NOW();
    END IF;        
    IF (company_id_val IS NOT NULL AND company_relation_exists = 0)
    THEN
        
        INSERT INTO relation_user_companies
        SET
            user_id           = user_id_val,
            company_id        = company_id_val,
            created_at        = NOW(),
            updated_at        = NOW();
    END IF;
END
$$
DELIMITER ;


DROP PROCEDURE IF EXISTS `remove_relation_user_contractor`;
DELIMITER $$

CREATE PROCEDURE `remove_relation_user_contractor` (
    `user_ext_id_val` VARCHAR(255),
    `contractor_ext_id_val` VARCHAR(255)
)
BEGIN
    DECLARE user_id_val INT DEFAULT NULL;
    DECLARE contractor_id_val INT DEFAULT NULL;
    DECLARE company_id_val INT DEFAULT NULL;
    DECLARE contractor_relation_exists INT DEFAULT 0;
    DECLARE company_relation_exists INT DEFAULT 0;

    SET user_id_val = (SELECT id FROM users WHERE ext_id = user_ext_id_val);
    SET contractor_id_val = (SELECT id FROM contractors WHERE ext_id = contractor_ext_id_val);
    SET company_id_val = (SELECT id FROM companies WHERE ext_id = contractor_ext_id_val);

    IF (user_id_val IS NULL)
    THEN
        SIGNAL SQLSTATE 'ERR0R' SET MESSAGE_TEXT = 'User not found';
    END IF;
    IF (contractor_id_val IS NULL AND company_id_val IS NULL)
    THEN
        SIGNAL SQLSTATE 'ERR0R' SET MESSAGE_TEXT = 'Contractor not found';
    END IF;

    SET contractor_relation_exists = (SELECT count(*) FROM relation_user_contractors WHERE user_id = user_id_val AND contractor_id = contractor_id_val);
    SET company_relation_exists = (SELECT count(*) FROM relation_user_companies WHERE user_id = user_id_val AND company_id = company_id_val);

    IF (contractor_id_val IS NOT NULL AND contractor_relation_exists != 0)
    THEN
        DELETE FROM relation_user_contractors
        WHERE
            user_id             = user_id_val
            AND contractor_id   = contractor_id_val;
    END IF;        
    IF (company_id_val IS NOT NULL AND company_relation_exists != 0)
    THEN
        DELETE FROM relation_user_companies
        WHERE
            user_id             = user_id_val
            AND company_id      = company_id_val;
    END IF;
END
$$
DELIMITER ;




-- call add_relation_user_contractor('bc61ff73-1a74-11e5-80d7-0cc47a49b635', 'd20aad7f-215b-11e5-80da-0cc47a49b635');
-- call add_relation_user_contractor('bc61ff73-1a74-11e5-80d7-0cc47a49b635', 'fd7eac9f-3b79-11e5-80dc-0cc47a49b635');