
-- DROP PROCEDURE IF EXISTS `add_contractor_contact`;
-- DELIMITER $$
--
-- CREATE PROCEDURE `add_contractor_contact` (
--     `ext_id_val` VARCHAR(255),
--     `contractor_ext_id_val` VARCHAR(255),
--     `delivery_addr_val` VARCHAR(255),
--     `legal_addr_val` VARCHAR(255),
--     `actual_addr_val` VARCHAR(255),
--     `phone_val` VARCHAR(255),
--     `fax_val` VARCHAR(255),
--     `email_val` VARCHAR(255)
-- )
-- BEGIN
--     DECLARE lines_count INT DEFAULT 0;
--     DECLARE contractor_id_val INT DEFAULT NULL;
--
--     SET contractor_id_val = (SELECT id FROM contractors WHERE ext_id = contractor_ext_id_val);
--     IF (contractor_id_val IS NULL)
--     THEN
--         SIGNAL SQLSTATE 'ERR0R' SET MESSAGE_TEXT = 'Contractor not found';
--     END IF;
--
--     SET lines_count = (SELECT count(*) FROM contractor_contacts WHERE ext_id = ext_id_val);
--     IF (lines_count > 0)
--     THEN
--         UPDATE contractor_contacts
--         SET
--             contractor_id           = contractor_id_val,
--             delivery_addr           = delivery_addr_val,
--             legal_addr              = legal_addr_val,
--             actual_addr             = actual_addr_val,
--             phone                   = phone_val,
--             fax                     = fax_val,
--             email                   = email_val,
--             updated_at              = NOW()
--       WHERE ext_id                  = ext_id_val;
--     ELSE
--         INSERT INTO contractor_contacts
--         SET
--             contractor_id           = contractor_id_val,
--             delivery_addr           = delivery_addr_val,
--             legal_addr              = legal_addr_val,
--             actual_addr             = actual_addr_val,
--             phone                   = phone_val,
--             fax                     = fax_val,
--             email                   = email_val,
--             created_at              = NOW(),
--             updated_at              = NOW(),
--             ext_id                  = ext_id_val;
--     END IF;
-- END
-- $$
-- DELIMITER ;

-- call add_contractor_group('666', 'test contractor group');
-- call add_region('777', 'test region');
-- call add_contractor_activity('888', 'test contractor activity');
-- call add_user('999', 1, 'test user name', 'test user email', 'test user phone');
-- call add_contractors('101010', '2016-01-01', 'Юр. лицо', 0, 0, 0, '666', 'contractor test name', 'contractor test full name', 'test inn', 'test code', 'test vat', '777', '888', '999');
-- call add_contractor_contact('111111', '101010', 'test delivery address', 'test legal address', 'test actual address', 'test phone', 'test fax', 'test mail');
-- call add_contractor_contact('111111', '101010', 'test delivery address2', 'test legal address2', 'test actual address2', 'test phone2', 'test fax2', 'test mail2');
