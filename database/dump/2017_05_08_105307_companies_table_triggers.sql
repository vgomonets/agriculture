DROP TRIGGER IF EXISTS `before_update_companies`;
DROP TRIGGER IF EXISTS `before_delete_companies`;
DELIMITER $$
CREATE TRIGGER `before_update_companies` BEFORE UPDATE ON `companies`
FOR EACH ROW BEGIN
    INSERT `companies_histories` (
        `old_id`,
        `ext_id`,
        `is_buyer`,
        `is_supplier`,
        `is_not_residend`,
        `contractor_group_id`,
        `contractor_activity_id`,
        `name`,
        `full_name`,
        `inn`,
        `code_egrpou`,
        `number_vat`,
        `city_id`,
        `user_id`,
        `created_at`,
        `updated_at`,
        `deleted_at`,
        `square`
    ) VALUES (
        OLD.`id`,
        OLD.`ext_id`,
        OLD.`is_buyer`,
        OLD.`is_supplier`,
        OLD.`is_not_residend`,
        OLD.`contractor_group_id`,
        OLD.`contractor_activity_id`,
        OLD.`name`,
        OLD.`full_name`,
        OLD.`inn`,
        OLD.`code_egrpou`,
        OLD.`number_vat`,
        OLD.`city_id`,
        OLD.`user_id`,
        OLD.`created_at`,
        OLD.`updated_at`,
        OLD.`deleted_at`,
        OLD.`square`
    );
END
$$
CREATE TRIGGER `before_delete_companies` BEFORE DELETE ON `companies`
FOR EACH ROW BEGIN
    INSERT `companies_histories` (
        `old_id`,
        `ext_id`,
        `is_buyer`,
        `is_supplier`,
        `is_not_residend`,
        `contractor_group_id`,
        `contractor_activity_id`,
        `name`,
        `full_name`,
        `inn`,
        `code_egrpou`,
        `number_vat`,
        `city_id`,
        `user_id`,
        `created_at`,
        `updated_at`,
        `deleted_at`,
        `square`
    ) VALUES (
        OLD.`id`,
        OLD.`ext_id`,
        OLD.`is_buyer`,
        OLD.`is_supplier`,
        OLD.`is_not_residend`,
        OLD.`contractor_group_id`,
        OLD.`contractor_activity_id`,
        OLD.`name`,
        OLD.`full_name`,
        OLD.`inn`,
        OLD.`code_egrpou`,
        OLD.`number_vat`,
        OLD.`city_id`,
        OLD.`user_id`,
        OLD.`created_at`,
        OLD.`updated_at`,
        OLD.`deleted_at`,
        OLD.`square`
    );
END
$$
DELIMITER ;