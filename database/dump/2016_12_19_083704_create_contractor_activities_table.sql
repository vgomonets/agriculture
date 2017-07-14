DROP PROCEDURE IF EXISTS `add_contractor_activity`;


DROP FUNCTION IF EXISTS `add_contractor_activity`;
DELIMITER $$

CREATE FUNCTION `add_contractor_activity` (`name_val` VARCHAR(255))
RETURNS VARCHAR(10) DETERMINISTIC
BEGIN
    DECLARE lines_count INT DEFAULT 0;
    SET lines_count = (SELECT count(*) FROM contractor_activities WHERE name = name_val);
    IF (lines_count = 0)
    THEN
        INSERT INTO contractor_activities
        SET
          name       = name_val,
          created_at  = NOW(),
          updated_at  = NOW();
    END IF;

    RETURN (SELECT id FROM contractor_activities WHERE name = name_val LIMIT 1);
END
$$
DELIMITER ;


DROP PROCEDURE IF EXISTS `add_activity_to_contractor`;
DELIMITER $$

CREATE PROCEDURE `add_activity_to_contractor` (
    `contractor_ext_id_val` VARCHAR(255),
    `activity_val` VARCHAR(255)
)
BEGIN
    DECLARE lines_count INT DEFAULT 0;
    DECLARE contractor_id_val INT DEFAULT NULL;
    DECLARE activity_id_val INT DEFAULT NULL;

    SET contractor_id_val = (SELECT id FROM contractors WHERE ext_id = contractor_ext_id_val);
    SET activity_id_val = (SELECT add_contractor_activity(activity_val));

    IF (contractor_id_val IS NULL)
    THEN
        SIGNAL SQLSTATE 'ERR0R' SET MESSAGE_TEXT = 'Contractor not found';
    END IF;

    SET lines_count = (SELECT count(*) FROM relation_contractors_activities WHERE contractor_id = contractor_id_val AND contractor_activity_id = activity_id_val);
    IF (lines_count = 0)
    THEN
        INSERT INTO relation_contractors_activities
        SET
          contractor_id             = contractor_id_val,
          contractor_activity_id    = activity_id_val,
          created_at                = NOW(),
          updated_at                = NOW();
    ELSE
        UPDATE relation_contractors_activities
        SET
          updated_at                    = NOW()
        WHERE contractor_id             = contractor_id_val
            AND contractor_activity_id  = activity_id_val;
    END IF;
END
$$
DELIMITER ;


-- SELECT add_contractor_activity('test contractor activity');
-- call add_contractor_activity('888', 'test contractor activity2');
