DROP PROCEDURE IF EXISTS `add_contractor_contact_user_role`;
DELIMITER $$

CREATE PROCEDURE `add_contractor_contact_user_role` (
    `ext_id_val` VARCHAR(255),
    `name_val` VARCHAR(255)
)
BEGIN
    DECLARE lines_count INT DEFAULT 0;
    SET lines_count = (SELECT count(*) FROM contractor_contact_user_roles WHERE ext_id = ext_id_val);
    IF (lines_count > 0)
    THEN
      UPDATE contractor_contact_user_roles
      SET
        name        = name_val,
        updated_at  = NOW()
      WHERE ext_id = ext_id_val;
    ELSE
      INSERT INTO contractor_contact_user_roles
      SET
        name        = name_val,
        created_at  = NOW(),
        updated_at  = NOW(),
        ext_id = ext_id_val;
    END IF;
END
$$
DELIMITER ;

-- call add_contractor_contact_user_role('121212', 'test contractor contact user role');
-- call add_contractor_contact_user_role('121212', 'test contractor contact user role2');
