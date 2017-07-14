DROP PROCEDURE IF EXISTS `add_address`;
DELIMITER $$

CREATE PROCEDURE `add_address` (
    `ext_id_val` VARCHAR(255),
    `user_id_val` VARCHAR(255),
    `zip_code_val` VARCHAR(255),
    `region_id_val` VARCHAR(255),
    `city_id_val` VARCHAR(255),
    `district_val` VARCHAR(255),
    `locality_val` VARCHAR(255),
    `street_val` VARCHAR(255),
    `house_val` VARCHAR(255),
    `housing_val` VARCHAR(255),
    `flat_val` VARCHAR(255)
)
BEGIN
    DECLARE lines_count INT DEFAULT 0;
    SET lines_count = (SELECT count(*) FROM addresses WHERE ext_id = ext_id_val);
    IF (lines_count > 0)
    THEN
        UPDATE addresses
        SET
            user_id         = (SELECT id FROM users WHERE ext_id = user_id_val),
            zip_code           = zip_code_val,
            region_id       = (SELECT id FROM regions WHERE ext_id = region_id_val),
            city_id         = (SELECT id FROM cities WHERE ext_id = city_id_val),
            district        = district_val,
            locality        = locality_val,
            street          = street_val,
            house           = house_val,
            housing         = housing_val,
            flat            = flat_val,
            updated_at      = NOW()
      WHERE ext_id          = ext_id_val;
    ELSE
        INSERT INTO addresses
        SET
            user_id         = (SELECT id FROM users WHERE ext_id = user_id_val),
            zip_code           = zip_code_val,
            region_id       = (SELECT id FROM regions WHERE ext_id = region_id_val),
            city_id         = (SELECT id FROM cities WHERE ext_id = city_id_val),
            district        = district_val,
            locality        = locality_val,
            street          = street_val,
            house           = house_val,
            housing         = housing_val,
            flat            = flat_val,
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
-- call add_region('777', 'test region');
-- call add_city('181818', '777', 'test city');
-- call add_address('191919', '999', 'test zip code', '777', '181818', 'test district', 'test locality', 'test street', 'test house', 'test housing', 'test flat');
-- call add_address('191919', '999', 'test zip code2', '777', '181818', 'test district2', 'test locality2', 'test street2', 'test house2', 'test housing2', 'test flat2');
