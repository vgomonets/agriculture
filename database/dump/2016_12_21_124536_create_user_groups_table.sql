DROP PROCEDURE IF EXISTS `add_user_group`;
DELIMITER $$

CREATE PROCEDURE `add_user_group` (`ext_id_val` VARCHAR(255), `name_val` VARCHAR(255))
BEGIN
    DECLARE lines_count INT DEFAULT 0;
    SET lines_count = (SELECT count(*) FROM user_groups WHERE ext_id = ext_id_val);
    IF (lines_count > 0)
    THEN
      UPDATE user_groups
      SET
        name        = name_val,
        updated_at  = NOW()
      WHERE ext_id = ext_id_val;
    ELSE
      INSERT INTO user_groups
      SET
        name        = name_val,
        created_at  = NOW(),
        updated_at  = NOW(),
        ext_id = ext_id_val;
    END IF;
END
$$
DELIMITER ;

-- call add_user_group('171717', 'test user group');
-- call add_user_group('171717', 'test user group2');
