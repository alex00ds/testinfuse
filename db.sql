CREATE TABLE `track` ( 
    `ip_address` VARCHAR(15) NOT NULL, 
    `user_agent` VARCHAR(500) NOT NULL, 
    `page_url` VARCHAR(200) NOT NULL, 
    `view_date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, 
    `views_count` INT UNSIGNED NOT NULL DEFAULT '1', 
    PRIMARY KEY (`ip_address`, `user_agent`, `page_url`)
) ENGINE = InnoDB;