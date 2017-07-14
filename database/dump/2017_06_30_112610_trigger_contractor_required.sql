DROP TRIGGER IF EXISTS `after_insert_task_templates`;
DROP TRIGGER IF EXISTS `after_update_task_templates`;
DROP TRIGGER IF EXISTS `after_delete_task_templates`;
DELIMITER $$
CREATE TRIGGER `after_insert_task_templates` AFTER INSERT ON `task_templates`
FOR EACH ROW BEGIN
    UPDATE `task_groups` SET
        `contractor_required` = IF ((SELECT count(id) FROM `task_templates` WHERE group_id = NEW.`group_id` AND contractor_required = 1) > 0, 1, 0)
    WHERE id = NEW.`group_id`;
END
$$
CREATE TRIGGER `after_update_task_templates` AFTER UPDATE ON `task_templates`
FOR EACH ROW BEGIN
    UPDATE `task_groups` SET
        `contractor_required` = IF ((SELECT count(id) FROM `task_templates` WHERE group_id = OLD.`group_id` AND contractor_required = 1) > 0, 1, 0)
    WHERE id = OLD.`group_id`;
    UPDATE `task_groups` SET
        `contractor_required` = IF ((SELECT count(id) FROM `task_templates` WHERE group_id = NEW.`group_id` AND contractor_required = 1) > 0, 1, 0)
    WHERE id = NEW.`group_id`;
END
$$
CREATE TRIGGER `after_delete_task_templates` AFTER DELETE ON `task_templates`
FOR EACH ROW BEGIN
    UPDATE `task_groups` SET
        `contractor_required` = IF ((SELECT count(id) FROM `task_templates` WHERE group_id = OLD.`group_id` AND contractor_required = 1) > 0, 1, 0)
    WHERE id = OLD.`group_id`;
END
$$
DELIMITER ;