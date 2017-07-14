DROP TRIGGER IF EXISTS `after_insert_task`;
DROP TRIGGER IF EXISTS `after_update_task`;
DROP TRIGGER IF EXISTS `after_delete_task`;
DELIMITER $$
CREATE TRIGGER `after_insert_task` AFTER INSERT ON `tasks`
FOR EACH ROW BEGIN
    UPDATE `task_groups` SET
        `tasks_count` =  (SELECT count(id) FROM `tasks` WHERE group_id = NEW.`group_id`)
    WHERE id = NEW.`group_id`;
END
$$
CREATE TRIGGER `after_update_task` AFTER UPDATE ON `tasks`
FOR EACH ROW BEGIN
    UPDATE `task_groups` SET
        `tasks_count` =  (SELECT count(id) FROM `tasks` WHERE group_id = OLD.`group_id`)
    WHERE id = OLD.`group_id`;
    UPDATE `task_groups` SET
        `tasks_count` =  (SELECT count(id) FROM `tasks` WHERE group_id = NEW.`group_id`)
    WHERE id = NEW.`group_id`;
END
$$
CREATE TRIGGER `after_delete_task` AFTER DELETE ON `tasks`
FOR EACH ROW BEGIN
    UPDATE `task_groups` SET
        `tasks_count` =  (SELECT count(id) FROM `tasks` WHERE group_id = OLD.`group_id`)
    WHERE id = OLD.`group_id`;
END
$$
DELIMITER ;


DROP TRIGGER IF EXISTS `after_insert_task_template`;
DROP TRIGGER IF EXISTS `after_update_task_template`;
DROP TRIGGER IF EXISTS `after_delete_task_template`;
DELIMITER $$
CREATE TRIGGER `after_insert_task_template` AFTER INSERT ON `task_templates`
FOR EACH ROW BEGIN
    UPDATE `task_groups` SET contractor_required =
            IF ((SELECT count(id) FROM `task_templates` WHERE group_id = NEW.`group_id` AND contractor_required = 1) > 0, 1, 0)
    WHERE id = NEW.`group_id`;
END
$$
CREATE TRIGGER `after_update_task_template` AFTER UPDATE ON `task_templates`
FOR EACH ROW BEGIN
    UPDATE `task_groups` SET contractor_required =
            IF ((SELECT count(id) FROM `task_templates` WHERE group_id = OLD.`group_id` AND contractor_required = 1) > 0, 1, 0)
    WHERE id = OLD.`group_id`;
    UPDATE `task_groups` SET contractor_required =
            IF ((SELECT count(id) FROM `task_templates` WHERE group_id = NEW.`group_id` AND contractor_required = 1) > 0, 1, 0)
    WHERE id = NEW.`group_id`;
END
$$
CREATE TRIGGER `after_delete_task_template` AFTER DELETE ON `task_templates`
FOR EACH ROW BEGIN
    UPDATE `task_groups` SET contractor_required =
            IF ((SELECT count(id) FROM `task_templates` WHERE group_id = OLD.`group_id` AND contractor_required = 1) > 0, 1, 0)
    WHERE id = OLD.`group_id`;
END
$$
DELIMITER ;
