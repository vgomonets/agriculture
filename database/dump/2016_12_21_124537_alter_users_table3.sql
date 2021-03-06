DROP PROCEDURE IF EXISTS `add_user`;
DELIMITER $$

CREATE PROCEDURE `add_user` (
    `ext_id_val` VARCHAR(255),
    `name_val` VARCHAR(255),
    `full_name_val` VARCHAR(255),
    `email_val` VARCHAR(255),
    `phone_val` VARCHAR(255)
)
BEGIN
    DECLARE lines_count INT DEFAULT 0;
    SET lines_count = (SELECT count(*) FROM users WHERE ext_id = ext_id_val);
    IF (lines_count > 0)
    THEN
        UPDATE users
        SET
            role_id         = 4, -- менеджер
            name            = name_val,
            full_name       = full_name_val,
            new_email       = email_val,
            phone           = phone_val,
            updated_at      = NOW()
        WHERE ext_id        = ext_id_val;
    ELSE
        INSERT INTO users
        SET
            role_id         = 4, -- менеджер
            name            = name_val,
            full_name       = full_name_val,
            new_email       = email_val,
            phone           = phone_val,
            created_at      = NOW(),
            updated_at      = NOW(),
            ext_id          = ext_id_val;
    END IF;
END
$$
DELIMITER ;

-- call add_individual('161616', 'test individual');
-- call add_user_group('171717', 'test user group');
-- call add_user('999', 1, '161616', '171717', 'test user name', 'test user full name', 'test user email', 'test user phone');
-- call add_user('999', 1, '161616', '171717', 'test user name2', 'test user full name2', 'test user email2', 'test user phone2');
