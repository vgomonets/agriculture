DROP PROCEDURE IF EXISTS `add_city`;
DELIMITER $$

CREATE PROCEDURE `add_city` (
    `ext_id_val` VARCHAR(255),
    `region_ext_id_val` VARCHAR(255),
    `name_val` VARCHAR(255)
)
BEGIN
    DECLARE lines_count INT DEFAULT 0;
    SET lines_count = (SELECT count(*) FROM cities WHERE ext_id = ext_id_val);
    IF (lines_count > 0)
    THEN
        UPDATE cities
        SET
            name            = name_val,
            region_id       = (SELECT id FROM regions WHERE ext_id = region_ext_id_val),
            updated_at      = NOW()
        WHERE ext_id        = ext_id_val;
    ELSE
        INSERT INTO cities
        SET
            name            = name_val,
            region_id       = (SELECT id FROM regions WHERE ext_id = region_ext_id_val),
            created_at      = NOW(),
            updated_at      = NOW(),
            ext_id          = ext_id_val;
    END IF;
END
$$
DELIMITER ;

-- call add_region('777', 'test region');
-- call add_city('181818', '777', 'test city');
-- call add_city('181818', '777', 'test city2);
